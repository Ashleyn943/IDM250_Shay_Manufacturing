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

    $packages = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $package_key = implode('|', [
                $row['reference_numb'],
                $row['ship_date'],
                $row['trailer_name'],
                $row['status']
            ]);

            if (!isset($packages[$package_key])) {
                $packages[$package_key] = [
                    'reference_numb' => $row['reference_numb'],
                    'ship_date' => $row['ship_date'],
                    'trailer_name' => $row['trailer_name'],
                    'status' => $row['status'],
                    'items' => []
                ];
            }

            $packages[$package_key]['items'][] = $row;
        }
    }
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
        <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'sent') { ?>
            <div class="status-banner status-success">
                MPL item sent to other team. Status is now pending.
            </div>
        <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'accepted') { ?>
            <div class="status-banner status-success">
                MPL item accepted. Status is now accepted.
            </div>
        <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'send-failed') { ?>
            <div class="status-banner status-warning">
                Unable to send item. It may no longer be in draft status.
            </div>
        <?php } elseif (isset($_GET['status']) && $_GET['status'] === 'accept-failed') { ?>
            <div class="status-banner status-warning">
                Unable to accept item. It may no longer be in pending status.
            </div>
        <?php } ?>

        <div class="section-container">
            <h2>Quick Actions</h2>
            <div class="button-group">
                <a href="mpl.php" class="btn">Create New MPL</a>
            </div>
        </div>

        <div class="table-container">
            <h2>All Shipping Packages</h2>
            <table class="data_tb">
                <tr>
                    <th>Reference #</th>
                    <th>Ship Date</th>
                    <th>Trailer</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php
                    if (!empty($packages)) {
                        $package_index = 0;
                        foreach ($packages as $package) {
                            $detail_row_id = 'package-details-' . $package_index;
                            $package_first_item_id = $package['items'][0]['id'];

                            echo "<tr onclick=\"togglePackageDetails('" . $detail_row_id . "')\" style='cursor:pointer;'>";
                            echo "<td>" . htmlspecialchars($package['reference_numb']) . "</td>";
                            echo "<td>" . htmlspecialchars($package['ship_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($package['trailer_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($package['status']) . "</td>";
                            echo "<td>";
                            echo "<a href='APIs/mpl-update.php?id=" . urlencode($package_first_item_id) . "' onclick=\"event.stopPropagation();\">Edit</a>";
                            if (($package['status'] ?? '') === 'draft') {
                                echo " | <a href='library/cms.php?send_mpl_id=" . urlencode($package_first_item_id) . "' onclick=\"event.stopPropagation(); return confirm('Send this package to the other team?');\">Send</a>";
                            }
                            echo "</td>";
                            echo "</tr>";

                            echo "<tr id='" . $detail_row_id . "' style='display:none;'>";
                            echo "<td colspan='5'>";
                            echo "<table class='data_tb' style='margin-top:10px;'>";
                            echo "<tr>";
                            echo "<th>Unit #</th>";
                            echo "<th>Ficha</th>";
                            echo "<th>Description</th>";
                            echo "<th>Quantity</th>";
                            echo "<th>Qty Unit</th>";
                            echo "<th>Footage</th>";
                            echo "<th>Actions</th>";
                            echo "</tr>";

                            foreach ($package['items'] as $item) {
                                $description = trim(($item['description1'] ?? '') . ' ' . ($item['description2'] ?? ''));

                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($item['unit_numb']) . "</td>";
                                echo "<td>" . htmlspecialchars($item['ficha']) . "</td>";
                                echo "<td>" . htmlspecialchars($description) . "</td>";
                                echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
                                echo "<td>" . htmlspecialchars($item['quantity_unit']) . "</td>";
                                echo "<td>" . htmlspecialchars($item['footage_quantity']) . "</td>";
                                echo "<td>";
                                echo "<a href='APIs/mpl-delete.php?id=" . urlencode($item['id']) . "' onclick=\"return confirm('Delete this MPL item?')\">Delete</a>";

                                if (($item['status'] ?? '') === 'pending') {
                                    echo " | <a href='library/cms.php?accept_mpl_id=" . urlencode($item['id']) . "' onclick=\"return confirm('Mark this MPL item as accepted?')\">Accept</a>";
                                }

                                echo "</td>";
                                echo "</tr>";
                            }

                            echo "</table>";
                            echo "</td>";
                            echo "</tr>";

                            $package_index++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No MPL shipping records found.</td></tr>";
                    }
                ?>
            </table>
        </div>
    </div>
    <script>
        function togglePackageDetails(rowId) {
            const row = document.getElementById(rowId);
            if (!row) {
                return;
            }

            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>
</body>
</html>
