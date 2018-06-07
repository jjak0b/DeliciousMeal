<?php

echo "<header>
        <div class=\"logo-container left\">
            <div class=\"logo-container-content left\">
                <img src=\"img/logo.png\" alt=\"Delicious Meal\"/>
            </div>
            <div class=\"logo-container-content left\">
                <h1>Delicious Meal</h1>
            </div>
        </div>";
        /*<div class=\"right\">
            <h2>Developed By Jacopo Rimediotti</h2>
        </div>*/
echo    "<div class=\"clear\"></div>
            <!--<h1 class=\"logo\">Delicious Meal</h1>-->

        <div class=\"logo-motto\">
            <h1 class=\"logo-text\">Ordina, paga, mangia: tutto questo da casa tua</h1>
        </div>
        <script src=\"scripts/menu.js\" charset=\"UTF-8\"></script>";
include_once( "scripts/navbar.php");
echo "</header>";

 if( isset( $_SESSION['user_login'] ) )
 {
     echo "<p class=\"welcome\">Hai effettuato l'accesso come ".$_SESSION['user_login']['cognome']." ".$_SESSION['user_login']['nome']."</p>";
 }