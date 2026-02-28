<?php
    require_once "../db_connect.php";

    $check = $connection->prepare("SELECT id, status FROM order_list WHERE id=? AND status='draft'");

     if($check == TRUE){
        $id = $_GET['id'];
        $stmt = $connection->prepare("UPDATE inventory_item_info iii INNER JOIN order_list ol ON iii.inventory_id = ol.item_id SET iii.location='warehouse' WHERE ol.id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt = $connection->prepare("DELETE FROM order_list WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

         if($stmt->execute()){
             echo "Item deleted successfully";
             header("Location: ../order_items.php");
         } else {
             echo "Failed to delete item";
         }
     };
?>