<?php

require_once('controller.php');

class errore extends controller {

	function __construct($mess = '')
	{
		$this->set_view('errore');
		$this->view->set_message($mess);
		$this->view->render();
		die();
	}
}