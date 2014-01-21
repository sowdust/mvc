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

	$("#login-nick").blur(function(e){
		var url = "<?php echo URL .'check-nick/'; ?>" + $("#login-nick").val();
		$.get(url,function(data,status){
			if(data == 'OK')
			{
				// non funziona
				$("#login-nick").addClass('ok');
			}else{
				$("#login-nick").addClass('notok');
				$("#errori-login-nick").html("<div class='alert'>"+ data + "</div>");	
			}
			

			//$("#errori-form-login").html("URL: " + url + "Data: " + data + "\nStatus: " + status);
		});
	});
});
