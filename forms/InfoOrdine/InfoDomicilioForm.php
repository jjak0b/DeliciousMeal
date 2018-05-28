<script>
    $( "#datepicker" ).ready(function() {
    $( "#datepicker" ).datepicker(  {
        beforeShowDay: checkDateOrders,
        beforeShow:function(textbox, instance){
            $( "#ui-datepicker-div" ).insertAfter( $( "#datepicker" ).parent() );
        },
        onSelect: function( textbox, instance ){
            var date = $.datepicker
                    .formatDate("dd-mm-yy", $("#datepicker")
                        .datepicker( 'getDate' ) );
            $( document.forms[ "form_domicilio" ]["giorno"] ).val( date );
        },
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true
    });
    $('#datepicker').datepicker("setDate", new Date());
    $( "#datepicker" ).trigger("change");// genero l'evento manualmente
});

function checkDateOrders(date) {
    var giorniChiusura = new Array();
    giorniChiusura.push( 4 );// giovedì
    
    if ($.inArray(date.getDay(), giorniChiusura) != -1
            || date.getTime() < new Date().getTime() ) {
        return [false,"","Chiuso"];
    }
    else {
        return [true, "","Aperto"];
    }
}
$("#form_domicilio").submit(function( event ) {
    var value = {};
    var myvalues = $( this ).serializeArray();
    for( var i = 0; i < myvalues.length; i++ ){
        value[ myvalues[i]["name"] ] = myvalues[i]["value"];
        console.log( myvalues[i]["name"] + " = " + myvalues[i]["value"] );
    }
    $.ajax({
        type: $(this).attr("method"),
        url: $(this).attr("action"),
        data: {
            action: "register", 
            value: JSON.stringify( value )
        },
        success: function (response) 
        {
            alert( response );
            refreshCart( true );
        }
    });
    
    return false;
    }
); 
</script>

<form id="form_domicilio" action="scripts/ordine.php" method="post" >
    <div class="center">
        <div class="form-section"> 
            <label class="form-field">Citt&agrave;</label>
            <input class="form-field" type="text" name="citta" required placeholder="Inserisci la tua citt&agrave"  >
        </div>
        <div class="form-section"> 
            <label class="form-field">Indirizzo</label>
            <input class="form-field" type="text" name="indirizzo" required placeholder="Esempio: Via della Repubblica 3"  >
        </div>
        <div class="form-section">
            <label class="form-field">Comune</label>
            <input class="form-field" type="text" name="comune" required placeholder="Inserisci il comune del tuo indirizzo" >
        </div>
        <div class="form-section">
            <label class="form-field">Giorno di Consegna</label>
            <div id="datepicker" class="form-field">
                <input name="giorno" type="text" required placeholder="Seleziona Il giorno">
                <script>
                    $( document.forms["form_domicilio"]["giorno"]).on("keydown paste", function( e ){
                        e.preventDefault();
                    });
                </script>
            </div>
        </div>
        <div class="form-section">
            <label class="form-field">Ora di Consegna</label>
            <select name='ora' required>
                <?php
                    $orari = array();
                    $orari["mattina"] = array();
                    $orari["pomeriggio"] = array();
                    $orari["sera"] = array();
                    
                    // orario pre impostati su php così facilmente modificabili
                    $orari["mattina"][] = "10:00";
                    $orari["mattina"][] = "10:30";
                    $orari["mattina"][] = "11:00";
                    $orari["mattina"][] = "11:30";
                    $orari["mattina"][] = "12:00";
                    $orari["mattina"][] = "12:30";
                            
                    $orari["pomeriggio"][] = "13:00";
                    $orari["pomeriggio"][] = "13:30";
                    $orari["pomeriggio"][] = "14:00";
                    $orari["pomeriggio"][] = "14:30";
                    $orari["pomeriggio"][] = "15:00";
                    
                    $orari["sera"][] = "18:00";
                    $orari["sera"][] = "18:30";
                    $orari["sera"][] = "19:00";
                    $orari["sera"][] = "19:30";
                    $orari["sera"][] = "20:00";
                    $orari["sera"][] = "20:30";
                    $orari["sera"][] = "21:00";
                    $orari["sera"][] = "21:30";
                    $orari["sera"][] = "22:00";
                    $orari["sera"][] = "22:30";
                ?>
                <optgroup label='Mattina'>
                <?php
                foreach ($orari["mattina"] as $key => $value) {
                    echo "<option value=\"$value\">".$value."</option>";
                }
                ?>
                </optgroup>
                <optgroup label='Pomeriggio'>
                <?php
                foreach ($orari["pomeriggio"] as $key => $value) {
                    echo "<option value=\"$value\">".$value."</option>";
                }
                ?>
                </optgroup>
                <optgroup label='Sera'>
                <?php
                foreach ($orari["sera"] as $key => $value) {
                    echo "<option value=\"$value\">".$value."</option>";
                }
                ?>
                </optgroup>
            </select>
        </div>
        <button type="submit">Conferma Ordine</button>
    </div>
</form>