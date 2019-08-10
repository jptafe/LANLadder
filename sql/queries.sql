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

-- Get all matches with unset winner or loser (value of 1)
SELECT * FROM `played_match` WHERE (losing_team_id = 1 OR winning_team_id = 1) AND (team_a_id = ? OR team_b_id = ?)

-- show matches that don't yet have complete results yet (1 means match with no result)
SELECT * FROM played_match 
    WHERE winning_team_id = 1 OR losing_team_id = 1

-- Name each of the team names involed in matches for 'CS GO' ladder
SELECT P.`id`, T.`team_name`, E.`team_name_b`, P.`ladder_id`, W.`team_name_winner`, L.`team_name_loser`, P.`match_start` FROM `team` AS T
inner join `played_match` AS P ON T.`id` = P.`team_a_id`
join (select `id` as `id_b`, `team_name` as `team_name_b` from `team`) as E on P.`team_b_id` = E.`id_b`
join (select `id` as `id_c`, `team_name` as `team_name_winner` from `team`) as W on P.`winning_team_id` = W.`id_c`
join (select `id` as `id_d`, `team_name` as `team_name_loser` from `team`) as L on P.`losing_team_id` = L.`id_d`
WHERE P.`ladder_id` = '3'
ORDER BY P.`id`

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



-- LADDER Most Important:
-- Show wins in order of Most to least, but this is not enough, I have to count the losses too!
SELECT played_match.winning_team_id, team.team_name, count(winning_team_id) AS wins
	FROM `played_match`
	JOIN team ON team.id = played_match.winning_team_id
	WHERE ladder_id = 3 AND winning_team_id > 2 AND losing_team_id > 2
	GROUP BY winning_team_id
		ORDER BY wins DESC

-- Show losses in order of least to most
SELECT played_match.losing_team_id, team.team_name, count(winning_team_id) AS wins
	FROM `played_match`
	JOIN team ON team.id = played_match.losing_team_id
	WHERE ladder_id = 3 AND winning_team_id > 2 AND losing_team_id > 2
	GROUP BY losing_team_id
		ORDER BY wins ASC 

-- union ensures that we include a count of losing teams & winning teams
SELECT distinct(winning_team_id) AS teama,
    (SELECT count(winning_team_id) FROM played_match
        WHERE winning_team_id = teama AND winning_team_id > 2 AND losing_team_id > 2) AS wins,
    (SELECT count(losing_team_id) FROM played_match
        WHERE losing_team_id = teama AND winning_team_id > 2 AND losing_team_id > 2) AS losses
            FROM `played_match`
            WHERE winning_team_id > 2 AND losing_team_id > 2 AND ladder_id = 3
            GROUP BY teama
UNION
SELECT distinct(losing_team_id) AS teamb,
    (SELECT count(winning_team_id) FROM played_match
        WHERE winning_team_id = teamb AND winning_team_id > 2 AND losing_team_id > 2) AS wins,
    (SELECT count(losing_team_id) FROM played_match
        WHERE losing_team_id = teamb AND winning_team_id > 2 AND losing_team_id > 2) AS losses
            FROM `played_match`
            WHERE winning_team_id > 2 AND losing_team_id > 2 AND ladder_id = 3
            GROUP BY teamb
     ORDER by wins DESC, losses ASC
