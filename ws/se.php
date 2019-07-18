<?php
    if(count($_COOKIE) < 1) {
        header('Location: ws.php');
    } // this may cause a infinate loop...
    
    class sessionObject {
        private $ip;
        private $referrer;

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
            // setup array of log data,
            $databaseObject->logEvent($dataArray);
        }
        public function domainLock() {
            return false;
        }
        public function rateLimit() {
            return false;
        }
    }
?>
