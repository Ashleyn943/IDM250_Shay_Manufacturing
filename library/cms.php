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
        $package_id = mt_rand(100000, 999999); // Generate a random package ID

        if (!empty($selected_items) && $reference && $date && $trailer && $package_id) {
            $insert = $connection->prepare(
                "INSERT INTO mpl_shipping_list (item_id, package_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, ?, 'draft')"
            );
            foreach($selected_items as $shipID){
                $item_id = intval($shipID);
                $insert->bind_param("iiiss", $item_id, $package_id, $reference, $date, $trailer);
                $insert->execute();

                $sql = $connection->prepare("UPDATE inventory_item_info SET `location`='pending' WHERE inventory_id=$item_id");
                $sql->execute();
            };
            header("Location: ../mpl.php?status=success");
            exit;
        } else {
            header("Location: ../mpl.php?status=missing");
            exit;
        }
    };

    //send MPL item to other team (draft -> pending)
    if (isset($_POST['send_mpl_btn'])) {
        $mpl_id = intval($_POST['mpl_id'] ?? 0);

        if ($mpl_id <= 0) {
            header("Location: ../mpl_items.php?status=send-failed");
            exit;
        }

        $package_stmt = $connection->prepare("SELECT reference_numb, ship_date, trailer_name FROM mpl_shipping_list WHERE id=? AND status='draft' LIMIT 1");
        $package_stmt->bind_param("i", $mpl_id);
        $package_stmt->execute();
        $package_result = $package_stmt->get_result();
        $package = $package_result ? $package_result->fetch_assoc() : null;

        if (!$package) {
            header("Location: ../mpl_items.php?status=send-failed");
            exit;
        }

        $stmt = $connection->prepare("UPDATE mpl_shipping_list SET status='pending' WHERE reference_numb=? AND ship_date=? AND trailer_name=? AND status='draft'");
        $stmt->bind_param("iss", $package['reference_numb'], $package['ship_date'], $package['trailer_name']);
        $stmt->execute();
        
        $stmt = $connection->prepare("UPDATE inventory_item_info iii INNER JOIN mpl_shipping_list mplship ON iii.inventory_id = mplship.item_id SET iii.location='warehouse' WHERE iii.inventory_id=? AND mplship.status='draft'");
        $stmt->bind_param("i", $package['item_id']);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../mpl_items.php?status=sent");
        } else {
            header("Location: ../mpl_items.php?status=send-failed");
        }
        exit;
    }

    //send MPL item to other team via link (draft -> pending)
    if (isset($_GET['send_mpl_id'])) {
        $mpl_id = intval($_GET['send_mpl_id']);

        if ($mpl_id <= 0) {
            header("Location: ../mpl_items.php?status=send-failed");
            exit;
        }

        $package_stmt = $connection->prepare("SELECT reference_numb, ship_date, trailer_name FROM mpl_shipping_list WHERE id=? AND status='draft' LIMIT 1");
        $package_stmt->bind_param("i", $mpl_id);
        $package_stmt->execute();
        $package_result = $package_stmt->get_result();
        $package = $package_result ? $package_result->fetch_assoc() : null;

        if (!$package) {
            header("Location: ../mpl_items.php?status=send-failed");
            exit;
        }
        $stmt = $connection->prepare("UPDATE inventory_item_info iii INNER JOIN mpl_shipping_list mplship ON iii.inventory_id = mplship.item_id SET iii.location='warehouse' WHERE iii.inventory_id=? AND mplship.status='draft'");
        $stmt->bind_param("i", $package['item_id']);
        $stmt->execute();
        
        $stmt = $connection->prepare("UPDATE mpl_shipping_list SET status='pending' WHERE reference_numb=? AND ship_date=? AND trailer_name=? AND status='draft'");
        $stmt->bind_param("iss", $package['reference_numb'], $package['ship_date'], $package['trailer_name']);
    
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../mpl_items.php?status=sent");
        } else {
            header("Location: ../mpl_items.php?status=send-failed");
        }
        exit;
    }

    //accept MPL item (pending -> accepted)
    if (isset($_POST['accept_mpl_btn'])) {
        $mpl_id = intval($_POST['mpl_id'] ?? 0);
        $sql = $connection->prepare("SELECT package_id FROM mpl_shipping_list WHERE id=? LIMIT 1");
        $sql->bind_param("i", $mpl_id);
        $sql->execute();
        $result = $sql->get_result();
        if ($result && $result->num_rows > 0) {
            $package = $result->fetch_assoc();
            $package_id = $package['package_id'];
        } else {
            echo "Order package not found";
            exit;
        }

        if ($mpl_id <= 0) {
            header("Location: ../mpl_items.php?status=accept-failed");
            exit;
        }

        foreach ($package_id as $id) {
            $stmt = $connection->prepare("UPDATE mpl_shipping_list SET status='accepted' WHERE id=? AND status='pending'");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        
            $stmt = $connection->prepare("UPDATE inventory_item_info iii INNER JOIN mpl_shipping_list mplship ON iii.inventory_id = mplship.item_id SET iii.location='warehouse' WHERE iii.inventory_id=? AND mplship.status='draft'");
            $stmt->bind_param("i", $package['item_id']);

            if ($stmt->execute() && $stmt->affected_rows > 0) {
                header("Location: ../mpl_items.php?status=accepted");
            } else {
                header("Location: ../mpl_items.php?status=accept-failed");
            }
            exit;
        }
    }

    //accept MPL item via link (pending -> accepted)
    if (isset($_GET['accept_mpl_id'])) {
        $mpl_id = intval($_GET['accept_mpl_id']);
        $sql = $connection->prepare("SELECT package_id FROM mpl_shipping_list WHERE id=? LIMIT 1");
        $sql->bind_param("i", $mpl_id);
        $sql->execute();
        $result = $sql->get_result();
        if ($result && $result->num_rows > 0) {
            $package = $result->fetch_assoc();
            $package_id = $package['package_id'];
        } else {
            echo "Order package not found";
            exit;
        }

        if ($mpl_id <= 0) {
            header("Location: ../mpl_items.php?status=accept-failed");
            exit;
        }
        
        foreach ($package_id as $id) {
            $stmt = $connection->prepare("UPDATE mpl_shipping_list SET status='accepted' WHERE id=? AND status='pending'");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            $stmt = $connection->prepare("UPDATE inventory_item_info iii INNER JOIN mpl_shipping_list mplship ON iii.inventory_id = mplship.item_id SET iii.location='warehouse' WHERE iii.inventory_id=? AND mplship.status='draft'");
            $stmt->bind_param("i", $package['item_id']);

            if ($stmt->execute() && $stmt->affected_rows > 0) {
                header("Location: ../mpl_items.php?status=accepted");
            } else {
                header("Location: ../mpl_items.php?status=accept-failed");
            }
            exit;
        }
    }

    //add item to MPL package (draft only)
    if (isset($_POST['add_mpl_item_btn'])) {
        $package_id = intval($_POST['package_id'] ?? 0);
        $new_item_id = isset($_POST['new_item_id']) ? $_POST['new_item_id'] : 0;
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

        foreach ($new_item_id as $item_id) {
             // Check for duplicate item in the same package
            $check_stmt = $connection->prepare("SELECT id FROM mpl_shipping_list WHERE item_id=? AND reference_numb=? AND ship_date=? AND trailer_name=? LIMIT 1");
            $check_stmt->bind_param("iiss", $item_id, $reference, $ship_date, $trailer);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
        }

        if ($check_result && $check_result->num_rows > 0) {
            header("Location: ../APIs/mpl-update.php?id=$package_id&status=add-duplicate");
            exit;
        }

        foreach ($new_item_id as $item_id) {
            $insert_stmt = $connection->prepare("INSERT INTO mpl_shipping_list (item_id, reference_numb, ship_date, trailer_name, status) VALUES (?, ?, ?, ?, 'draft')");
            $insert_stmt->bind_param("iiss", $item_id, $reference, $ship_date, $trailer);
        }

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

    //update mpl item details
    if(isset($_POST['update_mpl_btn'])){
        $id = intval($_POST['new_item_id[]'] ?? 0);
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
            $package_id = mt_rand(100000, 999999); // Generate a random package ID

            if (!preg_match("/^[a-zA-Z0-9_]*$/", $trailer)) {
                echo "Only alphabets, numbers, and underscores are allowed for Trailer Name";
            } elseif (!preg_match("/^[0-9]+$/", $reference)) {
                echo "Only numbers are allowed for Reference Number";
            } else {
                foreach($selected_items as $key => $shipID){
                    $stmt = $connection->prepare('INSERT INTO order_list (item_id, package_id, reference_numb, ship_date, trailer_name, address, zip_code, city, state, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, "draft")');
                    $stmt->bind_param("iiisssiss", $shipID, $package_id, $reference, $date, $trailer, $address, $zip, $city, $state);
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
    
    //send order list to other team (draft -> pending)
    if (isset($_POST['send_order_btn'])) {
        $order_id = intval($_GET['id']);

        if ($order_id <= 0) {
            header("Location: ../order_items.php?status=send-failed");
            exit;
        }

        $package_stmt = $connection->prepare("SELECT reference_numb, ship_date, trailer_name, address, zip_code, city, state FROM order_list WHERE package_id=? AND status='draft' LIMIT 1");
        $package_stmt->bind_param("i", $$order_id);
        $package_stmt->execute();
        $package_result = $package_stmt->get_result();
        $package = $package_result ? $package_result->fetch_assoc() : null;

        if (!$package) {
            header("Location: ../order_items.php?status=send-failed");
            exit;
        }

        $stmt = $connection->prepare("UPDATE order_list SET status='pending' WHERE reference_numb=? AND ship_date=? AND trailer_name=? AND address=? AND zip_code=? AND city=? AND state=? AND status='draft'");
        $stmt->bind_param("isssiss", $package['reference_numb'], $package['ship_date'], $package['trailer_name'], $package['address'], $package['zip_code'], $package['city'], $package['state']);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../order_items.php?status=sent");
        } else {
            header("Location: ../order_items.php?status=send-failed");
        }
        exit;
    }

    //send order list to other team via link (draft -> pending)
    if (isset($_GET['send_order_id'])) {
        $order_id = intval($_GET['send_order_id']);

        if ($order_id <= 0) {
            header("Location: ../order_items.php?status=send-failed");
            exit;
        }

        $sql = $connection->prepare("SELECT package_id FROM order_list WHERE id=? LIMIT 1");
        $sql->bind_param("i", $order_id);
        $sql->execute();
        $result = $sql->get_result();
        if ($result && $result->num_rows > 0) {
            $package = $result->fetch_assoc();
            $package_id = $package['package_id'];
        } else {
            echo "Order package not found";
            exit;
        }


        $package_stmt = $connection->prepare("SELECT reference_numb, ship_date, trailer_name, address, zip_code, city, state FROM order_list WHERE id=? AND status='draft' LIMIT 1");
        $package_stmt->bind_param("i", $order_id);
        $package_stmt->execute();
        $package_result = $package_stmt->get_result();
        $package = $package_result ? $package_result->fetch_assoc() : null;

        if (!$package) {
            header("Location: ../order_items.php?status=send-failed");
            exit;
        }

        $stmt = $connection->prepare("UPDATE order_list SET status='pending' WHERE reference_numb=? AND ship_date=? AND trailer_name=? AND address=? AND zip_code=? AND city=? AND state=? AND status='draft'");
        $stmt->bind_param("isssiss", $package['reference_numb'], $package['ship_date'], $package['trailer_name'], $package['address'], $package['zip_code'], $package['city'], $package['state']);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../APIs/api_orders_send.php?order_id=$order_id");
            header("Location: ../order_items.php?status=sent");
        } else {
            header("Location: ../order_items.php?status=send-failed");
        }
        exit;
    }

    //accept Order item (pending -> accepted)
    if (isset($_POST['accept_order_btn'])) {
        $order_id = intval($_POST['order_id'] ?? 0);
        $sql = $connection->prepare("SELECT package_id FROM order_list WHERE id=? LIMIT 1");
        $sql->bind_param("i", $order_id);
        $sql->execute();
        $result = $sql->get_result();
        if ($result && $result->num_rows > 0) {
            $package = $result->fetch_assoc();
            $package_id = $package['package_id'];
        } else {
            echo "Order package not found";
            exit;
        }

        if ($order_id <= 0) {
            header("Location: ../order_items.php?status=accept-failed");
            exit;
        }
        
        foreach ($package_id as $id) {
            $stmt = $connection->prepare("UPDATE order_list SET status='accepted' WHERE id=? AND status='pending'");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            $stmt = $connection->prepare("UPDATE inventory_item_info iii INNER JOIN order_list ordership ON iii.inventory_id = ordership.item_id SET iii.location='shipping' WHERE iii.inventory_id=? AND ordership.status='draft'");
            $stmt->bind_param("i", $package['item_id']);

            if ($stmt->execute() && $stmt->affected_rows > 0) {
                header("Location: ../order_items.php?status=accepted");
            } else {
                header("Location: ../order_items.php?status=accept-failed");
            }
            exit;
        }
    }

    //accept Order item via link (pending -> accepted)
    if (isset($_GET['accept_order_id'])) {
        $order_id = intval($_GET['accept_order_id']);
        $sql = $connection->prepare("SELECT package_id FROM order_list WHERE id=? LIMIT 1");
        $sql->bind_param("i", $order_id);
        $sql->execute();
        $result = $sql->get_result();
        if ($result && $result->num_rows > 0) {
            $package = $result->fetch_assoc();
            $package_id = $package['package_id'];
        } else {
            echo "Order package not found";
            exit;
        }

        if ($order_id <= 0) {
            header("Location: ../order_items.php?status=accept-failed");
            exit;
        }

        foreach ($package_id as $id) {
            $stmt = $connection->prepare("UPDATE order_list SET status='accepted' WHERE id=? AND status='pending'");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            $stmt = $connection->prepare("UPDATE inventory_item_info iii INNER JOIN order_list ordership ON iii.inventory_id = ordership.item_id SET iii.location='shipping' WHERE iii.inventory_id=? AND ordership.status='draft'");
            $stmt->bind_param("i", $package['item_id']);

            if ($stmt->execute() && $stmt->affected_rows > 0) {
                header("Location: ../order_items.php?status=accepted");
            } else {
                header("Location: ../order_items.php?status=accept-failed");
            }
            exit;
        }
    }

    //remove item from order package (draft only)
    if (isset($_POST['remove_order_item_btn'])) {
        $package_id = intval($_POST['package_id'] ?? 0);
        $order_item_id = intval($_POST['order_item_id'] ?? 0);
        $package_status = $_POST['package_status'] ?? '';

        if ($package_id <= 0 || $order_item_id <= 0) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-failed");
            exit;
        }

        if ($package_status !== 'draft') {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=locked");
            exit;
        }

        $stmt = $connection->prepare("DELETE FROM order_list WHERE id=? AND status='draft'");
        $stmt->bind_param("i", $order_item_id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-success");
            exit;
        }

        header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-failed");
        exit;
    }

    //remove item from order package via link (draft only)
    if (isset($_GET['remove_order_item_id'])) {
        $package_id = intval($_GET['package_id'] ?? 0);
        $order_item_id = intval($_GET['remove_order_item_id'] ?? 0);

        if ($package_id <= 0 || $order_item_id <= 0) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-failed");
            exit;
        }

        $stmt = $connection->prepare("DELETE FROM order_list WHERE id=? AND status='draft'");
        $stmt->bind_param("i", $order_item_id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-success");
            exit;
        }

        header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-failed");
        exit;
    }

    //update order package details
    if(isset($_POST['update_order_btn'])){
        $id = intval($_GET['id']);
        $sql = $connection->prepare("SELECT package_id FROM order_list WHERE id=? LIMIT 1");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result = $sql->get_result();
        if ($result && $result->num_rows > 0) {
            $package = $result->fetch_assoc();
            $package_id = $package['package_id'];
        } else {
            echo "Order package not found";
            exit;
        }
        $reference = $_POST['ref_numb'];
        $ship_date = $_POST['ship_date'];
        $trailer = $_POST['truck'];
        $address = $_POST['address'];
        $zip = $_POST['zip'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        
       
        $stmt = $connection->prepare("UPDATE order_list SET reference_numb=?, ship_date=?, trailer_name=?, address=?, zip_code=?, city=?, state=? WHERE package_id=$package_id");
        $stmt->bind_param("isssiss", $reference, $ship_date, $trailer, $address, $zip, $city, $state);
        
        
        if($stmt->execute()){
            echo "Order details updated successfully";
            header("Location: ../order_items.php");
        } else {
            echo "Failed to update order details";
        }
    };
    
    //add item to order package (draft only)
    if (isset($_POST['add_order_item_btn'])) {
        $package_id = intval($_POST['package_id'] ?? 0);
        $new_item_id = isset($_POST['new_item_id']) ? $_POST['new_item_id'] : 0;
        $reference = intval($_POST['package_ref_numb'] ?? 0);
        $ship_date = $_POST['package_ship_date'] ?? '';
        $trailer = $_POST['package_trailer'] ?? '';
        $address = htmlspecialchars($_POST['package_address'] ?? '');
        $zip = intval($_POST['package_zip'] ?? 0);
        $city = htmlspecialchars($_POST['package_city'] ?? '');
        $state = htmlspecialchars($_POST['package_state'] ?? '');
        $package_status = htmlspecialchars($_POST['package_status'] ?? '');

        if ($package_id <= 0 || $new_item_id <= 0 || $reference <= 0 || $ship_date === '' || $trailer === '' || $address === '' || $zip <= 0 || $city === '' || $state === '') {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=add-failed");
            exit;
        }

        if ($package_status !== 'draft') {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=locked");
            exit;
        }

        $check_stmt = $connection->prepare("SELECT id FROM order_list WHERE item_id=? AND reference_numb=? AND ship_date=? AND trailer_name=? AND address=? AND zip_code=? AND city=? AND state=? LIMIT 1");
        $check_stmt->bind_param("iiss", $new_item_id, $reference, $ship_date, $trailer);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result && $check_result->num_rows > 0) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=add-duplicate");
            exit;
        }

       foreach ($new_item_id as $item_id) {
            $insert_stmt = $connection->prepare("INSERT INTO order_list (item_id, reference_numb, ship_date, trailer_name, address, zip_code, city, state, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'draft')");
            $insert_stmt->bind_param("iisssiss", $item_id, $reference, $ship_date, $trailer, $address, $zip, $city, $state);
        }

        if ($insert_stmt->execute()) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=add-success");
            exit;
        }

        foreach ($new_item_id as $item_id) {
            $stmt= $connection->prepare("UPDATE inventory_item_info SET `location`='shipping' WHERE inventory_id=?");
            $stmt->bind_param("i", $new_item_id);
            $stmt->execute();
        }

        header("Location: ../APIs/orders-update.php?id=$package_id&status=add-failed");
        exit;
    }

    //remove item from order package (draft only)
    if (isset($_POST['remove_order_item_btn'])) {
        $package_id = intval($_POST['package_id'] ?? 0);
        $order_item_id = intval($_POST['order_item_id'] ?? 0);
        $package_status = $_POST['package_status'] ?? '';

        if ($package_id <= 0 || $order_item_id <= 0) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-failed");
            exit;
        }

        if ($package_status !== 'draft') {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=locked");
            exit;
        }

        $stmt = $connection->prepare("UPDATE inventory_item_info SET location='warehouse' WHERE inventory_id=?");
        $stmt->bind_param("i", $order_item_id);
        $stmt->execute();

        $stmt = $connection->prepare("DELETE FROM order_list WHERE id=? AND status='draft'");
        $stmt->bind_param("i", $mpl_item_id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-success");
            exit;
        }

        header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-failed");
        exit;
    }

    //remove item from order package via link (draft only)
    if (isset($_GET['remove_order_item_id'])) {
        $package_id = intval($_GET['package_id'] ?? 0);
        $order_item_id = intval($_GET['remove_order_item_id'] ?? 0);

        if ($package_id <= 0 || $order_item_id <= 0) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-failed");
            exit;
        }

        $stmt = $connection->prepare("UPDATE inventory_item_info SET location='warehouse' WHERE inventory_id=?");
        $stmt->bind_param("i", $order_item_id);
        $stmt->execute();

        $stmt = $connection->prepare("DELETE FROM order_list WHERE id=? AND status='draft'");
        $stmt->bind_param("i", $order_item_id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-success");
            exit;
        } else

        header("Location: ../APIs/orders-update.php?id=$package_id&status=remove-failed");
        exit;
    }



