// variabile globale che mantiene l'immagine selezionata al momento
var cookie_separator = "<br />";
var immagine_corrente;

//	flag per non chiamare due volte aggiungi_commento
var	flag = false;

//	impostiamo il form dei commenti alle immagini aggiungendo gli eventi
//	onkeydown(enter) e onsubmit
// document.getElementById("form_gallery").onsubmit = function () {
// 	if(!flag)
// 	{
// 		flag = true;
// 		aggiungi_commento();
// 	}
// }
//	in reatla' questo e' superfluo visto che il commento e' in una textarea
//	e non piu' input text
document.getElementById("commento_foto").onkeydown = function (event) {
	var key = event.keyCode || event.charCode || event.which;
	if (key == 13 && !flag) {
		flag = true;
		aggiungi_commento();
	}
};


//	prende dal testo nella textarea e dalla var immagine_corrente i valori
//	da mettere nel cookie (risp valore e nome)
function aggiungi_commento()
{
	var nome_cookie = "imm_"+immagine_corrente;
	var previous = getCookie(nome_cookie);
	if (previous==null) previous = "";
	var commento = previous + cookie_separator + document.getElementById("commento_foto").value;

	setCookie(nome_cookie,commento,2);
}

//	crea il div popup oscurando il resto della pagina e selezionando
//	la giusta immagine da un'altra cartella (ie a diversa risoluzione)
function apri(which,numero_immagini)
{

	// gestiamo i casi estemi (next su ultima e prev su prima immagine)
	if(which>=numero_immagini)
		which=0;
	if(which<0)
		which=numero_immagini-1;
	immagine_corrente=which;
	var id_imm = window.id_immagine[which];


	// numero di immagini prima delle mappe (costante)
	var imbf = 3;
	// numero di paragrafi prima delle rispettive descrizioni (costante)
	var pbf = 1;

	// facciamo apparire il "pop up"
	document.getElementById("immagine_centrale").style.visibility="visible";

	// oscuriamo il resto della pagina e la portiamo subito sotto al popup
	// (gentilmente con transition)
	document.getElementById("ombra_nera").style.opacity="0.9";
	document.getElementById("ombra_nera").style.zIndex="999"

	// aggiungiamo sotto l'immagine una descrizione presa dal paragrafo sotto
	var id_che_serve = "desc_"+which;
	document.getElementById("descrizione_gallery").innerHTML =
		document.getElementByTagId(id_che_serve).innerHTML;

	// mettiamo la stessa immagine ma da un'altra cartella
	document.getElementById("imm_grande").src =
			document.images[which+imbf].src.replace(".thumb","");

	// impostiamo il titolo preso dall'attributo alt dell'immagine
	document.getElementById("titolo_gallery").innerHTML =
						document.images[which+imbf].alt;

	// impostiamo l'alt dell'immagine grande
	document.getElementById("imm_grande").alt =
						document.images[which+imbf].alt;

	// aggiungiamo come campo al form commenti nascosto il nome del cookie
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "id");
	hiddenField.setAttribute("value", id_imm);
 	document.getElementById("form_gallery").appendChild(hiddenField);

	if document.getElementById("form_gallery").normalize
	{
		document.getElementById("form_gallery").normalize();
	}
//
// 	// modifichiamo l'action URL cosi' che il messaggio non vada perso
// 	document.getElementById("form_gallery").action
// 		= "mappe.html"+"?stato="+messaggio;
//
// 	// se c'e', preleviamo il cookie per questa immagine
// 	var nome_cookie = document.getElementsByName("cookie_name")[0].value;
// 	var cookie = getCookie("imm_"+which).replace("||","<br />");

	// e aggiungiamo il valore del cookie sotto al form per il commento
	var div_da_prendere = "commenti_" + (which);
	document.getElementById("commenti_gallery").innerHTML = document.getElementById(div_da_prendere).innerHTML ;

// navigazione con le frecce da tastiera
	document.onkeydown = function(event) {
		if(!flag_gallery)
		{
			var key = event.keyCode || event.charCode || event.which ;
			if(key == 39)	next(which,numero_immagini);
			if(key == 37)	previous(which,numero_immagini);
		}
	}
	window.onkeydown = document.onkeypress;
	flag_gallery=false;

}

function chiudi()
{
	document.getElementById("immagine_centrale").style.visibility="hidden";
	document.getElementById("ombra_nera").style.opacity="0";
	document.getElementById("ombra_nera").style.zIndex="-99";
	document.onkeydown = null;
	window.onkeydown = null;

}

function next(which,numero_immagini)
{
	apri(which+1,numero_immagini);
}

function previous(which,numero_immagini)
{
	apri(which-1,numero_immagini);
}

//	funzioni per gestire i cookie con javascript
//	http://www.w3schools.com/js/js_cookies.asp
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1)
	{
		c_start = c_value.indexOf(c_name + "=");
	}
	if (c_start == -1)
	{
		c_value = null;
	}
	else
	{
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1)
		{
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
	}
	return c_value;
}
