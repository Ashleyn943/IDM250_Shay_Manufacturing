<?php
    require_once('db_connect.php');
    include_once('header.php');

    // Fetch counts for the summary cards
    $sku_count = mysqli_num_rows(mysqli_query($connection, "SELECT id FROM products"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/nav.css">
</head>
<body>
    <div class="dashboard-container">
    <h1>Dashboard</h1>

    <div class="stats-row">
        <div class="card">
            <h3>Total SKUs</h3>
            <p class="stat-number"><?php echo $sku_count; ?></p>
        </div>
        <div class="card">
            <h3>Internal Inventory</h3>
            <p class="stat-number">100</p>
        </div>
        <div class="card">
            <h3>Warehouse Inventory</h3>
            <p class="stat-number">0</p>
        </div>
    </div>

    <div class="section-container">
        <h2>Quick Actions</h2>
        <div class="button-group">
            <a href="mpl.php" class="btn">Create MPL</a>
            <a href="orders.php" class="btn">Create Order</a>
            <a href="APIs/product-new.php" class="btn">Add SKU</a>
        </div>
    </div>

    <div class="section-container">
        <h2>Recent MPLs</h2>
        <p class="empty-msg">No MPL records found.</p>
    </div>

    <div class="section-container">
        <h2>Recent Orders</h2>
        <p class="empty-msg">No order records found.</p>
    </div>
</div>
</body>
</html>