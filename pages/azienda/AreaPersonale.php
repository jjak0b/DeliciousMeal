<!DOCTYPE html>
<?php
    include_once('../../config.php' );
    include_once('../../scripts/utility.php' );
    include_once('../../scripts/shared_site.php' );
?>
<html>
    <head>
        <title>Area Personale</title>
        <?php
            include_once("../../head.php");
        ?>
    </head>
    <body>
        <?php
            include_once('../../header.php' );
        ?>
        
        <div class="main">
            <div class="container">
                <div class="connection-info">
                    <?php
                    if( !isset( $connection ) ){
                        $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
                    }

                    // Check connection
                    if ( mysqli_connect_errno() )
                    {
                        echo "<p>Failed to connect to MySQL: " . mysqli_connect_error()."</p>";
                    }
                    
                    if( isset( $_GET['login'] ) ){
                        $result_login = $_GET['login'];
                    }
                    if( isset( $_GET['cause'] ) ){
                        $cause = $_GET['cause'];
                    }

                    if( isset( $result_login ) && $result_login == "s"){
                        echo "<p>Login effettuato con successo.</p>";
                    }
                    else if( isset( $result_login ) && $result_login == "f"){
                        echo "<p>";
                        echo "Errore durante la fase di login:<br>";
                        switch( $cause ){
                            case "already_registered" :
                                echo "Utente già registrato";
                                break;
                            case "nouser" :
                                echo "Non è stato trovato alcun utente con le credenziali fornite";
                                break;
                            case "connection":
                                echo "Errore di connessione";
                                break;
                            case 1062: // errore per duplicato
                                echo "Email già utilizzata";
                                break;
                            default :
                                echo "causa sconosciuta, la invitiamo a contattarci per esporci il problema se persiste l'errore";
                                break;
                        }
                        echo "</p>";
                    }
                ?>
                </div>
                <div id="area_personale">
                <?php
                    if( !isset( $_SESSION['user_login'] ) )
                    {
                        echo "<p class=\"center\">Accedi con le tue credenziali"
                        . " private, oppure registrati sul nostro sito</p>";
                        echo "<div class=\"login_form center\" style=\"display: block; width: 60%\">";
                            echo "<div class=\"container\">";
                                include_once( "../../forms/loginForm.php" );
                            echo "</div>";
                        echo "</div>";
                    }
                    else{
                        $unita = get_unita( $connection,
                                    $_SESSION['user_login']['id'] );
                        if( $unita ){ // carico script per i dipendenti
                            echo "<script src=\"scripts/area_dipendenti.js\">"
                                . "</script>";
                        }
                        else{ // carico script per utenti
                            echo "<script src=\"scripts/area_clienti.js\">"
                                . "</script>";
                        }
                        echo "<div id=\"workArea\">";
                        echo "</div>";
                    }
                ?>
                </div>
            </div>
            <script>
                function createSection( title, url )
                {
                    var section = $("<section>");
                    var btn = $("<button>");
                    btn.text(  title );
                    btn.attr( "title",  title );
                    btn.click( {url: url }, load_section );

                    section.append( btn );
                    return section;
                }
                function load_section( event )
                {
                    var url = event.data.url;
                    $.ajax(
                    {
                            type: 'post',
                            url: url,
                            data:
                            {
                                action: "post"
                            },
                            success: function (response) 
                            {
                                $("#workArea").html( response );
                            }
                    } );
                }
            </script>
        </div>
    </body>
</html>
