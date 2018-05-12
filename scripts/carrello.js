function modificaIngredienti( element, id){

    updateCartElements( undefined, true );// salvo le modifiche prima di rimouvere il contenuto nel form.
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
        beforeSend: function(){
            // inizio loader
            var loader = createLoader(undefined, "loader");
            $( "#cart_form" ).find(".container").css( "display", "none" );
            $( loader ).insertBefore( $( "#cart_form" ).find(".container") );
        },
        success: function (response) 
        {
            $( $( "#cart_form" ).find( ".loader" )[0] ).remove();
            $( "#cart_form" ).find(".container").css( "display", "block" );
            // fine loader
            
            $("#cart_form").find( ".container" ).html( response );
            $("#cart_form").find( "#submit_changes" ).click( value, submit_changes );
            $("#cart_form").find( ".container" ).find(".editable-item").each( function( index, item ){
                        // alert(index + " "+ $(item).attr("value") )
//                 $(item).css("background-color", "blue");
                var params = { item: item };
                $( item ).find(".btn-add").each( function( index, btn){
                    $(btn).css("background-color", "yellowgreen");
                    $(btn).click( params, addIngrediente );
                });
                $( item ).find(".btn-remove").each( function( index, btn ){
                    $(btn).css("background-color", "crimson");
                    $(btn).click( params, removeIngrediente );
                });
            });
        }
    });
}

function submit_changes( event ){
    var values = {};
    values['id'] = event.data.id;
    values['index'] = event.data.index;
    values['correnti'] = new Array();
    $("#correnti").find(".editable-item").each( function( index, element ) {
        if( jQuery.isNumeric( $( element).val() ) ){
            values['correnti'].push( $( element).val() );
        }
    });
    
    $.ajax(
    {
        type: 'post',
        url: 'scripts/carrello.php',
        data:
        {
            action: "set_changes",
            value: JSON.stringify( values )
        },
        success: function (response) 
        {
            refreshCart( true );
        }
    }
    );
}

function addIngrediente( event ){
    var item = event.data.item;
    $( this ).removeClass("btn-add");
    $( this ).addClass("btn-remove");
    $( item ).appendTo("#correnti");
    
    $( this ).unbind( event );
    $( this ).click( { item: item }, removeIngrediente );
}

function removeIngrediente( event ){
    var item = event.data.item;
    $( this ).removeClass("btn-remove");
    $( this ).addClass("btn-add");
    $( item ).appendTo("#disponibili");
    
    $( this ).unbind( event );
    $( this ).click( { item: item }, addIngrediente );
}

function addToCart( element, id ){
    var value = { id:id };
    $.ajax(
    {
        type: 'post',
        url: 'scripts/carrello.php',
        data:
        {
            action: "add",
            value: JSON.stringify( value )
        },
        success: function (response) 
        {
            refreshCart( false );
        }
    });
}

function removeFromCart( element, id_elem ){
    var values = id_elem.split("_");
    var index = values[1];
    var value = { index: index };
    updateCartElements( undefined, true);
    $.ajax(
    {
        type: 'post',
        url: 'scripts/carrello.php',
        data:
        {
            action: "remove",
            value: JSON.stringify( value )
        },
        beforeSend: function(){
            // inizio loader
            var loader = createLoader(undefined, "loader");
            $( "#cart_form" ).find(".container").css( "display", "none" );
            $( loader ).insertBefore( $( "#cart_form" ).find(".container") );
        },
        success: function (response) 
        {
            $( $( "#cart_form" ).find( ".loader" )[0] ).remove();
            $( "#cart_form" ).find(".container").css( "display", "block" );
            // fine loader
            refreshCart( true );
        }
    });   
}
// questo è più un salva e aggiorna
function updateCart( element, id_elem, b_only_server){
    var values = id_elem.split("_");
    var index = values[1];
    var info = {};
    info['id'] = $(element).attr("value");
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
// questo è un aggiorna
function refreshCart( b_updateonly ){
    $.ajax(
    {
        type: 'post',
        url: 'forms/carrelloForm.php',
        data:
        {
        },
        beforeSend: function(){
            // inizio loader
            var loader = createLoader(undefined, "loader");
            $( "#cart_form" ).find(".container").css( "display", "none" );
            $( loader ).insertBefore( $( "#cart_form" ).find(".container") );
        },
        success: function (response) 
        {
            $( $( "#cart_form" ).find( ".loader" )[0] ).remove();
            $( "#cart_form" ).find(".container").css( "display", "block" );
            // fine loader
            updateCartContent( response, b_updateonly );
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
            updateCartElements( div, false );
        });
        $( div ).attr( "id", "cart_form" );
        $( div ).insertAfter( "#menu_filter" );
    }
    if( !(b_updateonly != undefined && b_updateonly == true) ){
            div.css( "display", "block" );
    }
}

function order(){
    updateCartElements( undefined, false );
    
    if( $( "#cart_form" ).find(".container").find(".product-item").length > 0 ){
        $.ajax(
        {
            type: 'post',
            url: 'scripts/carrello.php',
            data:
            {
                action: "intermission",
            },
            beforeSend: function(){
                // inizio loader
                var loader = createLoader(undefined, "loader");
                $( "#cart_form" ).find(".container").css( "display", "none" );
                $( loader ).insertBefore( $( "#cart_form" ).find(".container") );
            },
            success: function (response) 
            {
                $( "#cart_form" ).find( ".loader" ).remove();
                $( "#cart_form" ).find(".container").css( "display", "block" );
                // fine loader
                $( "#cart_form" ).find(".container").html( response );
                $( "#setTavolo").find("button").click( function( event ){
                    if( $( "#setTavolo").find("[name='tavolo']").val() > 0 ){
                        $.ajax(
                            {
                                type: 'post',
                                url: 'scripts/ordine.php',
                                data:
                                {
                                    action: "register",
                                    value: JSON.stringify( { tavolo: $( "#setTavolo").find("[name='tavolo']").val() } )
                                },
                                success: function (response) 
                                {
                                    refreshCart( true );
                                    alert( response );
                                }
                            }
                        );
                    }
                });
            }   
        });
    }
}

