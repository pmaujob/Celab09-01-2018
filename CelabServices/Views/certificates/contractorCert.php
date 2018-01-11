<?php

date_default_timezone_set('America/Bogota');
@session_start();

if (!isset($_SESSION['contractData'])) {
    return;
}

$contractorData = explode(',', $_SESSION['contractorData']);
$contractData = explode('@sltlnr', $_SESSION['contractData']);

$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'fpdf/fpdf.php';
require_once MLIBPATH . 'fpdf/PDF.php';
require_once MLIBPATH . 'PDFFormats.php';
require_once MLIBPATH . 'ConvertFormats.php';
require_once $pRootC . '/CelabServices/Models/MGetContractAdditions.php';

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

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 6, utf8_decode('Libertad y Orden'), 0, 0, 'C');
$pdf->Ln(10);
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

for ($i = 0; $i < count($contractData) - 1; $i++) {

    $contract = explode('|', $contractData[$i]);

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

            if ($add[2] != '1900-01-01' && $add[3] != '0') {
                $tipAdd .= 'EN TIEMPO Y VALOR';
            } else if ($add[2] != '1900-01-01') {
                $tipAdd .= 'EN TIEMPO ';
            } else if ($add[3] != '0') {
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

$pdf->Ln();
//opcional **************
DisenoCertificacionesPDF::justificarParrafo(utf8_decode('Se adhieren y anulan estampillas Pro desarrollo de Nariño, '
                . 'Pro cultura y Universidad de Nariño, conforme a las disposiciones pertinentes de las ordenanzas números '
                . '028 de 2010 y 005 del 18 de julio de 2012, proferidas por la Asamblea Departamental de Nariño.'), 0.96, $pdf);
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
$pdf->SetFont('Arial', 'BI', 8);
$pdf->Cell(0, 4, utf8_decode('Gobernación de Nariño'));
$pdf->Ln();
$pdf->Cell(0, 4, utf8_decode('Carrera 25 No. 17-49 - Edificio de la Beneficiencia-Cuarto piso'));
$pdf->Ln();
$pdf->Cell(44, 4, utf8_decode('Pasto-Nariño Tel 7207666 Email: '));
$pdf->SetFont('Arial', 'BIU', 8);
$pdf->Cell(44, 4, utf8_decode('Contratacion@narino.gov.co'));
$pdf->Ln();
$pdf->Cell(44, 4, utf8_decode('www.narino.gov.co'));

$pdf->Output();

//========= Enviar por correo===========

$attachment = $pdf->Output('S', 'certificado.pdf');

$asunto = utf8_encode("Radicación Proyecto Bpid");
$msg = "PRUEBA ENVÍO PDF";
$altCuerpo = "PRUEBA ENVÍO PDF";

$correo = new Correos();
$correo->raiz = $raiz;
$correo->inicializar();
$correo->setDestinatario("danielernestodaza@hotmail.com");
$correo->armarCorreo($asunto, $msg, $altCuerpo);

$correoEnviado = $correo->enviar();

$intentos = 1;
while ((!$correoEnviado) && ($intentos < 3)) {
    sleep(5);
    $correoEnviado = $correo->enviar();
    $intentos++;
}

?>