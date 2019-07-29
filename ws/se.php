<?php
    if(count($_COOKIE) < 1) {
        header('Location: testsession.php');
    }

    class sessionObject {
        private $ip;
        private $referrer;
        private $lastrequestArray = null;

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
                if(count($temprequestArray) > 1000) {
                    $lastrequestArray = $temprequestArray;
                    return false;
                }
            }
            return true;
        }
    }
?>
