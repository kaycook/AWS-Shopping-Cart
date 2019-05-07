<html>
	<head>
		<title>Register - Algams</title>
	</head>
	
	<body>
		<h3><font color='red'><?= isset($message) ? $message : '' ?></font></h3>
		<hr/>
		<h1> Registration </h1>
		<form method="post" action="index.php">
			Username: <input type="text" name="user" value="<?= isset($user)? $user : '' ?>" />  <br/>
			Password: <input type="password" name="pass1"  /> <br/>
			Re-enter Password: <input type="password" name="pass2"  /> <br/>
			Address: <input type="text" name="address" value="<?= isset($address)? $address : '' ?>" />  <br/>
			<input type="submit" name="action" value="register"/>
		</form>
		<hr/>
		<a href="login.php">Login</a>
	</body>
</html>

