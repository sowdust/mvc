<?php

/**
 * Controller that manages the maps
 *
 * @uses view/luoghi/*
 * @uses model/luogo.php
 * @uses model/luogo_manager.php
 * @uses common/regexp.php
 */
require_once('model/luogo.php');
require_once('model/luogo_manager.php');

/** Controller that offers the interface for maps  */
class luoghi extends controller {

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
            case 'utenti':
                $this->utenti($param);
            default:
                $this->lista();
                break;
        }
        // nel dubbio
        die();
    }

    /**
     * Aggiunge un luogo che arriva via post.
     *
     * @uses common/regexp.php
     * @uses model/luogo_manager.php
     */
    function aggiungi() {
        if (!isset($_POST['location'])) {
            $this->set_view('luoghi', 'aggiungi');
            $this->view->set_js('mappe.js');
            $this->view->render(); //false?
            die();
        }
        if (empty($_POST['citta']) || empty($_POST['stato']) || $_POST['stato'] == 'Stato' || $_POST['citta'] == 'Citta') {
            $this->set_view('errore');
            $this->view->set_message('citt&agrave; e stato sono obbligatori');
            $this->view->render();
            die();
        }
        if (!regexp::testo($_POST['citta']) || !regexp::testo($_POST['stato'])
        //|| (strlen($_POST['indirizzo'])>1 && !regexp::testo($_POST['indirizzo']))
        //|| (strlen($_POST['prov'])>1 && !regexp::testo($_POST['prov']))
        ) {
            $this->set_view('errore');
            $this->view->set_message('campi non validi');
            $this->view->render();
            die();
        }



        $lmanager = new luogo_manager($this->db);
        $id_entita = $tipo_entita = 0;
        $id_nuovo = $lmanager->add_luogo($_POST['location'], $this->user->get_id(), $id_entita, $tipo_entita, $_POST['indirizzo'], $_POST['citta'], $_POST['prov'], $_POST['stato']);
        $this->set_view('messaggio');
        $this->view->set_message('Luogo inserito con successo');
        $this->view->set_redirect(init::link('luoghi', 'vedi', $id_nuovo));

        //  manda la notifica agli amici
        $amici = $this->user->get_amici();
        foreach ($amici as $a) {
            $u = new user($this->db, $a);
            $u->add_notifica('luogo-aggiunto', $id_nuovo);
        }


        $this->view->render();
        die();
    }

    /**
     * Carica la view con l'indice dei luoghi.
     *
     * @uses model/luogo_manager.php
     */
    function lista() {
        $manager = new luogo_manager($this->db);
        $this->set_view('luoghi');
        $this->view->set_model($manager);
        $this->view->set_user($this->user);
        $this->view->set_db($this->db);
        $this->view->render();
        die();
    }

    /**
     * Carica la view di un singolo luogo.
     *
     * @param int $id id del luogo
     * @uses model/luogo.php
     */
    function vedi($id) {
        if (null == $id || !is_numeric($id)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->set_user($this->user);
            $this->view->render();
            die();
        }
        $luogo = new luogo($this->db, $id);
        $luogo_m = new luogo_manager($this->db);
        $utenti = $luogo_m->utenti($luogo);
        $this->set_view('luoghi', 'vedi');
        $this->view->set_db($this->db);
        $this->view->set_user($this->user);
        $this->view->set_model($luogo);
        $this->view->set_message($utenti);

        $this->view->render();
        die();
    }

    /**
     * Rimuove un luogo.
     *
     * @param int $id id del luogo
     * @uses model/luogo.php
     * @uses model/luogo_manager.php
     * @uses luogo_manager::remove_luogo(int)
     */
    function rimuovi($id) {
        if (null == $id || !is_numeric($id)) {
            $this->set_view('errore');
            $this->view->set_message('id non valido');
            $this->view->render();
            die();
        }

        $luogo = new luogo($this->db, $id);
        // controllo permessi
        if ($luogo->get_uid() == $this->user->get_id() || $this->user->get_type() == 1) {
            $manager = new luogo_manager($this->db);
            $manager->remove_luogo($id);

            $this->set_view('messaggio');
            $this->view->set_message('Luogo rimosso');
            $this->view->set_redirect($this->user->session->get_previous_page());
            $this->view->render();
            die();
        } else {

            $this->set_view('errore');
            $this->view->set_message('Non autorizzato');
            $this->view->render();
            die();
        }
    }

}
