<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'ConnectionDB.php';
require_once MLIBPATH . 'HostData.php';

class GetContIdentType {

    public static function getTipoIdent() {

        $consult = 'select id, '//0
                . 'des, '//1
                . 'dv '//2
                . 'from get_tipo_identificacion() as ("id" integer, "des" varchar, "dv" char);';

        return ConnectionDB::consult(new HostData(), $consult);
    }

    public static function getTipoCont() {

        $consult = 'select id,'//0
                . ' des '//1
                . 'from get_tipo_contrato() as ("id" integer, "des" varchar);';
        return ConnectionDB::consult(new HostData(), $consult);
    }

}

$op = $_POST['op'];
switch ($op) {

    case 1:
        echo json_encode(GetContIdentType::getTipoIdent()->fetchAll(PDO::FETCH_OBJ));
        break;
    
    case 2:
        echo json_encode(GetContIdentType::getTipoCont()->fetchAll(PDO::FETCH_OBJ));
        break;

    default:
        echo "0";
        break;
}
?>
