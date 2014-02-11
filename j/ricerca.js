<?php

require_once('../common/config.php');


define('URL',config::basehost.config::basedir.'index.php?request=ajax/get-results/');

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