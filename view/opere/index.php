<?php

echo '<h2>Opere</h2>';
echo '<ul>';
foreach($this->model->lista_opere() as $opera)
{
	echo '<li><a href="'.init::link('opere','vedi',$opera['id']).'">'.$opera['autore']
		.': ' . $opera['titolo'] . '</a>';
	echo ' <a href="aggiungi_luogo.php?opera='.$opera['id'].'">Segnala un luogo per questa opera!</a>';


}

echo '</ul>';

?>