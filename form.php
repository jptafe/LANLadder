<?php require_once 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Forms</title>
  </head>
  <body>
    <!-- Create A Match for results to got in -->
    <form class="" action="#" method="post">
      <h1>Create A Match</h1>
      <div class="container">
        <fieldset>
          <div class="field-container">
            <label for="game"><b>Game</b></label>
            <select class="" name="game">
              <?php ladder_list(); ?>
            </select>
            <label for="team_a"><b>Team A</b></label>
            <select class="" name="team_a">
              <?php team_list(); ?>
            </select>
            <label for="team_b"><b>Team B</b></label>
            <select class="" name="team_b">
              <?php team_list(); ?>
            </select>
            <div class="">
              <button type="submit">Publish Match</button>
            </div>
          </div>
        </fieldset>
      </div>
    </form>
    <br>
    <br>
    <!-- Create A Ladder -->
    <form class="" action="#" method="post" enctype="multipart/form-data">
      <h1>Create A Ladder</h1>
      <div class="container">
        <fieldset>
          <div class="field-container">
            <label for="game"><b>Ladder</b></label>
            <input type="text" name="game" placeholder="What Game?">

            <label for="description"><b>Description</b></label>
            <input type="description" name="description">

            <label for="players"><b>Max Numbers of Players</b></label>
            <input type="text" name="players" placeholder="Max Number Of players In A Team">

            <label for="color"><b>Colour</b></label>
            <input type="text" name="color" placeholder="Color of The Game">

            <label for="color"><b>Colour</b></label>
            <input type="text" name="color" placeholder="Color of The Game">

            <label for="img"><b>image</b></label>
            <input type="file" name="image" accept="image/png, image/jpeg">
            <div class="">
              <button type="submit">Publish Ladder</button>
            </div>
          </div>
        </fieldset>
      </div>
    </form>
    <br>
    <br>
    <!-- Alter Results Published -->
    <form class="" action="#" method="post">
      <h1>Alter Results</h1>
      <div class="container">
        <fieldset>
          <div class="field-container">
            <label for="game"><b>Game</b></label>
            <select class="" name="">
              <?php ladder_list(); ?>
            </select>
            <?php $playing_match = playing_match();  ?>
            <label for="team_a"><b>Team A</b></label>
            <input type="text" name="1" <?php echo 'value="' . $playing_match['team_a_id'] . '"'; ?>>
            <label for="team_b"><b>Team B</b></label>
            <input type="text" name="2" <?php echo 'value="' . $playing_match['team_b_id'] . '"' ?>>
            <label for="win_team"><b>Win</b></label>
            <select class="" name="winning_team_id">

            </select>
            <label for="lose_team"><b>Lose</b></label>
            <select class="" name="losing_team_id">

            </select>
            <div class="">
              <button type="submit">Publish Match</button>
            </div>
          </div>
        </fieldset>
      </div>
    </form>

    <?php print_r(playing_match()); ?>

  </body>
</html>
