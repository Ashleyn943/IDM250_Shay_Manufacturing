<?php
    require_once('db_connect.php');
    require_once('session_config.php');
    require_auth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Sku Management</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="icon" href="media/ShayIcon.png" type="image/x-icon">
</head>
<body>
    <?php include('header.php'); ?>
    <?php if (isset($_GET['status']) && in_array($_GET['status'], ['product-added', 'product-updated', 'product-deleted', 'failed'])) { ?>
        <div class="dashboard-container">
            <div class="status-banner status-success">
                <?php
                    if ($_GET['status'] === 'product-added') {
                        echo 'Product added successfully.';
                    } elseif ($_GET['status'] === 'product-updated') {
                        echo 'Product updated successfully.';
                    } elseif ($_GET['status'] === 'product-deleted') {
                        echo 'Product deleted successfully.';
                    } elseif ($_GET['status'] === 'failed') {
                        echo 'An error occurred. Please try again.';
                    }
                ?>
            </div>
        </div>
    <?php } ?>
    <div class="Products">
        <h1>Products</h1>
        <a href="APIs/product-new.php" class="btn">Add New Product</a>
    </div>
    <div class="table-container">
        <table class="data_tb">
            <tr>
                <th>Ficha</th>
                <th>Sku</th>
                <th>Description</th>
                <th>Unit of Measure</th>
                <th>Piece Count</th>
                <th>Length</th>
                <th>Width</th>
                <th>Height</th>
                <th>Weight</th>
                <th>Assembly</th>
                <th>Price Rate</th>
                <th>Actions</th>
            <?php
                $results = mysqli_query($connection, "SELECT p.*, pd.*, pt.* FROM products p LEFT JOIN products_dimensions pd ON p.id = pd.id LEFT JOIN products_types pt ON p.ficha = pt.ficha");
                    if($row = mysqli_num_rows($results)){
                        foreach($results as $row){
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['sku']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['uom_primary'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['piece_count'] ?? 0) . "</td>";
                            echo "<td>" . htmlspecialchars($row['length_inches'] ?? 0) . " in </td>";
                            echo "<td>" . htmlspecialchars($row['width_inches'] ?? 0) . " in </td>";
                            echo "<td>" . htmlspecialchars($row['height_inches'] ?? 0) . " in </td>";
                            echo "<td>" . htmlspecialchars($row['weight_lbs'] ?? 0) . " lb </td>";
                            echo "<td>" . htmlspecialchars($row['assembly'] ?? '') . "</td>";
                            echo "<td> $" . htmlspecialchars($row['rate'] ?? 0) . "</td>";
                            echo "<td> <a href='APIs/product-update.php?id=" . htmlspecialchars($row['id'] ?? 0) . "' class=''>Edit</a>
                            |
                            <a href='APIs/product-delete.php?id=" . htmlspecialchars($row['id'] ?? 0) . "' class=''>Delete</a></td>";
                            echo "</tr>";
                        }
                    };
            ?>
        </table>
    </div>
    <br><br>
</body>
</html>