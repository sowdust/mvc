<?php

require_once('model/luogo.php');
require_once('model/luogo_manager.php');

class luoghi extends controller {

	function __construct($method = null, $param = null)
	{
		$this->set_db();
		$this->manage_session(1);

		switch ($method)
		{
			case 'aggiungi':
				$this->aggiungi();
				break;
			case 'vedi':
				$this->vedi($param);
				break;
			case 'rimuovi':
				$this->rimuovi($param);
				break;
			default:
				$this->lista();
				break;
		}
		// nel dubbio
		die();
	}

	function aggiungi()
	{
		if(!isset($_POST['location']))
		{
			$this->set_view('luoghi','aggiungi');
			$this->view->render(false); //false?
			die();
		}
		if(empty($_POST['citta']) || empty($_POST['stato']) || $_POST['stato'] == 'Stato' || $_POST['citta'] == 'Citta') 
		{
			$this->set_view('errore');
			$this->view->set_message('citt&agrave; e stato sono obbligatori');
			$this->view->render();
			die();
		}
		if(	!regexp::testo($_POST['citta'])
			|| !regexp::testo($_POST['stato'])
			|| (strlen($_POST['indirizzo'])>1 && !regexp::testo($_POST['indirizzo']))
			|| (strlen($_POST['prov'])>1 && !regexp::testo($_POST['prov']))
			)
		{
			$this->set_view('errore');
			$this->view->set_message('campi non validi');
			$this->view->render();
			die();
		}

		$lmanager = new luogo_manager($this->db);
		$id_entita = $tipo_entita = 0;
		$lmanager->add_luogo($_POST['location'],$this->user->get_id(),$id_entita,$tipo_entita,
			$_POST['indirizzo'],$_POST['citta'],$_POST['prov'],$_POST['stato']);
		$this->set_view('messaggio');
		$this->view->set_message('Luogo inserito con successo');
		$this->view->render();
		die();
	}

	function lista()
	{
		$manager = new luogo_manager($this->db);
		$this->set_view('luoghi');
		$this->view->set_model($manager);
		$this->view->set_user($this->user);
		$this->view->render();
		die();
	}

	function vedi($id)
	{
		if (null == $id || !is_numeric($id))
		{
			$this->set_view('errore');
			$this->view->set_message('id non valido');
			$this->view->set_user($this->user);
			$this->view->render();
			die();
		}

		$luogo = new luogo($this->db, $id);
		$this->set_view('luoghi','vedi');
		$this->view->set_model($luogo);
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

		$luogo = new luogo($this->db,$id);
		// controllo permessi
		if($luogo->get_uid() == $this->user->get_id() || $this->user->get_type() == 1)
		{
			$manager = new luogo_manager($this->db);
			$manager->remove_luogo($id);

			$this->set_view('messaggio');
			$this->view->set_message('Luogo rimosso');
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
