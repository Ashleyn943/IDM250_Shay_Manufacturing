<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../db_connect.php';
require_once __DIR__ . '/../auth.php';

check_api_key($_ENV);

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') { // get all products
    $query = "SELECT p.id, p.name, p.base_price FROM products p";

    if (isset($_GET['category'])) {
        $category = $connection->real_escape_string($_GET['category']);
        $query .= " JOIN product_categories pc ON p.id = pc.product_id JOIN categories c ON pc.category_id = c.id WHERE c.name = '$category'";
    }

    $result = $connection->query($query);
    $products = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Query error: ' . $connection->error]);
        exit();
    }

    echo json_encode(['success' => true, 'data' => $products]);
    exit();

} elseif ($method == 'POST') { // create a new product
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name']) || !isset($data['base_price'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad Request: Missing required fields']);
        exit();
    }

    $name = $data['name'];
    $base_price = floatval($data['base_price']);

    $stmt = $connection->prepare("INSERT INTO products (name, base_price) VALUES (?, ?)");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $connection->error]);
        exit();
    }
    $stmt->bind_param("sd", $name, $base_price);
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(["success" => true, "id" => $connection->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }
    $stmt->close();
    exit();

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit();
}