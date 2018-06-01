$("#area_personale").ready( onLoad );

function onLoad()
{
    $( createSection( "Assegna ruoli", "forms/assignUsersForm.php" ) ).insertBefore("#workArea");
    $( createSection( "Visualizza Ordini", "forms/visualizzaOrdiniForm.php" ) ).insertBefore("#workArea");
}
