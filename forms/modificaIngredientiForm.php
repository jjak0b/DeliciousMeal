<?php
    include_once('../config.php' );
    include_once("../scripts/utility.php");
    $value = null;
    if( isset( $_POST['value']))
    {
        $value = json_decode( $_POST['value'], true );
        $id_product = $value['id'];// id del prodotto
        $index = $value['index'];// indice del carrello
    }
    $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
?>

<div style="display: inline-block; vertical-align: top;">
    <label>Ingredienti correnti</label>
    <section>
    <?php
        $correnti = get_ingredienti_correnti( $connection, $index, $id_product );
        echo "<ul class=\"editable-list\" name=\"correnti\" size=".count($correnti).">";
        foreach ($correnti as $key => $row) {
            echo "<li class=\"editable-item\" value=".$row['id'].">";
                echo "<div>";
                    echo "<div class=\"editable-label\">";
                        echo "<label>".$row['nome']."</label>";
                    echo "</div>";
                    echo "<div class=\"editable-button\">";
                        echo "<button class=\"btn-remove\">";
                        echo "</button>";
                    echo "</div>";
                echo "</div>";
            echo "</li>";
        }
        echo "</ul>";
    ?>
    </section>
</div>
<div style="display: inline-block; vertical-align: left;">
    <label>Ingredienti Disponibili</label>
    <section>
    <?php
        $disponibili = get_ingredienti_disponibili( $connection, $index, $id_product );
        echo "<ul class=\"editable-list\" name=\"disponibili\" size=".count($disponibili).">";
        foreach ($disponibili as $key => $row) {
            echo "<li class=\"editable-item\" value=".$row['id'].">";
                echo "<div>";
                    echo "<div class=\"editable-label\">";
                        echo "<label>".$row['nome']."</label>";
                    echo "</div>";
                    echo "<div class=\"editable-button\">";
                        echo "<button class=\"btn-add\">";
                        echo "</button>";
                    echo "</div>";
                echo "</div>";
            echo "</li>";
        }
        echo "</ul>";
    ?>
    </section>
</div>
<?php
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
    $query_ing_default = quick_select2( array("i.id", "i.nome", "i.prezzo"),
                                        array("ingredienti i", "ingredienti_pietanze ip", "pietanze p"),
                                        array("i.id", "p.id", "p.id"),
                                        array( "ip.id_ingrediente", "ip.id_pietanza", $id_pietanza) );
    $result_default = mysqli_query($connection, $query_ing_default );
    $rows = [];
    while( $row = mysqli_fetch_assoc($result_default) ){
        $rows[] = $row;
    }
    
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
?>