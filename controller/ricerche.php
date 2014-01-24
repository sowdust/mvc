<?php

require_once('model/ricerca.php');

class ricerche extends controller {

	function __construct($method = null, $param = null)
	{
		$this->set_db();
		$this->manage_session(1);

		switch ($method)
		{
			case 'risultati':
				break;
			default:
				$this->set_view('ricerche');
				$this->view->set_js('form.js.php');
				$this->view->set_message(ricerca::get_tabelle());
				$this->view->render();
				die();
				break;
		}
		// nel dubbio
		die();
	}

	function view()
	{
		$this->set_view('ricerche');
		$this->view->render();
		die();
	}

}

?>