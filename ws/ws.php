<?php
    session_start();
//INCLUDES
    include('db.php'); // ALL SQL Actions go here
    include('se.php'); // ALL Session Management goes here
//INITIALISE
    $databaseOBJ = new databaseO();
    
    if(!isset( $_SESSION['sessionOBJ'])) {
        //// probably want to know that sessions are capable of being supported before we do this...
        $_SESSION['sessionOBJ'] = new sessionO();
    }
//SECURITY_CHECKS: rate limit, domain lock, 

//GET_SIGNATURES
    try {
        if(isset($_GET['reqcode'])) {
            $sanatised_pagereq = sanatise($_GET['reqcode']);
            $validated_pagereq = validate($sanatised_pagereq, 'alpha');
            
            switch($validated_pagereq) {
                /// LIST ladder in order of best to worst team
                case "ladderlist":
                    echo "ladderlist";
                    break;
                /// LIST all teams
                case "teamlist":
                    echo "teamlist";
                    break;
                /// LIST players not in a team
                case "playersnotinteam":
                    echo "playersnotinteam";
                    break;
                /// LIST all players in a team
                case "playersinteam":
                    echo "playersinteam";
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
    }
    catch(APIException $ae) {
        echo $ae;
    }
?>