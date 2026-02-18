<?php
    require_once('../db_connect.php');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product | Shay Manufacturing</title>
    <link rel="stylesheet" href="../css/stylesheet.css"> 
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/normalize.css">

</head>
<body>
    <?php include('../header.php'); ?>
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
                        <label for="ficha">Ficha (ID)</label>
                        <input type="number" name="ficha" placeholder="e.g. 452" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Product Description</label>
                        <input type="text" name="description" placeholder="Material description..." required>
                    </div>

                    <div class="form-group">
                        <label for="uom_primary">Unit of Measure</label>
                        <input type="text" name="uom_primary" placeholder="PALLET / BUNDLE" required>
                    </div>
                    <div class="form-group">
                        <label for="piece_count">Piece Count</label>
                        <input type="number" name="piece_count" required>
                    </div>

                    <div class="form-group">
                        <label for="length_inches">Length (in)</label>
                        <input type="number" name="length_inches" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="width_inches">Width (in)</label>
                        <input type="number" name="width_inches" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="height_inches">Height (in)</label>
                        <input type="number" name="height_inches" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="weight_lbs">Weight (lbs)</label>
                        <input type="number" name="weight_lbs" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="assembly">Assembly Required?</label>
                        <input type="text" name="assembly" placeholder="TRUE / FALSE" required>
                    </div> 
                    <div class="form-group">
                        <label for="rate">Price Rate ($)</label>
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