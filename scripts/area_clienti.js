$("#area_personale").ready( onLoad );

function onLoad()
{
    $( createSection( "I miei ordini", "forms/visualizzaOrdiniForm.php" ) ).insertBefore("#workArea");
}
