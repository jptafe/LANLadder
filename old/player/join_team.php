<!--

    A player can join any team that want, but only one

-->
<?php
  session_start();
  require_once '../functions.php';
  $teamid = $_GET['teamid'];
  if (isset($_GET['teamid'])) {
    $player = $_SESSION['UserID'];
    $_SESSION['TeamID'] = $_GET['teamid'];
    join_team($player, $teamid);
    header('location: ../');
  } else {
    header('location: ../');
  }
  print_r($_SESSION);
?>
