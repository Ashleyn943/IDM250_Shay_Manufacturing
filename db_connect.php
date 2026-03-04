<?php
    require_once(__DIR__ . '/session_config.php');

    if (!is_api_request()) {
        require_auth();
    }

    $env_file = __DIR__ . '/.env.php';
    $env = file_exists($env_file) ? require $env_file : [];

    define('DB_HOST', $env['DB_HOST'] ?? '');
    define('DB_NAME', $env['DB_NAME'] ?? '');
    define('DB_USER', $env['DB_USER'] ?? '');
    define('DB_PASS', $env['DB_PASS'] ?? '');

    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if ($connection->connect_error){
        die("Connection failed:" . $connection->connect_error);
    }
?> 