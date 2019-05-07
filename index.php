<?php
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	if(isset($_GET['action']) && ($_GET['action']) === 'search'){
		$action = 'search';
	}
	session_start();
	if($action=='login'){
		$user = isset($_REQUEST['user']) ? $_REQUEST['user'] : '';
		$pass = isset($_REQUEST['pass']) ? $_REQUEST['pass'] : '';
		if(!isset($_REQUEST['user']) || !isset($_REQUEST['pass']))
		{
			include('login.php');
			exit();
		}
		
		require_once('../dbConnection.php');
		$stmt = $conn->prepare('SELECT * FROM clients WHERE username = ? AND password = ?');
		$stmt->bind_param('ss', $user, $pass);
		$stmt->execute();
		$result = $stmt->get_result();

		$line = $result->fetch_array(MYSQLI_ASSOC);
		if(empty($line)){
			$error = "Wrong Username or Password";
			include ("login.php");
		}
		 else{
			$_SESSION['user'] = $line['username'];
			$_SESSION['id'] = $line['clientId'];
			$_SESSION['address'] = $line['address'];
			unset($result);
			include('main.php');
		 }

	} else if($action == "register"){
			
			$password = isset($_REQUEST['pass1']) ? $_REQUEST['pass1'] : '';
			$password2 = isset($_REQUEST['pass2']) ? $_REQUEST['pass2'] : '';
			$username = isset($_REQUEST['user']) ? $_REQUEST['user'] : '';
			$address = isset($_REQUEST['address']) ? $_REQUEST['address'] : '';
			if(isset($_REQUEST['pass1'])&&isset($_REQUEST['pass2'])&&isset($_REQUEST['user'])&&isset($_REQUEST['address'])){
				if($password != $password2){
					$message = "Passwords do not match";
					include('register.php');
				} else {
					require_once('../dbConnection.php');
					$stmt = $conn->prepare("INSERT INTO clients (password, username, address) VALUES (?,?,?)");
					$stmt->bind_param('sss', $password, $username, $address);
					if($stmt->execute()){
						$message = "User Added";
					} else{
						$message = "Failed to add.";
					}
					include('login.php');
				}
				
				
			} else{
				$message = "Make sure to fill out ALL the fields";
				include('register.php');
			}
			
	}	else if(!isset($_SESSION['user'])){
		include('login.php');
		exit();
	} else if($action == "search"){
		$search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
		if(!isset($_REQUEST['search']))
		{
			include('main.php');
			exit();
		}
		
		require_once('../dbConnection.php');
		$stmt = $conn->prepare("SELECT * FROM items WHERE itemName LIKE ?");
		$temp = '%'.$search.'%';
		$stmt->bind_param('s', $temp);
		$stmt->execute();
		$result = $stmt->get_result();
		
		include('main.php');
	}else if($action == "Edit Address"){
		if(isset($_POST['address'])){
			require_once('../dbConnection.php');
			$address =  $_POST['address'];
			$stmt = $conn->prepare("update clients set address = ?  where username = ?");
			$id = $_SESSION['user'];
			$stmt->bind_param('ss', $address, $id);
			if($stmt->execute()){
				$message = "Address Updated";
				$_SESSION['address'] = $address;
			} else{
				$message = "Failed to Update";
			}
		} else{
			$message = "please enter your address";
		}
		
		include('editAccount.php');
	}else if($action == "Edit Password"){
		if(isset($_POST['newPassword']) && isset($_POST['newPassword2']) && isset($_POST['password'])){
			$newpassword = $_POST['newPassword'];
			$newpassword2 = $_POST['newPassword2'];
			$password = $_POST['password'];
			if($newpassword != $newpassword2){
				$message = "New passwords do not match";
			} else {
				require_once('../dbConnection.php');
				$password =  $_POST['password'];
				$stmt = $conn->prepare("select * from clients where username = ? AND password = ?");
				$id = $_SESSION['user'];
				$stmt->bind_param('ss', $id, $password);
				$stmt->execute();
				$result = $stmt->get_result();
				$person = $result->fetch_array(MYSQLI_ASSOC);
				if($person['username']==$id){
					require_once('../dbConnection.php');
					$stmt = $conn->prepare("update clients set password = ?  where username = ?");
					$id = $_SESSION['user'];
					$stmt->bind_param('ss', $newpassword, $id);
					if($stmt->execute()){
						$message = "Password Updated";
					} else{
						$message = "Failed to update";
					}
				}
				
			}
			
		} else{
			$message = "Please be sure to fill out ALL fields";
		}
		include('editAccount.php');
	}else if($action == "View Cart"){
		include('shoppingCart.php');
	}else if($action == "Edit Account"){
		include('editAccount.php');
	}else if($action == "Details"){
		if(isset($_POST['id'])){
			
			require_once('../dbConnection.php');
			$stmt = $conn->prepare('SELECT * FROM items WHERE itemId = ? LIMIT 1');
			$itemId = $_POST['id'];
			$stmt->bind_param('i', $itemId);
			$stmt->execute();
			$result = $stmt->get_result();

			$item = $result->fetch_array(MYSQLI_ASSOC);
			
			include("getDetails.php");
		} else{
			include("main.php");
		}
	}else if($action == "Logout"){
		session_destroy();
		include('LoggedOut.php');
	} else if($action == "Buy"){
		require_once('../dbConnection.php');
		if(empty($_SESSION['cart'])){
			echo "boop";
			unset($_SESSION['cart']);
			include("shoppingCart.php");
			exit();
		}
		$stmt = $conn->prepare("INSERT INTO purchases (clientId, date) VALUES (?,?)");
		$id = $_SESSION['id'];
		$date = date('Y-m-d',time());
		$stmt->bind_param('is', $id, $date);
		$b = false;
		if($stmt->execute()){
			$stmt = $conn->prepare("SELECT MAX(purchaseId) as 'id' FROM `purchases` WHERE clientId = $id");
			$stmt->execute();
			$result = $stmt->get_result();
			$line = $result->fetch_array(MYSQLI_ASSOC);
			$purchasedId = $line['id'];
			foreach($_SESSION['cart'] as $key => $value){
				$stmt = $conn->prepare("INSERT INTO purchasedItem (itemId, number, purchaseId) VALUES (?,?,?)");
				$number = $value['number'];
				$itemId = $value['itemId'];
				$stmt->bind_param('iii', $itemId, $number, $purchasedId);

				if($stmt->execute()){
					$b = true;
				}
			}
			if($b){
				$message = "Bought items";
			}
			unset($_SESSION['cart']);
		} else{
			$message =  "failed to update";
		}
		
		include('shoppingCart.php');
	}
	else {
		include('main.php');
		exit();
	}
?>