<?php

$_FORMATI_IMMAGINI =  array('gif','png','jpg','jpeg');


function check_testo($s)
{
	// TODO
	return true;
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
