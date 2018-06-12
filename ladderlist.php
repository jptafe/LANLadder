<html lang="en">

<?php

    include 'functions.php';
    dom_head();
    echo '<body>';

    $conn = dbconnect();

    $getLadder = "SELECT DISTINCT team.id, team.team_name, team.image, team.color  
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

	dom_nav();

?>

  <section class="container" style="background-color: <?php echo $ladder_details['color']; ?>">
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
    <div class="ladderitem" style="background-color: <?php echo $ladder_item['color']; ?>">
      <aside class="text-shadow"><a href="teamcard.php?teamid=<?php echo $ladder_item['id'] . "\">" . $ladder_item['team_name']; ?></a></aside>
      <aside><img src="img/<?php echo $ladder_item['image']; ?>" height="64" width="64"></aside>
      <aside class="text-shadow">Wins: <?php echo $total_wins['total_win']; ?></aside>
      <aside class="text-shadow">Losses: <?php echo $total_loss['total_loss'];?></aside>
      <aside class="text-shadow">Total: <?php echo $totalgames; ?></aside>
    </div>
<?php } ?>
  </section>
</body>

</html>
