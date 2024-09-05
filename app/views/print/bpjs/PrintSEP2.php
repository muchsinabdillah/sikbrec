<?php
$pdf = new FPDF('L', 'mm', 'A5');
$datereal = date('d-m-Y');
$pdf->SetTopMargin(15);
$pdf->AddPage();

$tglxsep = $data['sep']['TGL_SEP'];
$tglxcreate = $data['sep']['TGL_CREATEX'];
 if( date("Y-m-d", strtotime($tglxsep))<date("Y-m-d",strtotime($tglxcreate))  ){
     $ketbackdate = "(BACKDATE)";
 }else{
    $ketbackdate = "";
 }
if( $data['sep']['JENIS_RAWAT'] == "R. Inap"){
    $faskesperujuk = "RSU YARSI";
}else{
    $faskesperujuk = $data['sep']['NAMA_PPK_PERUJUK'];
}
if ($data['sep']['NAIK_KELAS'] == "0") {
    $kelasrawatx = $data['sep']['KELAS_RAWAT'];
} else {
    $kelasrawatx = $data['sep']['KELAS_NAIK_NAMA'];
}
//logo Yarsi
$pdf->Image(BASEURL . '/images/logo_bpjs-02.png', 15, 5, 55); // atas, bawah, besar
$pdf->Ln(0);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(65, 5, '', 0, 0);
$pdf->Cell(0, 5, 'SURAT ELEGIBILITAS PESERTA', 0, 1);
$pdf->Cell(65, 5, '', 0, 0);
$pdf->Cell(0, 5, 'RSU YARSI JAKARTA', 0, 1);

$pdf->Cell(0, 5, '', 0, 1); //br

$border = 0;
$height = 5;

$pdf->SetFont('Arial', '', 10);

//line 1
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'No. SEP', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(0, $height, $data['sep']['NO_SEP'], $border, 1);
//------------------

//line 2
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Tgl. SEP', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['sep']['TGL_SEP'] .' '. $ketbackdate, $border, 0);
//------------------

//$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(25, $height, 'Peserta', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(50, $height, $data['sep']['JENIS_PESERTA'], $border, 1);
//------------------

//line 3
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'No. Kartu', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(30, $height, $data['sep']['NO_KARTU'], $border, 0);
$pdf->Cell(45, $height, '(MR. ' . $data['sep']['NO_MR'] . ') ' , $border, 0);
//------------------

//$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(25, $height, 'COB', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(50, $height, $data['sep']['COB'], $border, 1);
//------------------

//line 4
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Nama Peserta', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['sep']['NAMA_PESERTA'], $border, 0);
//------------------

//$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(25, $height, 'Jns. Rawat', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(50, $height, $data['sep']['JENIS_RAWAT'], $border, 1);
//------------------

//line 5
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Tgl. Lahir', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(22, $height, $data['sep']['TGL_LAHIR'], $border, 0);
$pdf->Cell(15, $height, 'Kelamin', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(35, $height, $data['sep']['JENIS_KELAMIN'], $border, 0);
//------------------

//$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(25, $height, 'Kls. Rawat', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(50, $height, $kelasrawatx, $border, 1);
//------------------

//line 6
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'No. Telepon', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['sep']['NO_TELEPON'], $border, 0);
//------------------

//$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(25, $height, 'Penjamin', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(50, $height, $data['sep']['PENJAMIN'], $border, 1);
//------------------

//line 7
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Sub/Spesialis', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['sep']['NAMA_POLI'], $border, 0);
//------------------
//$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(25, $height, 'PRB', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(50, $height, $data['sep']['KETERANGAN_PRB'], $border, 1);
//------------------
//line 7
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Dokter', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(75, $height, $data['sep']['NAMA_DOKTER'], $border, 0);
//------------------
//$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(25, $height, 'Kls. Hak', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(50, $height, $data['sep']['KELAS_RAWAT'], $border, 1);
//line 8
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Faskes Perujuk', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(0, $height, $faskesperujuk, $border, 1);
//------------------

//line 9
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Diagnosa Awal', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(0, $height, $data['sep']['NAMA_DIAGNOSA'], $border, 1);
//------------------

//line 10
$pdf->Cell(5, 5, '', 0, 0); //margin
$pdf->Cell(30, $height, 'Catatan', $border, 0);
$pdf->Cell(3, $height, ':', $border, 0);
$pdf->Cell(0, $height, $data['sep']['CATATAN'], $border, 1);
//------------------



$pdf->Cell(0, 2, '', 0, 1); //br

$pdf->SetFont('Arial', '', 9);
//line 11
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, '*Saya menyetujui BPJS Kesehatan menggunakan informasi medis pasien jika diperlukan.', $border, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 4, 'Pasien/Keluarga Pasien', $border, 1);
//------------------

$pdf->SetFont('Arial', '', 9);
//line 12
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, '*SEP Bukan sebagai bukti Penjaminan Peserta.', $border, 1);
//------------------

$pdf->Cell(0, 4, '', 0, 1); //br

$nokartu = $data['sep']['NO_KARTU'];
require_once("../App/library/phpqrcode/qrlib.php");
QRcode::png($nokartu, $nokartu .".png");
$gety = $pdf->getY();
$pdf->Image($nokartu.".png", 167, $gety-7, 15, 15, "png");
unlink($nokartu.".png");

$pdf->SetFont('Arial', '', 9);
//line 13
$pdf->Cell(5, 4, '', 0, 0); //margin
$pdf->Cell(140, 4, '', $border, 0); 
// $pdf->Cell(30, 25, "______________________", $border, 1);
$pdf->Cell(40, 25, $data['sep']['NAMA_PESERTA'], 0, 1,'C');
//------------------

$pdf->SetFont('Arial', '', 8);
//line 14
$pdf->Cell(5, 0, '', 0, 0); //margin
$pdf->Cell(140, -20, 'Cetakan ke-' . $data['sep']['CETAKAN_KE'] . ' ' . $data['sep']['TGL_LAST_CETAK'] . ' wib', $border, 1);
//------------------





/*
$pdf->Cell(0,5,'',0,1);

$pdf->setFont('Arial','',10);
$pdf->Cell(8,5,'',0,0);
$pdf->Cell(60,5,'Pasien / Wali',0,0,'L');
$pdf->Cell(60,5,'Saksi',0,0,'L');
$pdf->Cell(60,5,'Recieved by',0,1,'L');
$pdf->setFont('Arial','B',10);
$pdf->Cell(8,5,'',0,0);
$pdf->Cell(60,5,'Patient / Family Patient',0,0,'L');
$pdf->Cell(60,5,'Witness',0,0,'L');
$pdf->Cell(60,5,'Petugas Admission/Staff',0,1,'L');
$pdf->Cell(0,20,'',0,1);

$pdf->setFont('Arial','',10);
$pdf->Cell(8,5,'',0,0);
$pdf->Cell(28,5,'TTD/Signature',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
$pdf->Cell(28,5,'TTD/Signature',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
$pdf->Cell(28,5,'TTD/Signature',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,1,'L');
$pdf->Cell(8,5,'',0,0);
$pdf->Cell(28,5,'Nama/Name',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
$pdf->Cell(28,5,'Nama/Name',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
$pdf->Cell(28,5,'Nama/Name',0,0,'L');
$pdf->Cell(2,5,':',0,0,'L');
$pdf->Cell(30,5,' .....................',0,0,'L');
*/

//$pdf->Image($Foto,7,7,40);
//$pdf->Ln(5);


$pdf->Output();
