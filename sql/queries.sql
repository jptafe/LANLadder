-- Get all ladders order by start time
SELECT * FROM ladder ORDER BY start_time;

-- get all users
SELECT * FROM users

-- get all users group by team
SELECT team.team_name, player.name 
    FROM team, player 
        WHERE team.id = player.team_id     
        GROUP BY team.team_name
        ORDER BY team.team_name ASC

-- get all teams and their wins
SELECT team.team_name, count(played_match.winning_team_id) 
	FROM team  
		JOIN played_match ON team.id = played_match.winning_team_id
		GROUP BY team.team_name
		ORDER BY team.team_name ASC

-- get all teams and their losses
