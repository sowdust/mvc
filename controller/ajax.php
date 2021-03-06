<?php

/**
 * @uses view/view.php
 * @uses model/database.php
 * @uses model/ricerca.php
 */
require_once('model/ricerca.php');

/** Class used to receive and manage ajax requests */
class ajax extends controller {

    /**
     * Constructor.
     *
     * Calls the correct method based on the input params with which
     * it is called
     *
     * @param string|null $method
     * @param string|null $param
     */
    function __construct($method = null, $param = null) {

        $this->set_db();

        switch ($method) {
            case 'nick':
                $this->nick($param);
                break;
            case 'nick_unico':
                $this->nick_unico($param);
                break;
            case 'email':
                $this->email($param);
                break;
            case 'pass':
            case 'password':
                $this->password($param);
                break;
            case 'testo':
                $this->testo($para);
                break;
            case 'ricerca-campi':
                $this->ricerca_campi($param);
                break;
            case 'is-tabella':
                $this->is_tabella($param);
                break;
            case 'stato':
                $this->stato($param);
                break;
            case 'rimuovi-notifica':
                $this->rimuovi_notifica($param);
                break;
            case 'get-commenti':
                $this->get_commenti($param);
                break;
            default:
                echo 'ramo default';
                break;
        }
    }

    /**
     * Prints all comments children of given one.
     *
     * @param int $id
     * @return void
     * @uses model/commento.php
     * @uses commento::get_children()
     */
    function get_commenti($id) {
        $this->manage_session(1);

        require_once('model/commento.php');
        $commento = new commento($this->db, $id);
        $o = '';
        foreach ($commento->get_children() as $id_com) {
            $c = new view('commenti', 'vedi');
            $c->set_message($id_com);
            $c->set_db($this->db);
            $c->set_user($this->user);
            $c->render(false);
        }
        echo $o;
    }

    /**
     * Removes given notification
     *
     * @param int $id
     * @return void
     * @uses notifica::rimuovi()
     * @uses model/notifica.php
     */
    function rimuovi_notifica($id) {
        require_once('model/notifica.php');

        $notifica = new notifica($this->db, $id);
        $notifica->rimuovi();
        echo $id;
    }

    /**
     * Checks if given is a valid db table.
     *
     * @param  string
     * @return void
     * @uses ricerca::get_tabelle()
     * @uses model/ricerca.php
     */
    function is_tabella($tabella) {
        if (in_array($tabella, ricerca::get_tabelle())) {
            echo 'OK';
        } else {
            echo 'Selezionare una tabella';
        }
    }

    /**
     * Prints fields of given table.
     *
     * @param string
     * @return void
     * @uses model/ricerca.php
     * @uses ricerca::get_campi()
     */
    function ricerca_campi($tabella) {
        require_once('model/ricerca.php');
        if ('' == $tabella) {
            echo '<span class="errore">Tabella non trovata</span>';
            return;
        }

        $campi = ricerca::get_campi($tabella);
        foreach ($campi as $_) {
            echo '<input name="param_' . $_ . '" type="text"  value="" class="ricerca" placeholder="' . $_ . '" />' . "\n";
        }
    }

    /**
     * Prints result of nick validation.
     *
     * @param string
     * @return void
     * @uses common/regexp.php
     * @uses regexp::nick
     */
    function nick($nick) {
        if (null == $nick || !regexp::nick($nick)) {
            echo 'lettere, numeri, \'-\', \'_\' da 3 a 16';
        } else {
            echo 'OK';
        }
    }

    /**
     * Prints result of status validation.
     *
     * @param string
     * @return void
     * @uses common/regexp.php
     * @uses regexp::stato
     */
    function stato($stato) {
        if (null == $stato || !regexp::stato($stato)) {
            echo 'Stato non valido';
        } else {
            echo 'OK';
        }
    }

    /**
     * Prints result of unicity of nickname.
     *
     * @param string
     * @return void
     * @uses model/user_manager.php
     * @uses common/regexp.php
     */
    function nick_unico($nick) {
        require_once('model/user_manager.php');
        $manager = new user_manager($this->db);
        if (null == $nick || !regexp::nick($nick)) {
            echo 'lettere, numeri, \'-\', \'_\' da 3 a 16';
        }
        if ($manager->count_users("nick = \"" . $nick . "\"") > 0) {
            echo 'Nome utente gi&agrave; esistente';
        } else {
            echo 'OK';
        }
    }

    /**
     * Prints result of email validation.
     *
     * @param string
     * @return void
     * @uses common/regexp.php
     * @uses regexp::email
     */
    function email($email) {
        if (null == $email || !regexp::email($email)) {
            echo 'Indirizzo email non valido';
        } else {
            echo 'OK';
        }
    }

    /**
     * Prints result of pass validation.
     *
     * @param string
     * @return void
     * @uses common/regexp.php
     * @uses regexp::password
     */
    function password($password) {
        if (null == $password || !regexp::password($password)) {
            echo 'Password non valida. Da 3 a 255 caratteri';
        } else {
            echo 'OK';
        }
    }

    /**
     * Prints result of text validation.
     *
     * @param string
     * @return void
     * @uses common/regexp.php
     * @uses regexp::testo
     */
    function testo($testo) {
        if (!regexp::testo($testo)) {
            echo 'Testo non valido.';
        } else {
            echo 'OK';
        }
    }

}
