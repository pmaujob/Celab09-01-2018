<?php

@session_start();
$_SESSION['pRootC'] = dirname(__FILE__);
$_SESSION['pRootHtml'] = 'http://' . $_SERVER['SERVER_NAME'] . '/Celab';
$pRootC = $_SESSION['pRootC'];
$pRootHtml = $_SESSION['pRootHtml'];

require_once $pRootC . '/Celab/Models/MRegistContractorData.php';
require_once $pRootC . '/Celab/Models/MRegistPasyvocol.php';

$opModel = $_POST['opModel'];

switch ($opModel) {

    case "MOD_VINCULATION_TYPE":

        header("Location:  $pRootHtml/CelabServices/Controllers/ManagementWS.php?opModel=" . $opModel);

        break;

    case "MOD_SEARCH_CONTRACTOR":

        $document = $_POST['document'];
        $docType = $_POST['docType'];
        header("Location:  $pRootHtml/CelabServices/Controllers/ManagementWS.php?opModel=" . $opModel . "&document=" . $document . "&docType=" . $docType);

        break;

    case "CERT_CONTRACTOR":

        $contractorData = explode(',', $_POST['contractorData']);

        $res = MRegistContractorData::registContractorEmail($contractorData[1], $contractorData[2], $contractorData[3]);

        $_SESSION['contractorData'] = $_POST['contractorData'];
        $_SESSION['contractData'] = $_POST['contractData'];
        header("Location:  $pRootHtml/CelabServices/Views/certificates/contractorCert.php");

        break;
    
    case "CERT_NO_PENSIONER":

        $noPensionerData = explode(',', $_POST['noPensionerData']);

        $res = MRegistPasyvocol::registNoPensionerEmail($noPensionerData[2], $noPensionerData[5]);

        $_SESSION['noPensionerData'] = $_POST['noPensionerData'];
        header("Location:  $pRootHtml/CelabServices/Views/certificates/noPensionerCert.php");

        break;

    case "MOD_GET_CONTRACT_ADDS":

        $idContract = $_POST['idContract'];
        $bd = $_POST['bd'];
        header("Location:  $pRootHtml/CelabServices/Controllers/ManagementWS.php?opModel=" . $opModel . "&idContract=" . $idContract . "&bd=" . $bd);

        break;

    default:

        echo "MOD_ERROR";

        break;
}
?>