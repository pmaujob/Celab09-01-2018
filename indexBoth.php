<?php

@session_start();
$_SESSION['pRootC'] = dirname(__FILE__);
$_SESSION['pRootHtml'] = 'http://' . $_SERVER['SERVER_NAME'] . '/Celab';
$pRootC = $_SESSION['pRootC'];
$pRootHtml = $_SESSION['pRootHtml'];

require_once $pRootC . '/Celab/Models/MRegistContractorData.php';
require_once $pRootC . '/Celab/Models/MRegistPasyvocol.php';
require_once $pRootC . '/CelabServices/Controllers/ManagementWS.php';

$opModel = $_POST['opModel'];
switch ($opModel) {

    case "MOD_VINCULATION_TYPE":

        echo ManagementWS::getVinculationType();
        break;

    case "MOD_SEARCH_CONTRACTOR":

        echo ManagementWS::searchContractor($_POST['document'], $_POST['docType']);
        break;

    case "MOD_GET_DOCUMENT_TYPE":

        echo ManagementWS::getDocumentType();
        break;

    case "MOD_GET_PLACES":

        echo ManagementWS::getPlaces($_POST['codDep']);
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

        echo ManagementWS::getContractAdds($_POST['idContract'], $_POST['bd']);
        break;

    case "MOD_REGIST_NO_PENSIONER":

        $noPensionerData = array();
        $noPensionerData = $_POST['noPensionerData'];
        echo ManagementWS::registNoPensioner($noPensionerData);

        break;

    case "MOD_CONFIRM_NO_PENSIONER":

        echo ManagementWS::confirmNoPensioner($_POST['sha1']);
        break;

    default:

        echo "MOD_ERROR";
        break;
}
?>