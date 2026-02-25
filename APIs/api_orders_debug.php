<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    try {
        require_once('../db_connect.php');
        require_once('../library/auth.php');

        $env_file = __DIR__ . '/../.env.php';
        $env = file_exists($env_file) ? require $env_file : [];

        check_api_key($env);

        $method = $_SERVER['REQUEST_METHOD'];

        echo json_encode([
            'message' => 'API Orders Debug',
            'method' => $method,
            'has_order_send' => isset($_POST['order_send']),
            'has_selected_items' => isset($_POST['selected_items']),
            'post_data' => $_POST,
            'expected_format' => 'POST form data with order_send and selected_items[]'
        ], JSON_PRETTY_PRINT);

        if ($method !== 'POST') {
            throw new Exception("Expected POST, got: " . $method);
        }

        if (!isset($_POST['order_send'])) {
            throw new Exception("Missing order_send parameter");
        }

        if (!isset($_POST['selected_items'])) {
            throw new Exception("Missing selected_items parameter");
        }

        $data = implode(" ", $_POST['selected_items']);
        
        if (!preg_match("/^[a-zA-Z0-9_ ]*$/", $data)) {
            throw new Exception("Invalid characters in selected_items");
        }

        echo json_encode([
            'success' => true,
            'message' => 'Validation passed',
            'combined_data' => $data
        ], JSON_PRETTY_PRINT);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
?>
