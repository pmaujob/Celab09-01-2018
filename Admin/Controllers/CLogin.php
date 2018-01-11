<?php

@session_start();

$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'SessionVars.php';
require_once $pRootC . '/Admin/Models/MLogin.php';

class CLogin {

    private $email;
    private $emailFilter;
    private $user;
    private $idUser;
    private $idLog;
    private $pass;
    private $ip;
    private $idApp;

    public function setEmail($email) {

        $this->email = $email;
        $this->emailFilter = "'" . $email . "'";
    }

    public function setPass($pass) {

        $this->pass = "'" . sha1($pass) . "'";
    }

    public function setIp($ip) {

        $this->ip = "'" . $ip . "'";
    }

    public function setIdApp($idApp) {
        $this->idApp = $idApp;
    }

    private function getIdApp() {
        return $this->idApp;
    }

    public function logIn() {

        $mLogin = new MLogin();
        $mLogin->logIn($this->emailFilter, $this->pass, $this->ip);
        $this->user = $mLogin->getUser();
        $this->idUser = $mLogin->getIdUser();
        $this->idLog = $mLogin->getIdLog();

        return $mLogin->getResponse();
    }

    public function setSession() {

        $sess = new SessionVars();
        $sess->init();
        $sess->setValue('user', $this->user);
        $sess->setValue('idUser', $this->idUser);
        $sess->setValue('email', $this->email);
        $sess->setValue('idLog', $this->idLog);
        $sess->setValue('idApp', $this->getIdApp());
    }

}

if ((isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['idapp'])) && (!empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['idapp']))) {

    $login = new CLogin();
    $login->setEmail($_POST['email']);
    $login->setPass($_POST['pass']);
    $login->setIp('192.168.1.111');
    $login->setIdApp($_POST['idapp']);
    $user = $login->logIn();
    if ($user == "Ok")
        $login->setSession();

    echo $user;
}
?>