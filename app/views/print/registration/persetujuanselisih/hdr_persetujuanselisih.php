<?php
   date_default_timezone_set('Asia/Jakarta');

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false);

$datereal = date('d/m/Y');
$datenow   = new DateTime('today');
$datenowx = Date("d/m/Y");

      $NoRegRI = $data['listdata1']['NoRegistrasi'];
      $penjamin = $data['listdata1']['NamaPenjamin'];
      $namapasien = $data['listdata1']['NamaPasien'];
      $NoMR = $data['listdata1']['NoMR'];
      $gender = $data['listdata1']['JenisKelamin'];
      $alamat = $data['listdata1']['Alamat'];
      $homephone = $data['listdata1']['NoTelp_Pasien'];

        $age = $data['listdata1']['Usia'];


$pdf->AddPage();
$pdf->Image('../public/images/yarsi.png',15,7,50);
$pdf->Ln(10);
// cell(widht, height, text, border, end line , [ALIGN] )

// set font to , bold, 14pt
$pdf->setFont('','',9);

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(110,4,'',0,0);
$pdf->SetFont('','',10);
      $pdf->Cell(75,4,'Jl. Letjen Suprapto, Cempaka Putih, Jakarta 10510',0,1,'R');

      //garis----
                                    $pdf->SetFont('','U',10);
                                    $pdf->Cell(6,6,'',0,0);
                                    $pdf->Cell(180,0,'','T',1);

//make a dummy empty cell as a vertical spacer
$pdf->cell(189 ,5,'',0,1);//end of line

$pdf->setFont('','B',11);
$pdf->Cell(0 ,4,'SURAT PERSETUJUAN MEMBAYAR SELISIH BIAYA PERAWATAN',0,1,'C');//end of line

//$pdf->Image('../../img/bismillah.png',80,40,50,'C');
//$pdf->Ln(10);

$pdf->Cell(0,6,'',0,1);//br
$pdf->setFont('','',10);
$pdf->Cell(5,5,'',0,0);
$pdf->Cell(180,5,'Saya yang bertanda tangan dibawah ini :',0,1);
$pdf->Cell(0,5,'',0,1);//br

$pdf->setFont('','',10);
$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'Nama',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->MultiCell(120,5,$data['listdata1']['NamaWaliPasien'],0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'Nomor Identitas',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->MultiCell(120,5,$data['listdata1']['NIK'],0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'Hubungan dengan Pasien',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->MultiCell(120,5,$data['listdata1']['HubunganDenganPasien'],0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'No. Telepon / HP',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->MultiCell(120,5,$data['listdata1']['NoTelp'],0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(0,6,'',0,1);//br
$pdf->setFont('','',10);
$pdf->Cell(5,5,'',0,0);
$pdf->Cell(86,5,'Adalah benar merupakan penanggung jawab pasien :',0,0);
$pdf->Cell(0,8,'',0,1);//br

$pdf->setFont('','',10);
$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'Nama',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->MultiCell(120,5,$namapasien,0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'Nomor Medical Record',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->MultiCell(120,5,$NoMR,0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'Nama Penjamin',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->MultiCell(120,5,$penjamin,0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'Jenis Kelamin',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->Cell(10,5,$gender,0,0);
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(50,5,'Usia : '.$age.' Tahun',0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'Alamat',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->MultiCell(120,5,$alamat,0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(5,5,'',0,0);//margin
$pdf->Cell(48,5,'No. Telepon / HP',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->MultiCell(120,5,$homephone,0,1);

$pdf->Cell(0,6,'',0,1);//br
$pdf->Cell(5,5,'',0,0);
$pdf->Cell(86,5,'Menyatakan SETUJU dan BERSEDIA untuk membayar kepada RS. YARSI.',0,0);
$pdf->Cell(0,4,'',0,1);//br

$pdf->Cell(0,6,'',0,1);//br
$pdf->Cell(5,5,'',0,0);
$pdf->Cell(86,5,'1. Seluruh selisih biaya perawatan yang timbul diluar batan jaminan polis / Jaminan Perusahaan',0,0);
$pdf->Cell(0,1,'',0,1);//br

$pdf->Cell(0,6,'',0,1);//br
$pdf->Cell(5,5,'',0,0);
$pdf->Cell(86,5,'2. Seluruh biaya perawatan jika ternyata jenis penyakit / diagnosis termasuk dalam daftar pengecualian poli',0,0);
$pdf->Cell(0,5,'',0,1);//br

$pdf->Cell(0,6,'',0,1);//br
$pdf->Cell(5,5,'',0,0);
$pdf->Cell(86,5,'Demikianlah Surat persetujuan ini dibuat untuk dapat dipergunakan sesuai tujuan tersebut diatas.',0,0);
$pdf->Cell(0,8,'',0,1);//br


$pdf->Cell(0,8,'',0,1);//br

$h = 5;

$pdf->Cell(0,1,'',0,1);
$pdf->Cell(135,$h,'',0,0);
$pdf->Cell(0,$h,'Jakarta '.$data['listdata1']['TglCreate_sign'],0,1);

//QR CODE CELL
require_once("../App/library/phpqrcode/qrlib.php");
$url = $data['listdata1']['uuid4'];
$url_ext = "https://esigndocument.rsyarsi.co.id/edocpersetujuanselisih/".$url;
QRcode::png($url_ext, $url .".png");
// $gety = $pdf->getY();
// $pdf->Image($url.".png", 155, $gety, 25, 25, "png");

$pdf->Cell(0,1,'',0,1);//br
      $pdf->Cell(5,7,'',0,0);
      $pdf->Cell(50,$h,'Petugas',0,0,'C');
      $pdf->Cell(65,$h,'',0,0);
       $gety = $pdf->getY();
      $pdf->Image($url.".png", 85, $gety, 25, 25, "png");
      $pdf->Cell(50,$h,'Pasien / Penanggung Jawab',0,1,'C');
      
      $pdf->Cell(127,15,'',0,0);//br
      
    //$pdf->Image($h,$data['listdatasign']['IMAGE_PATH'].'.png',15,10,50);
    $pdf->Image($data['listdata1']['TTDPetugas'].'?ext=.png', 25, $pdf->getY(),35);
    //$pdf->Cell(120,15,'',0,0);//br
    $pdf->Image($data['listdata1']['TTD_PasienWali'].'?ext=.png', $pdf->getX(), $pdf->getY(),35);
    $pdf->Cell(0,15,'',0,1);//br
    $pdf->Cell(5,7,'',0,0);
      $pdf->Cell(50,$h,$data['listdata1']['Petugas'],0,0,'C');
      $pdf->Cell(65,$h,'',0,0);
      $pdf->Cell(50,$h,$data['listdata1']['NamaWaliPasien'],0,1,'C');
      $pdf->Cell(5,7,'',0,0);
      $pdf->Cell(50,$h,'',0,0,'C');
      $pdf->setFont('','',7);
      $pdf->Cell(65,$h,'Scan this for validate',0,0,'C');
      $pdf->setFont('','',9);
      $pdf->Cell(50,$h,'',0,0,'C');


$certificate2 = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.crt'; 
    $key = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.key';
   
$info = array(
             'Name' => 'TCPDF',
             'Location' => 'Office',
             'Reason' => 'Testing TCPDF',
             'ContactInfo' => 'http://www.tcpdf.org',
             );

$pdf->setSignature($certificate2, $key, 'tcpdfdemo', '', 2, $info);

?>
