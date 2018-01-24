<?php

date_default_timezone_set('America/Bogota');
@session_start();

if (!isset($_SESSION['noPensionerData'])) {
    return;
}

$noPensionerData = explode(',', $_SESSION['noPensionerData']);
$pRootC = $_SESSION['pRootC'];
require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'fpdf/fpdf.php';
require_once MLIBPATH . 'fpdf/PDF.php';
require_once MLIBPATH . 'Formats/PDFFormats.php';
require_once MLIBPATH . 'Formats/ConvertFormats.php';
require_once MLIBPATH . 'Mails/LnxMail.php';

$pdf = new FPDF('P', 'mm', 'Letter'); // vertical, milimetros y tamaño
$pdf->SetMargins(20, 15, 20);
$pdf->AddPage();
$pdf->SetFont('Arial', 'I', 10);

$pdf->Image('certImages/colombia_escudo.png', 34, 17, 13);
$pdf->Image('certImages/logo-client.png', 125, 17, 15);
$pdf->Ln(5);
$pdf->Cell(151.5, 6, utf8_decode('Departamento'), 0, 0, 'R');
$pdf->Ln(4);
$pdf->Cell(177, 6, utf8_decode('Administrativo de Contratación'), 0, 0, 'R');
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 6, utf8_decode('Libertad y Orden'), 0, 0, 'C');
$pdf->Ln(20);
$pdf->Cell(0, 6, utf8_decode('San Juan de Pasto, ') . ConvertFormats::formatDate(date("d-M-Y")));
$pdf->Ln(20);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, utf8_decode('LA SUBSECRETARIA DE TALENTO HUMANO'), 0, 0, 'C');
$pdf->Ln(20);
$pdf->Cell(0, 6, utf8_decode('HACE CONSTAR:'), 0, 0, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 10);
DisenoCertificacionesPDF::justificarParrafo(utf8_decode('Que revisadas las nóminas de pensionados que reposan en esta dependencia, '
                . 'NO se encontró como ' . ($noPensionerData[4] == "M" ? 'pensionado' : 'pensionada') . ' del Departamento '
                . 'de Nariño, ni gestionando pensión alguna en ésta Entidad, ' . ($noPensionerData[4] == "M" ? 'el señor' : 'la señora')
                . ' ' . utf8_decode(strtoupper($noPensionerData[1]))) . ($noPensionerData[4] == "M" ? ', identificado' : ', identificada')
        . ' con ' . utf8_decode($noPensionerData[3]) . ' No. ' . $noPensionerData[2] . '.', 0.96, $pdf, 0, 5);
$pdf->Ln(10);
$pdf->Cell(0, 5, utf8_decode('La presente Constancia se expide a solicitud del interesado.'));
$pdf->Ln(30);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 5, utf8_decode('DIANA MARÍA ORTIZ JULIAO'));
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, utf8_decode('Subsecretaria de Talento Humano'));
$pdf->Ln();
$pdf->Cell(0, 5, utf8_decode('Gobernación de Nariño'));
footer($pdf);
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

$sendedMail = $mail->send();

function footer($pdf) {
    $pdf->SetY(-33);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 4, utf8_decode('Gobernación de Nariño - Calle 19 No. 23-78 Pasto Nariño (Colombia)'), 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0, 4, utf8_decode('Línea Gratuita 01 8000 94 98 98 Pbx (57)27235003'), 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0, 4, utf8_decode('www.nariño.gov.co - contactenos@narino.gov.co'), 0, 0, 'C');
}

?>