<!DOCTYPE html>
<html lang="en">

<?php
    include 'functions.php';
	dom_head();
	echo '<body>';
    $conn = dbconnect();

    $getTotalTeamWins = "SELECT count(*) AS total_win 
        FROM played_match
        WHERE (team_a_id = " . (int)$_GET['teamid'] . " OR team_b_id = " . (int)$_GET['teamid'] . ") AND
            winning_team_id = " . (int)$_GET['teamid'] . " AND 
			losing_team_id > 1";
    $stmt = $conn->prepare($getTotalTeamWins);
    $stmt->execute();
    $total_wins = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_wins = $total_wins['total_win']; 
    // Getting the number of wins for the requested team

    $getTotalTeamLosses = "SELECT count(*) AS total_loss 
        FROM played_match
        WHERE (team_a_id = " . (int)$_GET['teamid'] . " OR team_b_id = " . (int)$_GET['teamid'] . ") AND
            losing_team_id = " . (int)$_GET['teamid'] . " AND 
			winning_team_id > 1";
    $stmt = $conn->prepare($getTotalTeamLosses);
    $stmt->execute();
    $total_loss = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_loss = $total_loss['total_loss'];
    // Getting the number of loses for the requested teams 

    $getTeamDetails = "SELECT * FROM team WHERE id = " . (int)$_GET['teamid'];
    $stmt = $conn->prepare($getTeamDetails);
    $stmt->execute();
    $team_details = $stmt->fetch(PDO::FETCH_ASSOC);

    $getLadders = "SELECT * FROM ladder";
    $stmt = $conn->prepare($getLadders);
    $stmt->execute();
    $ladders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Getting all the games for the Lan

    $getTeamMembers = "SELECT player.name 
        FROM player, team
        WHERE team.id = " . (int)$_GET['teamid'] . " AND 
        team.id = player.team_id;";
    $stmt = $conn->prepare($getTeamMembers);
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    dom_nav();
?>
  <section class="container" style="background-color: <?php echo $team_details['color']; ?>">
    <div class="title">
    <h1><?php echo $team_details['team_name']; ?></h1></div>
    <div class="detailedteamcard">
      <div class="teamcard">
      <img src="img/<?php echo $team_details['image'] ?>" height="64" width="64" alt="teams logo">
        <ul class="collection with-header">
        <?php 
        echo  '<li class="collection-header transparent white-text"> Total number of players: '  .  count($members) . '</li>'; 
        $count = 1; // Showing all the members with numbers beside their names
        foreach($members as $member) { 
            echo '<li class="collection-item transparent white-text">' . $count++ .  ' - ' .  $member['name'] . '</li>'; 
        } ?>
        </ul>

        <div class="teamstats">
<?php 
    foreach ($ladders as $ladder) {

        $ladderLoss = "SELECT count(*) AS loss 
            FROM played_match
            WHERE ladder_id = " . $ladder['id'] . " AND 
            losing_team_id = " . (int)$_GET['teamid'] . " AND 
			winning_team_id > 1";

            $stmt = $conn->prepare($ladderLoss);
            $stmt->execute();
            $losses = $stmt->fetch(PDO::FETCH_ASSOC);

        $ladderWins = "SELECT count(*) AS win  
            FROM played_match
            WHERE ladder_id = " . $ladder['id'] . " AND 
            winning_team_id = " . (int)$_GET['teamid'] . " AND 
			losing_team_id > 1";

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

<!-- list any matches with a TeamID in either team_a or team_b and a 1 in either winning team or losing team -->
<?php

	$incomplete_matches = "SELECT * FROM `played_match` 
			WHERE (losing_team_id = 1 OR winning_team_id = 1) 
			AND (team_a_id = " . $_SESSION['TeamID'] . " OR team_b_id = " . $_SESSION['TeamID'] . ")
			ORDER BY ladder_id";

    $stmt = $conn->prepare($incomplete_matches);
    $stmt->execute();
    $matchlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
	print_r($matchlist);
?>
	<div class="teamcard">
		<h4>Incomplete Matches</h4>
		<p>FOO</p>
    </div>
  </section>
</body>

</html>
