<?php
    include_once('utility.php' );
    include_once('../config.php' );

    $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );

    $filter = "";
    if(isset( $_POST['filter'] ) ){
        $filter = $_POST['filter'];
    }
    
    $sql_usr_src = quick_select(
                        array("id", "nome", "cognome" ),
                        array("utenti"),
                        null,
                        null
                        );
    $sql_usr_src .= " WHERE nome LIKE '%$filter%' OR cognome LIKE '%$filter%' ORDER BY cognome, nome;";

    $result = mysqli_query( $connection, $sql_usr_src);

    while( $row = mysqli_fetch_assoc($result) ){
        echo "<option value=".$row['id'].">".$row['cognome']." ".$row['nome']."</option>";
    }
    
    mysqli_close($connection);