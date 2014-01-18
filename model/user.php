<?php

require_once('entita.php');

class user extends entita{

	protected $id;
	protected $tipo_entita;
	protected $db;	
	public	$info;
	public $session;

	public function __construct($db,$id)
	{
		$this->tipo_entita = 'utente';
		if(!is_numeric($id)) die();
		$this->id = $id;
		$this->db = $db->mysqli;
		$this->update_info_from_db();
	}

	public function get_id()
	{
		return $this->id;
	}

	public function logout()
	{
		// cancelliamo tutti i record di sessione
		// memorizzati per l'utente
		$q = 'DELETE FROM sessioni WHERE id_utente = "'.$this->info['id'].'"';
		$r = $this->db->query($q) or die();
		unset($_SESSION['sess_data']);
	}
	public function is_friend($id)
	{
		if($id == $this->id)
		{
			return true;
		}
		if($id < $this->id)
		{
			$q = 'SELECT COUNT(*) FROM amicizie WHERE utente_1 = "'.$id.'" AND utente_2 = "'.$this->id.'"';
		}else{
			$q = 'SELECT COUNT(*) FROM amicizie WHERE utente_2 = "'.$id.'" AND utente_1 = "'.$this->id.'"';
		}
		$r = $this->db->query($q) or die ();
		$row = $r->fetch_row();
		return ($row[0] > 0);
	}

	public function set_session($session)
	{
		$this->session = $session;
	}

	public function get_type()
	{
		return $this->info['type'];
	}

	public function get_info()
	{
		return $this->info;
	}
	
	private function update_info_from_db()
	{
		$q = "SELECT * FROM utenti WHERE id = \"".$this->id."\" LIMIT 0,1";
		if(!($r = $this->db->query($q)))
		{
				die("query fallita");
		}
		while($c = $r->fetch_assoc())
		{
			foreach($c as $key => $value)
			{
					$this->info[$key] = $value;
			}
		}
	}

	public function set_info($data)
	{
		$q = "UPDATE utenti SET ";
		foreach($data as $k => $v)
		{
			$q .= $k . "= \"".$v."\",";
		}
		$q = substr($q,0,strlen($q)-1);
		$q .=" WHERE id=\"".$this->id."\"";;
		
		if(!($r = $this->db->query($q)))
		{
			return false;
		}
		return true;
	}

	public function add_aggiormaneto($tipo)
	{
		switch($tipo)
		{
			case 'stato':
				$tabella = 'stati';
				break;
			case 'opera':
				$tabella = 'opere';
				break;
			case 'luogo':
				$tabella = 'luoghi';
				break;
			case 'commento':
				$tabella = 'commenti';
				break;
			default:
				die();
				break;
		}
		$q = 'SELECT id FROM '.$tabelle.' WHERE id_utente = '.$this->user.' ORDER BY data desc';
		$r = $this->db->execute($q);
		$id_entita = null;
		$r->bind_result($id_entita);
		$r->fetch();
		$r->close();
		unset($q);unset($r);
		// non servono i prepared statement, lo switch fa gia' il controllo
		$q = 'INSERT INTO aggiornamenti (id_utente,tipo,id) VALUES ('.$this->id.', "'.$tipo.'", '.$id_entita.')';
		$r = $this->db->execute($q) or die();
		$r->close();
	}

	public function add_stato($stato)
	{
		$id__stato = uniqid("",true);
		$q = $this->db->prepare("INSERT INTO stati (id_utente,stato,data,valido) VALUES ((?), (?), now(), 1)");
		$q->bind_param('is',$this->id,$stato);
		$r = $q->execute() or die ('query fallita');;
		$q->close();
		unset($q);
	
		return $r;
	}

	public function remove_stato($id_stato)
	{
		// remove stato
		if($this->info['type'] == 1)
		{
			$q = $this->db->prepare("DELETE FROM stati WHERE id = (?) ");
			$q->bind_param('s',$id_stato);
		}else{
			$q = $this->db->prepare("DELETE FROM stati WHERE id = (?) and id_utente = (?)");
			$q->bind_param('si',$id_stato,$this->id);
		}
		$q->execute() or die();
		$q->close();
		unset($q);
		// remove aggiornamento
		$q = $this->db->prepare("DELETE FROM aggiornamenti WHERE id = (?) and id_utente = (?)");
		$q->bind_param('si',$id_stato,$this->id);
		$q->execute() or die();
		$q->close();
		unset($q);
		// marca stati come non validi
		$q = $this->db->prepare("UPDATE stati SET valido = 0 WHERE id_utente = (?)");
		$q->bind_param('i',$this->id);
		$q->execute() or die();
		$q->close();
		unset($q);
		return true;
	}

	public function get_stato($id_stato = -1)
	{	// se l'id non e' passato ritorna l'ultimo (corrente)
		$q = $this->db->prepare("SELECT stato FROM stati WHERE id_utente = (?) AND valido = true ORDER BY data DESC LIMIT 0,1");
		$q->bind_param('i',$this->id);
		$q->execute() or die('impossibile ottenere lo stato');
		$q->bind_result($stato);
		$q->fetch();
		$q->close();
		unset($q);
		if(strlen($stato)<1 || !isset($stato))
		{
			$stato='';
		}
		return $stato;
	}

	/* NOTIFICHE */
	public function add_notifica($tipo,$id_elemento)
	{
		$q = $this->db->prepare('INSERT INTO notifiche (id_utente,tipo,id_elemento,data) VALUES ((?),(?),(?),now())');
		$q->bind_param('iss',$this->info['id'],$tipo,$id_elemento);
		$q->execute() or die();
		$q->close();
	}

	public function mark_notifica($id_notifica)
	{
		$q = $this->db->prepare('UPDATE notifiche SET visualizzata = "1" WHERE id_utente = (?) AND id = (?)');
		$q->bind_param('ii',$this->info['id'],$id_notifica);
		$q->execute() or die();
		$q->close();
	}

	public function remove_notifica($id_notifica)
	{
		$q = $this->db->prepare('DELETE FROM notifiche WHERE id_utente = (?) AND id = (?)');
		$q->bind_param('ii',$this->info['id'],$id_notifica);
		$q->execute() or die();
		$q->close();
	}

	public function get_notifiche()
	{
		$q = $this->db->prepare('SELECT id,tipo,id_elemento,date_format(data,"%e/%m %H:%i"),visualizzata FROM notifiche WHERE id_utente = (?) ORDER BY visualizzata ASC, data DESC');
		$q->bind_param('i',$this->info['id']);
		$q->execute() or die();
		$q->store_result() or die();
		$q->bind_result($id,$tipo,$id_el,$data,$vis) or die();
		$r = null;
		$count = 0;
		while($q->fetch())
		{
			$r[$count]['id'] = $id;
			$r[$count]['tipo'] = $tipo;
			$r[$count]['id_elemento'] = $id_el;
			$r[$count]['data'] = $data;
			$r[$count]['visualizzata'] = $vis;
			++$count;
		}
		$q->close();
		unset($q);
		return $r;
	}

}

?>
