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

function createLoader( text, id ){
    if( text == undefined ){
        text = "Caricamento in corso...";
    }
    var e_center = $("<div>");
    var e_loader = $( "<div>" );
    var e_text = $("<div>");

    $( e_center ).attr( "id", id );
    $( e_center ).addClass( "center" );
    $( e_center ).addClass( "loader");
    $( e_loader ).addClass("loading");
    $( e_loader ).addClass("center");
    $( e_text ).addClass("loading-text");
    $( e_text ).text( text );
    
    $( e_center ).append( e_loader );
    $( e_loader ).append( e_text );
    
    return e_center;
}