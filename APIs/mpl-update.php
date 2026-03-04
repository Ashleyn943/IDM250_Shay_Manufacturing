<?php
    require_once('../db_connect.php');
    //require_once('../library/auth.php');
    require_once('../library/cms_alt.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesheet.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="icon" href="../media/ShayIcon.png" type="image/x-icon">
    <title>Update Master Packing List</title>
</head>
<body>
    <?php include('../header_alt.php'); ?>
    <div class="dashboard-container">
        <div class="form-card-centered">
            <h1>Edit Details of Master Packing List Item</h1>
            <p class="form-instruction">Update item details below.</p>
            <?php
                $id = intval($_GET['id']);

                $result = mysqli_query($connection, "SELECT * FROM mpl_shipping_list mplship
                                                                    INNER JOIN inventory_item_info iii ON mplship.item_id = iii.inventory_id");
                $row = mysqli_fetch_assoc($result);
            ?>
    <form action="../library/cms_alt.php?id=<?php echo $id; ?>" method="POST" class="styled-form">
        <div class="form-grid">
            <div class="form-group">
                <label for="ref_numb">Reference Number</label>
                <input type="number" name="ref_numb" value="<?php echo htmlspecialchars($row['reference_numb']) ?? ''; ?>" required>
            </div>
            <div  class="form-group">
                <label for="ship_date">Expected Arrival Date</label>
                <input type="date" name="ship_date" value="<?php echo htmlspecialchars($row['ship_date']) ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="truck">Vehicle Name</label>
                <input type="text" name="truck" value="<?php echo htmlspecialchars($row['trailer_name']) ?? ''; ?>" required>
            </div>
            
            <div class="form-footer-actions">
                <a href="../mpl_items.php" class="cancel-link">Cancel</a>
                <button type="submit" name="update_mpl_btn" class="btn">Update Item Details</button>
            </div>
    </form>
</body>
</html>