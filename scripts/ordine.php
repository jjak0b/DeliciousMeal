<?php
include_once('../config.php' );
include_once("utility.php");
include_once("shared_site.php");

$connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );

if( !$connection ){
    echo "Errore: Impossibile connettersi al database".PHP_EOL;
    echo mysqli_connect_errno().PHP_EOL;
}
$action;
$value;
if( isset( $_POST['action'] ) ){
    $action = $_POST['action'];
}
if( isset( $_POST['value'] ) ){
    $value = json_decode($_POST['value'], true);
}
if( isset( $_SESSION['user_login'] ) && $connection && isset( $action )){
    
    switch( $action ){
        case "register":
            $sql_ordine = insert(
                    "ordini",
                    array("id_utente", "data"),
                    array( $_SESSION['user_login']['id'], date( DATE_W3C ) ) );
            $result_ordine = mysqli_query($connection, $sql_ordine);
            $id_ordine = mysqli_insert_id( $connection );

            $sql_ordine_tipo = null;
            if( isset( $value['tavolo'] ) ){
                $sql_ordine_tipo = insert(
                        "ordini_locale",
                        array("id", "tavolo" ),
                        array($id_ordine, $value['tavolo'] ));
            }
            else if( isset( $value['indirizzo'] )
                    && isset( $value['citta'] )
                    && isset( $value['comune'] ) ){
                $sql_ordine_tipo = insert(
                        "ordini_domicilo",
                        array(
                            "id",
                            "indirizzo",
                            "citta",
                            "comune" ),
                        array(
                            $id_ordine,
                            $_POST['indirizzo'],
                            $_POST['citta'],
                            $_POST['comune'] ));
            }
            $result_ordine_tipo = mysqli_query($connection, $sql_ordine_tipo );

            foreach ( $_SESSION['carrello'] as $key => $prodotto ) {
                $sql_prodotto_ordinato = insert(
                        "pietanze_ordinate",
                        array(
                            "id_pietanza",
                            "id_ordine",
                            "quantita",
                            "note" ),
                        array(
                            $prodotto['id'],
                            $id_ordine,
                            $prodotto['qta'],
                            $prodotto['note'] ));
                $result_prodotto_ordinato = mysqli_query(
                        $connection,
                        $sql_prodotto_ordinato);
                $id_prodotto_ordinato = mysqli_insert_id( $connection );
                if( count( $prodotto['aggiunti'] ) > 0 ){
                    foreach ($prodotto['aggiunti'] as $key2 => $aggiunto ) {
                        $sql_modifica = insert(
                                "pietanze_modificate",
                                array(
                                    "id_pietanza_ordinata",
                                    "id_ingrediente",
                                    "azione"),
                                array(
                                    $id_prodotto_ordinato,
                                    $aggiunto['id'],
                                    "a" ));
                        mysqli_query($connection, $sql_modifica);
                    }
                }
                if( count( $prodotto['rimossi'] ) > 0 ){
                    foreach ($prodotto['rimossi'] as $key2 => $rimosso ) {
                        $sql_modifica = insert(
                                "pietanze_modificate",
                                array(
                                    "id_pietanza_ordinata",
                                    "id_ingrediente",
                                    "azione" ),
                                array(
                                    $id_prodotto_ordinato,
                                    $rimosso['id'],
                                    "r" ));
                        mysqli_query($connection, $sql_modifica);
                    }
                }
            }
            if( $result_ordine
                    && $result_ordine_tipo
                    && $result_prodotto_ordinato ){
                echo "Ordine ".$id_ordine." completato";
                unset( $_SESSION['carrello'] );
            }
            else{
                echo "Errore: Ordine ".$id_ordine." non completato";
            }
            break;
        case "get_dates_orders":
            $query_date = quick_select(
                    array("data"),
                    array("ordini"),
                    null,
                    null);
            $result_date = mysqli_query($connection, $query_date);
            $date = array();
            while( $row = mysqli_fetch_assoc( $result_date ) ){
                $d = explode(" ", $row['data'] );// separo data e ora
                $date[] = $d[0];
            }
            echo json_encode( $date );
            break;
    }
}


if( $connection ){
    mysqli_close($connection);
}
