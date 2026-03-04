<?php
    require_once('db_connect.php');
    // require_once('library/auth.php');
    require_once('library/cms.php');
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
    <title>Order List</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="dashboard-container">
        <h1>Order List Items</h1>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'removed') { ?>
            <div class="status-banner status-success">
                Order item(s) removed successfully.
            </div>
        <?php } ?>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'sent') { ?>
            <div class="status-banner status-success">
                Order item(s) sent successfully.
            </div>
        <?php } ?>

        <div class="section-container">
            <h2>Actions</h2>
            <div class="button-group">
                <a href="order.php" class="btn">Create New Order</a>
                <a href="APIs/api-orders.php" class="btn">Send Order</a>
            </div>
        </div>

        <div class="table-container">
            <h2>All Order List Records</h2>
            <form method="POST">
                <table class="data_tb">
                    <tr>
                        <th>SKU</th>
                        <th>Unit Number</th>
                        <th>Ficha</th>
                        <th>Description 1</th>
                        <th>Description 2</th>
                        <th>Quantity</th>
                        <th>Quantity Unit</th>
                        <th>Footage Quantity</th>
                        <th>UOM</th>
                        <th>Reference Number</th>
                        <th>Ship Date</th>
                        <th>Trailer Name</th>   
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        $stmt = $connection->prepare("SELECT iii.*, ordership.*, pt.uom_primary FROM inventory_item_info iii INNER JOIN order_list ordership ON iii.inventory_id = ordership.item_id INNER JOIN products_types pt ON iii.ficha = pt.ficha WHERE iii.location = 'shipping'");
                        $stmt->execute();
                        $result = $stmt->get_result();
                            if($result->num_rows > 0){
                                foreach($result as $row){
                                    $stmt->execute();
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['sku'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['description1'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['description2'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['quantity_unit'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['footage_quantity'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['uom_primary'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['reference_numb'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['ship_date'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['trailer_name'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['status'] ?? '') . "</td>";
                                    echo "<td> <a onClick='return confirm(\"Are you sure you want to remove this item from the Order List?\")' href='APIs/orders-delete.php?id=" . htmlspecialchars($row['id'] ?? 0) . "' name='delete-order'>Delete</a></td>";
                                    echo "</tr>";
                                }   
                            }
                    ?>
                </table>
            </form>
        </div>
    </div>
</body>
</html>