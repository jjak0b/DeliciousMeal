<?php

header('Content-Type: text/html; charset=\"utf-8\"');

$uri = "";
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
        $uri = 'https://';
}
else{
        $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];

define("HOST", "127.0.0.1:3306" );
define("USER", "root" );
define("PASSWORD", "" );
define("DB_NAME", "as_2017-2018_rimediotti-jacopo_ristorante" );

define('RELATIVE_PATH', "/my_work/jacopo.rimediotti/"); // QUESTA è DA CAMBIARE IN SEGUITO
$dirs = explode( "\\", dirname(__FILE__ ) );
$project_folder = $dirs[ count( $dirs ) - 1 ];


/*
 * definendo questa,
 * basta includere questo script in una pagina php e impostando nel head del file <base href=<?php echo PROJECT_ROOT ?> />
 * per considerare la cartella di root sempre quella del progetto,
 * es struttura cartella :
 * - cartella_progetto
 *      -pages
 *          mywebpage.php
 *      -img
 *      -style
 *          stile.css
 *  index.php
 *          
 * 
 * abbiamo la pagina pages/mywebpage.php aperta nel browser che ha collegato un file css al percorso style/stile.css:
 * normalmnte per accedere a tale cartela da pages/mywebpage.php dovrei mettere il percorso relativo atale cartella
 * ovvero "../style/stile.css" e magari se fosse stata in una sottocartella, il percorso sarebbe cambiato,
 * ma grazie a questo script mi basta mettere style/stile.css indipendentemente dal percorso della pagina parte nel browser
 */
define('PROJECT_ROOT', RELATIVE_PATH.$project_folder."/"  );

session_start();
