<?php
    require_once('db_connect.php');
    require_once('library/auth.php');
    require_once('library/cms.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Master Packing List</title>
</head>
<body>
    <a href="mpl.php">Return to Create Master Packing</a> | <a href="order.php">Create Order List</a> 
        <h1>Items on Master Packing List</h1>
        <form method="POST">
        <table class="inventory_tb">
            <tr>
                <th>SKU</th>
                <th>Unit Number</th>
                <th>Ficha</th>
                <th>Description 1</th>
                <th>Description 2</th>
                <th>Quantity</th>
                <th>Quantity Unit</th>
                <th>Footage Quantity</th>
                <th>UOM</th>
                <th>Reference Number</th>
                <th>Ship Date</th>
                <th>Trailer Name</th>   
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php
                $stmt = $connection->prepare("SELECT iii.*, mplship.*, pt.uom_primary FROM inventory_item_info iii INNER JOIN mpl_shipping_list mplship ON iii.inventory_id = mplship.item_id INNER JOIN products_types pt ON iii.ficha = pt.ficha");
                $stmt->execute();
                $result = $stmt->get_result();
                    if($result->num_rows > 0){
                        foreach($result as $row){
                            $stmt->execute();
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['sku'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description1'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description2'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity_unit'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['footage_quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['uom_primary'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['reference_numb'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['ship_date'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['trailer_name'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['status'] ?? '') . "</td>";
                            echo "<td> <a onClick='return confirm(\"Are you sure you want to remove this item from the Master Packing List?\")' href='APIs/mpl-delete.php?id=" . htmlspecialchars($row['id'] ?? 0) . "' name='delete-mpl'>Remove</a></td>";
                            echo "</tr>";
                        }   
                    }
            ?>
        </table>
    </form>
</body>
</html>