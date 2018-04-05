<?php
    include_once('utility.php' );
    include_once('../config.php' );

    $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );

    
    $filter = "";
    if(isset( $_POST['filter'] ) ){
        $filter = $_POST['filter'];
    }
    
    if( isset( $_POST['action'] ) && isset( $_POST['value'] ) ){
        $action = $_POST['action'];
        $value = $_POST['value'];
        
        $sql_query = "";
        switch ( $action ){
            case "assign":
                $value = json_decode($value, true);
                $id_user = $value['user'];
                $id_unita = $value['unita'];
                $sql_query = quick_select2(
                        array("un.id", "un.nome" ),
                        array("unita un", "ruoli r", "utenti usr"),
                        array("r.id_utente", "r.id_unita", "usr.id", "un.id"),
                        array("usr.id", "un.id", "'$id_user'", "'$id_unita'")
                        );
                $result = mysqli_query( $connection, $sql_query);
                if(mysqli_num_rows($result) > 0 ){
                    $sql_query = "UPDATE ruoli SET id_unita = '$id_unita' WHERE id_utente = '$id_user';";
                }
                else{
                    $sql_query = insert(   "ruoli",
                                            array("id_utente", "id_unita" ),
                                            array( $id_user, $id_unita )
                                        );
                }
                
                $result = mysqli_query( $connection, $sql_query);
                mysqli_close($connection);
                exit( 0 );
                break;
            case "get_user_unita":
                $sql_query = quick_select2(
                                        array("un.id", "un.nome" ),
                                        array("unita un", "ruoli r", "utenti usr"),
                                        array("r.id_utente", "r.id_unita", "usr.id"),
                                        array("usr.id", "un.id", "'$value'", )
                                        );
                $sql_query.= " ORDER BY un.nome;";
                $result = mysqli_query( $connection, $sql_query);
                
                if( $row = mysqli_fetch_assoc($result) ){
                    echo "<option value=\"".$row['id']."\">".$row['nome']."</option>";
                }
                
                mysqli_close($connection);
                return;
                break;
        }
        $result = mysqli_query( $connection, $sql_query);
    }
    
    $sql_query = quick_select(
                        array("id", "nome" ),
                        array("unita"),
                        null,
                        null
                        );
    if( !empty( $filter ) ){
        $sql_query .= " WHERE nome LIKE '%$filter%' OR cognome LIKE '%$filter%'";
    }
    
    $sql_query .= " ORDER BY nome;";
    
    $result = mysqli_query( $connection, $sql_query);

    while( $row = mysqli_fetch_assoc($result) ){
        echo "<option value=".$row['id'].">".$row['nome']."</option>";
    }
    
    mysqli_close($connection);