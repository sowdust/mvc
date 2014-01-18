<?php

require_once('model/opera.php');
require_once('model/opera_manager.php');

class opere extends controller {

	function __construct($method = null, $param = null)
	{
		$this->set_db();
		$this->manage_session(1);

		switch ($method)
		{
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

	function lista()
	{
		$omanager = new opera_manager($this->db);
		$this->set_view('opere');
		$this->view->set_model($omanager);
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

		$opera = new opera($this->db, $id);
		$this->set_view('opere','vedi');
		$this->view->set_model($opera);
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

		$opera = new opera($this->db,$id);
		// controllo permessi
		if($opera->get_uid() == $this->user->get_id() || $this->user->get_type() == 1)
		{
			$omanager = new opera_manager($this->db);
			$omanager->remove_opera($id);

			$this->set_view('messaggio');
			$this->view->set_message('Opera rimossa');
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
