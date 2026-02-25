<?php
	require_once('db_connect.php');
	include('header.php');

    $inventory_count = mysqli_num_rows(mysqli_query($connection, "SELECT inventory_id FROM inventory_item_info"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Internal Inventory</title>
	<link rel="stylesheet" href="css/stylesheet.css">
	<link rel="stylesheet" href="css/nav.css">
	<link rel="stylesheet" href="css/normalize.css">
</head>
<body>
	<div class="dashboard-container">
		<h1>Internal Inventory</h1>

		<div class="stats-row">
			<div class="card">
				<h3>Total Items</h3>
				<p class="stat-number"><?php echo $inventory_count; ?></p>
			</div>
			<div class="card">
				<h3>Low Stock</h3>
				<p class="stat-number">--</p>
			</div>
			<div class="card">
				<h3>Locations</h3>
				<p class="stat-number">--</p>
			</div>
		</div>

		<div class="section-container">
			<h2>Filters</h2>
			<form method="GET" class="form-grid">
				<div class="form-group">
					<label for="search">Search</label>
					<input type="text" id="search" name="search" placeholder="SKU, description, or ficha">
				</div>
				<div class="form-group">
					<label for="location">Location</label>
					<input type="text" id="location" name="location" placeholder="Aisle, rack, or bin">
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<input type="text" id="status" name="status" placeholder="Available, Reserved, Damaged">
				</div>
				<div class="form-group">
					<label for="min_qty">Min Quantity</label>
					<input type="number" id="min_qty" name="min_qty" placeholder="0">
				</div>
				<div class="form-footer-actions full-width">
					<a href="i_inventory.php" class="cancel-link">Reset</a>
					<button type="submit" class="btn">Apply Filters</button>
				</div>
			</form>
		</div>

		<div class="section-container">
			<h2>Quick Actions</h2>
			<div class="button-group">
				<a href="#" class="btn">Adjust Quantity</a>
				<a href="#" class="btn">Move Item</a>
				<a href="#" class="btn">Add Note</a>
			</div>
		</div>

		<div class="table-container">
			<h2>Inventory Items</h2>
			<table class="data_tb">
				<tr>
					<th>ID</th>
					<th>Unit Number</th>
					<th>Ficha</th>
					<th>Description</th>
					<th>Quantity</th>
					<th>Unit</th>
					<th>Footage</th>
					<th>Location</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
				<?php
					$result = mysqli_query($connection, "SELECT * FROM inventory_item_info");
					if ($result && mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							$description = trim(($row['description_1'] ?? '') . ' ' . ($row['description_2'] ?? ''));
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row['inventory_id'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['unit_numb'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['ficha'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($description) . "</td>";
							echo "<td>" . htmlspecialchars($row['quantity'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['quantity_unit'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['footage_quantity'] ?? '') . "</td>";
							echo "<td>" . htmlspecialchars($row['location'] ?? '-') . "</td>";
							echo "<td>" . htmlspecialchars($row['status'] ?? '-') . "</td>";
							echo "<td>-</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='10'>No inventory items found.</td></tr>";
					}
				?>
			</table>
		</div>
	</div>
</body>
</html>
