<?php
    require_once('../db_connect.php');
    //require_once('../library/auth.php');
    require_once('../library/cms_alt.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product | Shay Manufacturing</title>
    <link rel="stylesheet" href="../css/stylesheet.css"> 
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="icon" href="../media/ShayIcon.png" type="image/x-icon">
</head>
<body>
    <?php include('../header_alt.php'); ?>
    <div class="dashboard-container">
        <div class="form-card-centered">
            <h1>Add New Product</h1>
            <p class="form-instruction">Enter product details to add a new SKU to the manufacturing inventory.</p>

            <form action="../library/cms.php" method="POST" class="styled-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="sku">Product SKU</label>
                        <input type="number" name="sku" placeholder="e.g. 1720823" required>
                    </div>
                    <div class="form-group">
                        <label for="ficha">Ficha</label>
                        <input type="number" name="ficha" placeholder="e.g. 452" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" placeholder="Material description..." required>
                    </div>
                    <div class="form-group">
                        <label for="uom_primary">Unit of Measure</label>
                        <select name="uom_primary" required>
                            <option value="" disabled selected>Select unit</option>
                            <option value="PALLET">Pallet</option>
                            <option value="BUNDLE">Bundle</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="piece_count">Piece Count</label>
                        <input type="number" name="piece_count" required>
                    </div>
                    <div class="form-group">
                        <label for="length_inches">Length (inches)</label>
                        <input type="number" name="length_inches" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="width_inches">Width (inches)</label>
                        <input type="number" name="width_inches" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="height_inches">Height (inches)</label>
                        <input type="number" name="height_inches" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="weight_lbs">Weight (lbs)</label>
                        <input type="number" name="weight_lbs" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="assembly">Assembly</label>
                        <select name="assembly" required>
                            <option value="" disabled selected>Select unit</option>
                            <option value="TRUE">TRUE</option>
                            <option value="FALSE">FALSE</option>
                        </select>                    </div> 
                    <div class="form-group">
                        <label for="rate">Price Rate</label>
                        <input type="number" name="rate" step="0.01" required>
                    </div>
                </div>

                <div class="form-footer-actions">
                    <a href="../index.php" class="cancel-link">Cancel</a>
                    <button type="submit" name="add_btn" class="btn">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>