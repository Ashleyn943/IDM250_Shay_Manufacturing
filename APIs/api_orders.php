<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    require_once('../db_connect.php');
    require_once('../library/auth.php');

    check_api_key($env);

    $url = 'https://digmstudents.westphal.drexel.edu/~ckl49/idm250-csquaredwms/api/orders.php';
    $api_key = getenv('API_KEY');
    $method = $_SERVER['REQUEST_METHOD'];


    if($method === 'GET'){
        $sql =  "SELECT ol.*, iii.*, pt.uom_primary FROM order_list ol INNER JOIN inventory_item_info iii ON ol.item_id = iii.inventory_id INNER JOIN products_types pt ON iii.ficha = pt.ficha WHERE ol.status='draft'";
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
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['reference']) || !isset($input['date']) || !isset($input['truck']) || !isset($input['selected_items'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid Input, Missing required fields']);
            exit;
        } else {
            $reference = htmlspecialchars($input['reference']);
            $date = htmlspecialchars($input['date']);
            $trailer = htmlspecialchars($input['truck']);
            $selected_items = $input['selected_items'];
        };
    try {
        foreach($selected_items as $shipID){
            //personal database
            $stmt = $connection->prepare('INSERT INTO order_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, "pending")');
            $stmt->bind_param("iiss", 
                $shipID, 
                $reference, 
                $date, 
                $trailer);

            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(['sql error' => $stmt->error]);
                exit;
            };
            $stmt->close();

            //warehouse database
            $stmt = $connection->prepare("SELECT iii.*, pt.uom_primary FROM inventory_item_info iii INNER JOIN products_types pt ON iii.ficha = pt.ficha WHERE iii.inventory_id = ?");
            $stmt->bind_param("i", $shipID);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$row) {
                http_response_code(404);
                echo json_encode(['error' => 'Item not found']);
                exit;
            }
            
            $stmt = $connection->prepare("INSERT INTO orders (item_id, reference_numb, ship_date, trailer_name, ficha, unit_number, uom_primary) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisssss",
             $shipID, 
            $reference, 
                $date, 
                $trailer, 
                $row['ficha'], 
                $row['unit_numb'], 
                $row['uom_primary']
            );

            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(['sql error' => $stmt->error]);
                exit;
            };
            $stmt->close();

            //update location in personal database
            $stmt= $connection->prepare("UPDATE inventory_item_info SET `location`='shipping' WHERE inventory_id=?");
            $stmt->bind_param("i", $shipID);

            if (!$stmt->execute()) {
                http_response_code(500);
                echo json_encode(['sql error' => $stmt->error]);
                exit;
            };
            $stmt->close();
        }
    } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;}
        
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