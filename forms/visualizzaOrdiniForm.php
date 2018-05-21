<?php
    include_once('../config.php' );
    include_once('../scripts/utility.php' );
    include_once('../scripts/shared_site.php' );
    
    if( !isset( $connection ) ){
        $connection = mysqli_connect(HOST, USER, PASSWORD, DB_NAME );
    }

    // Check connection
    if ( mysqli_connect_errno() )
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    $value;
    if( isset( $_POST['value'] ) ){
        $value = json_decode($_POST['value'], true);
    }
?>
<div>
    <div id="filter_order">
        <input type="text" id="datepicker">
    </div>
    <div id="ordini_locale">
    </div>
    <div id="ordini_domicilio">
    </div>
    <script src="scripts/visualizzaOrdini.js"></script>
</div>