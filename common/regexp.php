<?php

/** Abstract class that provides static method for input validation	 */
abstract class regexp {

    /**
     * Checks if input is a valid nick.
     *
     * Returns true if nick satisfies {letter,digit,'_'}+.
     * @param string
     * @return bool
     * @used-by ajax::nick
     */
    static function nick($nick) {
        //	{lettera, numero, '_'}+
        //	lunghezza [3,16]
        return preg_match("/^[A-Za-z0-9_]{3,16}$/", $nick);
    }

    /**
     * Checks if input is a valid text field.
     *
     * @param string
     * @return bool
     * @used-by ajax::testo
     */
    static function testo($testo) {
        return $testo == htmlspecialchars($testo);
    }

    /**
     * Checks if input is a valid text password.
     *
     * @param string
     * @return bool
     * @used-by ajax::password
     */
    static function password($pass) {
        //	tra 3 e 255 caratteri
        return ( strlen($pass) > 3 && strlen($pass) < 255 );
    }

    /** Alias for password() */
    static function pass($pass) {
        return self::password($pass);
    }

    /**
     * Checks if input is a valid "status" field.
     *
     * @param string
     * @return bool
     * @used-by ajax::stato
     */
    static function stato($stato) {
        return (strlen($stato) < 161 && strlen($stato) > 2);
    }

    /**
     * Checks if input is a valid email address.
     *
     * @param string
     * @return bool
     * @used-by ajax::email
     */
    static function email($email) {
        //	trovata in rete
        return preg_match("/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $email);
    }

    /**
     * Checks if input is a valid isbn field.
     *
     * @param int
     * @return bool
     */
    static function isbn($i) { // 10 o 13 cifre
        return ( is_numeric($i) && ( strlen($i) == 10 || strlen($i) == 13));
    }

    /**
     * Checks if input is a valid 'entita'.
     *
     * @param string
     * @return bool
     */
    static function entita($s) {
        //	controlla che sia una valida
        //	specie di "entita'"
        if ('stato' == $s)
            return true;
        if ('opera' == $s)
            return true;
        if ('utente' == $s)
            return true;
        if ('luogo' == $s)
            return true;
        if ('commento' == $s)
            return true;
        return false;
    }

}
