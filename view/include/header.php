<?php require_once('common/form.php'); ?>
<body>
<?php include('menu.php'); ?>
<div id="centering">
<div id="header">
<?php

if(isset($this->user) && $this->user->get_type()>=0 )
{

$form = new form();
$form->set_action(init::link('stati','aggiungi'));
$form->set_name('stato');
$form->set_id('stato');
$redirect = new input("hidden","redirect");
$stato = new input("text","stato");
//$stato->set_legend('Stato');
$stato->set_id('stato-testo');
$stato->set_value('Cambia stato...');
$redirect->set_value(basename($_SERVER['REQUEST_URI']));
//$nick->add_js(['onblur','valida("login-nick","check_nick")']);
$stato->add_js(['onblur',"valida(this,'stato')"]);
$stato->add_js(['onsubmit',"valida(this,'stato')"]);
$stato->add_js(['onclick',"this.value='';"]);

//$submit =  new input("submit","stato-submit","ok");
$form->add($redirect);
$form->add($stato,true);
//$form->add($submit);

echo $form->to_html();

}
?>
</div>
<div id="middle">
<!--
<div id="header">
<div id="web_title"><h1>WAW</h1></div>
<?php
if(isset($user) && ($user->get_type() >= 0))
{
	echo "<div id=\"barra_stato\">".$user->get_stato()."</div>\n";
}
?>-->
<!-- form cambio stato 
<div>
<form id="cambia_stato_nuovo" method="post" action="add_stato.php" >
<input type="hidden" name="redirect" value="<?php echo basename($_SERVER['REQUEST_URI']); ?>">
<input type="text" name="stato" id="frase_stato_nuova" value="Scrivi qui il nuovo stato..."
				onclick="this.value='';" maxlength="255" />
</form>
</div>
<div id="web_subtitle">where are we?</div>
</div>-->	<!-- div header	-->
