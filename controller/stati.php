<?php

require_once('model/stato.php');

	class stati extends controller {

		function __construct($method = null, $param = null)
		{
			$this->set_db();
			$this->manage_session(1);

			switch ($method)
			{
				case 'aggiungi':
					$this->aggiungi();
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
			if(!isset($_POST['stato'])
				|| !regexp::stato($_POST['stato']))
			{
				$this->set_view('errore');
				$this->view->set_message('stato non valido');
				$this->view->render();
				die();
			}
			$this->user->add_stato($_POST['stato']);
			$redirect = (isset($_POST['redirect'])) ? $_POST['redirect'] : 'index.php';
			header("Location: ".$redirect);
		}

		function rimuovi($param)
		{
			if(null == $param || !is_numeric($param))
			{
				$this->set_view('errore');
				$this->view->set_message('id non valido');
				$this->view->render();
				die();
			}
			$stato = new stato($this->db,$param);
			if($stato->get_uid() != $this->user->get_id()
				&& $this->user->get_type()<1 )
			{
				$this->set_view('errore');
				$this->view->set_message('non sei autorizzato');
				$this->view->render();
				die();
			}

			$this->user->remove_stato($param);
			$this->set_view('messaggio');
			$this->view->set_message('Stato eliminato con successo');
                        $this->view->set_redirect($this->user->session->get_previous_page());
			$this->view->render();
			die();
		}


	}
?>