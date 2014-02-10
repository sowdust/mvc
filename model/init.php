<?php

require_once('controller/errore.php');
class init {

	protected $req;

	function __construct($req)
	{
		$req = (empty($req)) ? 'index' : rtrim($req,'/') ;
		$req = explode('/',$req);

		$method = (isset($req[1])) ? $req[1] : null;
		$params = (isset($req[2])) ? $req[2] : null;

		$controller_file = 'controller/'.$req[0].'.php';

		if(!file_exists(config::serverpath . $controller_file))
		{
			$controller = new errore('pagina non trovata');
			die();
		}
		require_once($controller_file);

		switch (sizeof($req))
		{
			case 0:
				$controller = new index;
				break;
			case 1:
				$controller = new $req[0];
				break;
			case 2:
				$controller = new $req[0]($req[1]);
				break;
			case 3:
				$controller = new $req[0]($req[1],$req[2]);
				break;
			default:
				$controller = new errore('pagina non trovata');
				break;
		}

		die();
	}

	static function link($controller,$method=null,$param=null)
	{
		$link =	config::basehost . config::basedir .'index.php?request='
				. $controller . '/';
		if($method)	$link .= $method .'/';
		if($param)	$link .= $param . '/';

		return $link;
	}

}

?>
