<?php
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Origin: *');

    require_once('../db_connect.php');
    // require_once('/auth.php');

    // check_api_key($env);

    $method=$_SERVER['REQUEST_METHOD'];
    $id = intval(basename($_SERVER['REQUEST_URI']));

    //add new product
    if(isset($_POST['add_btn'])){
        $sku = $_POST['sku'];
        $ficha = $_POST['ficha'];
        $description = $_POST['description'];
        $rate = $_POST['rate'];
        $length_inches = $_POST['length_inches'];
        $width_inches = $_POST['width_inches'];
        $height_inches = $_POST['height_inches'];
        $weight_lbs = $_POST['weight_lbs'];
        $uom_primary = $_POST['uom_primary'];
        $piece_count = $_POST['piece_count'];
        $assembly = $_POST['assembly'];

        $stmt1 = $connection->prepare("INSERT INTO products (sku, ficha, description, rate) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param("iisd", $sku, $ficha, $description, $rate);
        $stmt2 = $connection->prepare("INSERT INTO products_dimensions (length_inches, width_inches, height_inches, weight_lbs) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("dddd", $length_inches, $width_inches, $height_inches, $weight_lbs);
        $stmt3 = $connection->prepare("INSERT INTO products_types (uom_primary, piece_count, assembly) VALUES (?, ?, ?)");
        $stmt3->bind_param("sis", $uom_primary, $piece_count, $assembly);
        
        if($stmt1->execute() && $stmt2->execute() && $stmt3->execute()){
            echo "Product added successfully";
            header("Location: ../index.php");
        } else {
            echo "Failed to add product";
        }
    };

    //update existing product
    if(isset($_POST['update_btn'])){
        $id = intval($_GET['id']);
        $sku = $_POST['sku'];
        $ficha = $_POST['ficha'];
        $description = $_POST['description'];
        $rate = $_POST['rate'];
        $length_inches = $_POST['length_inches'];
        $width_inches = $_POST['width_inches'];
        $height_inches = $_POST['height_inches'];
        $weight_lbs = $_POST['weight_lbs'];
        $uom_primary = $_POST['uom_primary'];
        $piece_count = $_POST['piece_count'];
        $assembly = $_POST['assembly'];

        $stmt1 = $connection->prepare("UPDATE products SET sku=?, ficha=?, description=?, rate=? WHERE id=$id");
        $stmt1->bind_param("iisd", $sku, $ficha, $description, $rate);
        $stmt2 = $connection->prepare("UPDATE products_dimensions SET length_inches=?, width_inches=?, height_inches=?, weight_lbs=? WHERE id=$id");
        $stmt2->bind_param("dddd", $length_inches, $width_inches, $height_inches, $weight_lbs);
        $stmt3 = $connection->prepare("UPDATE products_types SET uom_primary=?, piece_count=?, assembly=? WHERE id=$id");
        $stmt3->bind_param("sis", $uom_primary, $piece_count, $assembly);
        
        if($stmt1->execute() && $stmt2->execute() && $stmt3->execute()){
            echo "Product updated successfully";
            header("Location: ../index.php");
        } else {
            echo "Failed to update product";
        }
    };