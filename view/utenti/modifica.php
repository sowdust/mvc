<?php

	/*
		prende i dati utente da $this->model
		$this->user puo' essere admin
	*/

global $_FORMATI_IMMAGINI;

?>
<form name="mod_profilo" id="mod_profilo"
	action="<?php echo init::link('utenti','modifica',$this->model->get_id()); ?>"  method="post" enctype="multipart/form-data">

<?php

if(strlen($this->model->get_info()['foto']) > 1)
{
	echo '<img src="' . config::basehost . config::basedir . config::user_img . $this->model->get_info()['foto']. '" alt="foto del profilo corrente" width="300"><br />';
}

?>
<label for="nick">Nick</label><br />
<input name="nick" type="text" value="<?php echo $this->model->get_info()['nick']; ?>" READONLY><br />
<label for="pass">Password</label><br />
<input name="pass" type="password" value=""><br />
<!--<label for="citta">Citt&agrave;</label><br />
<input name="citta" type="text" value="<?php echo $this->model->get_info()['citta']; ?>" READONLY><br />-->
<label for="email">E-mail</label><br />
<input name="email" type="text" value="<?php echo $this->model->get_info()['email']; ?>"><br />
<label for="foto">Foto</label><br />
<input name="foto" type="file"><br />
<span class="date">Formati accettati: 
<?php foreach($_FORMATI_IMMAGINI as $f)	echo $f." "; ?>
</span><br />
<label for="personale">Personale (scrivi quello che vuoi)</label><br />
<textarea name="personale" rows="10" cols="60">
<?php echo $this->model->get_info()['personale']; ?>
</textarea><br />
<span class="date">Riempire i campi sottostanti solo se si vuole modificare la password</span><br />
<label for="new_pass">Nuova Password</label><br />
<input name="new_pass" type="password" value=""><br />
<label for="new_pass2">Conferma Nuova Password</label><br />
<input name="new_pass2" type="password" value=""><br />
<input type="submit" name="modifica_profilo" value="Aggiorna">
</form>
