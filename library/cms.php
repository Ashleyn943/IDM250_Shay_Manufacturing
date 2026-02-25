<?php
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Origin: *');

    require_once('./db_connect.php');
    // require_once('/auth.php');

    // check_api_key($env);

    $method=$_SERVER['REQUEST_METHOD'];
    $id = intval(basename($_SERVER['REQUEST_URI']));

    //add new product [sku table]
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
            $inserted_id = $connection->insert_id;
            header("Location: ../index.php");
        } else {
            echo "Failed to add product";
        }
    };

    //update existing product [sku table]
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

    //delete product


    //sending selected inventory items to shipping list
    if(isset($_POST['send_list'])) {
        $selected_items = isset($_POST['selected_items']) && !empty($_POST['selected_items']) ? $_POST['selected_items'] : [];
        $reference = $_POST['reference'];
        $date = $_POST['date'];
        $trailer = $_POST['truck'];

        if (!preg_match("/^[a-zA-Z0-9_]*$/", $trailer)) {
            echo "Only alphabets, numbers, and underscores are allowed for Trailer Name";
        } elseif (!preg_match("/^[0-9]+$/", $reference)) {
            echo "Only numbers are allowed for Reference Number";
        } else {
            foreach($selected_items as $key => $shipID){
                $stmt = $connection->prepare('INSERT INTO mpl_shipping_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, "draft")');
                $stmt->bind_param("iiss", $shipID, $reference, $date, $trailer);
                $stmt->execute();
                $stmt= $connection->prepare("UPDATE inventory_item_info SET `location`='warehouse' WHERE inventory_id=$shipID");
                $stmt->execute();
            }

            if($stmt->execute()){
                echo "Items sent to shipping list successfully";
            } else {
                echo "Failed to send items to shipping list";
            }
        };
    } 
    
    ///sending selected inventory items to order list
    if(isset($_POST['order_list'])) {
        $selected_items = isset($_POST['selected_items']) && !empty($_POST['selected_items']) ? $_POST['selected_items'] : [];
        $reference = $_POST['reference'];
        $date = $_POST['date'];
        $trailer = $_POST['truck'];

        if (!preg_match("/^[a-zA-Z0-9_]*$/", $trailer)) {
            echo "Only alphabets, numbers, and underscores are allowed for Trailer Name";
        } elseif (!preg_match("/^[0-9]+$/", $reference)) {
            echo "Only numbers are allowed for Reference Number";
        } else {
            foreach($selected_items as $key => $shipID){
                $stmt = $connection->prepare('INSERT INTO order_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, "draft")');
                $stmt->bind_param("iiss", $shipID, $reference, $date, $trailer);
                $stmt->execute();
            }

            if($stmt->execute()){
                echo "Items sent to order list successfully";
                
            } else {
                echo "Failed to send items to order list";
            }
        };
    };

