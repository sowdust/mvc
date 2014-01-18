//	set up per ajax
$(document).ready(function(){ 
;							   
//		$("div").css("border", "3px solid red");
			
});

function setXMLHttpRequest() {
	var xhr = null;
	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xhr;
}

var xhrObj = setXMLHttpRequest();

// nella ricerca, carica il numero giusto di campi e parametri
// ajax "old-style"
function ricerca_get_param()
{
	var tab = document.getElementById('ricerca_tabelle').value;
	if( '' == tab )
	{
		$('ricerca_campi').html('Seleziona una tabella');
		return ;
	}

	url = '../ajax/ricerca_get_campi.php?tabella='
		+ encodeURIComponent(tab);

	xhrObj.open("GET", url, false);
	xhrObj.send(null);

	if(xhrObj.readyState == 4)
	{
		var div = document.getElementById('ricerca_campi');
		div.innerHTML = xhrObj.responseText;
	}else{
		alert('errore '+xhrObj.readyState);
	}
	
}
		  

/**
	GESTIONE DELLO STATUS: per non dover usare i cookie, la gestione dello
	stato e' gestita con un parametro passato via GET di pagina in pagina,
	modificabile tramite l'apposito form (che e' allo stesso tempo anche
	la barra in cui viene visualizzato).
	Per fare questo e' stato necessario rimuovere i tag href da tutti i link
	di navigazione e aggiungere un evento onclick che spedisse il contenuto
	del form
**/

var links = document.getElementsByTagName("a");

//	il messaggio e' memorizzato nel parametro 'stato' dell'url
var messaggio = getURLParameter("stato");

//	flag per non chiamare due volte l'aggiornamento dello stato
var chiamata = 0;

//	se messaggio nullo impostiamo a default
if(messaggio.length < 1 || messaggio == "null")	
	messaggio="scrivi un messaggio di stato...";

//	impostiamo i valori del form 
document.getElementById("cambia_stato").action = document.URL;
document.getElementById("frase_stato").value = 	messaggio;

//	se premuto enter (13) viene fatto il controllo dell'input e, se valido,
//	salvato nella variabile messaggio, che viene poi passata di pagina 
//	in pagina
document.getElementById("frase_stato").onkeydown = function (event) {
	var key = event.keyCode || event.charCode || event.which;
	if (key == 13 && chiamata == 0) {
		chiamata=1;
		check_stato();
	}
};
document.getElementById("cambia_stato").onsubmit = function () {
	if (chiamata == 0) {
		chiamata=1;
		check_stato();
	}
};
document.getElementById("frase_stato").onblur = function () {
	if (chiamata == 0) {
		chiamata=1;
		check_stato();
	}
};

//	modifichiamo tutti i link di navigazione in modo che non abbiano
//	attributo href e mandino ogni volta una richiesta via get (tramite
//	la funcione hhref)
for(l=0; l<links.length; ++l) 
{
	if(links[l].className=="menu")
	{
		links[l].url = links[l].href; 
		links[l].messaggio = messaggio
   		links[l].onclick =function (){
			hhref(this.url,this.messaggio);
		};                                                                        
		links[l].removeAttribute("href");
	}
}         


function formReset()
{
	document.getElementById("cambia_stato").reset();
}

//	inutilizzata
function setMessaggio()
{
	document.getElementById("frase_stato").value = ""; // messaggio;
}

//	espressione regolare trovata in rete che decodifica il valore
//	di un parametri dell'url
function getURLParameter(name) {
	return decodeURIComponent(
		(RegExp(name + '=' +
			'(.+?)(&|$)').exec(location.search)||[,null])[1]
		).replace(/\+/g," ");
}

//	controlla che il messaggio di stato non contenga caratteri illegale
//	se passa il controllo, salva il messaggio, altrimenti alert
function check_stato()
{
	var old_m = messaggio;
	var m = document.getElementById("frase_stato").value;

	var proibiti = new Array( "|", "+", "--", "=", "<", ">", "!=", "(", ")",
		"%", "*");
		
	// riassunto degli errori
	var s="";
	var errori = 0;

	for(i=0; i < proibiti.length; ++i)
	{
		if(m.indexOf(proibiti[i]) != -1 || decodeURIComponent(m).indexOf(proibiti[i]) != -1)
		{
			++errori;
			s += " " + proibiti[i];
		}
	}
	
	if(errori>0)
	{
		s += " non ammessi";
		s = "Caratteri" + s;
	}
	
	if( m.length>140 )
	{
		s+= "\n Le dimensioni dovrebbero essere comrpese tra 0 e 140 caratteri";
		s = "ERRORE!" + s;
		++errori;
	}
	
	if( errori == 0)
	{
		messaggio = m;
	}
	else
	{
		messaggio = old_m;
		document.getElementById("frase_stato").value = old_m;
		alert(s);
	}
	chiamata = 1;
	
}

//	funzione che crea un form get contenente il messaggio come campo
//	nascosto e lo invia via get ogni volta che viene cliccato un link
//	del menu di navigazione (che non ha piu' campo href)
function hhref(url, messaggio) 
{
	// creiamo un form 
	var stato = document.createElement("form");
	stato.setAttribute("method", "get");
	stato.setAttribute("action", url);

	// e gli aggiungiamo un campo nascosto con il messaggio
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "stato");
	hiddenField.setAttribute("value", messaggio);

	stato.appendChild(hiddenField);
	document.body.appendChild(stato);
	
	stato.submit();
}
