<?php
    //start the session if not started already
    if(!isset($_SESSION)) { session_start(); } 
    unset($_SESSION['username']); //remove username from session
    header('Location:index.php');
?>