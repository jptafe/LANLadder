<?php
    if(count($_COOKIE) < 1) {
        header('Location: testsession.php');
    }

    class sessionObject {
        private $ip;
        private $referrer;
        private $lastrequest = null;

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
            $databaseOBJECT = new databaseObject();
            return $databaseOBJECT->logEvent();
        }
        public function domainLock() {
            if((strpos($this->referrer, 'localhost') !== false) ||
                    (strpos($this->referrer, '34.211.34.94') !== false)) {
                return true;
            } else {
                throw new APIException("invalid referrer");
            }
        }
        public function rateLimit() {
            if($this->lastrequest == null) {
                $this->lastrequest = time();
            } else {
                if($this->lastrequest == time()) {
                    throw new APIException("rate limit exceeded");
                }
            }
            return true;
        }
    }
?>
