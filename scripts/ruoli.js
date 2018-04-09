

$( "#add_ruolo" ).click( add_ruolo );
$( "#delete_ruolo" ).click( delete_ruolo );
// $( "#unita_assigned" ).on('DOMSubtreeModified', get_ruoli  );
$( "#unita_assigned" ).on('updatedlist', get_ruoli  );

function get_ruoli(){
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
                // alert( "get_ruoli "+ JSON.stringify( values ) +" : " + response );
                $("#ruolo_assigned").html( response );
            }
    } );   
}

function add_ruolo(){
    var user = $('#users').find('option:selected').val();
    var unita = $('#unita_assigned').find('option:selected').val();
    if( unita == undefined){
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
                get_ruoli();
                // alert( "add_ruolo "+ JSON.stringify( values ) +" : " + response );
            }
    } );
    
    // get_ruoli();
}

function delete_ruolo(){

    var user = $('#users').find('option:selected').val();
    var unita = $('#unita_assigned').find('option:selected').val();
    var ruolo = $('#ruolo_assigned').find('option:selected').val();
    var values = {user: user, unita: unita, ruolo: ruolo};
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
                get_ruoli();
                //alert( "delete_ruolo "+ JSON.stringify( values ) +" : " + response );
            }
    } );
}