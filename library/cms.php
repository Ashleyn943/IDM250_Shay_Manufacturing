<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Origin: *');

    require_once(__DIR__ .  '/../db_connect.php');
    // require_once('/auth.php');

    // check_api_key($env);

    $method=$_SERVER['REQUEST_METHOD'];
    $id = intval(basename($_SERVER['REQUEST_URI']));

    //add new product [SKU Management]
    if(isset($_POST['add_btn'])){
        $sku = intval($_POST['sku']);
        $ficha = htmlspecialchars($_POST['ficha']);
        $description = htmlspecialchars($_POST['description']);
        $rate = floatval($_POST['rate']);
        $length_inches = intval($_POST['length_inches']);
        $width_inches = intval($_POST['width_inches']);
        $height_inches = intval($_POST['height_inches']);
        $weight_lbs = intval($_POST['weight_lbs']);
        $uom_primary = htmlspecialchars($_POST['uom_primary']);
        $piece_count = intval($_POST['piece_count']);
        $assembly = htmlspecialchars($_POST['assembly']);

        $stmt1 = $connection->prepare("INSERT INTO products (sku, ficha, description, rate) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param("issd", $sku, $ficha, $description, $rate);
        $stmt2 = $connection->prepare("INSERT INTO products_dimensions (length_inches, width_inches, height_inches, weight_lbs) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("dddd", $length_inches, $width_inches, $height_inches, $weight_lbs);
        $stmt3 = $connection->prepare("INSERT INTO products_types (ficha, uom_primary, piece_count, assembly) VALUES (?, ?, ?, ?)");
        $stmt3->bind_param("ssis", $ficha, $uom_primary, $piece_count, $assembly);
        
        if($stmt1->execute() && $stmt2->execute() && $stmt3->execute()){
            $inserted_id = $connection->insert_id;
            header("Location: ../sku_management.php?status=success_new");
        } else {
            header("Location: ../sku_management.php?status=failed");
        }
    };

    //update existing product [SKU Management]
    if(isset($_POST['update_btn'])){
        $id = intval($_GET['id']);
        $sku = intval($_POST['sku']);
        $ficha = htmlspecialchars($_POST['ficha']);
        $description = htmlspecialchars($_POST['description']);
        $rate = floatval($_POST['rate']);
        $length_inches = intval($_POST['length_inches']);
        $width_inches = intval($_POST['width_inches']);
        $height_inches = intval($_POST['height_inches']);
        $weight_lbs = intval($_POST['weight_lbs']);
        $uom_primary = htmlspecialchars($_POST['uom_primary']);
        $piece_count = intval($_POST['piece_count']);
        $assembly = htmlspecialchars($_POST['assembly']);

        $stmt1 = $connection->prepare("UPDATE products SET sku=?, ficha=?, description=?, rate=? WHERE id=$id");
        $stmt1->bind_param("issd", $sku, $ficha, $description, $rate);
        $stmt2 = $connection->prepare("UPDATE products_dimensions SET length_inches=?, width_inches=?, height_inches=?, weight_lbs=? WHERE id=$id");
        $stmt2->bind_param("dddd", $length_inches, $width_inches, $height_inches, $weight_lbs);
        $stmt3 = $connection->prepare("UPDATE products_types SET ficha=?, uom_primary=?, piece_count=?, assembly=? WHERE id=$id");
        $stmt3->bind_param("ssis", $ficha, $uom_primary, $piece_count, $assembly);
        
        if($stmt1->execute() && $stmt2->execute() && $stmt3->execute()){
            header("Location: ../sku_management.php?status=success_update");
        } else {
            header("Location: ../sku_management.php?status=failed");
        }
    };

    //delete product [SKU Management]
    if(isset($_POST['delete_id']) || isset($_POST['delete_btn'])) {
        $id = isset($_GET['delete_id']) ? intval($_GET['delete_id']) : intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo "Failed to delete product";
            exit;
        }

        $stmt1 = $connection->prepare("DELETE FROM products_dimensions WHERE id = ?");
        $stmt1->bind_param("i", $id);

        $stmt2 = $connection->prepare("DELETE FROM products_types WHERE id = ?");
        $stmt2->bind_param("i", $id);

        $stmt3 = $connection->prepare("DELETE FROM products WHERE id =?");
        $stmt3->bind_param("i", $id);

        if($stmt1->execute() && $stmt2->execute() && $stmt3->execute()){
            header("Location: ../sku_management.php?status=success_delete");
            exit;
        } else {
            header("Location: ../sku_management.php?status=failed");
            exit;
        }
    }


    //sending selected inventory items to MPL 
   $is_mpl_submit = isset($_POST['send_list']) && (isset($_POST['reference']) && isset($_POST['date']) && isset($_POST['truck']));
    if($is_mpl_submit){
        $selected_items = isset($_POST['selected_items']) && !empty($_POST['selected_items']) ? $_POST['selected_items'] : [];
        $reference = isset($_POST['reference']) ? intval($_POST['reference']) : 0;
        $date = isset($_POST['date']) ? $_POST['date'] : null;
        $trailer = isset($_POST['truck']) ? $_POST['truck'] : '';

        if (!empty($selected_items) && $reference && $date && $trailer) {
            $insert = $connection->prepare(
                "INSERT INTO mpl_shipping_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, 'draft')"
            );
            foreach($selected_items as $shipID){
                $item_id = intval($shipID);
                $insert->bind_param("iiss", $item_id, $reference, $date, $trailer);
                $insert->execute();

                $sql = $connection->prepare("UPDATE inventory_item_info SET `location`='on-route' WHERE inventory_id=$item_id");
                $sql->execute();
            };
            mysqli_query($connection, $sql);
            header("Location: ../mpl.php?status=success");
            exit;
        } else {
            header("Location: ../mpl.php?status=missing");
            exit;
        }
    };

    //update mpl item details
    if(isset($_POST['update_mpl_btn'])){
        $id = intval($_GET['id']);
        $reference = $_POST['ref_numb'];
        $ship_date = $_POST['ship_date'];
        $trailer = $_POST['truck'];

        $stmt = $connection->prepare("UPDATE mpl_shipping_list SET reference_numb=?, ship_date=?, trailer_name=? WHERE id=$id");
        $stmt->bind_param("iss", $reference, $ship_date, $trailer);
        
        if($stmt->execute()){
            echo "Item details updated successfully";
            header("Location: ../mpl_items.php");
        } else {
            echo "Failed to update item details";
        }
    };
    
    ///sending selected MPL items to order list
    $is_order_submit = isset($_POST['order_list']) && (isset($_POST['reference']) && isset($_POST['date']) && isset($_POST['truck']) && isset($_POST['address']) && isset($_POST['zip']) && isset($_POST['city']) && isset($_POST['state']));
        if($is_order_submit) {
            $selected_items = isset($_POST['selected_items']) && !empty($_POST['selected_items']) ? $_POST['selected_items'] : [];
            $reference = isset($_POST['reference']) ? intval($_POST['reference']) : 0;
            $date = isset($_POST['date']) ? $_POST['date'] : null;
            $trailer = isset($_POST['truck']) ? $_POST['truck'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $zip = isset($_POST['zip']) ? intval($_POST['zip']) : 0;
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $state = isset($_POST['state']) ? $_POST['state'] : '';

            if (!preg_match("/^[a-zA-Z0-9_]*$/", $trailer)) {
                echo "Only alphabets, numbers, and underscores are allowed for Trailer Name";
            } elseif (!preg_match("/^[0-9]+$/", $reference)) {
                echo "Only numbers are allowed for Reference Number";
            } else {
                foreach($selected_items as $key => $shipID){
                    $stmt = $connection->prepare('INSERT INTO order_list (item_id, reference_numb, ship_date, trailer_name, address, zip_code, city, state, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, "draft")');
                    $stmt->bind_param("iisssiss", $shipID, $reference, $date, $trailer, $address, $zip, $city, $state);
                    $stmt->execute();

                    $stmt= $connection->prepare("UPDATE inventory_item_info SET `location`='shipping' WHERE inventory_id=$shipID");
                    $stmt->execute();
                }

                if($stmt->execute()){
                    header("Location: ../orders.php?status=success");
                } else {
                    header("Location: ../orders.php?status=missing");
                }
            };
        };
    

