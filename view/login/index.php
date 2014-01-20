<?php

require('model/form.php');

$form = new form();
$form->set_action(init::link('login'));
$form->set_name('login');
$form->set_id('login');

$nick = new input("text","nick");

$submit =  new input("submit","login-form","accedi");
$submit->add_js( ['onclick','alert("alert")'] );

$form->add($nick);
$form->add( new input("password","pass") );
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