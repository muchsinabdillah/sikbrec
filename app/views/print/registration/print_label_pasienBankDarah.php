<?php
date_default_timezone_set('Asia/Jakarta');

class PDF extends FPDF
{

    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true)
    {
        //Get string width
        $str_width = $this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $ratio = ($w - $this->cMargin * 2) / $str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit) {
            if ($scale) {
                //Calculate horizontal scaling
                $horiz_scale = $ratio * 100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET', $horiz_scale));
            } else {
                //Calculate character spacing in points
                $char_space = ($w - $this->cMargin * 2 - $str_width) / max(strlen($txt) - 1, 1) * $this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET', $char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align = '';
        }

        //Pass on to Cell method
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT ' . ($scale ? '100 Tz' : '0 Tc') . ' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, true, false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, true, true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, false, false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        //Same as calling CellFit directly
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, false, true);
    }
}

//A4 width : 219 mm
// default margin : 10mm each side
// writable horizontal : 219-(10*2)=189mm
//$pdf = new PDF('L', 'mm', array(50, 80));
$pdf = new PDF('L', 'mm', array(40, 60));
$pdf->SetAutoPageBreak(false);


$pdf->AddPage();

$pdf->setFont('Arial', '', 9);

$pdf->Cell(0, -8, '', 0, 1); //br
$pdf->Cell(0, 4,'RUMAH SAKIT YARSI', 0, 1,'C');
$pdf->Cell(0, 1, '', 0, 1); //br

$pdf->setFont('Arial', '', 7);
$pdf->Cell(-5, 3, '', 0, 0); //margin
$pdf->Cell(16, 4, 'No. Bag', 0, 0);
$pdf->Cell(2, 4, ':', 0, 0);
$pdf->setFont('Arial', 'B', 7);
$pdf->Cell(50, 4, $data['listdata1']['Barcode'], 0, 1);
// $pdf->setFont('Arial', '', 12);
// $pdf->Cell(0, 4, $data['listdata1']['CC'].' cc', 0, 1);

$pdf->setFont('Arial', '', 7);
$pdf->Cell(-5, 3, '', 0, 0); //margin
$pdf->Cell(16, 4, 'EXP', 0, 0);
$pdf->Cell(2, 4, ':', 0, 0);
$pdf->Cell(50, 4, $data['listdata1']['Expired_Date'], 0, 1);


$pdf->setFont('Arial', '', 7);
$pdf->Cell(-5, 3, '', 0, 0); //margin
$pdf->Cell(16, 4, 'OS', 0, 0);
$pdf->Cell(2, 4, ':', 0, 0);
$pdf->Cell(50, 4, $data['listdata1']['PatientName'], 0, 1);
// $pdf->setFont('Arial', 'B', 15);
// $pdf->Cell(0, 4, $data['listdata1']['GolonganDarah'].$data['listdata1']['Rhesus'], 0, 1);

$pdf->setFont('Arial', '', 7);
$pdf->Cell(-5, 3, '', 0, 0); //margin
$pdf->Cell(16, 4, 'RM', 0, 0);
$pdf->Cell(2, 4, ':', 0, 0);
$pdf->Cell(40, 4, $data['listdata1']['NoMR'].' / '.$data['listdata1']['Date_of_birth'], 0, 1);

// $pdf->Cell(-2, 3, '', 0, 0); //margin
// $pdf->Cell(16, 4, 'Tgl Lahir', 0, 0);
// $pdf->Cell(2, 4, ':', 0, 0);
// $pdf->Cell(50, 4, $data['listdata1']['Date_of_birth'], 0, 0);
// $pdf->setFont('Arial', '', 12);
// $pdf->Cell(0, 4, $data['listdata1']['KeteranganDtl'], 0, 1);
//  $pdf->Cell(0, 4, '', 0, 1); //br

// $pdf->Cell(-2, 3, '', 0, 0); //margin
// $pdf->Cell(16, 4, 'Ruangan', 0, 0);
// $pdf->Cell(2, 4, ':', 0, 0);
// $pdf->Cell(100, 4, $data['listdata1']['ID_Card_Number'], 0, 1);

$pdf->setFont('Arial', '', 7);
$pdf->Cell(-5, 3, '', 0, 0); //margin
$pdf->Cell(16, 4, 'Tgl Periksa', 0, 0);
$pdf->Cell(2, 4, ':', 0, 0);
$pdf->Cell(40, 4, $data['listdata1']['DateConsume'], 0, 1);
$pdf->setFont('Arial', '', 7);
$pdf->Cell(-5, 3, '', 0, 0); //margin
$pdf->Cell(16, 4, 'Pemeriksa', 0, 0);
$pdf->Cell(2, 4, ':', 0, 0);
$pdf->Cell(40, 4, $data['listdata1']['UserConsumeName'], 0, 0);
// $pdf->Cell(-2, 3, '', 0, 0); //margin
// $pdf->Cell(16, 4, 'Jam', 0, 0);
// $pdf->Cell(2, 4, ':', 0, 0);
// $pdf->Cell(100, 4, $data['listdata1']['DateConsume'], 0, 1);
// $pdf->Cell(0, 1, '', 0, 1); //br

// $pdf->Cell(-2, 3, '', 0, 0); //margin
// $pdf->Cell(16, 4, 'MR', 0, 0);
// $pdf->Cell(2, 4, ':', 0, 0);
// $pdf->Cell(40, 4, $data['listdata1']['NoMR'], 0, 0);

// badrul
$pdf->setFont('Arial','',7);
$barcode = $data['listdata1']['Barcode'];
require_once("../App/library/phpqrcode/qrlib.php");
QRcode::png($barcode,$barcode     .".png");
// $gety = $pdf->getY();
//QR Code
$pdf->Image($barcode.".png", 10, 30, 10, 10, "png");


unlink($barcode.".png");
// $pdf->Cell(-2, 3, '', 0, 0); //margin
// $pdf->Cell(16, 4, 'Hasil', 0, 0);
// $pdf->Cell(2, 4, ':', 0, 0);
// $pdf->Cell(100, 4, $data['listdata1'][''], 0, 1);
// $pdf->Cell(0, 1, '', 0, 1); //br

$pdf->Output();
