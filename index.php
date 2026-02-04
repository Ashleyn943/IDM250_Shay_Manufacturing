<?php
    //header('Content-Type: application/json');
    //header('Access-Control-Allow-Origin: *');

    require_once('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Table Practice</title>
</head>
<body>
    <h1>Products</h1>
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