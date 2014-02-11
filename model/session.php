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
    private $current_page;
    private $previous_page;

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
        
        function set_current_page($i)
        {
            $this->current_page = $i;
        }
        
        function set_previous_page($i)
        {
            $this->previous_page = $i;
        }
        
        function get_current_page()
        {
            return $this->current_page;
        }        
        function get_previous_page()
        {
            return $this->previous_page;
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
//	non usata
	public function set_redirect($url)
	{
		$_SESSION['redirect'] = ((strpos(config::basehost,$url) == 0 )) ? urlencode($url)
								:	config::basehost.config::basedir;
	}
//	non usata
	public function get_redirect($url)
	{
		return urldecode($_SESSION['redirect']);
	}
//	non usata
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
            // se passata una funzione a bind param ritorna un notice
            $date = $this->start->format('Y-m-d H:i:s.u');
            $q = $this->db->prepare("UPDATE sessioni SET start = (?), current_page = (?) ,previous_page = (?) WHERE id_sessione = (?) ") or die($this->db->error);
            $q->bind_param( 'ssss' , $date, $this->current_page, $this->previous_page, $this->session_id );
			$q->execute();
			$q->close();
		}


	private function new_session()
	{
		$this->secret = md5(time()+$this->_SEED);
		$this->session_id = uniqid("",true);
		$this->start = new DateTime();
		$date = $this->start->format('Y-m-d H:i:s.u');
		$q = $this->db->prepare("INSERT INTO sessioni (id_sessione,id_utente,secret,start,current_page) VALUES ( (?), (?), (?), (?), 'index.php' )");
		$q->bind_param('siss', $this->session_id, $this->user_id, $this->secret, $date );
		$q->execute();

	}
	
	private function get_session_for_user($user_id)
	{
		if(!($q = $this->db->prepare("SELECT id_sessione,secret,start,current_page,previous_page FROM sessioni WHERE id_utente = (?) and start >= DATE_SUB(now(),INTERVAL 30 MINUTE) ORDER BY start DESC LIMIT 0,1")))
			die ("error".$this->db->error);
		$q->bind_param('i',$user_id);
		$q->execute();
		$q->store_result();
		$q->bind_result($this->session_id,$this->secret,$temp,$this->current_page,$this->previous_page);
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
