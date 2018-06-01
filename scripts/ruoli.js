

$( "#add_ruolo" ).click( add_ruolo );
$( "#delete_ruolo" ).click( delete_ruolo );
// $( "#unita_assigned" ).on('DOMSubtreeModified', get_ruolo  );
$( "#unita_assigned" ).on('updatedlist', get_ruolo  );

function get_ruolo(){
    var user = $('#users').find('option:selected').val();
    var unita = $('#unita_assigned').find('option:selected').val();

    var values = {user: user, unita: unita };
    $.ajax(
    {
            type: 'post',
            url: 'scripts/ruoli.php',
            data:
            {
                action: "get",
                value: JSON.stringify( values )
            },
            success: function (response) 
            {
                $("#ruolo_assigned").val( response );
            }
    } );   
}

function add_ruolo(){
    var user = $('#users').find('option:selected').val();
    var unita = $('#unita_assigned').find('option:selected').val();
    if( unita == undefined || unita == "" ){
        unita = $('#unita').find('option:selected').val();
    }
    var ruolo = $('#ruolo_toadd').val();
    var values = {user: user, unita: unita, ruolo: ruolo};
    $.ajax(
    {
            type: 'post',
            url: 'scripts/ruoli.php',
            data:
            {
                action: "add",
                value: JSON.stringify( values )
            },
            success: function (response) 
            {
                get_unita();
            }
    } );
    
    // get_ruolo();
}

function delete_ruolo(){

    var user = $('#users').find('option:selected').val();
    var values = {user: user };
    $.ajax(
    {
        type: 'post',
        url: 'scripts/ruoli.php',
        data:
        {
            action: "delete",
            value: JSON.stringify( values )
        },
        success: function (response) 
        {
            get_unita();
        }
    } );
}