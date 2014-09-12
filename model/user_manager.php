<?php

class user_manager {

    private $utenti;
    private $db;

    public function lista_utenti() {
        return $this->utenti;
    }

    public function __construct($db) {
        $this->db = $db->mysqli;
        $this->refresh_utenti();
    }

    function get_admin() {
        $q = "SELECT id FROM utenti WHERE type > 0 ORDER BY id asc LIMIT 0,1";
        if (!($r = $this->db->query($q))) {
            die("query fallita" . $q);
        }
        $u = null;
        while ($c = $r->fetch_assoc()) {
            $u = $c['id'];
        }
        return $u;
    }

    private function refresh_utenti() {
        $q = "SELECT id, nick FROM utenti ORDER BY id asc";
        if (!($r = $this->db->query($q))) {
            die("query fallita" . $q);
        }
        while ($c = $r->fetch_assoc()) {
            $this->utenti[$c['id']] = $c['nick'];
        }
    }

    public function count_users($condition = '') {
        $q = "SELECT COUNT(*) FROM utenti";
        if (strlen($condition) > 0) {
            $q .= " WHERE " . $condition;
        }
        if (!($r = $this->db->query($q))) {
            die("query fallita" . $q);
        }
        $c = $r->fetch_row();
        return $c[0];
    }

    // TODO: stampare link in caso mail non funzioni
    // TODO: usare prepared statements
    public function add_user($nick, $email, $pass) {

        if (($this->count_users("nick = \"" . $nick . "\"") > 0) || ($this->count_users("email = \"" . $email . "\"") > 0)) {
            return false;
        }

        $rand = md5(time());
        $pass_hash = md5($pass);

        $q_e = "INSERT INTO email_codes(nick,code) VALUES (\"" . $nick . "\",\"" . $rand . "\")";
        $r = $this->db->query($q_e) or die();

        $q = $this->db->prepare("INSERT INTO utenti (nick,email,pass_hash,type) VALUES ((?),(?),(?),(-2))");
        $q->bind_param('sss', $nick, $email, $pass_hash);
        $q->execute();

        $link = init::link('registra', urlencode($nick), urlencode($rand));
        $message = "Grazie per esserti registrato\n"
                . "Clicca sul seguente url per attivare il tuo account \n"
                . $link;
        $subject = "Conferma attivazione account";
        $headers = "From:" . 'nomesito' . "<noreply@dominiosito.com>" . "\r\n"
                . "X-Mailer: PHP/" . phpversion() . "\r\n"
                . 'Content-type: text; charset=UTF-8' . "\r\n";


        mail($email, $subject, $message, $headers);
        $result['last_id'] = $this->db->insert_id;
        $result['link'] = $link;
        return $result;
    }

    function admin_activate($id) {
        $q = $this->db->prepare("UPDATE utenti SET type = type+1 WHERE id = (?)");
        $q->bind_param('i', $id);
        if (!$q->execute()) {
            return false;
        }
        $q->close();
    }

    public function activate($nick, $code) {
        $q = $this->db->prepare("SELECT code FROM email_codes WHERE nick = (?) LIMIT 0,1") or die();
        $q->bind_param('s', $nick) or die();
        $q->execute() or die();
        $q->store_result() or die();
        $q->bind_result($r) or die();
        $q->fetch();
        $q->close();
        unset($q);

        if (NULL == $r) {
            // TODO pretty errors
            die('utente non pi&ugrave; presente nel nostro database');
        }
        if ($r == $code) {
            //	$this->set_info(array('type'=>0));
            $q = $this->db->prepare("UPDATE utenti SET type = type+1 WHERE nick = (?)");
            $q->bind_param('s', $nick);
            if (!$q->execute()) {
                return false;
            }
            $q->close();
            unset($q);
            $q = $this->db->prepare("DELETE FROM email_codes WHERE nick = (?) ");
            $q->bind_param('s', $nick);
            $q->execute();
            $q->close();
            unset($q);

            return true;
        }
        return false;
    }

    public function remove_user($id_utente) {
        require_once('model/user.php');
        $user = new user($this->db, $id_utente);
        if ($user->get_type() > 0) {
            die('non si possono eliminare gli amministratori');
        }
        $q = $this->db->prepare("DELETE FROM utenti WHERE id = (?)");
        $q->bind_param('i', $id_utente);
        $q->execute() or die('cancellazione non riuscita');
        $q->close();
    }

}
