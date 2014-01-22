<?php

header("Content-type: text/css", true);
require_once('../common/config.php');

?>

/**
	FINE AGGIUNTE COMPITO 3
*/

* {
	margin: 0 auto;
}

html {	
	background-image: linear-gradient(
		to right,
		hsl(0, 0%, 90%) 0%,
		hsl(0, 0%, 100%) 50%,
		hsl(0, 0%, 90%) 100%
	);
}

body {
	margin-top: 3%;
	font-family: Helvetica;

}

div#centering {
	width: 90%;
}

#header {
	width: 100%;
	min-height: 190px;
	background: white;
	background-image: url('../img/logo.png');
	background-repeat:no-repeat;
	background-position:right center;
	border: 2px dashed #0b3861;
}

#middle {

	width: 100%;
	background: white;
	border-right: 2px dashed #0b3861;
	border-left: 2px dashed #0b3861;
	padding: 2%;

}

#footer {
	width: 100%;
	background: white;
	border: 2px dashed #0b3861;
	border-top: 0;
	padding: 2%;
}



/***** BEGIN Dark Menu Styles }
.clear:after { content: "."; display: block; height: 0; clear: both; visibility: hidden;}
html[xmlns] .clear { display: block;}
* html .clear { height: 1%;}
*****/

nav.dark {
	background: #2E2E2E;
	position:fixed;
	top:0;
	width:100%;
	border-top: 0px;
	border-bottom: 1px solid #121317;
	
}
nav.dark ul {
	margin: 0px;
	margin-left: 15%;
	padding: 0px;
	border-left: 1px solid #2e3235;
}

/* Top level */
nav.dark li {list-style: none; float: left; border-right: 1px solid #2e3235; position: relative;}

/*
nav.dark li.first, nav li.first a {
	border-top-left-radius: 2px;
	border-bottom-left-radius: 2px;
	-moz-border-top-left-radius: 2px;
	-moz-border-bottom-left-radius: 2px;
}

nav.dark li.last, nav li.last a {
	border-top-right-radius: 2px;
	border-bottom-right-radius: 2px;
	-moz-border-top-right-radius: 2px;
	-moz-border-bottom-right-radius: 2px;
	}
*/

nav.dark li.drop a {
	padding-right: 30px;
}
nav.dark li a {
	display: block;
	padding: 9px 23px 10px;
	text-decoration: none;
/*	background-image: url(<?php echo config::basehost.config::basedir.config::imgdir; ?>nav/navigation-sprite.png);
*/
	background-repeat: repeat-x;
	color: #fff;
/*	border-top: 1px solid #5a5d60;
	border-left: 1px solid #525659;
	text-shadow: 0px -1px 0px #000;
*/
}
nav.dark li a {background-position: 0px 0px;}
nav.dark li a:hover, nav li.active a {background-position: 0px -36px;}
nav.dark li a:active {background-position: 0px -72px;}
nav.dark .dropdown {display: block; float: right; width: 7px; height: 5px;
	background: url(<?php echo config::basehost.config::basedir.config::imgdir; ?>nav/drop-down.png) no-repeat;
	margin: -20px 15px 0px 12px;
}

/* Drop down */
nav.dark li ul {
	opacity: 0;
	position: absolute;
	top: 45px;
	left: -26px;
	padding: 12px 15px; border-radius: 3px; -moz-border-radius: 3px; background: #222; display: none; z-index: 100;}
nav.dark li ul li {border-right: 0px; float: none!important; border-bottom: 1px solid #444; width: 125px;}
nav.dark li ul li:last-child { border-bottom: 0px;}
nav.dark li ul li a {background: none!important; border-left: 0px; border-top: 0px; padding: 10px 0px;}
nav.dark li ul li a:hover {opacity: 0.5;}

nav.dark li ul li.arrow {background: url(<?php echo config::basehost.config::basedir.config::imgdir; ?>nav/arrowtop.png) top left no-repeat; border-bottom: 0px; height: 10px; margin-top: -22px; margin-bottom: 10px;}

/***** END Dark Menu Styles *****/