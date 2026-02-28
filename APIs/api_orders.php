<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    require_once('../db_connect.php');
    require_once('../library/auth.php');

    check_api_key($env);

    $url = 'https://digmstudents.westphal.drexel.edu/~an943/Shay_Manufacturing/APIs/api_orders.php';
    $api_key = getenv('API_KEY');
    $method = $_SERVER['REQUEST_METHOD'];
    $data = null;
    $encoded_data = null;

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
        $selected_items = isset($_POST['selected_items']) && !empty($_POST['selected_items']) ? $_POST['selected_items'] : [];
        $sql = "SELECT ol.*, iii.*, pt.uom_primary FROM order_list ol INNER JOIN inventory_item_info iii ON ol.item_id = iii.inventory_id INNER JOIN products_types pt ON iii.ficha = pt.ficha WHERE ol.status='draft'";
        $result = mysqli_query($connection, $sql);

        $ficha = $results['ficha'] ?? null;
        $unit_number = $results['unit_number'] ?? null;
        $uom_primary = $results['uom_primary'] ?? null;

        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['reference']) || !isset($input['date']) || !isset($input['truck'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid Input, Missing required fields']);
            exit;
        } else {
            $reference = htmlspecialchars($input['reference']);
            $date = htmlspecialchars($input['date']);
            $trailer = htmlspecialchars($input['truck']);
        }

        foreach($selected_items as $key => $shipID){
            $stmt = $connection->prepare('INSERT INTO order_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, "pending")');
            $stmt->bind_param("iiss", $shipID, $reference, $date, $trailer);
            $stmt->execute();

            $stmt = $connection->prepare("INSERT INTO orders (id, reference_numb, ship_date, trailer_name, ficha, unit_number, uom_primary) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sisssss", $shipID, $reference, $date, $trailer, $ficha, $unit_number, $uom_primary);
            $stmt->execute();

            $stmt= $connection->prepare("UPDATE inventory_item_info SET `location`='shipping' WHERE inventory_id=$shipID");
            $stmt->execute();
        }
        
        $data = [
            'reference' => $reference, 
            'date' => $date, 
            'trailer' => $trailer, 
            'selected_items' => $selected_items
        ];

        echo json_encode(['sucess' => true, 'data' => $data]);

        if (!$results) {
            echo json_encode(['success' => true, 'message' => 'Order sent successfully']);
            //header("Location: ../order_items.php");
            exit();
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }   

?>