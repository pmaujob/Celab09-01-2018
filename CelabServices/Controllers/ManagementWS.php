<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'SessionVars.php';
require_once $pRootC . '/CelabServices/Models/MGetTipoVinculacion.php';
require_once $pRootC . '/CelabServices/Models/MSearchDocument.php';

const MOD_VINCULATION_TYPE = "MOD_VINCULATION_TYPE";
const MOD_SEARCH_CONTRACTOR = "MOD_SEARCH_CONTRACTOR";
const MOD_ERROR = "MOD_ERROR";

$opModel = $_GET['opModel'];
switch ($opModel) {

    case MOD_VINCULATION_TYPE://Traer tipos vinculacion
        echo json_encode(MGetVinculationType::getTypes()->fetchAll(PDO::FETCH_OBJ));
        break;

    case MOD_SEARCH_CONTRACTOR://Consultar si el documento existe
        $document = $_GET['document'];
        $docType = $_GET['docType'];
        echo json_encode(MSearchDocument::getContracts($document, $docType)->fetchAll(PDO::FETCH_OBJ));
        break;

    default:
        echo MOD_ERROR;
        break;
}

$sess = new SessionVars();
$sess->destroy();
?>