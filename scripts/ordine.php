<?php
include_once('../config.php' );
include_once("utility.php");
include_once("shared_site.php");

$connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );

if( !$connection ){
    echo "Errore: Impossibile connettersi al database".PHP_EOL;
    echo mysqli_connect_errno().PHP_EOL;
}

if( isset( $_SESSION['user_login'] ) && $connection ){
    
    $sql_ordine = insert("ordini",
                            array("id_utente" ),
                            array( $_SESSION['user_login']['id'] )
                        );
   $result_ordine = mysqli_query($connection, $sql_ordine);
   $id_ordine = mysqli_insert_id( $connection );
   
   $sql_ordine_tipo = null;
   if( isset( $_POST['tavolo'] ) ){
       $sql_ordine_tipo = insert("ordini_locale",
                            array("id", "tavolo" ),
                            array($id_ordine, $_POST['tavolo'] )
                        );
   }
   else if( isset( $_POST['indirizzo'] ) && isset( $_POST['citta'] ) && isset( $_POST['comune'] ) ){
        $sql_ordine_tipo = insert("ordini_domicilo",
                            array("id", "indirizzo", "citta", "comune" ),
                            array($id_ordine, $_POST['indirizzo'], $_POST['citta'], $_POST['comune'] )
                        );
   }
   $result_ordine_tipo = mysqli_query($connection, $sql_ordine_tipo );
   
   foreach ( $_SESSION['carrello'] as $key => $prodotto ) {
        $sql_prodotto_ordinato = insert("pietanze_ordinate",
                                    array("id_pietanza", "id_ordine", "quantita", "note" ),
                                    array($prodotto['id'], $id_ordine, $prodotto['qta'], $prodotto['note'] )
                                );
        $result_prodotto_ordinato = mysqli_query($connection, $sql_prodotto_ordinato);
        $id_prodotto_ordinato = mysqli_insert_id( $connection );
        if( count( $prodotto['aggiunti'] ) > 0 ){
            foreach ($prodotto['aggiunti'] as $key2 => $aggiunto ) {
                $sql_modifica = insert("pietanze_modificate",
                                            array("id_pietanza_ordinata", "id_ingrediente", "azione" ),
                                            array($id_prodotto_ordinato, $aggiunto['id'], "a" )
                                );
                mysqli_query($connection, $sql_modifica);
            }
        }
        if( count( $prodotto['rimossi'] ) > 0 ){
            foreach ($prodotto['rimossi'] as $key2 => $rimosso ) {
                $sql_modifica = insert("pietanze_modificate",
                                            array("id_pietanza_ordinata", "id_ingrediente", "azione" ),
                                            array($id_prodotto_ordinato, $rimosso['id'], "r" )
                                );
                mysqli_query($connection, $sql_modifica);
            }
        }
   }
   if( $result_ordine && $result_ordine_tipo && $result_prodotto_ordinato ){
       echo "Ordine ".$id_ordine." completato";
       unset( $_SESSION['carrello'] );
   }
   else{
       echo "Errore: Ordine ".$id_ordine." non completato";
   }
   
}


if( $connection ){
    mysqli_close($connection);
}
