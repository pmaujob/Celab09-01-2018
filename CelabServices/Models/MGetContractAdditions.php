<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/HostData.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';

class MGetContractAdditions {

    public static function getAdditions($contractId, $bd) {

        $sql = '';

        switch ($bd) {

            case 'siscon':

                $sql = "select coda, "//0
                        . "fecs, "//1
                        . "fecl, "//2
                        . "val "//3
                        . "from dblink('host=192.168.30.12 dbname=contratacion user=sistemasjoomla password=jogbn2017lnx',"
                        . "'select a.cod_adicion as coda, a.fecha_inicio as fecs, a.fecha_terminacion as fecl, a.valor_adicion as val "
                        . "from adiciones_contratos as a "
                        . "left join legalizar_directa as ld on a.cod_contrato = ld.cod_contrato "
                        . "left join legalizar_contratos_minima as lc on a.cod_contrato = lc.cod_contrato "
                        . "WHERE a.cod_contrato = $contractId;') "
                        . "as (coda varchar, fecs varchar, fecl varchar, val varchar);";

                break;

            case 'msia':

                $sql = "select a.id_adicion,"//0
                        . "a.fecha_suscripcion,"//1
                        . "a.fecha_terminacion,"//2
                        . "a.valor "//3
                        . "from msia.adicion as a inner join msia.contrato as c ON a.id_contrato = c.id_contrato "
                        . "WHERE a.id_contrato =  $contractId";

                break;

            case 'local':

                $sql = "select a.id_adicion,"//0
                        . "a.fecha_suscripcion,"//1
                        . "a.fecha_terminacion,"//2
                        . "a.valor "//3
                        . "from con_adicion as a inner join con_contrato as c ON a.id_contrato = c.id_contrato "
                        . "WHERE a.id_contrato = $contractId";

                break;

            default:

                echo 'Error: tipo de bd no reconocido ' . $bd;

                break;
        }
        
        return ConnectionDB::consult(new HostData(), $sql);
    }

}

?>
