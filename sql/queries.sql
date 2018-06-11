-- DATABASE SELECTS
-- Get all ladders order by start time
SELECT * FROM ladder ORDER BY start_time;

-- get all users order aphabetically
SELECT * FROM users ORDER BY users.name;

-- count all teams
SELECT count(*) FROM teams

-- only list teams that have players in them
SELECT * FROM team WHERE team.id IN (SELECT id FROM player)

-- list the ladders that have matches scheduled/played
SELECT distinct(ladder.game) FROM ladder 
    JOIN played_match ON ladder.id = played_match.ladder_id

-- get all users group by team
SELECT team.team_name, player.name 
    FROM team, player 
        WHERE team.id = player.team_id     
        GROUP BY team.team_name
        ORDER BY team.team_name ASC

-- get all teams order by their total games 

-- get all teams order by their total games group by ladder 

-- wins/losses for a team for a ladder
--WINS
SELECT count(*)
    FROM played_match 
    WHERE (team_a_id = 3 OR team_b_id = 3) AND
        winning_team_id = 3

--LOSSES
SELECT count(*)
    FROM played_match 
    WHERE (team_a_id = 3 OR team_b_id = 3) AND
        losing_team_id = 3
--ALL
SELECT count(*)
    FROM played_match 
    WHERE (team_a_id = 3 OR team_b_id = 3)


-- get all teams and their wins
SELECT team.team_name, count(played_match.winning_team_id) 
	FROM team  
		JOIN played_match ON team.id = played_match.winning_team_id
		GROUP BY team.team_name
		ORDER BY team.team_name ASC

-- get all teams and their losses
SELECT team.team_name, count(played_match.winning_team_id) 
	FROM team  
		JOIN played_match ON team.id = played_match.winning_team_id
		GROUP BY team.team_name
		ORDER BY team.team_name ASC

-- show matches that don't yet have complete results yet (1 means match with no result)
SELECT * FROM played_match 
    WHERE winning_team_id = 1 OR losing_team_id = 1

-- Name each of the team names involed in matches for 'CS GO' ladder

-- Name the teams that have no members - and delete (except for 1 - unset)
SELECT * FROM team 
    WHERE id NOT IN (select team_id FROM player);
 
-- Name the teams with more than one member
SELECT team.name 
    FROM player, team 
    WHERE team.id = player.team_id 
        GROUP BY team_id HAVING count(team_id) > 1;

-- DATABASE CHANGES
-- insert new user (team_id unset value)

-- insert new team (update player that created it)

-- update player with different team 

-- insert new ladder

-- insert new played_match with teams & dummy winner/loser team

-- update match with winner ID

-- update match with loser ID

-- update both winner & loser data at the same time. 

