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
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Table Practice</title>
</head>
<body>
    <h1>
        Edit Product
    </h1>
    <a href="../index.php">Back</a>
    <?php
    $result = mysqli_query($connection, "SELECT * FROM products p INNER JOIN products_dimensions pd ON p.id = pd.id INNER JOIN products_types pt ON p.id = pt.id");
    $row = mysqli_fetch_assoc($result);
    ?>
    <form method="POST">
        <div>
            <label for="sku">Product Sku:</label>
            <input type="number" name="sku" value="<?php echo htmlspecialchars($row['sku']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="ficha">Ficha:</label>
            <input type="number" name="ficha" value="<?php echo htmlspecialchars($row['ficha']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo htmlspecialchars($row['description']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="uom_primary">Unit of Measure:</label>
            <input type="text" name="uom_primary" value="<?php echo htmlspecialchars($row['uom_primary']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="piece_count">Piece Count:</label>
            <input type="number" name="piece_count" value="<?php echo htmlspecialchars($row['piece_count']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="length_inches">Length (inches):</label>
            <input type="number" name="length_inches" step="0.01" value="<?php echo htmlspecialchars($row['length_inches']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="width_inches">Width (inches):</label>
            <input type="number" name="width_inches" step="0.01" value="<?php echo htmlspecialchars($row['width_inches']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="height_inches">Height (inches):</label>
            <input type="number" name="height_inches" step="0.01" value="<?php echo htmlspecialchars($row['height_inches']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="weight_lbs">Weight (lbs):</label>
            <input type="number" name="weight_lbs" step="0.01" value="<?php echo htmlspecialchars($row['weight_lbs']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="assembly">Assembly:</label>
            <input type="text" name="assembly" value="<?php echo htmlspecialchars($row['assembly']) ?? ''; ?>" required>
        </div> 
        <div>
            <label for="rate">Price Rate:</label>
            <input type="number" name="rate" step="0.01" value="<?php echo htmlspecialchars($row['rate']) ?? ''; ?>" required>
        </div>
        
        <div>
            <button type="submit" name="update_btn">Update Product</button>
        </div>
    </form>
</body>
</html>