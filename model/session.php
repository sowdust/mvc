<?php

// 	session duration set to 30 minutes
// 	TODO: automatically clean sessions table
//	TODO: generate a decently secure seed

class session {

	private $_SEED;
	private $db;
	private $session_id;
	private	$secret;
	private $start;
	private $user_id;

	function __construct($db,$user_id)
	{
		$this->_SEED = time();
		$this->db = $db->mysqli;
		$this->user_id = $user_id;
		if( ! $this->get_session_for_user($this->user_id))
		{
			// CREATE NEW SESSION
			$this->new_session();
		}
		else
		{
			// REFRESH  THIS SESSION
			$this->refresh();
		}
	}

	public static function get_user_type_and_id($db,$nick,$pass)
	{
		$i = array('id'=> -1, 'type' => -2);
		$pass_hash = md5($pass);
		$q = $db->mysqli->prepare("SELECT id,type FROM utenti WHERE nick=(?) and pass_hash=(?)") or die();
		$q->bind_param('ss',$nick,$pass_hash) or die();
		$q->execute();
		$q->store_result();
		$q->bind_result($i['id'],$i['type']);
		$q->fetch();

		return $i;
	}

	public function remove()
	{
		$r = $this->db->query("DELETE FROM sessioni WHERE id_sessione = \"".$this->session_id."\"") or die();
		unset($_SESSION['sess_data']);
	}

	public function set_redirect($url)
	{
		$_SESSION['redirect'] = ((strpos(config::basehost,$url) == 0 )) ? urlencode($url)
								:	config::basehost.config::basedir;
	}

	public function get_redirect($url)
	{
		return urldecode($_SESSION['redirect']);
	}

	public function unset_redirect()
	{
		unset($_SESSION['redirect']);
	}

	public function set_db($db)
	{
		$this->db = $db;
	}

	public function get_id()
	{
		return $this->session_id;
	}

	public function get_user_id()
	{
		return $this->user_id;
	}
	public function refresh()
	{
		$this->start->setTimestamp(time());
		$this->db->query("UPDATE sessioni SET start = \"".$this->start->format('Y-m-d H:i:s.u')."\" WHERE id_sessione = \"".$this->session_id."\"") or die($this->db->error);
	}

	private function new_session()
	{
		$this->secret = md5(time()+$this->_SEED);
		$this->session_id = uniqid("",true);
		$this->start = new DateTime();
		$r = $this->db->query("INSERT INTO sessioni (id_sessione,id_utente,secret,start) VALUES ( \"".$this->session_id." \",  \"".$this->user_id." \", \"".$this->secret." \", \"" . $this->start->format('Y-m-d H:i:s.u') . "\")") or die ("errore insert");

	}
	
	private function get_session_for_user($user_id)
	{
		if(!($q = $this->db->prepare("SELECT id_sessione,secret,start FROM sessioni WHERE id_utente = (?) and start >= DATE_SUB(now(),INTERVAL 30 MINUTE) ORDER BY start DESC LIMIT 0,1"))) die ("error".$this->db->error);
		$q->bind_param('i',$user_id);
		$q->execute();
		$q->store_result();
		$q->bind_result($this->session_id,$this->secret,$temp);
		$this->start = new DateTime($temp);
		$q->fetch();
		if($this->db->affected_rows)
		{
			$return = true;
		}else{
			$return = false;
		}
		$q->close();

		return $return;

	}

	
}


?>
