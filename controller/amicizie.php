<?php

require_once('model/amicizia.php');


class amicizie extends controller {

	function __construct($method = null, $param = null)
	{
		$this->set_db();
		$this->manage_session(1);

		switch ($method)
		{
			case 'richiedi':
				$this->richiedi($param);
				break;
			case 'rimuovi':
				break;
			case 'accetta':
				$this->accetta($param);
			default:
				break;
		}
		$this->set_view('index');
		$this->view->render();
	}

	function richiedi($id)
	{
		if (null == $id || !is_numeric($id))
		{
			$this->set_view('errore');
			$this->view->set_message('id non valido');
			$this->view->set_user($this->user);
			$this->view->render();
			die();
		}

		$amicizia = new amicizia($this->db,$this->user->get_id(),$id);
		$amicizia->richiedi();
		$da_notificare = new user($this->db,$id);
		$da_notificare->add_notifica('amicizia-richiesta',$this->user->get_id());

		$this->set_view('messaggio');
		$this->view->set_message('Richiesta di amicizia notificata');
		$this->view->set_user($this->user);
		$this->view->render();
		die();
	}

	function accetta($id)
	{
		if (null == $id || !is_numeric($id))
		{
			$this->set_view('errore');
			$this->view->set_message('id non valido');
			$this->view->set_user($this->user);
			$this->view->render();
			die();
		}

		$amicizia = new amicizia($this->db,$this->user->get_id(),$id);
		$amicizia->accetta();
		$da_notificare = new user($this->db,$id);
		$da_notificare->add_notifica('amicizia-accettata',$this->user->get_id());

		$this->set_view('messaggio');
		$this->view->set_message('Amicizia reciprocata');
		$this->view->set_user($this->user);
		$this->view->render();
		die();

	}
}

?>