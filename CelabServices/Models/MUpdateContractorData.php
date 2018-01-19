<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/HostData.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';

class MUpdateContractorData {

    public static function updateEmail($doc, $email, $bd) {

        $sql = '';

        switch ($bd) {

            case 'siscon':
                
                $sql = "INSERT INTO con_email(doc_contratista,email) VALUES('$doc','$email')";

                break;

            case 'msia':
                
                $sql = "UPDATE msia.contratista SET email = '$email' WHERE documento = $doc";

                break;

            case 'local':
                
                $sql = "UPDATE contratista SET email = '$email' WHERE documento = $doc";

                break;

            default:
                
                echo 'Error: tipo de bd no reconocido ' . $bd;

                break;
        }
    }

}
?>

