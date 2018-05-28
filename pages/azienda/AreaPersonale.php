<!DOCTYPE html>
<?php
    include_once('../../config.php' );
    include_once('../../scripts/utility.php' );
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
                            echo "<p>Se sei un dipendente della nostra azienda, accedi con le credenziali fornite</p>";
                            echo "<div class=\"login_form\" style=\"display: block;\">";
                                echo "<div class=\"container\"";
                                    include_once( "../../forms/loginForm.php" );
                                echo "</div>";
                            echo "</div>";
                        }else{
                            echo "<section>";
                                echo "sezione sempre presente dopo login per scopo didattico, altrimenti dovrebbe apparire solo se l'utente loggato è stato assegnato alla direzione o risorse umane";
                            echo "</section>";
                            echo "<script src=\"scripts/area_personale.js\"></script>";
                            echo "<div id=\"workArea\">";
                            // include_once( "../../forms/assignUsersForm.php" );
                            echo "<div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
