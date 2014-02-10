<?php

class login extends controller {

	function __construct($logout = null)
	{
		$this->set_db();
		$this->manage_session(1);
		
		if('logout' == $logout)
		{
			$this->user->logout();
			$this->user->set_type(-1);
			$this->set_view('messaggio');
			$this->view->set_message('Logout effettuato. Tutti i dati relativi alla navigazione sono stati eliminati');
			$this->view->render();
			die();
		}


		if($this->user->get_type() < 0)
		{
			$this->user->logout();
			$this->set_view('login');
			$this->view->set_js('form.js.php');
			$this->view->render();
			die();
		}else{
			$this->set_view('messaggio');
			$this->view->set_message('Login effettuato');
			$this->view->render();
			die();
		}		
	}
}

?>
