<?php 
require_once('model/commento.php');
$commento = new commento($this->db,$this->message);
$utente = new user($this->db,$commento->id_utente);
?>

<div id="commento_<?php echo $commento->id; ?>" class="commento">

Il <?php echo $commento->data; ?> 
<a href="<?php echo init::link('utenti','vedi',$utente->get_id()); ?>" >
<?php echo $utente->get_info()['nick']; ?>
</a>
ha scritto:
<div id="contenuto_commento_<?php echo $commento->id; ?>">
<?php echo htmlentities($commento->testo); ?><br />
<!-- <a href="aggiungi_commento.php?id_entita='.$this->id.'&tipo_entita=commento">commenta</a> -->
<a href="#" onclick="comment_form(<?php echo $commento->id; ?>);return false;">Commenta</a>
<?php
if($this->user->get_type() > 0 || $this->user->get_id()==$utente->get_id())
{
	echo '<a href="'. init::link('commenti','rimuovi',$commento->id). '">Rimuovi</a>';
}

?>


</div>
<?php 
		$count = 0;
		$o = '';
		if(sizeof($commento->get_children()))
		{
			$o.=' | <a id="more_'.$commento->id.'" title="Mostra gli altri commenti a questo" href="#"'
				.'	onmouseover="get_commenti('.$commento->id.');return false;">More</a>';
			$o.=' | <a id="less_'.$commento->id.'" title="Nascondi gli altri commenti a questo" href="#"'
				.'	onmouseover="less('.$commento->id.');return false;">Less</a>';

		}
		$o.='<script type="text/javascript">window.showing['.$commento->id.']=true;</script>';
		$o .= '</div>';
		echo $o;
?>
