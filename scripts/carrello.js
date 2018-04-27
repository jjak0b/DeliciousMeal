function modificaIngredienti( element, id){
    
    updateCartElements( undefined, true );
    var item = $("#"+id);
    var index = id.split("_")[1];
    var id_prod = item.attr("value");
    createModificaIngredientiForm( id_prod, index );
}

function createModificaIngredientiForm( id_prod, cart_index ){
    var value = { id: id_prod, index: cart_index };
    $.ajax(
    {
        type: 'post',
        url: 'forms/modificaIngredientiForm.php',
        data:
        {
            value: JSON.stringify( value )
        },
        success: function (response) 
        {
            $("#cart_form").find( ".container" ).html( response );
        }
    });
}

function addToCart( element, id ){
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

function updateCart( element, id_elem, b_only_server){
    var values = id_elem.split("_");
    var index = values[1];
    var info = {};
    info['id'] = $(element).val();
    info['qta'] = $(element).find( "[name='quantity']" ).val();
    info['note'] = $(element).find( "[name='note']" ).val();
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
            if( b_only_server == undefined || b_only_server == false ){
                updateCartContent( response, true);
            }
        }
    });   
}

function updateCartElements( cart, b_only_server){
    if( cart == undefined ){
        cart = $("#cart_form");
    }
    
    $(cart).find( ".product-item" ).each( function( index, element ){
        updateCart( element, $( element ).attr("id"), b_only_server );
    });
}

function updateCartContent( html, b_updateonly ){
   
    var div = undefined;
    if( $( "#cart_form" ).length > 0 ){
        div = $( "#cart_form" );
        div.find(".container").html( html );
    }
    else{
        div = createModalForm( html );
        $( div ).on('closed', function( event, element, id_elem){
            updateCartElements( div );
        });
        $( div ).attr( "id", "cart_form" );
        $( div ).insertAfter( "#menu_filter" );
    }
    if( !(b_updateonly != undefined && b_updateonly == true) ){
            div.css( "display", "block" );
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
    $(event.data.div).trigger("closed", [ event.data.div, $( event.data.div ).attr( "id" ) ] );
    $(event.data.div).css( "display", "none" );
    
}