<?php

require_once('entita.php');

class luogo extends entita{

	protected $db;
	protected $id;
	protected $tipo_entita;
	private $lat;
	private $lng;
	private $address;
	private $id_utente;
	private $data;
	private $citta;
	private $indirizzo;
	private $prov;
	private $stato;

	public function __construct($db,$id)
	{
		$this->tipo_entita = 'luogo';
		$this->db = ( 'database' == get_class($db) ) ? $db->mysqli : $db;
		$this->id = $id;
		$this->get_info_from_db();
	}

	function get_data()
	{
		return $this->data;
	}

	function get_id()
	{
		return $this->id;
	}
	function get_lat()
	{
		return $this->lat;
	}

	function get_lng()
	{
		return $this->lng;
	}

	function get_google_address()
	{
		$this->get_address();
		return $this->address;
	}

	function get_indirizzo()
	{
		return $this->indirizzo;
	}

	function get_provincia()
	{
		return $this->prov;
	}

	function get_prov()
	{
		return $this->prov;
	}

	function get_citta()
	{
		return $this->citta;
	}

	function get_stato()
	{
		return $this->stato;
	}

	function get_tutto()
	{
		return	 $this->indirizzo . ', '
				.$this->citta . ' '
				.'('.$this->prov.') '
				.$this->stato;
	}

	public function get_info_from_db()
	{
		$q = $this->db->prepare('SELECT id_utente,lat,lng,date_format(data,"%d/%m/%Y"),indirizzo,citta,prov,stato FROM luoghi WHERE id = (?)');
		$q->bind_param('i',$this->id);
		$q->execute() or die();
		$q->bind_result($this->id_utente,$this->lat,$this->lng,$this->data,$this->indirizzo,$this->citta,$this->prov,$this->stato);
		$q->fetch();
		$q->close();
		unset($q);
	}
	public function get_uid()
	{
		return $this->id_utente;
	}
	public function get_address()
	{
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=';
		$url.= $this->lat.','.$this->lng;
		$url.= '&sensor=false';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$page = curl_exec($ch);
		curl_close($ch);
		// true ritorna array associativo invece di object
		$data = json_decode($page,true);
		if($data['status'] != 'OK')
		{
			$msg_errore = 'Si &egrave; verificato un errore nell&acute;'
				.'uso delle API di Google.'.$url;
			include_once('../view/errore.php');
			die();
		}
		$this->address = $data['results'][0]['formatted_address'];
	}

}
