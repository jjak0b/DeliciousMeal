<form class="modal-content animate" action="scripts/login.php" method="post">
    <div class="header_container">
      <span onclick="document.getElementById('login_form').style.display='none'" class="close" title="Chiudi">&times;</span>
    </div>

    <div class="container">
        <label><b>Email</b></label>
        <input type="email" placeholder="Inserisci la tua email" name="email" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Inserisci la tua Password" name="password" required>

        <!--<label>Ricorda credenziali
            <input type=\"checkbox\" checked=\"checked\" name=\"remember\" style=\"width: auto;\">
        </label>-->

        <button type="submit">Accedi</button>
    </div>

    <div class="container center">
        <label>Non hai un account?</label>
        <button onclick="registerSection(this)" type="button" style="width:50%;"<b>Registrati</b></button>
    </div>
</form>