<!DOCTYPE html>
<html lang="en">

<?php
    include '../functions.php';
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
		echo '<form action="process_result.php?teamid=' . $_SESSION['TeamID'] . '&matchid=' . $match['id'] . '" method="post">';
		echo '<select>';
		echo '<option value="win">Win</option>';
		echo '<option value="loss">Loss</option>';
		echo '</select>';
		echo '</form>';
	}

?>
    </div>
  </section>
</html>
