<?php
$GLOBALS['header'] = $data['listdataheader'];
$GLOBALS['detail'] = $data['listdatadetail'];
$GLOBALS['headercetakanx'] = $data['headercetakan'];



// var_dump($GLOBALS['header']);
// var_dump(count($GLOBALS['detail']));
// $GLOBALS['header'] = $data['listdatadetail'];

class PDF extends Tcpdf
{
    function Header()
    {

        $this->setFont('', '', 9);
        // $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World', 20, 5, 40, 0, 'PNG');
        $this->Image('../public/images/yarsi.png', 5, 5, 40);
        $this->Ln(5);
        $this->Cell(206, 4, '', 0, 0);
        $this->Cell(59, 4, $GLOBALS['headercetakanx']['AlamatRS'], 0, 1);
        $this->Cell(220, 4, '', 0, 0);
        $this->Cell(59, 4, $GLOBALS['headercetakanx']['KotaName'].', '.$GLOBALS['headercetakanx']['ProvinsiName'].' '.$GLOBALS['headercetakanx']['Kodepos'], 0, 1);
        $this->Cell(247, 4, '', 0, 0);
        $this->Cell(59, 4, 'Telp : '.$GLOBALS['headercetakanx']['Phone'], 0, 1);
        $this->Cell(225, 4, '', 0, 0);
        $this->Cell(59, 4, 'Email  : '.$GLOBALS['headercetakanx']['Email'], 0, 1);
        $this->SetFont('', 'B', 11);
        $this->Cell(5, 1, '', 0, 1);
        // $this->Cell(5, 4, '', 0, 0);
        $this->Cell(50, 4, 'INFORMASI REKAP KASIR DETAIL', 0, 0,'');
        $this->SetFont('', '', 9);
        $this->Cell(189, 4, '', 0, 0);
        $this->Cell(59, 4, $GLOBALS['headercetakanx']['Email'], 0, 1);
        $this->Cell(5, 1, '', 0, 1);
        $this->SetFont('', '', 10);
        // $this->Cell(5, 5, '', 0, 0);
        $this->Cell(15, 5, 'Periode    ', 0, 0);
        $this->Cell(15, 5, '', 0, 0);
        $this->Cell(3, 5, ': ', 0, 0);
        $this->Cell(60, 5, $GLOBALS['header']['data']['TglAwal'] . " s/d " . $GLOBALS['header']['data']['TglAkhir'], 0, 0);
        $this->Cell(25, 5, ' Jenis Payment', 0, 0);
        $this->Cell(15, 5, '', 0, 0);
        $this->Cell(3, 5, ': ', 0, 0);
        $this->Cell(60, 5, $GLOBALS['header']['data']['tipepembayaran'], 0, 1);
        // $this->Cell(5, 5, '', 0, 0);
        $this->Cell(17, 5, 'Nama Kasir', 0, 0);
        $this->Cell(13, 5, '', 0, 0);
        $this->Cell(3, 5, ': ', 0, 0);
        $this->Cell(60, 5, $GLOBALS['header']['data']['kasir'], 0, 0);
        $this->Cell(25, 5, ' Jenis Pasien', 0, 0);
        $this->Cell(15, 5, '', 0, 0);
        $this->Cell(3, 5, ': ', 0, 0);
        $this->Cell(60, 5, $GLOBALS['header']['data']['jenispasien'], 0, 1);
        // $this->Cell(5, 5, '', 0, 0);
        // $this->Cell(15, 5, 'Jam          ', 0, 0);
        // $this->Cell(15, 5, '', 0, 0);
        // $this->Cell(3, 5, ': ', 0, 0);
        // $this->Cell(60, 5, '12:12:12 - 12:12:21', 0, 1);
        //Margin top

        //BR
        $this->Cell(0, 4, '', 0, 1);

        $this->Cell(10, 3, '', 0, 1);   

        //Line 1
        // $this->SetFont('', 'B', 12);
        // $this->Cell(5, 7, '', 0, 0);
        // $this->Cell(0, 1, 'LAPORAN KASIR', 'B', 0, 'C');

        $border = 0;
        $h = 6;
    }
    function Footer()
    {
        // $datenowx = date('d/m/y      H:i');
        // // Position at 1.5 cm from bottom
        // $this->SetTextColor(0, 0, 0);
        // $this->SetY(-37);
        // $this->SetFont('', 'U', 8);
        // $this->Cell(15, 4, '', 0, 0);
        // $this->Cell(10, 4, '                                                                                                                                           Approved by Radiologist : dr. Tia Bonita Sp.Rad', 0, 1);
        // $this->SetFont('', '', 8);
        // $this->Cell(15, 4, '', 0, 0);
        // //$this->Cell(65,4,'Validated by :'.$GLOBALS['footer']['Validate_by'],0,0);
        // $this->Cell(65, 4, 'Taken by Radiographer:', 0, 0);
        // $this->Cell(55, 4, '*(do not need sign)', 0, 0);
        // $this->Cell(35, 4, $datenowx, 0, 1);
        // $this->Cell(15, 4, '', 0, 0);
        // $this->Cell(55, 4, 'Sri Mulyani,A.Md.Rad', 0, 0);
        // //$this->Image('../public/images/footer2.png',175, 265, 30,'R');
        // $this->Image('../public/images/LogoGabungCert.png', 155, 265, 43, 'R');
        // $this->Image('../public/images/footer_1.png', 0, 284, 210, 13);
    }
}

