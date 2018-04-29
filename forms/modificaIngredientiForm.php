<?php
    include_once('../config.php' );
    include_once("../scripts/utility.php");
    include_once("../scripts/shared_site.php");
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
        echo "<ul id=\"correnti\" class=\"editable-list\" name=\"correnti\" size=".count($correnti).">";
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
<div style="display: inline-block; vertical-align: top;">
    <label>Ingredienti Disponibili</label>
    <section>
    <?php
        $disponibili = get_ingredienti_disponibili( $connection, $index, $id_product );
        echo "<ul id=\"disponibili\" class=\"editable-list\" name=\"disponibili\" size=".count($disponibili).">";
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
        mysqli_close($connection);
    ?>
    </section>
</div>
<div>
    <button id="submit_changes" style="width: 50%">Conferma Modifiche</button>
</div>
