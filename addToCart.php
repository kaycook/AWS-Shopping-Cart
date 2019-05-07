<?php
	session_start();
	
	$id = $_POST['id'];
	
	require_once('../dbConnection.php');
	$stmt = $conn->prepare("SELECT * FROM items  WHERE itemId = ?");
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$p = $result->fetch_array(MYSQLI_ASSOC);
	
	if(!isset($_SESSION['cart'][$id])){
		$p['number'] = 1;
		$_SESSION['cart'][$id] = $p; 
	} else{
		$_SESSION['cart'][$id]['number'] += 1; 
	}
	
	echo $id;

?>

