<?php

if( isset( $_POST['action'] ) ){
    $action = $_POST['action'];
}
if( isset( $_POST['value'] ) ){
    $value = $_POST['value'];
    $value = json_decode( $value, true );
}

switch( $action ){
    case "update":
        break;
}