<?php
    require_once('db_connect.php');

    $sql = "SELECT 
                mplship.id,
                mplship.item_id,
                mplship.reference_numb,
                mplship.ship_date,
                mplship.trailer_name,
                mplship.status,
                iii.unit_numb,
                iii.ficha,
                iii.description1,
                iii.description2,
                iii.quantity,
                iii.quantity_unit,
                iii.footage_quantity
            FROM mpl_shipping_list mplship
            INNER JOIN inventory_item_info iii ON mplship.item_id = iii.inventory_id
            ORDER BY mplship.ship_date DESC, mplship.id DESC";

    $result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Packing List Items</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="icon" href="media/ShayIcon.png" type="image/x-icon">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="dashboard-container">
        <h1>Master Packing List Items</h1>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted') { ?>
            <div class="status-banner status-success">
                MPL item deleted successfully.
            </div>
        <?php } ?>

        <div class="section-container">
            <h2>Quick Actions</h2>
            <div class="button-group">
                <a href="mpl.php" class="btn">Create New MPL</a>
            </div>
        </div>

        <div class="table-container">
            <h2>All Shipping Records</h2>
            <table class="data_tb">
                <tr>
                    <th>ID</th>
                    <th>Item ID</th>
                    <th>Reference #</th>
                    <th>Ship Date</th>
                    <th>Trailer</th>
                    <th>Status</th>
                    <th>Unit #</th>
                    <th>Ficha</th>
                    <th>Description 1</th>
                    <th>Description 2</th>
                    <th>Quantity</th>
                    <th>Qty Unit</th>
                    <th>Footage</th>
                    <th>Actions</th>
                </tr>
                <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['item_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['reference_numb']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ship_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['trailer_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['unit_numb']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ficha']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description1']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description2']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity_unit']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['footage_quantity']) . "</td>";
                            echo "<td>";
                            echo "<a href='APIs/mpl-update.php?id=" . urlencode($row['id']) . "'>Edit</a> | ";
                            echo "<a href='APIs/mpl-delete.php?id=" . urlencode($row['id']) . "' onclick=\"return confirm('Delete this MPL item?')\">Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='14'>No MPL shipping records found.</td></tr>";
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
