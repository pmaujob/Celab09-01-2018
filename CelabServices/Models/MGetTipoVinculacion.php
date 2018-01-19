<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/HostData.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';

class MGetVinculationType {

    public static function getTypes() {

        $sql = 'select id, '
                . 'des, '
                . 'idvin '
                . 'from get_tipo_vinculacion() '
                . 'as ("id" smallint, "des" varchar, "idvin" varchar);';

        return ConnectionDB::consult(new HostData(), $sql);
    }

}

?>