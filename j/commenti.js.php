<?php
require_once('../common/config.php');


define('URL', config::basehost . config::basedir . 'index.php?request=ajax/get-commenti/');
define('URL_ADD_COMM', config::basehost . config::basedir . 'index.php?request=commenti/aggiungi/');

header("Content-type: text/javascript");
?>

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

function comment_form(id,tipo_entita,header)
{       if(header)
{
var quale = document.getElementById('contenuto_commento_header_'+id);
}
else{
var quale = document.getElementById('contenuto_commento_'+id);
}
var id_to_rm = document.getElementById('aggiungi_commento');
if(id_to_rm)
{
id_to_rm.parentNode.removeChild(id_to_rm);
}
var d = document.createElement("div");
d.setAttribute('id',"aggiungi_commento");
var f = document.createElement("form");
f.setAttribute('method',"post");
f.setAttribute('action',"<?php echo URL_ADD_COMM; ?>");
f.setAttribute('id',"aggiungi_commento_"+id);
var i = document.createElement("input");
i.setAttribute('type',"hidden");
i.setAttribute('name',"id_entita");
i.setAttribute('value',id);
var j = document.createElement("input");
j.setAttribute('type',"hidden");
j.setAttribute('name',"tipo_entita");
j.setAttribute('value',tipo_entita);
var r = document.createElement("input");
r.setAttribute("type","hidden");
r.setAttribute("name","redirect");
r.setAttribute("value",window.location.pathname+window.location.search)
var t = document.createElement("textarea");
t.setAttribute('name',"testo");
var s = document.createElement("input");
s.setAttribute('type',"submit");
s.setAttribute('value',"Commenta");
s.setAttribute('name',"commento_inviato");
f.appendChild(i);
f.appendChild(j);
f.appendChild(t);
f.appendChild(r);
f.appendChild(s);
d.appendChild(f);
quale.appendChild(d);
$('#aggiungi_commento').hide().fadeIn();
}


function get_commenti(id)
{
var id_div = 'content_of'+id;

if(document.getElementById(id_div))
{
$('#'+id_div).fadeIn('slow');
return;
}
var url = "<?php echo URL; ?>" + id;
xhrObj.open("GET", url, false);
xhrObj.onreadystatechange = function() { add_commenti(id); };
xhrObj.send(null);

}


function nascondi(id)
{
document.getElementById(id).style.display='none';
}

function visibile(id)
{
document.getElementById(id).style.display='inline';
}

function add_commenti(id)
{

/*	var id_more = 'more_'+id;
var id_less = 'less_'+id;
$('#'+id_less).fadeIn();
$('#'+id_more).fadeOut();
*/
if(xhrObj.readyState == 4)
{
var id_div = "commento_"+id;
var to_add = '<div id="content_of' + id + '">';
    to_add += xhrObj.responseText;
    to_add += '</div>';
document.getElementById(id_div).innerHTML += to_add;
$('#content_of'+id).hide().fadeIn();
}
//	alert(xhrObj.readyState + ' ' + 'id: '+id+' '+ xhrObj.responseText);
}

function less(id)
{
var id_div = 'content_of'+id;
$('#'+id_div).fadeOut();
/*
var id_more = 'more_'+id;
var id_less = 'less_'+id;
$('#'+id_more).fadeIn();
$('#'+id_less).fadeOut();
*/
}

/*function callServerCity(c) {
var url = "getCap.php?city="+c;
xhrObj.open("GET", url, true);
xhrObj.onreadystatechange = updatePage;
xhrObj.send(null);
}
function updatePage() {
if (xhrObj.readyState == 4) {
var risp = xhrObj.responseText;
document.getElementById("cap").value = risp;
}
}



*/