
$( document ).ready( get_users );
$( "#search_user" ).keyup( get_users );

function get_users()
{
    var filter = $( "#search_user" ).val();
    $.ajax(
    {
            type: 'post',
            url: 'scripts/users.php',
            data:
            {
                filter: filter
            },
            success: function (response) 
            {
                $( "#users" ).html( response );
                $( "#users" ).trigger( 'updatedlist' );
            }
    } );
}