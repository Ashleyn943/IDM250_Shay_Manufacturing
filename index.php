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
        <a href="APIs/product-new.php">Add New Product</a>
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
                            echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['sku']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['uom_primary'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['piece_count'] ?? 0) . "</td>";
                            echo "<td>" . htmlspecialchars($row['length_inches'] ?? 0) . " in </td>";
                            echo "<td>" . htmlspecialchars($row['width_inches'] ?? 0) . " in </td>";
                            echo "<td>" . htmlspecialchars($row['height_inches'] ?? 0) . " in </td>";
                            echo "<td>" . htmlspecialchars($row['weight_lbs'] ?? 0) . " lb </td>";
                            echo "<td>" . htmlspecialchars($row['assembly'] ?? '') . "</td>";
                            echo "<td> $" . htmlspecialchars($row['rate'] ?? 0) . "</td>";
                            echo "<td> <a href='APIs/product-update.php?id=" . htmlspecialchars($row['id'] ?? 0) . "' class=''>Edit</a>
                            |
                            <a href='APIs/product-delete.php?id=" . htmlspecialchars($row['id'] ?? 0) . "' class=''>Delete</a></td>";
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
                            echo "<td> <input type='checkbox' name='".$row['inventory_id'] ."' value='selected'> </td>";
                            echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description_1'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description_2'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity'] ?? 0) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity_unit'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['footage_quantity'] ?? 0) . "</td>";
                            echo "</tr>";
                        }   
                    }
            ?>
        </table>

    <div>
        <form action=""></form>
    </div>
</body>
</html>