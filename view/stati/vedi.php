<?php 
$amico = $this->model; 
$autore = new user($this->db,$this->model->get_uid());
?>

<div class="contg">
<span class="date"> <?php echo $autore->get_info()['nick']. ' alle ' .$amico->get_data(); ?></span>:
<p><?php  echo $this->model->get_testo(); ?></p>

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

?>

</div>
