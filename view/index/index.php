<div class="cover-container">
    <div class="jumbotron">
        <h1>Benvenuto, <?php
            if (isset($this->user) && $this->user->get_type() >= 0) {
                echo $this->user->get_info()['nick'];
            } else {
                echo 'Anonimo';
            }
            ?> !</h1>
        <p>Questo &egrave; il progetto finale del corso di Tecnologie Web.</p>
        <p>Ci si pu&ograve; registrare come nuovi utenti oppure usare uno degli account gi&agrave; creati.<br />
            Ogni account ha come password <i><b>pass</b></i>.<br />
            I seguenti account (nome utente : password) sono stati "riempiti" in modo da essere utli nella dimostrazione di uso da parte di un utente normale e un amministratore (rispettivamente).

        <pre>mat : pass
admin : pass</pre>
        <p>
            Una volta effettuato il login, tramite il menu <i>Area personale</i> &egrave; possibile aggiungere contenuti sul proprio profilo e/o fare dei "check in".
        </p>

        <p>
            Dalla sezione <i>Luoghi</i> si ha il riepilogo di tutti i luoghi in cui gli utenti hanno fatto un check-in, raggruppati gerarchicamente in base a stato, provincia, citt&agrave;.<br />
            La cronologia di un singolo utente &egrave; raggiungibile a partire dalla sua pagina personale.

        </p>

        <p>
            Dalla sezione <i>Archivio</i> &egrave; possibile fare una ricerca nelle principali tabelle del database utilizzando semplici espressioni regolari
        </p>

        <p>
            Tutti i contenuti (profili, luoghi, stati, commenti stessi) sono commentabili. Una volta caricati, i contenuti sono visibili solo dagli amici del creatore.
            Ogni volta che un utente aggiunge un luogo o un commento, una notifica avverte tutti i suoi amici.
        </p>
    </div>
</div>