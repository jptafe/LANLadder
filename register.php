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
  <div>
    <div class="container">
      <h1>Register</h1>
      <i class="grey-text text-lighten-1">Please fill in this form to create an account.</i>
      <form action="control/registerprocess.php" method="post">
        <label for="name"><b>Username</b></label>
        <input type="text" required placeholder="Enter Name" name="Name">
        <label for="room"><b>Location</b></label>
        <input type="text" placeholder="Where are you in the room?" name="room">
        <label for="psw"><b>Password</b></label>
        <input type="password" required placeholder="Enter Password" name="psw">
        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" required placeholder="Repeat Password" name="psw-repeat">
        <button type="submit" class="btn waves-effect waves-green">Register</button>
      </form>
    </div>
  </div>
</body>

</html>
