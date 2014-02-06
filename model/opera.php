<?php

require_once('entita.php');

class opera extends entita {

	protected $tipo_entita;
	protected $db;
	protected $id;
	public $titolo;
	public $autore;
	public $anno;
	public $genere;
	public $cover;
	protected $id_utente;
	public $data;

	public function get_uid()
	{
		return $this->id_utente;
	}
	public function get_id()
	{
		return $this->id;
	}
	public function __construct($db,$id)
	{
		$this->tipo_entita = 'opera';
		$this->db = ( 'database' == get_class($db) ) ? $db->mysqli : $db;
		$this->id = $id;
		$this->get_data_from_db();
		$this->get_data_from_api();
	}

	public function get_data_from_db()
	{
		$q = $this->db->prepare('SELECT isbn,id_utente, date_format(data,"%d/%m/%Y") as data FROM opere WHERE id = (?)');
		$q->bind_param('i',$this->id);
		$q->execute() or die();
		$q->bind_result($this->isbn,$this->id_utente,$this->data);
		$q->fetch();
		$q->close();
		unset($q);
	}

	public function get_data_from_api()
	{
		$url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:';
		$url.= $this->isbn;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$page = curl_exec($ch);
		curl_close($ch);
		// true ritorna array associativo invece di object
		$data = json_decode($page,true);
		if($data['totalItems']<1)
		{
			echo 'problema api google';
			return -1;
		}

		$this->autore = '';
		foreach($data['items'][0]['volumeInfo']['authors'] as $v)
		{
			$this->autore .= ($v.', ');
		}
		$this->autore = substr($this->autore,0,strlen($this->autore)-2);
		$this->titolo = $data['items'][0]['volumeInfo']['title'];
		$this->anno = $data['items'][0]['volumeInfo']['publishedDate'];
		$this->cover = '';
		if(isset($data['items'][0]['volumeInfo']['imageLinks']['thumbnail']))
		{
			$this->cover = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
		}
		$this->genere = '';
		foreach($data['items'][0]['volumeInfo']['categories'] as $v)
		{
			$this->genere .= ($v.', ');
		}
		$this->genere = substr($this->genere,0,strlen($this->genere)-2);
	}

}

?>
