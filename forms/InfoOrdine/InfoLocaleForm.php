<script>
    $("#form_locale").submit(function( event ) {
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
<form id="form_locale" action="scripts/ordine.php" method="post">
    <div class="center">
        <div class="form-section"> 
            <label class="form-field">Inserisci numero tavolo</label>
            <input class="form-field" required type="number" name="tavolo" min="1">
        </div> 
        <button>Conferma</button>
    </div>
</form>