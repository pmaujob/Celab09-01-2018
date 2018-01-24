<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';
require_once MLIBPATH . 'Connection/HostData.php';

class MRegistPasyvocol {

    public static function registPasyvocol($jsonNoPensioner) {

        $consult = "select from pasyvocol.ins_pasyvocol($jsonNoPensioner);";
        return ConnectionDB::afect(new HostData(), $consult);
    }
    
    public static function registNoPensionerEmail($doc, $email) {

        $consult = "select from pasyvocol.ins_no_pensionado_email('$doc', '$email');";   
        return ConnectionDB::afect(new HostData(), $consult);
        
    }


}
?>

