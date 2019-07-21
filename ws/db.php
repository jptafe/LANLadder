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
                        played_match.ladder_id = " . (int)$ladderID;
                // no order by...
                $stmt = $conn->prepare($getLadder);
                $stmt->execute();
                $ladder_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {

            }
            return Array("request"=>"a ladder");
        }
        public function allLadders() {
            try {
                $query = "SELECT * FROM ladder"; // Possiably replace this with a procedure
                $stmt = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {

            }
            return Array("request"=>"all ladders");
        }
        public function allTeamlist() {
            try {
                $team_list = "SELECT * FROM team;";
                $stmt = $this->conn->prepare($team_list);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {

            }
            return Array("request"=>"all teams");
        }
        public function teamsinLadder($ladderID) {
            try {
                $team_list = "SELECT DISTINCT * FROM team
                    JOIN played_match
                    ON (team.id = played_match.team_a_id OR team.id = played_match.team_b_id)
                    WHERE team.ladder_id = " . $ladderID;
                $stmt = $this->conn->prepare($team_list);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {

            }
            return Array("request"=>"teams in ladder");
        }
        public function TeamsWithZeroPlayerslist() { // Probably not needed
            try {
                $teams = "SELECT DISTINCT * FROM team
                    WHERE NOT EXISTS (
                        SELECT team_id FROM player
                            WHERE team.id = player.team_id)
                    AND team.ladder_id = " . $ladderID;
                $stmt = $this->conn->prepare($teams);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {

            }
            return Array("request"=>"teams with 0 players");
        }
        public function ladderTeamlist($ladderID) {
            try {
                $teaminladder = "SELECT UNIQUE * FROM team
                    JOIN ladder ON team.ladder_id = ladder
                        WHERE team.ladder_id = " . $ladderID;
                $stmt = $this->conn->prepare($teaminladder);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {

            }
            return Array("request"=>"teams in a ladder");
        }
        public function playersNotinTeam() {
            try {
                $noteam = "SELECT * FROM player WHERE team_id = 1";
                $stmt = $this->conn->prepare($noteam);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {

            }
            return Array("request"=>"players not in a team");
        }
        public function playersinTeam($teamID) {
            try {
                $playersinteam = "SELECT * FROM player WHERE team_id = " . $teamID;
                $stmt = $this->conn->prepare($playersinteam);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {

            }
            return Array("request"=>"players in a specific team");
        }
        public function reportPlayedmatch($playerID, $matchID, $winLoss) {


            return Array("request"=>"report played match");
        }
        public function incompleteMatches($teamA, $teamB) {
            try {
                $incomplete_matches = "SELECT * FROM played_match
                    WHERE (losing_team_id = 1 OR winning_team_id = 1)
                    AND (team_a_id = " . $teamA . "
                    OR team_b_id = " . $teamB . ")
                        ORDER BY ladder_id";
                $stmt = $this->conn->prepare($incomplete_matches);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {

            }
        }
        public function createTeam($playerID) {
            try {
                $query = "INSERT INTO team (team_name, color, image)
                    VALUES (:tname , :color, :img)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':tname', $name);
                $stmt->bindParam(':color', $color);
                $stmt->bindParam(':img', $file);
                $stmt->execute();
                return $conn->lastInsertId();
            } catch (PDOException $e) {

            }
            return Array("request"=>"create new team");
        }
        public function joinTeam($playerID, $teamID) {
            try {
                $query = "UPDATE `player` SET `team_id` = :team
                    WHERE `player`.`id` = :player";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':player', $player);
                $stmt->bindParam(':team', $teamid);
                $result = $stmt->execute();
            } catch (PDOException $e){

            }
            return Array("request"=>"join a team");
        }
        public function matchesPlayedbyTeam($teamID, $ladderID) {
            try {
                $complete_matches = "SELECT * FROM played_match
                    WHERE (losing_team_id > 1 OR winning_team_id > 1)
                    AND (team_a_id = " . $teamID . "
                    OR team_b_id = " . $teamID . ")
                        ORDER BY ladder_id";
                $stmt = $this->conn->prepare($complete_matches);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {

            }
            return Array("request"=>"join a team");
        }
        public function isTeaminLadder($teamID, $ladderID) {
            try {
                $teaminladder = "SELECT UNIQUE * FROM team
                    JOIN played_match ON (played_match.team_a_id = team.id OR
                        played_match.team_b_id - team.id)
                        WHERE team.id = " . $teamID;
                $stmt = $this->conn->prepare($teaminladder);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {

            }
            return Array("request"=>"join a team");
        }
        public function createPlayer() {
            try {
                $query = 'INSERT INTO `player`(`name`, `pass`, `seated_loc`, `team_id`)
                    VALUES (:name , :pass, :loc, :team)';
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':pass', $pass);
                $stmt->bindParam(':loc', $loc);
                $stmt->bindParam(':team', $teamid);
                $result = $stmt->execute();
                return $conn->lastInsertId();
            } catch (PDOException $e) {

            }
            return Array("request"=>"create a player");
        }
        public function createMatch() {
            try{
                $query = 'INSERT INTO `played_match`(`team_a_id`, `team_b_id`,
                  `ladder_id`, `winning_team_id`, `losing_team_id`)
                  VALUES (:team_a, :team_b, :game, 1, 1)'; // 1 is unset
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':team_a', $team_a);
                $stmt->bindParam(':team_b', $team_b);
                $stmt->bindParam(':game', $game);
                $result = $stmt->execute();
            } catch (PDOException $e) {

            }
            return Array("request"=>"create a match");
        }
        public function createLadder() {
            return Array("request"=>"create a ladder");
        }
        public function removeTeam($teamID) {
            try {
                $query = "DELETE FROM team WHERE id = " . $teamID;
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute();
            } catch (PDOException $e) {

            }
            return Array("request"=>"remove a team");
        }
        public function removePlayerFromTeam($playerID) {
            try {
                $query = "UPDATE user SET (team_id = 1) WHERE id = " . $playerID;
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute();
            } catch (PDOException $e) {

            }
            return Array("request"=>"remove player from team");
        }
        public function logEvent() {
            return Array("request"=>"log an event");
        }
    }
?>
