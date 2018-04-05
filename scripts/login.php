<?php
    include_once('utility.php' );
    include_once('../config.php' );
    
    if( isset( $_SESSION['user_login'] ) )
    {
        unset( $_SESSION['user_login'] );
    }
    // session_start();
    
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    $password  = md5( $password );
 
    $sql_login = quick_select(
                        array("id", "nome", "cognome", "email", "password"),
                        array("utenti"),
                        array("email", "password"),
                        array($email, $password)
                        );
    $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
    // Check connection
    $user = null;
    $cause = "";
    if ( mysqli_connect_errno() )
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        $cause = "connection";
    }
    else{
        $result_login = mysqli_query($connection, $sql_login);
        $user = mysqli_fetch_assoc( $result_login );
    }
    if( $user ){
        $_SESSION['user_login'] = $user;
        header( "location: ../index.php");
    }
    else{
        $cause = "nouser";
        header( "location: ../pages/azienda/AreaPersonale.php?login=f&cause=$cause");
    }
    
    
    
    
    
    
            
 