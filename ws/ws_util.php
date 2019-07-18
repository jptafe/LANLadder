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
    
    function validate($dirty_string, $action_code) {
        //return string if OK, otherwise return false;
        switch($action_code) {
            case 'alpha':
                if(ctype_alpha($dirty_string)) {
                    return $dirty_string;
                }
                return false;
            case 'integer':
                if(is_numeric($dirty_string)) {
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
                    if((int)$dirty_string > 0 && (int)$dirty_string < 65335) {
                        return $dirty_string;
                    }
                } 
                return false;
            case 'alphanumeric':
                if(preg_match('/[A-Za-z0-9]{3,24}/', $dirty_string) > 0) {
                    return $safe_value;
                }
                return false;
                break;
            case 'IP':
                if(ip2long($dirty_string)) {
                    return $dirty_string;
                }
                return false;
            case 'WinLose':
                if($dirty_string == 'Win' || $dirty_string == 'Loss') {
                    return $dirty_string;
                }
                return false;
            default:
                return false;
        }
    }
?>