<?php
    //checking keys 

    if ($method === 'POST'){

    $data = json_decode(file_get_contents('php://input'), true); 
    $data_keys = ['name', 'description', 'price', 'sku'];

    foreach ($data_keys as $key) {
        if (!isset($key)) {
            http_response_code(400);
            echo json_encode(['error' => "Bad Request", 'details' => "Missing field: $key"]);
            exit;
        }
    }

    $new_id = create_product($data);

    if($new_id){
        http_response_code(201);
        echo json_encode(['message' => 'Product created', 'id' => $new_id]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
    };
?>