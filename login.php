<html>
	<head>
		<title>Algam Login</title>
	</head>
	
	<body>
		<h3><font color='red'><?= isset($error) ? $error : '' ?></font></h3>
		<hr/>
		<h1> Login </h1>
		<form method="post" action="index.php">
			Username: <input type="text" name="user" value="<?= isset($user)? $user : '' ?>"/>  <br/>
			Password: <input type="password" name="pass" /> <br/>
			<input type="submit" name="action" value="login"/>
		</form>
		<hr/>
		<a href="register.php">Register</a>
	</body>
</html>

