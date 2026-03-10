<?php
    require_once('db_connect.php');
    require_once('library/cms.php');
    require_once('session_config.php');
    require_auth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="icon" href="media/ShayIcon.png" type="image/x-icon">
    <title>Shipping List</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="dashboard-container">
    <h1>Select Stock to be Shipped</h1>
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success') { ?>
        <div class="status-banner status-success">
            Shipping list saved. Selected items were added to the MPL shipping list.
        </div>
    <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'missing') { ?>
        <div class="status-banner status-warning">
            Please select at least one item and fill out all fields before submitting.
        </div>
    <?php } ?>

    <div class="form-section">
        
        <form method="POST" action="library/cms.php">
            <div class="form-group">
                <label for="reference">Reference Number</label>
                <input type="number" id="reference" name="reference" required>
            </div>
            <div class="form-group">
                <label for="date">Expected Arrival Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="truck">Trailer name:</label>
                <input type="text" id="truck" name="truck" required>
            </div>

            <div class="table-container">
                <h2>Inventory Items</h2>
                <table class="data_tb">
            <tr>
                <th>Select</th>
                <th>SKU</th>
                <th>Unit Number</th>
                <th>Ficha</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Quantity Unit</th>
                <th>Footage Quantity</th>
                <th>Location</th>
            </tr>
            <?php
				$result = mysqli_query($connection, "SELECT * FROM inventory_item_info WHERE location = 'internal'");
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td><input type='checkbox' value='" . htmlspecialchars($row['inventory_id']) . "' name='selected_items[" . htmlspecialchars($row['inventory_id']) . "]'></td>";
                            echo "<td>" . htmlspecialchars($row['sku'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                            $description = trim(($row['description1'] ?? '') . ' ' . ($row['description2'] ?? ''));
                            echo "<td>" . htmlspecialchars($description) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity_unit'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['footage_quantity'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['location'] ?? '') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No inventory items found.</td></tr>";
                    }
            ?>
                </table>
            </div>

            <div class="form-actions">
                <button type="submit" name="send_list" class="btn-form">Submit</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>