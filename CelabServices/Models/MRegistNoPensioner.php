<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/HostData.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';

class MRegistNoPensioner {

    public static function registNoPensioner($noPensionerJson) {

        $sql = "select id from ing_no_pensionado('" . $noPensionerJson . "') as (\"id\" integer);";
        return ConnectionDB::consult(new HostData(), $sql);
    }

    public static function confirmNoPensioner($sha1) {
        $sql = "select res,doc from confirmar_no_pensionado('$sha1') "
                . 'as ("res" integer, "doc" varchar)';
        return ConnectionDB::consult(new HostData(), $sql);
    }

}

?>
