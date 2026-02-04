<?php
    header('Content-Type: application/json');
    header('Access-Control_Allow_Origin: *');

    require_once('.../db_connect.php');
    require_once('/auth.php');

    check_api_key($env);

    $method=$_SERVER['REQUEST_METHOD'];
    $id = intval(basename($_SERVER['REQUEST_URI']));

    //GET via product ID
    if(!isset($id)) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad Request', 'details' => 'Missing ID']);
        exit;
    };

    if ($method === 'GET') :
        function get_product($connection, $id) {
            $stmt = $connection -> prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
            $stmt -> bind_param('i', $id);
            $stmt -> execute();

            $result = $stmt -> get_result();
            $product = $result -> fetch_assoc();

            if($product) {
                $vars_query = $connection -> prepare('SELECT * FROM product_variants WHERE product_id = ?');
                $vars_query -> bind_param('i', $id);
                $vars_query -> execute();

                $vars_result = $vars_query -> get_result();
                $vars = $vars_result -> fetch_assoc();

                $product['variants'] = $vars;

                echo json_encode(['success' => true, 'data' => $product]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Not Found', 'details' => 'Product Not Found']);
            }
        };
    elseif ($method === 'PUT') :
        function update_product($connection, $id) {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['name'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Bad Request', 'details' => 'Missing Required fields']);
                exit;
            }

            //changing data (in this case data name)
            $name = $connection -> real_escape_string($data['name']);
            $stmt = $connection -> prepare('UPDATE products SET name = ? WHERE id = ? LIMIT 1');
            $stmt -> bind_param('si', $name, $id);

            if ($stmt -> execute()) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Internal Server Error']);
            }
        };
    elseif ($method === 'DELETE') :
        function delete_product($connection, $id) {
            $stmt = $connection -> prepare('DELETE FROM products WHERE id = ? LIMIT 1');
            $stmt -> bind_param('i', $id);

            if ($stmt -> execute()) {
                http_response_code(204);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Internal Server Error']);
            }
        };
    endif;
?>