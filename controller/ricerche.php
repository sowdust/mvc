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
				$this->show_risultati();
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

	function show_risultati()
	{
		$lista_tabelle = ricerca::get_tabelle();

		if(!isset($_POST['table']) || !in_array($_POST['table'],$lista_tabelle))
		{
			$this->set_view('errore');
			$this->view->set_message('tabella non valida');
			$this->view->render();
			die();
		}


		$count = 0;
		$parameters = array();
		$values = array();
		foreach($_POST as $k => $v)
		{
			// nel form distinguiamo i parametri di ricerca
			if( strpos($k,'param_') !== false )
			{
				if(!in_array(str_replace('param_','',$k),ricerca::get_campi($_POST['table'])))
				{
					$this->set_view('errore');
					$this->view->set_message( 'Campo non valido: '.str_replace('param_','',$k));
					$this->view->render();
					die();
				}
				$parameters[$count] = str_replace('param_','',$k);
				// controlliamo la validita' dei campi (ripetuto nel model, non si sa mai)
				switch(ricerca::get_tipo($_POST['table'],$parameters[$count]))
				{
					case 'i':
						if(!is_numeric($v) && $v!='')
						{
							$this->set_view('errore');
							$this->view->set_message( 'Campo numerico non valido');
							$this->view->render();
							die();
						}
						break;
					case 's':
						if(!regexp::testo($v))
						{
							$this->set_view('errore');
							$this->view->set_message( 'Campo testo non valido');
							$this->view->render();
							die();
						}
						break;
					default:
						die('opzione non contemplata nel controller ricerca');
						break;
				}
				$values[$count] = $v;
				++ $count;
			}
		}

		$start = (isset($_POST['start']) && is_numeric($_POST['start'])) ? $_POST['start'] : 0;
		$offset = (isset($_POST['offset']) && is_numeric($_POST['offset'])) ? $_POST['offset'] : 20;
		$order_by = (isset($_POST['order_by']) && regexp::testo($_POST['order_by'])) ? $_POST['oder_by'] : '';
		$reverse = (isset($_POST['reverse']) && $_POST['reverse'] == 'true') ? true : false;


		$ricerca = new ricerca($this->db,$_POST['table'],$parameters,$values,
			$start,$offset,$order_by,$reverse);

		$ricerca->prepare_query();
		$this->set_view('ricerche','risultati');
		$this->view->set_js('sorttable.js');
		$this->view->set_user($this->user);
		$this->view->set_db($this->db);
		$this->view->set_model($ricerca);
		$this->view->render();
		die();
	}

}

?>