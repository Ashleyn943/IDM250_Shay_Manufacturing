<?php
    require_once('../db_connect.php');
    $id = intval($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Confirmation | Shay Manufacturing</title>
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/stylesheet.css">
    <link rel="icon" href="../media/ShayIcon.png" type="image/x-icon">
</head>
<body>
    <div class="login-body">
        <div class="login-container">
            <div class="login-header">
                <h1>Confirm Deletion</h1>
                <p>Are you sure you want to delete this product?</p>
            </div>
            <form action="../library/cms.php?id=<?php echo $id; ?>" method="POST">
                <button type="submit" name="delete_btn" class="btn">Confirm Delete</button>
                <button type="button" style="margin-top: 10px;" class="btn" onclick="window.location.href='../sku_management.php'">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>