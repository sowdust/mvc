<?php

/**
 *  File che definisce il controllore per gestire i commenti.
 *
 * @uses common/regexp.php
 * @uses model/user.php
 * @uses model/commento.php
 * @uses model/commento_manager.php
 * @uses model/database.php
 * @uses view/view.php
 */
require_once('common/regexp.php');
require_once('model/commento_manager.php');
require_once('model/commento.php');
require_once('model/user.php');

/** controller per i commenti */
class commenti extends controller {

    /**
     * Costruttore.
     *
     * In base al metodo richiesto, chiama l'apposito metodo sul modello del commento.
     *
     * @param string|null $method
     * @param string|null optional $param
     */
    function __construct($method = null, $param = null) {
        $this->set_db();
        $this->manage_session(1);

        switch ($method) {
            case 'aggiungi':
                $this->aggiungi();
                break;
            case 'vedi':
                $this->vedi($param);
                break;
            case 'rimuovi':
                $this->rimuovi($param);
                break;
            default:

                break;
        }
        // nel dubbio
        die();
    }

    /**
     * Chiama la view per visualizzare il commento.
     *
     * @param int $id id commento da visualizzare
     */
    function vedi($id) {
        if (null == $id || !is_numeric($id)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->render();
            die();
        }
        $this->set_view('commenti', 'vedi');
        $this->view->set_message($id);
        $this->view->set_db($this->db);
        $this->view->render();
        die();
    }

    /**
     * Aggiunge un commento.
     *
     * Se i dati via post sono stati spediti li aggiunge,
     * altrimenti carica la view che offre un modulo per aggiungere commenti
     *
     * @uses commento_manager::add_commento
     * @uses regexp
     */
    function aggiungi() {

        if (!isset($_POST['testo']) || (!isset($_POST['id_entita']) || !is_numeric($_POST['id_entita']) ) || !regexp::entita($_POST['tipo_entita']) || !regexp::testo($_POST['testo'])) {
            $this->set_view('errore');
            $this->view->set_message('campi non compilati o non validi');
            $this->view->render();
            die();
        }

        $cm = new commento_manager($this->db);

        $id_nuovo = $cm->add_commento($this->user->get_id(), $_POST['id_entita'], $_POST['tipo_entita'], trim($_POST['testo']));
        if ($id_nuovo > 0) {
            $this->set_view('messaggio');
            $this->view->set_message('commento inserito con successo');
            $this->view->set_redirect($this->user->session->get_previous_page());
            //  manda la notifica agli amici
            $amici = $this->user->get_amici();
            foreach ($amici as $a) {
                $u = new user($this->db, $a);
                $u->add_notifica('commento-aggiunto', $id_nuovo);
            }
            $this->view->render();
        } else {
            $this->set_view('errore');
            $this->view->set_message('errore durante inserimento commento');
            $this->view->set_redirect($this->user->session->get_previous_page());
            $this->view->render();
        }
        return;
    }

    /**
     * Rimuove un commento.
     *
     * Il commento e' rimosso solo se il richiedente e' l'utente proprietario
     * (autore) del commento, o admin.
     *
     * @param int
     */
    function rimuovi($id) {
        if (null == $id || !is_numeric($id)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->render();
            die();
        }

        $commento = new commento($this->db, $id);
        if ($commento->id_utente != $this->user->get_id() && $this->user->get_type() <= 0) {
            $this->set_view('errore');
            $this->view->set_message('Non autorizzato');
            $this->view->render();
            die();
        }

        $cm = new commento_manager($this->db);
        $cm->remove_commento($id);

        $this->set_view('messaggio');
        $this->view->set_message('commento rimosso');
        $this->view->set_redirect($this->user->session->get_previous_page());
        $this->view->render();
        die();
    }

}
