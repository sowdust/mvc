<?php


class ajax extends controller {

	function __construct($method = null, $param = null)
	{
		switch ($method) {
			case 'check-nick':
				$this->check_nick($param);
				break;
			
			default:
				echo 'ramo default';
				break;
		}
	}

	function check_nick($nick)
	{
		if( null == $nick || strlen($nick)<3 )
		{
			echo 'minore di 3';
		}else{
			echo 'OK';
		}
	}
}

?>