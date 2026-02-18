<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../db_connect.php';
require_once __DIR__ . '/../auth.php';

check_api_key($_ENV);

$method = $_SERVER['REQUEST_METHOD'];
$uri_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$id = intval(end($uri_parts)); // api/products/{id}

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request: Missing or invalid product ID']);
    exit();
}

if ($method == 'GET') { // get product by id
    $stmt = $connection->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    if ($product) {
        $var_query = $connection->prepare("SELECT * FROM product_variants WHERE product_id = ?");
        $var_query->bind_param("i", $id);
        $var_query->execute();

        $var_result = $var_query->get_result();
        $variants = [];
        while ($var = $var_result->fetch_assoc()) {
            $variants[] = $var;
        }

        $product['variants'] = $variants;

        echo json_encode(['success' => true, 'data' => $product]);
        exit();
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        exit();
    }
}

elseif ($method == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad Request: Missing required fields']);
        exit();
    }

    $name = $data['name'];
    $stmt = $connection->prepare('UPDATE products SET name = ? WHERE id = ? LIMIT 1');
    $stmt->bind_param('si', $name, $id);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Update failed: ' . $connection->error]);
        exit();
    }
}

elseif ($method == 'DELETE') {
    $stmt = $connection->prepare('DELETE FROM products WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
        exit();
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Delete failed: ' . $connection->error]);
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit();
}