<?php

require_once('entita.php');

class commento extends entita {

    public $tipo_entita;
    protected $db;
    public $id;
    // si riferiscono al padre
    protected $id_entita_padre;
    protected $tipo_entita_padre;
    public $data;
    public $testo;
    public $id_utente;

    function __construct($db, $id) { //TODO forse da fare con dati entita' e non id commento
        $this->tipo_entita = 'commento';
        $this->db = ( 'database' == get_class($db) ) ? $db->mysqli : $db;
        $this->id = $id;
        $this->get_data_from_db();
    }

    function get_testo() {
        return $this->testo;
    }

    function get_data() {
        return $this->data;
    }

    function get_uid() {
        return $this->id_utente;
    }

    function get_data_from_db() {
        $q = $this->db->prepare('SELECT id_utente, id_entita, tipo_entita, date_format(data,"%d/%m/%Y") as data, testo FROM commenti WHERE id = (?)');
        $q->bind_param('i', $this->id);
        $q->execute() or die('er 42');
        $q->bind_result($this->id_utente, $this->id_entita, $this->tipo_entita, $this->data, $this->testo);
        $q->fetch();
        $q->close();
        unset($q);
    }

    function get_children() {
        $q = $this->db->prepare('SELECT id FROM commenti WHERE id_entita = (?) AND tipo_entita = "commento" order by data asc');
        $q->bind_param('i', $this->id);
        $t = null;
        $count = 0;
        $chil = array();
        $q->execute() or die('56');
        $q->bind_result($t);
        while ($q->fetch()) {
            $chil[$count++] = $t;
        }
        return $chil;
    }

    function stampa() {
        $o = '<div id="commento_' . $this->id . '" class="commento">'
                . 'Il ' . $this->data . ' ' . $this->id_utente . ' ha scritto:'
                . '<div id="contenuto_commento_' . $this->id . '">'
                . htmlentities($this->testo) . '<br />'
                //.'<a href="aggiungi_commento.php?id_entita='.$this->id.'&tipo_entita=commento">commenta</a>';
                . '<a href="#" onclick="comment_form(' . $this->id . ');return false;">Commenta</a>'
                . '</div>';
        $count = 0;

        if (sizeof($this->get_children())) {
            $o.=' | <a id="more_' . $this->id . '" title="Mostra gli altri commenti a questo" href="#"'
                    . '	onmouseover="get_commenti(' . $this->id . ');return false;">More</a>';
            $o.=' | <a id="less_' . $this->id . '" title="Nascondi gli altri commenti a questo" href="#"'
                    . '	onmouseover="less(' . $this->id . ');return false;">Less</a>';
        }
        $o.='<script type="text/javascript">window.showing[' . $this->id . ']=true;</script>';
        $o .= '</div>';

        return $o;
    }

}
