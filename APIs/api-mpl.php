<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type, X-API-KEY');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

    require_once(__DIR__ .  '/../db_connect.php');
    require_once(__DIR__ .  '/../library/auth.php');

    $env_file = __DIR__ . '/../.env.php';
    $env = file_exists($env_file) ? require $env_file : [];

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }

    check_api_key($env);

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        // Fetch all shipping records with related inventory info
        $sql = "SELECT 
                    mplship.id,
                    mplship.item_id,
                    mplship.reference_numb,
                    mplship.ship_date,
                    mplship.trailer_name,
                    mplship.status,
                    iii.unit_numb,
                    iii.ficha,
                    iii.description1,
                    iii.description2,
                    iii.quantity,
                    iii.quantity_unit,
                    iii.footage_quantity
                FROM mpl_shipping_list mplship
                INNER JOIN inventory_item_info iii ON mplship.item_id = iii.inventory_id
                ORDER BY mplship.ship_date DESC";

        $results = mysqli_query($connection, $sql);

        if (!$results) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Database query error: ' . mysqli_error($connection)]);
            exit;
        }

        $data = mysqli_fetch_all($results, MYSQLI_ASSOC);

        echo json_encode($data);

    } elseif ($method === 'POST') {
        $raw_input = file_get_contents('php://input');
        $json_input = json_decode($raw_input, true);
        $input = is_array($json_input) ? $json_input : $_POST;

        $update_id = isset($input['id']) ? intval($input['id']) : 0;
        $requested_status = strtolower(trim($input['status'] ?? ''));

        if ($update_id > 0 && in_array($requested_status, ['pending', 'accepted'])) {
            $stmt = $connection->prepare("UPDATE mpl_shipping_list SET status=? WHERE id=?");
            $stmt->bind_param("si", $requested_status, $update_id);

            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'MPL status updated',
                    'id' => $update_id,
                    'status' => $requested_status
                ]);
                $stmt->close();
                exit;
            }

            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to update status: ' . $stmt->error]);
            $stmt->close();
            exit;
        }

        $reference_numb = isset($input['reference_number'])
            ? intval($input['reference_number'])
            : (isset($input['reference_numb']) ? intval($input['reference_numb']) : (isset($input['reference']) ? intval($input['reference']) : 0));
        $ship_date = $input['ship_date'] ?? ($input['date'] ?? '');
        $trailer_name = $input['trailer_name'] ?? ($input['truck'] ?? '');
        $status = $input['status'] ?? 'pending';
        $selected_items = (isset($input['selected_items']) && is_array($input['selected_items'])) ? $input['selected_items'] : [];

        if ($reference_numb <= 0 || $ship_date === '' || $trailer_name === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing required fields: reference_number/reference_numb/reference, ship_date/date, trailer_name/truck']);
            exit;
        }

        try {
            $stmt = $connection->prepare("INSERT INTO mpl_shipping_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, ?)");

            if (!$stmt) {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'Failed to prepare insert statement']);
                exit;
            }

            $created_ids = [];

            if (count($selected_items) > 0) {
                foreach ($selected_items as $shipID) {
                    $item_id = intval($shipID);

                    if ($item_id <= 0) {
                        continue;
                    }

                    $stmt->bind_param("iisss", $item_id, $reference_numb, $ship_date, $trailer_name, $status);

                    if (!$stmt->execute()) {
                        http_response_code(500);
                        echo json_encode(['success' => false, 'error' => 'Failed to insert record: ' . $stmt->error]);
                        $stmt->close();
                        exit;
                    }

                    $created_ids[] = $connection->insert_id;
                }
            } else {
                $item_id = isset($input['item_id']) ? intval($input['item_id']) : 0;

                if ($item_id <= 0) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'error' => 'Missing required field: item_id or selected_items']);
                    $stmt->close();
                    exit;
                }

                $stmt->bind_param("iisss", $item_id, $reference_numb, $ship_date, $trailer_name, $status);

                if (!$stmt->execute()) {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'error' => 'Failed to insert record: ' . $stmt->error]);
                    $stmt->close();
                    exit;
                }

                $created_ids[] = $connection->insert_id;
            }

            $stmt->close();

            if (count($created_ids) === 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'No valid item IDs were provided']);
                exit;
            }

            echo json_encode([
                'success' => true,
                'message' => 'Shipping record(s) created',
                'count' => count($created_ids),
                'ids' => $created_ids
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
            exit;
        }

    } else {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    }
?>