<?php

$lista_utenti = $this->model->lista_utenti();
echo'<div class = "page-header">';

echo '<h1>Lista utenti</h1>';
echo'</div>';




echo '<ul class="list-group ">';
foreach ($lista_utenti as $id => $nick) {
    if ($this->user->get_id() != $id) {
        $amicizia = new amicizia($this->db, $this->user->get_id(), $id);
        $amici = $amicizia->check();
        echo '<li class="list-group-item text-left">';
        if ($amici || $this->user->get_type() == 1) {
            $u = new user($this->db, $id);
            $foto = (strlen($u->get_info()['foto']) > 1) ? $u->get_info()['foto'] : 'default.png';
            echo '<a href="' . init::link('utenti', 'vedi', $id) . '" class="avath">';
            echo '<img src="' . config::basehost . config::basedir . config::user_img . $foto . '" class="avatar" />';
            echo '</a>';
            echo '<a href="' . init::link('utenti', 'vedi', $id) . '"><strong>' . $nick . '</strong></a>';
            echo '<span class="divisore"> </span><i> ' . $u->get_stato() . '</i>';
        } else {

            echo '<img src="' . config::basehost . config::basedir . config::user_img . '/default.png" class="avatar" />';

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
