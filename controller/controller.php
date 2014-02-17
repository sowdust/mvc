<?php

/**
 * File generale chedefinisce una classe ereditata da tutti i controller.
 *
 * @uses model/user.php
 * @uses model/session.php
 * @uses model/database.php
 * @uses view/view.php
 */

require_once('model/database.php');
require_once('model/session.php');
require_once('model/user.php');
require_once('view/view.php');


/**
 * Classe controller ereditata da tutti i controller.
 *
 * Definisce metodi e variabili comuni a tutti i controller.
 *
 * @var database $db
 * @var user $user
 * @var view $view
 */

class controller {

	protected $db;
	protected $user;
	protected $view;

	/**
	 * Sets the database.
	 *
	 * Creates a new 'database' object and stores its pointer in the object's $db var
	 */
	function set_db()
	{
		$this->db = new database;
	}

	/**
	 * Sets the view.
	 *
	 * Cretes a new 'view' object and stores its pointer in the object's $view var
	 * Also associates the visitor's user object's pointer in object's $user var.
	 * 
	 * @var string 					name of the view (corresponds to a subfolder name in 'view' folder)
	 * @var string|null optional 	sub view name (corresponds to a file in the view's folder).
	 * 								default is 'index'
	 */
	 function set_view($name,$sub=null)
	{
		$this->view = new view($name,$sub);
		$this->view->set_user($this->user);
	}
	

	/**
	 * Session manager - *authorization* manager.
	 *
	 * Creates or restores a session from $_SESSION var
	 * and creates/restores a row in "sessioni" table in mysql database
	 * The authorizathion is done via a secret key stored both in the db and
	 * in the $_SESSION var, generated and set after a successful login
	 * 
	 * @uses session::get_user_type_and_id
	 * @uses view 
	 * @uses $_POST
	 *
	 * @todo *impostare massimo # di tentativi di login per evitare brute force*
	 *
	 */
	 function manage_session($auth_required = 1, $redirect = true )
	{
		if(!isset($this->db)) die ('db non settato') ;
		
		session_start();
		
		//	se sono stati inviati valori via post, tentiamo il login
		//	se loggato, automaticamente avviene il logout
		if(isset($_POST['nick']) && isset($_POST['pass']) && isset($_POST['login-form']))
		{
			if( isset($this->user) && $this->user->get_type() >= 0)
			{
				$this->user->logout();
			}
			if(!regexp::nick($_POST['nick']))
			{
				die('nick non valido');
			}else{
				$nick = $_POST['nick'];
			}

			$user_data = session::get_user_type_and_id($this->db,$nick,$_POST['pass']);
			$user_type = $user_data['type'];
			$user_id = $user_data['id'];

			// se login fallito, errore
			if( $user_type < 0 && $auth_required > 0)
			{
				$this->view = new View('errore');
				$this->view->set_user($this->user);
				$this->view->set_message('Login Fallito');
				$this->view->render();
				die();
			}

			// se login valido, start new session
		 	if($user_type >= 0)
			{
				$session = new session($this->db,$user_id);
				$_SESSION['sess_data'] = serialize($session);

				$this->user = new user($this->db,$user_id);
				$this->user->set_session($session);

				unset($session);

			}
		}

		// altrimenti proviamo a vedere se la sessione dell'utente e' valida
		elseif(isset($_SESSION['sess_data'] ))
		{
			$session = unserialize($_SESSION['sess_data']);
			$session->set_db($this->db->mysqli);

			//	quick fix per alcuni link verso i quali non facciamo redirect
			if( 	!strpos($_SERVER['REQUEST_URI'],'ajax') 
				&&	!strpos($_SERVER['REQUEST_URI'],'risultati') 
				&&	!strpos($_SERVER['REQUEST_URI'],'rimuovi') 
				&&	!strpos($_SERVER['REQUEST_URI'],'aggiungi') )
			{

				$session->set_previous_page($session->get_current_page());
				@$session->set_current_page('index.php?'.explode('?',$_SERVER['REQUEST_URI'])[1]);
				$session->refresh();
			}else{

				$session->set_previous_page($session->get_current_page());
				$session->set_current_page($session->get_current_page());
				$session->refresh();
			}

			$this->user = new user($this->db,$session->get_user_id());

			if($this->user->get_type() < 0 )
			{
				die('sessione falsa?');
			}
                        
			$this->user->set_session($session);
                        $_SESSION['sess_data'] = serialize($session);
			unset($session);
		
		// infine, se la pagina richiede autorizzazione, presentiamo pag login
		}elseif($auth_required > 0 ){

			$this->set_view('login');
			$this->view->set_js('form.js.php');
			$this->view->set_user($this->user);
			$this->view->render();
			die();
		}
	}
}

?>