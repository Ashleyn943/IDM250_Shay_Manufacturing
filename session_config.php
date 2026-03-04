<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_api_request() {
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    return strpos($script, '/APIs/') !== false;
}

function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function require_auth() {
    if (is_logged_in()) {
        return;
    }

    header('Location: login.php');
    exit;
}

function logout() {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
    header('Location: login.php');
    exit;
}
