<?php
    require_once('db_connect.php');
    require_once('library/cms.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Order Request</title>
</head>
<body>
    <a href="index.php">Return to Main Menu</a> | <a href="mpl_items.php">View Items on Master Packing List</a> | <a href="order_items.php">View Order List</a> 
        <h1>Select Stock for Order</h1>
        <form method="POST">
            <div>
                <label for="reference">Reference Number</label>
                <input type="number" name="reference" required>
            </div>
            <div>
                <label for="date">Expected Shipment Date:</label>
                <input type="date" name="date" required>
            </div>
            <div>
                <label for="truck">Trailer name:</label>
                <input type="text" name="truck" required>
            </div>
    
            <div>
                <button type="submit" name="order_list">Submit</button>
            </div>
        <table class="inventory_tb">
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
                <th>Location</th>
            </tr>
            <?php
                $result = mysqli_query($connection, "SELECT iii.*, pt.uom_primary FROM inventory_item_info iii INNER JOIN products_types pt ON iii.ficha = pt.ficha WHERE location = 'warehouse'");
                    if($row = mysqli_num_rows($result)){
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td> <input type='checkbox' value='" . htmlspecialchars($row['inventory_id']) . "' name='selected_items[" . htmlspecialchars($row['inventory_id']) . "]'> </td>";
                            echo "<td>" . htmlspecialchars($row['sku'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description1'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description2'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity_unit'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['footage_quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['uom_primary'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['location'] ?? '') . "</td>";
                            echo "</tr>";
                        }   
                    }
            ?>
        </table>
    </form>
</body>
</html>