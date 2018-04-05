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
        success: function (response) 
        {
            // alert( "get_ruoli "+ JSON.stringify( values ) +" : " + response );
            $(".menu-list").html( response );
        }
    } );   
}