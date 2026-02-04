<?php
    //authentication api
    function check_api_key($env) {
        //gives name of key
            $valid_key = $env['X-API-KEY'];
            //sets what keys can be
            $provided_key = null;
            //connects headers settings to api
            $headers = getallheaders();

            //names what the keys are
            foreach ($headers as $name => $value) {
                if (strtolower($name) === 'x-api-key') {
                    $provided_key = $value;
                    break;
                };
            };
            //response if key is not valid
            if ($provided_key != $valid_key) {
                http_response_code(401);
                echo json_encode(['error' => 'Unauthorized', 'details' => 'Invalid API Key']);
                exit;
            };
        
    };
?>