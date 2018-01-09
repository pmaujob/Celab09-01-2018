<?php

@session_start();

$pRootC = $_SESSION['pRootC'];
require_once $pRootC . '/Config/DefaultConnection.php';

class HostData {

    private $motor;
    private $user;
    private $pass;
    private $host;
    private $db;

    public function __construct($motor = null, $user = null, $pass = null, $db = null, $host = null) {
        
        if ($motor == null && $user == null && $pass == null && $db == null && $host == null) {

            $this->setMotor(MOTOR);
            $this->setUser(USER);
            $this->setPass(PASS);
            $this->setDb(DB);
            $this->setHost(HOST);
            
        } else {
            
            $this->setMotor($motor);
            $this->setUser($user);
            $this->setPass($pass);
            $this->setDb($db);
            $this->setHost($host);
        }
        
    }

    public function getMotor() {
        return $this->motor;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPass() {
        return $this->pass;
    }

    public function getHost() {
        return $this->host;
    }

    public function getDb() {
        return $this->db;
    }

    public function setMotor($motor) {
        $this->motor = $motor;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function setDb($db) {
        $this->db = $db;
    }

}
?>
