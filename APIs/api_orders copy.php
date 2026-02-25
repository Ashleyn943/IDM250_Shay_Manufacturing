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
    $selected_items = null;
    $order_send = false;

    if ($method === 'POST') {
        // Accept both form data and JSON
        if (!empty($_POST['selected_items'])) {
            $selected_items = $_POST['selected_items'];
            $order_send = isset($_POST['order_send']);
        } else {
            $input = json_decode(file_get_contents('php://input'), true);
            if ($input && isset($input['selected_items'])) {
                $selected_items = is_array($input['selected_items']) ? $input['selected_items'] : [$input['selected_items']];
                $order_send = isset($input['order_send']) && $input['order_send'] === true;
            }
        }

        if (!$order_send || !$selected_items) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing required fields']);
            exit;
        }

        $data = implode(" ", $selected_items);
        if (!preg_match("/^[a-zA-Z0-9_ ]*$/", $data)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid input characters']);
            exit;
        }

        // Update order_list table with status
        $success = true;
        foreach($selected_items as $id){
            $id = intval($id);
            $stmt = $connection->prepare("UPDATE order_list SET status = 'Pending' WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id);
                if (!$stmt->execute()) {
                    $success = false;
                }
            } else {
                $success = false;
            }
        }

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Orders updated successfully',
                'items_processed' => count($selected_items)
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to update orders']);
        }

    } else {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    }   

?>