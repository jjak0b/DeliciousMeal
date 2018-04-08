<?php
include_once('../config.php' );
include_once("../scripts/utility.php");

$connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
// Check connection
if ( mysqli_connect_errno() )
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function get_product_info( $id_value )
{
    
    $query = quick_select2(
                array("p.id", "p.nome", "p.prezzo", "p.descrizione", "p.categoria", "p.img"),
                array("pietanze p"),
                array("p.id"),
                array( id_value )
                );
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc( $result );
    return $row;
}
// in questo caso aggiunge un prodotto con id specifico gli ingredienti di default, che poi potrà essere modficato
if( isset( $_POST['add'] ) )
{
    $p = get_product_info( $_POST['add'] );
    $_SESSION['carrello'][] = $p;
}
// questo non rimuoverà un id di un prodotto ma un l'indice del carrello
// perchè ad esempio:
// ci può essere 1 prodotto con id 1 in quantità 2
// e ci può essere 1 prodotto con id 1 in quantità 1 con specifici elementi rimossi o aggiunti
if( isset( $_POST['remove'] ) )
{
    // non so se mantenere questo perchè forse salvo il carrello nel database...
}
/*
 * $_SESSION['carrello'] // array di prodotti ordinati
 * p = $_SESSION['carrello'][i]
 * P contiene le informazioni del db come p['id'], p['descrizione'], ecc...
 * p["aggiunti"] // contiene gli id degli ingredienti aggiunti al prodotto ordinato
 * p["rimossi"] // contiene gli id degli ingredienti rimossi al prodotto ordinato
 * p["note"] // note aggiuntive sul prodotto
 */
?>
<form class="modal">
    <?php
    $prodotti_ordinati = $_SESSION['carrello'];
    foreach ($prodotti_ordinati as $key => $prodotto) {
        echo "<li id=c_".$key." value=".$prodotto['id'].">";
            echo "<table>";
                echo "<tr>";
                    echo "<td>";
                        echo "<h4 class=\"product-name\">".$prodotto["nome"]."</h4>";
                        if( ( isset( $prodotto["aggiunti"] ) && count( $prodotto["aggiunti"] ) > 0 ) ||
                            ( isset( $prodotto["rimossi"] ) && count( $prodotto["rimossi"] ) > 0 ) )
                        {
                            echo "<div>";
                            if( isset( $prodotto["aggiunti"] ) && count( $prodotto["aggiunti"] ) > 0 ){
                                echo "<div class=\"dropdown\">";
                                    echo "<a class=\"dropbtn\">Elementi aggiunti</a>";
                                    echo "<ul class=\"dropdown-content\" style=\"top: 0; right: 100%; background-color:whitesmoke\">";
                                        foreach ( $prodotto["aggiunti"] as $key_p => $ingrediente ) {
                                            echo "<li class=\"field ingrediente\">".$ingrediente['nome']."</li>";
                                        }
                                    echo "</ul>";
                                echo "</div>";
                            }
                            if( isset( $prodotto["rimossi"] ) && count( $prodotto["rimossi"] ) > 0 ){
                                echo "<div class=\"dropdown\">";
                                    echo "<a class=\"dropbtn\">Elementi rimossi</a>";
                                    echo "<ul class=\"dropdown-content\" style=\"top: 0; right: 100%; background-color:whitesmoke\">";
                                        foreach ($prodotto["rimossi"] as $key_p => $ingrediente) {
                                            echo "<li class=\"field ingrediente\">".$ingrediente['nome']."</li>";
                                        }
                                    echo "</ul>";
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                        echo "<textarea>".$prodotto["note"]."</textarea>";
                    echo "</td>";
                    echo "<td><input type=\"number\ value=".$prodotto["qta"]."></td>";
                    echo "<td><button>Modifica</button></td>";
                echo "</tr>";
            echo "</table>";
        echo "</li>";
    }
    ?>
</form>
