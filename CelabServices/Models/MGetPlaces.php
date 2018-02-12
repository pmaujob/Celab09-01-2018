<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/HostData.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';

class MGetPlaces {

    public static function getPlaces($codDep) {

        $sql = 'select cod, des from get_municipios('
                . ($codDep == null ? '1, null' : '2,' . $codDep) . ')'
                . 'as ("cod" integer, "des" varchar)';

        return ConnectionDB::consult(new HostData(), $sql);
        
    }

}

?>
