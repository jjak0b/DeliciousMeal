<?php
include_once('../config.php' );
include_once("../scripts/utility.php");

if( isset( $_POST['action'] ) ){
    $action = $_POST['action'];
}
if( isset( $_POST['value'] ) ){
    $value = $_POST['value'];
    $value = json_decode( $value, true );
}

switch( $action ){
    case "update":
        $index = $value['index'];
        $info = $value['data'];
        if( ( isset( $index ) && isset( $info ) ) && $_SESSION['carrello'][$index]['id'] == $info['id'] ){
            $_SESSION['carrello'][$index]['qta'] = $info['qta'];
            $_SESSION['carrello'][$index]['note'] = $info['note'];
            // TODO ingredienti aggiunti/rimossi
        }
        include_once('../forms/carrelloForm.php');
        // echo print_r( $value );
        break;
}