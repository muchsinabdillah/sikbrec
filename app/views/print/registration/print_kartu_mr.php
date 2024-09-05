<?php
   date_default_timezone_set('Asia/Jakarta');

   class PDF extends FPDF
    {

   //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max(strlen($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
    }

}

//A4 width : 219 mm
// default margin : 10mm each side
// writable horizontal : 219-(10*2)=189mm
$pdf = new PDF('L','mm',array(55,85));
      $pdf->SetAutoPageBreak(false);


$pdf->AddPage();

$pdf->setFont('Arial','',7);

$nomr = $data['listdata1']['NoMR'];

require_once("../App/library/phpqrcode/qrlib.php");
//QRcode::png('https://validate.rsyarsi.co.id/validasi/'.$nomr,$nomr .".png");
QRcode::png($nomr,$nomr .".png");

$gety = $pdf->getY();

//$pdf->Cell(0,5,'',0,1);//br

//QR Code
$pdf->Image($nomr.".png", 53, $gety+8, 19, 19, "png");

$gety = $pdf->getY();

$pdf->setFont('Arial','B',7);
$pdf->Cell(0,$gety+18,'',0,1);//margin
$pdf->Cell(30,4,'',0,0);//margin
$pdf->CellFitScale(43,4,$data['listdata1']['PatientName'],0,1,'C');
$pdf->Cell(30,4,'',0,0);//margin
$pdf->Cell(43,4,$nomr,0,0,'C');

unlink($nomr.".png");


$pdf->Output();
?>
