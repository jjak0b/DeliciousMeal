<form action="" method="post" class="center">
    <section>
        <select id="users" name="users" style="min-width: 40%">
        </select>
        <input id="search_user" type="search" name="search_user" placeholder="ricerca utente" style="width: 40%">
        
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
                        <label style="width: 100%">Ruoli assegnati</label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 40%">
                        <select id="ruolo_assigned" placeholder="Ruolo assegnato" style="width: 100%;" >
                        </select>
                    </td>
                    <td style="width: 40%">
                        <button id="delete_ruolo" style="width: 100%">Rimuovi ruolo</button>
                    </td>
                </tr>
                
                
                <tr>
                    <td style="width: 40%">
                        <input id="ruolo_toadd" type="text" name="ruolo_toadd" placeholder="nome ruolo" style="width: 100%">
                    </td>
                    <td style="width: 40%">
                        <button id="add_ruolo" style="width: 100%">Aggiugi ruolo</button>
                    </td>
                </tr>
        </table>

    <script src="scripts/users.js"></script>
    <script src="scripts/unita.js"></script>
    <script src="scripts/ruoli.js"></script>
</form>
