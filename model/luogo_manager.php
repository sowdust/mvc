<?php

class luogo_manager {
	
	private $luoghi;
	private $db;

	public function lista_luoghi()
	{
		return $this->luoghi;
	}

	public function __construct($db)
	{
		$this->db = $db->mysqli;
		$this->luoghi = $this->refresh_luoghi();
	}

	public function string_to_lat_lng($strin)
	{
		$string = str_replace('(','',$strin);
		$string = str_replace(')','',$string);
		$coords = explode(',',$string);
		if(	(sizeof($coords) == 2 )
			&& is_numeric($coords[0])
			&& is_numeric($coords[1]))
		{
			return $coords;
		}
		die('coordinate non valide '.$strin);
	}

	public function get_address($lat,$lng)
	{
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=';
		$url.= $lat.$lng;
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
				.'uso delle API di Google.';
			include_once('../view/errore.php');
			die();
		}
		return $data['results'][0]['formatted_address'];
	}


	private function refresh_luoghi($id_entita = null, $tipo_entita = null)
	{
		if(null == $id_entita || null == $tipo_entita)
		{
			// questa e' la query usata dall'admin (solo lui vede lista completa
			// dei luoghi tutta in una) quindi i piu' recenti meglio che siano prima
			$tq = 'SELECT id,lat,lng,id_entita,tipo_entita,date_format(data,"%b %d %Y %h:%i %p"),indirizzo,citta,prov,stato,id_utente FROM luoghi ORDER BY data desc';
			$q = $this->db->prepare($tq);
		}else{
			$tq = 'SELECT id,lat,lng,id_entita,tipo_entita,date_format(data,"%b %d %Y %h:%i %p"),indirizzo,citta,prov,stato,id_utente FROM luoghi WHERE id_entita = (?) AND tipo_entita = (?) ORDER BY data DESC';
			$q = $this->db->prepare($tq);
			$q->bind_param('is',$id_entita,$tipo_entita);
		}
		$q->execute() or die();
		$lat = $id = $lng = $id_entita = $data = $tipo_entita = $indirizzo = $citta = $prov = $stato = $id_utente = null;
		$q->bind_result($id,$lat,$lng,$id_entita,$tipo_entita,$data,$indirizzo,$citta,$prov,$stato,$id_utente);
		$count = 0;
		$luoghi = array();
		while($q->fetch())
		{
			$luoghi[$count]['id'] = $id;
			$luoghi[$count]['lat'] = $lat;
			$luoghi[$count]['lng'] = $lng;
			$luoghi[$count]['id_entita'] = $id_entita;
			$luoghi[$count]['data'] = $data;
			$luoghi[$count]['indirizzo'] = $indirizzo;
			$luoghi[$count]['citta'] = $citta;
			$luoghi[$count]['prov'] = $prov;
			$luoghi[$count]['stato'] = $stato;
			$luoghi[$count]['data'] = $data;
			$luoghi[$count]['id_utente'] = $id_utente;
			++$count;
		}

		return $luoghi;
	}

	public function add_luogo($coords,$id_utente,$id_entita,$tipo_entita,$indirizzo,$citta,$prov,$stato)
	{
		if(!regexp::entita($tipo_entita) && $tipo_entita!=null) die ('entita non valida');
		$coordinate = $this->string_to_lat_lng($coords);
		$lat = $coordinate[0];
		$lng = $coordinate[1];

		if(!is_numeric($id_utente) || !(is_numeric($id_entita) || $id_entita==null) )
		{
			die();
		}

		$q = $this->db->prepare('INSERT INTO luoghi (id_utente,lat,lng,id_entita,tipo_entita,indirizzo,citta,prov,stato,data)
			VALUES ( (?),(?),(?),(?), (?), (?), (?), (?), (?), now() )');
		$q->bind_param('iddisssss',$id_utente,$lat,$lng,$id_entita,$tipo_entita,$indirizzo, $citta,$prov, $stato);
		if(!$q->execute())
		{
			$msg_errore = 'inserimento fallito'.$this->db->error;
			include('../view/errore.php');
			die();
		}
		$q->close();
	}

	public function remove_luogo($id_luogo,$tipo_entita = null)
	{
		if(null == $tipo_entita)
		{
			$q = $this->db->prepare("DELETE FROM luoghi WHERE id = (?)");
			$q->bind_param('i',$id_luogo);
		} else {
			$q = $this->db->prepare("DELETE FROM luoghi WHERE id_entita = (?) AND tipo_entita = (?) ");
			$q->bind_param('i',$id_luogo,$tipo_entita);
		}
		$q->execute() or die ('cancellazione non riuscita');
		$q->close();
	}

}
