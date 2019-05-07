<?php
	require_once('check.php');
?>
	<html>
		<head>
			<title><?=$item['itemName']?> - Algam's</title>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script src="algams.js"></script>
		</head>
	<body>

		<?php
			include('header.php');
			
			$location = "Images/".$item['image'];
			$image_file = fopen($location, 'r');
			$image_data = fread($image_file, filesize($location));
		?>

		<table border="1">
			<tr>
				<th colspan='5' align="center"><h1><?= $item['itemName'] ?></h1></th>
			</tr>
			<tr>
				<td colspan='5' align="center">
					<?= $item['desc'] ?>
				</td>
			</tr>
			<tr>
				<td colspan='5' align="center">
					<img height="200px" src="data:image/jpeg;base64,<?=base64_encode($image_data)?>"/>
				</td>
			</tr>
			<tr>
				<td colspan='5' align="center">
					$<?= $item['price'] ?> 
					<input type='submit' name='action' id="add<?=$item['itemId']?>" value='Add' onclick="addToCart(<?=$item['itemId']?>)"/>
				</td>
			</tr>
		</table>
		<br/>
		<form method="GET" action="index.php">
			<input type="hidden" name="search" value="<?= isset($_REQUEST['searchWas']) ? $_REQUEST['searchWas'] : ''?>"/>
			<button type='submit' name='action' value='search'>Back</button>
		</form> 
	</body>
</html>