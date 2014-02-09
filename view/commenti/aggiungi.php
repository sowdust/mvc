<?php

// da sopra arrivano le variabili
// $messaggio['id_entita']
// $messaggio['tipo_entita']
?>

<div id = "div_aggiungi_commento">
<form name="aggiungi_commento" id="aggiungi_commento" action="<?php echo init::link('commenti','aggiungi'); ?>" method="post">
<input type="hidden" name="id_entita" value="<?php echo $this->message['id_entita']; ?>">
<input type="hidden" name="tipo_entita" value="<?php echo $this->message['tipo_entita']; ?>">
<input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
<textarea name = "testo"></textarea> <br />
<input type = "submit" name = "commento_inviato">
</form>
</div>
