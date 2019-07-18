<?php
    include("db.php"); // ALL SQL Actions go here
    include("se.php"); // ALL Session Management goes here
    include("ws_util.php"); // ALL generic utilities
    session_start();    
    $databaseOBJECT = new databaseObject();
    
//SECURITY_CHECKS: rate limit, domain lock, logging

//GET_REQUEST_SIGNATURES
    try { 
        if(!isset($_SESSION['sessionOBJ'])) {
            $_SESSION['sessionOBJ'] = new sessionObject();
        }
        $_SESSION['sessionOBJ']->logEvent();
        $_SESSION['sessionOBJ']->rateLimit();
        $_SESSION['sessionOBJ']->domainLock();
        
        if(isset($_GET['reqcode'])) {
            if(($validated_pagereq = validate($_GET['reqcode'], 'alpha')) == false) {
                throw new APIException("request code not an alpha");
            }
            if(isset($_GET['ladderid'])) {
                if($ladderID = validate($_GET['ladderid'], 'primarykey') == false) {
                    throw new APIException("ladder ID not a valid ID");
                }
            }
            if(isset($_GET['teamid'])) {
                if($teamID = validate($_GET['teamid'], 'primarykey') == false) {
                    throw new APIException("team ID not a valid ID");
                }
            }
            if(isset($_GET['playerid'])) {
                if($playerID = validate($_GET['playerid'], 'primarykey') == false) {
                    throw new APIException("player ID not a valid ID");
                }
            }
            if(isset($_GET['matchid'])) {
                if($matchID = validate($_GET['matchid'], 'primarykey') == false) {
                    throw new APIException("Match ID not a valid ID");
                }
            }
            switch($validated_pagereq) {
                case "ladderlist":
                    if(isset($ladderID)) {
                        if($result = $databaseOBJECT->ladderlist($ladderID) == false) {
                            throw new APIException("invalid ladder id");
                        }
                    } else {
                        throw new APIException("ladder id missing");
                    }
                    break;
                /// LIST all teams
                case "teamlist":
                    echo "teamlist";
                    break;
                /// LIST players not in a team
                case "playersnotinateam":
                    echo "playersnotinteam";
                    break;
                /// LIST all players in a team
                case "playersinteam":
                    echo "playersinteam";
                    break;
                case "teamsinladder":
                    if(isset($ladderID)) {
                        if($result = $databaseOBJECT->teamsinLadder($ladderID) == false) {
                            throw new APIException("invalid ladder id");
                        }
                    } else {
                        throw new APIException("ladder id missing");
                    }
                    break;
                /// UPDATE played_match with results
                case "reportplayedmatch":
                    echo "reportplayedmatch";
                    break;
                /// INSERT new team and add inserting player into team
                case "createteam":
                    echo "createteam";
                    break;
                /// UPDATE player with a new team. If the team they leave has 0 players, delete the team
                case "jointeam":
                    echo "createteam";
                    break;
                /// INSERT new player
                case "createplayer":
                    echo "createplayer";
                    break;
                /// INSERT new match
                case "creatematch":
                    echo "creatematch";
                    break;          
                /// INSERT new ladder
                case "createladder":
                    echo "creatematch";
                    break;  
                /// DELETE team, but first check if there are 0 players...
                case "removeteam":
                    echo "removeteam";
                    break;  
                default:
                    throw new APIException("incorrect request code");
                    break;
            }
        } else {
            throw new APIException("request code not tendered");
        }
        echo json_encode($result);
    }
    catch(APIException $ae) {
        echo $ae; // This is debug. INSTEAD: echo json_encode(Array('error'=>'true'));
    }
?>
