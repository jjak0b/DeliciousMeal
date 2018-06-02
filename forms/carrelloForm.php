<?php
include_once('../config.php' );
include_once("../scripts/utility.php");
include_once("../scripts/shared_site.php");

if( !isset( $connection ) ){
    $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
}

// Check connection
if ( mysqli_connect_errno() )
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// in questo caso aggiunge un prodotto con id specifico gli ingredienti di default, che poi potrà essere modficato
if( !isset( $_SESSION['carrello'] ) ){
    $_SESSION['carrello'] = [];
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
<section>
    <?php
    echo "Numero prodotti:".count( $_SESSION['carrello'] );
    echo "<table align=center>";
    foreach ($_SESSION['carrello'] as $key => $prodotto) {
        $id_li = "c_".$key;
        echo "<tr class=\"product-item\" id=".$id_li." value=".$prodotto['id'].">";
            // echo "<table>";
                // echo "<tr>";
                    echo "<td>";
                        echo "<h4 class=\"product-name\">".$prodotto["nome"]."</h4>";
                    echo "</td>";
                    echo "<td>";
                    echo "<details>";
                        echo "<summary>Note aggiuntive</summary>";
                        echo "<textarea name=\"note\" placeholder=\"scrivi eventuali allergie, modifiche o aggiunte non diponibili sul sito, e altro ...\" style=\"resize: vertical; box-sizing: inherit;\">";
                        if( isset( $prodotto["note"] ) ){
                            echo $prodotto["note"];
                        }
                        echo "</textarea>";
                    echo "</details>";
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
                        else{
                            $_SESSION['carrello'][$key]["aggiunti"] = [];
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
                        else{
                            $_SESSION['carrello'][$key]["rimossi"] = [];
                        }
                        echo "</div>";
                    }
                    echo "</td>";
                    $qta = 1;
                    if( !isset( $prodotto["qta"] ) ){
                        $_SESSION['carrello'][$key]["qta"] = 1;
                    }
                    else{
                        $qta = $prodotto["qta"];
                    }
                    echo "<td><input type=\"number\" name=quantity value=".$qta." min=1></td>";
                    echo "<td><button onclick=\"modificaIngredienti(this, '$id_li')\">Modifica</button></td>";
                    echo "<td><span onclick=\"removeFromCart(this, '$id_li')\" class=\"remove\" title=\"Rimuovi\">&times;</span></td>";
                // echo "</tr>";
            // echo "</table>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_close($connection);
    unset( $connection );
    ?>
    <button onclick="order()">Ordine ultimato</button>
</section>
