<?php

/**
 * Controller che gestisce le view e le azioni sugli utenti
 *
 * @uses model/user.php
 * @uses model/user_manager.php
 * @uses model/amicizia.php
 * @uses common/common.php
 * @uses model/user.php
 * @uses common/regexp.php
 */
require_once('model/user.php');
require_once('model/user_manager.php');
require_once('model/amicizia.php');
require_once('common/common.php');

/**
 * Controller che gestisce view e azioni di utenti
 */
class utenti extends controller {

    /**
     * Costruttore.
     *
     * @param string|null optional $method
     * @param string|null optional $param
     */
    function __construct($method = null, $param = null) {
        $this->set_db();
        $this->manage_session(1);

        switch ($method) {
            case 'vedi':
                $this->vedi($param);
                die();
                break;
            case 'rimuovi':
                $this->rimuovi($param);
                die();
                break;
            case 'modifica':
                $this->modifica($param);
                die();
            case 'cronologia':
                $this->cronologia($param);
                die();
            default:
                $this->lista();
                die();
                break;
        }
        // nel dubbio
        die();
    }

    /**
     * Modifica un utente con info via post.
     *
     * @uses model/user.php
     * @uses $_POST
     * @uses $_FORMATI_IMMAGINI
     *
     * @param int $id
     */
    function modifica($id) {
        global $_FORMATI_IMMAGINI;

        $id = ( null == $id ) ? $this->user->get_id() : $id;

        if ($this->user->get_id() != $id && $this->user->get_type() < 1) {
            $this->set_view('errore');
            $this->view->set_message('Non autorizzato');
            $this->view->render();
            die();
        }

        $utente = new user($this->db, $id);

        if (!isset($_POST['modifica-invia'])) {
            $this->set_view('utenti', 'modifica');
            $this->view->set_model($utente);
            $this->view->set_user($this->user);
            $this->view->set_js('form.js.php');
            $this->view->render();
            die();
        }

        if (!regexp::email($_POST['email'])) {
            $this->set_view('errore');
            $this->view->set_message('email non valida');
            $this->view->render();
            die();
        }

        //	controllo password

        if (( (strcmp(md5(trim($_POST['pass'])), trim($utente->get_info()['pass_hash'])) ) != 0 ) && ( $this->user->get_type() < 1)) {
            $this->set_view('errore');
            $this->view->set_message('Password non valida');
            $this->view->render();
            die();
        }

        //	caricamento foto

        if (!empty($_FILES['foto']) && pathinfo($_FILES["foto"]["name"])['filename'] != '') {
            $info = pathinfo($_FILES["foto"]["name"]);
            $estensione = strtolower($info["extension"]);
            if (!in_array($estensione, $_FORMATI_IMMAGINI)) {
                $this->set_view('errore');
                $this->view->set_message('Formato immagine non accettato');
                $this->view->render();
                die();
            }
            $rand = uniqid('', true);
            $nome_immagine = $rand . '.' . $estensione;

            if (!move_uploaded_file($_FILES['foto']['tmp_name'], config::serverpath . config::user_img . $nome_immagine)) {
                $this->set_view('errore');
                $this->view->set_message('Caricamento immagine fallito');
                $this->view->render();
                die();
            }
            $new_info['foto'] = $nome_immagine;
        } else {
            $new_info['foto'] = $utente->get_info()['foto'];
        }



        if (!empty($_POST['new_pass']) && strlen($_POST['new_pass']) > 0) {
            if ($_POST['new_pass'] != $_POST['new_pass2']) {
                $this->set_view('errore');
                $this->view->set_message('Le password non coincidono');
                $this->view->render();
                die();
            }
            if (!check_pass($_POST['new_pass'])) {
                $this->set_view('errore');
                $this->view->set_message('Password non valida');
                $this->view->render();
                die();
            }

            $new_info['pass_hash'] = md5($_POST['new_pass']);
        }

        $new_info['personale'] = $_POST['personale'];

        if ($utente->set_info($new_info)) {
            $this->set_view('messaggio');
            $this->view->set_message('Profilo aggiornato');
            $this->view->set_redirect(init::link('utenti', 'vedi', $this->user->get_id()));
            $this->view->render();
            die();
        } else {

            $this->set_view('errore');
            $this->view->set_message('Aggiornamento non riuscito');
            $this->view->render();
            die();
        }
        die();
    }

    /**
     * Carica la view con l'indice degli utenti.
     *
     * @uses model/user_manager.php
     */
    function lista() {
        $manager = new user_manager($this->db);
        $this->set_view('utenti');
        $this->view->set_model($manager);
        $this->view->set_user($this->user);
        $this->view->set_db($this->db);
        $this->view->render();
        die();
    }

    /**
     * Carica la view di un singolo utente.
     *
     * @param int $id id dell'utente
     * @uses model/utente.php
     */
    function vedi($id) {
        if (null == $id) {
            $id = $this->user->get_id();
        }
        if (!is_numeric($id)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->render();
            die();
        }
        $amicizia = new amicizia($this->db, $this->user->get_id(), $id);

        if ($amicizia->check() || $id == $this->user->get_id() || $this->user->get_type() == 1) {
            $user = new user($this->db, $id);
            $this->set_view('utenti', 'vedi');
            $this->view->set_user($this->user);
            $this->view->set_model($user);
            $this->view->set_db($this->db);
            $this->view->render();
            die();
        }
        if ($amicizia->is_pending()) {
            $user = new user($this->db, $id);
            $this->set_view('utenti', 'vedi_limitato');
            $this->view->set_user($this->user);
            $this->view->set_model($user);
            $this->view->set_db($this->db);
            $this->view->render();
            die();
        } else {
            $messaggio = 'Devi richiedere l&acute;amicizia per vedere un profilo';
        }
        $this->set_view('messaggio');
        $this->view->set_message($messaggio);
        $this->view->render();
        die();
    }

    /**
     * Rimuove un luogo.
     *
     * @param int $id id dell'utente
     * @uses model/user.php
     * @uses model/user_manager.php
     * @uses user_manager::remove_user(int)
     */
    function rimuovi($id) {
        if (null == $id || !is_numeric($id)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->render();
            die();
        }

        $utente = new user($this->db, $id);
        // controllo permessi
        if ($utente->get_id() == $this->user->get_id() || $this->user->get_type() == 1) {
            $manager = new user_manager($this->db);
            $manager->remove_user($id);

            $this->set_view('messaggio');
            $this->view->set_message('Account cancellato');
            $this->view->render();
            die();
        } else {

            $this->set_view('errore');
            $this->view->set_message('Non autorizzato');
            $this->view->render();
            die();
        }
    }

    function cronologia($id) {
        if (null == $id || !is_numeric($id)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->render();
            die();
        }

        $amico = new user($this->db, $id);

        $this->set_view('utenti', 'cronologia');
        $this->view->set_user($this->user);
        $this->view->set_model($amico);
        $this->view->set_db($this->db);
        $this->view->render();
    }

}
