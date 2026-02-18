<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p><a href="product-form.php">Add a New Product</a></p>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>

        <?php
        require '../CMS/cms.php';
        $products = getAllProducts();

        if ($products) ;
            foreach ($products as $product) ;
        ?>

        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['price']; ?></td>
            <td>
                <a href="edit-product.php?id=<?php echo $product['id']; ?>">Edit</a> 
                | 
                <a href="delete-product.php?id=<?php echo $product['id']; ?>">Delete</a></td>
        </tr>

    </table>
</body>
</html>