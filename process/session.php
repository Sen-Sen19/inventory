<?php
	include 'login.php';

	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$q = "SELECT * FROM user_accounts WHERE username = '$username'";
		$stmt = $conn->prepare($q);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			foreach($stmt->fetchALL() as $i){
				$username = $i['username'];
				$name = $i['full_name'];
				$role = $i['role'];
			}
		}else{
			session_unset();
			session_destroy();
			header('location: login.php');
		}
	}else{
		session_unset();
		session_destroy();
		header('location: login.php');
	}
	

?>