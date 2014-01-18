<?php

define('URL',$_SERVER['REQUEST_URI']);
require_once('model/init.php');
require_once('controller/controller.php');
require_once('common/common.php');

$req = (isset($_GET['request'])) ? $_GET['request'] : '';
$init = new init($req);


?>
