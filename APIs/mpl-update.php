<?php
    require_once('../db_connect.php');
    //require_once('../library/auth.php');
    require_once('../library/cms_alt.php');

    $id = intval($_GET['id'] ?? 0);

    $package_stmt = $connection->prepare("SELECT id, reference_numb, ship_date, trailer_name, status FROM mpl_shipping_list WHERE id=? LIMIT 1");
    $package_stmt->bind_param("i", $id);
    $package_stmt->execute();
    $package_result = $package_stmt->get_result();
    $package_row = $package_result ? $package_result->fetch_assoc() : null;

    if (!$package_row) {
        http_response_code(404);
        echo "MPL package not found.";
        exit;
    }

    $package_ref = $package_row['reference_numb'];
    $package_ship_date = $package_row['ship_date'];
    $package_trailer = $package_row['trailer_name'];
    $package_status = $package_row['status'];

    $items_stmt = $connection->prepare("SELECT mplship.id, mplship.item_id, iii.unit_numb, iii.ficha, iii.description1, iii.description2, iii.quantity, iii.quantity_unit, iii.footage_quantity FROM mpl_shipping_list mplship INNER JOIN inventory_item_info iii ON mplship.item_id = iii.inventory_id WHERE mplship.reference_numb=? AND mplship.ship_date=? AND mplship.trailer_name=? AND mplship.status=? ORDER BY mplship.id ASC");
    $items_stmt->bind_param("isss", $package_ref, $package_ship_date, $package_trailer, $package_status);
    $items_stmt->execute();
    $items_result = $items_stmt->get_result();
    $package_items = [];
    while ($item = $items_result->fetch_assoc()) {
        $package_items[] = $item;
    }

    $available_items_stmt = $connection->prepare("SELECT iii.inventory_id, iii.unit_numb, iii.ficha, iii.description1, iii.description2 FROM inventory_item_info iii WHERE iii.location='internal' AND iii.inventory_id NOT IN (SELECT item_id FROM mpl_shipping_list WHERE reference_numb=? AND ship_date=? AND trailer_name=?) ORDER BY iii.inventory_id ASC");
    $available_items_stmt->bind_param("iss", $package_ref, $package_ship_date, $package_trailer);
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
    <title>Update Master Packing List</title>
</head>
<body>
    <?php include('../header_alt.php'); ?>
    <div class="dashboard-container">
        <div class="form-card-centered">
            <h1>Edit MPL Package</h1>
            <p class="form-instruction">Update package details and add/remove items before sending.</p>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'updated') { ?>
                <div class="status-banner status-success">Package details updated successfully.</div>
            <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'add-success') { ?>
                <div class="status-banner status-success">Item added to package.</div>
            <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'remove-success') { ?>
                <div class="status-banner status-success">Item removed from package.</div>
            <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'add-duplicate') { ?>
                <div class="status-banner status-warning">That item is already in this package.</div>
            <?php } elseif (isset($_GET['status']) && ($_GET['status'] === 'update-failed' || $_GET['status'] === 'add-failed' || $_GET['status'] === 'remove-failed')) { ?>
                <div class="status-banner status-warning">Action failed. Please try again.</div>
            <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'locked') { ?>
                <div class="status-banner status-warning">This package is no longer in draft status and cannot be edited.</div>
            <?php } ?>

            <form action="../library/cms_alt.php?id=<?php echo $id; ?>" method="POST" class="styled-form">
                <input type="hidden" name="package_id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="orig_ref_numb" value="<?php echo htmlspecialchars($package_ref); ?>">
                <input type="hidden" name="orig_ship_date" value="<?php echo htmlspecialchars($package_ship_date); ?>">
                <input type="hidden" name="orig_trailer" value="<?php echo htmlspecialchars($package_trailer); ?>">
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
                </div>

                <div class="form-footer-actions">
                    <a href="../mpl_items.php" class="cancel-link">Cancel</a>
                    <?php if ($package_status === 'draft') { ?>
                        <button type="submit" name="update_mpl_btn" class="btn">Update Package Details</button>
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
                                echo "<a href='../library/cms_alt.php?package_id=" . urlencode($id) . "&remove_mpl_item_id=" . urlencode($item['id']) . "' onclick=\"return confirm('Remove this item from package?')\">Remove</a>";
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
                    <form action="../library/cms_alt.php" method="POST" class="styled-form">
                        <input type="hidden" name="package_id" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="hidden" name="package_ref_numb" value="<?php echo htmlspecialchars($package_ref); ?>">
                        <input type="hidden" name="package_ship_date" value="<?php echo htmlspecialchars($package_ship_date); ?>">
                        <input type="hidden" name="package_trailer" value="<?php echo htmlspecialchars($package_trailer); ?>">
                        <input type="hidden" name="package_status" value="<?php echo htmlspecialchars($package_status); ?>">

                        <div class="form-group">
                            <label for="new_item_id">Internal Inventory Item</label>
                            <select name="new_item_id[]" required>
                                <option value="" disabled selected>Select item to add</option>
                                <?php
                                    if ($available_items_result && $available_items_result->num_rows > 0) {
                                        while ($available_item = $available_items_result->fetch_assoc()) {
                                            $available_description = trim(($available_item['description1'] ?? '') . ' ' . ($available_item['description2'] ?? ''));
                                            echo "<option value='" . htmlspecialchars($available_item['inventory_id']) . "'>" .
                                                htmlspecialchars($available_item['inventory_id']) . " | Unit " .
                                                htmlspecialchars($available_item['unit_numb']) . " | " .
                                                htmlspecialchars($available_description) .
                                            "</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-footer-actions">
                            <button type="submit" name="add_mpl_item_btn" class="btn">Add Item</button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>