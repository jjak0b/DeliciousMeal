<?php
    include_once('utility.php' );
    include_once('../config.php' );
    
    if( isset( $_SESSION['user_login'] ) )
    {
        unset( $_SESSION['user_login'] );
    }
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    
    $password  = md5( $password );
 
    $sql_login = quick_select(
                        array("id", "nome", "cognome", "email", "password"),
                        array("utenti"),
                        array("email", "password"),
                        array($email, $password)
                        );
    $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
    // Check connection
    $user = false;
    $cause = "";
    if ( mysqli_connect_errno() )
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        $cause = "connection";
        header( "location: ../pages/azienda/AreaPersonale.php?login=f&cause=$cause");
        return;
    }
    else{
        $result_login = mysqli_query($connection, $sql_login);
        $user = mysqli_fetch_assoc( $result_login );
    }
    
    
    
    if( $user ){
        $cause = "already_registered";
        echo "<pre>".print_r( $user )."</pre>";
        header( "location: ../pages/azienda/AreaPersonale.php?login=f&cause=$cause");
    }
    else{
        $sql_register = insert( "utenti",
                                array( "nome", "cognome", "email", "password" ),
                                array( $name, $surname, $email, $password )
                              );
        $result_register = mysqli_query($connection, $sql_register);
        $id = mysqli_insert_id( $connection );
        $error = mysqli_errno( $connection );
        if( $result_register && $id ){
            /*
            $sql_register = insert( "ruoli",
                        array( "id_utente" ),
                        array( $id )
                      );
            $result_register = mysqli_query($connection, $sql_register);*/
            
            $_SESSION['user_login']["id"] = $id;
            $_SESSION['user_login']["nome"] = $name;
            $_SESSION['user_login']["cognome"] = $surname;
            $_SESSION['user_login']["email"] = $email;
            $_SESSION['user_login']["password"] = $password;
            header( "location: ../pages/azienda/AreaPersonale.php?login=s");
        }
        else{
            if( !empty( $error )){
                $cause = $error;
            }
            else{
                $cause = "unknown";
            }
            header( "location: ../pages/azienda/AreaPersonale.php?login=f&cause=$cause");
        }
    }