<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';
require_once MLIBPATH . 'Connection/HostData.php';

class GetContIdentType {

    public static function getTipoIdent() {

        $consult = 'select id, '//0
                . 'des, '//1
                . 'dv '//2
                . 'from get_tipo_identificacion() as ("id" integer, "des" varchar, "dv" char);';

        return ConnectionDB::consult(new HostData(), $consult);
    }

    public static function getTipoCont() {

        $consult = 'select id,'//0
                . ' des '//1
                . 'from get_tipo_contrato() as ("id" integer, "des" varchar);';
        return ConnectionDB::consult(new HostData(), $consult);
    }

}

?>
