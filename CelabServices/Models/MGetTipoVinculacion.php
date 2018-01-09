<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Libraries/HostData.php';
require_once $pRootC . '/Libraries/ConnectionDB.php';

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