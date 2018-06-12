<!--
  players can create only one team
  and not necessarally join that team, but another using join_tem.php
-->
<!DOCTYPE html>
<html lang="en">
<?php
  require_once '../functions.php';
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LANLAdder HOME</title>
  <script src="../js/code.js"></script>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

  <link rel="stylesheet" href="../css/style.css" type="text/css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
</head>
<body>
  <?php
    dom_nav();
?>
  <div>
    <div class="container">
      <h1>Create A Team</h1>
      <i class="grey-text text-lighten-1">Please fill in this form to create a team.</i>
      <form action="../control/createteamprocess.php" method="post" enctype="multipart/form-data">
        <label for="name"><b>Team Name</b></label>
        <input type="text" required placeholder="Enter Team Name" name="TeamName">
        <label for="color"><b>Team Colour</b></label>
        <input type="color" name="color">
        <label for="image"><b>Image</b></label>
        <div class="file-field input-field">
          <div class="btn">
            <span>File</span>
              <input type="file" required name="image" accept="image/jpeg, image/x-png">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
        <button type="submit" class="btn waves-effect waves-green">Create Team</button>
      </form>
    </div>
  </div>
</body>
</html>
