<?php
    if(count($_COOKIE) < 1) {
        $header = 'Location: testsession.php?' . $_SERVER['QUERY_STRING'];
        header($header);
    }

    class sessionObject {
        private $ip;
        private $referrer;
        private $lastrequestArray = null;
        private $authCode = null;
        private $uid;
        private $icon;
        private $tid;
        private $ticon;

        public function __construct() {
            if(isset($_SERVER['REMOTE_ADDR'])) {
                $this->ip = $_SERVER['REMOTE_ADDR'];
            } else {
                throw new APIException("No viable headers");
            }
            if(isset($_SERVER['HTTP_REFERER'])) {
                $this->referrer = $_SERVER['HTTP_REFERER'];
            } else {
                throw new APIException("no referrer");
            }
        }
        public function logEvent() {
            global $databaseOBJECT;
            return $databaseOBJECT->logEvent();
        }
        public function domainLock() {
            if((strpos($this->referrer, 'localhost') !== false) ||
                    (strpos($this->referrer, 'LANLadder') !== false)) {
                return true;
            } else {
                throw new APIException("invalid referrer");
            }
        }
        public function rateLimit() {
            $temprequestArray = Array();
            if($this->lastrequestArray == null) {
                $this->lastrequestArray = Array(time());
            }
            if(time() == end($this->lastrequestArray)) {
                array_push($this->lastrequestArray, time());
                foreach($this->lastrequestArray AS $thisone) {
                    if($thisone == time()) {
                        array_push($temprequestArray, $thisone);
                    }
                }
                if(count($temprequestArray) > 10) {
                    return false;
                }
            } else {
                array_push($this->lastrequestArray, time());
            }
            foreach($this->lastrequestArray AS $thisone) {
                if($thisone > (time() - 86400)) {
                    array_push($temprequestArray, $thisone);
                }
                if(count($temprequestArray) > 10000) {
                    $lastrequestArray = $temprequestArray;
                    return false;
                }
            }
            return true;
        }
        function isAuth() {
            if($this->authCode !== null) {
                return Array('auth'=>$this->authCode, 
                             'authicon'=>$this->icon, 
                             'teamicon'=>$this->ticon);
            } else {
                return Array('auth'=>-1);
            }
        }
        function setAuth($incomingAuth) {
            global $databaseOBJECT;
            $stringAuth = json_encode($incomingAuth);
            $this->authCode = hash('md2', $stringAuth);
            $this->uid = $incomingAuth['id'];
            $this->tid = $incomingAuth['team_id'];
            $this->icon = $incomingAuth['image'];
            $team = $databaseOBJECT->getTeam($incomingAuth['team_id']);
            $this->ticon = $team['image'];
            return Array('name'=>$this->authCode, 
                        'authicon'=>$this->icon,
                        'teamicon'=>$this->ticon);
        }
        function unsetAuth() {
            $this->authCode = null;
            $this->uid = null;
            $this->tid = null;
            $this->icon = null;
            return Array("name"=>"-1");
        }
        function tid() {
            return $this->tid;
        }
    }
?>
