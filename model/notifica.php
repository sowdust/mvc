<?php

class notifica{

	private $tipo;
	private $id_elemento;
	private $data;
	
	public function __construct($tipo,$id_elemento,$data = null)
	{
		$this->tipo = $tipo;
		$this->id_elemento = $id_elemento;
		if(null == $data)
		{
			$data = time();
		}
		$this->data = $data;
	}

	public function testo()
	{
		$testo = $this->tipo;
		switch($this->tipo)
		{
			case 'amicizia-richiesta':
				$testo = 'Hai ricevuto una richiesta di amicizia'
					.'Clicca <a href="profilo_utente.php?id='.$this->id_elemento.'">QUI</a>'
					.'Per vedere l&acute;utente che ne ha fatto richiesta.<br />'
					.'<a href="amicizia.php?id='.$this->id_elemento.'&op=accetta">Accetta</a> - '
					.'<a href="amicizia.php?id='.$this->id_elemento.'&op=nega">Nega</a>';
				break;
			case 'amicizia-accettata':
				$testo = 'Richiesta di amicizia accettata. <a href="profilo_utente.php?id='.$this->id_elemento.'">'
					.'Guarda il profilo del tuo nuovo amico</a>';
				break;
			case 'amicizia-rimossa':
				$testo = 'Uno dei tuoi amici ti ha eliminato dalla sua lista';
				break;
			case 'amicizia-negata':
				$testo = 'Una tua richiesta di amicizia &egrave; stata negata';
				break;
			default:
				$testo = '';
				break;
		}
		return $testo;
	}

}
