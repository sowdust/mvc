<nav class="dark">
			<ul class="clear">
				<li><?php echo '<a href="' . init::link('index') .'">Home</a>'; ?></li>


<!--	Community 	-->

				<li><?php echo '<a href="' . init::link('utenti') .'">Community</a>'; ?>
				<ul>
<?php
	if(isset($this->user) && $this->user->get_type()>= 0)
	{
		//	UTENTE LOGGATO
	echo '<li><a href="' . init::link('utenti','vedi') .'">Profilo</a></li>';
	echo '<li><a href="' . init::link('utenti','modifica') .'">Modifica</a></li>';
	echo '<li><a href="' . init::link('login','logout') .'">Esci</a></li>';

	}else{

		//	UTENTE ANONIMO
		echo '<li><a href="' . init::link('login') .'" class="menu">Login</a></li>';
		echo '<li><a href="' . init::link('registra') .'" class="menu">Registrati</a></li>';
	}
?>
				</ul>




<!--	Luoghi 	-->
				<li><?php echo '<a href="' . init::link('luoghi') .'">Luoghi</a>'; ?>
				
<?php
	if(isset($this->user) && $this->user->get_type()>= 0)
	{
		//	UTENTE LOGGATO
		echo '<ul>';
		echo '<li><a href="' . init::link('luoghi','aggiungi') .'">Aggiugi luogo</a></li>';
		echo '</ul>';

	}
?>					
				</li>


<!--	Opere 	-->
				<li><?php echo '<a href="' . init::link('opere') .'">Opere</a>'; ?>
				
<?php
	if(isset($this->user) && $this->user->get_type()>= 0)
	{
		//	UTENTE LOGGATO
		echo '<ul>';
		echo '<li><a href="' . init::link('opere','aggiungi') .'">Aggiugi Opera</a></li>';
		echo '</ul>';

	}
?>					
				</li>



<!--	ricerca		-->
		<li><?php echo '<a href="' . init::link('ricerche') .'">Archivio</a>'; ?></li>




			</ul>
		</nav>

<!--
<div id="menu">
<ul class="menu">
<li><a href="index.php" class="menu">Home</a></li>

<?php

	echo '<li><a href="' . init::link('opere') .'" class="menu">Opere</a></li>';
	echo '<li><a href="' . init::link('luoghi') .'" class="menu">Luoghi</a></li>';
	echo '<li><a href="' . init::link('utenti') .'" class="menu">Utenti</a></li>';

?>
<br><BR>
<?php

	//include('menu_user.php');

	//include('menu_admin.php');


?>
</ul></div>-->