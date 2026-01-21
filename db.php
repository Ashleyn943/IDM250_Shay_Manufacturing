<?php
    $env_file =  dirname(__FILE__) . '.env.php';
    $env	= file_exists($env_file) ? require $env_file :  [ ];

    $database = [
        'host' => $env [DB_HOST]  ?? null,
        'name' => $env [DB_NAME]  ?? null,
        'username' => $env [DB_USER]  ?? null,
        'password' => $env [DB_PASS]  ?? null,
    ];

    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if ($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }
?>