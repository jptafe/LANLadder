<?php
    class databaseObject {
        private $conn;
        public function __construct() {
            try {
                $this->conn = new PDO("mysql:host=localhost;dbname=LANLadder", 'root','');
                //$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // DEBUG
            }
            catch(PDOException $e) {
                echo json_encode(Array("error"=>"Database Connection Error")); // This is debug. INSTEAD: echo json_encode(Array('error'=>'true'));
                die();
            }
        }
        public function ladderlist($ladderID) {
          try {
                $getLadder = "SELECT DISTINCT team.id, team.team_name, team.image, team.color
                    FROM team JOIN played_match ON (team.id = played_match.team_a_id OR played_match.team_b_id)
                        WHERE played_match.winning_team_id > 1 AND
                        played_match.losing_team_id > 1 AND
                        played_match.ladder_id = :ladderid";
                // no order by...?
                $stmt = $this->conn->prepare($getLadder);
                $stmt->bindParam(':ladderid', $ladderID);
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
                    return Array("request"=>"all ladders");
                }
            } catch(PDOException $e) {
                echo "allladders error"; die();
            }
        }
        public function allTeamlist() {
            try {
                $team_list = "SELECT * FROM team;";
                $stmt = $this->conn->prepare($team_list);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"all teams");
                }
            } catch(PDOException $e) {
                echo "allTeamList error"; die();
            }
        }
        public function playersNotinTeam() {
            try {
                $noteam = "SELECT * FROM player WHERE team_id = 1";
                $stmt = $this->conn->prepare($noteam);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"players not in a team");
                }
            } catch(PDOException $e) {
                echo "playersNotinTeam error"; die();
            }
        }
        public function playersinTeam($teamID) {
            try {
                $playersinteam = "SELECT * FROM player WHERE team_id = :teamid";
                $stmt = $this->conn->prepare($playersinteam);
                $stmt->execute();
                $stmt->bindParam(':teamid', $teamID);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"players in a specific team");
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
                $stmt->bindParam(':ladderid', $ladderID);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"teams in ladder");
                }
            } catch(PDOException $e) {
                echo "teamsInLadder Error"; die();
            }
        }
        public function reportPlayedmatch($matchID, $teamID, $winLoss) {
            return Array("request"=>"report played match");
        }
        public function createTeam($playerID, $teamname, $color, $imageurl) {
            try {
                $query = "INSERT INTO team (team_name, color, image)
                    VALUES (:tname , :color, :img)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':tname', $teamname);
                $stmt->bindParam(':color', $color);
                $stmt->bindParam(':img', $imageurl);
                $stmt->execute();
                //update playerid with $conn->lastInsertId();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"create new team");
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
                $stmt->bindParam(':player', $playerID);
                $stmt->bindParam(':team', $teamID);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"join a team");
                }
            } catch (PDOException $e){
                echo "joinTeam error"; die();
            }
        }
        public function createPlayer($name, $pass, $loc, $teamid) {
            try {
                $HashedPassword = password_hash($pass, PASSWORD_DEFAULT);
                $query = 'INSERT INTO `player`(`name`, `pass`, `seated_loc`, `team_id`)
                    VALUES (:name , :pass, :loc, :team)';
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':pass', $HashedPassword);
                $stmt->bindParam(':loc', $loc);
                $stmt->bindParam(':team', $teamid);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"create a player");
                    //$conn->lastInsertId();
                }
            } catch (PDOException $e) {
                echo "createPlayer error"; die();
            }
        }
        public function createMatch($team_a, $team_b, $ladder) {
            try{
                $query = 'INSERT INTO `played_match`(`team_a_id`, `team_b_id`,
                  `ladder_id`, `winning_team_id`, `losing_team_id`)
                  VALUES (:team_a, :team_b, :ladder, 1, 1)'; // 1 is unset
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':team_a', $team_a);
                $stmt->bindParam(':team_b', $team_b);
                $stmt->bindParam(':ladder', $ladder);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"create a match");
                }
            } catch (PDOException $e) {
                echo "createMatch error"; die();
            }
        }
        public function createLadder() {
////////////////////////////////////////////////////////////////////////////////
            return Array("request"=>"create a ladder");
        }
        public function removeTeam($teamID) {
///////////// Check to see if team has players first!
            try {
                $query = "DELETE FROM team WHERE id = :teamid";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':teamid', $teamID);
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
                $stmt->bindParam(':playerid', $playerID);
                $result = $stmt->execute();
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"remove player from team");
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
                $stmt->bindParam(':ladderid', $ladderID);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"teams with 0 players");
                }
            } catch(PDOException $e) {
                echo "teamsWithZeroPlayersList Error"; die();
            }
        }
        public function ladderTeamlist($ladderID) {
            try {
                $teaminladder = "SELECT UNIQUE * FROM team
                    JOIN ladder ON team.ladder_id = ladder
                        WHERE team.ladder_id = :ladderID";
                $stmt = $this->conn->prepare($teaminladder);
                $stmt->bindParam(':ladderid', $ladderID);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"teams in a ladder");
                }
            } catch(PDOException $e) {
                echo "ladderTeamlist error"; die();
            }
        }
        public function incompleteMatches($teamA, $teamB) {
            try {
                $incomplete_matches = "SELECT * FROM played_match
                    WHERE (losing_team_id = 1 OR winning_team_id = 1)
                    AND (team_a_id = :teama OR team_b_id = :teamb)
                        ORDER BY ladder_id";
                $stmt = $this->conn->prepare($incomplete_matches);
                $stmt->bindParam(':teama', $teamA);
                $stmt->bindParam(':teamb', $teamB);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"incomplete Matches");
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
                $stmt->bindParam(':ladder', $ladderID);
                $stmt->bindParam(':team', $teamID);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"join a team");
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
                $stmt->bindParam(':teamid', $teamID);
                $stmt->bindParam(':ladderid', $ladderID);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    return Array("request"=>"join a team");
                }
            } catch (PDOException $e) {
                echo "isTeaminLadder error"; die();
            }
        }
        public function authPlayer($username, $password) {
            try {
                $auth = "SELECT * FROM user WHERE name = :username";
                $stmt = $this->conn->prepare($auth);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result == false) {
                    return false;
                } else {
                    if(password_verify($result['pass'], $password)) {
                        return Array("request"=>"user exists");
                    } else {
                        return false;
                    }
                }
            } catch (PDOException $e) {
                echo "isTeaminLadder error"; die();
            }
        }
        public function logEvent() {
            return Array("request"=>"log an event");
        }
    }
?>
