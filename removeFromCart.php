<?php
	session_start();
	
	$id = $_POST['id'];
	
	if(isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]['number'] -= 1; 
		if($_SESSION['cart'][$id]['number'] == 0){
			unset($_SESSION['cart'][$id]);
		}
		if(empty($_SESSION['cart']))
			unset($_SESSION['cart']);
		echo "y";
		exit();
	}
	
	echo "n";

?>

