<?php $amico = $this->model; ?>
<?php $info = $amico->get_info(); ?>

<h1><?php echo $amico->info['nick']; ?> </h1>
<h2><?php echo $amico->get_stato(); ?> </h2>
<table>
<tr><td width="30%" valign="top">
<img src="<?php echo config::basehost.config::basedir.config::user_img.$amico->get_info()['foto']; ?>" alt="<?php echo $amico->get_info()['nick']; ?>" style="width:100%;" />
</td><td valign="top">
<h3 style="padding:10px">Presentazione personale</h3>
<p style="padding:20px">
<?php echo nl2br(htmlentities($info['personale'])); ?>
</p>
</td></tr>
</table>
<p>
</p>


<h3>Gli ultimi stati di <?php echo $amico->info['nick']; ?></h3>
<?php

$stati = $amico->get_stati();
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


$form_commenti = new view('commenti','aggiungi');
$form_commenti->set_message(array('id_entita'=>$amico->get_id(),'tipo_entita'=>'utente'));
$form_commenti->render(false);

require_once('model/commento.php');
foreach($amico->get_commenti() as $id_com)
{
	$c = new view('commenti','vedi');
	$c->set_message($id_com);
	$c->set_db($this->db);
	$c->set_user($this->user);
	$c->render(false);
}
//var_dump($commenti);

?>