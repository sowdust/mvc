<?php $amico = $this->model; ?>
<?php $info = $amico->get_info(); ?>

<h1><?php echo $amico->info['nick']; ?> </h1>
<h2><?php echo $amico->get_stato(); ?> </h2>

<!-- info generali utente -->
<div>
<div style="display:inline-block; width:30%; vertical-align:top">
<img src="<?php echo config::basehost.config::basedir.config::user_img.$amico->get_info()['foto']; ?>"
	alt="<?php echo $amico->get_info()['nick']; ?>" style="width:100%;" />
</div>
<div style="display:inline-block; width:65%;">
<p><?php echo nl2br(htmlentities($info['personale'])); ?></p>
</div>
</div>


<!-- commenti all'utente -->

<h2><?php echo $amico->info['nick']; ?>&acute; guestbook</h2>
<a href="#" onclick="comment_form(<?php echo $amico->get_id(); ?>,'utente',true);return false;"> <img src="<?php echo config::icons; ?>scrivi.png" class="icon" /> Commenta</a>
<div id="contenuto_commento_header_<?php echo $amico->get_id(); ?>"></div>

<?php


require_once('model/commento.php');
foreach($amico->get_commenti() as $id_com)
{
	$c = new view('commenti','vedi');
	$c->set_message($id_com);
	$c->set_db($this->db);
	$c->set_user($this->user);
	$c->render(false);
}

$form_commenti = new view('commenti','aggiungi');
$form_commenti->set_message(array('id_entita'=>$amico->get_id(),'tipo_entita'=>'utente'));
//$form_commenti->render(false);

?>



<!-- ultime attivita' utente -->

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

?>


<h3>Gli ultimi luoghi inseriti di <?php echo $amico->info['nick']; ?></h3>
<?php

$luoghi = $amico->get_luoghi();
echo '<ul>';
foreach($luoghi as $s)
{
	echo '<li>';
	echo '<span class="data"> '. $s->get_data() . ' </span>';
	echo $s->get_indirizzo(). '(' . $s->get_citta() . ')';
	echo ($this->user->get_type() > 0 || $this->user->get_id() == $s->get_uid())
			?	' <a href = "'.init::link('luoghi','rimuovi',$s->get_id()).'">Rimuovi</a>' : '' ;
	echo '</li>';
}
echo '</ul>';
?>



<h3>Gli ultimi commenti inseriti di <?php echo $amico->info['nick']; ?></h3>
<?php

$commenti = $amico->get_commenti_autore();
echo '<ul>';
foreach($commenti as $s)
{
	echo '<li>';
	echo '<span class="data"> '. $s->get_data() . ' </span>';
	echo $s->get_testo();
	echo ($this->user->get_type() > 0 || $this->user->get_id() == $s->get_uid())
			?	' <a href = "'.init::link('commenti','rimuovi',$s->get_id()).'">
                                   <img src="'.config::icons.'rimuovi.png" class="icon" /></a>' : '' ;
	echo '</li>';
}
echo '</ul>';


?>