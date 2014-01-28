
<?php

require('common/form.php');

$form = new form();
$form->set_action(init::link('login'));
$form->set_name('login');
$form->set_id('login');

$nick = new input("text","nick");
$nick->set_legend('Nome utente');
$nick->set_id('login-nick');
//$nick->add_js(['onblur','valida("login-nick","check_nick")']);
$nick->add_js(['onblur',"valida(this,'nick')"]);

$pass =  new input("password","pass");
$pass->set_legend('Password');
$pass->set_id('login-pass');
$pass->add_js(['onblur',"valida(this,'pass')"]);

$submit =  new input("submit","login-form","accedi");
//$submit->add_js(['onclick',"valida_tutto(this,lista_elementi,obbligatori)"]);

$form->add($nick,true);
$form->add($pass,true);
$form->add($submit);

echo $form->to_html();


?>

