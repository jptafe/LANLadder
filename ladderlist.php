<?php

    include 'functions.php';

    $conn = dbconnect();

    $getLadder = "SELECT DISTINCT team.id, team.team_name, team.image  
		FROM team JOIN played_match on team.id = played_match.winning_team_id
			WHERE played_match.losing_team_id > 1 AND
			played_match.ladder_id = " . (int)$_GET['gameid']; 
    $stmt = $conn->prepare($getLadder);
    $stmt->execute();
    $ladder_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $getLadderDetails = "SELECT * FROM ladder WHERE id = " . (int)$_GET['gameid'];
    $stmt = $conn->prepare($getLadderDetails);
    $stmt->execute();
    $ladder_details = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LANLadder ladderlist</title>
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
  <section class="container">
    <div class="title">
      <h1><?php echo $ladder_details['game']; ?></h1>
	</div>


<?php

    foreach($ladder_list as $ladder_item) {


		$getTotalTeamWins = "SELECT count(*) AS total_win 
			FROM played_match
			WHERE (team_a_id = " . $ladder_item['id'] . " OR team_b_id = " . $ladder_item['id'] . ") AND
				winning_team_id = " . $ladder_item['id'] . " AND 
				losing_team_id > 1 AND ladder_id = " . (int)$_GET['gameid'];
		$stmt = $conn->prepare($getTotalTeamWins);
		$stmt->execute();
		$total_wins = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_wins['total_win'];

		$getTotalTeamLosses = "SELECT count(*) AS total_loss 
			FROM played_match
			WHERE (team_a_id = " . $ladder_item['id'] . " OR team_b_id = " . $ladder_item['id'] . ") AND
				losing_team_id = " . $ladder_item['id'] . " AND 
				winning_team_id > 1 AND ladder_id = " . (int)$_GET['gameid'];
		$stmt = $conn->prepare($getTotalTeamLosses);
		$stmt->execute();
		$total_loss = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_loss['total_loss'];

		$totalgames = $total_wins['total_win'] + $total_loss['total_loss'];


?>
    <div class="ladderitem">
      <aside><a href="teamcard.php?teamid=<?php echo $ladder_item['id'] . "\">" . $ladder_item['team_name']; ?></a></aside>
      <aside><img src="img/<?php echo $ladder_item['image']; ?>" height="64" width="64"></aside>
      <aside>Wins: <?php echo $total_wins['total_win']; ?></aside>
      <aside>Losses: <?php echo $total_loss['total_loss'];?></aside>
      <aside>Total: <?php echo $totalgames; ?></aside>
    </div>
<?php } ?>
  </section>
</body>

</html>
