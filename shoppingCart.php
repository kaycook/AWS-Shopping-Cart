<?php 
	require_once('check.php');
?>
	<html>
		<head>
			<title>Cart - Algam's</title>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script src="algams.js"></script>
		</head>
		<body>
		
		<h4><?=isset($message) ? $message : ''?></h4>
<?php
	include('header.php');
	
	if(!isset($_SESSION['cart'])) {
		echo "<h1>Nothing in Cart</h1>";
		exit();
	}

?>
	<table border='1'>
	<tr>
		<th>Item Name</th>
		<th>Amount</th>
		<th>Individual Cost</th>
		<th>Total Cost</th>
	</tr>
<?php
	$total = 0;
	foreach($_SESSION['cart'] as $key => $value){
			$cost = $value['number']*$value['price'];
			$total+=$cost;
			$id = $value['itemId'];
		?>
		<tr>
			<td><?=$value['itemName']?></td>
			<td id="n<?=$id?>"><?=$value['number']?></td>
			<td id="p<?=$id?>">$<?=$value['price']?></th>
			<td id="c<?=$id?>">$<?=$cost?></td>
			<td><input type='submit' name='action' value='remove' onclick="removeItem(<?=$id?>)"/></td>
		</tr>
		<?php
	}
		echo "<tr><th>Total</th><th colspan='4' align='right' id='total' >\$$total</th></tr>";
	
?>
	<tr>
		<td align="center" colspan="5">
			<form method="POST" action="index.php">
				<br/>
				Address: <input type="text" name="address" value="<?= $_SESSION['address']?>"/> <br/>
				Zip Code: <input type="text" name="zip" /> <br/>
				Credit Card: <input type="text" name="credit" /> <br/>
				<input type="submit" name="action" value="Buy"/>
			</form>
		</td>
	</tr>
	
	</table>
	