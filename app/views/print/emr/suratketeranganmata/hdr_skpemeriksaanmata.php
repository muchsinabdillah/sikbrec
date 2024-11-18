<?php
$GLOBALS['dataPasien'] = $data['dataPasien'];
$GLOBALS['dataSurat'] = $data['dataSurat'];

class PDF extends Tcpdf
{
    function Header()
    {

        $this->setFont('', '', 9); 
        $this->Image('../public/images/yarsi.png', 15, 8, 50);
        $this->SetFont('', 'B', 18);
        $this->Cell(60, 7, '', 0, 1);
        $this->Cell(60, 7, '', 0, 0);
        $this->Cell(130, 4, 'KLINIK BREBES EYE CENTER', 0, 1, 'R'); 

        $this->SetFont('', '', 10);
        $this->Cell(60, 4, '', 0, 0);
        $this->Cell(130, 4, 'Jl. Pemuda No.19, Desa Blubuk, Kec. Losari, Kabupaten Brebes, Jawa Tengah 52255', 0, 1, 'R');

        $this->SetFont('', '', 10);
        $this->Cell(60, 4, '', 0, 0);
        $this->Cell(130, 4, 'Telp : 0811-1901-1119', 0, 1, 'R');

        // Set line color
        $this->SetDrawColor(0, 0, 0); // RGB color for black
        // Draw a line (x1, y1, x2, y2)
        $this->Line(10, 35, 200, 35); // Example line from (10,50) to (200,50)


        $this->Ln(5);
        // $this->Cell(125, 4, '', 0, 0);
        $this->Cell(100, 1, '', 0, 1);
        //Margin top

        //BR
        // $this->Cell(0, 4, '', 0, 1);
        $this->Cell(10, 1, '', 0, 1);
        //Line 1
        $this->SetFont('', 'B', 12);
        $this->Cell(5, 7, '', 0, 0);
        $this->Cell(0, 1, 'SURAT KETERANGAN PEMERIKSAAN MATA', 0, 1, 'C');
        $this->SetFont('', 'I', 12);
        $this->Cell(5, 7, '', 0, 0);
        $this->Cell(0, 1, 'EYE EXAMINATION CERTIFICATE', 0, 1, 'C');
        $this->Cell(5, 7, '', 0, 0);
        $this->Cell(0, 1, '(' . $GLOBALS['dataSurat']['data']['NoSurat'] . ')', 0, 1, 'C');

        // $this->Cell(0, 1, 'Dengan ini menyatakan bahwa', 'B', 0, 'C');

        $border = 0;
        $h = 6;


        $this->Cell(10, $h, '', 0, 1);
        $this->SetFont('', '', 10);
        //row 1 (left)-------------------
        $this->Cell(5, $h, '', $border, 0);
        $this->MultiCell(180, $h, 'Yang bertanda tangan dibawah ini Dokter Spesialis Mata, mengingat sumpah jabatan dengan ini             menerangkan telah memeriksa dengan hasil seseorang.                                             ', $border, 0);
    }
    function Footer()
    {
        
    }
}

//$GLOBALS['header'] = $data['data'][0];

$pdf = new PDF('p', 'mm', 'A4');
$pdf->SetAutoPageBreak(TRUE, 35);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 45, PDF_MARGIN_RIGHT);
$pdf->AddPage();

