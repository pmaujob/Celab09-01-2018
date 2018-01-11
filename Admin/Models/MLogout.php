<?php

@session_start();

$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'ConnectionDB.php';
require_once MLIBPATH . 'HostData.php';

class MLogout {
    
    public static function logOut($idLog){
        
        $consult = 'select from seguridad.logs_logout('.$idLog.');';
        
        ConnectionDB::consult(new HostData(), $consult);
        
    }
    
}

?>
