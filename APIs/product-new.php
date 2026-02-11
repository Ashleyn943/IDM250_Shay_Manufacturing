<?php
    require_once('../db_connect.php');
    //require_once('../library/auth.php');
    require_once('../library/cms.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
</head>
<body>
    <h1>Add New Product:</h1>
    <div>
        <form action="../library/cms.php" method="POST">
            <div>
                <label for="sku">Product Sku:</label>
                <input type="number" name="sku" required>
            </div>
            <div>
                <label for="ficha">Ficha:</label>
                <input type="number" name="ficha" required>
            </div>
            <div>
                <label for="description">Description:</label>
                <input type="text" name="description" required>
            </div>
            <div>
                <label for="uom_primary">Unit of Measure:</label>
                <input type="text" name="uom_primary" required>
            </div>
            <div>
                <label for="piece_count">Piece Count:</label>
                <input type="number" name="piece_count" required>
            </div>
            <div>
                <label for="length_inches">Length (inches):</label>
                <input type="number" name="length_inches" step="0.01" required>
            </div>
            <div>
                <label for="width_inches">Width (inches):</label>
                <input type="number" name="width_inches" step="0.01" required>
            </div>
            <div>
                <label for="height_inches">Height (inches):</label>
                <input type="number" name="height_inches" step="0.01" required>
            </div>
            <div>
                <label for="weight_lbs">Weight (lbs):</label>
                <input type="number" name="weight_lbs" step="0.01" required>
            </div>
            <div>
                <label for="assembly">Assembly:</label>
                <input type="text" name="assembly" required>
            </div> 
            <div>
                <label for="rate">Price Rate:</label>
                <input type="number" name="rate" step="0.01" required>
            </div>
            <button type="submit" name="add_btn">Add Product</button>
        </form>
    </div>
</body>
</html>