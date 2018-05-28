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
if( isset( $_SESSION['user_login'] )
        && $connection
        && isset( $action ) ){
    
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
                    && isset( $value['comune'] ) 
                    && isset( $value['giorno'])
                    && isset( $value['ora'])){
                
                $giorno = explode("-", $value['giorno'] );
                // inverto la data per formato richiesto dal DB
                $giorno_consegna =  $giorno[2]."-".$giorno[1]."-".$giorno[0]
                                    ." ".$value["ora"];
                $sql_ordine_tipo = insert(
                        "ordini_domicilio",
                        array(
                            "id",
                            "indirizzo",
                            "citta",
                            "comune" ,
                            "giorno_consegna"),
                        array(
                            $id_ordine,
                            $value['indirizzo'],
                            $value['citta'],
                            $value['comune'],
                            $giorno_consegna));
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
            $query_date_locale = quick_select2(
                    array("o.data"),
                    array("ordini o", "ordini_locale ol"),
                    array("o.id"),
                    array("ol.id") );
            $query_date_domicilio = quick_select2(
                    array("od.giorno_consegna as data"),
                    array("ordini o", "ordini_domicilio od"),
                    array("o.id"),
                    array("od.id") );
            $query_date = "SELECT DISTINCT CAST( data as date ) as data
                        FROM (
                        ( $query_date_locale ) UNION ( $query_date_domicilio )
                        ) as d ORDER BY d.data;";
            $result_date = mysqli_query($connection, $query_date);
            $date = array();
            while( $row = mysqli_fetch_assoc( $result_date ) ){
                // $date[] = explode(" ", $row['data'] )[0];
                $date[] = $row['data'];
            }
            echo json_encode( $date );
            break;
    }
}


if( $connection ){
    mysqli_close($connection);
}