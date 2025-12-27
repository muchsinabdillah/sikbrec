<?php
date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/y H:i:s");

//$GLOBALS['identitas_pasien'] = $data['hdr']['data'];

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



date_default_timezone_set('Asia/Jakarta');
//$datenow = Date("d/m/Y H:i:s");
$datenow = Utils::seCurrentDateTime();
$pdf = new PDF('L', 'mm', 'A5');
$pdf->SetAutoPageBreak(true,2);
//$datereal = date('d-m-Y');
$daterreal = Utils::datenowcreateNotFull();

$pdf->AddPage();
$pdf->Image('../public/images/yarsi.png', 10, 8, 40);
$pdf->Ln(-5);
// cell(widht, height, text, border, end line , [ALIGN] )

// cell(widht, height, text, border, end line , [ALIGN] )
////potrait
// $pdf->Cell(75, 4, '', 0, 0);
// $pdf->SetFont('Arial', '', 7);
// $pdf->Cell(50, 3, 'No:031/FRM/IRJ/BPJS?RSY?Rev0/II/2021', 1, 1, 'L');
// $pdf->Cell(0, 2, '', 0, 1);
// $pdf->Cell(75, 3, '', 0, 0);
// $pdf->Cell(25, 3, 'Jl. Letjen Suprapto, Kav. 13 Cempaka Putih, ', 0, 1, 'L');
// $pdf->Cell(75, 3, '', 0, 0);
// $pdf->Cell(25, 3, 'Jakarta Pusat 10510', 0, 1, 'L');
// $pdf->Cell(75, 3, '', 0, 0);
// $pdf->Cell(25, 3, 'Telp: 021-80618618, 80618619 (Hunting),', 0, 1, 'L');
// $pdf->Cell(75, 3, '', 0, 0);
// $pdf->Cell(25, 3, 'www.rsyarsi.co.id', 0, 1, 'L');

