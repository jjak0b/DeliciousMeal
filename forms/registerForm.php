<form class="modal-content animate" action="scripts/register.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('login_form').style.display='none'" class="close" title="Chiudi">&times;</span>
    </div>

    <div class="container">
        <label><b>Nome</b></label>
        <input type="text" placeholder="Il tuo Nome" name="name" required>

        <label><b>Cognome</b></label>
        <input type="text" placeholder="Il tuo Cognome" name="surname" required>

        <label><b>Email</b></label>
        <input type="email" placeholder="Inserisci la tua email" name="email" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Inserisci la tua Password" name="password" required>

        <button type="submit">Registrati</button>
    </div>

    <div class="container center" >
        <label>Hai già un account?</label>
        <button type="button" onclick="loginSection(this)" style="width:50%;"<b>Accedi</b></button>
        
    </div>
</form>