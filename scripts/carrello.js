function addToCart( element, id )
{
    $.ajax(
    {
        type: 'post',
        url: 'forms/carrelloForm.php',
        data:
        {
            add: id
        },
        success: function (response) 
        {
            updateCart( response );
        }
    });   
}

function updateCart( html ){
    if( $( "#cart_form" ).length > 0 ){
                var cart_div = $( "#cart_form" );
                cart_div.find(".container").html( html );
                cart_div.css( "display", "block" );
                
    }
    else{
        var div = createModalForm( html );
        $( div ).attr( "id", "cart_form" );
        $( div ).css( "display", "block" );
        $( div ).insertAfter( "#menu_filter" );
    }
}

function removeFromCart( element, id_elem ){
    var values = id_elem.split("_");
    var index = values[1];
    $.ajax(
    {
        type: 'post',
        url: 'forms/carrelloForm.php',
        data:
        {
            remove: index
        },
        success: function (response) 
        {
            updateCart( response );
        }
    });   
}
function createModalForm( content ){
    var div = $("<div>");
    var div_content = $("<div>");
    var close_btn = $("<span>");
    var container = $("<div>");
    
    
    $( div ).append( div_content );
    $( div_content ).append( close_btn )
    $( container ).insertAfter( close_btn );
    
    div.addClass( "modal" );
    div_content.addClass( "modal-content" );
    div_content.addClass( "animate" );
    
    close_btn.html( "&times;");
    close_btn.attr( "title", "Chiudi");
    close_btn.addClass("close");
    close_btn.click( {div: div}, function( event ){
        $(event.data.div).css( "display", "none");
    });
    container.addClass( "container" );
    container.html( content );
    return div;
}