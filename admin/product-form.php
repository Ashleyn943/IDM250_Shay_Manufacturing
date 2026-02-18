<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo isset($_GET['ID']) ? 'Edit Product' : 'Add New Product'; ?></h1>

    <?php
    require '../CMS/cms.php';
    
    $id = isset($_GET['ID']) ? intval($_GET['ID']) : 0;
    $product = $id ? getProductById($id) : null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($id) update_product($id, $_POST);
        else add_product($_POST);

        header('Location: index.php');
    }
    ?>
    
    <form method="POST">
        <div class="form-control">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo $product['name'] ?? ''; ?>" required>
        </div>
        <div class="form-control">
            <label for="description">Descriptions</label>
            <textarea name="descriptions" required>
                <?php echo $product['descriptions'] ?? ''; ?>
            </textarea>
        </div>
        <div class="form-control">
            <label for="price">Base Price</label>
            <input type="number" step="0.01" name="price" id="price" value="<?php echo $product['price'] ?? ''; ?>" required>
        </div>
        <div class="form-control">
            <label for="sku">SKU</label>
            <input type="text" name="sku" id="sku" value="<?php echo $product['sku'] ?? ''; ?>" required>
        </div>
</body>
</html>