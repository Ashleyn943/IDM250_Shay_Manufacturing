<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once('db_connect.php');
    require_once('library/cms.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="icon" href="media/ShayIcon.png" type="image/x-icon">
    <title>Order Request</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="form-section">
        <h1>Select Stock for Order</h1>
        <form method="POST">
            <div class="form-group">
                <label for="reference">Reference Number</label>
                <input type="number" id="reference" name="reference" required>
            </div>
            <div class="form-group">
                <label for="date">Expected Shipment Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="truck">Trailer name:</label>
                <input type="text" id="truck" name="truck" required>
            </div>
    
            <div class="form-actions">
                 <button type="submit" name="order_list" class="btn-form" onClick='return confirm(\"Are you sure you want to send this order to the warehouse?\")'>Submit Order</button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <h2>Warehouse Inventory</h2>
        <table class="data_tb">
            <tr>
                <th>Select</th>
                <th>SKU</th>
                <th>Unit Number</th>
                <th>Ficha</th>
                <th>Description 1</th>
                <th>Description 2</th>
                <th>Quantity</th>
                <th>Quantity Unit</th>
                <th>Footage Quantity</th>
                <th>UOM</th>
            </tr>
            <?php
                $result = mysqli_query($connection, "SELECT iii.*, pt.uom_primary FROM inventory_item_info iii INNER JOIN products_types pt ON iii.ficha = pt.ficha WHERE location = 'warehouse'");
                    if($row = mysqli_num_rows($result)){
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td> <input type='checkbox' value='" . htmlspecialchars($row['inventory_id']) . "' name='selected_items[" . htmlspecialchars($row['inventory_id']) . "]'> </td>";
                            echo "<td>" . htmlspecialchars($row['inventory_id'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description1'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description2'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity_unit'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['footage_quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['uom_primary'] ?? '') . "</td>";
                            echo "</tr>";
                        }   
                    }
            ?>
        </table>
    </div>
</body>
</html>