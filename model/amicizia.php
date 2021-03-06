<?php

class amicizia {

    private $id_1;
    private $id_2;
    private $db;
    private $stato;

    public function __construct($db, $id_1, $id_2) {
        $this->db = $db->mysqli;
        $this->id_1 = $id_1;
        $this->id_2 = $id_2;
    }

    public function is_pending() {
        $q = $this->db->prepare('SELECT COUNT(*) FROM richieste WHERE id_from = (?) AND id_to = (?) ');
        $q->bind_param('ii', $this->id_2, $this->id_1);
        $q->execute() or die();
        $n = NULL;
        $q->bind_result($n);
        $q->fetch();
        $q->close();
        unset($q);
        $q = $this->db->prepare('SELECT COUNT(*) FROM richieste WHERE id_from = (?) AND id_to = (?) ');
        $q->bind_param('ii', $this->id_1, $this->id_2);
        $q->execute() or die();
        $m = NULL;
        $q->bind_result($m);
        $q->fetch();
        $q->close();

        return( ($n + $m) > 0 );
    }

    public function check() {
        $q = $this->db->prepare('SELECT COUNT(*) FROM amicizie WHERE utente_1 = (?) AND utente_2 = (?) ');
        if ($this->id_1 < $this->id_2) {
            $q->bind_param('ii', $this->id_1, $this->id_2);
        } else {
            $q->bind_param('ii', $this->id_2, $this->id_1);
        }
        $q->execute() or die();
        $n = NULL;
        $q->bind_result($n);
        $q->fetch();
        $q->close();

        return( 1 == $n );
    }

    public function richiedi() {
        if ($this->check()) {
            die('amicizia esistente');
        }
        if ($this->is_pending()) {
            die('richiesta gi&agrave; inviata');
        }
        $q = $this->db->prepare('INSERT INTO richieste (id_from,id_to,data) VALUES ((?),(?),now())');
        $q->bind_param('ii', $this->id_1, $this->id_2);
        $q->execute() or die();
        $q->close();
    }

    public function nega() {
        if (!$this->is_pending()) {
            die('non ti e stata richiesta');
        }
        $q = $this->db->prepare('DELETE FROM richieste WHERE id_from = (?) AND id_to = (?)');
        $q->bind_param('ii', $this->id_2, $this->id_1);
        $q->execute() or die();
        $q->close();
    }

    public function accetta() {
        if ($this->check()) {
            die('amicizia esistente');
        }
        if (!$this->is_pending()) {
            die('non esiste');
        }
        // controlliamo che sia dest e non mittente (altrimenti uno le puo confermare da solo)
        $q = $this->db->prepare('SELECT COUNT(*) FROM richieste WHERE id_from = (?) AND id_to = (?) ');
        $q->bind_param('ii', $this->id_2, $this->id_1);
        $q->execute() or die();
        $n = NULL;
        $q->bind_result($n);
        $q->fetch();
        $q->close();
        unset($q);
        if ($n < 1) {
            die('non ti ha chiesto l amicizia');
        }
        // inseriamo amicizia
        $q = $this->db->prepare('INSERT INTO amicizie (utente_1,utente_2,data) VALUES ( (?),(?),now())');
        if ($this->id_1 < $this->id_2) {
            $q->bind_param('ii', $this->id_1, $this->id_2);
        } else {
            $q->bind_param('ii', $this->id_2, $this->id_1);
        }
        $q->execute() or die();
        $q->close();
        unset($q);
        $q = $this->db->prepare('DELETE FROM richieste WHERE id_from = (?) AND id_to = (?)');
        $q->bind_param('ii', $this->id_2, $this->id_1);
        $q->execute() or die();
        $q->close();
    }

    public function rimuovi() {
        if (!$this->check()) {
            die('amicizia inesistente');
        }
        $q = $this->db->prepare('DELETE FROM amicizie WHERE utente_1=(?) AND utente_2 = (?)');
        if ($this->id_1 < $this->id_2) {
            $q->bind_param('ii', $this->id_1, $this->id_2);
        } else {
            $q->bind_param('ii', $this->id_2, $this->id_1);
        }
        $q->execute() or die();
        $q->close();
    }

}
