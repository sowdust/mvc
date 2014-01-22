<?php

require_once('model/database.php');
require_once('model/session.php');
require_once('model/user.php');
require_once('view/view.php');

class controller {

	protected $db;
	protected $user;
	protected $view;

	function set_db()
	{
		$this->db = new database;
	}

	function set_view($name,$sub=null)
	{
		$this->view = new View($name,$sub);
		$this->view->set_user($this->user);
	}
	
	function manage_session($auth_required = 1)
	{
		if(!isset($this->db)) die ('db non settato') ;
		
		session_start();
		
		//TODO: impostare max numero login in range di tempo per 
		//		evitare bruteforce
		// se hanno appena fatto il login	
		
		if(isset($_POST['nick']) && isset($_POST['pass']) && isset($_POST['login-form']))
		{
			if( isset($_SESSION['sess_data']))
			{
				unset($_SESSION['sess_data']);
			}
			if(!regexp::nick($_POST['nick']))
			{
				die('nick non valido');
			}else{
				$nick = $_POST['nick'];
			}

			//	TODO: trattare session id
			$sess_id = 0;
			$user_data = session::get_user_type_and_id($this->db,$nick,$_POST['pass']);
			$user_type = $user_data['type'];
			$user_id = $user_data['id'];
			if( $user_type < 0 && $auth_required > 0)
			{
				$this->view = new View('errore');
				$this->view->set_user($this->user);
				$this->view->set_message('Login Fallito');
				$this->view->render();
			}

		 	if($user_type >= 0)
			{
				$session = new session($this->db,$user_id);
				$_SESSION['sess_data'] = serialize($session);

				$this->user = new user($this->db,$user_id);
				$this->user->set_session($session);

				unset($session);

			}
		}

		if(isset($_SESSION['sess_data'] ))
		{
			$session = unserialize($_SESSION['sess_data']);
			$session->set_db($this->db->mysqli);
			$session->refresh();
			$this->user = new user($this->db,$session->get_user_id());
			if($this->user->get_type() < 0 )
			{
				die('sessione falsa?');
			}
			$this->user->set_session($session);
			unset($session);
			
		}elseif($auth_required > 0 ){

			$this->set_view('login');
			$this->view->set_js('form.js.php');
			$this->view->set_user($this->user);
			$this->view->render();
		}
	}
}

?>