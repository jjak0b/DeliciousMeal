<!DOCTYPE html>
<?php
    include_once('../config.php' );
    include_once("../scripts/utility.php");
?>
<html>
    <head>
        <title>Prodotti</title>
        <?php
            include_once("../head.php");
        ?>
    </head>
    <body>
        <?php
            include_once('../header.php' );
            $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
            // Check connection
            if ( mysqli_connect_errno() )
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
        ?>
        <div class="main">
            <div class="container">
                <div class="center">
                    <form id=menu_filter >
                        <select id="categoria" style="max-width: 40%;">
                            <?php
                                $query_categorie = quick_select(
                                        array("c.id", "c.nome", "c.descrizione"),
                                        array("categorie c"),
                                        null,
                                        null
                                    );
                                
                                echo "<option value=\"0\">tutti</option>";
                                $result_c = mysqli_query($connection, $query_categorie);
                                while( $row = mysqli_fetch_assoc( $result_c ) ){
                                    echo "<option ";
                                    if( isset( $_GET['c'] ) && $_GET['c'] == $row['id'] ){
                                        echo " selected ";
                                    }
                                    echo " value=\"".$row['id']."\" title=\"".$row['descrizione']."\"";
                                    echo ">".$row['nome']."</option>";
                                }
                            ?>
                        </select>
                        <input id="filter" type="search" placeholder="Cerca un piatto nella categoria selezionata" style="max-width: 40%">
                        
                    </form>
                </div>
                <ul class="menu-list">
                </ul>
                <!--
                <div class="menu-elem">
                    <div class="product-header">
                        <h4 class="product-name">nome</h4>
                        <div class="product-price">prezzo</div>
                    </div>

                    <div class="product-content">
                        <div class="product-description">
                            descrizione dgdfcvb sdfffffffffffffffffffffffffffffffffffffff fdf dsfest segf sdfds<br>
                            dsgcsexdcghdvgssbnhv vrtffffffffffffffffffffffffffe  fettttttttttttttttttttttttttttttttttttttttttttttttttrfedwyy <br>
                        </div>
                        <div class="product-assets dropdown">
                            <a class="dropbtn">Ingredienti</a>
                            <ul class="dropdown-content">
                                <li>Uova</li>
                                <li>Pasta</li>
                                <li>Pomodoro</li>
                                <li>Rucola</li>
                            </ul>
                        </div>
                    </div>

                </div>-->
            </div>
            <script src="scripts/menu.js"></script>
        </div>
        <?php
            mysqli_close( $connection );
        ?>
    </body>
</html>