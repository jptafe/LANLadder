<?php
  require_once '../functions.php';
  if ($_POST['psw'] = $_POST['psw-repeat']) {
    $Username = clean($_POST['Name']);
    $UserPassword = clean($_POST['psw']);
    $HashedPassword = password_hash($UserPassword, PASSWORD_DEFAULT);
    $_SESSION['user'] = $Username;
    $_SESSION['UserPrivileges'] = 0;
    header('location: ../index.php');
  } else {
    $_SESSION['error_message'] = 'Your password do not match';
    header('location: ../index');
  }
?>
