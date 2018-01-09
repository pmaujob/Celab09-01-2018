<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Libraries/ConnectionDB.php';
require_once $pRootC . '/Libraries/HostData.php';

class MSearchDocument {

    public static function getContracts($document, $docType) {

        $sql = '';

        switch ($docType) {

            case "V1":
                //consulta para ACTIVOS              

                break;

            case "V2":
                //consulta para EXFUNCIONARIOS
                break;

            case "V3":
                //consulta para PENSIONADOS
                break;

            case "V4":
                //consulta para NO PENSIONADOS
                break;

            case "V5":
                //Consulta para CONTRATISTAS                

                $sql = 'select nom,'//0
                        . 'doc,'//1
                        . 'email,'//2
                        . 'num,'//3
                        . 'tip,'//4
                        . 'fecs,'//5
                        . 'fect,'//6
                        . 'val,'//7
                        . 'obj,'//8
                        . 'bd,'//9
                        . 'cod '//10
                        . 'from get_contratos(\'' . $document . '\') as ("nom" varchar, "doc" varchar, "email" varchar, "num" varchar, "tip" varchar, "fecs" varchar, "fect" varchar, "val" money, "obj" varchar, "bd" varchar, "cod" integer)';
                
                break;
        }

        return ConnectionDB::consult(new HostData(), $sql);
    }

}
?>

