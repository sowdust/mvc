<?php
$loggato=false;	// legacy
?>
<body>
<div id="centering">

<div id="header">
<div id="web_title"><h1>WAW</h1></div>
<?php
if(isset($user) && ($user->get_type() >= 0))
{
	echo "<div id=\"barra_stato\">".$user->get_stato()."</div>\n";
}
?>
<!-- form cambio stato -->
<div>
<form id="cambia_stato_nuovo" method="post" action="add_stato.php" >
<input type="hidden" name="redirect" value="<?php echo basename($_SERVER['REQUEST_URI']); ?>">
<input type="text" name="stato" id="frase_stato_nuova" value="Scrivi qui il nuovo stato..."
				onclick="this.value='';" maxlength="255" />
</form>
</div>
<div id="web_subtitle">where are we?</div>
</div>	<!-- div header	-->
