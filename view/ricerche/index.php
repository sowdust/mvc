<form name="ricerca" 
onsubmit="return valida_tutto(this,lista_elementi,obbligatori);"
id="ricerca" action="<?php echo init::link('ricerche','risultati'); ?>"  method="post">

<span id="ricerca_tabella">
<select name = "table" onchange="valida(this,'is-tabella');ricerca_get_param();return false;" id="ricerca_tabelle">
<option value = '' disabled selected>--seleziona tabella--</option>
<?php

foreach($this->message as $t)
{
echo '<option value="'.$t.'">'.ucfirst($t).'</option>';
}

?>
</select>
</span>
<div id="errori-table"></div>
<span id="ricerca_campi">
</span>
<input type="submit" name="inviato" value="Ricerca">

</form>
