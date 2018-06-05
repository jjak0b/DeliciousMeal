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
                <div class="wrapper">
                    <h2 class="center">I nostri 5 prodotti più apprezzati:</h2>
                    <div class="jcarousel-wrapper">
                        <div class="jcarousel">
                            <ul>
                                <?php
                                    foreach ( $rows as $key => $product ) {
                                        echo "<li value=\"$product[id]\" title=\"$product[nome]\"><img src=\"img/$product[img]\" alt=\"$product[nome]\"></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                        <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                        <a href="#" class="jcarousel-control-next">&rsaquo;</a>
                        <p class="jcarousel-pagination">
                        </p>
                    </div>
                </div>
                <script type="text/javascript" src="ajax/libs/jcarousel/jcarousel-core.js"></script>
                <script type="text/javascript" src="ajax/libs/jcarousel/jcarousel-control.js"></script>
                <script type="text/javascript" src="ajax/libs/jcarousel/jcarousel-pagination.js"></script>
                <script type="text/javascript" src="ajax/libs/jcarousel/jcarousel-autoscroll.js"></script>
                <script type="text/javascript" src="ajax/libs/jcarousel/jcarousel-scrollintoview.js"></script>
                <script type="text/javascript">
                (function($) {
                    $(function() {
                        var interval = 3000;
                        $('.jcarousel').jcarousel();
                        $('.jcarousel')
                            .jcarouselAutoscroll({
                                interval: interval,
                                target: '+=1',
                                autostart: true,
                                method: 'scroll'
                            });
                        $('.jcarousel')
                            .on('jcarousel:scrollend', function() {
                                if( !$(this).jcarousel("hasNext") ){
                                    $(this).jcarousel('scroll', 0);
                                }
                            });
                        $('.jcarousel-control-prev')
                            .on('jcarouselcontrol:active', function() {
                                $(this).removeClass('inactive');
                            })
                            .on('jcarouselcontrol:inactive', function() {
                                $(this).addClass('inactive');
                            })
                            .jcarouselControl({
                                target: '-=1'
                            });

                        $('.jcarousel-control-next')
                            .on('jcarouselcontrol:active', function() {
                                $(this).removeClass('inactive');
                            })
                            .on('jcarouselcontrol:inactive', function() {
                                $(this).addClass('inactive');
                            })
                            .jcarouselControl({
                                target: '+=1'
                            });

                        $('.jcarousel-pagination')
                            .on('jcarouselpagination:active', 'a', function() {
                                $(this).addClass('active');
                            })
                            .on('jcarouselpagination:inactive', 'a', function() {
                                $(this).removeClass('active');
                            })
                            .jcarouselPagination();
                    });
                })(jQuery);
                </script>
            </div>
        </div>
    </body>
</html>
