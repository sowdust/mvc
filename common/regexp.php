<?php

abstract class regexp {

		

		static function nick($nick)
		{
			//	{lettera, numero, '_'}+
			//	lunghezza [3,16]
			return preg_match("/^[A-Za-z0-9_]{3,16}$/", $nick);
		}

		static function testo($testo)
		{
			return true;
		}

		static function password($pass)
		{
			//	tra 3 e 255 caratteri
			return (	strlen($pass) > 3
					&&	strlen($pass) < 255 );
		}

		static function pass($pass)
		{
			return self::password($pass);
		}

		static function email($email)
		{
			//	trovata in rete			
			return preg_match("/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/",
				$email);
		}

		static function isbn($i)
		{	// 10 o 13 cifre
			return (	is_numeric($i)
					&& (	strlen($i)==10
						 || strlen($i)==13));
		}

		static function entita($s)
		{
			//	controlla che sia una valida
			//	specie di "entita'"
			if('stato' == $s)	return true;
			if('opera' == $s)	return true;
			if('utente' == $s)	return true;
			if('luogo' == $s)	return true;
			if('commento' == $s)return true;
			return false;
		}

}

?>