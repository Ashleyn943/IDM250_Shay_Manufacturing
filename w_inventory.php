<?php
    require_once('db_connect.php');
    require_once('session_config.php');
    require_auth();

    $warehouse_count = mysqli_num_rows(mysqli_query($connection, "SELECT inventory_id FROM inventory_item_info WHERE location = 'warehouse'"));
    $pending_MPLs = mysqli_num_rows(mysqli_query($connection, "SELECT id FROM mpl_shipping_list WHERE status = 'pending'"));
    $pending_orders = mysqli_num_rows(mysqli_query($connection, "SELECT id FROM order_list WHERE status = 'pending'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Inventory</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="icon" href="media/ShayIcon.png" type="image/x-icon">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="dashboard-container">
        <h1>Warehouse Inventory</h1>

        <div class="stats-row">
            <div class="card">
                <h3>Total Items</h3>
                <p class="stat-number"><?php echo $warehouse_count; ?></p>
            </div>
            <div class="card">
                <h3>Pending MPLs</h3>
                <p class="stat-number"><?php echo $pending_MPLs; ?></p>
            </div>
            <div class="card">
                <h3>Pending Order Shipments</h3>
                <p class="stat-number"><?php echo $pending_orders; ?></p>
            </div>
        </div>

        <div class="table-container">
            <h2>Warehouse Items</h2>
            <table class="data_tb">
                <tr>
                    <th>SKU</th>
                    <th>Unit Number</th>
                    <th>Ficha</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Footage</th>
                    <th>Warehouse</th>
                </tr>
                <tr>
                   <?php
					$result = mysqli_query($connection, "SELECT * FROM inventory_item_info WHERE location = 'warehouse'");
					if ($result && mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							$description = trim(($row['description1'] ?? '') . ' ' . ($row['description2'] ?? ''));
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row['sku'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($description) . "</td>";
							echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['quantity_unit'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['footage_quantity'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['location'] ?? '-') . "</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='10'>No inventory items found.</td></tr>";
					}
				?>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>