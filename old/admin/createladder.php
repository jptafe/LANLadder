<!-- form to create ladder with game type 
should only be a few

-->
<?php
    error_reporting(0); // Ignoring the error generated by session start
    session_start();
    if(!isset($_SESSION['UserPrivileges']) == 1 && $_SESSION['UserPrivileges'] != 1){ // Checks to see if the userprivileges session is set and to see if its admin or not
        header('location: ../');
    }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LANLAdder HOME</title>
    <script src="../js/code.js"></script>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>           
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script> 
</head>
<?php
    require_once('../functions.php');
    print '<body>';
    ?>
    <nav class="navbar_admin">
      <div class="nav-wrapper">
        <ul class="left">
          <li class="waves-effect waves-light"><a href="../index.php">Home</a></li>
          <li class="waves-effect waves-light"><a href="createladder.php">Create Ladder</a></li>
          <li class="waves-effect waves-light"><a href="creatematch.php">Create Match</a></li>
        </ul>
        <ul class="right">
          <li class="waves-effect waves-light"><a href="../control/logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
    <form action="admincontroller" method="post" enctype="multipart/form-data">
      <h1>Create A Ladder</h1>
      <div class="container">
        <fieldset>
          <div class="field-container">
            <label for="game"><b>Ladder</b></label>
            <input type="text" name="game" placeholder="What Game?">

            <label for="description"><b>Description</b></label>
            <input type="text" name="description" placeholder="Description on how to setup the game for the lan">

            <label for="players"><b>Max Numbers of Players</b></label>
            <p class="range-field">
                <input type="range" id="test5" min="0" max="32" value="0"/>
            </p>

            <label for="color"><b>Colour</b></label>
            <input type="color" name="color" placeholder="Color of The Game">

            <div class="file-field input-field">
                <div class="btn">
                    <span>File</span>
                    <input type="file">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
          </div>
        </fieldset>
      </div>
    </form>
    <?php
    print '</body>';
?>
