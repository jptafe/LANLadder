<?php
// Session Set
 session_start();
 if(!isset($_SESSION['UserPrivileges'])) {
   $_SESSION['UserPrivileges'] = 9;
 }


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


  // Played matches
  function insert_match($game, $team_a, $team_b){
    try{
      $query = 'INSERT INTO `played_match`(`team_a_id`, `team_b_id`, `ladder_id`, `winning_team_id`, `losing_team_id`) VALUES (:team_a, :team_b, :game, 1, 1)'; // 1 is unset
      $conn = dbConnect();
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':team_a', $team_a);
      $stmt->bindParam(':team_b', $team_b);
      $stmt->bindParam(':game', $game);
      $result = $stmt->execute();
    }catch (PDOException $e){
      exit(print '<h1 style="color: red; font-weight: bold; text-align: center;">ERROR</h1>' . $e->getMessage() .  '<br><p>Error breakdown</p>' . $e);
    }
  }

  function insert_new_player($name, $pass, $loc, $teamid){
    try{
      $query = 'INSERT INTO `player`(`name`, `pass`, `seated_loc`, `team_id`) VALUES (:name , :pass, :loc, :team)';
      $conn = dbConnect();
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':pass', $pass);
      $stmt->bindParam(':loc', $loc);
      $stmt->bindParam(':team', $teamid);
      $result = $stmt->execute();
    }catch (PDOException $e){
      exit(print '<h1 style="color: red; font-weight: bold; text-align: center;">ERROR</h1>' . $e->getMessage() .  '<br><p>Error breakdown</p>' . $e);
    }
  }


  // Create New Team
  function create_new_team($name, $color, $file) {
    try{
      $query = 'INSERT INTO `team`(`team_name`, `color`, `image`) VALUES (:tname , :color, :img)';
      $conn = dbConnect();
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':tname', $name);
      $stmt->bindParam(':color', $color);
      $stmt->bindParam(':img', $file);
      $result = $stmt->execute();
    }catch (PDOException $e){
      exit(print '<h1 style="color: red; font-weight: bold; text-align: center;">ERROR</h1>' . $e->getMessage() .  '<br><p>Error breakdown</p>' . $e);
    }
  }

  // Join A team
  function join_team($player, $teamid) {
    try {
      $query = "UPDATE `player` SET `team_id` = :team WHERE `player`.`id` = :player";
      $conn = dbConnect();
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':player', $player);
      $stmt->bindParam(':team', $teamid);
      $result = $stmt->execute();
    }catch (PDOException $e){
      exit(print '<h1 style="color: red; font-weight: bold; text-align: center;">ERROR</h1>' . $e->getMessage() .  '<br><p>Error breakdown</p>' . $e);
    }
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
            <ul class="left">
              <li class="waves-effect waves-light"><a href="index.php">Home</a></li>
              <li class="waves-effect waves-light"><a href="player/create_team.php">Create Team</a></li>
              <li class="waves-effect waves-light"><a href="#teams">View Teams</a></li>
            </ul>
            <ul class="right">
              <li class="waves-effect waves-light"><a href="control/logout.php">Logout</a></li>
            </ul>
          </div>
        </nav>
        <?php
        break;
      case 1:
        ?>
        <nav class="navbar_admin">
          <div class="nav-wrapper">
            <ul class="left">
              <li class="waves-effect waves-light"><a href="index.php">Home</a></li>
              <li class="waves-effect waves-light"><a href="admin/createladder.php">Create Ladder</a></li>
              <li class="waves-effect waves-light"><a href="admin/creatematch.php">Create Match</a></li>
            </ul>
            <ul class="right">
              <li class="waves-effect waves-light"><a href="control/logout.php">Logout</a></li>
            </ul>
          </div>
        </nav>
        <?php
        break;
      default:
        ?>
        <nav class="navbar_anon">
          <div class="nav-wrapper">
            <ul>
              <li class="waves-effect waves-light"><a href="index.php">Home</a></li>
            </ul>
            <ul class="right">
              <li class="waves-effect waves-light"><a href="login.php">Login</a></li>
              <li class="waves-effect waves-light"><a href="register.php">Register</a></li>
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
    $conn = dbConnect();
    $query = 'SELECT * FROM `team` ORDER BY `id` ASC'; // Possiably replace this with a procedure
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute();
    $result = $stmt->fetchAll();
    ?>
    <main class="container">
      <div class="title">
        <h1 id="teams">Team Ladder</h1>
      </div>
      <ul class="collection">
      <?php
        $teams_query = 'SELECT * FROM `played_match` WHERE `winning_team_id` OR `losing_team_id`;';
        $stm = $conn->prepare($teams_query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stm->execute();
        $teams = $stm->fetchAll();
        foreach($result as $row){
          if(!preg_match('/^Unset$/i', $row['team_name'])){ //Checks to see if the start and end of the string only contain Unset with checks for capitialization
            print '
            <li class="collection-item avatar z-depth-1" style="background-color: ' . $row['color'] . ';">
              <div class="opacity_ontop">
              <img class="circle" src="img/' . $row['image'] . '" alt="Team image" width="250px" height="250px">
              <a href="teamcard.php?teamid=' . $row['id'] . '" class="title text-shadow"><h4 class=" left-align">' . $row['team_name'] . '</h4></a>';
            $win = 0;
            $loss = 0;
            foreach($teams as $teamid){
              if($row['id'] == $teamid['winning_team_id']){
                $win++;
              }else if($row['id'] == $teamid['losing_team_id']){
                $loss++;
              }
            }
            $total = $win + $loss;
              print '
                <p class="text-shadow">Wins: ' . $win . '</p>
                <p class="text-shadow">Losses: ' . $loss . '</p>
                <span class=" secondary-content white-text text-shadow">
                  <p>Total: ' . $total . '</p>

                  <a class="teams-button waves-effect waves-light btn blue-grey darken-4" href="player/join_team.php?teamid=' . $row['id'] . '">Join Team</a>
                  <a class="teams-button waves-effect waves-light btn blue-grey darken-4" href="teamcard.php?teamid=' . $row['id'] . '">View team</a>
                </span>
              </div>';
            print '</li>';
          }
        }
        $team_list = "SELECT * FROM team;";
        $conn = dbConnect();
        $stmt = $conn->prepare($team_list);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){

        }
      ?>
      </ul>
    </main>

    </section>
    <?php
  }


// Games list
  function ladder_list() {
    $ladder_list = "SELECT * FROM ladder;";
    $conn = dbConnect();
		$stmt = $conn->prepare($ladder_list);
		$stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

// Team list
  function team_list() {
    $team_list = "SELECT * FROM team;";
    $conn = dbConnect();
		$stmt = $conn->prepare($team_list);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

  // Teams Playing a Match
  function playing_match() {
    $gameMatch = $_GET['id'];
    $match = "SELECT * FROM played_match WHERE id = '" . $gameMatch . "' ;";
    $conn = dbConnect();
    $stmt = $conn->prepare($match);
    $stmt->execute();
    $playing_match = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $playing_match;
  }
?>
