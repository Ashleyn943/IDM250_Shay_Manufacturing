<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    require_once('../db_connect.php');
    require_once('../library/auth.php');

    check_api_key($env);

    //General Call
    //url = the url with current functions 
    //method = whatever method the function uses 
    //data = database 
    //api_key = key in the env file 
    $url = 'https://digmstudents.westphal.drexel.edu/~an943/Shay_Manufacturing/APIs/api_call.php';
    $api_key = getenv('API_KEY');
    $method = $_SERVER['REQUEST_METHOD'];

        $options = [
            'http' =>  [
                'method' => $method,
                'header' => 'X-API-KEY:' . $api_key . "\r\n" .
                    'Content-Type: application/json',
                'content' => json_encode($data ?? [])
            ]
        ];
    
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        $result   = json_decode($response, true);


    //For items on Master Packing List

    if($method === 'GET'){
        $sql = "SELECT mplship.*, iii.*, pt.uom_primary FROM mpl_shipping_list mplship INNER JOIN inventory_item_info iii  ON mplship.item_id = iii.inventory_id INNER JOIN products_types pt ON iii.ficha = pt.ficha";
        $results = mysqli_query($connection, $sql);

        $data = mysqli_fetch_all($results, MYSQLI_ASSOC);

        echo json_encode(['success' => true, 'data' => $data]);

         if(!$results){
             http_response_code(500);
             echo json_encode(['error' => 'Internal Server Error']);
         }
    } elseif ($method === 'POST'){
        $selected_items = isset($_POST['selected_items']) && !empty($_POST['selected_items']) ? $_POST['selected_items'] : [];
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['reference']) || !isset($input['date']) || !isset($input['truck'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid Input, Missing required fields']);
            exit;
        } else {
            $reference = $input['reference'];
            $date = $input['date'];
            $trailer = $input['truck'];
        }

        if (!preg_match("/^[a-zA-Z0-9_]*$/", $trailer)) {
            echo "Only alphabets, numbers, and underscores are allowed for Trailer Name";
        } elseif (!preg_match("/^[0-9]+$/", $reference)) {
            echo "Only numbers are allowed for Reference Number";
        } else {
            foreach($selected_items as $key => $shipID){
                $stmt = $connection->prepare('INSERT INTO mpl_shipping_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, "draft")');
                $stmt->bind_param("iiss", $shipID, $reference, $date, $trailer);
                $stmt->execute();
                $stmt= $connection->prepare("UPDATE inventory_item_info SET `location`='warehouse' WHERE inventory_id=$shipID");
                $stmt->execute();
            }
        }

        if (!$stmt->execute()) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
         } else {
             echo json_encode(['success' => true, 'message' => 'Items sent to shipping list successfully']);
         }
    } elseif ($method === 'DELETE') {
        $input = json_decode(file_get_contents('php://input'), true);
        $check = $connection->prepare("SELECT id, status FROM mpl_shipping_list WHERE id=? AND status='draft'");

     if($check == TRUE){
        $id = $_GET['id'];
        $stmt = $connection->prepare("UPDATE inventory_item_info iii INNER JOIN mpl_shipping_list mplship ON iii.inventory_id = mplship.item_id SET iii.location='internal' WHERE mplship.id=$id");
        $stmt->execute();

        $stmt = $connection->prepare("DELETE FROM mpl_shipping_list WHERE id=$id");
        $stmt->execute();

        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }
?>



