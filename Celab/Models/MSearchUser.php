<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';
require_once MLIBPATH . 'Connection/HostData.php';

class MSearchUser {

    public static function searchContractor($fill) {

        $consult = 'select id,'//0
                . 'nom,'//1
                . 'doc,'//2
                . 'email,'//3
                . 'bd '//4
                . 'from get_contratista(\'' . strtolower($fill) . '\') as ("id" integer, "nom" varchar, "doc" varchar, "email" varchar, "bd" varchar)';
       
        return ConnectionDB::consult(new HostData(), $consult);
        
    }

}

?>
