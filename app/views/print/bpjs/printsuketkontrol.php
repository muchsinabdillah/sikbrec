<?php
date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/y H:i:s");

class PDF extends TCPDF
    {
    // Page header
    function Header()
        {
            $this->Image('../public/images/yarsi.png',10,7,35);
            //$this->Image('../public/images/footer2.png',144,0,40);
            //$this->Image('../public/images/LogoGabungCert.png',145,0,55);
            $this->SetFont('', '', 7);
            $this->Ln(2);
            $this->Cell(80, 6, '', 0, 0);
            $this->Cell(50, 6, '  No: 033/FRM/IRJ/BPJS/RSY/Rev0/II/2021', 1, 1, 'L');
            $this->Cell(0,1, '', 0, 1);
            $this->Cell(80, 3, '', 0, 0);
            $this->Cell(25, 3, 'Jl. angkasa No.19, Dukuhkrikil', 0, 1, 'L');
            $this->Cell(80, 3, '', 0, 0);
            $this->Cell(25, 3, '-', 0, 1, 'L');
            //$this->Cell(80, 3, '', 0, 0);
            //$this->Cell(25, 3, 'Telp: 021-80618618, 80618619 (Hunting),', 0, 1, 'L');
            //$this->Cell(80, 3, '', 0, 0);
            //$this->Cell(25, 3, 'www.rsyarsi.co.id', 0, 1, 'L');
        }
    
    
    // Page footer
    function Footer()
        {
            // $this->getY();
            // $this->Image('../public/images/footer_1.png',0,135,210, 13);

        }

    }



date_default_timezone_set('Asia/Jakarta');
//$datenow = Date("d/m/Y H:i:s");
$datenow = Utils::seCurrentDateTime();
$pdf = new PDF('P', 'mm', 'A5');
$pdf->SetAutoPageBreak(true,2);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(true);
//$datereal = date('d-m-Y');
$daterreal = Utils::datenowcreateNotFull();

$pdf->AddPage();
//$pdf->Image('../public/images/yarsi.png', 10, 8, 40);
$pdf->Ln(-5);


$pdf->setFont('', 'BU', 11);
$pdf->Cell(0, 6, 'SURAT KETERANGAN KONTROL PASIEN', 0, 1, 'C'); 

if ($data['listdata']['data']['PRB'] == true){
    $pdf->setFont('', 'B', 11);
    $pdf->Cell(110, 2, '', 0, 0, 'R'); 
    $pdf->Cell(10, 2, 'PRB', 1, 1, 'R'); 
}

// $pdf->Image('../public/images/bismillah.png', 80, 30, 50, 'C');
// $pdf->Ln(10);

$pdf->Cell(0, 3, '', 0, 1); //br
$pdf->setFont('', '', 9);


//HEADER--------------------------
//row 1 (left)-------------------
//(width,heigth,isi, border, tr)

$pdf->Cell(40,5, 'No. RM', 0, 0);
$pdf->Cell(3,5, ':', 0, 0);
$pdf->MultiCell(65,5, $data['listdata']['data']['NamaPasien'], 0, 1);

$pdf->Cell(40,5, 'Nama', 0, 0);
$pdf->Cell(3,5, ':', 0, 0);
$pdf->MultiCell(65,5, $data['listdata']['data']['NoMR'], 0, 1);

$pdf->Cell(40,5, 'Tanggal Surat Rujukan', 0, 0);
$pdf->Cell(3,5, ':', 0, 0);
$pdf->MultiCell(65,5, ($data['listdata']['data']['Tgl_SuratRujukan'] != null) ?  date('d/m/Y', strtotime($data['listdata']['data']['Tgl_SuratRujukan'])) : '', 0, 1);

$pdf->Cell(40,5, 'Diagnosa', 0, 0);
$pdf->Cell(3,5, ':', 0, 0);
$pdf->MultiCell(65,5, $data['listdata']['data']['Diagnosa'], 0, 1);

$pdf->Cell(0,5, '', 0, 1);

$pdf->Cell(0,5, 'Belum dapat dikembalikan ke Fasilitas Perujuk/PPK 1 dengan alasan :', 0, 1);
$pdf->MultiCell(0,5, $data['listdata']['data']['is_belum_kembali'], 0, 1);

$pdf->Cell(0, 2, '', 0, 1); //br

    foreach ($data['listdatadetail'] as $row){
        $pdf->Cell(5, 5, '', 0, 0); 
        $pdf->Cell(45,5, 'Kontrol kembali ke RS tanggal : ', 0, 0);
        $pdf->MultiCell(0,5, date('d/m/Y', strtotime($row['Tgl_Kontrol'])).', '.$row['Poli'], 0, 1);
        $pdf->Cell(5, 5, '', 0, 0); 
        $pdf->Cell(20,5, 'Keterangan : ', 0, 0);
        $pdf->MultiCell(0,5, $row['Keterangan'], 0, 1);
    }

$pdf->Cell(0, 2, '', 0, 1); //br
$pdf->Cell(5, 2, '', 0, 0); 
if ($data['listdata']['data']['is_konsul_selesai'] == true){
    //$konsultasi_selesai = 'YA';
    $checbox = $pdf->Image('../public/images/checkbox.png', 16, $pdf->gety(), 4);
}else{
    $checbox = $pdf->Image('../public/images/unchecked.png', 16, $pdf->gety(), 4);
}
$checbox;
$pdf->Cell(0,5,'Konsultasi selesai', 0, 1);

$pdf->Cell(0,5, '', 0, 1);

$pdf->Cell(0,5, 'Pasien dapat dilakukan program rujuk balik dengan terapi :', 0, 1);
$pdf->MultiCell(0,5, $data['listdata']['data']['Terapi'], 0, 1);

$pdf->Cell(0,5, '', 0, 1);

$pdf->Cell(76,5, '', 0, 0);
$pdf->Cell(0,5, 'Tanggal : '.Date('d/m/Y', strtotime($data['listdata']['data']['datecreate'])), 0, 1);

  if ($data['listdata']['data']['DPJP'] != null){
    $qr_dokter = $data['listdata']['data']['DPJP'];
  }else{
    $qr_dokter = 'nodata';
  }

require_once("../App/library/phpqrcode/qrlib.php");
QRcode::png($qr_dokter, $qr_dokter .".png");
$gety = $pdf->getY();
$pdf->Image($qr_dokter.".png", 98, $gety, 20, 20, "png");
$pdf->Cell(90, 19, '', 0, 1);


$pdf->Cell(70,5, '', 0, 0);
$pdf->Cell(0,5, $data['listdata']['data']['DPJP'], 0, 1,'C');
//$pdf->Cell(70,5, '', 0, 0);
//$pdf->Cell(0,5, 'Nama & TTD DPJP', 0, 0,'C');

unlink($qr_dokter.".png");


$fileName = $data['listdata']['data']['NamaPasien'].' - '.$data['listdata']['data']['NoSEP'].'.pdf';
$pdf->Output($fileName, 'I');
