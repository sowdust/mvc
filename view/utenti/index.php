<?php

$lista_utenti = $this->model->lista_utenti();

echo '<h2>Lista utenti</h2>';
echo '<ul class="utenti">';
foreach($lista_utenti as $id=>$nick)
{
	if($this->user->get_id() != $id)
	{
		$amicizia = new amicizia($this->db,$this->user->get_id(),$id);
		$amici = $amicizia->check();
		echo '<li>';
		if($amici)
		{
			echo '<a href="' . init::link('utenti','vedi',$id) . '">'.$nick.'</a>';
		}else{
			echo $nick;
		}
		if(!$amici && !$amicizia->is_pending())
		{
			echo '<a href="'.init::link('amicizie','richiedi',$id).'"><img src="'.config::icons.'friend.png" " class="icon" alt="Richiedi Amicizia!" /></a>';
		}
		if($amicizia->is_pending())
		{
			echo ' Quasi Amici';
		}
		if($this->user->get_type() == 1)
		{
			echo' <a href="'.init::link('utenti','rimuovi',$id).'"><img src="'.config::icons.'rimuovi.png" " class="icon" alt="rimuovi" /></a> - '
				.'<a href="'.init::link('utenti','modifica',$id).'"><img src="'.config::icons.'scrivi.png" " class="icon" alt="modifica" /></a>';
		}
		echo '</li>';
	}
}

echo '</ul>';