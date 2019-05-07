<?php 
	require_once('check.php');
?>
	<html>
		<head>
			<title>Algam's</title>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script src="algams.js"></script>
		</head>
		<body>
<?php
	include('header.php');
	
	require_once('../dbConnection.php');
	$stmt = $conn->prepare("SELECT purchases.purchaseId, itemName, number, date FROM clients JOIN purchases ON clients.clientId = purchases.clientId JOIN purchasedItem ON purchases.purchaseID = purchasedItem.purchaseId JOIN items ON items.itemId = purchasedItem.itemId WHERE username LIKE ? ORDER BY date DESC LIMIT 10");
	$te = $_SESSION['user'];
	$stmt->bind_param('s', $te);
	$stmt->execute();
	$result2 = $stmt->get_result();
?>

	<pre id="response">
	</pre>
	<form method="get" action="index.php">
		Search Items: <input type="text" name="search" value="<?= (!empty($search)) ? $search : "" ?>">
		<input type="submit" name="action" value="search"/>
	</form>
	
	<?php
		
		if(isset($result) && !empty($result)){
			?>
			<table border='1'>
			<tr>
				<th>Title</th>
				<th>price</th>
				<th>Image</th>
				<th></th>
			</tr>
			
			<?php 
			while($t = $result->fetch_array(MYSQLI_ASSOC)){
				
				$location = "Images/".$t['image'];
				$image_file = fopen($location, 'r');
				$image_data = fread($image_file, filesize($location));
				
				?>
				<tr>
					<td><?=$t['itemName']?></td>
					<td><?=$t['price']?></td>
					
					<td><img height="200px" src="data:image/jpeg;base64,<?=base64_encode($image_data)?>"/></td>
					<td>
						<form method="POST" action="index.php">
							<input type="hidden" name="id" value="<?=$t['itemId']?>"/>
							<input type="hidden" name="searchWas" value="<?= isset($_REQUEST['search']) ? $_REQUEST['search'] : ''?>"/>
							<input type='submit' name='action' value='Details' />
						</form>
						<input type='submit' name='action' id="add<?=$t['itemId']?>" value='Add' onclick="addToCart(<?=$t['itemId']?>)"/>
					</td>
				
				</tr>
			<?php
			}
			?>
			</table>
			
		<?php
		}
		if(!empty($result2->num_rows)){
			?>
			<br/>
			<hr><h1>Previous Purchases</h1>
			<table border='1'>
			<tr><th>Purchase Date</th><th>Items</th>
			<?php
			while($t = $result2->fetch_array(MYSQLI_ASSOC)){
				?>
				<tr>
				<td><?=$t['date']?></td>
				<td><?=$t['itemName']?></td>
				</tr>
			<?php 
			}
			?>
			</table>
		<?php
		}
		


	// AJAX to add to cart
	// Details slides out with description
	?>