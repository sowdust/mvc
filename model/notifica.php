<?php

require_once('model/user.php');

class notifica{

	private $id;
	private $id_utente;
	private $tipo;
	private $id_elemento;
	private $data;

	public function __construct($db, $id)
	{
		if(!is_numeric($id) || null == $id)
		{
			die();
		}
		$this->id = $id;
		$this->db = ( 'database' == get_class($db) ) ? $db->mysqli : $db;
		$this-> update_info_from_db();

	}

	function rimuovi()
	{
		$q = $this->db->prepare("DELETE FROM notifiche WHERE id = (?)");
		$q->bind_param('i',$this->id);
		$q->execute();
		$q->close();
		unset($q);
	}

	function update_info_from_db()
	{
		$q = $this->db->prepare('SELECT id_utente,tipo,id_elemento,date_format(data,"%e/%m %H:%i") as data FROM notifiche WHERE id = (?) ORDER BY data DESC LIMIT 0,1');
		$q->bind_param('i',$this->id);
		$q->execute() or die('impossibile ottenere lo stato');
		$q->bind_result($this->id_utente,$this->tipo,$this->id_elemento,$this->data);
		$q->fetch();
		$q->close();
		unset($q);
	}

	public function testo()
	{
		$testo = $this->tipo;
		switch($this->tipo)
		{
			case 'amicizia-richiesta':
				$user = new user($this->db, $this->id_elemento);
				$testo = 'Amicizia richiesta da '
					.'<a href="'.init::link('utenti','vedi',$this->id_elemento).'">'.$user->get_info()['nick'].'</a>:'
					.'<a onclick="rimuovi_notifica('.$this->id.');" href="'.init::link('amicizie','accetta',$this->id_elemento).'"><img src="'.config::icons.'ok.png" width="20px" /></a>'
					.'<a onclick="rimuovi_notifica('.$this->id.');" href="'.init::link('amicizie','nega',$this->id_elemento).'"><img src="'.config::icons.'rimuovi.png" width="20px" /></a>';
				break;
			case 'amicizia-accettata':
				$user = new user($this->db, $this->id_elemento);
				$testo = 'Tu e <a href="'.init::link('utenti','vedi',$this->id_elemento).'">'
					.$user->get_info()['nick'].'</a> siete amici. <a href="#"  onclick="rimuovi_notifica('.$this->id.');return false;">OK!</a>';
				break;
			case 'amicizia-rimossa':
				$testo = 'Uno dei tuoi amici ti ha eliminato dalla sua lista';
				break;
			case 'amicizia-negata':
				$user = new user($this->db, $this->id_elemento);
				$testo = $user->get_info()['nick'] . 'ha negato la tua richiesta di amicizia';
				$testo .= '<a href="'.'index.php?'.explode('?',$_SERVER['REQUEST_URI'])[1].'"  onclick="rimuovi_notifica('.$this->id.');return false;">OK!</a>';				
				break;
			default:
				$testo = 'default';
				break;
		}
		return $testo;
	}

}
