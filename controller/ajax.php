<?php


class ajax extends controller {

	function __construct($method = null, $param = null)
	{
		switch ($method) {
			case 'nick':
				$this->nick($param);
				break;
			case 'email':
				$this->email($param);
				break;
			case 'pass':
			case 'password':
				$this->password($param);
				break;
			case 'testo':
				$this->test($para);
				break;
			case 'ricerca-campi':
				$this->ricerca_campi($param);
				break;
			default:
				echo 'ramo default';
				break;
		}
	}

	function ricerca_campi($tabella)
	{
		require_once('model/ricerca.php');
		if( '' == $tabella )
		{
			echo '<span class="errore">Tabella non trovata</span>';
			return ;
		}

		$campi = ricerca::get_campi($tabella);
		foreach($campi as $_)
		{
			echo '<label for="param_'.$_.'">'.$_.'</label>';
			echo '<input name="param_'.$_.'" type="text"  value="" />'."\n";
		}
	}

	function nick($nick)
	{
		if( null == $nick || !regexp::nick($nick) )
		{
			echo 'lettere, numeri, \'-\', \'_\' da 3 a 16';
		}else{
			echo 'OK';
		}
	}

	function email($email)
	{
		if( null == $email || !regexp::email($email) )
		{
			echo 'Indirizzo email non valido';
		}else{
			echo 'OK';
		}
	}

	function password($password)
	{
		if( null == $password || !regexp::password($password) )
		{
			echo 'Password non valida. Da 3 a 255 caratteri';
		}else{
			echo 'OK';
		}
	}

	function testo($testo)
	{
		if(!regexp::testo($testo))
		{
			echo 'Testo non valido.';
		}else{
			echo 'OK';
		}
	}
}

?>