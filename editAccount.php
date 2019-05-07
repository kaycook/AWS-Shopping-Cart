<?php 
	require_once('check.php');
?>
	<html>
		<head>
			<title>Account - Algam's</title>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		</head>
		<body>
<?php
	include('header.php');

?>
<h4><?=isset($message) ? $message : ''?></h4>
<br/>
Information: <br/>
Name: <?= $_SESSION['user']?> <br/>
Address: <?= $_SESSION['address']?> <br/>
<br/>
<hr/>

<h1> Change Information </h1>

<hr/>
<form method="POST" action="index.php">
	Address: <input name="address" value="<?=(isset($address)) ? $address : ""; ?>"/><br/>
	<input type="submit" name="action" value="Edit Address"><br/>
</form>
<hr/>
<br/>

<form method="POST" action="index.php">
	New Password: <input type="password" name="newPassword" id="newPassword"/> <br/>
	Reenter New Password: <input type="password" name="newPassword2" id="newPassword2"/> <br/>
	Password: <input type="password" name="password"/><br/>
	<input type="submit" name="action" value="Edit Password"><br/>
</form>
<hr/>