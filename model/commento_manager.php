<?php

class commento_manager {
	
	private $commenti;
	private $db;

	public function lista_commenti()
	{
		return $this->commenti;
	}

	public function __construct($db)
	{
		$this->db = $db->mysqli;
		$this->refresh_commenti();
	}

	public function add_commento($id_utente,$id_entita,$tipo_entita)
	{
		if(!is_entita($tipo_entita)) die ('entita non valida');
		if(!is_numeric($id_utente) || !is_numeric($id_entita))
		{
			die();
		}

		$q = $this->db->prepare('INSERT INTO commenti (id_utente,id_entita,tipo_entita,testo,data)
			VALUES ( (?),(?),(?),(?), now() )');
		$q->bind_param('iiss',$id_utente,$id_entita,$tipo_entita,$testo);
		if(!$q->execute())
		{
			$msg_errore = 'inserimento fallito';
			include('../view/errore.php');
			die();
		}
		$q->close();
	}

	public function remove_commento($id_commento,$tipo_entita = null)
	{
		if(null == $tipo_entita)
		{
			$q = $this->db->prepare("DELETE FROM commenti WHERE id = (?)");
			$q->bind_param('i',$id_commento);
		} else {
			$q = $this->db->prepare("DELETE FROM commenti WHERE id_entita = (?) AND tipo_entita = (?) ");
			$q->bind_param('i',$id_commento,$tipo_entita);
		}
		$q->execute() or die ('cancellazione non riuscita');
		$q->close();
	}

}
