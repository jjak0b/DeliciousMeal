$("#area_personale").ready( onLoad );

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

function onLoad()
{
    $( createSection( "Assegna ruoli", "forms/assignUsersForm.php" ) ).insertBefore("#workArea");
    $( createSection( "Visualizza Ordini", "forms/visualizzaOrdniForm.php" ) ).insertBefore("#workArea");
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
                // alert( "get_ruoli "+ JSON.stringify( values ) +" : " + response );
                $("#workArea").html( response );
            }
    } );
}
