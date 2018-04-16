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
            updateCartContent( response );
        }
    });
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
            updateCartContent( response );
        }
    });   
}

function updateCart( element, id_elem ){
    var values = id_elem.split("_");
    var index = values[1];
    var info = [];
    info['qta'] = $(element).find( "[name='quantity']" ).val();
    
    var value = { index: index, data: info };
    $.ajax(
    {
        type: 'post',
        url: 'scripts/carrello.php',
        data:
        {
            action: "update",
            value: JSON.stringify( value )
        },
        success: function (response) 
        {
            updateCartContent( response );
        }
    });   
}

function updateCartContent( html ){
    if( $( "#cart_form" ).length > 0 ){
        var cart_div = $( "#cart_form" );
        cart_div.find(".container").html( html );
        cart_div.css( "display", "block" );
    }
    else{
        var div = createModalForm( html );
        $( div ).on('closed', updateCart  );
        $( div ).attr( "id", "cart_form" );
        $( div ).css( "display", "block" );
        $( div ).insertAfter( "#menu_filter" );
    }
}

function createModalForm( content ){
    var div = $("<div>");
    var div_content = $("<div>");
    var div_header = $("<div>");
    var close_btn = $("<span>");
    var container = $("<div>");
    
    $( div ).append( div_content );
    $( div_content ).append( container);
    
    $( div_header ).append( close_btn );
    $( div_header ).insertBefore( container );
    
    div.addClass( "modal" );
    div_content.addClass( "modal-content" );
    div_content.addClass( "animate" );
    div_header.addClass( "header_container");
    // div_header.css( "padding-top", "0");
    // div_header.css( "padding-bottom", "0");
    // When the user clicks anywhere outside of the modal, close it
    div.click( {div: div}, function( event ){
            if ( $( event.target ).is( event.data.div) ){
                closeModalForm( event );
            }
        }
    );
    
    close_btn.html( "&times;");
    close_btn.attr( "title", "Chiudi");
    close_btn.addClass("close");
    close_btn.click( {div: div}, function( event ){
        closeModalForm( event );
    });
    
    container.addClass( "container" );
    container.html( content );
    return div;
}

function closeModalForm( event ){
    $(event.data.div).css( "display", "none");
    $(event.data.div).trigger("closed", { element: event.data.div, id: $( event.data.div ).attr( "id" ) } );
}