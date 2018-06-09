<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LANLAdder HOME</title>
        <script src="js/code.js"></script>
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
            <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
<body>
    
    <div class="registerform" action="">
        <div class="container">
            <h1>Register</h1>
            <h2>Please fill in this form to create an account.</h2>
            <form action="control/registerprocess.php" method="post">
                <label for="name"><b>Username</b></label>
                <input type="text" placeholder="Enter Name" name="Name" >
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" >
                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat"    >
                <button type="submit" class="registerbtn">Register</button>
            </form>
        </div>
    </div>
    </body>
</html>