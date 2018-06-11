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
?>
  <div class="registerform" action="control/registerprocess" method="post">
    <div class="container">
      <h1>Register</h1>
      <h2>Please fill in this form to create an account.</h2>
      <form action="control/registerprocess.php" method="post">
        <label for="name"><b>Username</b></label>
        <input type="text" placeholder="Enter Name" name="Name">
        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw">
        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat">
        <button type="submit" class="registerbtn">Register</button>
      </form>
    </div>
  </div>
</body>

</html>
