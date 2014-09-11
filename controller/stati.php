<?php

/**
 * Controller that manages stati
 *
 * @uses view
 * @uses common/regexp.php
 */
require_once('model/stato.php');

/**
 * Controller che gestisce view e azioni di stati
 */
class stati extends controller {

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
            case 'aggiungi':
                $this->aggiungi();
                break;
            case 'rimuovi':
                $this->rimuovi($param);
                break;
            case 'vedi':
                $this->vedi($param);
            default:
                $this->lista();
                break;
        }
        // nel dubbio
        die();
    }

    /**
     * Aggiunge uno status che arriva via post.
     *
     * @uses regexp::stato
     * @uses $_POST
     */
    function aggiungi() {
        if (!isset($_POST['stato']) || !regexp::stato($_POST['stato'])) {
            $this->set_view('errore');
            $this->view->set_message('stato non valido');
            $this->view->render();
            die();
        }
        $this->user->add_stato($_POST['stato']);
        $redirect = (isset($_POST['redirect'])) ? $_POST['redirect'] : 'index.php';
        header("Location: " . $redirect);
    }

    /**
     * Rimuove uno status che arriva via post.
     *
     * @param int $param id dello stato
     */
    function rimuovi($param) {
        if (null == $param || !is_numeric($param)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->render();
            die();
        }
        $stato = new stato($this->db, $param);
        if ($stato->get_uid() != $this->user->get_id() && $this->user->get_type() < 1) {
            $this->set_view('errore');
            $this->view->set_message('non sei autorizzato');
            $this->view->render();
            die();
        }

        $this->user->remove_stato($param);
        $this->set_view('messaggio');
        $this->view->set_message('Stato eliminato con successo');
        $this->view->set_redirect($this->user->session->get_previous_page());
        $this->view->render();
        die();
    }

    /**
     * Carica la view per un singolo stato
     *
     * @param int $param id dello stato
     */
    function vedi($id) {
        if (null == $id || !is_numeric($id)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->set_user($this->user);
            $this->view->render();
            die();
        }

        $stato = new stato($this->db, $id);
        $this->set_view('stati', 'vedi');
        $this->view->set_db($this->db);
        $this->view->set_user($this->user);
        $this->view->set_model($stato);
        $this->view->render();
        die();
    }

    /**
     * @todo implementare la lista degli stati
     */
    function lista() {
        ;
    }

}
