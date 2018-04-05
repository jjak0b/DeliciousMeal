<!DOCTYPE html>
<?php
    include_once('../../config.php' );
?>
<html>
    <head>
        <title>Organigramma Aziendale</title>
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
                <p>
                    La qualità dei nostri piatti è quello che rende l'immagine della nostra azienda, proprio per questo gestiamo 
                    al meglio le Unità Organizzative che la compongono schematizzandole nel sequente schema aventi brevi descrizioni dei loro compiti:
                </p>
                <ul class="tree">
                    <li>
                        <a>Direttore</a>
                        <ul>
                            <li class="dropdown">
                                <a>Assistenza tecnica</a>
                                <div class="dropdown-content" id="tree-content">
                                    <p>
                                        Questa unità organizzativa si occupa sopprattuto di fornire assistenza informatica
                                        ai nostri dipendenti e ai nostri clienti che hanno riscontrato dei problemi ad effettuare degli ordini.<br>
                                        E' Proprio questa unità organizzativa a rendendere l'intera nostra infrastruttura di rete efficiente.
                                    </p>
                                </div>
                            </li>
                            <li>
                                <ul>
                                    <li class="dropdown">
                                        <a>Risorse umane</a>
                                        <div class="dropdown-content" id="tree-content">
                                            <p>
                                                Delicious Meal vuole il meglio per i nostri clienti, e per questo vengono assunti solo persone altamente qualificate
                                                ed efficienti nel loro lavoro; questi vengono scelti e stipendiati proprio da questa Unità Organizzativà
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <a>Marketing</a>
                                        <ul>
                                            <li class="dropdown">
                                                <a>Vendite</a>
                                                <div class="dropdown-content" id="tree-content">
                                                    <p>
                                                        Come facciamo a sapere i piatti o i gusti che preferite?<br>
                                                        L'ufficio vendite si occupa di studiare il mercato del nostro settore e quindi analizzare
                                                        i gusti dei possibili clienti, in base statistica o dovute a ricerche.
                                                    </p>
                                                </div>
                                            </li>
                                            <li class="dropdown">
                                                <a>Comunicazione</a>
                                                <div class="dropdown-content" id="tree-content">
                                                    <p>
                                                        Come siete venuti a conoscenza del nostro ristorante? Se non vi è stato consigliato da qualche vostra conoscenza,
                                                        lo è stato grazie alla presenza dei nostri annunci pubblicitari mirati per soddisfare le richieste dei clienti.<br>
                                                        Questo è il compito dell'ufficio comunicazione.
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a>acquisti</a>
                                        <div class="dropdown-content" id="tree-content">
                                            <p>
                                                Teniamo moltissimo alla qualità degli ingredienti utilizzati nei nostri piatti.<br>
                                                Per questo l'ufficio acquisti si occupa di contattare e catalogare i migliori fornitori
                                                che vendono gli ingredienti migliori sul mercato ad un prezzo conveniente per la nostra azienda e
                                                sopprattutto non troppo eccessivo per contenere i costi che dovranno affrontare i nostri consumatori.<br>
                                                Inoltre questa Unità Organizzativa, collabora in particolare con l'unità <b>Sicurezza igiene alimentare</b>.
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <a>produzione</a>
                                        <ul>
                                            <li class="dropdown">
                                                <a>Cucina</a>
                                                <div class="dropdown-content" id="tree-content">
                                                    <p>
                                                        Teniamo moltissimo alla sicurezza e alla qualità degli ingredienti utilizzati nei nostri prodotti<br>
                                                    L'igiene per noi è così importante che abbiamo abbiamo inserito nella nostra azienda un'unità organizzativa
                                                    che si occupi di garantire la provenienza delle materie prime dall'italia e le adatte procedure igieniche
                                                    </p>
                                                </div>
                                                <ul>
                                                    <li class="dropdown">
                                                        <a>Confezionamento</a>
                                                        <ul>
                                                            <li class="dropdown">
                                                                <a>Trasporto</a>
                                                                <div class="dropdown-content" id="tree-content">
                                                                    <p>
                                                                        Se vuoi gustare i nostri piatti nella tranquillità delle mura domestiche, Delicious Meal fa al caso tuo!<br>
                                                                        I prodotti ti arriveranno direttamente a casa grazie al nostro servizio da asporto estremamente rapido, 
                                                                        inoltre il pagamento verrà effettuato direttamente alla porta di casa tua.
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a>Servizio di sala</a>
                                                        <div class="dropdown-content" id="tree-content">
                                                            <p>
                                                                I nostri camerieri saranno lieti di accogliere la nostra clientela per servirla nei loro ordini.<br>
                                                                Una volta effettuato l'ordine si occuperanno di farlo sapere in cucina e nel breve tempo possibile vi serviranno i vostri piatti richiesti
                                                                direttamente al tavolo.
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a>Sicurezza igiene alimentare</a>
                                <div class="dropdown-content" id="tree-content">
                                    <p>
                                        Teniamo moltissimo alla sicurezza e alla qualità degli ingredienti utilizzati nei nostri prodotti<br>
                                    L'igiene per noi è così importante che abbiamo abbiamo inserito nella nostra azienda un'unità organizzativa
                                    che si occupi di garantire la provenienza delle materie prime dall'italia e le adatte procedure igienico-sanitarie
                                    </p>
                                </div>
                            </li>
                        </ul>

                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </body>
</html>