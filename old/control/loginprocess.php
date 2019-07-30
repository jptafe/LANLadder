<?php
	include '../functions.php';
  	$Username = $_POST["username"];
		// Searchs the database for an email that matchs the email provied.
		$conn = dbConnect();
		$login = "SELECT * FROM player WHERE name = :Username;";
		$stmt = $conn->prepare($login);
		$stmt->bindParam(':Username', $Username);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		// Gets User login credential and changes the name of the object.
		$UP = $_POST["password"];
		$DP = $result["pass"];
		// If user email is not found throw an error on reload
		if($stmt->rowcount() == 0) {
			$_SESSION['message'] = "Login details are invalid please try again";
		 	header('Location: ../index.php');
		} else {
			// Checks User input password agentist the hashed password in the database
			if (password_verify($UP, $DP)) {
				echo 'Password is valid!';
				//Set Users details into session.
				$_SESSION['UserID'] = $result['id'];
				$_SESSION['UserPrivileges'] = $result['user_privileges'];
				$_SESSION['TeamID'] = $result['team_id'];
				unset($_SESSION['message']);
				header('location: ../index.php');
			} else {
				// if an email was found but your password was wrong.
				$_SESSION['message'] = "Login details are invalid please try again";
			 	header('Location: ../index.php');
			}
		}
 ?>
