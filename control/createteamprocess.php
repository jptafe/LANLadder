<?php
  require_once '../functions.php';
  $Time = time();
  $UploadDir = '../img/';
  $UploadFile = basename($Time.'_'.str_replace(' ', '', $_FILES['image']['name'])); // changes files name and removes spaces
  // Moves Files into locations
  if (move_uploaded_file($_FILES['image']['tmp_name'], $UploadDir.$UploadFile)) {
    echo 'Move was successful';
  }
  $TeamName = clean($_POST['TeamName']);
  $TeamColor = clean($_POST['color']);
  create_new_team($TeamName, $TeamColor, $UploadFile);
  header('location: ../index.php');
?>
