<?php

$lista_utenti = $this->model->lista_utenti();

echo '<h2>Lista utenti</h2>';




echo '<ul class="list-group ">';
foreach ($lista_utenti as $id => $nick) {
    if ($this->user->get_id() != $id) {
        $amicizia = new amicizia($this->db, $this->user->get_id(), $id);
        $amici = $amicizia->check();
        echo '<li class="list-group-item text-left">';
        if ($amici || $this->user->get_type() == 1) {
            echo '<a href="' . init::link('utenti', 'vedi', $id) . '"><strong>' . $nick . '</strong></a>';
        } else {
            echo '<strong>' . $nick . '</strong>';
        }
        echo '<span class="badge transparent">';
        if (!$amici && !$amicizia->is_pending()) {
            echo '<a class="nohover" href="' . init::link('amicizie', 'richiedi', $id) . '">'
            . '<button type="button" class="btn btn-xs btn-default">Richiedi Amicizia</button></a>';
        }
        if ($amicizia->is_pending()) {
            echo ' Quasi Amici';
        }
        if ($this->user->get_type() == 1) {
            echo' <a class="nohover" href="' . init::link('utenti', 'rimuovi', $id) . '">'
            . '<button type="button" class="btn btn-xs btn-danger">Rimuovi Utente</button>'
            . '</a> '
            . '<a  class="nohover" href="' . init::link('utenti', 'modifica', $id) . '">'
            . '<button type="button" class="btn btn-xs btn-primary">Modifica Info</button>'
            . '</a>';
        }
        echo '</span>';
        echo '</li>';
    }
}

echo '</ul>';
