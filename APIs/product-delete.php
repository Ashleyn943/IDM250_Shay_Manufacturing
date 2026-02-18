<?php
    require_once('../db_connect.php');
    $id = intval($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Confirmation</title>
</head>
<body>
    <h1>Are you sure you want to delete product #<?php echo $id; ?>?</h1>
    <p>This action cannot be undone.</p>
    
    <form action="../library/cms.php?id=<?php echo $id; ?>" method="POST">
        <button type="submit" name="delete_btn">Confirm Delete</button>
        <a href="../index.php">Cancel</a>
    </form>
</body>
</html>