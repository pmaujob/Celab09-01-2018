<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/HostData.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';

class MSearchDocument {

    public static function getContracts($document, $docType) {

        $sql = '';

        switch ($docType) {

            case "V1": //consulta para ACTIVOS

                break;

            case "V2": //consulta para EXFUNCIONARIOS

                break;

            case "V3": //consulta para PENSIONADOS

                //pasyvocol
                $sql = "SELECT np.id_persona as id,"//0
                        . "np.apellido_nombre as nom,"//1
                        . "np.documento as doc,"//2
                        . "td.descripcion as doctype,"//3
                        . "np.sexo as sex, "//4
                        . "pe.email as email "//5
                        . "FROM pasyvocol.pensionado AS np "
                        . "INNER JOIN pasyvocol.tipo_documento AS td ON np.id_doctipo = td.id_doctipo "
                        . "LEFT JOIN pasyvocol.pensionado_email AS pe ON np.documento = pe.doc_pensionado "
                        . "WHERE np.documento = '$document';";

                break;

            case "V4": //consulta para NO PENSIONADOS

                $sql = "SELECT np.id_persona as id, "//0
                    . "(np.nombre || ' ' || np.apellido) as nom, "//1
                    . "ti.descripcion as tdes, "//2
                    . "np.documento as doc, "//3
                    . "pm.descripcion as mdes, "//4
                    . "pd.descripcion as ddes, "//5
                    . "np.sexo as sex, "//6
                    . "np.email as email, "//7
                    . "np.activo as act "//8
                    . "FROM no_pensionado AS np "
                    . "INNER JOIN tipo_identificacion AS ti ON np.id_doctipo = ti.id_idtipo "
                    . "INNER JOIN paises_municipios AS pm ON pm.cod_municipio = np.id_lugar_expedicion "
                    . "INNER JOIN paises_departamentos AS pd ON pd.cod_departamento = pm.cod_departamento "
                    . "WHERE np.documento = '$document';";

                break;

            case "V5": //Consulta para CONTRATISTAS                

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

