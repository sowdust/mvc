<p>
	Ordina i risultati cliccando sull&acute;intestazione delle tabelle.
</p>
<?php

$risultati = $this->model->get_results();

if( 0 == sizeof($risultati))
{
	echo '<span class="errore">Nessun risultato trovato</span>';
	return ;
}

echo '<table class="sortable">';
switch($_POST['table'])
{
	case 'commenti':
		echo '<tr>'
			.'<th>preview</th>' 
			.'<th>data</th>'
			.'<th>autore</th>'
			.'<th>link vari</th>'
			.'</tr>'."\n";
		foreach($risultati as $r)
		{
			$autore = new user($this->db,$r['id_utente']);
			echo '<tr>'
				.'<td>'.htmlentities($r['testo']).'</td>'
				.'<td>'.$r['data'].'</td>'
				.'<td><a href="'.init::link('utenti','vedi',$r['id_utente']).'">'.$autore->get_info()['nick'].'</a></td>'
				.'<td>'
				.' <a href="'.init::link('commenti','vedi',$r['id']).'" class="nohover"><img src="'.config::icons.'lens.png" " class="icon" alt="details" /></a>';
				if($r['id_utente'] == $this->user->get_id() || $this->user->get_type()>0 )
				{
					echo ' <a href="'.init::link('commenti','rimuovi',$r['id']).'" class="nohover"><img src="'.config::icons.'rimuovi.png" " class="icon" alt="rimuovi" /></a>';

				}
				echo '</td>'
				.'</tr>';	
		}
		break;
	case 'luoghi':
		echo '<tr>'
			.'<th>indirizzo</th>'
			.'<th>citta</th>'
			.'<th>prov</th>'
			.'<th>stato</th>'
			.'<th>data</th>'
			.'<th>autore</th>'
			.'<th>link vari</th>'
			.'</tr>';
		foreach($risultati as $r)
		{
			$autore = new user($this->db,$r['id_utente']);
			echo '<tr>'
				.'<td>'.htmlentities($r['indirizzo']).'</td>'
				.'<td>'.htmlentities($r['citta']).'</td>'
				.'<td>'.htmlentities($r['prov']).'</td>'
				.'<td>'.htmlentities($r['stato']).'</td>'
				.'<td>'.$r['data'].'</td>'
				.'<td><a href="'.init::link('utenti','vedi',$r['id_utente']).'">'.$autore->get_info()['nick'].'</a></td>'
				.'<td>'
				.' <a href="'.init::link('luoghi','vedi',$r['id']).'" class="nohover"><img src="'.config::icons.'lens.png" " class="icon" alt="details" /></a>';
				if($r['id_utente'] == $this->user->get_id() || $this->user->get_type()>0 )
				{
					echo ' <a href="'.init::link('luoghi','rimuovi',$r['id']).'" class="nohover"><img src="'.config::icons.'rimuovi.png" " class="icon" alt="rimuovi" /></a>';
				}
				echo '</td>'
				.'</tr>';	
		}
		break;
	case 'utenti':
		require_once('model/amicizia.php');
		echo '<tr>'
			.'<th>Nome</th>'
			.'<th>link vari</th>'
			.'</tr>';
		foreach($risultati as $r)
		{
			$amicizia = new amicizia($this->db,$this->user->get_id(),$r['id']);
			$amici = $amicizia->check();

			echo '<tr>'
				.'<td>'.htmlentities($r['nick']).'</td>'
				.'<td>';
				if($amici || $r['id'] == $this->user->get_id())
				{
					echo ' <a href="'.init::link('utenti','vedi',$r['id']).'" class="nohover"><img src="'.config::icons.'lens.png" " class="icon" alt="details" /></a>';
				}
				if(!$amici && !$amicizia->is_pending() && $r['id'] != $this->user->get_id()){

					echo ' <a href="'.init::link('amicizie','richiedi',$r['id']).'" class="nohover"><img src="'.config::icons.'friend.png" " class="icon" alt="Richiedi Amicizia!" /></a>';

				}
				if($amicizia->is_pending())
				{
					echo ' <a href="'.init::link('utenti','vedi_limitato',$r['id']).'" class="nohover"><img src="'.config::icons.'lens.png" " class="icon" alt="details" /></a>';
				}
				if($this->user->get_type()>0 )
				{
					echo ' <a href="'.init::link('utenti','rimuovi',$r['id']).'" class="nohover"><img src="'.config::icons.'rimuovi.png" " class="icon" alt="rimuovi" /></a>';
					echo ' <a href="'.init::link('utenti','modifica',$r['id']).'" class="nohover"><img src="'.config::icons.'scrivi.png" " class="icon" alt="modifica" /></a>';
				}
				echo '</td>'
				.'</tr>';	
		}
		break;
	case 'opere':
		echo '<tr>'
			.'<th>titolo</th>'
			.'<th>autore</th>'
			.'<th>isbn</th>'
			.'<th>utente</th>'
			.'<th>data</th>'
			.'<th>link vari</th>'
			.'</tr>';
		foreach($risultati as $r)
		{
			echo '<tr>'
				.'<td>'.htmlentities($r['titolo']).'</td>'
				.'<td>'.htmlentities($r['autore']).'</td>'
				.'<td>'.htmlentities($r['isbn']).'</td>'
				.'<td>'.$r['data'].'</td>'
				.'<td>'.$r['id_utente'].'</td>'
				.'<td>links</td>'
				.'</tr>';	
		}
		break;
	default:
		die();
		break;

}
echo '</table>';


?>