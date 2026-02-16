<?php
    require_once '../db_connect.php';

        // $sql_query = "INSERT test_shipping SELECT * FROM test_inventory";

        // if($connection->query($sql_query) === TRUE){
        //         echo "Shipping list created successfully";
        //     } else {
        //         echo "Failed to create shipping list";
        //     }

    if(isset($_POST['send_list'])){
        $selected_items = isset($_POST['selected_items']) && !empty($_POST['selected_items']) ? $_POST['selected_items'] : [];
        $reference = $_POST['reference'];
        $date = $_POST['date'];
        $trailer = $_POST['truck'];

        foreach($selected_items as $key => $shipID){
            $sql = "SELECT DISTINCT ti.item, ti.item_numb, ti.cost FROM test_inventory ti WHERE ti.id = $shipID";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);

            if(!empty($row)){
                $stmt = $connection->prepare("INSERT INTO test_shipping (item, item_numb, cost, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, ?, ?, 'draft')");
                $stmt->bind_param("ssssss", $row['item'], $row['item_numb'], $row['cost'], $reference, $date, $trailer);
                $stmt->execute();
            };
        };
    };



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Sending</title>
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
        <table class="inventory_tb">
            <tr>
                <th>Select</th>
                <th>SKU</th>
                <th>Unit Number</th>
                <th>Ficha</th>
            </tr>
            <?php
                $result = mysqli_query($connection, "SELECT * FROM test_inventory");
                    if($row = mysqli_num_rows($result)){
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td> <input type='checkbox' value='" . htmlspecialchars($row['id']) . "' name='selected_items[]'> </td>";
                            echo "<td>" . htmlspecialchars($row['item'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['item_numb'] ?? '') . "</td>";
                            echo "<td> $" . htmlspecialchars($row['cost'] ?? '') . "</td>";
                            echo "</tr>";
                        }   
                    }
            ?>
        </table>
    </form>
</body>
</html>