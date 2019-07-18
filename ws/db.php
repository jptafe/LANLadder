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
        }
        public function allLadders() {
        }
        public function allTeamlist() {
        }
        public function teamsinLadder($ladderID) {
        }
        public function TeamsWithZeroPlayerslist() { // Probably not needed
        }
        public function ladderTeamlist($ladderID) {
        }
        public function playersNotinTeam($teamID) {
        }
        public function playersinTeam($teamID) {
        }
        public function reportPlayedmatch($playerID, $matchID) {
        }
        public function createTeam($playerID) {
        } 
        public function joinTeam($playerID, $teamID) {
        }
        public function matchesPlayedbyTeam($teamID, $ladderID) {
        }
        public function isTeaminLadder($teamID, $ladderID) {
            return false;
        }
        public function createPlayer() {
        }
        public function createMatch() {
        }
        public function createLadder() {
        }
        public function removeTeam($teamID) {
        }
        public function removePlayerFromTeam($playerID) {
        }
    }
?>