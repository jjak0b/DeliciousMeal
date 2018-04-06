/*
// codice per aggiungere calendario in jquery-ui
$( "#datepicker" ).datepicker(  {
                                    dateFormat: 'dd/mm/yy',
                                    changeMonth: true,
                                    changeYear: true
                                });
 */
function Field( str_name, str_link )
{
    this.name = str_name;
    this.link = str_link;
    
    this.node = document.createElement( "li" );
    var textNode = document.createTextNode( str_name );
    var a = document.createElement("a");
    // a.setAttribute("class", "submenu");
    a.href = this.link;
    a.appendChild( textNode );
    // this.textNode.href = this.link;
    this.node.appendChild( a );
    
    this.getNode = function()
    {
        return this.node;
    };
}

function Menu( str_name )
{
    this.fields = new Array();
    this.name = str_name;
    
    this.node = document.createElement( "li" );
    this.node.classList.add("dropdown");

    this.list = document.createElement( "ul" );
    this.list.classList.add("dropdown-content");
   
    this.button = document.createElement("a");
    this.button.classList.add("dropbtn");
    
    var textNode = document.createTextNode( str_name );
    
    
    // a.setAttribute("class", "submenu");
    
    this.button.appendChild( textNode );
    this.node.appendChild( this.button );
    this.node.appendChild( this.list );
    
    this.addElement = function( menu_field )
    {
        if(menu_field instanceof Menu )
        {
            // menu_field.getNode().classList.add("dropdown-submenu");
        }
        else if( menu_field instanceof Field )
        {
            menu_field.getNode().classList.add("field");
            
        }
        this.list.appendChild( menu_field.getNode() );
        this.fields.push( menu_field );
    };
    
    this.getNode = function()
    {
        return this.node;
    };
}

function Navbar( str_id )
{
    this.menus = [];
    this.name = str_id;
    
    this.node = document.createElement( "ul" ); // class navbar
    this.node.classList.add("navbar");
    
    this.addMenu = function( menu ){
        this.node.appendChild( menu.getNode() );
        this.menus.push( menu );
    };

    this.getNode = function()
    {
        return this.node;
    };
};

function setup_menu( menudiv ){
    // genera questo cavolo di Menu!!!
    
    var menu = new Menu("Home"); 
    menu.button.href = "index.php";
   
    var menu1 = new Menu("Azienda");
            var field11 = new Field("Area Personale", "pages/azienda/AreaPersonale.php");
            var field12 = new Field("Struttura", "pages/azienda/struttura.php");
            var field13 = new Field("Sicurezza", "pages/azienda/sicurezza.php");
            var field14 = new Field("Storia", "pages/azienda/storia.php");
            
    menu1.addElement(field11);
    menu1.addElement(field12);
    menu1.addElement(field13);
    menu1.addElement(field14);
    
    
    var menu2 = new Menu("Prodotti");
        var sub_menu2 = new Menu("Menù");
            sub_menu2.button.href = "pages/prodotti.php";
            var fields = Array();
            fields[ fields.length ] = new Field("Antipasti", "pages/prodotti.php?c=1");
            fields[ fields.length ] = new Field("Primi", "pages/prodotti.php?c=2");
            fields[ fields.length ] = new Field("Secondi", "pages/prodotti.php?c=3");
            fields[ fields.length ] = new Field("Dolci", "pages/prodotti.php?c=4");
            fields[ fields.length ] = new Field("Bevande", "pages/prodotti.php?c=5");
        for ( var i = 0; i < fields.length; i++ )
        {
            sub_menu2.addElement(  fields[i] );
        }
        
    menu2.addElement( sub_menu2 );
    
    var menu3 = new Menu("Contatti");
    menu3.button.href = "pages/contatti.php";

    // var field31 = new Field("Chi siamo", "pages/contatti.php");
    // var field32 = new Field("Dove siamo", "pages/prodotti.php");
        
    
    

    
    var navbar = new Navbar("navbar");
    
    navbar.addMenu( menu );
    navbar.addMenu( menu1 );
    navbar.addMenu( menu2 );
    navbar.addMenu( menu3 );
    
    
    menudiv.appendChild( navbar.getNode() );
    return navbar;
}

function getAppPath() {
    var pathArray = location.pathname.split('/');
    var appPath = "/";
    for(var i=1; i<pathArray.length-1; i++) {
        appPath += pathArray[i] + "/";
    }
    return appPath;
}
    
window.onload = function () {
    var menudiv = document.getElementById("menu");
    var navbar = setup_menu( menudiv );
    
    
    
    // login 
    
    var menu_login = new Menu("Login"); 
    var login = menu_login.getNode();
    
    var login_session = sessionStorage.getItem("user_login");
    var div = document.createElement("div");
    div.classList.add("modal");
    div.setAttribute("id", "login_form");// solo il div nella navbar avrà questo id
    div.classList.add( "login_form" );
    menu_login.button.addEventListener( "click", function(event) {
            div.style.display= "block";
        }
    );
    // When the user clicks anywhere outside of the modal, close it
    div.addEventListener("click", function(event) {
            if (event.target == div) {
                div.style.display = "none";
            }
        }
    );

    $.ajax( {
                type: 'post',
                url: 'create_form_login.php',
                data: 
                {
                    action: "login"
                },
                success: function (response) 
                {
                    // la risposta è un oggetto JSON, --> oggetto sessione
                    if( response.charAt(0) == '{')
                    {
                        // menu_login.button = document.createElement("a");
                        childNodes = menu_login.button.childNodes;
                        childNodes[0].nodeValue = "Logout";
                        menu_login.button.href = "scripts/logout.php";
                        sessionStorage.setItem("user_login", JSON.parse( response ) );
                        menu_login.button.addEventListener("click", function(event) {
                                if (event.target == div) {
                                    sessionStorage.removeItem( "user_login" );
                                }
                            }
                        );
                    }
                    else{ // la risposta è un contenuto html
                        div.innerHTML = response; 
                        login.appendChild( div );
                    }
                    
                }
        }
    );
    
    navbar.addMenu( menu_login );
};

function registerSection( ele ){
    
    // var div = document.getElementById('login_form');
    var divs = document.getElementsByClassName("login_form");
    
    $.ajax( {
            type: 'post',
            url: 'create_form_login.php',
            data: 
            {
                action: "register"
            },
            success: function (response) 
            {
                var i = 0
                for( i = 0; i < divs.length; i++ ){
                    divs[i].innerHTML = response; 
                }
            }
        }
    );
}

function loginSection( ele ){
    // var div = document.getElementById('login_form');
    var divs = document.getElementsByClassName("login_form");
    
    $.ajax( {
            type: 'post',
            url: 'create_form_login.php',
            data: 
            {
                action: "login"
            },
            success: function (response) 
            {
                var i = 0
                for( i = 0; i < divs.length; i++ ){
                    divs[i].innerHTML = response; 
                }
            }
        }
    );
}