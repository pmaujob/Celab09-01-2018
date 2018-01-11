<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'ConnectionDB.php';
require_once MLIBPATH . 'HostData.php';

class MRegistContractorData {

    public static function registContractor($nombre, $apellido, $idDocTipo, $documento, $dv, $email) {

        $consult = 'select id from ins_contractor(' . $nombre . ','
                . $apellido . ','
                . $idDocTipo . ','
                . $documento . ','
                . ($dv == "" ? "NULL" : $dv) . ','
                . $email . ') as ("id" integer);';

        return ConnectionDB::consult(new HostData(), $consult);
    }

    public static function registContracts($idContractor, $bdContractor, $contractData, $emailContractor) {

        $consult = "select from ins_contract($idContractor, '$bdContractor', $contractData, '$emailContractor');";
        
        return ConnectionDB::afect(new HostData(), $consult);
    }

}
?>

