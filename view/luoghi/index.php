<?php $lista_luoghi = $this->model->lista_luoghi(); ?>

<h1>Elenco dei luoghi</h1>
<p>In questa pagina trovi l&acute; elenco dei luoghi che gli utenti hanno inserito.</p>
<?php

require_once('model/user.php');

$output = '';
$cur_citta = '';
$cur_prov = '';
$cur_stato = '';
$citta = array();
$stati = array();
$province = array();

foreach($lista_luoghi as $luogo)
{
	if($cur_stato != trim(strtolower($luogo['stato']))) 
	{
		if($cur_stato != '')
		{
		}
		$cur_stato = trim(strtolower($luogo['stato']));
		$stati[] = $cur_stato;
		$output .= '<br /><h2><a name="'.$cur_stato.'">'.ucfirst($cur_stato).'</a></h2>';
	}
	if($cur_prov !=  trim(strtolower($luogo['prov'])))
	{
		$cur_prov =  trim(strtolower($luogo['prov']));
		$province[] = $cur_prov;
		$output .= '<h3><a name="'.$cur_prov.'">'.ucfirst($cur_prov).'</a></h3>';

	}
	if($cur_citta !=  trim(strtolower($luogo['citta'])))
	{
		$cur_citta =  trim(strtolower($luogo['citta']));
		$citta[] = $cur_citta;
		$output .= '<h4><a name="'.$cur_citta.'">'.ucfirst($cur_citta).'</a></h4>';
	}

	$utente = new user($this->db, $luogo['id_utente']);

	$output .= '<div class="lista_luoghi">';
	$output .= '<address>'.$luogo['indirizzo'] .'</address> <br />';
	$output .= ' inserito da <a href="'.init::link('utenti','vedi',$utente->get_id()).'">';
	$output .= $utente->get_info()['nick']. '</a>';
	$output .= ' il <span class="date">'. $luogo['data'] . '</span><br />';
	$output .= '<b>Azioni:</b> <a href="'.init::link('luoghi','vedi',$luogo['id']).'">Vedi mappa</a>';
	if($this->user->get_type() == 1 || $luogo['id_utente']==$this->user->get_id())
	{

		$output .= ' | <a href="'.init::link('luoghi','rimuovi',$luogo['id']).'">Elimina</a>';
	}
	$output .= '</div>';
}

?>

<div class = "elenco-stati">
<b>Stati:</b>
<?php
foreach ($stati as $s) {
	echo '<a href="#'.$s.'">'.$s.'</a> ';
}
?>
</div>

<div class = "elenco-prov">
<b>Province:</b>
<?php
foreach ($province as $s) {
	echo '<a href="#'.$s.'">'.$s.'</a> ';
}
?>

<div class = "elenco-citta">
<b>Citt&agrave;:</b>
<?php
foreach ($citta as $s) {
	echo '<a href="#'.$s.'">'.$s.'</a> ';
}
?>
</div>



</div>


<?php echo $output; ?>
