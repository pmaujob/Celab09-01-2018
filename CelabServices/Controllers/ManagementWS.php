<?php
@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Access/SessionVars.php';
require_once MLIBPATH . 'Formats/ConvertFormats.php';
require_once MLIBPATH . 'Mails/LnxMail.php';
require_once $pRootC . '/CelabServices/Models/MGetTipoVinculacion.php';
require_once $pRootC . '/CelabServices/Models/MSearchDocument.php';
require_once $pRootC . '/CelabServices/Models/MGetContractAdditions.php';
require_once $pRootC . '/CelabServices/Models/MRegistNoPensioner.php';
require_once $pRootC . '/CelabServices/Models/MGetPlaces.php';
require_once $pRootC . '/Celab/Models/MGetContIdentType.php';

class ManagementWS {

    public static function getVinculationType() {
        return json_encode(MGetVinculationType::getTypes()->fetchAll(PDO::FETCH_OBJ));
    }

    public static function searchContractor($document, $docType) {
        return json_encode(MSearchDocument::getContracts($document, $docType)->fetchAll(PDO::FETCH_OBJ));
    }

    public static function getDocumentType() {
        return json_encode(GetContIdentType::getTipoIdent()->fetchAll(PDO::FETCH_OBJ));
    }

    public static function getPlaces($codDep) {
        return json_encode(MGetPlaces::getPlaces($codDep)->fetchAll(PDO::FETCH_OBJ));
    }

    public static function getContractAdds($idContract, $bd) {
        return json_encode(MGetContractAdditions::getAdditions($idContract, $bd)->fetchAll(PDO::FETCH_OBJ));
    }

    public static function registNoPensioner($noPensionerData) {

        $newArray = array("firstName" => $noPensionerData[0],
            "lastName" => $noPensionerData[1],
            "sex" => $noPensionerData[2],
            "email" => $noPensionerData[3],
            "docType" => $noPensionerData[4],
            "docNum" => $noPensionerData[5],
            "town" => $noPensionerData[6]);

        $res = MRegistNoPensioner::registNoPensioner(json_encode($newArray, JSON_UNESCAPED_SLASHES))->fetch(PDO::FETCH_OBJ)->id;

        if (trim($res) != "-1" && trim($res) != "0") {

            $sha1 = sha1($res . $noPensionerData[5]);
            $subject = utf8_decode("Confirmación de Registro - CELAB");
            ob_start();
            ?>
            <span><strong>Estimado <?php echo $noPensionerData[0] . " " . $noPensionerData[1]; ?></strong></span>
            <br>
            <p style="text-align: justify;">El presente correo se envió con el fin de  
                confirmar su registro. Su cuenta se encuentra inactiva, para activarla debe entrar al siguiente link:           
            </p>
            <a href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/CelabWeb/Views/NoPensioner/frmConfirmNoPensionerEmail.php?confirmValue=" . $sha1 ?>">CLICK AQUÍ</a>
            <?php
            $msg = ob_get_clean();
            $altBody = utf8_decode("Estimado(a) " . $noPensionerData[0] . " " . $noPensionerData[1]
                    . ", El presente correo se envió con el fin de "
                    . "confirmar su registro. Su cuenta se encuentra inactiva, "
                    . "para activarla debe entrar al siguiente link: "
                    . "http://" . $_SERVER['SERVER_NAME'] . "/CelabWeb/Views/NoPensioner/frmConfirmNoPensionerEmail.php?confirmValue=" . $sha1);

            $mail = new LnxMail();
            $mail->construct();
            $mail->setAddress($noPensionerData[3]);
            $mail->buildMail($subject, $msg, $altBody);

            $sendedMail = $mail->send();
        }

        return $res;
    }

    public static function confirmNoPensioner($sha1) {

        $res = MRegistNoPensioner::confirmNoPensioner($sha1)->fetch(PDO::FETCH_OBJ);
        return $res->res . ',' . $res->doc;
    }

}

//$sess = new SessionVars();
//$sess->destroy();
?>