
<?php
    include_once 'config.php';
?>

<base href="<?php echo PROJECT_ROOT ?>" >
<meta name="description" content="Ordina, Paga, mangia: scopri il nostro ristorante Delicious Meal e assapora le nostre specialità nella nostra sede oppure ordinando online" />
<meta name="author" content="Jacopo Rimediotti">
<meta name="keywords" content="Ristorante, Delicious, Meal, DeliciousMeal">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta charset="Unicode/UTF-8">
<link rel="stylesheet" type="text/css" href="style/normalize.css">
<link rel="stylesheet" type="text/css" href="style/stile.css">
<link rel="stylesheet" type="text/css" href="style/navbar.css">
<link rel="stylesheet" type="text/css" href="style/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="style/jcarousel.css">
<link rel="shortcut icon" href="img/logo.png">
<script type="text/javascript" src="ajax/libs/jquery/3.3.1/jquery-3.3.1.js" ></script>
<script type="text/javascript" src="ajax/libs/jquery-ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="scripts/js/shared_site.js"></script>
<script type="text/javascript" src="scripts/js/init.js"></script>
<script type='text/javascript'>
    var loggedIn = <?php
                if( isset( $_SESSION['user_login'] ) ) echo "true";
                else echo "false";
    ?>;
</script>
<script type="text/javascript" src="scripts/navbar.js"></script>