<?php
 require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <?php
                $stmt = $connection->prepare("SELECT `sku` FROM `products`");
                $stmt->execute();
                    $result = $stmt->get_result();
                        if($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo 
                                "<table>
                                    <tr>
                                        <p>$row[sku]</p>
                                    </tr>
                                </table>
                                ";
                            }
                        };
                $stmt->close();
            ?>
        </tr>
    </table>
</body>
</html>