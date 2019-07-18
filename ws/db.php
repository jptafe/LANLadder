<?php
    class databaseObj {
        private $conn;
        public function __construct() {
            try {
                $this->conn = new PDO("mysql:host=127.0.0.1;dbname=LANLadder", 'root','');
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e) {
                echo "Database Error"; // This is debug. INSTEAD: echo json_encode(Array('error'=>'true'));
                die();
            }
        }
        public function ladderlist($ladderID) {
            return false;
        }
        public function allLadders() {
            return false;
        }
        public function allTeamlist() {
            return false;
        }
        public function teamsinLadder($ladderID) {
            return false;
        }
        public function TeamsWithZeroPlayerslist() { // Probably not needed
            return false;
        }
        public function ladderTeamlist($ladderID) {
            return false;
        }
        public function playersNotinTeam($teamID) {
            return false;
        }
        public function playersinTeam($teamID) {
            return false;
        }
        public function reportPlayedmatch($playerID, $matchID) {
            return false;
        }
        public function createTeam($playerID) {
            return false;
        } 
        public function joinTeam($playerID, $teamID) {
            return false;
        }
        public function matchesPlayedbyTeam($teamID, $ladderID) {
            return false;
        }
        public function isTeaminLadder($teamID, $ladderID) {
            return false;
        }
        public function createPlayer() {
            return false;
        }
        public function createMatch() {
            return false;
        }
        public function createLadder() {
            return false;
        }
        public function removeTeam($teamID) {
            return false;
        }
        public function removePlayerFromTeam($playerID) {
            return false;
        }
    }
?>