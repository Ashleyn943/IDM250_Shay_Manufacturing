<?php
    require_once "../db_connect.php";

    $check = $connection->prepare("SELECT id, status FROM order_list WHERE id=? AND status='draft'");

     if($check == TRUE){
        $id = $_GET['id'];

        $stmt = $connection->prepare("DELETE FROM order_list WHERE id=$id");
        $stmt->execute();

         if($stmt->execute()){
             echo "Item deleted successfully";
             header("Location: ../mpl_items.php");
         } else {
             echo "Failed to delete item";
         }
     };
?>