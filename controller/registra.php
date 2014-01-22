<?php

require_once('model/user_manager.php');

class registra extends controller {

	function __construct($method = null, $param = null)
	{

		$this->set_db();
		$this->manage_session(0);

		if(isset($method) && isset($param)) 
		{
			$this->attiva($method,$param);
			die();
		}

		$this->registra();
	}

	function registra()
	{
		if(!isset($_POST['nick']) && !isset($_POST['pass']) && !isset($_POST['email']))
		{
			$this->set_view('utenti','registra');
			$this->view->render();
			die();
		}

		if(		!regexp::nick($_POST['nick']) 
			||	!regexp::pass($_POST['pass']) 
			||	!regexp::email($_POST['email']) )
		{
			$this->set_view('errore');
			$this->view->set_message('campi non validi');
			$this->view->render();
			die();
		}

		$umanager = new user_manager($this->db);
		$link = $umanager->add_user($_POST['nick'],$_POST['email'],$_POST['pass']);
		$this->set_view('utenti','registrato');
		$this->view->set_message($link);
		$this->view->render();
		die();
	}

	function attiva($nick,$code)
	{
		$nick = urldecode($nick);
		$code = urldecode($code);
		if(!regexp::nick($nick))
		{
			die('nick non valido');
		}
		$umanager = new user_manager($this->db);
		$response = $umanager->activate($nick,$code);

		if($response)
		{
			$this->set_view('messaggio');
			$this->view->set_message('Account attivato');
			$this->view->render();
			die();
		}else{
			$this->set_view('errore');
			$this->view->set_message('Si sono verificati errori');
			$this->view->render();
			die();
		}
	}
}
?>