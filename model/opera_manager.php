<?php

class opera_manager {

    private $opere;
    private $db;
    private $totale;

    public function lista_opere() {
        return $this->opere;
    }

    public function __construct($db) {
        $this->db = $db->mysqli;
        $this->refresh_opere();
    }

    private function refresh_opere($order_by = 'autore', $reverse = false) {
        if ($reverse) {
            $tq = 'SELECT id, autore, titolo, isbn FROM opere ORDER BY (?) DESC';
        } else {
            $tq = 'SELECT id, autore, titolo, isbn FROM opere ORDER BY (?) ASC';
        }
        $q = $this->db->prepare($tq);
        $q->bind_param('s', $order_by);
        $q->execute() or die();
        $autore = $titolo = $id = $isbn = null;
        $q->bind_result($id, $autore, $titolo, $isbn);
        $count = 0;
        while ($q->fetch()) {
            $this->opere[$count]['id'] = $id;
            $this->opere[$count]['autore'] = $autore;
            $this->opere[$count]['titolo'] = $titolo;
            $this->opere[$count]['isbn'] = $isbn;
            ++$count;
        }
        $q->close();
        $this->totale = $count - 1;
    }

    public function remove_opera($id_opera) {
        $q = $this->db->prepare("DELETE FROM opere WHERE id = (?)");
        $q->bind_param('i', $id_opera);
        $q->execute() or die('cancellazione non riuscita');
        $q->close();
    }

}
