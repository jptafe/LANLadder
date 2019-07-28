<?php
    class APIException extends Exception {
        // empty
    }
    function sanatise($dirty_string) {
        $clean_string = stripslashes($dirty_string);
        $clean_string = strip_tags($clean_string);
        $clean_string = trim($clean_string);
        return $clean_string;
    }
    function kill_session() {
        session_destroy();
        die();
    }
    function validate($dirty_string, $action_code) {
        switch($action_code) {
            case 'alpha':
                if(ctype_alpha($dirty_string)) {
                    return $dirty_string;
                }
                return false;
            case 'integer':
                if(is_numeric($dirty_string)) { // not enough
                    return $dirty_string;
                }
                return false;
            case 'key':
                if(is_numeric($dirty_string)) {
                    if((int)$dirty_string > 1) {
                        return $dirty_string;
                    }
                }
                return false;
            case 'primarykey':
                if(is_numeric($dirty_string)) {
                    if((int)$dirty_string > 0 && (int)$dirty_string < 99999999999) {
                        return $dirty_string;
                    }
                }
                return false;
            case 'IP':
                if(ip2long($dirty_string)) {
                    return $dirty_string;
                }
                return false;
            case 'winloss':
                if($dirty_string == 'win' || $dirty_string == 'loss'
                        || $dirty_string == 'draw') {
                    return $dirty_string;
                }
                return false;
            case 'colorcode':
                if(ctype_xdigit($dirty_string)) {
                    return $dirty_string;
                }
                return false;
            case 'alpha':
                if(ctype_alpha($dirty_string)) {
                    return $dirty_string;
                }
                return false;
            case 'alphanumeric':
                if(ctype_alnum($dirty_string)) {
                    return $dirty_string;
                }
                return false;
            case 'isodate':
                $dt = strtotime($dirty_string);
                $dt = DateTime::createFromFormat('Y-m-d', $dt);
                if($dt != false) {
                    return $dt->format('Y-m-d');
                }
                return false;
            case 'isodatetime':
                $dt = DateTime::createFromFormat('Y/m/d H:i:s', $dirty_string);
                if($dt != false) {
                    return $dt->format('Y-m-d H:i:s');
                }
                return false;
            default:
                return false;
        }
    }
?>
