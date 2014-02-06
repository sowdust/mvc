<?php

abstract class entita {


	public function get_luoghi($id_entita = null)
	{
		if(null == $id_entita)
		{
			$tq = 'SELECT id,lat,lng,id_entita,tipo_entita,date_format(data,"%b %d %Y %h:%i %p") FROM luoghi WHERE tipo_entita = (?) ORDER BY data desc';
			$q = $this->db->prepare($tq);
			$q->bind_param('s',$this->tipo_entita);
		}else{
			$tq = 'SELECT id,lat,lng,id_entita,tipo_entita,date_format(data,"%b %d %Y %h:%i %p") FROM luoghi WHERE id_entita = (?) AND tipo_entita = (?) ORDER BY data DESC';
			$q = $this->db->prepare($tq);
			$q->bind_param('is',$this->id_entita,$this->tipo_entita);
		}
		$q->execute() or die();
		$lat = $id = $lng = $id_entita = $data = $tipo_entita_temp = null;
		$q->bind_result($id,$lat,$lng,$id_entita,$tipo_entita_temp,$data);
		$count = 0;
		$luoghi = array();
		while($q->fetch())
		{
			$luoghi[$count]['id'] = $id;
			$luoghi[$count]['lat'] = $lat;
			$luoghi[$count]['lng'] = $lng;
			$luoghi[$count]['id_entita'] = $id_entita;
			$luoghi[$count]['data'] = $data;
			$luoghi[$count]['tipo_entita'] = $tipo_entita_temp;
			++$count;
		}
		return $luoghi;
	}

	function get_id()
	{
		return $this->id;
	}

	public function output($string)
	{
		$string = nl2br(htmlentities($string));
		return $string;
	}

	function get_commenti()
	{
		$q = $this->db->prepare('SELECT id FROM commenti WHERE id_entita = (?) AND tipo_entita = (?) order by data asc');
		$q->bind_param('is',$this->id,$this->tipo_entita);
		$t = null;
		$count = 0;
		$chil = array();
		$q->execute() or die();
		$q->bind_result($t);
		while($q->fetch())
		{
			$chil[$count++] = $t;
		}
		return $chil;
	}

	function get_data()
	{
		return $this->data;
	}

}

?>
