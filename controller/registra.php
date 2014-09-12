<?php

/**
 * Controller that manages registration procedure
 *
 * @uses view
 * @uses model/user_manager.php
 */
require_once('model/user_manager.php');

class registra extends controller {

    /**
     * Costruttore.
     *
     * In base al metodo richiesto, chiama l'apposito metodo sul modello del commento.
     *
     * @param string|null optional $method nick dell'utente [solo per l'attivazione]
     * @param string|null optional $param chiave di attivazione [solo per l'attivazione]
     */
    function __construct($method = null, $param = null) {

        $this->set_db();
        $this->manage_session(0);

        if (isset($method) && isset($param)) {
            if ($method == 'attiva_admin') {
                $this->attiva_admin($param);
            } else {
                $this->attiva($method, $param);
            }
            die();
        }

        $this->registra();
    }

    /**
     * Funzione che registra un utente in base ai dati inviati via *post*
     *
     * Effettua la validazione dei campi contenuti in $_POST e registra
     *
     * @uses $_POST
     * @uses model/user_manager.php
     */
    function registra() {
        if (!isset($_POST['nick']) && !isset($_POST['pass']) && !isset($_POST['email'])) {
            $this->set_view('utenti', 'registra');
            $this->view->set_js('form.js.php');
            $this->view->render();
            die();
        }

        if (!regexp::nick($_POST['nick']) || !regexp::pass($_POST['pass']) || !regexp::email($_POST['email'])) {
            $this->set_view('errore');
            $this->view->set_message('campi non validi');
            $this->view->render();
            die();
        }

        $umanager = new user_manager($this->db);
        $r = $umanager->add_user($_POST['nick'], $_POST['email'], $_POST['pass']);
        $link = $r['link'];
        $id_nuovo = $r['last_id'];
        if ($link == false) {
            $this->set_view('errore');
            $this->view->set_message("Nome utente o email gi&agrave; esistenti");
            $this->view->render();
            die();
        }

        //  manda la notifica a un admin
        $admin_id = $umanager->get_admin();
        print_r($admin_id);
        $u = new user($this->db, $admin_id);
        $u->add_notifica('utente-aggiunto', $id_nuovo);



        $this->set_view('utenti', 'registrato');
        $this->view->set_message($link);
        $this->view->render();
        die();
    }

    /**
     * Attiva un utente.
     *
     * @param string nick dell'utente [solo per l'attivazione]
     * @param string chiave di attivazione [solo per l'attivazione]
     */
    function attiva($nick, $code) {
        $nick = urldecode($nick);
        $code = urldecode($code);
        if (!regexp::nick($nick)) {
            die('nick non valido');
        }
        $umanager = new user_manager($this->db);
        $response = $umanager->activate($nick, $code);

        if ($response) {
            $this->set_view('messaggio');
            $this->view->set_message('Indirizzo email attivato. L&acute;uso delle aree riservate &egrave; concesso solo previa autorizzazione dell&acute;admin');
            $this->view->render();
            die();
        } else {
            $this->set_view('errore');
            $this->view->set_message('Si sono verificati errori');
            $this->view->render();
            die();
        }
    }

    function attiva_admin($param) {
        if (null == $param || !is_numeric($param)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->set_user($this->user);
            $this->view->render();
            die();
        }
        if ($this->user->get_type() < 1) {
            $this->set_view('errore');
            $this->view->set_message('non autorizzato');
            $this->view->set_user($this->user);
            $this->view->render();
            die();
        }

        $um = new user_manager($this->db);
        $um->admin_activate($param);
        $this->set_view('messaggio');
        $this->view->set_message('Utente attivato');
        $this->view->render();
        die();
    }

}
