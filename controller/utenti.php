<?php

require_once('model/user.php');
require_once('model/user_manager.php');
require_once('model/amicizia.php');

class utenti extends controller {

	function __construct($method = null, $param = null)
	{
		$this->set_db();
		$this->manage_session(1);

		switch ($method)
		{
			case 'vedi':
				$this->vedi($param);
				die();
				break;
			case 'rimuovi':
				$this->rimuovi($param);
				die();
				break;
			case 'modifica':
				$this->modifica($param);
				die();
			default:
				$this->lista();
				die();
				break;
		}
		// nel dubbio
		die();
	}

	function modifica($id)
	{

		$id = ( null == $id ) ? $this->user->get_id() : $id;

		if($this->user->get_id() != $id && $this->user->get_type()<1)
		{
			$this->set_view('errore');
			$this->view->set_message('Non autorizzato');
			$this->view->render();
			die();
		}

		$utente = new user($this->db,$id);

		if(!isset($_POST['modifica_profilo']))
		{
			$this->set_view('utenti','modifica');
			$this->view->set_model($utente);
			$this->view->set_user($this->user);
			$this->view->render();
			die();
		}

	//	controllo password

		if( ( (strcmp( md5( trim( $_POST['pass'] ) ), trim($utente->get_info()['pass_hash'] ) ) ) != 0 )
			&& ( $this->user->get_type() < 1) )
		{
			$this->set_view('errore');
			$this->view->set_message('Password non valida');
			$this->view->render();
			die();
		}

	//	caricamento foto

		if( ! empty( $_FILES['foto'] ) &&  pathinfo( $_FILES["foto"]["name"] )['filename'] != '' )
		{
			$info = pathinfo($_FILES["foto"]["name"]);
			$estensione = strtolower($info["extension"]);
			if (!in_array($estensione, $_FORMATI_IMMAGINI))
			{
				$this->set_view('errore');
				$this->view->set_message('Formato immagine non accettato');
				$this->view->render();
				die();
			}
			$rand = uniqid('',true);
			$nome_immagine = $rand.'.'.$estensione;
			if(!move_uploaded_file($_FILES['foto']['tmp_name'], $_USR_IMG_DIR.$nome_immagine ))
			{
				$msg_errore = "Caricamento foto fallito";
				include('../view/errore.php');
				die();
			}
			$new_info['foto'] = $nome_immagine;

		}else{
			$new_info['foto'] = $utente->get_info()['foto'];
		}



		if(!empty($_POST['new_pass']) && strlen($_POST['new_pass']) > 0 )
		{
			if($_POST['new_pass'] != $_POST['new_pass2'])
			{
				$this->set_view('errore');
				$this->view->set_message('Le password non coincidono');
				$this->view->render();
				die();
			}
			if(!check_pass($_POST['new_pass']))
			{
				$this->set_view('errore');
				$this->view->set_message('Password non valida');
				$this->view->render();
				die();
			}

			$new_info['pass_hash'] = md5($_POST['new_pass']);
		}

		$new_info['personale'] = mysql_real_escape_string($_POST['personale']);

		if($utente->set_info($new_info))
		{				
			$this->set_view('messaggio');
			$this->view->set_message('Profilo aggiornato');
			$this->view->render();
			die();

		} else {
			
			$this->set_view('errore');
			$this->view->set_message('Aggiornamento non riuscito');
			$this->view->render();
			die();
		}

		$this->set_view('messaggio');
		$this->view->set_message('Profilo modificato');
		$this->view->render();

	}

	function lista()
	{
		$manager = new user_manager($this->db);
		$this->set_view('utenti');
		$this->view->set_model($manager);
		$this->view->set_user($this->user);
		$this->view->set_db($this->db);
		$this->view->render();
		die();
	}	

	function vedi($id)
	{
		if (null == $id || !is_numeric($id))
		{
			$this->set_view('errore');
			$this->view->set_message('id non valido');
			$this->view->render();
			die();
		}

		$user = new user($this->db, $id);
		$this->set_view('utenti','vedi');
		$this->view->set_user($this->user);
		$this->view->set_model($user);
		$this->view->set_db($this->db);
		$this->view->render();
		die();
	}


	function rimuovi($id)
	{
		if (null == $id || !is_numeric($id))
		{
			$this->set_view('errore');
			$this->view->set_message('id non valido');
			$this->view->render();
			die();
		}

		$utente = new user($this->db,$id);
		// controllo permessi
		if($utente->get_id() == $this->user->get_id() || $this->user->get_type() == 1)
		{
			$manager = new user_manager($this->db);
			$manager->remove_user($id);

			$this->set_view('messaggio');
			$this->view->set_message('Account cancellato');
			$this->view->render();
			die();
		
		}else{
		
			$this->set_view('errore');
			$this->view->set_message('Non autorizzato');
			$this->view->render();
			die();
		}

		
	}

}

?>