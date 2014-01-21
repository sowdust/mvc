<?php

require('model/form.php');

$form = new form();
$form->set_action(init::link('login'));
$form->set_name('login');
$form->set_id('login');

$nick = new input("text","nick");
$nick->set_legend('Nome utente');
$nick->set_id('login-nick');

$pass =  new input("password","pass");
$pass->set_legend('Password');
$pass->set_id('login-pass');

$submit =  new input("submit","login-form","accedi");
$submit->add_js( ['onclick','alert("alert")'] );

$form->add($nick);
$form->add($pass);
$form->add($submit);

echo $form->to_html();


/*
<form name="login" id="login" action="<?php echo str_replace('/logout','',URL); ?>"  method="post">
<input type="text" name="nick"><br>
<input type="password" name="pass"><br>
<input type="submit" name="login-form" value="accedi">
</form>
*/

?>



<input type="submit" id="invia-login" value = "invia!" />

<div id="msgid"></div>