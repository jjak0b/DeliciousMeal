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
    <style>
/* slider
----------------------*/
.slide-wrap {
    margin: 5% auto 0;
    width: max-content;
}
.slide-mask {
    position: relative;
    overflow: hidden;
    height: 40vmin;
    width: 75vmin; /*.slide-mask = .slide*/
}
.slide-group {
    position: relative; 
    width: max-content;
    height: 100%;
    padding: 0;
    margin: 0;
}
.slide {
    color: #fff;
    text-align: center;
    display: inline-block;
    padding: 0;
    margin: 0;
    font-size: 0px;
    width: 75vmin; /*.slide-mask = .slide*/
    height: 100%;
}

.slide > img{
    display: block;
    width: 100%;
    height: 100%;
}

/* nav
----------------------*/
.slide-nav {
    text-align: center;
}
.slide-nav ul {
    margin: 0;
    padding: 0;
}
.slide-nav li {
    display: inline-block;
    width: 1em;
    height: 1em;
    background: yellowgreen;
    cursor: pointer;
    margin-left: .5em;
}
.slide-nav li.current {
    background: crimson;
}
    </style>
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