// $GLOBALS['detail'] = $data['detail'][0];



$pdf = new PDF('l', 'mm', 'A4');
$pdf->SetAutoPageBreak(TRUE, 35);
$pdf->SetMargins(PDF_MARGIN_LEFT - 10, PDF_MARGIN_TOP + 20, PDF_MARGIN_RIGHT);
$pdf->AddPage();

$noborder = 0;
$border = 1;
$h = 6;
$hb = 10;

$pdf->setFont('', 'B', 9);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(25, $hb, 'TGL / NO TRANSAKSI', $border, 1);
$pdf->SetXY($x + 25, $y);
$pdf->MultiCell(25, $hb, 'NO REGISTRASI', $border, 1);
$pdf->SetXY($x + 50, $y);
$pdf->MultiCell(35, $hb, "NAMA PASIEN\n ", $border, 1);
$pdf->SetXY($x + 85, $y);
$pdf->MultiCell(35, $hb, 'NAMA UNIT / JAMINAN', $border, 1);
$pdf->SetXY($x + 120, $y);
$pdf->MultiCell(35, $hb, "NAMA DOKTER\n ", $border, 1);
$pdf->SetXY($x + 155, $y);
$pdf->MultiCell(25, $hb, 'NOMINAL BAYAR', $border, 1);
$pdf->SetXY($x + 180, $y);
$pdf->MultiCell(21, $hb, "CASH\n ", $border, 1);
$pdf->SetXY($x + 201, $y);
$pdf->MultiCell(21, $hb, "DEBIT\n ", $border, 1);
$pdf->SetXY($x + 222, $y);
$pdf->MultiCell(21, $hb, "KREDIT\n ", $border, 1);
$pdf->SetXY($x + 243, $y);
$pdf->MultiCell(21, $hb, "PIUTANG\n ", $border, 1);
$pdf->SetXY($x + 264, $y);
$pdf->MultiCell(21, $hb, "QRIS\n ", $border, 1);



$countDetail = count($GLOBALS['detail']);
// var_dump($x);
// exit;
$hb = 10;
$totalnominalbayar = 0;
$totalcash = 0;
$totaldebit = 0;
$totalkredit = 0;
$totalpiutang = 0;
$totalqris = 0;
for ($i = 0; $i < $countDetail; $i++) {
    // var_dump($i);
    // exit;
    $totalnominalbayar = $totalnominalbayar + $GLOBALS['detail'][$i]['Nominal_Bayar'];
    $totalcash = $totalcash + $GLOBALS['detail'][$i]['Cash'];
    $totaldebit = $totaldebit + $GLOBALS['detail'][$i]['Debit'];
    $totalkredit = $totalkredit + $GLOBALS['detail'][$i]['Kredit'];
    $totalpiutang = $totalpiutang + $GLOBALS['detail'][$i]['Piutang'];
    $totalqris = $totalqris + $GLOBALS['detail'][$i]['Qris'];
    $pdf->setFont('', '', 7);
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(25, $hb, $GLOBALS['detail'][$i]['TGL_Transaksi'] . "\n" . $GLOBALS['detail'][$i]['NoTransaksi'], $border, 1);
    $pdf->SetXY($x + 25, $y);
    $pdf->MultiCell(25, $hb, $GLOBALS['detail'][$i]['NoReg'], $border, 1);
    $pdf->SetXY($x + 50, $y);
    $pdf->MultiCell(35, $hb,  $GLOBALS['detail'][$i]['NamaPasien'], $border, 1);
    $pdf->SetXY($x + 85, $y);
    $pdf->MultiCell(35, $hb, $GLOBALS['detail'][$i]['Nama_Unit'] . "\n" . $GLOBALS['detail'][$i]['NamaJaminan'], $border, 1);
    $pdf->SetXY($x + 120, $y);
    $pdf->MultiCell(35, $hb, $GLOBALS['detail'][$i]['Nama_Dokter'], $border, 1);
    $pdf->SetXY($x + 155, $y);
    $pdf->MultiCell(25, $hb, number_format($GLOBALS['detail'][$i]['Nominal_Bayar']), $border, 1);
    $pdf->SetXY($x + 180, $y);
    $pdf->MultiCell(21, $hb, number_format($GLOBALS['detail'][$i]['Cash']), $border, 1);
    $pdf->SetXY($x + 201, $y);
    $pdf->MultiCell(21, $hb, number_format($GLOBALS['detail'][$i]['Debit']), $border, 1);
    $pdf->SetXY($x + 222, $y);
    $pdf->MultiCell(21, $hb, number_format($GLOBALS['detail'][$i]['Kredit']), $border, 1);
    $pdf->SetXY($x + 243, $y);
    $pdf->MultiCell(21, $hb, number_format($GLOBALS['detail'][$i]['Piutang']), $border, 1);
    $pdf->SetXY($x + 264, $y);
    $pdf->MultiCell(21, $hb, number_format($GLOBALS['detail'][$i]['Qris']), $border, 1);
}
$pdf->setFont('', 'B', 7);
$pdf->Cell(155, $hb, 'GRAND TOTAL', $border, 0, 'C');
$pdf->Cell(25, $hb, number_format($totalnominalbayar), $border, 0);
$pdf->Cell(21, $hb, number_format($totalcash), $border, 0);
$pdf->Cell(21, $hb, number_format($totaldebit), $border, 0);
$pdf->Cell(21, $hb, number_format($totalkredit), $border, 0);
$pdf->Cell(21, $hb, number_format($totalpiutang), $border, 0);
$pdf->Cell(21, $hb, number_format($totalqris), $border, 1);

