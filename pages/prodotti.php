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
                prova
                <ul class="menu-list_t">
                    
                    <li class="menu-elem blind-content in">
                        <div class="product-header">
                            <h4 class="product-name">Crostini toscani</h4>
                        </div>
                        <div class="product-content">
                            <div class="product-description">
                                ChmYbjuJTxTuMXGmKamn5zFFXmjCzBaEhyUSiWcI82LEPeFSKmpli40ay8pgbb1FLcrSVq9TCzwaI4eK3WnCoCHHbREMYjjKpnqoIKOHz3pLW1aEMx8LoJnzifvTCjBbCTXmvOWDlwKLR3ofXsTWFnI4AmTeuHt6ObnW3b9o0QW9sD61qYcrpnejskYVZaTPeH16wsIQZRv6E7FoWmKNA1zZSdsKLfjdtoKrvHhb2fEYDtQaW3dWGSr1VoIExJF
                            </div>
                            <div class="product-assets">
                                <div class="product-preview">
                                    <img src="img/carbonara.jpg" />
                                </div>
                                <div class="product-list">
                                    <div class="dropdown">
                                        <a class="dropbtn">Ingredienti</a>
                                        <ul class="dropdown-content" style="top: 0; right: 100%; background-color:whitesmoke">
                                            <li class="field ingrediente">fegatini</li>
                                            <li class="field ingrediente">pane</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="product-general">
                                <div class="product-price" style="width: 100%; display: inline-block;" >Euro 3.50</div>
                                <button onclick="addToCart(this) "style="width: 100%; display: inline-block;">Ordina</button>
                            </div>
                        </div>
                    </li>
                    <!--
                    <li class="menu-elem">
                        <div style="vertical-align: middle;">
                            <div style="width: 50%; display: inline-block; font-size: initial; vertical-align: middle;">
                                <h4>nome</h4>
                                <div style="word-wrap:break-word;">
                                    ChmYbjuJTxTuMXGmKamn5zFFXmjCzBaEhyUSiWcI82LEPeFSKmpli40ay8pgbb1FLcrSVq9TCzwaI4eK3WnCoCHHbREMYjjKpnqoIKOHz3pLW1aEMx8LoJnzifvTCjBbCTXmvOWDlwKLR3ofXsTWFnI4AmTeuHt6ObnW3b9o0QW9sD61qYcrpnejskYVZaTPeH16wsIQZRv6E7FoWmKNA1zZSdsKLfjdtoKrvHhb2fEYDtQaW3dWGSr1VoIExJF
                                </div>
                            </div>
                            <div style="max-width: 20%; display: inline-block; font-size: initial; vertical-align: middle;">
                                <img src="img/carbonara.jpg" style="width: auto; display: inline-block; font-size: initial; vertical-align: middle;"/>
                            </div>
                            <div style="width: 15%; display: inline-block; font-size: initial; vertical-align: middle;"> 
                                <div>
                                    prezzo
                                </div>
                                <div class="dropdown">
                                    <a class="dropbtn">Ingredienti</a>
                                    <ul class="dropdown-content">
                                        <li class="field">Uova</li>
                                        <li class="field">Pasta</li>
                                        <li class="field">Pomodoro</li>
                                        <li class="field">Rucola</li>
                                    </ul>
                                </div>
                            </div>
                            <div style="width: 10%; display: inline-block; font-size: initial; vertical-align: middle;" title="ordina">
                                <button style="margin: 50% auto;">Ordina</button>
                            </div>                        
                        </div>
                        <div class="clear"></div>
                    </li>-->
                </ul>
            </div>
            <script src="scripts/menu.js"></script>
            <script src="scripts/carrello.js"></script>
        </div>
        <?php
            mysqli_close( $connection );
        ?>
    </body>
</html>