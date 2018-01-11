<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'ConvertFormats.php';
require_once $pRootC . '/Celab/Models/MRegistContractorData.php';

class CRegistContract {

    private $idContract;
    private $idConType;
    private $numContract;
    private $susDate;
    private $finDate;
    private $value;
    private $object;

    function getIdContract() {
        return $this->idContract;
    }

    function getIdConType() {
        return $this->idConType;
    }

    function getNumContract() {
        return $this->numContract;
    }

    function getSusDate() {
        return $this->susDate;
    }

    function getFinDate() {
        return $this->finDate;
    }

    function getValue() {
        return $this->value;
    }

    function getObject() {
        return $this->object;
    }

    function setIdContract($idContract) {
        $this->idContract = $idContract;
    }

    function setIdConType($idConType) {
        $this->idConType = $idConType;
    }

    function setNumContract($numContract) {
        $this->numContract = $numContract;
    }

    function setSusDate($susDate) {
        $this->susDate = $susDate;
    }

    function setFinDate($finDate) {
        $this->finDate = $finDate;
    }

    function setValue($value) {
        $this->value = $value;
    }

    function setObject($object) {
        $this->object = $object;
    }

    public function registContracts($idContractor, $bdContractor, $contractData, $emailContractor) {
        $newArray = array();
        for ($i = 1; $i < count($contractData); $i += 2) {
            $contract = $contractData[$i];

            $newAddArray = array();
            if ($contract[6] != "") {//Evitar error 
                $addArray = $contract[6];
                for ($j = 0; $j < count($addArray); $j++) {
                    $addObject = $addArray[$j];

                    $newObj = array("addSusDate" => $addObject[1] == "" ? "NULL" : $addObject[1],
                        "addFinDate" => $addObject[2] == "" ? "NULL" : $addObject[2],
                        "addValue" => $addObject[3] == "" ? "NULL" : $addObject[3]);

                    $newAddArray[] = $newObj;
                }
            }
            $addJson = str_replace("'", "", ConvertFormats::convertToJsonItems($newAddArray));

            $obj = array("idContType" => $contract[0],
                "numContract" => $contract[1],
                "susDate" => $contract[2],
                "finDate" => $contract[3],
                "value" => $contract[4],
                "object" => $contract[5],
                "adds" => $addJson == "" ? "" : $addJson . "RE|");

            $newArray[] = $obj;
        }
        //se adiciona la cadena "RE|" para eliminar las comillas que el Json principal le pone al json secundario
        $jsonText = str_replace("\\", "", ConvertFormats::convertToJsonItems($newArray));
        $jsonText = str_replace('"adds":"{', '"adds":{', $jsonText);
        $jsonText = str_replace('RE|"', '', $jsonText);

        return MRegistContractorData::registContracts($idContractor, $bdContractor, $jsonText, $emailContractor);
    }

}

$contracts = array();
$contracts = $_POST['contractArray'];
$registContract = new CRegistContract();
echo $registContract->registContracts($_POST['idContractor'], $_POST['bdContractor'], $contracts, $_POST['emailContractor']);
?>
