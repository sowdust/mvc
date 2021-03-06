<?php
header("Content-type: text/css", true);
require_once('../common/config.php');
?>

/**
FINE AGGIUNTE COMPITO 3
*/


.transparent {
background-color : transparent !important
}


* {
margin: 0 auto;
}

html {

}

body {
margin-top: 2%;
color: rgb(50,50,50);
font-size: 13px;
}

p {
padding: 15px;
}

address {
display: inline-block;
padding: 2px;
font-style:italic
}

h1,h2,h3,h4 {
text-align:center;
margin: 5px;
margin-top: 10px;
}


a:link, a:visited {
color: #0b3861;
background: transparent;
text-decoration: none;
}
a:hover	{
color: white;
background: #0b3861;
transition: background 0.5s,color 0.5s ease-in-out;
-moz-transition: background 0.5s,color 0.5s ease-in-out;
-webkit-transition: background 0.5s,color 0.5s ease-in-out;
}
a:active {
color: Red;
}
a.nohover:hover {
background:transparent;
}



div#centering {
width: 75%;
min-width: 600px;
}

#header {
width: 100%;
background: white;
border-right: 2px dashed #0b3861;
border-left: 2px dashed #0b3861;
padding: 2%;
}

#middle {

width: 100%;
background: white;
border-right: 2px dashed #0b3861;
border-left: 2px dashed #0b3861;
padding: 2%;
display: block;
height:100%;

}

#footer {
width: 100%;
background: white;
border: 2px dashed #0b3861;
border-top: 0;
padding: 2%;
display:block;
}

.data {
font-color: gray !important;
}

img.icon {
width:15px;
margin-right: 10px;
}

div.cont {
background: #EFF2FB;
padding: 5px;
display: inline-block;
margin:10px;
}
div.contg {
background: #EFF2FB;
padding: 5px;
display: block;
width:100%;
}

div.lista_luoghi {
margin-bottom: 10px;
padding: 5px;
border-bottom: 1px black dotted;
}

div.commento {
padding:5px;
margin-left:30px;
background-color:#EFFBFB;
font-size: 12px;
}
div.commento div.commento {
background-color:#F8E0F7;
}
div.commento div.commento div.commento {
background-color: #CEF6CE;
}
div.commento div.commento div.commento div.commento {
background-color: #F7F8E0;
}

div.commento-header {
padding:3px;
background-color:#d5edf8;
color: #205791;
}

div.commento-footer {
padding:5px;
border-top: 1px #c0c0c0 dotted;
text-align: right;
}

div.commento-content {
padding:5px;

}

/* Sortable tables */
table.sortable td{
padding: 4px;
}
table.sortable thead {
background-color:#eee;
color:#666666;
font-weight: bold;
cursor: default;
}

ul, ol {
/*list-style-type:cjk-ideographic;*/
}

/*****    MENU
.clear:after { content: "."; display: block; height: 0; clear: both; visibility: hidden;}
html[xmlns] .clear { display: block;}
* html .clear { height: 1%;}
*****/




nav.dark {
z-index: 99;
background: #2E2E2E;
position:fixed;
top:0;
padding-top:7px;
width:100%;
border-top: 0px;
border-bottom: 1px solid #121317;
color:white;

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
/*	background-image: url(<?php echo config::basehost . config::basedir . config::imgdir; ?>nav/navigation-sprite.png);
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
background: url(<?php echo config::basehost . config::basedir . config::imgdir; ?>nav/drop-down.png) no-repeat;
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

nav.dark li ul li.arrow {background: url(<?php echo config::basehost . config::basedir . config::imgdir; ?>nav/arrowtop.png) top left no-repeat; border-bottom: 0px; height: 10px; margin-top: -22px; margin-bottom: 10px;}

/***** END Dark Menu Styles *****/




#map-canvas {
width: 600px;
height: 400px;
z-index: 9;
}


a.noblock:link {
display:inline !important;
padding:0;
}

.smallertext{
padding:3px;
font-size:0.9em !important;
}

.avath {
width: 120px;
height: 120px;
display:inline-block;
margin-right:20px;

}

.avatar {
max-width:120px;
max-height:120px;
vertical-align:middle;

}

.divisore {
margin:10px;
}