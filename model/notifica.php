<?php

require_once('model/user.php');
require_once('model/luogo.php');
require_once('model/commento.php');

class notifica {

    private $id;
    private $id_utente;
    private $tipo;
    private $id_elemento;
    private $data;

    public function __construct($db, $id) {
        if (!is_numeric($id) || null == $id) {
            die();
        }
        $this->id = $id;
        $this->db = ( 'database' == get_class($db) ) ? $db->mysqli : $db;
        $this->update_info_from_db();
    }

    function rimuovi() {
        $q = $this->db->prepare("DELETE FROM notifiche WHERE id = (?)");
        $q->bind_param('i', $this->id);
        $q->execute();
        $q->close();
        unset($q);
    }

    function update_info_from_db() {
        $q = $this->db->prepare('SELECT id_utente,tipo,id_elemento,date_format(data,"%e/%m %H:%i") as data FROM notifiche WHERE id = (?) ORDER BY data DESC LIMIT 0,1');
        $q->bind_param('i', $this->id);
        $q->execute() or die('impossibile ottenere lo stato');
        $q->bind_result($this->id_utente, $this->tipo, $this->id_elemento, $this->data);
        $q->fetch();
        $q->close();
        unset($q);
    }

    public function testo() {
        $testo = $this->tipo;
        switch ($this->tipo) {
            case 'amicizia-richiesta':
                $user = new user($this->db, $this->id_elemento);
                $testo = 'Amicizia richiesta da '
                        . '<a class="noblock" href="' . init::link('utenti', 'vedi', $this->id_elemento) . '">' . $user->get_info()['nick'] . '</a><br />'
                        . '<a  class="noblock" onclick="rimuovi_notifica(' . $this->id . ');" href="' . init::link('amicizie', 'accetta', $this->id_elemento) . '">'
                        . '<button type="button" class="btn btn-xs btn-primary">Accetta</button> '
                        . '</a>'
                        . '<a  class="noblock" onclick="rimuovi_notifica(' . $this->id . ');" href="' . init::link('amicizie', 'nega', $this->id_elemento) . '">'
                        . '<button type="button" class="btn btn-xs btn-danger">Rifiuta</button>'
                        . '</a>';
                break;
            case 'amicizia-accettata':
                $user = new user($this->db, $this->id_elemento);
                $testo = 'Tu e <a class="noblock" href="' . init::link('utenti', 'vedi', $this->id_elemento) . '">'
                        . $user->get_info()['nick'] . '</a> siete amici. <a class="noblock" href=""  onclick="rimuovi_notifica(' . $this->id . ');">OK!</a>';
                break;
            case 'amicizia-rimossa':
                $testo = 'Uno dei tuoi amici ti ha eliminato dalla sua lista';
                break;
            case 'amicizia-negata':
                $user = new user($this->db, $this->id_elemento);
                $testo = $user->get_info()['nick'] . 'ha negato la tua richiesta di amicizia';
                $testo .= '<a class="noblock" href="' . 'index.php?' . explode('?', $_SERVER['REQUEST_URI'])[1] . '"  onclick="rimuovi_notifica(' . $this->id . ');return false;"> OK!</a>';
                break;
            case 'luogo-aggiunto':
                $luogo = new luogo($this->db, $this->id_elemento);
                $user = new user($this->db, $luogo->get_uid());
                $testo = $user->get_info()['nick'] . 'ha fatto un nuovo checkin a ';
                $testo .= '<a class="noblock" href="' . init::link('luoghi', 'vedi', $this->id_elemento) . '" onclick="rimuovi_notifica(' . $this->id . ');">' . $luogo->get_citta() . '</a>';

                break;
            case 'commento-aggiunto':
                $commento = new commento($this->db, $this->id_elemento);
                $user = new user($this->db, $commento->get_uid());
                $testo = 'Nuovo commento di <a class="noblock" href="' . init::link('commenti', 'vedi', $commento->get_uid()) . '">' . $user->get_info()['nick'] . '</a>: <small>';
                $testo .= '<a class="noblock" href="' . init::link('commenti', 'vedi', $this->id_elemento) . '" onclick="rimuovi_notifica(' . $this->id . ');">' . substr($commento->get_testo(), 0, 25) . '...</a></small>';

                break;
            case 'utente-aggiunto':
                $user = new user($this->db, $this->id_elemento);
                $testo = 'Attivazione account richiesta da '
                        . '<a class="noblock" href="' . init::link('utenti', 'vedi', $this->id_elemento) . '">' . $user->get_info()['nick'] . '</a><br />'
                        . '<a class="noblock" onclick="rimuovi_notifica(' . $this->id . ');" href="' . init::link('registra', 'attiva_admin', $this->id_elemento) . '">'
                        . '<button type="button" class="btn btn-xs btn-primary">Attiva</button> '
                        . '</a>'
                        . '<a class="noblock" onclick="rimuovi_notifica(' . $this->id . ');" href="">'
                        . '<button type="button" class="btn btn-xs btn-danger">Scarta</button> '
                        . '</a>';
                break;
            default:
                $testo = 'default';
                break;
        }
        return $testo;
    }

}
