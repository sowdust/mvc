<?php

require_once('secret/db.php');

class database {

    private $user;
    private $pass;
    private $host;
    private $dbname;
    public $mysqli;

    public function __construct() {
        $this->host = secret::host;
        $this->user = secret::user;
        $this->pass = secret::pass;
        $this->dbname = secret::dbname;

        $this->mysqli = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
        if (mysqli_connect_errno($this->mysqli)) {
            echo "Errore: " . mysqli_connect_error();
            die();
        }
    }

}
