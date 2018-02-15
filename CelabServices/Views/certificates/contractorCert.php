<?php

date_default_timezone_set('America/Bogota');
@session_start();

if (!isset($_SESSION['contractData'])) {
    return;
}

$contractorData = explode(',', $_SESSION['contractorData']);
$contractData = explode('@sltlnr', $_SESSION['contractData']);

$conHistArray = array();

$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once $pRootC . '/Admin/Views/Certificate/CelabCertificate.php';
require_once MLIBPATH . 'Formats/PDFFormats.php';
require_once MLIBPATH . 'Formats/ConvertFormats.php';
require_once MLIBPATH . 'Mails/LnxMail.php';
require_once $pRootC . '/CelabServices/Models/MGetContractAdditions.php';
require_once $pRootC . '/CelabServices/Models/MUpdateContractorData.php';

$pdf = new CelabCertificate('P', 'mm', 'Letter'); // vertical, milimetros y tamaño
$pdf->AliasNbPages(); //llamar al header y footer
$pdf->SetMargins(20, 15, 20);
$pdf->SetAutoPageBreak(true, 30);
$pdf->AddPage();

$pdf->Ln(5);
$pdf->Cell(0, 6, utf8_decode('San Juan de Pasto, ') . ConvertFormats::formatDate(date("d-M-Y")));
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 6, utf8_decode('EL DIRECTOR DEL DEPARTAMENTO ADMINISTRATIVO DE CONTRATACIÓN'), 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(0, 6, utf8_decode('CERTIFICA QUE:'), 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 8);
DisenoCertificacionesPDF::justificarParrafo(utf8_decode('El (la) Señor(a) ' . $contractorData[0] . ', identificado con cédula de ciudadanía No. ' . $contractorData[1]
                . ', celebró Contrato(s) con el Departamento de Nariño conforme a la siguiente relación: '), 0.96, $pdf);
$pdf->Ln(5);
$yPos = 0;
for ($i = 0; $i < count($contractData) - 1; $i++) {

    if ($pdf->GetY() > 220) {
        $pdf->AddPage();
    }

    $contract = explode('|', $contractData[$i]);
    $conHistArray[] = array("idCon" => $contract[7],"bd" => $contract[6]);

    $tip = strtoupper((strpos(strtoupper($contract[1]), "CONTRATO") !== false ? "" : "CONTRATO DE ") . $contract[1]);
    $conTypeLines = $pdf->getNumberLn(44, 4, utf8_decode($tip));
    $pdf->SetFont('Arial', 'B', 8);

    if ($conTypeLines == 1) {
        $pdf->Cell(45.1, 8, utf8_decode($tip), 1, 0, 'C');
    } else {
        $pdf->MultiCell(45.1, 4, utf8_decode($tip), 1, 'C');
        $pdf->backLn(65.1, $conTypeLines * 4);
    }

    $pdf->Cell(44, ($conTypeLines == 1 ? 8 : $conTypeLines * 4), utf8_decode('SUSCRIPCIÓN D/M/A'), 1, 0, 'C');
    $pdf->Cell(44, ($conTypeLines == 1 ? 8 : $conTypeLines * 4), utf8_decode('TERMINACIÓN D/M/A'), 1, 0, 'C');
    $pdf->Cell(44, ($conTypeLines == 1 ? 8 : $conTypeLines * 4), utf8_decode('VALOR'), 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(45.1, 4, 'No. ' . $contract[0], 1, 0, 'C');
    $pdf->Cell(44, 4, $contract[2], 1, 0, 'C');
    $pdf->Cell(44, 4, $contract[3], 1, 0, 'C');
    $pdf->Cell(44, 4, $contract[4], 1, 0, 'C');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln();
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode($contract[5]), 0.96, $pdf, 1);

    $additions = MGetContractAdditions::getAdditions($contract[7], $contract[6]);
    $pdf->SetFont('Arial', 'B', 8);
    foreach ($additions as $add) {

        if (!($add[2] == '1900-01-01' && $add[3] == '0')) {

            $tipAdd = "ADICIÓN ";

            if (($contract[6] == "siscon" && $add[2] != '1900-01-01' && $add[3] != '0') ||
                    ($contract[6] != "siscon" && ($add[2] != null && trim($add[2]) != "") &&
                    ($add[3] != null && trim($add[3]) != ""))) {
                $tipAdd .= 'EN TIEMPO Y VALOR';
            } else if (($contract[6] == "siscon" && $add[2] != '1900-01-01') ||
                    ($contract[6] != "siscon" && $add[2] != null && trim($add[2]) != "")) {
                $tipAdd .= 'EN TIEMPO ';
            } else if (($contract[6] == "siscon" && $add[3] != '0') ||
                    ($contract[6] != "siscon" && $add[3] != null && trim($add[3]) != "")) {
                $tipAdd .= 'EN VALOR ';
            }

            $tipAdd .= strtoupper(" A " . $tip);
            $conTypeLines = $pdf->getNumberLn(44, 4, utf8_decode($tipAdd));

            if ($conTypeLines == 1) {
                $pdf->Cell(45.1, 8, utf8_decode($tipAdd), 1, 0, 'C');
            } else {
                $pdf->MultiCell(45.1, 4, utf8_decode($tipAdd), 1, 'C');
                $pdf->backLn(65.1, $conTypeLines * 4);
            }

            $pdf->Cell(44, $conTypeLines * 4, ($add[2] == '1900-01-01' ? '-' : $add[1]), 1, 0, 'C');
            $pdf->Cell(44, $conTypeLines * 4, ($add[2] == '1900-01-01' ? '-' : $add[2]), 1, 0, 'C');
            $pdf->Cell(44, $conTypeLines * 4, ($add[3] == '0' || $add[3] == '' ? "-" : '$ ' . $add[3]), 1, 0, 'C');
            $pdf->Ln();
        }
    }
    $pdf->Ln(5);
}


