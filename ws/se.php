<?php

    // Code here to ID that the client can retain cookies...
    /* IF there are no cookies, redirect, check for cookie, if not there die()! */
    //// probably want to know that sessions are capable of being supported before we do this...
    //print_r(count($_COOKIE)); die();
    if(count($_COOKIE) < 1) {
        header('Location: ws.php');
    } // this may cause a infinate loop...
    
    class sessionO {
        private $ip;
        private $referrer;

        public function __construct() {
            if(isset($_SERVER['REMOTE_ADDR'])) {
                $this->ip = $_SERVER['REMOTE_ADDR'];
            } else {
                throw new APIException("No viable headers");
            }
            if(isset($_SERVER['Referer'])) {
                $this->referrer = $_SERVER['Referer'];  
            } else {
                throw new APIException("no referrer");
            }
        }
        public function logEvent() {
            $databaseObject->createPlayer();
        }
        public function domainLock() {
            
        }
        public function rateLimit() {
            
        }
    }
?>