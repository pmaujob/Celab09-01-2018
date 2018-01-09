
<?php
class PDF extends FPDF { var $widths; var $aligns; function SetWidths($w) {    $this->widths=$w;
}
 
function SetAligns($a)
{
$this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
	
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
	$p=1;
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
		
		
		$this->SetFillColor(193,193,255);
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
		
        $this->MultiCell($w,5,$data[$i],1,$a,true);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
		
    }

    $this->Ln($h);
}
function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}
function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
function Header()
{
$this->Image('imagenes/titulobpid.png',20,10,170,25);
//$this->Image('imagenes/escudo.png',20,13,15,20);	
$this->SetFont('Arial','B',20);
//$this->SetTextColor(0,0,160);
//$this->Text(40,8,'BANCO DE PROGRAMAS Y PROYECTOS',0,'C', 0);
$this->Ln(7);
//$this->Text(41,11,'DE INVERSION DEPARTAMENTAL',0,'C', 0);
$this->Ln(10);
}
 
function Footer()
{
$this->SetY(-25);
$this->SetFont('Arial','BI',8); 
$this->AliasNbPages();
//$this->SetTextColor(0,0,160);
        // $this->Cell(250,2,"Fecha de Impresion: ".date('d - m - Y')."  ",'',1,'L'); 
        //Arial italic 8 
		$this->Image('imagenes/pie.png',20,273,160,12);
        $this->SetFont('Arial','BI',8); 
        //Número de página 
		//$texto = utf8_decode('Gobernación de Nariño');
        //$this->Cell(195,4,"$texto",'T',0,'C'); 
        //$this->Cell(0,4,'Pagina '.$this->PageNo().'/{nb}','T',1,'R'); 
	   
}


}
?>