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
$pdf->Cell(70, 5, 'SURAT RUJUKAN', 0, 0);
$pdf->Cell(8, 5, 'No. ', 0, 0);
$pdf->Cell(0, 5,  $data['rujukan']['idRujukan'], 0, 1);

$pdf->Cell(65, 5, '', 0, 0);
$pdf->Cell(70, 5, 'RSU YARSI JAKARTA', 0, 0);
$pdf->Cell(8, 5, 'Tgl. ', 0, 0);
$pdf->Cell(0, 5, $data['rujukan']['tglRujukan'], 0, 1); //br

$border = 0;
$height = 5;

$pdf->SetFont('Arial', '', 10);
//line 2
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'kepada Yth.', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['rujukan']['namapolitujuan'], $border, 1);
//line 2
$pdf->Cell(38, 5, '', 0, 0); //margin
$pdf->Cell(97, $height, $data['rujukan']['tujuanrujukan'], $border, 0);
$pdf->Cell(5, $height, '== '. $data['rujukan']['tipeRujukan']. ' ==', $border, 1);
//line 1
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Mohon Pemeriksaan dan Penanganan Lebih Lanjut :', $border, 1);
//------------------

//line 2
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'No. Kartu', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['rujukan']['nomorkartu'], $border, 1);
//------------------


//line 3
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Nama Peserta', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(70, $height, $data['rujukan']['nama'], $border, 0);
$pdf->Cell(45, $height, '(' . $data['rujukan']['kelamin'] . ')', $border, 1);
//$pdf->Cell(45, $height, '(MR. ' . $data['sep']['NO_MR'] . ')', $border, 0);
//------------------


//line 5
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Tgl. Lahir', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(22, $height, date("d-M-Y", strtotime($data['rujukan']['tgllahir'])), $border, 1);
//------------------


//line 6
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Diagnosa ', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['rujukan']['namadiagnosa'], $border, 1);
//------------------

//line 7
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Rencana Inap', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(0, $height, date("d-M-Y", strtotime($data['rujukan']['tglRencanaKunjungan'])), $border, 1);
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
$pdf->Cell(140, 4, '', $border, 0);
$pdf->Cell(30, 7, $data['rujukan']['dpjp'], $border, 1);
//------------------

$pdf->SetFont('Arial', '', 8);
//line 14
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, 'Tgl Entri ' . date("d-M-Y", strtotime($data['rujukan']['created_at'])) . ' | Cetakan ke-' . $data['rujukan']['CETAKAN_KE'] . ' ' . date("d-M-Y H:i:s", strtotime($data['rujukan']['TGL_LAST_CETAK'])) . ' wib', $border, 1);
//------------------


$pdf->Output();
