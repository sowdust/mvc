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
		if( null == $nick || !regexp::nick($nick) )
		{
			echo 'lettere, numeri, \'-\', \'_\' da 3 a 16';
		}else{
			echo 'OK';
		}
	}
}

?>