<?php
  require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php
  dom_head();
?>

<body>
  <?php
    dom_nav();
    dom_games();
    dom_teams();
  ?>
  <div class="error">
    <?php
      print_r($_SESSION);
      echo "<br>";
    ?>
  </div>
</body>

</html>
