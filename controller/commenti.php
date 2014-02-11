<?php

require_once('common/regexp.php');
require_once('model/commento_manager.php');
require_once('model/commento.php');
require_once('model/user.php');

class commenti extends controller {

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
				
				break;
		}
		// nel dubbio
		die();
	}


	function vedi($id)
	{
		if( null == $id || !is_numeric($id))
		{
			$this->set_view('errore');
			$this->view->set_message('id non valido');
			$this->view->render();
			die();
		}
		$this->set_view('commenti','vedi');
		$this->view->set_message($id);
		$this->view->set_db($this->db);
		$this->view->render();
		die();
	}

	function aggiungi()
	{

		if(!isset($_POST['testo']) || ( !isset($_POST['id_entita']) || !is_numeric($_POST['id_entita']) )
			|| !regexp::entita($_POST['tipo_entita']) || !regexp::testo($_POST['testo']))
		{
			$this->set_view('errore');
			$this->view->set_message('campi non compilati o non validi');
			$this->view->render();
			die();
		}

		$cm = new commento_manager($this->db);

		if($cm->add_commento($this->user->get_id(),$_POST['id_entita'],$_POST['tipo_entita'],trim($_POST['testo'])) )
		{
			$this->set_view('messaggio');
			$this->view->set_message('commento inserito con successo');
			$this->view->set_redirect($this->user->session->get_previous_page());
			$this->view->render();	
		}else{
			$this->set_view('errore');
			$this->view->set_message('errore durante inserimento commento');
			$this->view->set_redirect($this->user->session->get_previous_page());
			$this->view->render();	
		}
		return ;
	}

	function rimuovi($id)
	{
		if( null == $id || !is_numeric($id))
		{
			$this->set_view('errore');
			$this->view->set_message('id non valido');
			$this->view->render();
			die();
		}

		$commento = new commento($this->db, $id);
		if($commento->id_utente != $this->user->get_id()
			&& $this->user->get_type()<= 0 )
		{
			$this->set_view('errore');
			$this->view->set_message('Non autorizzato');
			$this->view->render();
			die();
		}
		
		$cm = new commento_manager($this->db);
		$cm -> remove_commento($id);

		$this->set_view('messaggio');
		$this->view->set_message('commento rimosso');
        $this->view->set_redirect($this->user->session->get_previous_page());
		$this->view->render();
		die();
	}


}