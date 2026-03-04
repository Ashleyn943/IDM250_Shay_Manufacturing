<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    require_once('../db_connect.php');
    require_once('../library/auth.php');

    $env_file = __DIR__ . '/../.env.php';
    $env = file_exists($env_file) ? require $env_file : [];

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
                    iii.description_1,
                    iii.description_2,
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

        echo json_encode([
            'success' => true,
            'count' => count($data),
            'data' => $data
        ]);

    } elseif ($method === 'POST') {
        // Create new shipping record
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['item_id']) || !isset($input['reference_number']) || !isset($input['ship_date']) || !isset($input['trailer_name'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing required fields: item_id, reference_number, ship_date, trailer_name']);
            exit;
        }

        $item_id = intval($input['item_id']);
        $reference_numb = intval($input['reference_number']);
        $ship_date = $connection->real_escape_string($input['ship_date']);
        $trailer_name = $connection->real_escape_string($input['trailer_name']);
        $status = $connection->real_escape_string($input['status'] ?? 'Pending');

        $sql = "INSERT INTO mpl_shipping_list (item_id, reference_numb, ship_date, trailer_name, status) 
                VALUES ($item_id, $reference_numb, '$ship_date', '$trailer_name', '$status')";

        if (mysqli_query($connection, $sql)) {
            $new_id = $connection->insert_id;
            echo json_encode([
                'success' => true,
                'message' => 'Shipping record created',
                'id' => $new_id
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to insert record: ' . mysqli_error($connection)]);
        }

    } else {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    }
?>
