
<?php

require_once('common/form.php');

$form = new form();
$form->set_action(init::link('registra'));
$form->set_name('registra');
$form->set_id('registra');

$nick = new input("text","nick");
$nick->set_legend('Nome utente');
$nick->set_id('registra-nick');
$nick->add_js(['onblur',"valida(this,'nick_unico')"]);

$email = new input("text","email");
$email->set_legend('Indirizzo email');
$email->set_id('registra-email');
$email->add_js(['onblur',"valida(this,'email')"]);

$pass =  new input("password","pass");
$pass->set_legend('Password');
$pass->set_id('registra-pass');
$pass->add_js(['onblur',"valida(this,'pass')"]);

$submit =  new input("submit","registra-inviato","registra");

$form->add($nick,true);
$form->add($pass,true);
$form->add($email,true);
$form->add($submit);

echo $form->to_html();

?>