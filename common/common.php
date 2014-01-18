<?php

// api key non necessaria in realta'. Se usata correttamente,
// anche con i giusti filtri IP, google ritorna FORBIDDEN
// eliminandola dall'URL tutto funziona!
$_GOOGLE_API_KEY = 'AIzaSyAUCJK79_EYm6tQ3VsShIgiEpwSxkLuPDs';
$_BASEDIR = 'tweb_boot/';
$_ABS_BASEDIR = 'http://localhost/'.$_BASEDIR;
$_NOME_SITO = 'WAW';
$_URL_ATTIVAZIONE = $_ABS_BASEDIR . 'controller/attiva.php';
$_FORMATI_IMMAGINI =  array('gif','png','jpg','jpeg');
$_USR_IMG_DIR = '/var/www/tweb_boot/usr_img/';
$_ABS_IMG_DIR = $_ABS_BASEDIR. 'usr_img/';


// defined in model/session.php
//$_SEED = "0";


//	TODO: add validation functions body
function check_nick($nick)
{
	// TODO
	return true;
}
function check_stato($stato)
{
	// TODO
	return true;
}
function check_pass($pass)
{
	// TODO
	return true;
}
function check_testo($s)
{
	// TODO
	return true;
}

function is_entita($s)
{
	if('stato' == $s)	return true;
	if('opera' == $s)	return true;
	if('utente' == $s)	return true;
	if('luogo' == $s)	return true;
	if('commento' == $s)return true;
	return false;
}

function is_isbn($i)
{
	return( is_numeric($i) && (strlen($i)==10 || strlen($i)==13));
}

function is_email($email)
{
// espressioni regolari per l'email trovate in rete
	if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email))
	{
		return false;
	}

	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++)
	{
		if (!preg_match("/^(([A-Za-z0-9!#$%&'*+=?^_`{|}~-][A-Za-z0-9!#$%&'*+=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i]))
		{
			return false;
		}
	}

	if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1]))
	{ // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2)
		{
			return false; // Not enough parts to domain
		}

		for ($i = 0; $i < sizeof($domain_array); $i++)
		{
			if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i]))
			{
				return false;
			}
		}
	}

	return true;
}

?>
