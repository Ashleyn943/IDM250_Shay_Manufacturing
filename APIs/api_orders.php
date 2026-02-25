<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    require_once('../db_connect.php');
    require_once('../library/auth.php');

    // Load environment variables
    $env_file = __DIR__ . '/../.env.php';
    $env = file_exists($env_file) ? require $env_file : [];

    check_api_key($env);

    $url = 'https://digmstudents.westphal.drexel.edu/~an943/Shay_Manufacturing/APIs/api_orders.php';
    $api_key = getenv('API_KEY');
    $method = $_SERVER['REQUEST_METHOD'];
    $data = null;
    $encoded_data = null;

    if($method === 'POST' && isset($_POST['order_send'])){
        $data = implode(" ",$_POST['selected_items']);
        if (!preg_match("/^[a-zA-Z0-9_]*$/", $data)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid Input']);
            exit;
        }
        $encoded_data = json_encode($data);

        $options = [
            'http' =>  [
                'method' => $method,
                'header' => 'X-API-KEY:' . $api_key . "\r\n" .
                    'Content-Type: application/json',
                'content' => $encoded_data
            ]
        ];
    
        $context  = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        $result   = json_decode($response, true);

        if ($result && isset($result['success']) && $result['success'] === true) {
            echo json_encode(['success' => true, 'message' => 'Order sent successfully']);
            foreach($_POST['selected_items'] as $id){
                $stmt = $connection->prepare("UPDATE order_list SET status = 'Pending' WHERE item_id = '$id'");
                $stmt->execute();
            }
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }   

?>