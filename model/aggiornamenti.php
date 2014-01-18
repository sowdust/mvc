<?php

class aggiornamenti {
	
	private $id_utente;
	private $db;
	private $stati;
	// stati[n]['data'],stati[n]['testo'],stato[n]['id']

	public function __construct($db,$id_utente)
	{
		$this->db = $db->mysqli;
		$this->id_utente = $id_utente;
		$this->retrieve_stati();
	}

	public function get()
	{
		return $this->stati;
	}

	private function retrieve_stati()
	{
			$q = "SELECT id,stato, date_format(data,'%d/%m/%Y') as data FROM stati WHERE id_utente = \"".$this->id_utente."\" ORDER BY data DESC LIMIT 0,10";
			if(!($r = $this->db->query($q)))
			{
					die('query fallita');
			}
			$count = 0;
			while( $c = $r->fetch_assoc() )
			{
					$this->stati[$count]['data']=$c['data'];
					$this->stati[$count]['testo']=$c['stato'];
					$this->stati[$count]['id']=$c['id'];
					$count++;
			}
	}
}
