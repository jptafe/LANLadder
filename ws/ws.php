<?php
// Write a program that prints the numbers from 1 to 100.
// But for multiples of three print “Fizz” instead of the number
// and for the multiples of five print “Buzz”. For numbers which
// are multiples of both three and five print “FizzBuzz”.

    include("db.php"); // ALL SQL Actions go here
    include("se.php"); // ALL Session Management goes here
    include("ws_util.php"); // ALL generic utilities
    session_start();
    $databaseOBJECT = new databaseObject();
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
            if(isset($_GET['winloss'])) {
                if($matchID = validate($_GET['winloss'], 'winloss') == false) {
                    throw new APIException("win/loss value not valid");
                }
            }
            switch($validated_pagereq) {
                case "ladderlist":
                    if(isset($ladderID)) {
                        $result = $databaseOBJECT->ladderlist($ladderID);
                    } else {
                        throw new APIException("ladder id missing");
                    }
                    if($result == false) {
                        $result = Array('result'=>$result);
                    }
                    break;
                /// LIST all teams
                case "teamlist":
                    $result = $databaseOBJECT->allLadders();
                    break;
                case "allteams":
                    $result = $databaseOBJECT->allTeamList();
                    break;
                case "teamsinladder":
                    if(isset($ladderID)) {
                        $result = $databaseOBJECT->teamsinLadder($ladderID);
                    } else {
                        throw new APIException("ladder id missing");
                    }
                    break;
                /// LIST players not in a team
                case "playersnotinateam":
                    $result = $databaseOBJECT->playersNotinTeam();
                    break;
                /// LIST all players in a team
                case "playersinteam":
                    if(isset($teamID)) {
                        $result = $databaseOBJECT->playersinTeam($teamID);
                    } else {
                        throw new APIException("team id missing");
                    }
                    break;
                case "teamsinladder":
                    if(isset($ladderID)) {
                        $result = $databaseOBJECT->teamsinLadder($ladderID);
                    } else {
                        throw new APIException("ladder id missing");
                    }
                    break;
                /// UPDATE played_match with results
                case "reportplayedmatch":
                    if(isset($ladderID) && isset($matchID) && isset($winLoss)) {
                        $result = $databaseOBJECT->reportPlayedmatch($playerID, $matchID, $winLoss);
                    } else {
                        throw new APIException("played match ids missing");
                    }
                    break;
                /// INSERT new team and add inserting player into team
                case "createteam":
                    if(isset($playerID)) {
                        $result = $databaseOBJECT->createTeam($playerID);
                    } else {
                        throw new APIException("player id missing to create team");
                    }
                    break;
                /// UPDATE player with a new team. If the team they leave has 0 players, delete the team
                case "jointeam":
                    if(isset($teamID) && isset($playerID)) {
                        $result = $databaseOBJECT->joinTeam($playerID, $teamID);
                    } else {
                        throw new APIException("team joining IDs missing");
                    }
                    break;
                /// INSERT new player
                case "createplayer":
                    $result = $databaseOBJECT->createPlayer();
                    break;
                /// INSERT new match
                case "creatematch":
                    $result = $databaseOBJECT->createMatch();
                    break;
                /// INSERT new ladder
                case "createladder":
                    $result = $databaseOBJECT->createLadder();
                    break;
                /// DELETE team, but first check if there are 0 players...
                case "removeteam":
                    if(isset($teamID)) {
                        $result = $databaseOBJECT->removeTeam($teamID);
                    } else {
                        throw new APIException("team joining IDs missing");
                    }
                    break;
                case "removeplayerfromteam":
                    if(isset($playerID)) {
                        $result = $databaseOBJECT->removePlayerFromTeam($playerID);
                    } else {
                        throw new APIException("team joining IDs missing");
                    }
                    break;
                default:
                    throw new APIException("incorrect request code");
                    break;
            }
        } else {
            throw new APIException("request code does not exist");
        }
        echo json_encode($result);
    }
    catch(APIException $ae) {
        echo $ae; // This is debug. INSTEAD: echo json_encode(Array('error'=>'true'));
    }
?>
