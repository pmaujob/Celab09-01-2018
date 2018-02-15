<?php

date_default_timezone_set('America/Bogota');
@session_start();

if (!isset($_SESSION['noPensionerData'])) {
    return;
}

$noPensionerData = explode(',', $_SESSION['noPensionerData']);
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once $pRootC . '/Admin/Views/Certificate/CelabCertificate.php';
require_once $pRootC . '/CelabServices/Models/MRegistNoPensioner.php';
require_once MLIBPATH . 'Formats/PDFFormats.php';
require_once MLIBPATH . 'Formats/ConvertFormats.php';
require_once MLIBPATH . 'Mails/LnxMail.php';

$pdf = new CelabCertificate('P', 'mm', 'Letter'); // vertical, milimetros y tamaño
$pdf->AliasNbPages(); //llamar al header y footer
$pdf->SetMargins(20, 15, 20);
$pdf->SetAutoPageBreak(true, 30);
$pdf->AddPage();

$pdf->Ln(5);
$pdf->Cell(0, 6, utf8_decode('San Juan de Pasto, ') . ConvertFormats::formatDate(date("d-M-Y")));
$pdf->Ln(20);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, utf8_decode('LA SUBSECRETARIA DE TALENTO HUMANO'), 0, 0, 'C');
$pdf->Ln(20);
$pdf->Cell(0, 6, utf8_decode('HACE CONSTAR:'), 0, 0, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 10);
DisenoCertificacionesPDF::justificarParrafo(utf8_decode('Que revisadas las nóminas de pensionados que reposan en esta dependencia, '
                . 'NO se encontró como ' . ($noPensionerData[6] == "M" ? 'pensionado' : 'pensionada') . ' del Departamento '
                . 'de Nariño, ni gestionando pensión alguna en ésta Entidad, ' . ($noPensionerData[6] == "M" ? 'el señor' : 'la señora')
                . ' ' . strtoupper($noPensionerData[1]) . ($noPensionerData[6] == "M" ? ', identificado' : ', identificada')
                . ' con ' . $noPensionerData[2] . ' No. ' . $noPensionerData[3] . ' expedida en ' . $noPensionerData[4] . ' (' . $noPensionerData[5] . '). '), 0.96, $pdf, 0, 5);
$pdf->Ln(10);
$pdf->Cell(0, 5, utf8_decode('La presente Constancia se expide a solicitud del interesado.'));
$pdf->Ln(20);

//Histórico y Cod. Verificación
$formatedName = ConvertFormats::replaceAccent(strtoupper($noPensionerData[1]));
$codVer = substr($noPensionerData[3], -3) . date("jny") . substr($formatedName, -1) . substr($formatedName, 0, 1);
$codVer = MRegistNoPensioner::registNoPensionerHist($codVer, $noPensionerData[0], date("Y-m-d"), 'DIANA MARÍA ORTIZ JULIAO', 'Subsecretaria de Talento Humano', null)->fetch(PDO::FETCH_OBJ)->cod;

DisenoCertificacionesPDF::justificarParrafo(utf8_decode('Puede verificar la autenticidad de este certificado ingresando el código ' . $codVer . ' en el sitio web: ' . 'http://' . $_SERVER['SERVER_NAME'] . '/Celab'), 0.96, $pdf, 0, 5);
$pdf->Ln(25);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 5, utf8_decode('DIANA MARÍA ORTIZ JULIAO'));
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, utf8_decode('Subsecretaria de Talento Humano'));
$pdf->Ln();
$pdf->Cell(0, 5, utf8_decode('Gobernación de Nariño'));

$pdf->Output();

//======== Enviar Correo ======
$attachment = $pdf->Output('S', 'certificado.pdf');

$subject = utf8_decode("Certificados Laborales - CELAB");
$msg = ($noPensionerData[4] == "M" ? 'Estimado ' : 'Estimada ') . utf8_decode(ucwords($noPensionerData[1]))
        . ", adjuntamos al presente correo, copia del certificado "
        . "de No Pensionados expedido el día " . ConvertFormats::formatDate(date("d-M-Y"));
$altBody = ($noPensionerData[4] == "M" ? 'Estimado ' : 'Estimada ') . utf8_decode(ucwords($noPensionerData[1]))
        . ", adjuntamos al presente correo, copia del certificado "
        . "de No Pensionados expedido el día " . ConvertFormats::formatDate(date("d-M-Y"));

$mail = new LnxMail();
$mail->construct();
$mail->setAddress($noPensionerData[5]);
$mail->buildMail($subject, $msg, $altBody);
$mail->addFPDFAttachment($attachment, 'certificado.pdf');

//$sendedMail = $mail->send();
?>