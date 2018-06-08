<?php
    header('Content-type: text/html; charset=ISO-8859-1');
    include_once('../config.php' );
    include_once('utility.php' );
    include_once('shared_site.php' );

    $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
    $query = "";
    if( isset( $_GET['filter'] ) ){
        $filter = $_GET['filter'];
    }
    if( isset( $_GET['cat'] ) )
    {
        $categoria = $_GET['cat']; // filtro pietanze, primi, secondi, ecc
    }else{
        $categoria = "";
    }/*
    $query = quick_select(  array("p.id", "p.nome", "p.prezzo", "p.descrizione", "p.categoria"),
                        array("pietanze p"),
                        array( p.categoria, ),
                        array( $categoria, )
                        );*/
    $key_words = explode(" ", $filter);
    $query = search_like(
                        array("p.id", "p.nome", "p.prezzo", "p.descrizione", "p.categoria", "p.img"),
                        array("pietanze p"),
                        "p.nome",
                        $key_words
                );
    if( !isset( $categoria ) || !empty( $categoria )){
        $query .= " AND p.categoria= '$categoria'";
    }
    
    $query .= " ORDER BY p.categoria, p.nome;";

    $result_p = mysqli_query($connection, $query);
    
    $piatti = [];
    while( $row = mysqli_fetch_array($result_p ) )
    {
        $piatti[] = $row;
    }

    foreach ($piatti as $key => $piatto) {

        $id = $piatto['id'];
        // $img = $piatto['img'];
        $nome = $piatto['nome'];;
        $prezzo = $piatto['prezzo'];
        $descrizione = $piatto['descrizione'];
        $ingredienti = get_default_ingredienti( $connection, $id );
        printPiatto( $connection, $piatto, $ingredienti );
        // printListPiatti_old( $connection, $piatto, $ingredienti);
    }
    
    mysqli_close( $connection );
    
    function printPiatto( $connection, $piatto, $ingredienti )
    {
        echo "<li class=\"menu-elem blind-content in\" value=".$piatto["id"].">";
            echo "<div class=\"product-header\">";
                echo "<h4 class=\"product-name\">".$piatto['nome']."</h4>";
            echo "</div>";
            echo "<div class=\"product-content\">";
                echo "<div class=\"product-description\">";
                    echo "<p>".$piatto['descrizione']."</p>";
                    echo "<p class=\"product-list\">";
                    $ingredienti_sup = get_ingredienti_supplementi(
                                $connection,
                                $piatto["id"]);
                    if( count( $ingredienti) > 0
                        || count ( $ingredienti_sup ) > 0)
                    {
                        if( count($ingredienti) > 0){
                            $ingredienti_nome = array();
                            foreach ($ingredienti as $key => $ingrediente) {
                                $ingredienti_nome[] = $ingrediente['nome'];
                            }
                            $str_ingredienti_list = implode(
                                    ", ",
                                    $ingredienti_nome);
                            echo "<fieldset><legend>Contenuto:</legend>".$str_ingredienti_list."</fieldset>";
                        }
                        if( count( $ingredienti_sup ) > 0){
                            $supplementi_nome = array();
                            foreach ($ingredienti_sup as $key => $ingrediente_sup) {
                                $supplementi_nome[] = $ingrediente_sup['nome'];
                            }
                            $str_supplementi_list = implode(
                                    ", ",
                                    $supplementi_nome);
                            echo "<fieldset><legend>Supplementi:</legend>".$str_supplementi_list."</fieldset>";
                        }
                    }
                    else if( $piatto['categoria'] == 5 )// bevande
                    {
                        $query_bevanda = "SELECT pi.quantita_ingrediente
                                          FROM pietanze p, ingredienti_pietanze pi
                                          WHERE p.id = pi.id_pietanza AND p.id = ".$piatto['id'];
                        $result_bevanda = mysqli_query($connection, $query_bevanda);
                        $bevanda = mysqli_fetch_array($result_bevanda);
                        $qta = $bevanda['quantita_ingrediente'];
                        echo "<p>Lt. ".$qta."</p>";
                    }
                    echo "</p>";
                echo "</div>";
                echo "<div class=\"product-assets\">";
                    if( isset( $piatto['img'] ) )
                    {
                        echo "<div class=\"product-preview\">";
                            echo "<img src=\"img/".$piatto['img']."\" alt=\"".$piatto['nome']."\" />";
                        echo "</div>";
                    }
                echo "</div>";
                echo "<div class=\"product-general\">";
                    echo "<div class=\"product-price\" style=\"width: 100%; display: inline-block;\" >Euro ".$piatto['prezzo']."</div>";
                    echo "<button  class=\"order_button\" onclick=\"addToCart( this, ".$piatto["id"]." )\" style=\"width: 100%; display: inline-block;\">Ordina</button>";
                echo "</div>";
            echo "</div>";
        echo "</li>";
    }
    
    function printPiattoOld( $connection, $piatto, $ingredienti)
    {
        echo "<li class=\"menu-elem blind-content in\">";
        echo "<div>";
            echo "<div class=\"product-header\">";
                echo "<h4 class=\"product-name\">".$piatto['nome']."</h4>";
                echo "<div class=\"product-price\">Euro ".$piatto['prezzo']."</div>";
            echo "</div>";
            echo "<div class=\"product-content\">";
                echo "<div class=\"product-description\">".$piatto['descrizione']."</div>";
                echo "<div class=\"product-assets";

                if( count( $ingredienti) > 0 )
                {
                    echo " dropdown\">"; // se ci sono gli ingredienti, aggingo la clase dropdown
                    echo "<a class=\"dropbtn\">Ingredienti</a>";
                    echo "<ul class=\"dropdown-content\" style=\"top: 0; right: 100%; background-color:whitesmoke\">";
                        foreach ($ingredienti as $key => $ingrediente) {
                            echo "<li class=\"field ingrediente\">".$ingrediente['nome']."</li>";
                        }
                    echo "</ul>";
                }
                else if( $piatto['categoria'] == 5 )// bevande
                {
                    $query_bevanda = "SELECT pi.quantita_ingrediente
                                      FROM pietanze p, ingredienti_pietanze pi
                                      WHERE p.id = pi.id_pietanza AND p.id = ".$piatto['id'];
                    $result_bevanda = mysqli_query($connection, $query_bevanda);
                    $bevanda = mysqli_fetch_array($result_bevanda);
                    echo "\">"; // se è una bevanda senza ingredienti particolari, chiudo il tag "CLASS"
                    $qta = $bevanda['quantita_ingrediente'];
                    echo "<div>Lt. ".$qta."</div>";
                }
                else
                {
                    echo "\">";// chiudo il tag "CLASS"
                }

                echo "</div>";
            echo "</div>";
        echo "</div>";
        echo "</li>";
    }