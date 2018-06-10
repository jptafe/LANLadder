<?php
  require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LANLAdder HOME</title>
  <script src="js/code.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
  <?php
    switch ($_SESSION['UserPrivileges']) {
      case 0:
        // Player
        ?>
        <nav class="navbar_player">
          <p><a href="index.php">Home</a></p>
          <p>Logout</p>
          <p>Join Team</p>
          <p>Create Team</p>
          <p>Join Ladder</p>
        </nav>
        <?php
        break;
      case 1:
        // Admin
        ?>
        <nav class="navbar_admin">
          <p><a href="index.php">Home</a></p>
          <p>Logout</p>
          <p>Create Matches</p>
          <p>Create Ladder</p>
        </nav>
        <?php
        break;
      default:
        ?>
        <nav class="navbar_anon">
          <p><a href="index.php">Home</a></p>
          <p><a href="login.php">Login</a></p>
          <p><a href="register.php">Register</a></p>
        </nav>
        <?php
        break;
    }
  ?>
  <section class="container">
    <div class="title">
      <h1>Game Ladders</h1></div>
    <div class="ladderitem">
      <aside><a href="ladderlist.php?gameid=3">Team Fortress 2</a></aside>
      <aside><img src="img/tf2.png" height="64" width="64"></aside>
      <time>2018-6-15 16:00</time>
    </div>
    <div class="ladderitem">
      <aside><a href="ladderlist.php?gameid=3">CS GO</a></aside>
      <aside><img src="img/csgo.jpg" height="64" width="64"></aside>
      <aside>2018-6-15 17:00</aside>
    </div>
    <div class="ladderitem">
      <aside><a href="ladderlist.php?gameid=3">Rocket League</a></aside>
      <aside><img src="img/rocketleague.jpeg" height="64" width="64"></aside>
      <aside>2018-6-15 18:00</aside>
    </div>
  </section>

  <section class="container">
    <div class="title">
      <h1>Team Ladder</h1></div>
    <div class="ladderitem">
      <aside><a href="teamcard.php?teamid=3">Blue Bleechers</a></aside>
      <aside><img src="img/bluebleechers.jpg" height="64" width="64"></aside>
      <aside>Wins: 2</aside>
      <aside>Losses: 2</aside>
      <aside>Total: 4</aside>
    </div>
    <div class="ladderitem">
      <aside><a href="teamcard.php?teamid=4">Ready Creek</a></aside>
      <aside><img src="img/readycreek.jpeg" height="64" width="64"></aside>
      <aside>Wins: 2</aside>
      <aside>Losses: 1</aside>
      <aside>Total: 3</aside>
    </div>
  </section>
  <div class="error">
    <?php
      print_r($_SESSION);
      echo "<br>";
    ?>
  </div>
</body>

</html>
