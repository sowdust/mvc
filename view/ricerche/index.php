<form name="ricerca" id="ricerca" action="<?php echo init::link('ricerche','risultati'); ?>"  method="post">

<span id="ricerca_tabella">
<select name = "table" onchange="ricerca_get_param();return false;" id="ricerca_tabelle">
<option value = '' disabled selected>--seleziona tabella--</option>
<?php

foreach($this->message as $t)
{
echo '<option value="'.$t.'">'.ucfirst($t).'</option>';
}

?>
</select>
</span>

<span id="ricerca_campi">
</span>
<input type="submit" name="inviato" value="Ricerca">

</form>
