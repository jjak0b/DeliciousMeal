var dateOrders;
$( "#datepicker" ).ready(function() {
    $( "#datepicker" ).datepicker(  {
        // aggiorna la lista delle date relative agli ordini
        beforeShow: updateDateOrders,
        // rende selezionabili solo le date con degli ordini
        beforeShowDay: checkDateOrders,
        // aggiorna la lista ordini
        onSelect: onDateSelected,
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true
    });
    $( "#datepicker" ).change( onDateChanged );
    $('#datepicker').datepicker("setDate", new Date());
    $( "#datepicker" ).trigger("change");// genero l'evento manualmente
});

function updateDateOrders( input, inst ){
    var ajaxObj = $.ajax(
    {
        type: 'post',
        url: 'scripts/ordine.php',
        // mi serve sia sincronizzata per recuperare
        // e salvare in una variabile globale i dati ricevuti
        async: false,
        data:
        {
            action: "get_dates_orders",
        }
    } );
    dateOrders = JSON.parse( ajaxObj.responseText );
}

function checkDateOrders(date) {
    var mydate = $.datepicker.formatDate("yy-mm-dd", date);
    if ($.inArray(mydate, dateOrders) != -1) {
        return [true, "","Disponibile"];
    }
    else {
        // alert( mydate +" non in "+ $( dateOrders).serialize() );
        return [false,"","Non disponibile"];
    }
}

function onDateSelected( dateText, inst ){
    onDateChanged( undefined );
}

function onDateChanged( event ){
    var value = {};
    value['date'] = $.datepicker.formatDate("yy-mm-dd", $("#datepicker").datepicker( 'getDate' ) );
    value = JSON.stringify(value);
    updateLists( value );
}

function updateLists( value ){
    // ordini locale
    $.ajax(
    {
        type: 'post',
        url: 'forms/visualizzaOrdiniForm/ordini_locale.php',
        data:
        {
            value: value
        },
        success: function (response) 
        {
            $("#ordini_locale").html( response );
            $("#ordini_locale")
                    .find("[name='section_prodotti']")
                    .find("select")
                    .each( function(index, element ){
                        $( element ).change( show_info );
                        if( element.show_info == undefined ){
                            element.show_info = show_info;
                        }
                        element.show_info();
                    });
        }
    });
    
    // ordini domicilio
    $.ajax(
    {
        type: 'post',
        url: 'forms/visualizzaOrdiniForm/ordini_domicilio.php',
        data:
        {
            value: value
        },
        success: function (response) 
        {
            $("#ordini_domicilio").html( response );
            $("#ordini_domicilio")
                    .find("[name='section_prodotti']")
                    .find("select")
                    .each( function(index, element ){
                        $( element ).change( show_info );
                        if( element.show_info == undefined ){
                            element.show_info = show_info;
                        }
                        element.show_info();
                    });
            // $("#workArea").find("[name='section_prodotti']").find("select")
        }
    });
}

function show_info(){
    var p_id;
    var list_aggiunti;
    var list_rimossi;
    var list_quantita;
    var list_note;
    
    // prendo il l'id del prodotto selezionato
    var section_modifiche = $( this )
            .closest( "details" ) // cerco l'elemento padre più conveniente
            .find("[name='section_modifiche']");// e cerco il figlio specifico
    p_id = $( this ).find(":selected").attr("value");
    
    var section_quantita = $( this )
            .closest( "details" ) // cerco l'elemento padre più conveniente
            .find("[name='section_quantita']");// e cerco il figlio specifico

    var section_note = $( this )
            .closest( "details" ) // cerco l'elemento padre più conveniente
            .find("[name='section_note']");// e cerco il figlio specifico
    
    // nascondo tutti gli elementi 
    $( section_modifiche )
            .find("ul[name='aggiunti']")
            .each( function( index, element){
                $(element).css("display", "none");
    });
    $( section_modifiche )
            .find("ul[name='rimossi']")
            .each( function( index, element){
                $(element).css("display", "none");
    });
    
    $( section_quantita )
            .find("li")
            .each( function( index, element){
                $(element).css("display", "none");
    });
    
    $( section_note )
            .find("textarea")
            .each( function( index, element){
                $(element).css("display", "none");
    });
    
    // cerco le ul di mio interesse aventi come valore l'id del prodotto
    $( section_modifiche )
            .find( "ul[name='aggiunti']" )
            .each( function( index_ul, ul ){
                if( $( ul ).attr( "value" ) == p_id ){
                    list_aggiunti = ul;
                }
            });
            
    $( section_modifiche )
            .find( "ul[name='rimossi']" )
            .each( function( index_ul, ul ){
                if( $( ul ).attr( "value" ) == p_id ){
                    list_rimossi = ul;
                }
            });
            
    $( section_quantita )
            .find( "li" )
            .each( function( index_li, li ){
                if( $( li ).attr( "value" ) == p_id ){
                    list_quantita = li;
                }
            });
    $( section_note )
            .find("textarea")
            .each( function( index, element ){
                if( $( element ).attr( "value" ) == p_id ){
                    list_note = element;
                }
            });
    
    // rendo visibili le ul
    $( list_aggiunti ).css( "display", "block" );
    $( list_rimossi ).css( "display", "block" );
    $( list_quantita ).css( "display", "block" );
    $( list_note ).css( "display", "block" );
}