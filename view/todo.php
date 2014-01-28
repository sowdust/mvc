<?php

// stampa la variabile $msg_string che arriva da sopra
// per errorie usare view/errore.php


?>


<pre>

*****	RICORDARSI CHE CI SONO	*****



28:12	reti
14:21	prog

		- MFI : almeno 20 giorni	-----	-----
		- RETI: almeno 25 giorni	29 gen	13 feb
		- NOWC:	almeno 5 giorni
		- PROG: almeno 10 giorni	31 gen	21 feb
		- STAT: almeno 7 giorni		28 gen	19 feb
		- TWEB: almeno 3 giorni		27 gen	 7 feb

PHP:

cambiare organizzazione:
le costanti vanno messe in una classe poi estesa dalle altre
utilizzando la sintassi constants::nome_cost


AGGIORNAMENTI:
dopo ogni inserimento fare $user->add_aggiornamento(tipo);

NOTIFICHE:
vedere se si possono mettere delle notifiche qua e la'


OPERE:


LUOGHI:


COMMENTI:

	* colori contenuto in base a profondita'
		(e.g. div div div : )
	* mettere solo il bottone show/less e non entrambi
		(basta fare in modo che cambi la classe 
		del link id="link_id_tal-tei-tali"
	* possibilita a utente e admin di rimuoverli (magari da pagina a parte)
		o tramite richiesta ajax al server
	* invece di includere la view fare link a funzione javascript
		oppure usare quello che c'e' gia' ma aggiungere come parametro tipo_entita
	! fare in modo che si possano rimuovere 

RICERCA 

fare una ricerca universale tramite i prepared stmts e switch
fare i div che si caricano (eventualmente ajax)
e scorrere fra i risultati volendo con richieste ajax
eventualmente con ajax fare suggerimento parole

fare tabelle ordinabili tramite:
http://www.kryogenix.org/code/browser/sorttable/

CONTROLLI (ajax)

tramite un js incluso nella pagina, aggiungere a tutti i form
un event handler per onsubmit()
	function check_input()
che richiama uno script php che prende tutto l'input $_POST e $_GET
e se lo trova scorretto apre un div di errore segnalando l'errore
altrimenti invia l'input dove deve andare

	* controlli user input etc
	* se c'e' tempo controlli di AI su input:wq
	* quando uno carica una mappa controllare se esite!!!
	* notifiche	

** STILE E GRAFICA **
	* magari fare pure il caricamento a scroll che appare dal basso
	* magari no



RELAZIONE

spiegare che e' voluto l'avere piu' luoghi uguali per opere diverse
occupano pochissimo spazio ed e' possibile separare i commenti da un'opera  a un'altra
(non ha senso mischiare commenti a la roma del debello gallico con una del 2013 in ho voglia di te)


dire anche che i vari manager non memorizzano gli oggetti ma solo array associativi per convenienza
di spazio e efficienza
</pre>



<?php

include_once('include/footer.php');
die();
?>
