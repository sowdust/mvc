<div id="menu">
<ul class="menu">
<li><a href="index.php" class="menu">Home</a></li>

<?php

	echo '<li><a href="' . init::link('registra') .'" class="menu">Registrati</a></li>';
	echo '<li><a href="' . init::link('login') .'" class="menu">Login</a></li>';
	echo '<li><a href="' . init::link('login','logout') .'" class="menu">Logout</a></li>';
	echo '<li><a href="' . init::link('opere') .'" class="menu">Opere</a></li>';
	echo '<li><a href="' . init::link('luoghi') .'" class="menu">Luoghi</a></li>';
	echo '<li><a href="' . init::link('utenti') .'" class="menu">Utenti</a></li>';

?>
<br><BR>
<?php

	//include('menu_user.php');

	//include('menu_admin.php');


?>
</ul></div>