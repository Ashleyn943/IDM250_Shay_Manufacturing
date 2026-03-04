<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type, X-API-KEY');
    header('Access-Control-Allow-Methods: GET, OPTIONS');

    require_once('../db_connect.php');
    require_once('../library/auth.php');

    // Load environment variables
    $env_file = __DIR__ . '/../.env.php';
    $env = file_exists($env_file) ? require $env_file : [];

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }

    check_api_key($env);

    $method = $_SERVER['REQUEST_METHOD'];


    //For items on Master Packing List

    if($method === 'GET'){
        $sql = "SELECT mplship.*, iii.*, pt.uom_primary FROM mpl_shipping_list mplship INNER JOIN inventory_item_info iii  ON mplship.item_id = iii.inventory_id INNER JOIN products_types pt ON iii.ficha = pt.ficha";
        $results = mysqli_query($connection, $sql);

         if(!$results){
             http_response_code(500);
             echo json_encode(['error' => 'Internal Server Error']);
             exit;
         } else {
            $data = mysqli_fetch_all($results, MYSQLI_ASSOC);
            echo json_encode(['success' => true, 'count' => count($data), 'data' => $data]);
         }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }
?>



