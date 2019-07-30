<?php
    require_once('../functions.php');
    session_start();
    if(!isset($_SESSION['UserPrivileges']) && $_SESSION['UserPrivileges'] != 1){ // Checks to see if the userprivileges session is set and to see if its admin or not
        header('location: ../');
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST)){
            if(isset($_POST['game']) && isset($_POST['team_a']) && isset($_POST['team_b'])){
                $game = !empty($_POST['game'])? clean(($_POST['game'])) : null;
                $team_a = !empty($_POST['team_a'])? clean(($_POST['team_a'])) : null;
                $team_b = !empty($_POST['team_b'])? clean(($_POST['team_b'])) : null;
                insert_match($game, $team_a, $team_b);
                header('location: ../index.php');
            }
        }


    }else{
        header('location: ../index.php');
    }



?>