$pdf->Cell(5, 5, '', $noborder, 1);
$pdf->Cell(10, $h, 'Brebes,', $noborder, 0,'C');
$pdf->Cell(3, $h, '', $noborder, 0);
$pdf->Cell(0, $h, $GLOBALS['header']['data']['dateCreate'], $noborder, 1);

//br

//br
$pdf->Cell(15, $h, '', $noborder, 0);
$pdf->Cell(85, $h, 'Petugas Kasir,', $noborder, 0); 
$pdf->Cell(20, $h, 'Petugas Verifikasi,', $noborder, $noborder, 1); 

//ttd
// $pdf->Image($Datas['header']['ParafDokter'], 15, 175, 50);
//ttd

//br
$pdf->Cell(0, 15, '', $noborder, 1);
//br
 
$pdf->Cell(5, $h, '(', $noborder, 0);
$pdf->Cell(40, $h, $GLOBALS['header']['data']['userCreate'], $noborder, 0, 'C');
$pdf->Cell(50, $h, ')', $noborder);
$pdf->Cell(20, $h, '( ______________________ )', $noborder, $noborder, 1); 
// $pdf->Cell(25, $h, 'Diagnose', $border, 0);
// $pdf->Cell(3, $h, ':', $border, 0);
// //diagnosa
// $pdf->MultiCell(141, $h, $GLOBALS['header']['DIAGNOSIS'], $border, 1);

// //row 6-------------------
// $pdf->Cell(5, $h, '', $border, 0);
// $pdf->Cell(25, $h, 'Examination ', $border, 0);
// $pdf->Cell(3, $h, ':', $border, 0);
// //pemeriksaan
// $pdf->Cell(0, $h, $GLOBALS['header']['SCHEDULED_PROC_DESC'], $border, 1);
// $pdf->Cell(0, 0, '', $border, 1); //br
// $pdf->Cell(33, $h, '', $border, 0);
// $pdf->MultiCell(141, $h, $data['listdatadetail']['REPORT_TEXT'], $border, 1);

// //Garis---
// $pdf->SetFont('', 'U', 12);
// $pdf->Cell(33, $h, '', $border, 0);
// $pdf->Cell(10, $h, '                                                                                                                      ', $border, 0);

//   new line

// $pdf->Cell(0, $h, '', $border, 1); //br
// $pdf->setFont('', '', 10);

// $pdf->Cell(5, $h, '', $border, 0);
// $pdf->Cell(25, $h, '', $border, 0);
// $pdf->Cell(3, $h, '', $border, 0);
// $pdf->MultiCell(141, $h, $data['listdatadetail']['CONCLUSION'], $border, 1);

// //QR CODE
// require_once("../App/library/phpqrcode/qrlib.php");
// $url = $data['uuid4'];
// $url_ext = "https://esigndocument.rsyarsi.co.id/" . $url;
// QRcode::png($url_ext, $url . ".png");

// //Garis---
// $gety = $pdf->getY();
// //$pdf->Line(15, $gety, 210-15, $gety);
// //QR Code
// $pdf->Image($url . ".png", 25, $gety + 10, 25, 25, "png");
// //Hapus file qr code nya
// unlink($url . ".png");

// $pdf->Output();

$certificate = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.crt';
$key = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.key';

$info = array(
    'Name' => 'TCPDF',
    'Location' => 'Office',
    'Reason' => 'Testing TCPDF',
    'ContactInfo' => 'http://www.tcpdf.org',
);

$pdf->setSignature($certificate, $key, 'tcpdfdemo', '', 2, $info);
