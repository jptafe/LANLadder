<?php

    include 'functions.php';

    $conn = dbconnect();

    $getTotalTeamWins = "SELECT count(*) AS total_win 
        FROM played_match
        WHERE (team_a_id = " . (int)$_GET['teamid'] . " OR team_b_id = " . (int)$_GET['teamid'] . ") AND
            winning_team_id = " . (int)$_GET['teamid'];
    $stmt = $conn->prepare($getTotalTeamWins);
    $stmt->execute();
    $total_wins = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_wins = $total_wins['total_win']; 

    $getTotalTeamLosses = "SELECT count(*) AS total_loss 
        FROM played_match
        WHERE (team_a_id = " . (int)$_GET['teamid'] . " OR team_b_id = " . (int)$_GET['teamid'] . ") AND
            losing_team_id = " . (int)$_GET['teamid'];
    $stmt = $conn->prepare($getTotalTeamLosses);
    $stmt->execute();
    $total_loss = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_loss = $total_loss['total_loss'];

    $getTeamDetails = "SELECT * FROM team WHERE id = " . (int)$_GET['teamid'];
    $stmt = $conn->prepare($getTeamDetails);
    $stmt->execute();
    $team_details = $stmt->fetch(PDO::FETCH_ASSOC);

    $getLadders = "SELECT * FROM ladder";
    $stmt = $conn->prepare($getLadders);
    $stmt->execute();
    $ladders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $getTeamMembers = "SELECT player.name 
        FROM player, team
        WHERE team.id = " . (int)$_GET['teamid'] . " AND 
        team.id = player.team_id;";
    $stmt = $conn->prepare($getTeamMembers);
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div class=>';
    echo '</div>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Team Card</title>
  <script src="js/code.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
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
  <section class="container" style="background-color: <?php echo $team_details['color']; ?>">
    <div class="title">
    <h1><?php echo $team_details['team_name']; ?></h1></div>
    <div class="detailedteamcard">
      <div class="teamcard">
      <img src="img/<?php echo $team_details['image'] ?>" height="64" width="64" alt="teams logo">
        <p><?php echo count($members) . ' - '; foreach($members as $member) { echo $member['name'] . ' '; } ?></p>

        <div class="teamstats">
<?php 
    foreach ($ladders as $ladder) {

        $ladderLoss = "SELECT count(*) AS loss 
            FROM played_match
            WHERE ladder_id = " . $ladder['id'] . " AND 
            losing_team_id = " . (int)$_GET['teamid'];

            $stmt = $conn->prepare($ladderLoss);
            $stmt->execute();
            $losses = $stmt->fetch(PDO::FETCH_ASSOC);

        $ladderWins = "SELECT count(*) AS win  
            FROM played_match
            WHERE ladder_id = " . $ladder['id'] . " AND 
            winning_team_id = " . (int)$_GET['teamid'];

            $stmt = $conn->prepare($ladderWins);
            $stmt->execute();
            $wins = $stmt->fetch(PDO::FETCH_ASSOC);

?>
          <div>
            <img src="img/<?php echo $ladder['image']; ?>" alt="TF2 Logo">
            <p>W: <?php echo $wins['win'] ?></p>
            <p>L: <?php echo $losses['loss'] ?></p>
          </div>
<?php } ?>
          <div class="totalstats">
            <h2>Total</h2>
            <p>W: <?php echo $total_wins; ?></p>
            <p>L: <?php echo $total_loss; ?></p>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
</body>

</html>
