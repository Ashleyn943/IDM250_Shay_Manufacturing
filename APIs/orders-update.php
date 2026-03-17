<?php
    require_once('../db_connect.php');
    //require_once('../library/auth.php');
    require_once('../library/cms.php');

    $id = intval($_GET['id'] ?? 0);

    $package_stmt = $connection->prepare("SELECT id, reference_numb, ship_date, trailer_name, address, zip_code, city, state, status FROM order_list WHERE id=?");
    $package_stmt->bind_param("i", $id);
    $package_stmt->execute();
    $package_result = $package_stmt->get_result();
    $package_row = $package_result ? $package_result->fetch_assoc() : null;

    if (!$package_row) {
        http_response_code(404);
        echo "Order not found.";
        exit;
    }

    $package_ref = $package_row['reference_numb'];
    $package_ship_date = $package_row['ship_date'];
    $package_trailer = $package_row['trailer_name'];
    $package_address = $package_row['address'];
    $package_zip = $package_row['zip_code'];
    $package_city = $package_row['city'];
    $package_state = $package_row['state'];
    $package_status = $package_row['status'];

    $items_stmt = $connection->prepare("SELECT 
                                                ordership.id, 
                                                ordership.item_id, 
                                                iii.unit_numb, 
                                                iii.ficha, 
                                                iii.description1, 
                                                iii.description2, 
                                                iii.quantity, 
                                                iii.quantity_unit, 
                                                iii.footage_quantity 
                                                FROM order_list ordership 
                                                INNER JOIN inventory_item_info iii ON ordership.item_id = iii.inventory_id 
                                                WHERE ordership.reference_numb=? AND ordership.ship_date=? AND ordership.trailer_name=? AND ordership.address=? AND ordership.zip_code=? AND ordership.city=? AND ordership.state=? AND ordership.status=? 
                                                ORDER BY ordership.id ASC");
    $items_stmt->bind_param("isssisss", $package_ref, $package_ship_date, $package_trailer, $package_address, $package_zip, $package_city, $package_state, $package_status);
    $items_stmt->execute();
    $items_result = $items_stmt->get_result();
    $package_items = [];
    while ($item = $items_result->fetch_assoc()) {
        $package_items[] = $item;
    }

    $available_items_stmt = $connection->prepare("SELECT 
                                                            iii.inventory_id, 
                                                            iii.unit_numb, 
                                                            iii.ficha, 
                                                            iii.description1, 
                                                            iii.description2 
                                                            FROM inventory_item_info iii 
                                                            WHERE iii.location='warehouse' 
                                                            AND iii.inventory_id 
                                                            NOT IN (SELECT item_id 
                                                            FROM order_list ordership 
                                                            WHERE reference_numb=? 
                                                            AND ship_date=? 
                                                            AND trailer_name=? 
                                                            AND ordership.address=? 
                                                            AND ordership.zip_code=? 
                                                            AND ordership.city=? 
                                                            AND ordership.state=?) 
                                                            ORDER BY iii.inventory_id ASC");
    $available_items_stmt->bind_param("isssiss", $package_ref, $package_ship_date, $package_trailer, $package_address, $package_zip, $package_city, $package_state);
    $available_items_stmt->execute();
    $available_items_result = $available_items_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesheet.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="icon" href="../media/ShayIcon.png" type="image/x-icon">
    <title>Update Order</title>
</head>
<body>
    <?php include('../header_alt.php'); ?>
    <div class="dashboard-container">
        <div class="form-card-centered">
            <h1>Edit Order Package</h1>
            <p class="form-instruction">Update package details and add/remove items before sending.</p>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'updated') { ?>
                <div class="status-banner status-success">Package details updated successfully.</div>
            <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'add-success') { ?>
                <div class="status-banner status-success">Item(s) added to package.</div>
            <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'remove-success') { ?>
                <div class="status-banner status-success">Item removed from package.</div>
            <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'add-duplicate') { ?>
                <div class="status-banner status-warning">Item(s) already in this package.</div>
            <?php } elseif (isset($_GET['status']) && ($_GET['status'] === 'update-failed' || $_GET['status'] === 'add-failed' || $_GET['status'] === 'remove-failed')) { ?>
                <div class="status-banner status-warning">Action failed. Please try again.</div>
            <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'locked') { ?>
                <div class="status-banner status-warning">This package is no longer in draft status and cannot be edited.</div>
            <?php } ?>

            <br>

            <form action="../library/cms.php?id=<?php echo $id; ?>" method="POST" class="styled-form">
                <input type="hidden" name="package_id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="orig_ref_numb" value="<?php echo htmlspecialchars($package_ref); ?>">
                <input type="hidden" name="orig_ship_date" value="<?php echo htmlspecialchars($package_ship_date); ?>">
                <input type="hidden" name="orig_trailer" value="<?php echo htmlspecialchars($package_trailer); ?>">
                <input type="hidden" name="orig_address" value="<?php echo htmlspecialchars($package_address); ?>">
                <input type="hidden" name="orig_zip" value="<?php echo htmlspecialchars($package_zip); ?>">
                <input type="hidden" name="orig_city" value="<?php echo htmlspecialchars($package_city); ?>">
                <input type="hidden" name="orig_state" value="<?php echo htmlspecialchars($package_state); ?>">
                <input type="hidden" name="package_status" value="<?php echo htmlspecialchars($package_status); ?>">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="ref_numb">Reference Number</label>
                        <input type="number" name="ref_numb" value="<?php echo htmlspecialchars($package_ref); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ship_date">Expected Arrival Date</label>
                        <input type="date" name="ship_date" value="<?php echo htmlspecialchars($package_ship_date); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="truck">Vehicle Name</label>
                        <input type="text" name="truck" value="<?php echo htmlspecialchars($package_trailer); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($package_address); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="zip">Zip Code</label>
                        <input type="text" name="zip" value="<?php echo htmlspecialchars($package_zip); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" value="<?php echo htmlspecialchars($package_city); ?>" required>
                    </div>
                    <div class="form-group">
                        <div class="form-group dropdown-select">
                            <label for="state">State</label>
                            <select id="state" name="state" required>
                                <option value="" disabled selected>Select a state</option>
                                <option value="AZ" <?php echo ($package_state === 'AZ') ? 'selected' : ''; ?>>Arizona</option>
                                <option value="AR" <?php echo ($package_state === 'AR') ? 'selected' : ''; ?>>Arkansas</option>
                                <option value="CA" <?php echo ($package_state === 'CA') ? 'selected' : ''; ?>>California</option>
                                <option value="CO" <?php echo ($package_state === 'CO') ? 'selected' : ''; ?>>Colorado</option>
                                <option value="CT" <?php echo ($package_state === 'CT') ? 'selected' : ''; ?>>Connecticut</option>
                                <option value="DE" <?php echo ($package_state === 'DE') ? 'selected' : ''; ?>>Delaware</option>
                                <option value="FL" <?php echo ($package_state === 'FL') ? 'selected' : ''; ?>>Florida</option>
                                <option value="GA" <?php echo ($package_state === 'GA') ? 'selected' : ''; ?>>Georgia</option>
                                <option value="HI" <?php echo ($package_state === 'HI') ? 'selected' : ''; ?>>Hawaii</option>
                                <option value="ID" <?php echo ($package_state === 'ID') ? 'selected' : ''; ?>>Idaho</option>
                                <option value="IL" <?php echo ($package_state === 'IL') ? 'selected' : ''; ?>>Illinois</option>
                                <option value="IN" <?php echo ($package_state === 'IN') ? 'selected' : ''; ?>>Indiana</option>
                                <option value="IA" <?php echo ($package_state === 'IA') ? 'selected' : ''; ?>>Iowa</option>
                                <option value="KS" <?php echo ($package_state === 'KS') ? 'selected' : ''; ?>>Kansas</option>
                                <option value="KY" <?php echo ($package_state === 'KY') ? 'selected' : ''; ?>>Kentucky</option>
                                <option value="LA" <?php echo ($package_state === 'LA') ? 'selected' : ''; ?>>Louisiana</option>
                                <option value="ME" <?php echo ($package_state === 'ME') ? 'selected' : ''; ?>>Maine</option>
                                <option value="MD" <?php echo ($package_state === 'MD') ? 'selected' : ''; ?>>Maryland</option>
                                <option value="MA" <?php echo ($package_state === 'MA') ? 'selected' : ''; ?>>Massachusetts</option>
                                <option value="MI" <?php echo ($package_state === 'MI') ? 'selected' : ''; ?>>Michigan</option>
                                <option value="MN" <?php echo ($package_state === 'MN') ? 'selected' : ''; ?>>Minnesota</option>
                                <option value="MS" <?php echo ($package_state === 'MS') ? 'selected' : ''; ?>>Mississippi</option>
                                <option value="MO" <?php echo ($package_state === 'MO') ? 'selected' : ''; ?>>Missouri</option>
                                <option value="MT" <?php echo ($package_state === 'MT') ? 'selected' : ''; ?>>Montana</option>
                                <option value="NE" <?php echo ($package_state === 'NE') ? 'selected' : ''; ?>>Nebraska</option>
                                <option value="NV" <?php echo ($package_state === 'NV') ? 'selected' : ''; ?>>Nevada</option>
                                <option value="NH" <?php echo ($package_state === 'NH') ? 'selected' : ''; ?>>New Hampshire</option>
                                <option value="NJ" <?php echo ($package_state === 'NJ') ? 'selected' : ''; ?>>New Jersey</option>
                                <option value="NM" <?php echo ($package_state === 'NM') ? 'selected' : ''; ?>>New Mexico</option>
                                <option value="NY" <?php echo ($package_state === 'NY') ? 'selected' : ''; ?>>New York</option>
                                <option value="NC" <?php echo ($package_state === 'NC') ? 'selected' : ''; ?>>North Carolina</option>
                                <option value="ND" <?php echo ($package_state === 'ND') ? 'selected' : ''; ?>>North Dakota</option>
                                <option value="OH" <?php echo ($package_state === 'OH') ? 'selected' : ''; ?>>Ohio</option>
                                <option value="OK" <?php echo ($package_state === 'OK') ? 'selected' : ''; ?>>Oklahoma</option>
                                <option value="OR" <?php echo ($package_state === 'OR') ? 'selected' : ''; ?>>Oregon</option>
                                <option value="PA" <?php echo ($package_state === 'PA') ? 'selected' : ''; ?>>Pennsylvania</option>
                                <option value="RI" <?php echo ($package_state === 'RI') ? 'selected' : ''; ?>>Rhode Island</option>
                                <option value="SC" <?php echo ($package_state === 'SC') ? 'selected' : ''; ?>>South Carolina</option>
                                <option value="SD" <?php echo ($package_state === 'SD') ? 'selected' : ''; ?>>South Dakota</option>
                                <option value="TN" <?php echo ($package_state === 'TN') ? 'selected' : ''; ?>>Tennessee</option>
                                <option value="TX" <?php echo ($package_state === 'TX') ? 'selected' : ''; ?>>Texas</option>
                                <option value="UT" <?php echo ($package_state === 'UT') ? 'selected' : ''; ?>>Utah</option>
                                <option value="VT" <?php echo ($package_state === 'VT') ? 'selected' : ''; ?>>Vermont</option>
                                <option value="VA" <?php echo ($package_state === 'VA') ? 'selected' : ''; ?>>Virginia</option>
                                <option value="WA" <?php echo ($package_state === 'WA') ? 'selected' : ''; ?>>Washington</option>
                                <option value="WV" <?php echo ($package_state === 'WV') ? 'selected' : ''; ?>>West Virginia</option>
                                <option value="WI" <?php echo ($package_state === 'WI') ? 'selected' : ''; ?>>Wisconsin</option>
                                <option value="WY" <?php echo ($package_state === 'WY') ? 'selected' : ''; ?>>Wyoming</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-footer-actions">
                    <a href="../order_items.php" class="cancel-link">Cancel</a>
                    <?php if ($package_status === 'draft') { ?>
                        <button type="submit" name="update_order_btn" class="btn">Update Package Details</button>
                    <?php } ?>
                </div>
            </form>

            <div class="table-container" style="margin-top: 20px;">
                <h2>Items in Package</h2>
                <table class="data_tb">
                    <tr>
                        <th>Unit #</th>
                        <th>Ficha</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Qty Unit</th>
                        <th>Footage</th>
                        <th>Actions</th>
                    </tr>
                    <?php if (!empty($package_items)) {
                        foreach ($package_items as $item) {
                            $description = trim(($item['description1'] ?? '') . ' ' . ($item['description2'] ?? ''));
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($item['unit_numb']) . "</td>";
                            echo "<td>" . htmlspecialchars($item['ficha']) . "</td>";
                            echo "<td>" . htmlspecialchars($description) . "</td>";
                            echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
                            echo "<td>" . htmlspecialchars($item['quantity_unit']) . "</td>";
                            echo "<td>" . htmlspecialchars($item['footage_quantity']) . "</td>";
                            echo "<td>";
                            if ($package_status === 'draft') {
                                echo "<a href='../library/cms.php?package_id=" . urlencode($id) . "&remove_order_item_id=" . urlencode($item['id']) . "' onclick=\"return confirm('Remove this item from package?')\">Remove</a>";
                            } else {
                                echo "Locked";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No items in this package.</td></tr>";
                    } ?>
                </table>
            </div>

            <?php if ($package_status === 'draft') { ?>
                <div class="section-container" style="margin-top: 20px;">
                    <h2>Add Item to Package</h2>
                    <form action="../library/cms.php" method="POST" class="styled-form">
                        <input type="hidden" name="package_id" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="hidden" name="package_ref_numb" value="<?php echo htmlspecialchars($package_ref); ?>">
                        <input type="hidden" name="package_ship_date" value="<?php echo htmlspecialchars($package_ship_date); ?>">
                        <input type="hidden" name="package_trailer" value="<?php echo htmlspecialchars($package_trailer); ?>">
                        <input type="hidden" name="package_address" value="<?php echo htmlspecialchars($package_address); ?>">
                        <input type="hidden" name="package_zip" value="<?php echo htmlspecialchars($package_zip); ?>">
                        <input type="hidden" name="package_city" value="<?php echo htmlspecialchars($package_city); ?>">
                        <input type="hidden" name="package_state" value="<?php echo htmlspecialchars($package_state); ?>">
                        <input type="hidden" name="package_status" value="<?php echo htmlspecialchars($package_status); ?>">

                        <div class="form-group">
                            <label for="new_item_id">Warehouse Inventory Item</label>
                            <?php if ($available_items_result && $available_items_result->num_rows > 0) { ?>
                                <div class="select-all-wrap">
                                    <label class="select-all-label">
                                        <input type="checkbox" id="select-all-items">
                                        Select all available items
                                    </label>
                                </div>
                                <div class="item-list">
                                    <?php
                                        while ($available_item = $available_items_result->fetch_assoc()) {
                                            $available_description = trim(($available_item['description1'] ?? '') . ' ' . ($available_item['description2'] ?? ''));
                                    ?>
                                        <label class="item-option">
                                            <input type="checkbox" class="item-checkbox" name="new_item_id[]" value="<?php echo htmlspecialchars($available_item['inventory_id']); ?>">
                                            <?php
                                                echo htmlspecialchars($available_item['inventory_id']) . " | Unit " .
                                                     htmlspecialchars($available_item['unit_numb']) . " | " .
                                                     htmlspecialchars($available_description);
                                            ?>
                                        </label>
                                    <?php } ?>
                                </div>
                                <small class="item-help">Choose one or more items to add to this order package.</small>
                            <?php } else { ?>
                                <div class="empty-msg">No available warehouse items to add.</div>
                            <?php } ?>
                        </div>


                        <div class="form-footer-actions">
                            <button type="submit" name="add_order_item_btn" class="btn">Add Item</button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="../js/package-update.js"></script>
</body>
</html>