$jsonConHist = ConvertFormats::convertToJsonItems($conHistArray);

//Histórico y Cod. Verificación
$formatedName = ConvertFormats::replaceAccent(strtoupper($contractorData[0]));
$codVer = substr($contractorData[1], -3) . date("jny") . substr($formatedName, -1) . substr($formatedName, 0, 1);
$codVer = MUpdateContractorData::registContractorHist($codVer, $contractorData[1], $contractorData[3], date("Y-m-d"), 'JOSE ALEXANDER ROMERO TABLA', 'Director DAC', null, $jsonConHist);

$pdf->Ln();
//opcional **************
DisenoCertificacionesPDF::justificarParrafo(utf8_decode('Se adhieren y anulan estampillas Pro desarrollo de Nariño, '
                . 'Pro cultura y Universidad de Nariño, conforme a las disposiciones pertinentes de las ordenanzas números '
                . '028 de 2010 y 005 del 18 de julio de 2012, proferidas por la Asamblea Departamental de Nariño. ' . $codVer), 0.96, $pdf);
$pdf->Ln(10);
//**************
$pdf->Cell(0, 4, utf8_decode('La presente NO es una constancia laboral.'));
$pdf->Ln(10);
$pdf->Cell(0, 4, utf8_decode('Se expide a solicitud del interesado, el día ') . ConvertFormats::formatDate(date("d-M-Y")));
$pdf->Ln(20);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 4, utf8_decode('JOSE ALEXANDER ROMERO TABLA'), 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(0, 4, utf8_decode('Director DAC.'), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Output();
//========= Guardar histórico ==========
//========= Enviar por correo ==========

$attachment = $pdf->Output('S', 'certificado.pdf');

$subject = utf8_decode("Certificados Laborales - CELAB");
$msg = "Estimado(a) " . $contractorData[0] . ", adjuntamos al presente correo, copia del certificado "
        . "de contratos expedido el día " . ConvertFormats::formatDate(date("d-M-Y"));
$altBody = utf8_decode("Estimado(a) " . $contractorData[0] . ", adjuntamos al presente correo, copia del certificado "
        . "de contratos expedido el día " . ConvertFormats::formatDate(date("d-M-Y")));

$mail = new LnxMail();
$mail->construct();
$mail->setAddress($contractorData[2]);
$mail->buildMail($subject, $msg, $altBody);
$mail->addFPDFAttachment($attachment, 'certificado.pdf');

$sendedMail = $mail->send();
?>