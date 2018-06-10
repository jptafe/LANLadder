-- DATABASE SELECTS
-- Get all ladders order by start time
SELECT * FROM ladder ORDER BY start_time;

-- get all users order aphabetically
SELECT * FROM users ORDER BY users.name;

-- count all teams

-- only list teams that have players in them

-- list the ladders that have matches scheduled/played

-- get all users group by team
SELECT team.team_name, player.name 
    FROM team, player 
        WHERE team.id = player.team_id     
        GROUP BY team.team_name
        ORDER BY team.team_name ASC

-- get all teams order by their total wins

-- get all teams and their wins
SELECT team.team_name, count(played_match.winning_team_id) 
	FROM team  
		JOIN played_match ON team.id = played_match.winning_team_id
		GROUP BY team.team_name
		ORDER BY team.team_name ASC

-- get all teams and their losses

-- show matches that don't yet have complete results yet.

-- Name each of the team names involed in matches

-- Name the teams that have no members - and delete
 
-- Name the teams with more than one member


-- DATABASE CHANGES
-- insert new user (team_id unset value)

-- insert new team (update player that created it)

-- update player with different team 

-- insert new ladder

-- insert new played_match with teams & dummy winner/loser team

-- update match with winner ID

-- update match with loser ID

-- update both winner & loser data at the same time. 

