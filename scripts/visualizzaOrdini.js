$("#workArea").find("[name='section_prodotti']").find("select").each( function(index, element ){
    element.show_info = show_info;
    element.show_info();
});
$("#workArea").find("[name='section_prodotti']").find("select").change( show_info );

$( "#datepicker" ).datepicker(  {
                                    dateFormat: 'dd/mm/yy',
                                    changeMonth: true,
                                    changeYear: true
                                });
function show_info(){
    var p_id;
    var list_aggiunti;
    var list_rimossi;
    
    // prendo il l'id del prodotto selezionato
    var section_modifiche = $( this )
            .closest( "details" ) // cerco l'elemento padre più conveniente
            .find("[name='section_modifiche']");// e cerco il figlio specifico
    p_id = $( this ).find(":selected").attr("value");
    
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
            
    // rendo visibili le ul
    $( list_aggiunti ).css( "display", "block" );
    $( list_rimossi ).css( "display", "block" );
}