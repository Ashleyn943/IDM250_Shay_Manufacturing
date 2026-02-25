<?php
    require_once('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Inventory</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="icon" href="media/ShayIcon.png" type="image/x-icon">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="dashboard-container">
        <h1>Warehouse Inventory</h1>

        <div class="stats-row">
            <div class="card">
                <h3>Total Items</h3>
                <p class="stat-number">--</p>
            </div>
            <div class="card">
                <h3>Pending Receipts</h3>
                <p class="stat-number">--</p>
            </div>
            <div class="card">
                <h3>Pending Shipments</h3>
                <p class="stat-number">--</p>
            </div>
        </div>

        <div class="section-container">
            <h2>Filters</h2>
            <form method="GET" class="form-grid">
                <div class="form-group">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search" placeholder="SKU, description, or ficha">
                </div>
                <div class="form-group">
                    <label for="warehouse">Warehouse</label>
                    <input type="text" id="warehouse" name="warehouse" placeholder="Main, East, West">
                </div>
                <div class="form-group">
                    <label for="bin">Bin / Rack</label>
                    <input type="text" id="bin" name="bin" placeholder="A1, B2, C3">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" id="status" name="status" placeholder="Available, Reserved, In Transit">
                </div>
                <div class="form-footer-actions full-width">
                    <a href="w_inventory.php" class="cancel-link">Reset</a>
                    <button type="submit" class="btn">Apply Filters</button>
                </div>
            </form>
        </div>

        <div class="section-container">
            <h2>Quick Actions</h2>
            <div class="button-group">
                <a href="#" class="btn">Receive Stock</a>
                <a href="#" class="btn">Create Pick List</a>
                <a href="#" class="btn">Transfer Stock</a>
            </div>
        </div>

        <div class="table-container">
            <h2>Warehouse Items</h2>
            <table class="data_tb">
                <tr>
                    <th>SKU</th>
                    <th>Unit Number</th>
                    <th>Ficha</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Footage</th>
                    <th>Warehouse</th>
                    <th>Bin</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td><a href="#">Edit</a></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>