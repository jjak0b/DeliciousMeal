<script>
    $( function() {
      $( "#menu" ).menu();
    } );
</script>
<nav id="nav" role="navigation">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a><span>Azienda</span></a>
            <ul>
                <li>
                    <a href="pages/azienda/AreaPersonale.php">Area Personale</a>
                </li>
                <li>
                    <a href="pages/azienda/struttura.php">Struttura</a>
                </li>
                <li>
                    <a href="pages/azienda/sicurezza.php">Sicurezza</a>
                </li>
                <li>
                    <a href="pages/azienda/storia.php">Storia</a>
                </li>
            </ul>
        </li>
        <li>
            <a><span>Prodotti</span></a>
            <ul>
                <li>
                    <a href="pages/prodotti.php"><span>Menù</span></a>
                    <ul>
                        <li><a href="pages/prodotti.php?c=1">Antipasti</a></li>
                        <li><a href="pages/prodotti.php?c=2">Primi</a></li>
                        <li><a href="pages/prodotti.php?c=3">Secondi</a></li>
                        <li><a href="pages/prodotti.php?c=4">Dolci</a></li>
                        <li><a href="pages/prodotti.php?c=6">Pizze</a></li>
                        <li><a href="pages/prodotti.php?c=5">Bevande</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="pages/contatti.php">Contatti</a></li>
        <li><a id="login_button">Login</a></li>
    </ul>
</nav>