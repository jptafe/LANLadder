<?php
    class databaseObject {
        private $conn;
        public function __construct() {
            try {
                //$this->conn = new PDO("mysql:host=localhost;dbname=LANLadder", 'root',''); // DEV
                $this->conn = new PDO("mysql:host=127.0.0.1;dbname=lanladder", 'lluser','llpassword'); // DOCKER 
//                $this->conn = new PDO("mysql:host=127.0.0.1;port=51051;dbname=localdb", 'azure','6#vWHD_$'); // Azure
//                $this->conn = new PDO("mysql:host=aa1rdt1oikf2nc.cqbylsinlsjf.us-west-2.rds.amazonaws.com;port=3306;dbname=ebdb", 'adminuser','thisisapassword'); // AWS
//                $this->conn = new PDO("mysql:unix_socket=cmssubdomains:australia-southeast1:lanladder;dbname=LANLadder", 'root','b0KJK8Ih5CbjC1Bd'); // GCP
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // DEBUG
            }
            catch(PDOException $e) {
                echo $e;
                //echo json_encode(Array("error"=>"Database Connection Error")); // This is debug. INSTEAD: echo json_encode(Array('error'=>'true'));
                die();
            }
        }
        public function ladderlist($ladderID) {
          try {
                $getLadder = "SELECT distinct(winning_team_id) AS teama,
                    (SELECT count(winning_team_id) FROM played_match
                        WHERE winning_team_id = teama AND winning_team_id > 2 AND losing_team_id > 2
                        AND ladder_id = :ladderid) AS wins,
                    (SELECT count(losing_team_id) FROM played_match
                        WHERE losing_team_id = teama AND winning_team_id > 2 AND losing_team_id > 2
                        AND ladder_id = :ladderid) AS losses
                            FROM `played_match`
                            WHERE winning_team_id > 2 AND losing_team_id > 2 AND ladder_id = :ladderid AND
				                winning_team_id != losing_team_id
                            GROUP BY teama
                UNION
                SELECT distinct(losing_team_id) AS teamb,
                    (SELECT count(winning_team_id) FROM played_match
                        WHERE winning_team_id = teamb AND winning_team_id > 2 AND losing_team_id > 2
                        AND ladder_id = :ladderid) AS wins,
                    (SELECT count(losing_team_id) FROM played_match
                        WHERE losing_team_id = teamb AND winning_team_id > 2 AND losing_team_id > 2
                        AND ladder_id = :ladderid) AS losses
                            FROM `played_match`
                            WHERE winning_team_id > 2 AND losing_team_id > 2 AND ladder_id = :ladderid AND
				                winning_team_id != losing_team_id
                            GROUP BY teamb
                     ORDER by wins DESC, losses ASC";
                // We need add to ladder with those teams that won against a forefit but not tie
                $stmt = $this->conn->prepare($getLadder);
                $stmt->bindParam(':ladderid', $ladderID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "ladderlist error"; die();
            }
        }
        public function allLadders() {
            try {
                $query = "SELECT * FROM ladder"; // Possiably replace this with a procedure
                $stmt = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "allladders error"; die();
            }
        }
        public function allTeamlist() {
            try {
                $team_list = "SELECT * FROM team WHERE id > 2;";
                $stmt = $this->conn->prepare($team_list);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "allTeamList error"; die();
            }
        }
        public function playersNotinTeam() {
            try {
                $noteam = "SELECT name, loc, image, team_id FROM player WHERE team_id = 1
                    AND user_privileges = 0";
                $stmt = $this->conn->prepare($noteam);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "playersNotinTeam error"; die();
            }
        }
        public function allPlayers() {
            try {
                $players = "SELECT id, name, seated_loc, image, team_id FROM player WHERE user_privileges = 0";
                $stmt = $this->conn->prepare($players);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "playersinTeam"; die();
            }
        }
        public function playersinTeam($teamID) {
            try {
                $playersinteam = "SELECT id, name, seated_loc, image, team_id FROM player WHERE team_id = :teamid
                    AND user_privileges = 0";
                $stmt = $this->conn->prepare($playersinteam);
                $stmt->bindParam(':teamid', $teamID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "playersinTeam"; die();
            }
        }
        public function teamsinLadder($ladderID) {
            try {
                $team_list = "SELECT DISTINCT * FROM team
                    JOIN played_match
                    ON (team.id = played_match.team_a_id OR team.id = played_match.team_b_id)
                    WHERE team.ladder_id = :ladderid";
                $stmt = $this->conn->prepare($team_list);
                $stmt->bindParam(':ladderid', $ladderID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "teamsInLadder Error"; die();
            }
        }
        public function reportPlayedmatch($matchID, $winner, $loser) {
            try {
                $check_sql = 'SELECT * from played_match WHERE id = :matchid';
                $stmt = $this->conn->prepare($check_sql);
                $stmt->bindParam(':matchid', $matchID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if(sizeof($result) > 0) {
                    if(($result['team_a_id'] == $winner || $result['team_a_id'] == $loser) &&
                            ($result['team_b_id'] == $winner || $result['team_b_id'] == $loser)) {
                        $sql = 'UPDATE played_match SET winning_team_id = :winner, 
                        losing_team_id = :loser WHERE id = :matchid';
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(':winner', $winner, PDO::PARAM_INT);
                        $stmt->bindParam(':loser', $loser, PDO::PARAM_INT);
                        $stmt->bindParam(':matchid', $matchID, PDO::PARAM_INT);
                        $result = $stmt->execute();
                        if($result == false) {
                            return Array("matchreport"=>"fail");
                        } else {
                            return Array("matchreport"=>"success");
                        }
                    }
                }
                return Array("matchreport"=>"fail");
            } catch(PDOException $e) {
                echo $e;
                echo "match report error"; die();
            }
        }
        function allPlayedMatches() {
            try {
                $matches = "SELECT * FROM played_match WHERE played_match.winning_team_id > 2
                    AND played_match.losing_team_id > 2";
                $stmt = $this->conn->prepare($matches);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "played matches error"; die();
            }
        }
        function allUnReportedMatches() {
            try {
                $matches = "SELECT * FROM played_match WHERE played_match.winning_team_id < 3
                    OR played_match.losing_team_id < 3";
                $stmt = $this->conn->prepare($matches);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "playersinTeam"; die();
            }
        }
        function unreportedMatchesByLadder($ladderID) {
            try {
                $matches = "SELECT id, team_a_id, team_b_id, ladder_id,
                            	(select team.team_name FROM team WHERE team.id = played_match.team_a_id) AS team_a_name,
                            	(select team.team_name FROM team WHERE team.id = played_match.team_b_id) AS team_b_name
                                FROM `played_match`
                            	WHERE (winning_team_id < 2 OR losing_team_id < 2) AND ladder_id = :ladderid";
                $stmt = $this->conn->prepare($matches);
                $stmt->bindParam(':ladderid', $ladderID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "playersinTeam"; die();
            }
        }
        public function createTeam($playerID, $teamname, $color, $imageurl) {
            try {
                $query = "INSERT INTO team (team_name, color, image)
                    VALUES (:tname, :color, :img)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':tname', $teamname);
                $stmt->bindParam(':color', $color);
                $stmt->bindParam(':img', $imageurl);
                $result = $stmt->execute();
                //update playerid with $conn->lastInsertId();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"created new team");
                }
            } catch (PDOException $e) {
                echo "createTeam error"; die();
            }
        }
        public function joinTeam($playerID, $teamID) {
            try {
                $query = "UPDATE player SET player.team_id = :team
                    WHERE player.id = :player";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':player', $playerID, PDO::PARAM_INT);
                $stmt->bindParam(':team', $teamID, PDO::PARAM_INT);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"joined a team");
                }
            } catch (PDOException $e){
                echo "joinTeam error"; die();
            }
        }
        public function createPlayer($name, $pass, $loc, $image, $teamid) {
            try {
                $HashedPassword = password_hash($pass, PASSWORD_DEFAULT);
                $query = 'INSERT INTO player (name, pass, seated_loc, image, team_id)
                    VALUES (:name , :pass, :loc, :imageurl, :team)';
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':pass', $HashedPassword);
                $stmt->bindParam(':loc', $loc);
                $stmt->bindParam(':imageurl', $image);
                $stmt->bindParam(':team', $teamid, PDO::PARAM_INT);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"created a player");
                    //$conn->lastInsertId();
                }
            } catch (PDOException $e) {
                echo $e;
                echo "createPlayer error"; die();
            }
        }
        public function createMatch($team_a, $team_b, $ladder, $start) {
            try {
                $query = 'INSERT INTO played_match (team_a_id, team_b_id,
                    ladder_id, winning_team_id, losing_team_id, match_start)
                    VALUES (:team_a, :team_b, :ladder, 1, 1, :start)'; // 1 is unset
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':team_a', $team_a, PDO::PARAM_INT);
                $stmt->bindParam(':team_b', $team_b, PDO::PARAM_INT);
                $stmt->bindParam(':ladder', $ladder, PDO::PARAM_INT);
                $stmt->bindParam(':start', $start, PDO::PARAM_STR);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"created a match");
                }
            } catch (PDOException $e) {
                echo $e;
                echo "createMatch error"; die();
            }
        }
        public function createLadder($name, $description, $members, $color, $image, $start) {
            try{
                $query = 'INSERT INTO ladder (game, description,
                    players, start_time, color, image)
                    VALUES (:name, :desc, :members, :start, :color, :image)';
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':desc', $description, PDO::PARAM_STR);
                $stmt->bindParam(':start', $start, PDO::PARAM_STR);
                $stmt->bindParam(':color', $color, PDO::PARAM_STR);
                $stmt->bindParam(':image', $image, PDO::PARAM_STR);
                $stmt->bindParam(':members', $members, PDO::PARAM_INT);
                $stmt->bindParam(':start', $start, PDO::PARAM_STR);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"created a ladder");
                }
            } catch (PDOException $e) {
                echo "createLadder error"; die();
            }
        }
        public function removeTeam($teamID) {
///////////// Check to see if team has players first!
            try {
                $query = "DELETE FROM team WHERE id = :teamid";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':teamid', $teamID, PDO::PARAM_INT);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"remove a team");
                }
            } catch (PDOException $e) {
                echo "removeTeam error"; die();
            }
        }
        public function removePlayerFromTeam($playerID) {
            try {
                $query = "UPDATE user SET (team_id = 1) WHERE id = :playerid";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':playerid', $playerID, PDO::PARAM_INT);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"removed player from team");
                }
            } catch (PDOException $e) {
                echo "removePlayerFromTeam error"; die();
            }
        }
        public function teamsWithZeroPlayerslist() { // Probably not needed
            try {
                $teams = "SELECT DISTINCT * FROM team
                    WHERE NOT EXISTS (
                        SELECT team_id FROM player
                            WHERE team.id = player.team_id)";
                $stmt = $this->conn->prepare($teams);
                $stmt->bindParam(':ladderid', $ladderID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "teamsWithZeroPlayersList Error"; die();
            }
        }
        public function getTeam($teamid) { // Probably not needed
            try {
                $team = "SELECT * FROM team WHERE id = :teamid";
                $stmt = $this->conn->prepare($team);
                $stmt->bindParam(':teamid', $teamid, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "Get team Error"; die();
            }
        }        
        public function ladderTeamlist($ladderID) {
            try {
                $teaminladder = "SELECT UNIQUE * FROM team
                    JOIN ladder ON team.ladder_id = ladder
                        WHERE team.ladder_id = :ladderID";
                $stmt = $this->conn->prepare($teaminladder);
                $stmt->bindParam(':ladderid', $ladderID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "ladderTeamlist error"; die();
            }
        }
        public function incompleteMatches($playerID, $ladderID) {
            try {
                $incomplete_matches = "SELECT * FROM played_match
                    JOIN player ON player.team_id = played_match.team_a_id
                        OR player.team_id = played_match.team_b_id
                            WHERE (losing_team_id = 1 OR winning_team_id = 1)
                            AND (played_match.ladder_id = :ladderid
                            AND (player.team_id = :playerid)";
                $stmt = $this->conn->prepare($incomplete_matches);
                $stmt->bindParam(':playerid', $playerID, PDO::PARAM_INT);
                $stmt->bindParam(':ladderid', $ladderID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch(PDOException $e) {
                echo "incompleteMatches error"; die();
            }
        }
        public function matchesPlayedbyTeam($teamID, $ladderID) {
            try {
                $complete_matches = "SELECT * FROM played_match
                    WHERE (losing_team_id > 1 AND winning_team_id > 1)
                    AND (team_a_id = :team OR team_b_id = :team)
                        AND ladder_id = :ladder
                            ORDER BY ladder_id";
                $stmt = $this->conn->prepare($complete_matches);
                $stmt->bindParam(':ladder', $ladderID, PDO::PARAM_INT);
                $stmt->bindParam(':team', $teamID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch (PDOException $e) {
                echo "matchesPlayedbyTeam error"; die();
            }
        }
        public function isTeaminLadder($teamID, $ladderID) {
            try {
                $teaminladder = "SELECT UNIQUE * FROM team
                    JOIN played_match ON (played_match.team_a_id = team.id OR
                        played_match.team_b_id = team.id)
                        WHERE team.id = :teamid
                        AND played_match.ladder_id = :ladderid";
                $stmt = $this->conn->prepare($teaminladder);
                $stmt->bindParam(':teamid', $teamID, PDO::PARAM_INT);
                $stmt->bindParam(':ladderid', $ladderID, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return $result;
                }
            } catch (PDOException $e) {
                echo "isTeaminLadder error"; die();
            }
        }
        public function doesUserNameExist($name) {
            try {
                $auth = "SELECT * FROM player WHERE name = :username";
                $stmt = $this->conn->prepare($auth);
                $stmt->bindParam(':username', $name, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result == false) {
                    return Array("user"=>'notfound');
                } else {
                    return Array("user"=>"exists");
                }
            } catch (PDOException $e) {
                echo "User Name error"; die();
            }
        }
        public function doesLadderNameExist($name) {
            try {
                $auth = "SELECT * FROM ladder WHERE game = :laddername";
                $stmt = $this->conn->prepare($auth);
                $stmt->bindParam(':laddername', $name, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result == false) {
                    return Array("ladder"=>'notfound');
                } else {
                    return Array("ladder"=>"exists");
                }
            } catch (PDOException $e) {
                echo "Ladder Name error"; die();
            }
        }
        public function doesTeamNameExist($name) {
            try {
                $auth = "SELECT * FROM team WHERE team_name = :teamname";
                $stmt = $this->conn->prepare($auth);
                $stmt->bindParam(':teamname', $name, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result == false) {
                    return Array("team"=>'notfound');
                } else {
                    return Array("team"=>"exists");
                }
            } catch (PDOException $e) {
                echo "Team Name error"; die();
            }
        }
        public function userIDExist($id) {
            try {
                $auth = "SELECT * FROM player WHERE id = :userid";
                $stmt = $this->conn->prepare($auth);
                $stmt->bindParam(':userid', $id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result == false) {
                    return Array("user"=>'notfound');
                } else {
                    return $result;
                }
            } catch (PDOException $e) {
                echo "Auth error"; die();
            }
        }
        public function authPlayer($username, $password) {
            try {
                $auth = "SELECT * FROM player WHERE name = :username";
                $stmt = $this->conn->prepare($auth);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result == false) {
                    return Array("name"=>-1);
                } else {
                    if(password_verify($password, $result['pass'])) {
                        return $result;
                    } else {
                        return Array("name"=>-1);
                    }
                }
            } catch (PDOException $e) {
                echo "Auth error"; die();
            }
        }
        public function getLANStatus() {
            $allplayers = $this->allPlayers();
            $allplayersHash = hash('md2', json_encode($allplayers));
            $allplayersCount = sizeof($allplayers);
            
            $allladders = $this->allLadders();
            $allladdersHash = hash('md2', json_encode($allladders));
            $allladdersCount = sizeof($allladders);
            
            $allteams = $this->allTeamlist();
            $allteamsHash = hash('md2', json_encode($allteams));
            $allteamsCount = sizeof($allteams);
            
            $allplayedmatches = $this->allPlayedMatches();
            $allplayedmatchesHash = hash('md2', json_encode($allplayedmatches));
            $allplayedmatchesCount = sizeof($allplayedmatches);
            
            $allunplayedmatches = $this->allUnReportedMatches();
            $allunplayedmatchesHash = hash('md2', json_encode($allunplayedmatches));
            $allunplayedmatchesCount = sizeof($allunplayedmatches);
            
            return Array(
                'players'=>Array('hash'=>$allplayersHash,'size'=>$allplayersCount), 
                'ladders'=>Array('hash'=>$allladdersHash,'size'=>$allladdersCount), 
                'teams'=>Array('hash'=>$allteamsHash,'size'=>$allteamsCount), 
                'playedmatches'=>Array('hash'=>$allplayedmatchesHash,'size'=>$allplayedmatchesCount), 
                'unplayedmatches'=>Array('hash'=>$allunplayedmatchesHash,'size'=>$allunplayedmatchesCount)
            );
            
        }
        public function logEvent() {
            return Array("request"=>"log an event");
        }
    }
?>
