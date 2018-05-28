<?php
include_once('../config.php' );
include_once("utility.php");
include_once("shared_site.php");

if( isset( $_POST['action'] ) ){
    $action = $_POST['action'];
}
if( isset( $_POST['value'] ) ){
    $value = $_POST['value'];
    $value = json_decode( $value, true );
}
$connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME ) or die();

switch( $action ){
    case "update":
        $index = $value['index'];
        $info = $value['data'];
        if( isset( $_SESSION['carrello'][$index] ) ){
            if(!isset( $_SESSION['carrello'][$index]['aggiunti'] ) ){
                $_SESSION['carrello'][$index]['aggiunti'] = [];
            }
            if(!isset( $_SESSION['carrello'][$index]['rimossi'] ) ){
                $_SESSION['carrello'][$index]['rimossi'] = [];
            }

            if( ( isset( $index ) && isset( $info ) )
                && $_SESSION['carrello'][$index]['id'] == $info['id']
            ){
                $_SESSION['carrello'][$index]['qta'] = $info['qta'];
                $_SESSION['carrello'][$index]['note'] = $info['note'];
            }
        }
        include_once('../forms/carrelloForm.php');
        break;
    case "set_changes":
        $index = $value['index'];
        $id_prodotto = $value['id'];
        $default_ingredienti = get_default_ingredienti( $connection, $id_prodotto );
        $ingredienti_modificati = [];
        $ingredienti_modificati['aggiunti'] = [];
        $ingredienti_modificati['rimossi'] = [];
        
        // ricavo gli ingredienti rimossi
        foreach ($default_ingredienti as $key => $default) {
            // se tra gli elementi correnti non vi è un elemento di default
            if( !in_array( $default['id'], $value['correnti'] ) ){
                $ingredienti_modificati['rimossi'][] = $default['id'];// allora è stato rimosso
            }
        }
        
        // filtro gli ingredienti aggiunti
        foreach ($value['correnti'] as $key1 => $id_corrente) {
            $b_default_ingrediente = false;
            foreach ($default_ingredienti as $key2 => $default) {
                if( $id_corrente == $default['id'] ){ // 
                    $b_default_ingrediente = true;
                    break;
                }
            }
            
            if( !$b_default_ingrediente ){
                $ingredienti_modificati['aggiunti'][] =  $id_corrente;
            }
        }
        // aggiorno le modifiche nel carrello
        $_SESSION['carrello'][$index]['aggiunti'] = [];
        foreach ($ingredienti_modificati['aggiunti'] as $key => $id_ingrediente) {
            $value = get_ingrediente( $connection, $id_ingrediente );
            if( isset($value) && $value ){
                $_SESSION['carrello'][$index]['aggiunti'][] = $value;
            }
        }
        
        $_SESSION['carrello'][$index]['rimossi'] = [];
        foreach ($ingredienti_modificati['rimossi'] as $key => $id_ingrediente) {
            $value = get_ingrediente( $connection, $id_ingrediente );
            if( isset($value) && $value ){
                $_SESSION['carrello'][$index]['rimossi'][] = $value;
            }
        }
        
        
        break;
    case "add":
        $p = get_product_info( $connection, $value['id'] );
        $p['aggiunti'] = [];
        $p['rimossi'] = [];
        $_SESSION['carrello'] = array_values( $_SESSION['carrello'] );
        $_SESSION['carrello'][] = $p;
        break;
    case "remove":
    /*questo non rimuoverà un id di un prodotto ma un l'indice del carrello
     * perchè ad esempio:
     * ci può essere 1 prodotto con id 1 in quantità 2
     * e ci può essere 1 prodotto con id 1 in quantità 1 con specifici elementi
     * rimossi o aggiunti*/
    // non so se mantenere questo perchè forse salvo il carrello nel database...
        if( isset( $_SESSION['carrello'][ $value['index'] ] ) ){
            unset( $_SESSION['carrello'][ $value['index'] ] );
        }
        $_SESSION['carrello'] = array_values( $_SESSION['carrello'] );
        break;
    case "intermission":
        if( isset( $_SESSION['user_login'] ) ){
            $unita = get_unita($connection, $_SESSION['user_login']['id'] );
            /*se l'utente è un dipendente e appartiene all'UO riservata
             * allo staff del  SERVIZIO SALA ( renderlo accessibile a tutti
             *  i dipendenti? )
             */
            // if( isset( $unita ) && $unita && $unita['id'] == 9 ){
            if( isset( $unita ) ){// temp
                include_once("../forms/InfoOrdine/InfoLocaleForm.php");
            }
            else{
                include_once("../forms/InfoOrdine/InfoDomicilioForm.php");
            }
        }
        else{
            echo "<script>";
            echo "alert(\"Devi prima effettuare l'accesso\");";
            echo "$(\"#cart_form\").css( 'display', 'none' );";
            echo "</script>";
        }
        break;
}
if( isset( $connection ) ){
    mysqli_close($connection);
    unset( $connection );
}

