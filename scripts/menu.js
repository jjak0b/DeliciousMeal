$( document ).ready( get_pietanze );
$("#categoria").change( get_pietanze );
$('#filter').keyup( get_pietanze );
function get_pietanze(){
    var c = $('#categoria').find('option:selected').val();
    var filter = $('#filter').val();
    
    $.ajax(
    {
        type: 'get',
        url: 'scripts/menu.php',
        data:
        {
            cat: c,
            filter: filter
        },
        beforeSend: function(){
            // inizio loader
            var loader = createLoader(undefined, "loader");
            $( ".menu-list" ).css( "display", "none" );
            $( loader ).insertBefore( ".menu-list" );
        },
        success: function (response) 
        {
            $( ".menu-list" ).closest( ".container" ).find( ".loader" ).remove();
            $( ".menu-list" ).css( "display", "block" );
            // fine loader
            // alert( "get_ruoli "+ JSON.stringify( values ) +" : " + response );
            $(".menu-list").html( response );
        }
    } );   
}