<?php

@session_start();

$pRootC = $_SESSION['pRootC'];


require_once $pRootC . "/Libraries/HostData.php";
require_once $pRootC . '/Libraries/ConnectionDB.php';

class MLogin {

    private $con;
    private $email;
    private $user;
    private $idUser;
    private $idLog;
    private $response;

    public function logIn($email, $pass, $ip) {

        $this->con = new HostData();
        $this->email = $email;

        $sql = 'select cont from seguridad.login(' . $email . ',' . $pass . ') as ("cont" varchar);';

        $res = ConnectionDB::consult($this->con, $sql)->fetchAll(PDO::FETCH_OBJ);
        $response = "No";

        foreach ($res as $result) {
            $response = $result->cont;
        }

        if ($response == "Ok") {

            $sql = 'select id from seguridad.ing_logs_login(' . $ip . ',' . $email . ') as ("id" integer);';

            $res = ConnectionDB::consult($this->con, $sql)->fetchAll(PDO::FETCH_OBJ);

            foreach ($res as $result) {
                $this->idLog = $result->id;
            }

            $this->setDataUsers();
        }

        $this->response = $response;
    }

    private function setDataUsers() {

        $sql = 'select usuario, id from seguridad.get_datos_usuario(' . $this->email . ') as ("usuario" varchar, "id" varchar);';

        $res = ConnectionDB::consult($this->con, $sql)->fetchAll(PDO::FETCH_OBJ);

        foreach ($res as $resultado) {
            $this->user = $resultado->usuario;
            $this->idUser = $resultado->id;
        }
    }

    public function getUser() {

        return $this->user;
    }

    public function getIdUser() {

        return $this->idUser;
    }

    public function getIdLog() {

        return $this->idLog;
    }

    public function getResponse() {

        return $this->response;
    }

}

?>