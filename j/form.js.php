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
});
