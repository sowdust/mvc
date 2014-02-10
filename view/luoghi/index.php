<?php $lista_luoghi = $this->model->lista_luoghi(); ?>



<h2>Elenco dei luoghi</h2>


<table class="sortable">
<tr><th>Indirizzo</th><th>Citt&agrave;</th><th>Provincia</th><th>Stato</th><th>Lat</th><th>Lng</th><th>Aggiunto il</th><th></th></tr>


<?php

foreach($lista_luoghi as $luogo)
{
	echo '<tr>';
	echo '<td>'.$luogo['indirizzo'].'</td>';
	echo '<td>'.$luogo['citta'].'</td>';
	echo '<td>'.$luogo['prov'].'</td>';
	echo '<td>'.$luogo['stato'].'</td>';
	echo '<td>'.$luogo['lat'].'</td>';
	echo '<td>'.$luogo['lng'].'</td>';
	echo '<td>'.$luogo['data'].'</td>';
	echo '<td>';
	echo '<a href="'.init::link('luoghi','vedi',$luogo['id']).'">Dettagli</a>';

	if($this->user->get_type() == 1 || $luogo['id_utente']==$this->user->get_id())
	{

		echo '<a href="'.init::link('luoghi','rimuovi',$luogo['id']).'">Remove</a>';
	}

	echo '</td></tr>';
	echo "\n";

}
echo '</table>';

echo '</ul>';


?>