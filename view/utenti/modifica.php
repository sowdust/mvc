<?php

require_once('common/form.php');

	/*
		prende i dati utente da $this->model
		$this->user puo' essere admin
	*/
$user_data = $this->model->get_info();

global $_FORMATI_IMMAGINI;


if(strlen($this->model->get_info()['foto']) > 1)
{
	echo '<img src="' . config::basehost . config::basedir . config::user_img 
		.$this->model->get_info()['foto']. '" alt="foto del profilo corrente" width="300"><br />';
}

$form = new form();
$form->set_name('modifica-profilo');
$form->set_id('modifica-profilo');
$form->set_action(init::link('utenti','modifica',$this->model->get_id()));
$form->set_method('POST');
$form->set_type('multipart/form-data');

$nick = new input('text','nick');
$nick->set_legend('Nome utente');
$nick->set_value($user_data['nick']);
$nick->set_readonly(true);
$nick->set_id('registra-nick');


$pass =  new input("password","pass");
$pass->set_legend('Password');
$pass->set_id('registra-pass');
$pass->add_js(['onblur',"valida(this,'pass')"]);

$email = new input("text","email");
$email->set_legend('Indirizzo email');
$email->set_value($user_data['email']);
$email->set_id('registra-email');
$email->add_js(['onblur',"valida(this,'email')"]);

$foto = new input('file','foto');
$legenda_foto = 'Foto personale (Formati ';
foreach($_FORMATI_IMMAGINI as $f)	$legenda_foto.= $f." "; 
$legenda_foto.=')';
$foto->set_legend($legenda_foto);
$foto->set_id('registra-foto');

$personale = new input('textarea','personale');
$personale->set_value($user_data['personale']);
$personale->set_legend('Personale');
$personale->add_js(['onblur',"valida(this,'testo')"]);
$personale->set_row_col(10,60);
$personale->set_id('registra-personale');

$npass =  new input("password","new_pass");
$npass->set_legend('Nuova password (lasciare vuoto per mantenere la vecchia)');
$npass->add_js(['onblur',"valida(this,'pass')"]);
$npass->set_id('registra-npass');

$npass2 =  new input("password","new_pass2");
$npass2->set_legend('Conferma nuova password');
$npass2->add_js(['onblur',"valida(this,'pass')"]);
$npass2->set_id('registra-npass2');

$invia = new input('submit','modifica-invia');
$invia->set_value('Modifica');




$form->add($nick,true);
$form->add($pass,true);
$form->add($email,true);
$form->add($foto);
$form->add($personale);
$form->add($npass);
$form->add($npass2);
$form->add($invia);
echo $form->to_html();


?>
