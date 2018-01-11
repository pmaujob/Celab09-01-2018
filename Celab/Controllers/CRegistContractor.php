<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'ConvertFormats.php';
require_once $pRootC . '/Celab/Models/MRegistContractorData.php';

class RegistContractor {

    private $idContratista;
    private $nombre;
    private $apellido;
    private $idDocTipo;
    private $documento;
    private $email;
    private $dv;

    function getIdContratista() {
        return $this->idContratista;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function getIdDocTipo() {
        return $this->idDocTipo;
    }

    function getDocumento() {
        return $this->documento;
    }

    function getEmail() {
        return $this->email;
    }

    function getDv() {
        return $this->dv;
    }

    function setIdContratista($idContratista) {
        $this->idContratista = $idContratista;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    function setIdDocTipo($idDocTipo) {
        $this->idDocTipo = $idDocTipo;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setDv($dv) {
        $this->dv = $dv;
    }

    //Funciones Datos Contrato
    function getIdContrato() {
        return $this->idContrato;
    }

    function getIdConTipo() {
        return $this->idConTipo;
    }

    function getNumContrato() {
        return $this->numContrato;
    }

    function getFechaSuscripcion() {
        return $this->fechaSuscripcion;
    }

    function getFechaTerminacion() {
        return $this->fechaTerminacion;
    }

    function getValor() {
        return $this->valor;
    }

    function getObjeto() {
        return $this->objeto;
    }

    function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    function setIdConTipo($idConTipo) {
        $this->idConTipo = $idConTipo;
    }

    function setNumContrato($numContrato) {
        $this->numContrato = $numContrato;
    }

    function setFechaSuscripcion($fechaSuscripcion) {
        $this->fechaSuscripcion = $fechaSuscripcion;
    }

    function setFechaTerminacion($fechaTerminacion) {
        $this->fechaTerminacion = $fechaTerminacion;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setObjeto($objeto) {
        $this->objeto = $objeto;
    }

    public function regist() {
        $result = MRegistContractorData::registContractor("'" . $this->getNombre() . "'", 
                "'" . $this->getApellido() . "'", 
                $this->getIdDocTipo(), 
                "'" . $this->getDocumento() . "'", 
                $this->getDv(), 
                "'" . $this->getEmail() . "'")->fetch(PDO::FETCH_OBJ)->id;
        return $result;
    }
}

$contractorData = array();
$contractorData = $_POST['contractorData'];
$registContractor = new RegistContractor();
$registContractor->setNombre($contractorData[0]);
$registContractor->setApellido($contractorData[1]);
$registContractor->setIdDocTipo($contractorData[2]);
$registContractor->setDocumento($contractorData[3]);
$registContractor->setDv($contractorData[4]);
$registContractor->setEmail($contractorData[5]);

echo $registContractor->regist();
?>
