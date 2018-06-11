<?php
// Session Set
 session_start();
 unset($_SESSION['UserPrivilges']);
 $_SESSION['UserPrivileges'] = 0;


// DB Connections
// Connection to database
  function dbConnect() {
    $dbuser = "root";
    $dbpass = "";
    try {
      $conn = new PDO("mysql:host=localhost;dbname=lanladder", $dbuser,$dbpass);
      // set attributes
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      return $conn;
    }
    catch(PDOException $e) {
      $error_message = $e->getMessage();
      echo '<h1>Database Connection Error</h1>';
      echo '<p>There was an error connecting to the database.</p>';
       // display the error message
      echo '<p>Error message:   $error_message; </p>';
      die();
    }
  }

//sanitise data sent via POST and SEND
  function clean($data) {
    $data = trim($data);
    $data= stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }



  // DOM Items


  function dom_head(){
    ?> 
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>LANLAdder HOME</title>
      <script src="js/code.js"></script>
      <!-- Compiled and minified CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

      <!-- Compiled and minified JavaScript -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <?php
  }

  // Nav items
  function dom_nav(){
    switch ($_SESSION['UserPrivileges']) {
      case 0:
        // Player
        ?>
        <nav class="navbar_player">
          <div class="nav-wrapper">
            <ul class="right">
              <li><a href="index.php">Home</a></li>
              <li><a href="#">Create Team</a></li>
              <li><a href="#">Join Ladder</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div>
        </nav>
        <?php
        break;
      case 1:
        ?>
        <nav class="navbar_admin">
          <div class="nav-wrapper">
            <ul class="right">
              <li><a href="#">Create Matches</a></li>
              <li><a href="#">Create Ladder</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div>
        </nav>
        <?php
        break;
      default:
        ?>
        <nav class="navbar_anon">
          <div class="nav-wrapper">
            <ul class="right">
              <li><a href="index.php">Home</a></li>
              <li><a href="#">Login</a></li>
              <li><a href="#">Register</a></li>
            </ul>
          </div>
        </nav>
        <?php
        break;
    }
  }
  function dom_games(){
    ?>
    <section class="container">
      <div class="title">
        <h1>Game Ladders</h1>
      </div>
      <ul class="collapsible z-depth-0">
      <?php
        $query = 'SELECT * FROM `ladder`'; // Possiably replace this with a procedure
        $conn = dbConnect();
        $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach($result as $row){
          $time = date_create($row['start_time']); // Creating a date for php to read
          $time = date_format($time, "Y M D, g:ia"); // Reformatting the date
          if(preg_match('/white/i', $row['color'])){ // Testing if the color is white replace the text color with black the /i checks for captialization
            $text = 'black-text';
          }else{
            $text = 'white-text';
          }
          print '
          <li style="background-color: ' . $row['color'] . '" class="z-depth-1">
            <div class="collapsible-header blue-grey darken-4 waves-effect waves-light">
              <img src="img/' . $row['image'] . '" width="25px" height="25px" class="circle">
              <span class="center-align">' . $row['game'] . '</span>   
              <time class="right-align">' . $time  . '</time>         
            </div>
            <div class="collapsible-body ' . $text . '">
              <h4 class="center-align">' . $row['players'] . ' VS ' . $row['players'] . '</h4>
              <a class="games-button waves-effect waves-light btn right-align blue-grey darken-4" href="ladderlist.php?gameid=' . $row['id'] . '">View teams</a>
              <span>' . $row['description'] . '</span>
            </div>
          </li>';
        }
        


      ?>
      </ul>
    </section>

    <?php
  }

  function dom_teams(){
    $query = 'SELECT * FROM `team`'; // Possiably replace this with a procedure
    $conn = dbConnect();
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute();
    $result = $stmt->fetchAll();
    var_dump($result);
    ?>
    <main class="container">
      <div class="title">
        <h1>Team Ladder</h1>
      </div>
      <?php
        foreach($result as $row){
          if(!preg_match('/^Unset$/i', $row['team_name'])){ //Checks to see if the start and end of the string only contain Unset with checks for capitialization
            print '
            <div class="row" style="background-color: ' . $row['color'] . '">
              <img class="col s3 materialboxed no-margin no-padding" src="img/' . $row['image'] . '" alt="Team image" width="250px" height="auto">
              <span class="col s2 text-shadow"><a href="teamcard.php?teamid=' . $row['id'] . '">' . $row['team_name'] . '</a></span>
              <span class="col s2 text-shadow">Wins: 2</span>
              <span class="col s2 text-shadow">Losses: 2</span>
              <span class="col s2 text-shadow">Total: 4</span>
            </div>
            ';
          }
        }
      ?>
    </main>

    <?php
  }

//
?>
