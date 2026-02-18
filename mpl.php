<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    // require_once('library/auth.php');
    // require_once('library/cms.php');
    require_once('db_connect.php');
    include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/nav.css">
    <title>Shipping List</title>
</head>
<body>
        <h1>Select Stock to be Shipped</h1>
        <form method="POST">
            <div>
                <label for="reference">Reference Number</label>
                <input type="number" name="reference" required>
            </div>
            <div>
                <label for="date">Expected Arrival Date:</label>
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
                <th>SKU</th>
                <th>Unit Number</th>
                <th>Ficha</th>
                <th>Description 1</th>
                <th>Description 2</th>
                <th>Quantity</th>
                <th>Quantity Unit</th>
                <th>Footage Quantity</th>
                <th>Location</th>
            </tr>
            <?php
                $result = mysqli_query($connection, "SELECT * FROM inventory_item_info");
                    if($row = mysqli_num_rows($result)){
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td> <input type='checkbox' value='" . htmlspecialchars($row['inventory_id']) . "' name='selected_items[" . htmlspecialchars($row['inventory_id']) . "]'> </td>";
                            echo "<td>" . htmlspecialchars($row['inventory_id'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description_1'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['description_2'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity_unit'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['footage_quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['location'] ?? '') . "</td>";
                            echo "</tr>";
                        }   
                    }
            ?>
        </table>
    </form>
</body>
</html>