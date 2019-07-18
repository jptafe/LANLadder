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
        switch($action_code) {
            case 'alpha':
                if(ctype_alpha($dirty_string)) {
                    return $dirty_string;
                }
                return false;
                break;
            case 'integer':
                if(is_numeric($dirty_string)) {
                    return $dirty_string;
                } 
                return false;
                break;
            case 'key':
                if(is_numeric($dirty_string)) {
                    if((int)$dirty_string > 1) {
                        return $dirty_string;
                    }
                }
                return false;
                break;
            default:
                return false;
        }
    }
?>