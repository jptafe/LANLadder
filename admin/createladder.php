<!-- form to create ladder with game type 
should only be a few

-->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LANLAdder HOME</title>
  <script src="../js/code.js"></script>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/style.css" type="text/css">
</head>
<?php
    require_once('../functions.php');
    print '<body>';
    dom_nav();
    ?>
    <form class="" action="#" method="post" enctype="multipart/form-data">
      <h1>Create A Ladder</h1>
      <div class="container">
        <fieldset>
          <div class="field-container">
            <label for="game"><b>Ladder</b></label>
            <input type="text" name="game" placeholder="What Game?">

            <label for="description"><b>Description</b></label>
            <input type="text" name="description">

            <label for="players"><b>Max Numbers of Players</b></label>
            <input type="text" name="players" placeholder="Max Number Of players In A Team">

            <label for="color"><b>Colour</b></label>
            <input type="text" name="color" placeholder="Color of The Game">

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
