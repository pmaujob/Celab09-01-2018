<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Formats/ConvertFormats.php';
require_once $pRootC . '/Celab/Models/MRegistPasyvocol.php';

class CImportPasyvocol {

    public function validateData($noPensionerArray) {

        $newArray = array();

        foreach ($noPensionerArray as $object) {

            
            $abState = '';
            switch (strtolower($object[5])) {

                case "casado":

                    $abState = 'C';
                    break;

                case "divorciado/separado":

                    $abState = "D";
                    break;

                case "soltero":

                    $abState = "S";
                    break;

                case "unión libre":

                    $abState = "L";
                    break;

                case "viudo":

                    $abState = "V";
                    break;

                default:

                    echo "El estado '" . strtolower($object[5]) . "' no se identifica.";
                    return;
                    
            }

            $newObj = array(
                "personName" => $object[2],
                "doc" => str_replace(".", "", $object[1]),
                "docType" => $object[0],
                "emType" => ($object[3] == "Oficial" ? "O" : "P"),
                "genre" => ($object[4] == "Masculino" ? "M" : "F"),
                "estType" => $abState,
                "birthDate" => ConvertFormats::formatBDDate('d/m/Y', $object[6]),
                "spouseDate" => ($object[7] == "" ? "null" : ConvertFormats::formatBDDate('d/m/Y', $object[7])),
                "basicSalary" => str_replace(".", "", $object[8]),
                "joinDate" => ConvertFormats::formatBDDate('d/m/Y', $object[9]),
                "leaveDate" => ConvertFormats::formatBDDate('d/m/Y', $object[10])
            );

            $newArray[] = $newObj;
        }        
        
        return MRegistPasyvocol::registPasyvocol(ConvertFormats::convertToJsonItems($newArray));
    }

}

$noPensionerArray = array();
$noPensionerArray = $_POST['noPensionerArray'];
$importPas = new CImportPasyvocol();

echo $importPas->validateData($noPensionerArray);
?>