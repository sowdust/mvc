<?php

class index extends controller {

	function __construct()
	{
		$this->set_db();
		$this->manage_session(0);
		$this->set_view('index');
		$this->view->set_user($this->user);
		$this->view->render();
	}
}

?>
