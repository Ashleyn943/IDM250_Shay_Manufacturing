<?php
session_start();

// Static credentials
define('STATIC_USERNAME', 'admin');
define('STATIC_PASSWORD', 'password123');

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Show the login page HTML
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="normalize.css">
</head>

<body class="login-body">
    <div class="login-container">
        <div class="login-header">
            <h1>Shay Manufacturing</h1>
            <p>Content Management System</p>
        </div>
        
        <form method="POST" onsubmit="handleLogin(event)">
            <div id="loginMessage" class="message"></div>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
    </div>
    
    <script src="js/login.js"></script>

</body>
</html>
    <?php
    exit;
}

// Handle login POST request
header('Content-Type: application/json');

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Username and password are required']);
    exit();
}

// Check against static credentials
if ($username === STATIC_USERNAME && $password === STATIC_PASSWORD) {
    // Create session
    session_regenerate_id(true);
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = $username;
    $_SESSION['login_time'] = time();
    
    http_response_code(200);
    echo json_encode(['success' => true, 'redirect' => 'index.php']);
    exit();
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid username or password']);
    exit();
}
?>
