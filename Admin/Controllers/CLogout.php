<?php

@session_start();

$pRootC = $_SESSION['pRootC'];
$pRootHtmlC = $_SESSION['pRootHtmlC'];

require_once $pRootC . '/Admin/Models/MLogout.php';
require_once $pRootC . '/libraries/SessionVars.php';

class CLogout {

    private $idLog;
    private $sess;

    public function setIdLog() {

        $this->sess = new SessionVars();
        $this->idLog = $this->sess->getValue('idLog');
        $this->unSetSession();
    }

    public function logOut() {

        try {
            MLogout::logOut($this->idLog);
            return "Ok";
        } catch (ErrorException $e) {
            return "No";
        }
    }

    private function unSetSession() {

        if ($this->sess->exist()) {

            if ($this->sess->varExist('user'))
                $this->sess->unsetValue('user');

            if ($this->sess->varExist('idUser'))
                $this->sess->unsetValue('idUser');

            if ($this->sess->varExist('email'))
                $this->sess->unsetValue('email');

            if ($this->sess->varExist('idLog'))
                $this->sess->unsetValue('idLog');

            $this->sess->destroy();
        }
    }

}

$logOut = new CLogout();
$logOut->setIdLog();
$logOut->logOut();

header("Location: $pRootHtmlC/index.php");
?>
