<div class="center">
    <section>
        <select id="users" name="users" style="min-width: 40%">
        </select>
        <input id="search_user" type="search" name="search_user" placeholder="Cerca un utente" style="width: 40%">
        
    </section>
    
        <table class="center" style="width: 80%">
                <tr>
                    <td style="width: 40%">
                        <label style="width: 100%">Unità assegnata</label>
                    </td>
                    <td style="width: 40%">
                        <label style="width: 100%">Scegli unità da assegnare</label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 40%">
                        <select id="unita_assigned" disabled style="width: 100%">
                        </select>
                    </td>
                    <td style="width: 40%">
                        <select id="unita" name="unita" style="width: 100%">
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 40%">
                        <label style="width: 100%">Ruolo assegnato</label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 40%">
                        <input id="ruolo_assigned" type="text" name="ruolo_assigned" placeholder="Nessun ruolo assegnato" disabled style="width: 60%;">
                    </td>
                    <td style="width: 40%">
                        <button id="delete_ruolo" style="width: 60%">Rimuovi ruolo</button>
                    </td>
                </tr>
                
                
                <tr>
                    <td style="width: 40%">
                        <input id="ruolo_toadd" type="text" name="ruolo_toadd" placeholder="Scrivi il nome del ruolo da assegnare" style="width: 60%;">
                    </td>
                    <td style="width: 40%">
                        <button id="add_ruolo" style="width: 60%">Imposta ruolo</button>
                    </td>
                </tr>
        </table>

    <script src="scripts/users.js"></script>
    <script src="scripts/unita.js"></script>
    <script src="scripts/ruoli.js"></script>
</div>
