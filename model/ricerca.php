<?php

class ricerca {
//	VARIABILI DI CLASSE
	/*	tabelle alle quali e' limitata la ricerca */
	static $tabelle;
	/*	tipo dei campi per ogni tabella (per prepared stmt)
	 *	implicita dichiarazione dei campi ai quali e' limitata
	 *	la ricerca
	*/
	static $tipi;
	/*	tabella delle diverse query da richiamare per ogni
	 *	tabella del db */

//	VARIABILI D'ISTANZA
	protected $db;
	protected $table;
	protected $parameters;
	protected $values;
	protected $start;
	protected $offset;
	protected $order_by;
	protected $reverse;
	protected $query;

	public static function get_tabelle()
	{
		return array('commenti','opere','luoghi','utenti');
	}

	public static function get_tipi()
	{
		$tipi = array();
		$tipi['commenti']['testo']='s';
		$tipi['commenti']['id_utente']='i';
		$tipi['opere']['autore']='s';
		$tipi['opere']['titolo']='s';
		$tipi['opere']['isbn']='s';
		$tipi['luoghi']['indirizzo']='s';
		$tipi['luoghi']['citta']='s';
		$tipi['luoghi']['stato']='s';
		$tipi['luoghi']['prov']='s';
		$tipi['utenti']['nick']='s';
		return $tipi;
	}

	public static function get_campi($table)
	{
		if(null == self::$tipi)
		{
			self::$tipi = self::get_tipi();
		}
		$count = 0;
		$r = array();
		foreach(self::$tipi[$table] as $k=>$v)
		{
			$r[$count++] = $k;
		}
		return $r;
	}

	public static function get_tipo($table,$campo)
	{
		if(null == self::$tipi)
		{
			self::$tipi = self::get_tipi();
		}
		return self::$tipi[$table][$campo];
	}

	private static function get_table_query($table)
	{
		switch($table)
		{
			case 'utenti':
				return 'SELECT id, type, nick FROM utenti';
				break;
			case 'commenti':
				return 'SELECT id, id_entita, tipo_entita, id_utente, DATE_FORMAT(data,"%d %b %Y %T") as data, testo FROM commenti';
				break;
			case 'opere':
				return 'SELECT id, isbn, autore, titolo, id_utente, DATE_FORMAT(data,"%d %b %Y %T") as data FROM opere';
				break;
			case 'luoghi':
				return 'SELECT id, id_entita, tipo_entita, id_utente, indirizzo, citta, prov, stato, DATE_FORMAT(data,"%d %b %Y %T") as data FROM luoghi';
				break;
			default:
				die('1');
				break;
		}
	}

	function __construct($db,$table,$parameters,$values,
		$start=0,$offset=20,$order_by='',$reverse=false)
	{
		// php non permette di inizializzare array statici 
		// dalla classe quindi dobbiamo farlo qui
		self::$tabelle = self::get_tabelle();
		// whitelist tabella
		if(!in_array($table,self::$tabelle))
		{
			die('2');
		}
		self::$tipi = self::get_tipi();

		// ora controlliamo input dal costruttore
		if(sizeof($parameters) != sizeof($values))
		{
			die('3');
		}
		// whitelist campi e tipo valori
		foreach($parameters as $count=>$p)
		{
			if(!in_array($p,self::get_campi($table)))
			{
				die('4');
			}
			if(self::$tipi[$table][$p] == 's'
				&& !regexp::testo($values[$count]) )
			{
				die('5');
			}
			if(self::$tipi[$table][$p] == 'i'
				&& (!is_numeric($values[$count]) && $values[$count]!=''))
			{
				die('6');
			}
		}

		foreach($values as $i=>$v)
		{
			if($v!='')
			{
				$this->parameters[$i] = $parameters[$i];
				$this->values[$i] = $v;
			}
		}
		$this->db = $db->mysqli;
		$this->table = $table;
		$this->start = $start;
		$this->offset = $offset;
		$this->order_by = $order_by;
		$this->reverse = $reverse;
		$this->query = '';
	}

	function get_query()
	{
		return $this->query;
	}
	// simula mysqli::stmt::prepare() e bind_param()
	function prepare_query()
	{
		$q = self::get_table_query($this->table);
		if(sizeof($this->values))
		{
			$q .= ' WHERE ';
			$check = false;
			foreach($this->parameters as $count => $p)
			{
				$v = $this->values[$count];
				if(self::$tipi[$this->table][$p]=='s')
				{
					$v = str_replace('*','%',$v);
					if($check)
					{
						$q.= ' AND';
					}
					$q .= ' '.$p.' LIKE "'.$v.'"';
					$q .= ' OR '.$p.' = "'.$v.'"';
					$check = true;
				}elseif(self::$tipi[$this->table][$p]=='i')
				{
					if($check)
					{
						$q .= ' AND';
					}
					$q .=' '.$p.' = '.(int)$v;
					$check = true;
				}
			}
		}
		if($this->order_by!='')
		{
			$q.=' ORDER BY (?)';
			if($this->reverse)
			{
				$q.=' DESC';
			}
		}
		$q .= ' LIMIT '.$this->start.','.$this->offset;

		$this->query = $q;
	}

	function get_results()
	{
		$r = $this->db->query($this->query) or die($this->db->error.'7');
		$ret = array();
		while($c = $r->fetch_assoc())
		{
			$ret[] = $c;			
		}
		return $ret;
	}
	
}


?>
