<?php

define('URL','http://localhost/mvc/index.php?request=ajax/');

 header("Content-type: text/javascript"); ?>

$(document).ready(function(){
 $("#msgid").html("This is Hello World by JQuery");
});

$(document).ready(function() {
	$("#invia-login").click(function(e){
		var url = "<?php echo URL .'check-nick/'; ?>" + $("#login-nick").val();
		$.get(url,function(data,status){
			$("#msgid").html("URL: " + url + "Data: " + data + "\nStatus: " + status);
		});
});
/*
	$("#login-nick").blur(function(e){
		var url = "<?php echo URL .'check-nick/'; ?>" + $("#login-nick").val();
		$.get(url,function(data,status){
			if(data == 'OK')
			{
				// non funziona
				$("#login-nick").addClass("ok");
				$("#errori-login-nick").html('<div class="success">Successo</div>');
			}else{
				$("#login-nick").addClass("prova");
				$("#msgid").addClass("prova");
				$("#login-nick").val("ok");
				$("#errori-login-nick").html("<div class='alert'>"+ data + "</div>");	
			}

		});
	});
*/





});


function valida(elemento,funzione)
{
	var url = "<?php echo URL; ?>" + funzione + '/' + elemento.value;
	$.get(url,function(data,status){
		if('OK' == data)
		{
			$(elemento).addClass("ok");

		}else{

			$(elemento).addClass("notok");
			$("#errori-" + elemento.id).html("<div class='alert'>"+ data + "</div>");
		}

	});
}

/*	
function valida(id-elemento, funzione)
{
var url = "<?php echo URL .'check-nick/'; ?>" + $(id-elemento).val();
	$.get(url,function(data,status){
		if(data == 'OK')
		{
			$(id-elemento).val("ok");
		}else{
			$(id-elemento).val("non ok")
		}

	});


}

*/