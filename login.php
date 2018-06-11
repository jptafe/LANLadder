<!--

Show a form for users to login, action goes to loginprocess.php

:w
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LANLadder Login</title>
  <script src="js/code.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
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
            <button type="submit">Login</button>
          </div>
        </div>
      </fieldset>
    </div>
  </form>
</body>

</html>
