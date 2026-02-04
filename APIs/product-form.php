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
        <?php
            echo isset($_GET['id']) ? 'Edit Product' : 'Add New Product';
        ?>
        Product
    </h1>

    <?php
        require_once('db_connect.php');
        require_once('/.../library/auth.php');
        require_once('/.../library/cms.php');

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $product = $id ? get_product($id) : []; 

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($id) update_product($id, $_POST);
            else create_product($_POST);

            header('Location: index.php');
        }
    ?>

    <form method="POST">
        <div>
            <label for="name">Product Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo htmlspecialchars($product['description']) ?? ''; ?>" required>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" name="price" value="<?php echo htmlspecialchars($product['price']) ?? ''; ?>" step="0.01" required>
        </div>
        <div>
            <label for="sku">SKU:</label>
            <input type="text" name="sku" value="<?php echo htmlspecialchars($product['sku']) ?? ''; ?>" required>
        </div>
        <div>
            <button type="submit"><?php echo $id ? 'Update Product' : 'Add Product'; ?> Submit</button>
        </div>
    </form>
</body>
</html>