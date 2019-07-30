<?php
  require_once '../functions.php';
  if ($_POST['psw'] == $_POST['psw-repeat']) {
    $Username = clean($_POST['Name']);
    $UserPassword = clean($_POST['psw']);
    $teamid = 1;
    $location = clean($_POST['room']);
    if($location == '' || empty($location)){ // DB can't execpt no value for this field
      $location = 'No location given';
    }

    $HashedPassword = password_hash($UserPassword, PASSWORD_DEFAULT);
    $_SESSION['user'] = $Username;
    $_SESSION['UserPrivileges'] = 0;
	$_SESSION['TeamID'] = 1;
    $_SESSION['UserID'] = insert_new_player($Username, $HashedPassword, $location, $teamid);
    header('location: ../index.php');
  } else {
    $_SESSION['error_message'] = 'Your password do not match';
    header('location: ../index');
  }
?>
