<?php $amico = $this->model; ?>

<h1><?php echo $amico->get_info()['nick']; ?> </h1>
<h2><?php echo $amico->get_stato(); ?> </h2>

<div style = "display:block;">
<div style = "width:25%;float:left;padding:1em">
<img src="<?php echo config::basehost.config::basedir.config::user_img.$amico->get_info()['foto']; ?>" alt="<?php echo $amico->get_info()['nick']; ?>" width="100%" />
</div>
<div style = "float:left;padding:1em">
<p><?php echo $amico->get_info()['personale']; ?></p>
</div>
</div>

<div style = "display:block;">

<?php

$stati = $this->user->get_stati();
echo '<ul>';
foreach($stati as $s)
{
	echo '<li>';
	echo '<span class="data"> '. $s->get_data() . ' </span>';
	echo (strlen($s->get_testo()) > 160)	? substr($s->get_testo(), 0, 160).'...'
											: substr($s->get_testo(), 0, 160);
	echo ($this->user->get_type() > 0 || $this->user->get_id() == $s->get_uid())
			?	' <a href = "'.init::link('stati','rimuovi',$s->get_id()).'">Rimuovi</a>' : '' ;
	echo '</li>';
}
echo '</ul>';
?>

</div>
<?php


$stati = $this->user->get_notifiche();
foreach($stati as $s)
{
	var_dump($s);
	echo $s->stampa();
	echo $s->get_data();
	//echo $s->
}

?>
