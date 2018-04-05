<?php

    session_start();
    
    if( isset( $_POST['action'] ) ){
        $action = $_POST['action'];
    }
    $force = false;
    if( isset( $_GET['force'] )){
        $force = force;
    }
    
    if( isset( $_SESSION['user_login'] ) && !$force ){
        echo json_encode( $_SESSION['user_login'] );
    }
    if( isset( $action ) && $action == "register" ){
        include_once( "forms/registerForm.php");
    }
    else if( isset( $action ) && $action == "login" ){
        include_once( "forms/loginForm.php" );
    }

