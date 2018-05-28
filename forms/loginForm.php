<form action="scripts/login.php" method="post">
    <div class="center">
        <div class="form-section"> 
            <label class="form-field"><b>Email</b></label>
            <input class="form-field" type="email" name="email" required placeholder="Inserisci la tua email"  >
        </div>
        <div class="form-section">
            <label class="form-field"><b>Password</b></label>
            <input class="form-field" name="password" type="password" required placeholder="Inserisci la tua Password" >
        </div>

        <button type="submit">Accedi</button>
    </div>
    <div class="center">
        <div class="form-section">
            <label class="form-field">Non hai un account?</label>
            <button class="form-field" onclick="registerSection(this)" type="button" style="width:50%;"<b>Registrati</b></button>
        </div>
    </div>
</form>