<?php
    //header('Content-Type: application/json');
    //header('Access-Control-Allow-Origin: *');
    include('header.php');
    require_once('db_connect.php');

    // Fetch counts for the summary cards
    $sku_count = mysqli_num_rows(mysqli_query($connection, "SELECT id FROM products"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/nav.css">
    <title>Table Practice</title>
</head>
<body>
<<<<<<< Updated upstream
    <h1>Products</h1>
=======

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

    <h1>Products</h1>
        <a href="APIs/product-new.php" class="btn">Add New Product</a>
>>>>>>> Stashed changes
        <table class="data_tb">
            <tr>
                <th>ID</th>
                <th>Sku</th>
                <th>Description</th>
                <th>Unit of Measure</th>
                <th>Piece Count</th>
                <th>Length</th>
                <th>Width</th>
                <th>Height</th>
                <th>Weight</th>
                <th>Assembly</th>
                <th>Price Rate</th>
                <th>Actions</th>
            <?php
                $result = mysqli_query($connection, "SELECT * FROM products p INNER JOIN products_dimensions pd ON p.id = pd.id INNER JOIN products_types pt ON p.id = pt.id");
                    if($row = mysqli_num_rows($result)){
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ficha']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['sku']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['uom_primary']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['piece_count']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['length_inches']) . "in </td>";
                            echo "<td>" . htmlspecialchars($row['width_inches']) . "in </td>";
                            echo "<td>" . htmlspecialchars($row['height_inches']) . "in </td>";
                            echo "<td>" . htmlspecialchars($row['weight_lbs']) . "lb </td>";
                            echo "<td>" . htmlspecialchars($row['assembly']) . "</td>";
                            echo "<td> $" . htmlspecialchars($row['rate']) . "</td>";
                            echo "<td> <a href='edit.php?=" . htmlspecialchars($row['ID']) . "' class=''>Edit</a></td>";
                            echo "</tr>";
                        }
                    };
            ?>
        </table>
    <br><br>
    <h1>Current Stock</h1>
        <table class="data_tb">
            <tr>
                <th>Select</th>
                <th>Order Number</th>
                <th>Shipment Number</th>
                <th>Bill Number</th>
                <th>Purchase Number</th>
                <th>Unit Number</th>
                <th>Ficha</th>
                <th>Description 1</th>
                <th>Description 2</th>
                <th>Quantity</th>
                <th>Quantity Unit</th>
                <th>Footage Quantity</th>
            </tr>
            <?php
                $result = mysqli_query($connection, "SELECT * FROM inventory_item_info");
                    if($row = mysqli_num_rows($result)){
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td> <input type='checkbox' value='selected'> </td>";
                            echo "<td>" . htmlspecialchars($row['order_numb']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['shipment_numb']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['bill_numb']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['purchase_numb']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['unit_numb']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ficha']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description_1']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description_2']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity_unit']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['footage_quantity']) . "</td>";
                            echo "</tr>";
                        }   
                    }
            ?>
        </table>
</body>
</html>