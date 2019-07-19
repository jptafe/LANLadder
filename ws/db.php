<?php
    class databaseObject {
        private $conn;
        public function __construct() {
            try {
                $this->conn = new PDO("mysql:host=127.0.0.1;dbname=LANLadder", 'root','');
                //$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // DEBUG
            }
            catch(PDOException $e) {
                echo json_encode(Array("error"=>"Database Connection Error")); // This is debug. INSTEAD: echo json_encode(Array('error'=>'true'));
                die();
            }
        }
        public function ladderlist($ladderID) {
            /// LIST ladder in order of best to worst team
            return Array("request"=>"a ladder");
        }
        public function allLadders() {
            return Array("request"=>"all ladders");
        }
        public function allTeamlist() {
            return Array("request"=>"all teams");
        }
        public function teamsinLadder($ladderID) {
            return Array("request"=>"teams in ladder");
        }
        public function TeamsWithZeroPlayerslist() { // Probably not needed
            return Array("request"=>"teams with 0 players");
        }
        public function ladderTeamlist($ladderID) {
            return Array("request"=>"teams in a ladder");
        }
        public function playersNotinTeam() {
            return Array("request"=>"players not in a team");
        }
        public function playersinTeam($teamID) {
            return Array("request"=>"players in a specific team");
        }
        public function reportPlayedmatch($playerID, $matchID, $winLoss) {
            return Array("request"=>"report played match");
        }
        public function createTeam($playerID) {
            return Array("request"=>"create new team");
        }
        public function joinTeam($playerID, $teamID) {
            return Array("request"=>"join a team");
        }
        public function matchesPlayedbyTeam($teamID, $ladderID) {
            return Array("request"=>"join a team");
        }
        public function isTeaminLadder($teamID, $ladderID) {
            return Array("request"=>"join a team");
        }
        public function createPlayer() {
            return Array("request"=>"create a player");
        }
        public function createMatch() {
            return Array("request"=>"create a match");
        }
        public function createLadder() {
            return Array("request"=>"create a ladder");
        }
        public function removeTeam($teamID) {
            return Array("request"=>"remove a team");
        }
        public function removePlayerFromTeam($playerID) {
            return Array("request"=>"remove player from team");
        }
        public function logEvent() {
            return Array("request"=>"log an event");
        }
    }
?>