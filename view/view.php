<?php

class view {

    protected $name;
    protected $message;
    protected $model;
    protected $user;
    protected $db;
    protected $js = array();
    protected $redirect;

    function __construct($name, $sub = null) {
        $sub = ( null == $sub ) ? 'index' : $sub;
        $this->name = $name;
        $this->filename = 'view/' . $name . '/' . $sub . '.php';
        if (!file_exists($this->filename))
            die('view inesistente');
    }

    function set_redirect($url) {
        $this->redirect = $url;
    }

    function set_js($js) {
        $this->js[] = $js;
    }

    function set_db($db) {
        $this->db = $db;
    }

    function set_model($m) {
        $this->model = $m;
    }

    function set_user($u) {
        $this->user = $u;
    }

    function set_message($m) {
        $this->message = $m;
    }

    function render($formatted = true) {
        if (!in_array('form.js.php', $this->js)) {
            $this->set_js('form.js.php');
        }
        if (!in_array('commenti.js.php', $this->js)) {
            $this->set_js('commenti.js.php');
        }
        if ($formatted) {
            require_once('view/include/head.php');
            require_once('view/include/header.php');
            //require_once('view/include/menu.php');
            require_once($this->filename);
            if (isset($this->redirect)) {
                require_once('view/messaggio/redirect.php');
            }
            require_once('view/include/footer.php');
        } else {
            require($this->filename);
        }
    }

}
