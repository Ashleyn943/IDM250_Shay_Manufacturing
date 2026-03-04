<?php
    require_once('../db_connect.php');
    require_once('../library/auth.php');

    // Load environment variables
    $env_file = __DIR__ . '/../.env.php';
    $env = file_exists($env_file) ? require $env_file : [];

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
    }
?>



