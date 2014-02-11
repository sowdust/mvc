<?php
require_once('model/ricerca.php');

class ajax extends controller {

	function __construct($method = null, $param = null)
	{

		$this->set_db();

		switch ($method) {
			case 'nick':
				$this->nick($param);
				break;
			case 'nick_unico':
				$this->nick_unico($param);
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
			case 'is-tabella':
				$this->is_tabella($param);
				break;
			case 'stato':
				$this->stato($param);
				break;
			case 'rimuovi-notifica':
				$this->rimuovi_notifica($param);
				break;
			case 'get-commenti':
				$this->get_commenti($param);
				break;
			default:
				echo 'ramo default';
				break;
		}
	}

	function get_commenti($id)
	{
		$this->manage_session(1);

		require_once('model/commento.php');
		$commento = new commento($this->db,$id);
		$o = '';
		foreach($commento->get_children() as $id_com)
		{
			$c = new view('commenti','vedi');
			$c->set_message($id_com);
			$c->set_db($this->db);
			$c->set_user($this->user);
			$c->render(false);
		}
		echo $o;
	}

	function rimuovi_notifica($id)
	{
		require_once('model/notifica.php');

		$notifica = new notifica($this->db,$id);
		$notifica->rimuovi();
		echo $id;
	}

	function is_tabella($tabella)
	{
		if(in_array($tabella, ricerca::get_tabelle()))
		{
			echo 'OK';
		}else{
			echo 'Selezionare una tabella';
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
			echo '<input name="param_'.$_.'" type="text"  value="" class="ricerca" placeholder="'.$_.'" />'."\n";
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

	function stato($stato)
	{
		if(null == $stato || !regexp::stato($stato))
		{
			echo 'Stato non valido';
		}else{
			echo 'OK';
		}
	}

	function nick_unico($nick)
	{
		require_once('model/user_manager.php');
		$manager = new user_manager($this->db);
		if( null == $nick || !regexp::nick($nick) )
		{
			echo 'lettere, numeri, \'-\', \'_\' da 3 a 16';
		}
		if( $manager->count_users("nick = \"".$nick."\"")>0) 
		{
			echo 'Nome utente gi&agrave; esistente';
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