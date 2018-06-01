<?php
    include_once('utility.php' );
    include_once('../config.php' );

    $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
    
    if( isset( $_POST['action'] ) && isset( $_POST['value'] ) ){
        $action = $_POST['action'];
        $value = $_POST['value'];
        
        $sql_query = "";
        $value = json_decode($value, true );
        
        if( isset( $value['user']) ){
           $user = $value['user'];
        }
        if( isset( $value['unita'])){
            $unita = $value['unita'];
        }
        switch ( $action ){
            case "get":
                if( isset( $user )){
                    $sql_query = quick_select2(
                        array("d.id", "d.ruolo" ),
                        array( "dipendenti d", "utenti usr"),
                        array("d.id", "d.id" ),
                        array("usr.id", "\"$user\"" )
                        );
                    $sql_query.= " ORDER BY d.ruolo;";
                    $result = mysqli_query( $connection, $sql_query);
                    $row = mysqli_fetch_assoc($result);
                    if( $row && !is_null( $row['ruolo'] ) ){
                        echo $row['ruolo'];
                    }
                    else echo "";
                }
                break;
            case "add":
                $ruolo = $value['ruolo'];
                $sql_query = insert(   "dipendenti",
                                        array("id", "id_unita", "ruolo" ),
                                        array( $user, $unita, $ruolo ) );
                echo $sql_query;
                $result = mysqli_query( $connection, $sql_query);
                break;
            case "delete":
                $sql_query = "DELETE FROM dipendenti WHERE id=\"$user\"";
                $result = mysqli_query( $connection, $sql_query);
                break;
        }
    }
    mysqli_close($connection);