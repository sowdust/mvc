<?php

require_once('model/aggiornamenti.php');
$amico = $this->model;
$aggiornamenti = new aggiornamenti($this->db,$amico->get_id());
$lista_aggiornamenti = $aggiornamenti->get();

?>




<h1><?php echo $amico->get_info()['nick']; ?> </h1>
<p><img src="<?php echo config::basehost.config::basedir.config::user_img.$amico->get_info()['foto']; ?>" alt="<?php echo $amico->get_info()['nick']; ?>" width="500px"><br />
<?php echo $amico->get_info()['personale']; ?>
</p>
<p>
<ul>
<?php

for($i = 0; $i < sizeof($lista_aggiornamenti); ++$i)
{
	echo '<li class="aggiornamenti">'
		.'<span class="date">'
		.$lista_aggiornamenti[$i]['data']
		.'</span> '
		.$lista_aggiornamenti[$i]['testo'];

	if($this->user->get_id() == $amico->get_id() || $this->user->get_type() >0 )
	{
		echo ' <a href="remove_stato.php?id='.$lista_aggiornamenti[$i]['id'].'">Rimuovi</a>';
	}
	echo '</li>';
}

?>
</ul>
</p>