$border = 0;
$h = 6; 
$pdf->setFont('', '', 10);
 

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(32, $h, 'Nama', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(128, $h, $GLOBALS['dataPasien']['data']['PatientName'].' ('.$GLOBALS['dataPasien']['data']['Gander'] .')' , $border, 1); 

 

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(32, $h, 'T,T,L (Umur)', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(50, $h,date('d/m/Y', strtotime($GLOBALS['dataPasien']['data']['Date_of_birth'])).' - ( '. $GLOBALS['dataPasien']['data']['as_year'].' )', $border, 1); 
$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(32, $h, 'Pekerjaan', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(0, $h, $GLOBALS['dataPasien']['data']['Pekerjaan'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(32, $h, 'Alamat', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->MultiCell(0, $h, $GLOBALS['dataPasien']['data']['Address'], $border, 1);

$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(32, $h, 'No. Kartu Identitas', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(75, $h, $GLOBALS['dataPasien']['data']['Nik']. ' ( '.$GLOBALS['dataPasien']['data']['Tipe_Idcard'].' )', $border, 1); 

//br
$pdf->Cell(5, 15, '', $border, 1);
//br
$pdf->Cell(5, $h, '', $border, 0);
$pdf->Cell(25, $h, 'Telah dilakukan pemeriksaan mata dengan hasil sebagai berikut :', $border, 0);
$pdf->Cell(3, $h, '', $border, 0);
$pdf->Cell(0, $h, '', $border, 1);

//br
$pdf->Cell(5, 5, '', $border, 1);
//br
$pdf->Cell(10, $h, '', $border, 0);
$pdf->Cell(0, $h, '1. Tajam penglihatan :', $border, 1);
$pdf->Cell(15, $h, '', $border, 0);
$pdf->Cell(32, $h, 'Mata Kiri', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(65, $h, $GLOBALS['dataSurat']['data']['TajamPenglihatanKiri']. ' ' . $GLOBALS['dataSurat']['data']['TajamPenglihatanKiriAlat'], $border, 1);
$pdf->Cell(15, $h, '', $border, 0);
$pdf->Cell(32, $h, 'Mata Kanan', $border, 0);
$pdf->Cell(3, $h, ':', $border, 0);
$pdf->Cell(65, $h, $GLOBALS['dataSurat']['data']['TajamPenglihatanKanan']. ' ' . $GLOBALS['dataSurat']['data']['TajamPenglihatanKananAlat'], $border, 1); 
$pdf->Cell(10, $h, '', $border, 0);
$pdf->Cell(0, $h, '2. Penglihatan Warna :', $border, 1);
$pdf->Cell(15, $h, '', $border, 0);
$pdf->Cell(0, $h, $GLOBALS['dataSurat']['data']['PenglihatanWarna'], $border, 1);

$pdf->Cell(10, $h, '', $border, 0);
$pdf->Cell(0, $h, '3. Catatan :', $border, 1);
$pdf->Cell(15, $h, '', $border, 0);
$pdf->MultiCell(0, $h, $GLOBALS['dataSurat']['data']['Catatan'], $border, 1);
 
$pdf->Cell(5, 10, '', $border, 1); 
$ht = 10;
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->setFont('', '', 12);
$pdf->MultiCell(80, $ht, '', $border, 1);
$pdf->SetXY($x + 30, $y);
$pdf->MultiCell(40, 60, "\n\n\n\n        Pas Photo \n          Ukuran \n            4 x 6", 1, 1);
$pdf->SetXY($x + 130, $y);
$pdf->setFont('', '', 10);
$pdf->MultiCell(50, $ht, "\n\n" . "Brebes" . "," . strtotime($GLOBALS['dataSurat']['data']['Tanggal_Sekarang']) . "\n" . "Dokter yang memeriksa, ", $border, 1);
 
$pdf->Cell(0, 25, '', $border, 1);
//br

$pdf->Cell(130, $h, '', $border, 0);
$pdf->Cell(5, $h, '(', $border, 0);
$pdf->Cell(45, $h, $GLOBALS['dataSurat']['data']['Dokter'], $border, 0, 'C');
$pdf->Cell(5, $h, ')', $border, 1);


// $pdf->Output();

$certificate = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'EMR/public/server.crt';
$key = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'EMR/public/server.key';

$info = array(
    'Name' => 'TCPDF',
    'Location' => 'Office',
    'Reason' => 'Testing TCPDF',
    'ContactInfo' => 'http://www.tcpdf.org',
);

$pdf->setSignature($certificate, $key, 'tcpdfdemo', '', 2, $info);