//landscape
$pdf->Cell(135, 4, '', 0, 0);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(50, 4, 'No:031/FRM/IRJ/BPJS/RSY/Rev0/II/2021', 1, 1, 'L');
$pdf->Cell(0, 2, '', 0, 1);
$pdf->Cell(135, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Jl. angkasa No.19, Dukuhkrikil', 0, 1, 'L');
$pdf->Cell(135, 3, '', 0, 0);
$pdf->Cell(25, 3, '-', 0, 1, 'L');
$pdf->Cell(135, 3, '', 0, 0);
$pdf->Cell(25, 3, '-', 0, 1, 'L');
$pdf->Cell(135, 3, '', 0, 0);
$pdf->Cell(25, 3, '-, 0, 1, 'L');

//garis----
// $pdf->SetFont('Arial', 'U', 10);
// $pdf->Cell(6, 6, '', 0, 0);
// $pdf->Cell(180, 0, '', 1, 1);

//make a dummy empty cell as a vertical spacer

$pdf->setFont('Arial', 'Bu', 12);
$pdf->Cell(0, 6, 'BUKTI PELAYANAN PASIEN', 'LTR', 1, 'C'); 
$pdf->Cell(0, 6, 'JAMINAN BPJS KESEHATAN RAWAT JALAN', 'LBR', 1, 'C'); 

// $pdf->Image('../public/images/bismillah.png', 80, 30, 50, 'C');
// $pdf->Ln(10);

$pdf->Cell(0, 3, '', 0, 1); //br
$pdf->setFont('Arial', '', 9);


//HEADER--------------------------
//row 1 (left)-------------------
//(width,heigth,isi, border, tr)
$pdf->Cell(5, 7, '', 0, 0);
$pdf->Cell(50,4, 'NAMA PASIEN', 0, 0);
$pdf->Cell(3,4, ':', 0, 0);
$pdf->Cell(65,4, $data['listdata']['data']['NamaPasien'], 0, 1);

$pdf->Cell(5, 7, '', 0, 0);
$pdf->Cell(50,4, 'NO REKAM MEDIS', 0, 0);
$pdf->Cell(3,4, ':', 0, 0);
$pdf->Cell(65,4, $data['listdata']['data']['NoMR'], 0, 1);

$pdf->Cell(5, 7, '', 0, 0);
$pdf->Cell(50,4, 'TANGGAL LAHIR', 0, 0);
$pdf->Cell(3,4, ':', 0, 0);
$pdf->Cell(65,4, date('d/m/Y', strtotime($data['listdata']['data']['Tgl_Lahir'])), 0, 1);

$pdf->Cell(5, 7, '', 0, 0);
$pdf->Cell(50,4, 'POLIKLINIK', 0, 0);
$pdf->Cell(3,4, ':', 0, 0);
$pdf->Cell(65,4, $data['listdata']['data']['NamaUnit'], 0, 1);

$pdf->Cell(5, 7, '', 0, 0);
$pdf->Cell(50,4, 'DPJP', 0, 0);
$pdf->Cell(3,4, ':', 0, 0);
$pdf->Cell(65,4, $data['listdata']['data']['NamaDokter'], 0, 1);

$pdf->Cell(5, 7, '', 0, 0);
$pdf->Cell(50,4, 'TANGGAL JAM PELAYANAN', 0, 0);
$pdf->Cell(3,4, ':', 0, 0);
$pdf->Cell(65,4, date('d/m/Y', strtotime($data['listdata']['data']['TglKunjungan'])), 0, 1);

$pdf->Cell(0, 2, '', 0, 1); //br

//ver 1
$pdf->Cell(8, 7, '', 0, 0);
$pdf->Cell(25, 5, 'DIAGNOSA', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->MultiCell(0, 5, $data['listdata']['data']['Diagnosa'], 0, 1);

$pdf->Cell(0, 3, '', 0, 1); //br

$pdf->Cell(8, 7, '', 0, 0);
$pdf->Cell(25, 5, 'TINDAKAN', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->MultiCell(0, 5, $data['listdata']['data']['Tindakan'], 0, 1);
//#endver

// //ver 2
// $pdf->Cell(8, 7, '', 0, 0);
// $pdf->Cell(25, 5, 'DIAGNOSA', 0, 0);

// $pdf->Cell(70, 5, '', 0, 0);
// $pdf->Cell(25, 5, 'KODE ICD X', 0, 1);
// $pdf->Cell(100, 5, $data['listdata']['data']['Diagnosa'], 1, 0);
// $pdf->Cell(90, 5,'', 1, 1);

// $pdf->Cell(0, 3, '', 0, 1); //br

// $pdf->Cell(8, 7, '', 0, 0);
// $pdf->Cell(25, 5, 'TINDAKAN', 0, 0);

// $pdf->Cell(70, 5, '', 0, 0);
// $pdf->Cell(25, 5, 'KODE ICD 9-CM', 0, 1);
// $pdf->Cell(100, 5, $data['listdata']['data']['Tindakan'], 1, 0);
// $pdf->Cell(90, 5, '', 1, 1);
// //#endver2

$pdf->Cell(0, 5, '', 0, 1); //br
$pdf->setFont('Arial', 'B', 9);

$pdf->Cell(5, 7, '', 0, 0);
$pdf->Cell(28, 5, 'TINDAK LANJUT', 0, 0);
$pdf->Cell(3, 5, ':', 0, 0);
$pdf->Cell(65, 5, $data['listdata']['data']['TindakLanjut'], 0, 1);




$pdf->Cell(0, 3, '', 0, 1); //br
$pdf->setFont('Arial', '', 9);

$pdf->Cell(30, 5, '', 0, 0);
$pdf->Cell(35, 5, 'Dokter', 0, 0,'C');
$pdf->Cell(60, 5, '', 0, 0);
$pdf->Cell(35, 5, 'Pasien/Keluarga', 0, 1,'C');



    //Garis---
  //$pdf->Line(15, $gety, 210-15, $gety);
  //QR Code

  if ($data['listdata']['data']['NoSEP'] != null){
    $qr_pasien = $data['listdata']['data']['NoSEP'];
  }else if ($data['listdata']['data']['NoRegistrasi'] != null){
    $qr_pasien = $data['listdata']['data']['NoRegistrasi'];
  }else{
    $qr_pasien = 'nodata';
  }

  if ($data['listdata']['data']['NamaDokter'] != null){
    $qr_dokter = $data['listdata']['data']['NamaDokter'];
  }else{
    $qr_dokter = 'nodata2';
  }
  

$pdf->Cell(0, 5, '', 0, 1);
$pdf->Cell(30, 5, '', 0, 0);
//$qr_dokter = $data['listdata']['data']['NamaDokter'];
require_once("../App/library/phpqrcode/qrlib.php");
QRcode::png($qr_dokter, $qr_dokter .".png");
$gety = $pdf->getY();
$pdf->Image($qr_dokter.".png", 50, $gety-5, 15, 15, "png");
$pdf->Cell(90, 10, '', 0, 0);
// $qr_pasien = $data['listdata']['data']['NoSEP'] == null ? $data['listdata']['data']['NoRegistrasi'] : $data['listdata']['data']['NoSEP'];
//require_once("../App/library/phpqrcode/qrlib.php");
QRcode::png($qr_pasien, $qr_pasien .".png");
$pdf->Image($qr_pasien.".png", 145, $gety-5, 15, 15, "png");

$pdf->Cell(0, 10, '', 0, 1);

$pdf->Cell(15, 15, '', 0, 0);
$pdf->CellFitScale(70, 5,  $data['listdata']['data']['NamaDokter'] == null ? '-' : $data['listdata']['data']['NamaDokter'], 0, 0,'C');
$pdf->Cell(32, 5, '', 0, 0);
$pdf->CellFitScale(50, 5,  $data['listdata']['data']['NamaPasien'] == null ? '-' : $data['listdata']['data']['NamaPasien'], 0, 1,'C');

unlink($qr_dokter.".png");
unlink($qr_pasien.".png");


$fileName = $data['listdata']['data']['NamaPasien'].' - '.$data['listdata']['data']['NoSEP'].'.pdf';
$pdf->Output($fileName, 'I');
