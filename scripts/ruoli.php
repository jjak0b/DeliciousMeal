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
                    if( isset( $unita )){
                        $sql_query = quick_select2(
                            array("r.id", "r.ruolo" ),
                            array("unita un", "ruoli r", "utenti usr"),
                            array("r.id_utente", "r.id_unita", "usr.id" , "un.id" ),
                            array("usr.id", "un.id", "'$user'", "'$unita'")
                            );
                    }
                    else{
                        $sql_query = quick_select2(
                            array("r.id", "r.ruolo" ),
                            array( "ruoli r", "utenti usr"),
                            array("r.id_utente", "usr.id" ),
                            array("usr.id", "'$user'" )
                            );
                        $sql_query.= " AND r.id_unita IS NULL";
                    }
                }
                

                $sql_query.= " ORDER BY r.ruolo;";
                echo $sql_query;
                $result = mysqli_query( $connection, $sql_query);

                while( $row = mysqli_fetch_assoc($result) ){
                    echo "<option value=\"".$row['id']."\">".$row['ruolo']."</option>";
                }


                break;
            case "add":
                $ruolo = $value['ruolo'];
                $sql_query = insert(   "ruoli",
                                        array("id_utente", "id_unita", "ruolo" ),
                                        array( $user, $unita, $ruolo )
                                    );
                echo $sql_query;
                $result = mysqli_query( $connection, $sql_query);
                break;
            case "delete":
                $ruolo = $value['ruolo'];
                $sql_query = "DELETE FROM ruoli WHERE id = '$ruolo'";
                echo $sql_query;
                $result = mysqli_query( $connection, $sql_query);
                break;
        }
    }
    mysqli_close($connection);