<?php
    print_r($_COOKIE);
    // this ensures that some cookies have been set by start_session();
    if(count($_COOKIE) < 1) {
        die();
    } else {
        header('Location: ws.php');
    }
?>
