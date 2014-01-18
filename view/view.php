<?php

class view {

	protected $name;
	protected $message;
	protected $model;
	protected $user;
	protected $db;

	function __construct($name,$sub=null)
	{
		$sub = ( null == $sub ) ? 'index' : $sub;
		$this->name = $name;
		$this->filename = 'view/'.$name.'/'.$sub.'.php';
		if(!file_exists($this->filename)) die ('view inesistente');
	}

	function set_db($db)
	{
		$this->db = $db;
	}
	
	function set_model($m)
	{
		$this->model = $m;
	}

	function set_user($u)
	{
		$this->user = $u;
	}

	function set_message($m)
	{
		$this->message = $m;
	}

	function render($formatted = true)
	{
		if($formatted)
		{
			require_once('view/include/head.php');
			require_once('view/include/header.php');
			require_once('view/include/menu.php');
			require_once($this->filename);
			require_once('view/include/footer.php');
		}else{
			require_once($this->filename);
		}
	}



}

?>