<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    require_once(__DIR__ .  '/../db_connect.php');
    require_once(__DIR__ .  '/../library/auth.php');

    check_api_key($env);

    $url = 'https://digmstudents.westphal.drexel.edu/~ckl49/idm250-csquaredwms/api/orders.php';
    $api_key = getenv('API_KEY');
    $method = $_SERVER['REQUEST_METHOD'];


    if($method === 'GET'){
        $sql =  "SELECT 
                    ol.*, 
                    iii.*, 
                    pt.uom_primary 
                    FROM order_list ol 
                    INNER JOIN inventory_item_info iii ON ol.item_id = iii.inventory_id 
                    INNER JOIN products_types pt ON iii.ficha = pt.ficha 
                    WHERE ol.status='pending'";
        $result = mysqli_query($connection, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $encoded_data = json_encode($data);
            if(!$result){
                http_response_code(500);
                echo json_encode(['error' => 'Internal Server Error']);
            } else {
                echo $encoded_data;
            }
    } elseif ($method === 'POST'){
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
            $address = $input['address'] ?? '';
            $zip_code = $input['zip_code'] ?? '';
            $city = $input['city'] ?? '';
            $state = $input['state'] ?? '';
            $status = $input['status'] ?? 'pending';
            $selected_items = (isset($input['selected_items']) && is_array($input['selected_items'])) ? $input['selected_items'] : [];

        if ($reference_numb <= 0 || $ship_date === '' || $trailer_name === '' || $address === '' || $zip_code === '' || $city === '' || $state === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing required fields: reference_number/reference_numb/reference, ship_date/date, trailer_name/truck, address, zip_code, city, state']);
            exit;
        }

        try {
            $stmt = $connection->prepare("INSERT INTO orders_list (item_id, reference_numb, ship_date, trailer_name, address, zip_code, city, state, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

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

                    $stmt->bind_param("iisssisss", $item_id, $reference_numb, $ship_date, $trailer_name, $address, $zip_code, $city, $state, $status);

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

                $stmt->bind_param("iisssisss", $item_id, $reference_numb, $ship_date, $trailer_name, $address, $zip_code, $city, $state, $status);

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





    //     $input = json_decode(file_get_contents('php://input'), true);

    //     if (!isset($input['reference']) || !isset($input['date']) || !isset($input['truck'])) {
    //         http_response_code(400);
    //         echo json_encode(['error' => 'Invalid Input, Missing required fields']);
    //         exit;
    //     } else {
    //         $reference = htmlspecialchars($input['reference']);
    //         $date = htmlspecialchars($input['date']);
    //         $trailer = htmlspecialchars($input['truck']);
    //     };

    //         $sql = "SELECT item_id FROM order_list WHERE status='pending'";
    //         $result = mysqli_query($connection, $sql);
    //         $selected_items = [];
    //         while($row = mysqli_fetch_assoc($result)) {
    //             $selected_items[] = $row['item_id'];
    //         }
    // try {
    //     foreach($selected_items as $shipID){
    //         //personal database
    //         $stmt = $connection->prepare('INSERT INTO order_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, "pending")');
    //         $stmt->bind_param("iiss", 
    //             $shipID, 
    //             $reference, 
    //             $date, 
    //             $trailer);

    //         if (!$stmt->execute()) {
    //             http_response_code(500);
    //             echo json_encode(['sql error' => $stmt->error]);
    //             exit;
    //         };
    //         $stmt->close();

    //         //warehouse database
    //         $stmt = $connection->prepare("SELECT iii.*, pt.uom_primary FROM inventory_item_info iii INNER JOIN products_types pt ON iii.ficha = pt.ficha WHERE iii.inventory_id = ?");
    //         $stmt->bind_param("i", $shipID);
    //         $stmt->execute();
    //         $row = $stmt->get_result()->fetch_assoc();
    //         $stmt->close();

    //         if (!$row) {
    //             http_response_code(404);
    //             echo json_encode(['error' => 'Item not found']);
    //             exit;
    //         }
            
    //         $stmt = $connection->prepare("INSERT INTO orders (item_id, reference_numb, ship_date, trailer_name, ficha, unit_number, uom_primary) VALUES (?, ?, ?, ?, ?, ?, ?)");
    //         $stmt->bind_param("iisssss",
    //          $shipID, 
    //         $reference, 
    //             $date, 
    //             $trailer, 
    //             $row['ficha'], 
    //             $row['unit_numb'], 
    //             $row['uom_primary']
    //         );

    //         if (!$stmt->execute()) {
    //             http_response_code(500);
    //             echo json_encode(['sql error' => $stmt->error]);
    //             exit;
    //         };
    //         $stmt->close();

    //         //update location in personal database
    //         $stmt= $connection->prepare("UPDATE inventory_item_info SET `location`='shipping' WHERE inventory_id=?");
    //         $stmt->bind_param("i", $shipID);

    //         if (!$stmt->execute()) {
    //             http_response_code(500);
    //             echo json_encode(['sql error' => $stmt->error]);
    //             exit;
    //         };
    //         $stmt->close();
    //     }
    // } catch (Exception $e) {
    // http_response_code(500);
    // echo json_encode(['error' => $e->getMessage()]);
    // exit;}
        
        $data = [
            'reference' => $reference, 
            'date' => $date, 
            'trailer' => $trailer, 
            'selected_items' => $selected_items
        ];

        $options = [
            'http' =>  [
                'method' => $method,
                'header' => 'X-API-KEY:' . $api_key . "\r\n" .
                    'Content-Type: application/json',
                    'content' => json_encode($data)
            ]
        ];
        
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        $result   = json_decode($response, true);

        echo json_encode(['success' => true, 'data' => $data]);

    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }   

?>