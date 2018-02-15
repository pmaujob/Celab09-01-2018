<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'fpdf/fpdf.php';
require_once MLIBPATH . 'Formats/ConvertFormats.php';

class CelabCertificate extends FPDF {

    function header() {

        $this->SetFont('Arial', 'I', 10);
        $this->Image('certImages/colombia_escudo.png', 34, 17, 13);
        $this->Image('certImages/logo-client.png', 125, 17, 15);
        $this->Ln(5);
        $this->Cell(151.5, 6, utf8_decode('Departamento'), 0, 0, 'R');
        $this->Ln(4);
        $this->Cell(177, 6, utf8_decode('Administrativo de Contratación'), 0, 0, 'R');
        $this->Ln(6);

        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 6, utf8_decode('Libertad y Orden'), 0, 0, 'C');
        $this->Ln(15);
        
    }

    function footer() {

        $this->SetY(-30);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 4, utf8_decode('Gobernación de Nariño - Calle 19 No. 23-78 Pasto Nariño (Colombia)'), 0, 0, 'C');
        $this->Ln();
        $this->Cell(0, 4, utf8_decode('Línea Gratuita 01 8000 94 98 98 Pbx (57) 27235003'), 0, 0, 'C');
        $this->Ln();
        $this->Cell(0, 4, utf8_decode('www.nariño.gov.co - contactenos@narino.gov.co'), 0, 0, 'C');
            
    }

}
?>

