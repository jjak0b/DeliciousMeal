<form action="scripts/register.php" method="post">
    <div class="center" >
        <div class="form-section">
            <label class="form-field"><b>Nome</b></label>
            <input class="form-field"type="text" placeholder="Il tuo Nome" name="name" required>
        </div>
        <div class="form-section">
            <label class="form-field"><b>Cognome</b></label>
            <input class="form-field" type="text" placeholder="Il tuo Cognome" name="surname" required>
        </div>
        <div class="form-section">
            <label class="form-field"><b>Email</b></label>
            <input class="form-field"type="email" placeholder="Inserisci la tua email" name="email" required>
        </div>
        <div class="form-section">
            <label class="form-field"><b>Password</b></label>
            <input class="form-field" type="password" placeholder="Inserisci la tua Password" name="password" required>
        </div>

        <button type="submit">Registrati</button>
    </div>
    <div class="center" >
        <label>Hai già un account?</label>
        <button type="button" onclick="loginSection(this)" style="width:50%;"<b>Accedi</b></button>
    </div>
</form>