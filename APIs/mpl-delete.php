<?php
    require_once "../db_connect.php";

    $check = $connection->prepare("SELECT id, status FROM mpl_shipping_list WHERE id=? AND status='draft'");

     if($check == TRUE){
        $id = $_GET['id'];
        $stmt = $connection->prepare("UPDATE inventory_item_info iii INNER JOIN mpl_shipping_list mplship ON iii.inventory_id = mplship.item_id SET iii.location='internal' WHERE mplship.id=$id");
        $stmt->execute();

        $stmt = $connection->prepare("DELETE FROM mpl_shipping_list WHERE id=$id");
        $stmt->execute();

         if($stmt->execute()){
             echo "Item deleted successfully";
             header("Location: ../mpl_items.php");
         } else {
             echo "Failed to delete item";
         }
     };
?>