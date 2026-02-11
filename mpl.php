<?php
    require_once('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Shipping List</title>
</head>
<body>
    <table>
        <h1>Current Stock</h1>
        <form method="POST">
            <div>
                <label for="reference">Reference Number</label>
                <input type="number" name="reference" required>
            </div>
            <div>
                <label for="date">Shipment Date:</label>
                <input type="date" name="date" required>
            </div>
            <div>
                <label for="truck">Trailer name:</label>
                <input type="text" name="truck" required>
            </div>
    
            <div>
                <button type="submit" name="send_list">Submit</button>
            </div>
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
                            echo "<td> <input type='checkbox' value='selected'> </td>";
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
        </form>
    </table>
</body>
</html>