<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Origin: *');

    require_once('../db_connect.php');
    // require_once('/auth.php');

    // check_api_key($env);

    $method=$_SERVER['REQUEST_METHOD'];
    $id = intval(basename($_SERVER['REQUEST_URI']));

    //add new product [sku table]
    if(isset($_POST['add_btn'])){
        $sku = htmlspecialchars($_POST['sku']);
        $ficha = htmlspecialchars($_POST['ficha']);
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
            header("Location: ../sku_management.php?status=product-added");
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
            header("Location: ../sku_management.php?status=product-updated");
        } else {
            echo "Failed to update product";
        }
    };

    //delete product
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
            echo "Product deleted successfully";
            header("Location: ../sku_management.php?status=product-deleted");
            exit;
        } else {
            echo "Failed to delete product";
        }
    }


    //sending selected inventory items to shipping list
   $is_mpl_submit = isset($_POST['send_list']) || (isset($_POST['reference']) && isset($_POST['date']) && isset($_POST['truck']));
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
            };
            header("Location: ../mpl.php?status=success");
            exit;
        } else {
            header("Location: ../mpl.php?status=missing");
            exit;
        }
    };

    //update MPL package details (draft only)
    if(isset($_POST['update_mpl_btn'])){
        $package_id = intval($_POST['package_id'] ?? ($_GET['id'] ?? 0));
        $reference = intval($_POST['ref_numb'] ?? 0);
        $ship_date = $_POST['ship_date'] ?? '';
        $trailer = trim($_POST['truck'] ?? '');
        $orig_reference = intval($_POST['orig_ref_numb'] ?? 0);
        $orig_ship_date = $_POST['orig_ship_date'] ?? '';
        $orig_trailer = $_POST['orig_trailer'] ?? '';
        $package_status = $_POST['package_status'] ?? '';

        if ($package_id <= 0 || $reference <= 0 || $ship_date === '' || $trailer === '') {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=update-failed");
            exit;
        }

        if ($package_status !== 'draft') {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=locked");
            exit;
        }

        $stmt = $connection->prepare("UPDATE mpl_shipping_list SET reference_numb=?, ship_date=?, trailer_name=? WHERE reference_numb=? AND ship_date=? AND trailer_name=? AND status='draft'");
        $stmt->bind_param("ississ", $reference, $ship_date, $trailer, $orig_reference, $orig_ship_date, $orig_trailer);
        
        if($stmt->execute()){
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=updated");
            exit;
        } else {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=update-failed");
            exit;
        }
    };

    //add item to MPL package (draft only)
    if (isset($_POST['add_mpl_item_btn'])) {
        $package_id = intval($_POST['package_id'] ?? 0);
        $new_item_id = intval($_POST['new_item_id'] ?? 0);
        $reference = intval($_POST['package_ref_numb'] ?? 0);
        $ship_date = $_POST['package_ship_date'] ?? '';
        $trailer = $_POST['package_trailer'] ?? '';
        $package_status = $_POST['package_status'] ?? '';

        if ($package_id <= 0 || $new_item_id <= 0 || $reference <= 0 || $ship_date === '' || $trailer === '') {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=add-failed");
            exit;
        }

        if ($package_status !== 'draft') {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=locked");
            exit;
        }

        $check_stmt = $connection->prepare("SELECT id FROM mpl_shipping_list WHERE item_id=? AND reference_numb=? AND ship_date=? AND trailer_name=? LIMIT 1");
        $check_stmt->bind_param("iiss", $new_item_id, $reference, $ship_date, $trailer);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result && $check_result->num_rows > 0) {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=add-duplicate");
            exit;
        }

        $insert_stmt = $connection->prepare("INSERT INTO mpl_shipping_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, 'draft')");
        $insert_stmt->bind_param("iiss", $new_item_id, $reference, $ship_date, $trailer);

        if ($insert_stmt->execute()) {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=add-success");
            exit;
        }

        header("Location: ../APIs/mpl-update.php?id=$package_id&status=add-failed");
        exit;
    }

    //remove item from MPL package (draft only)
    if (isset($_POST['remove_mpl_item_btn'])) {
        $package_id = intval($_POST['package_id'] ?? 0);
        $mpl_item_id = intval($_POST['mpl_item_id'] ?? 0);
        $package_status = $_POST['package_status'] ?? '';

        if ($package_id <= 0 || $mpl_item_id <= 0) {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=remove-failed");
            exit;
        }

        if ($package_status !== 'draft') {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=locked");
            exit;
        }

        $stmt = $connection->prepare("DELETE FROM mpl_shipping_list WHERE id=? AND status='draft'");
        $stmt->bind_param("i", $mpl_item_id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=remove-success");
            exit;
        }

        header("Location: ../APIs/mpl-update.php?id=$package_id&status=remove-failed");
        exit;
    }

    //remove item from MPL package via link (draft only)
    if (isset($_GET['remove_mpl_item_id'])) {
        $package_id = intval($_GET['package_id'] ?? 0);
        $mpl_item_id = intval($_GET['remove_mpl_item_id'] ?? 0);

        if ($package_id <= 0 || $mpl_item_id <= 0) {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=remove-failed");
            exit;
        }

        $stmt = $connection->prepare("DELETE FROM mpl_shipping_list WHERE id=? AND status='draft'");
        $stmt->bind_param("i", $mpl_item_id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=remove-success");
            exit;
        }

        header("Location: ../APIs/mpl-update.php?id=$package_id&status=remove-failed");
        exit;
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

                    $stmt= $connection->prepare("UPDATE inventory_item_info SET `location`='shipping' WHERE inventory_id=$shipID");
                    $stmt->execute();
                }

                if($stmt->execute()){
                    echo "Items sent to order list successfully";
                    header("Location: ../order_items.php");
                } else {
                    echo "Failed to send items to order list";
                }
            };
        };
    

