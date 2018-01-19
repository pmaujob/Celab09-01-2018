<?php

@session_start();

$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Connection/ConnectionDB.php';
require_once MLIBPATH . 'Access/SessionVars.php';

class MGetMenu {

    public static function getMenu($op, $idApp, $idMod = -1) {

        $sess = new SessionVars();
        $user = $sess->getValue('idUser');

        $consult = "";

        if ($op == 1)
            $consult = 'select id, mod, fun, url from seguridad.get_menu(' . $user . ',' . $op . ',' . $idApp . ',' . $idMod . ') as ("id" integer, "mod" varchar, "fun" varchar, "url" varchar);';
        else if ($op == 2)
            $consult = 'select id, mod, unico from seguridad.get_menu(' . $user . ',' . $op . ',' . $idApp . ',' . $idMod . ') as ("id" integer, "mod" varchar, "unico" varchar);';

        return ConnectionDB::consult(new HostData(), $consult);
    }

}

?>
