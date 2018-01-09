<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Celab/Models/MSearchUser.php';

class CSearchUser {

    public static function searchUser($op, $fill) {
        
        switch ($op){
            
            case 1://contratistas
                return MSearchUser::searchContractor($fill);
                break;
            
            default:
                echo "Opción (op) no reconocida.";
                break;
            
        }        
    }

}
?>