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
    $tot = 0.00;
    echo "Numero prodotti:".count( $_SESSION['carrello'] );
    echo "<hr>";
    echo "<ul id=\"cart_list\">";
    foreach ($_SESSION['carrello'] as $key => $prodotto) {
        $id_li = "c_".$key;
        echo "<li class=\"product-item\" id=".$id_li." value=".$prodotto['id'].">";
            echo "<table align=center>";
                echo "<tr>";
                    echo "<td class=\"price-info\">";
                        echo "<h5 style=\"margin: 1% 0;\">Pietanza</h5>";
                        echo "<span>Euro <span>";
                        echo "<input class=\"price-default\" type=\"number\" disabled value=".$prodotto['prezzo'].">";
                    echo "</td>";
                    echo "<td>";
                        echo "<h4>".$prodotto["nome"]."</h4>";
                    echo "</td>";
                    echo "<td><button onclick=\"modificaIngredienti(this, '$id_li')\">Modifica</button></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>";
                        $tot_suppl = 0;
                        foreach ( $prodotto["aggiunti"] as $key_p => $ingrediente ) {
                            $tot_suppl += $ingrediente["prezzo"];
                        }
                        foreach ( $prodotto["rimossi"] as $key_p => $ingrediente ) {
                            $tot_suppl -= $ingrediente["prezzo"];
                        }
                            echo "<h5 style=\"margin: 1% 0;\">Supplementi</h5>";
                            echo "<span>Euro </span>";
                            echo "<input class=\"price-edit\" type=\"number\" disabled value=".$tot_suppl.">";
                    echo "</td>";
                    echo "<td colspan=\"2\">";
                        echo "<details class=\"center\">";
                            echo "<summary>Note aggiuntive</summary>";
                            echo "<textarea name=\"note\" placeholder=\"Scrivi eventuali allergie, modifiche o aggiunte non diponibili sul sito, e altro ...\" style=\"resize: vertical; box-sizing: inherit;\">";
                            if( isset( $prodotto["note"] ) ){
                                echo $prodotto["note"];
                            }
                            echo "</textarea>";
                        echo "</details>";
                    echo "</td>";
                    echo "<td><span onclick=\"removeFromCart(this, '$id_li')\" class=\"remove\" title=\"Rimuovi\">&times;</span></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>";
                        echo "<h5 style=\"margin: 1% 0;\">Prezzo unitario</h5>";
                        echo "<span>Euro </span>";
                        echo "<input name=\"p_u\" type=\"number\" disabled value=".($prodotto['prezzo']+$tot_suppl).">";
                    echo "</td>";
                    $qta = 1;
                    if( !isset( $prodotto["qta"] ) ){
                        $_SESSION['carrello'][$key]["qta"] = 1;
                    }
                    else{
                        $qta = $prodotto["qta"];
                    }
                    $tot += ( ($prodotto['prezzo']+$tot_suppl)* $qta);
                    echo "<td><div>".htmlentities("Quantità")."</div><input type=\"number\" name=quantity value=".$qta." min=1></td>";
                    echo "<td>";
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
                        echo "</div>";
                        echo "<div>";
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
                    echo "</td>";
                echo "</tr>";
            echo "</table>";
        echo "</li>";
        echo "<hr>";
    }
    echo "</ul>";
    echo "<table align=center>";
        echo "<tr>";
            echo "<th>Importo totale</th>";
        echo "</tr>";
        echo "<tr><td id=\"importo-totale\">Euro $tot</td></tr>";
    echo "</table>";
    echo "<br>";
    mysqli_close($connection);
    unset( $connection );
    ?>
    <button onclick="order()">Ordine ultimato</button>
    <script>
        function update_price(){
            var ul = document.getElementById( "cart_list" );
            var tot = 0.00;
            $(ul).find( ".product-item" ).each(function( index, elem ){
                tot += get_item_price( li );
            });
            var e_tot = document.getElementById( "cart_list" );
            $( e_tot ).html("<span>Euro " + tot +"</span>");
        }
        function get_item_price( li ){
            var p_u = $( li ).find( "input[name=p_u]").attr("value");
            var qta = $( li ).find( "input[name=quantity]").attr("value");
            return p_u*qta;
        }
    </script>
</section>
