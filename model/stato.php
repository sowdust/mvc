<?php

require_once('entita.php');

class stato extends entita {

    protected $id;
    protected $tipo_entita;
    protected $db;
    protected $data;
    protected $valido;
    protected $stato;
    protected $uid;

    function __construct($db, $id) {
        $this->tipo_entita = 'stato';
        if (!is_numeric($id))
            die();
        $this->id = $id;
        $this->db = ( 'database' == get_class($db) ) ? $db->mysqli : $db;
        $this->update_info_from_db();
    }

    function get_testo() {
        return htmlentities($this->stato);
    }

    function get_data() {
        return $this->data;
    }

    function get_uid() {
        return $this->uid;
    }

    function update_info_from_db() {
        $q = $this->db->prepare("SELECT stato,date_format(data,'%d.%m.%Y'),valido,id_utente FROM stati WHERE id = (?) ORDER BY data DESC LIMIT 0,1");
        $q->bind_param('i', $this->id);
        $q->execute() or die('impossibile ottenere lo stato');
        $q->bind_result($this->stato, $this->data, $this->valido, $this->uid);
        $q->fetch();
        $q->close();
        unset($q);
    }

}
