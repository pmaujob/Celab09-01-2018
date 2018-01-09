<?php

require_once 'fpdf/fpdf.php';
require_once 'fpdf/PDF.php';

class DisenoCertificacionesPDF {

    public static function justificarParrafo($strOriginal, $noCols, $pdf, $border = 0, $iAlturaRow = 4) {
        $iMaxCharRow = 170; //Número máximo de caracteres por renglón 
        $iSizeMultiCell = $iMaxCharRow / $noCols; //Tamaño ancho para la columna
        $iTotalCharMax = 9957; //Número máximo de caracteres por página 
        $iCharPerCol = $iTotalCharMax / $noCols; //Caracteres por Columna    
        $iCharPerCol = $iCharPerCol - 290; //Ajustamos el tamaño aproximado real del número de caracteres por columna 
        $iLenghtStrOriginal = strlen($strOriginal); //Tamaño de la cadena original 
        $iPosStr = 0; // Variable de la posición para la extracción de la cadena. 
        // get current X and Y 
        $start_x = $pdf->GetX(); //Posición Actual eje X 
        $start_y = $pdf->GetY(); //Posición Actual eje Y 
        $cont = 0;
        while ($iLenghtStrOriginal > $iPosStr) { // Mientras la posición sea menor al tamaño total de la cadena entonces imprime 
            $strCur = substr($strOriginal, $iPosStr, $iCharPerCol); //Obtener la cadena actual a pintar 
            if ($cont != 0) { //Evaluamos que no sea la primera columna 
                // seteamos a X y Y, siendo el nuevo valor para X 
                // el largo de la multicelda por el número de la columna actual, 
                // más 10 que sumamos de separación entre multiceldas 
                $pdf->SetXY(($iSizeMultiCell * $cont) + 10, $start_y); //Calculamos donde iniciará la siguiente columna 
            }
            $pdf->MultiCell($iSizeMultiCell, $iAlturaRow, $strCur, $border); //Pintamos la multicelda actual 
            $iPosStr = $iPosStr + $iCharPerCol; //Posicion actual de inicio para extracción de la cadena 
            $cont++; //Para el control de las columnas 
        }

        return $pdf;
    }

    public static function getNumeroLineas($noCols, $lineHeight = 4) {

        $iMaxCharRow = 170; //Número máximo de caracteres por renglón 
        $iSizeMultiCell = $iMaxCharRow / $noCols; //Tamaño ancho para la columna
        return $iSizeMultiCell / $lineHeight;
    }

}

?>