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
            if(isset($_POST['ladderid'])) {
                $ladderID = validate($_POST['ladderid'], 'primarykey');
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
            if(isset($_POST['teamid'])) {
                $teamID = validate($_POST['teamid'], 'primarykey');
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
            if(isset($_GET['winner'])) {
                $winner = validate($_GET['winner'], 'primarykey');
                if($winner == false) {
                    throw new APIException("team winner ID not valid");
                }
            }
            if(isset($_GET['loser'])) {
                $loser = validate($_GET['loser'], 'primarykey');
                if($loser == false) {
                    throw new APIException("team loser ID not valid");
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
            if(isset($_GET['color'])) {
                $color = validate($_GET['color'], 'colorcode');
                if($color == false) {
                    throw new APIException("color value not valid");
                }
            }
            if(isset($_POST['color'])) {
                $color = validate($_POST['color'], 'colorcode');
                if($color == false) {
                    throw new APIException("color value not valid");
                }
            }
            if(isset($_POST['laddername'])) {
                $laddername = validate($_POST['laddername'], 'alphanumeric');
                if($laddername == false) {
                    throw new APIException("ladder value not valid");
                }
            }
            if(isset($_GET['laddername'])) {
                $laddername = validate($_GET['laddername'], 'alphanumeric');
                if($laddername == false) {
                    throw new APIException("ladder value not valid");
                }
            } 
            if(isset($_GET['teamname'])) {
                $teamname = validate($_GET['teamname'], 'alphanumeric');
                if($teamname == false) {
                    throw new APIException("ladder value not valid");
                }
            }
            if(isset($_GET['username'])) {
                $username = validate($_GET['username'], 'alphanumeric');
                if($username == false) {
                    throw new APIException("ladder value not valid");
                }
            }
            if(isset($_POST['desc'])) {
                $desc = validate($_POST['desc'], 'alphanumeric_space');
                if($desc == false) {
                    throw new APIException("Description value not valid");
                }
            }
            if(isset($_POST['members'])) {
                $memberNos = validate($_POST['members'], 'integer');
                if($memberNos == false || $memberNos < 1) {
                    throw new APIException("Member Numbernot valid");
                }
            }
            if(isset($_POST['imageurl'])) {
                $imageURL = validate($_POST['imageurl'], 'filename');
                if($imageURL == false) {
                    throw new APIException("image url value not valid");
                }
            }
            if(isset($_GET['imageurl'])) {
                $imageURL = validate($_GET['imageurl'], 'filename');
                if($imageURL == false) {
                    throw new APIException("image url value not valid");
                }
            }
            if(isset($_POST['username'])) {
                $userName = validate($_POST['username'], 'alphanumeric');
                if($userName == false) {
                    throw new APIException("Player Name value not valid");
                }
            }
            if(isset($_POST['location'])) {
                $location = validate($_POST['location'], 'alphanumeric');
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
            if(isset($_POST['starttime'])) {
                $startTime = validate($_POST['starttime'], 'isodatetime');
                if($startTime == false) {
                    throw new APIException("ISO date not valid");
                }
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
                    if(isset($matchID) && isset($winner) && isset($loser)) {
                        if($winner == $_SESSION['sessionOBJ']->tid() ||
                            $loser == $_SESSION['sessionOBJ']->tid()) {
                            $result = $databaseOBJECT->reportPlayedmatch($matchID, $winner, $loser);
                        } else {
                            $result = Array('matchreport'=>'fail');
                        }
                    } else {
                        throw new APIException("played match ids missing");
                    }
                    break;
                /// INSERT new team and add inserting player into team
                case "createteam":
                    if(isset($playerID) && isset($teamname) || isset($color) && isset($imageURL)) {
                        $result = $databaseOBJECT->createTeam($playerID, $teamname, $color, $imageURL);
                    } else {
                        throw new APIException("player id missing to create team");
                    }
                    break;
                case "jointeam":
                    if(isset($teamID)) {
                        $uid = $_SESSION['sessionOBJ']->uid();
                        if($uid != null) {
                            $result = $databaseOBJECT->joinTeam($uid, $teamID);
                        } else {
                            $result = Array('auth'=>-1);
                        }
                    } else {
                        throw new APIException("team joining IDs missing");
                    }
                    break;                
                case "kickoffteam":
                    if(isset($teamID) || isset($playerID)) {
                        $tid = $_SESSION['sessionOBJ']->tid();
                        if($tid == $teamID) {
                            $result = $databaseOBJECT->removePlayerFromTeam($playerID);
                        } else {
                            $result = Array('kick'=>-1);
                        }
                    }
                    break;
                case "createplayer":
                    if(isset($userName) && isset($passWord) && isset($location) && isset($imageURL) && isset($teamID)) {
                        $result = $databaseOBJECT->createPlayer($userName, $passWord, $location, $imageURL, $teamID);
                    } else {
                        throw new APIException("create player error");
                    }
                    break;
                case "creatematch":
                    if(isset($teamID) && isset($teamBID) && isset($ladderID) && isset($startTime)) {
                        $result = $databaseOBJECT->createMatch($teamID, $teamBID, $ladderID, $startTime);
                    } else {
                        throw new APIException("create player error");
                    }
                    break;
                case "createladder":
                    if(isset($imageURL) && isset($memberNos) && isset($laddername) && isset($color) && isset($desc) && isset($startTime)) {
                        $result = $databaseOBJECT->createLadder($laddername, $desc, $memberNos, $color, $imageURL, $startTime);
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
                    if(isset($userName) && isset($passWord)) {
                        $result = $databaseOBJECT->authPlayer($userName, $passWord);
                        if($result['name'] != -1) {
                            $result = $_SESSION['sessionOBJ']->setAuth($result);
                        }
                    }
                    break;
                case "isauth":
                    $result = $_SESSION['sessionOBJ']->isAuth();
                    break;
                case "deauth":
                    $result = $_SESSION['sessionOBJ']->unsetAuth();
                    break;
                case 'userexists':
                    if(isset($username)) {
                        $result = $databaseOBJECT->doesUserNameExist($username);
                    }
                    break;
                case 'ladderexists':
                    if(isset($laddername)) {
                        $result = $databaseOBJECT->doesLadderNameExist($laddername);
                    }
                    break;
                case 'teamexists':
                    if(isset($teamname)) {
                        $result = $databaseOBJECT->doesTeamNameExist($teamname);
                    }
                    break;             
                case 'destroy':
                    kill_session();
                    break;
                case 'statushashes':
                    $result = $databaseOBJECT->getLANStatus();
                    break;
                case 'imageupload':
                    if(sizeof($_FILES) > 0) {
                        move_uploaded_file($_FILES["file_upload"]["tmp_name"], '../img/' . $_FILES["file_upload"]["name"]);
                        $result = Array('upload'=>$_FILES["file_upload"]["name"]);
                    } else {
                        $result = Array('upload'=>'false');
                    }
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
