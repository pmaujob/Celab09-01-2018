<?php

@session_start();

$pRootC = $_SESSION['pRootC'];

require_once $pRootC.'/libraries/ConnectionDB.php';

class MLogout {
    
    public static function logOut($idLog){
        
        $consult = 'select from seguridad.logs_logout('.$idLog.');';
        
        ConnectionDB::consult(new HostData(), $consult);
        
    }
    
}

?>
