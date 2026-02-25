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
    <a href="../mpl_items.php">Back to Master Packing List</a>
    <?php
    $result = mysqli_query($connection, "SELECT * FROM inventory_item_info iii INNER JOIN mpl_shipping_list mplship ON iii.inventory_id = mplship.item_id INNER JOIN products p ON iii.sku = p.sku");
    $row = mysqli_fetch_assoc($result);
    ?>
    <form method="POST">
        <div>
            <label for="sku">Sku:</label>
            <input type="number" name="sku" value="<?php echo htmlspecialchars($row['sku']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="unit_numb">Unit Number:</label>
            <input type="text" name="unit_numb" value="<?php echo htmlspecialchars($row['unit_numb']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="ficha">Ficha:</label>
            <input type="number" name="ficha" value="<?php echo htmlspecialchars($row['ficha']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="description1">Description 1:</label>
            <input type="text" name="description1" value="<?php echo htmlspecialchars($row['description1']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="description2">Description 2:</label>
            <input type="text" name="description2" value="<?php echo htmlspecialchars($row['description2']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="<?php echo htmlspecialchars($row['quantity']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="quantity_unit">Quantity Unit:</label>
            <input type="text" name="quantity_unit" value="<?php echo htmlspecialchars($row['quantity_unit']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="uom_primary">Unit of Measure:</label>
            <input type="text" name="uom_primary" value="<?php echo htmlspecialchars($row['uom_primary']) ?? ''; ?>" required>
        </div>
        </div> 
        <div>
            <label for="footage_quantity">Footage Quantity:</label>
            <input type="number" name="footage_quantity" step="0.01" value="<?php echo htmlspecialchars($row['footage_quantity']) ?? ''; ?>" required>
        </div>
        
        <div>
            <button type="submit" name="update_mpl_btn">Update Product</button>
        </div>
    </form>
</body>
</html>