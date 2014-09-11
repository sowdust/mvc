<?php

/**
 * Index file directly called by web query.
 *
 * Loads the common files used throughout the application and calls the init
 * model that loads the right controller and starts actual session
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

define('URL', $_SERVER['REQUEST_URI']);

require_once('common/config.php');
require_once('common/common.php');
require_once('common/regexp.php');
require_once('model/init.php');
require_once('controller/controller.php');

$req = (isset($_GET['request'])) ? $_GET['request'] : '';
$init = new init($req);
