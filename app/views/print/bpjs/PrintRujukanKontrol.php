<?php
$pdf = new FPDF('L', 'mm', 'A5');
$datereal = date('d-m-Y');
$pdf->SetTopMargin(15);
$pdf->AddPage();


//logo Yarsi
$pdf->Image(BASEURL . '/images/logo_bpjs-02.png', 15, 5, 55);
$pdf->Ln(0);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(65, 5, '', 0, 0);
$pdf->Cell(70, 5, 'SURAT RENCANA KONTROL', 0, 0);
$pdf->Cell(8, 5, 'No. ', 0, 0);
$pdf->Cell(0, 5,  $data['spri']['NO_SPRI'], 0, 1);

$pdf->Cell(65, 5, '', 0, 0);
$pdf->Cell(70, 5, 'RSU YARSI JAKARTA', 0, 1); 

$border = 0;
$height = 5;

$pdf->SetFont('Arial', '', 10);
//line 2


$pdf->Cell(0, 2, '', 0, 1); //br
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'kepada Yth.', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['spri']['NAMA_DOKTER'], $border, 1);
//line 2
$pdf->Cell(38, 5, '', 0, 0); //margin
$pdf->Cell(97, $height, $data['spri']['NAMA_POLI'], $border, 1); 
//line 1
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Mohon Pemeriksaan dan Penanganan Lebih Lanjut :', $border, 1);
//------------------

//line 2
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'No. Kartu', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['spri']['NO_KARTU'], $border, 1);
//------------------


//line 3
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Nama Peserta', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(70, $height, $data['spri']['NAMA_PASIEN'], $border, 0);
$pdf->Cell(45, $height, '(' . $data['spri']['JENIS_KELAMIN'] . ')', $border, 1);
//$pdf->Cell(45, $height, '(MR. ' . $data['sep']['NO_MR'] . ')', $border, 0);
//------------------


//line 5
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Tgl. Lahir', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(22, $height, date("d-M-Y", strtotime($data['spri']['TGL_LAHIR'])), $border, 1);
//------------------


//line 6
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Diagnosa ', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['spri']['NAMA_DIAGNOSA'], $border, 1);
//------------------

//line 6
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Rencana Kontrol ', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, date("d-M-Y", strtotime($data['spri']['TGL_RENCANA_KONTROL'])), $border, 1);
//------------------

//line 8
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, 10, 'Demikian atas bantuannya, diucapkan terima kasih.', $border, 1);
//------------------


$pdf->Cell(0, 2, '', 0, 1); //br

$pdf->SetFont('Arial', '', 9);
//line 11
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, '', $border, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 4, 'Mengetahui DPJP', $border, 1);
//------------------

$pdf->SetFont('Arial', '', 9);
//line 12
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, '', $border, 1);
//------------------

$pdf->Cell(0, 4, '', 0, 1); //br

$pdf->SetFont('Arial', 'U', 9);
//line 13
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(130, 4, '', $border, 0);
$pdf->Cell(30, 4, $data['spri']['NAMA_DOKTER'], $border, 1);
//------------------

$pdf->SetFont('Arial', '', 8);
//line 14
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, 'Tgl Entri ' . date("d-M-Y", strtotime($data['spri']['TGL_ENTRY'])) . ' | Cetakan ke-' . $data['spri']['CETAKAN_KE'] . ' ' . date("d-M-Y H:i:s", strtotime($data['spri']['TGL_LAST_CETAK'])) . ' wib', $border, 1);
//------------------
 

$pdf->Output();
