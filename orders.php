<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
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
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="icon" href="media/ShayIcon.png" type="image/x-icon">
    <title>Order Request</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="form-section">
        <h1>Select Stock for Order</h1>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') { ?>
            <div class="status-banner status-success">
                Order item(s) added to order list successfully.
            </div>
        <?php } ?>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') { ?>
            <div class="status-banner status-success">
                Order saved. Selected items were added to the order list.
            </div>
        <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'missing') { ?>
            <div class="status-banner status-warning">
                Please select at least one item and fill out all fields before submitting.
            </div>
        <?php } ?>

        <form method="POST" action="library/cms.php">
            <div class="form-group">
                <label for="reference">Reference Number</label>
                <input type="number" id="reference" name="reference" maxlength="10" required>
            </div>
            <div class="form-group">
                <label for="date">Expected Shipment Date</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="truck">Trailer name</label>
                <input type="text" id="truck" name="truck" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="zip">ZIP Code</label>
                <input type="number" id="zip" name="zip" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <select id="state" name="state" required>
                    <option value="" disabled selected>Select a state</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>
            </div>

    
            <div class="form-actions">
                 <button type="submit" name="order_list" class="btn-form">Submit Order</button>
            </div>
    </div>

    <div class="table-container">
        <h2>Warehouse Inventory</h2>
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
                <th>UOM</th>
            </tr>
            <?php
                $result = mysqli_query($connection, "SELECT iii.*, pt.uom_primary FROM inventory_item_info iii INNER JOIN products_types pt ON iii.ficha = pt.ficha WHERE location = 'warehouse' || location = 'on-route'");
                    if($row = mysqli_num_rows($result)){
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td> <input type='checkbox' value='" . htmlspecialchars($row['inventory_id']) . "' name='selected_items[" . htmlspecialchars($row['inventory_id']) . "]'> </td>";
                            echo "<td>" . htmlspecialchars($row['inventory_id'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                            $description = trim(($row['description1'] ?? '') . ' ' . ($row['description2'] ?? ''));
                            echo "<td>" . htmlspecialchars($description) . "</td>";
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
    </form>
</body>
</html>