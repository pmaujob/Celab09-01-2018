<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Access/SessionVars.php';
require_once $pRootC . '/CelabServices/Models/MGetTipoVinculacion.php';
require_once $pRootC . '/CelabServices/Models/MSearchDocument.php';
require_once $pRootC . '/CelabServices/Models/MGetContractAdditions.php';

const MOD_VINCULATION_TYPE = "MOD_VINCULATION_TYPE";
const MOD_SEARCH_CONTRACTOR = "MOD_SEARCH_CONTRACTOR";
const MOD_GET_CONTRACT_ADDS = "MOD_GET_CONTRACT_ADDS";
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
    
    case MOD_GET_CONTRACT_ADDS://Traer Adiciones de contratos
        
        $idContract = $_GET['idContract'];
        $bd = $_GET['bd'];
        echo json_encode(MGetContractAdditions::getAdditions($idContract, $bd)->fetchAll(PDO::FETCH_OBJ));
        
        break;
        
    default:
        echo MOD_ERROR;
        break;
}

$sess = new SessionVars();
$sess->destroy();
?>