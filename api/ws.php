<?php
    include("db.php"); // ALL SQL Actions go here
    include("se.php"); // ALL Session Management goes here
    include("ws_util.php"); // ALL generic utilities

    session_start();
    $databaseOBJECT = new databaseObject();

    try {
        if(!isset($_SESSION['sessionOBJ'])) {
            $_SESSION['sessionOBJ'] = new sessionObject();
        }

        $_SESSION['sessionOBJ']->logEvent();
        $_SESSION['sessionOBJ']->domainLock();

        if($_SESSION['sessionOBJ']->rateLimit() == false) {
            throw new APIException("Rate limit exceeded");
        }

        if(isset($_GET['reqcode'])) {
            $validated_pagereq = validate($_GET['reqcode'], 'alpha');
            if($validated_pagereq == false) {
                throw new APIException("request code not an alpha");
            }
            if(isset($_GET['ladderid'])) {
                $ladderID = validate($_GET['ladderid'], 'primarykey');
                if($ladderID == false) {
                    throw new APIException("ladder ID not a valid ID");
                }
            }
            if(isset($_GET['teamid'])) {
                $teamID = validate($_GET['teamid'], 'primarykey');
                if($teamID == false) {
                    throw new APIException("team ID not a valid ID");
                }
            }
            if(isset($_GET['teambid'])) {
                $teamBID = validate($_GET['teambid'], 'primarykey');
                if($teamBID == false) {
                    throw new APIException("team B ID not a valid ID");
                }
            }
            if(isset($_GET['playerid'])) {
                $playerID = validate($_GET['playerid'], 'primarykey');
                if($playerID == false) {
                    throw new APIException("player ID not a valid ID");
                }
            }
            if(isset($_GET['matchid'])) {
                $matchID = validate($_GET['matchid'], 'primarykey');
                if($matchID == false) {
                    throw new APIException("Match ID not a valid ID");
                }
            }
            if(isset($_GET['winloss'])) {
                $winLoss = validate($_GET['winloss'], 'winloss');
                if($winLoss == false) {
                    throw new APIException("win/loss value not valid");
                }
            }
            if(isset($_GET['color'])) {
                $color = validate($_GET['color'], 'colorcode');
                if($color == false) {
                    throw new APIException("color value not valid");
                }
            }
            if(isset($_GET['name'])) {
                $name = validate($_GET['name'], 'alphanumeric');
                if($name == false) {
                    throw new APIException("teamname value not valid");
                }
            }
            if(isset($_GET['desc'])) {
                $desc = validate($_GET['desc'], 'alphanumeric');
                if($desc == false) {
                    throw new APIException("Description value not valid");
                }
            }
            if(isset($_GET['members'])) {
                $memberNos = validate($_GET['members'], 'integer');
                if($memberNos == false || $memberNos < 1) {
                    throw new APIException("Member Numbernot valid");
                }
            }
            if(isset($_GET['imageurl'])) {
                $imageURL = validate($_GET['imageurl'], 'filename');
                if($imageURL == false) {
                    throw new APIException("image url value not valid");
                }
            }
            if(isset($_GET['playername'])) {
                $playerName = validate($_GET['playername'], 'alphanumeric');
                if($playerName == false) {
                    throw new APIException("Player Name value not valid");
                }
            }
            if(isset($_GET['password'])) {
                $passWord = $_GET['password'];
            }
            if(isset($_GET['location'])) {
                $location = validate($_GET['location'], 'alphanumeric');
                if($location == false) {
                    throw new APIException("Location Name value not valid");
                }
            }
            if(isset($_GET['starttime'])) {
                $startTime = validate($_GET['starttime'], 'isodatetime');
                if($startTime == false) {
                    throw new APIException("ISO date not valid");
                }
            }
            if(isset($_POST['username'])) {
                $userName = $_POST['username'];
            }
            if(isset($_POST['password'])) {
                $passWord = $_POST['password'];
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
                case "allladders":
                    $result = $databaseOBJECT->allLadders();
                    break;
                case "allteams":
                    $result = $databaseOBJECT->allTeamList();
                    break;
                case "allplayers":
                    $result = $databaseOBJECT->allPlayers();
                    break;
                case "allplayedmatches":
                    $result = $databaseOBJECT->allPlayedMatches();
                    break;
                case "allunreportedmatches":
                    $result = $databaseOBJECT->allUnReportedMatches();
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
                    if(isset($matchID) && isset($playerID) && isset($winLoss)) {
                        $result = $databaseOBJECT->reportPlayedmatch($matchID, $playerID, $winLoss);
                    } else {
                        throw new APIException("played match ids missing");
                    }
                    break;
                /// INSERT new team and add inserting player into team
                case "createteam":
                    if(isset($playerID) && isset($name) || isset($color) && isset($imageURL)) {
                        $result = $databaseOBJECT->createTeam($playerID, $name, $color, $imageURL);
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
                    if(isset($playerName) && isset($passWord) && isset($location) && isset($imageURL) && isset($teamID)) {
                        $result = $databaseOBJECT->createPlayer($playerName, $passWord, $location, $imageURL, $teamID);
                    } else {
                        throw new APIException("create player error");
                    }
                    break;
                /// INSERT new match
                case "creatematch":
                    if(isset($teamID) && isset($teamBID) && isset($ladderID) && isset($startTime)) {
                        $result = $databaseOBJECT->createMatch($teamID, $teamBID, $ladderID, $startTime);
                    } else {
                        throw new APIException("create player error");
                    }
                    break;
                /// INSERT new ladder
                case "createladder":
                    if(isset($imageURL) && isset($memberNos) && isset($name) && isset($color) && isset($desc) && isset($startTime)) {
                        $result = $databaseOBJECT->createLadder($name, $desc, $memberNos, $color, $imageURL, $startTime);
                    } else {
                        throw new APIException("create player error");
                    }
                    break;
                /// DELETE team, but first check if there are 0 players...
                case "removeteam":
                    if(isset($teamID)) {
                        $result = $databaseOBJECT->removeTeam($teamID);
                    } else {
                        throw new APIException("team IDs missing");
                    }
                    break;
                case "removeplayerfromteam":
                    if(isset($playerID)) {
                        $result = $databaseOBJECT->removePlayerFromTeam($playerID);
                    } else {
                        throw new APIException("team joining IDs missing");
                    }
                    break;
                case "emptyteams":
                    $result = $databaseOBJECT->teamsWithZeroPlayerslist();
                    break;
                case "teamsinladder":
                    if(isset($ladderID)) {
                        $result = $databaseOBJECT->ladderTeamlist($ladderID);
                    } else {
                        throw new APIException("team joining IDs missing");
                    }
                    break;
                case "incompletematches":
                    if(isset($playerID) && isset($ladderID)) {
                        $result = $databaseOBJECT->incompleteMatches($playerID, $ladderID);
                    } else {
                        throw new APIException("team joining IDs missing");
                    }
                    break;
                case "incompletematchesbyladder":
                    if(isset($ladderID)) {
                        $result = $databaseOBJECT->unreportedMatchesByLadder($ladderID);
                    } else {
                        throw new APIException("unplayed matches by ladder error");
                    }
                    break;
                case "matchesplayedbyteam":
                    if(isset($teamID) && isset($ladderID)) {
                        $result = $databaseOBJECT->matchesPlayedbyTeam($teamID, $ladderID);
                    } else {
                        throw new APIException("team joining IDs missing");
                    }
                    break;
                case "isteaminladder":
                    if(isset($teamID) && isset($ladderID)) {
                        $result = $databaseOBJECT->isTeaminLadder($teamID, $ladderID);
                    } else {
                        throw new APIException("team joining IDs missing");
                    }
                    break;
                case "auth":
                    $result = $databaseOBJECT->authPlayer($userName, $passWord);
                    if($result['name'] != -1) {
                        $result = $_SESSION['sessionOBJ']->setAuth($result);
                    }
                    break;
                case "isauth":
                    $result = $_SESSION['sessionOBJ']->isAuth();
                    break;
                case "deauth":
                    $result = $_SESSION['sessionOBJ']->unsetAuth();
                    break;
                case 'userexists':
                    if(isset($name)) {
                        $result = $databaseOBJECT->doesUserExist($name);
                    }
                    break;
                case 'destroy':
                    kill_session();
                    break;
                case 'statushashes':
                    $result = $databaseOBJECT->getLANStatus();
                    break;
                default:
                    throw new APIException("incorrect request code");
                    break;
            }
        } else {
            throw new APIException("request code does not exist");
        }
        if($result == false) {
            echo json_encode(Array('result'=>'false'));
        } else {
            echo json_encode($result);
        }
    }
    catch(APIException $ae) {
        echo $ae; // This is debug. INSTEAD: echo json_encode(Array('error'=>'true'));
    }
?>
