<!DOCTYPE html>
<html lang="en">

<?php
    include 'functions.php';
    dom_head();
    echo '<body>';
    $conn = dbconnect();

?>

<!--

    Any team member can report a result for their team, but both winner & loser must report for the ladder to register the activity

-->
<!-- list any matches with a TeamID in either team_a or team_b and a 1 in either winning team or losing team -->

  </section>
    <div class="teamcard">
        <h4>Incomplete Matches</h4>
<?php

    $incomplete_matches = "SELECT * FROM `played_match` 
            WHERE (losing_team_id = 1 OR winning_team_id = 1) 
            AND (team_a_id = " . $_SESSION['TeamID'] . " OR team_b_id = " . $_SESSION['TeamID'] . ")
            ORDER BY ladder_id";

    $stmt = $conn->prepare($incomplete_matches);
    $stmt->execute();
    $matchlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
	foreach($matchlist AS $match) {

		$ladderDetail = "SELECT * FROM ladder WHERE id = " . $match['ladder_id'];
		if($_SESSION['TeamID'] == $match['team_a_id']) {
			$opposing_team = "SELECT * FROM team WHERE id = " . $match['team_b_id'];
		} else {
    		$opposing_team = "SELECT * FROM team WHERE id = " . $match['team_a_id'];
		}

		$stmt = $conn->prepare($ladderDetail);
		$stmt->execute();
		$ladder = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$stmt = $conn->prepare($opposing_team);
		$stmt->execute();
		$opposition = $stmt->fetch(PDO::FETCH_ASSOC);
		
		echo '<form action="control/process_result.php?teamid=' . $_SESSION['TeamID'] . '&matchid=' . $match['id'] . '" method="post">';
		echo '<div>'; 
		echo '<img src="img/' . $ladder['image'] . '" height="64" width="64">&nbsp;' . $ladder['game'];
		echo '</div><div>';
		echo '<img src="img/' . $opposition['image'] . '" height="64" width="64">&nbsp;' . $opposition['team_name'];
		echo '</div>';
		echo '<select class="input-field">';
		echo '<option value="win">Win</option>';
		echo '<option value="loss">Loss</option>';
		echo '</select>';
		echo '<input type="submit" value="Report">';
		echo '</form>';
	}
?>
    </div>
  </section>
</html>
