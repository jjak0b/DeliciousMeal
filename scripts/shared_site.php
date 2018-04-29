<?php
/*
 * Funzioni condivise e utilizzate da altri script del sito
 */
function get_ingredienti_disponibili( $connection, $index, $id_pietanza ){
    $query_ing_default = quick_select2( array("i.id"),
                                            array("ingredienti i", "ingredienti_pietanze ip", "pietanze p"),
                                            array("i.id", "p.id", "p.id"),
                                            array( "ip.id_ingrediente", "ip.id_pietanza", $id_pietanza) );
    $query_ing_all = quick_select2( array("i.id", "i.nome", "i.prezzo"),
                                        array("ingredienti i"),
                                        null,
                                        null);
    $query_ing_available = $query_ing_all." WHERE i.id NOT IN ( $query_ing_default ) ORDER BY i.nome";
    
    $result_available = mysqli_query($connection, $query_ing_available );
    $rows = [];
    while( $row = mysqli_fetch_assoc($result_available) ){
        $rows[] = $row;
    }
    
    if( !isset( $_SESSION['carrello'][$index]['aggiunti'] ) ){
        $_SESSION['carrello'][$index]['aggiunti'] = [];
    }
    if( !isset( $_SESSION['carrello'][$index]['rimossi'] ) ){
        $_SESSION['carrello'][$index]['rimossi'] = [];
    }
    
    // aggiungo agli ingredienti disponbili, quelli rimossi
    foreach ($_SESSION['carrello'][$index]['rimossi'] as $key => $rimosso) {
        $rows[] = $rimosso;
    }
    
    // rimuovo dagli ingredienti disponbili, quelli aggiunti
    foreach ($_SESSION['carrello'][$index]['aggiunti'] as $key => $aggiunto) {
        foreach ($rows as $index1 => $disponibile) {
            if($disponibile["id"]==$aggiunto['id']){
                unset( $rows[$index1] );
            }
        }
    }
    
    return array_values($rows);
}

function get_ingredienti_correnti( $connection, $index, $id_pietanza ){
    $rows = get_default_ingredienti( $connection, $id_pietanza );
    
    if( !isset( $_SESSION['carrello'][$index]['aggiunti'] ) ){
        $_SESSION['carrello'][$index]['aggiunti'] = [];
    }
    if( !isset( $_SESSION['carrello'][$index]['rimossi'] ) ){
        $_SESSION['carrello'][$index]['rimossi'] = [];
    }
    
    // aggiungo agli ingredienti correnti, quelli aggiunti
    foreach ($_SESSION['carrello'][$index]['aggiunti'] as $key => $aggiunto) {
        $rows[] = $aggiunto;
    }
    
    // rimuovo dagli ingredienti correnti, quelli rimossi
    foreach ($_SESSION['carrello'][$index]['rimossi'] as $key => $rimosso) {
        foreach ($rows as $index1 => $corrente) {
            if($corrente["id"]==$rimosso['id']){
                unset( $rows[$index1] );
            }
        }
    }
    
    return array_values($rows);
}

function get_default_ingredienti( $connection, $id_pietanza ){
    $query_ing_default = quick_select2( array("i.id", "i.nome", "i.prezzo"),
                                        array("ingredienti i", "ingredienti_pietanze ip", "pietanze p"),
                                        array("i.id", "p.id", "p.id"),
                                        array( "ip.id_ingrediente", "ip.id_pietanza", $id_pietanza) );
    $result_default = mysqli_query($connection, $query_ing_default );
    $rows = [];
    while( $row = mysqli_fetch_assoc($result_default) ){
        $rows[] = $row;
    }
    return $rows;
}

function get_ingrediente( $connection, $id_ingrediente ){
    $query_ing = quick_select2( array("*"),
                                        array("ingredienti"),
                                        array("id" ),
                                        array( $id_ingrediente) );
    $result_default = mysqli_query($connection, $query_ing );
    $row = mysqli_fetch_assoc($result_default);
    return $row;
}

function get_product_info( $connection, $id_value )
{
    
    $query = quick_select2(
                array("p.id", "p.nome", "p.prezzo", "p.descrizione", "p.categoria", "p.img"),
                array("pietanze p"),
                array("p.id"),
                array( $id_value )
                );
    echo $query;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc( $result );
    return $row;
}

function get_unita( $connection, $id_utente ){
    $sql_query = quick_select2(
        array("un.id", "un.nome" ),
        array("unita un", "ruoli r", "utenti usr"),
        array("r.id_utente", "r.id_unita", "usr.id"),
        array("usr.id", "un.id", "\"$id_utente\"")
        );
    $result = mysqli_query($connection, $sql_query);
    $row = mysqli_fetch_assoc( $result );
    return $row;
}