<!DOCTYPE html>
<?php
    include_once('config.php' );
    include_once("scripts/utility.php");
?>
<html>
    <head>
        <title>Homepage</title>
        <?php
            include_once("head.php");
        ?>
    </head>
    <body>
        <?php
            include_once('header.php' );
            
            // i 5 prodotti più acquistati saranno visualizzati nella home page
            $n = 5;
            $table_top = "SELECT pa.id_pietanza, SUM(pa.id_pietanza) as tot
                            FROM pietanze_ordinate pa
                            GROUP BY pa.id_pietanza
                            ORDER BY tot DESC LIMIT $n";
            $sql_top_products = quick_select2(
                                            array( "p.id", "p.nome", "p.prezzo", "p.img" ),
                                            array( "($table_top) as top", "pietanze p"),
                                            array( "p.id" ),
                                            array( "top.id_pietanza" ) );
            $rows = [];
            $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
            mysqli_set_charset($connection, "utf8");
            $result_top = mysqli_query($connection, $sql_top_products);
            while( $row = mysqli_fetch_assoc( $result_top ) ){
                $rows[] = $row;
            }
        ?>
        <div class="main">
            <div class="container">
                <div class="slide-wrap">
                    <div class="slide-mask">
                      <ul class="slide-group">
                        <?php
                            foreach ( $rows as $key => $product ) {
                                echo "<li class=\"slide\" value=\"$product[id]\" title=\"$product[nome]\"><img src=\"img/$product[img]\" alt=\"$product[nome]\">";
                            }
                        ?>
                      </ul>
                    </div>
                    <div class="slide-nav">
                      <ul>
                        <?php
                            foreach ( $rows as $key => $product ) {
                                echo "<li class=\"bullet\" title=\"$product[nome]\"></li>";
                            }
                        ?>
                      </ul>
                    </div>
                </div>
                <script src="scripts/js/slide.js"></script>
            </div>
        </div>
    </body>
</html>
