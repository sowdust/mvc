<?php

require_once('../common/config.php');


define('URL',config::basehost.config::basedir.'index.php?request=ajax/');

header("Content-type: text/javascript"); ?>

var errori_form = 0;
var capi_obbligatori = 0;

function valida(elemento,funzione)
{
	var url = "<?php echo URL; ?>" + funzione + '/' + elemento.value;
	$.get(url,function(data,status){
		if('OK' == data)
		{
			$(elemento).removeClass("notok");
			$(elemento).addClass("ok");
			$("#errori-" + elemento.id).html('');

		}else{

			// remove class ok
			$(elemento).removeClass("ok");
			$(elemento).addClass("notok");
			$("#errori-" + elemento.id).html("<div class='alert'>"+ data + "</div>");
			++errori_form;
		}

	});
}


function ricerca_get_param()
{
	var tab = document.getElementById('ricerca_tabelle').value;

	if( '' == tab )
	{
		$('ricerca_campi').html('Seleziona una tabella');
		return ;
	}

	url = "<?php echo URL; ?>" + "ricerca-campi" + '/' + encodeURIComponent(tab);

	$.get(url,function(data,status){
		$("#ricerca_campi").html(data);
	});

}