<?php 

function check_api_key($env) {
    // Check if the 'x-api-key' is set in the environment
    $valid_key = isset($env['x-api-key']) ? $env['x-api-key'] : null;
    $provided_key = null;
    $headers = getallheaders();

    foreach ($headers as $name => $value) {
        if (strtolower($name) === 'x-api-key') {
            $provided_key = $value;
            break;
        }
    }

    if ($provided_key !== $valid_key) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized: Invalid API Key']);
        exit();
    }
}