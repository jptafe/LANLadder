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
        <nav class="navbar_anon">
            <p><a href="index.php">Home</a></p>
            <p><a href="login.php">Login</a></p>
            <p><a href="register.php">Register</a></p>
        </nav>
        <nav class="navbar_player">
            <p><a href="index.php">Home</a></p>
            <p>Logout</p>
            <p>Join Team</p>
            <p>Create Team</p>
            <p>Join Ladder</p>
        </nav>
        <nav class="navbar_admin">
            <p><a href="index.php">Home</a></p>
            <p>Logout</p>
            <p>Create Matches</p>
            <p>Create Ladder</p>
        </nav>  
        <section class="container">
            <div class="title"><h1>Blue Bleechers</h1></div>
                <div class="detailedteamcard">
                    <div class="teamcard">
                        <img src="img/bluebleechers.jpg" height="64" width="64" alt="teams logo">
                        <p>Team Size - (count members)</p>
                        <p class="teammemname">Team Members Names: Example, Example, Example</p>
                        <div class="teamstats">
                            <div class="tf2stats">
                                <img src="img/tf2.png"  alt="TF2 Logo">
                                <p>W: 0</p><p>L: 0</p>  
                            </div>
                            <div class="csgostats">
                                <img src="img/csgo.jpg"  alt="csgo Logo">
                                <p>W: 0</p> <p>L: 0</p> 
                            </div>
                            <div class="rlstats">
                                <img src="img/rocketleague.jpeg"  alt="rl Logo">
                                <p>W: 0</p> <p>L: 0</p> 
                            </div>
                            <div class="totalstats">
                                <h2>Total</h2> <p>W: 0</p> <p>L: 0</p>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>