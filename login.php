<!--

Show a form for users to login, action goes to loginprocess.php

:w
-->
<!DOCTYPE html>
<html lang="en">
<?php
  require_once('functions.php');
  dom_head();
?>

<body>
  <?php
    dom_nav();
  ?>
  <form action="control/loginprocess.php" method="post">
    <h1>Become a Player</h1>
    <div class="container">
      <fieldset>
        <div class="field-container">
          <label for="username"><b>Username</b></label>
          <input type="text" name="username">

          <label for="password"><b>Password</b></label>
          <input type="password" name="password">

          <div class="loginbtn">
            <button class="btn waves-effect waves-green" type="submit">Login</button>
          </div>
        </div>
      </fieldset>
    </div>
  </form>
</body>

</html>
