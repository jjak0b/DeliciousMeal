function addToCart( element, id )
{
    alert("adding: "+  id );
    $.ajax(
    {
        type: 'post',
        url: 'scripts/carrello.php',
        data:
        {
            add: id,
        },
        success: function (response) 
        {
            $("#menu_filter").add( response );
        }
    });   
}