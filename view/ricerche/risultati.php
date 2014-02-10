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
			echo '<tr>'
				.'<td>'.htmlentities($r['testo']).'</td>'
				.'<td>'.$r['data'].'</td>'
				.'<td>'.$r['id_utente'].'</td>'
				.'<td>links</td>'
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
			echo '<tr>'
				.'<td>'.htmlentities($r['indirizzo']).'</td>'
				.'<td>'.htmlentities($r['citta']).'</td>'
				.'<td>'.htmlentities($r['prov']).'</td>'
				.'<td>'.htmlentities($r['stato']).'</td>'
				.'<td>'.$r['data'].'</td>'
				.'<td>'.$r['id_utente'].'</td>'
				.'<td>links</td>'
				.'</tr>';	
		}
		break;
	case 'utenti':
		echo '<tr>'
			.'<th>Nome</th>'
			.'<th>link vari</th>'
			.'</tr>';
		foreach($risultati as $r)
		{
			echo '<tr>'
				.'<td>'.htmlentities($r['nick']).'</td>'
				.'<td>links</td>'
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