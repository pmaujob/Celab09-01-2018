<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';
require_once MLIBPATH . 'Connection/HostData.php';

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

    public static function registContractorEmail($doc, $email, $bd) {

        $consult = "select from ins_contractor_email('$doc', '$email', '$bd');";        
        return ConnectionDB::afect(new HostData(), $consult);
        
    }

}
?>

