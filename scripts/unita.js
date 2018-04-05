// $("#assign_unita").click( assign_unita );
$("#users").change( get_unita );
$( "#users" ).on('updatedlist', get_unita  );
// $( "#users" ).on('DOMSubtreeModified', get_unita );


function assign_unita( event ){

    var value = $('#unita').find('option:selected').val();
    var value2 = $('#users').find('option:selected').val();
    
    var values =  {user: value2, unita: value };
    $.ajax(
    {
        type: 'post',
        url: 'scripts/unita.php',
        data:
        {
            action: "assign",
            value: JSON.stringify( values )

        },
        success: function (response)
        {
        }
    } );
    
    get_unita();
}

// non usata
function del_unita( event ){
    
    var value = $('#unita').find('option:selected').val();
    
    $.ajax(
    {
            type: 'post',
            url: 'scripts/unita.php',
            data:
            {
                action: "delete",
                value: value
            },
            success: function (response)
            {
            }
    } );
    get_unita();
}

function get_unita(){
    $.ajax(
    {
        type: 'post',
        url: 'scripts/unita.php',
        data:
        {
        },
        success: function (response) 
        {
            // alert( "get_unita: " + response );
            $('#unita').html( response );
        }
    } );
    
    var value = $('#users').find('option:selected').val();
    $.ajax(
    {
        type: 'post',
        url: 'scripts/unita.php',
        data:
        {
            action: "get_user_unita",
            value: value
        },
        success: function (response) 
        {
            // alert( "get_user_unita with id " + value + " : " + response );
            $('#unita_assigned').html( response );
            $("#assign_unita").prop("disabled", $('#unita_assigned').find('option:selected').val() == undefined);
            $("#assign_unita").prop("disabled", $('#unita_assigned').find('option:selected').val() == undefined);
            $('#unita_assigned').trigger("updatedlist");
        }
    } );
}
