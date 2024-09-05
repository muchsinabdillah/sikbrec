<?php
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y");
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$pdf->Image('../public/images/yarsi.png',15,10,50);
$pdf->Ln(-5);
// cell(widht, height, text, border, end line , [ALIGN] )

// set font to , bold, 14pt
$pdf->setFont('','',9);

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(125, 4, '', 0, 0);
$pdf->SetFont('', '', 9);
$pdf->Cell(55, 4, 'No : 010/FRM/REG/RSY/Rev0/1/2020', 1, 1, 'L');
$pdf->Cell(0, 2, '', 0, 1);
$pdf->Cell(125, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Jl. Letjen Suprapto, Kav. 13 Cempaka Putih, ', 0, 1, 'L');
$pdf->Cell(125, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Jakarta Pusat 10510', 0, 1, 'L');
$pdf->Cell(125, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Telp: 021-80618618, 80618619 (Hunting),', 0, 1, 'L');
$pdf->Cell(125, 3, '', 0, 0);
$pdf->Cell(25, 3, 'www.rsyarsi.co.id', 0, 1, 'L');


//make a dummy empty cell as a vertical spacer
$pdf->cell(0 ,10,'',0,1);//end of line

$pdf->setFont('','B',15);
$pdf->Cell(0 ,4,'HAK & KEWAJIBAN PASIEN',0,1,'C');//end of line
$pdf->cell(0 ,5,'',0,1);//end of line
$h = 5;

$pdf->setFont('','B',10);
$pdf->Cell(10,2,'',0,0);
$pdf->MultiCell(0,$h,'HAK PASIEN ( UU Hak & Tanggung Jawab Pasal 32 UU No.44 / 2009 )',0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->setFont('','',9);
$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'1. ',0,0);
$pdf->MultiCell(0,$h,'Hak memperoleh informasi mengenai tata tertib dan peraturan yang berlaku di Rumah sakit.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'2. ',0,0);
$pdf->MultiCell(0,$h,'Hak memperoleh informasi tentang hak dan kewajiban pasien.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'3. ',0,0);
$pdf->MultiCell(0,$h,'Hak memperoleh layanan yang manusiawi, adill, jujur, dan tanpa diskriminasi.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'4. ',0,0);
$pdf->MultiCell(0,$h,'Hak memperoleh layanan kesehatan yang bermutu sesuai dengan standar profesi dan standar prosedur operasional.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'5. ',0,0);
$pdf->MultiCell(0,$h,'Hak memperoleh layanan yang efektif dan efisien sehingga pasien terhindar dari kerugian fisik dan materi.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'6. ',0,0);
$pdf->MultiCell(0,$h,'Hak mengajukan pengaduan atas kualitas pelayanan yang didapatkan.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'7. ',0,0);
$pdf->MultiCell(0,$h,'Hak memilih dokter dan kelas perawatan sesuai dengan keinginanannya dan peraturan yang berlaku di Rumah sakit',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'8. ',0,0);
$pdf->MultiCell(0,$h,'Hak meminta konsultasi tentang penyakit yang dideritanya kepada dokter lain yang mempunyai Surat Izin Praktik ( SIP ) baik di dalam maupun di luar Rumah Sakit.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'9. ',0,0);
$pdf->MultiCell(0,$h,'Hak mendapatkan privacy dan kerahasiaan penyakit yang diderita termasuk data-data medisnya.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'10. ',0,0);
$pdf->MultiCell(0,$h,'Hak mendapatkan informasi yang meliputi diagnosis dan tata cara tindakan medis, tujuan tindakan medis, alternative tindakan, resiko dan komplikasi yang mungkin terjadi dan prognosis terhadap tindakan yang dilakukan serta perkiran biaya pengobatan.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'11. ',0,0);
$pdf->MultiCell(0,$h,'Hak memberikan persetujuan atau menolak atas tindakan yang akan dilakukan oleh tenaga kesehatan terhadap penyakit yang dideritanya.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'12. ',0,0);
$pdf->MultiCell(0,$h,'Hak didampingi keluarganya dalam keadaan kritis.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'13. ',0,0);
$pdf->MultiCell(0,$h,'Hak beribadah menurut agama dan kepercayaannya selama tidak menggangu ketertiban, ketenangan umum / pasien lainnya.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'14. ',0,0);
$pdf->MultiCell(0,$h,'Hak atas keamanan dan keselamatan selama dalam perwatan di Rumah.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'15. ',0,0);
$pdf->MultiCell(0,$h,'Hak untuk mengajukan usul, saran, perbaikan atas pelayanan Rumah Sakit terhadap dirinya.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'16. ',0,0);
$pdf->MultiCell(0,$h,'Hak menolak pelayanan bimbingan rohani yang tidak sesuai dengan agama dan kepercayaan yang dianutnya.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'17. ',0,0);
$pdf->MultiCell(0,$h,'Hak menggugat dan/atau menuntut Rumah Sakit apabila Rumah Sakit diduga memberikan pelayanan yang tidak sesuai dengan standar baik secara perdata ataupun pidana.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'18. ',0,0);
$pdf->MultiCell(0,$h,'Hak mengeluhkan pelayanan Rumah Sakit yang tidak sesuai dengan standar pelayanan melalui media cetak dan elektronik sesuai dengan ketentuan peraturan perundang-undangan.',0,1);

$pdf->Cell(0,1,'',0,1);//br
$pdf->setFont('','B',10);
$pdf->Cell(10,2,'',0,0);
$pdf->MultiCell(0,$h,'KEWAJIBAN PASIEN ( Pasal 26 Kebijakan Pemenkes 4 Tahun 2018 )',0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->setFont('','',9);
$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'1. ',0,0);
$pdf->MultiCell(0,$h,'Mematuhi peraturan yang berlaku di Rumah Sakit.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'2. ',0,0);
$pdf->MultiCell(0,$h,'Menggunakan fasilitas Rumah Sakit secara bertanggung jawab.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'3. ',0,0);
$pdf->MultiCell(0,$h,'Menghormati hak Pasien lain, pengunjung dan hak Tenaga Kesehatan serta petugaslainnya yang bekerja di Rumah sakit.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'4. ',0,0);
$pdf->MultiCell(0,$h,'Memberikan informasi yang jujur, lengkap dan akurat sesuai dengan kemampuan dan pengetahuannya tentang masalah kesehatannya.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'5. ',0,0);
$pdf->MultiCell(0,$h,'Memberikan informasi mengenai kemampuan finansial dan jaminan kesehatan yang dimilikinya.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'6. ',0,0);
$pdf->MultiCell(0,$h,'Mematuhi rencana terapi yang direkomendasikan oleh Tenaga Kesehatan di Rumah Sakit dan disetujui oleh pasien yang bersangkutan setelah mendapatkan penjelasan sesuai dengan ketentuan peratur perundangan-undangan.',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'7. ',0,0);
$pdf->MultiCell(0,$h,'Menerima segala konsekuensi atas keputusan pribadinya untuk menolak rencana terapi yang direkomendasikan oleh Tenaga Kesehatan dan/atau tidak mematuhi petunjuk yang diberikan oleh Tenaga Kesehatan untuk penyembuhan penyakt atau masalah kkesehatannya',0,1);

$pdf->Cell(15,$h,'',0,0);
$pdf->Cell(5,$h,'8. ',0,0);
$pdf->MultiCell(0,$h,'Memberikan imbalan jasa atas pelayanan yang diterima.',0,1);

$pdf->Cell(0,1,'',0,1);
$pdf->Cell(145,$h,'',0,0);
$pdf->Cell(0,$h,'Jakarta '.$datenow,0,1);

//QR CODE CELL
require_once("../App/library/phpqrcode/qrlib.php");
$url = $data['listdata1']['uuid4'];
$url_ext = "https://esigndocument.rsyarsi.co.id/edochakdkewajiban/".$url;
QRcode::png($url_ext, $url .".png");
// $gety = $pdf->getY();
// $pdf->Image($url.".png", 155, $gety, 25, 25, "png");

$pdf->Cell(0,1,'',0,1);//br
      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(50,$h,'Pihak I',0,0,'C');
      $pdf->Cell(65,$h,'',0,0);
       $gety = $pdf->getY();
      $pdf->Image($url.".png", 95, $gety, 25, 25, "png");
      $pdf->Cell(50,$h,'Pihak II',0,1,'C');
      
      $pdf->Cell(137,15,'',0,0);//br

      

      
    //$pdf->Image($h,$data['listdatasign']['IMAGE_PATH'].'.png',15,10,50);
    $pdf->Image($data['listdata1']['TTDPetugas'].'?ext=.png', 35, $pdf->getY(),35);
    //$pdf->Cell(120,15,'',0,0);//br
    $pdf->Image($data['listdata1']['TTD_PasienWali'].'?ext=.png', $pdf->getX(), $pdf->getY(),35);
    $pdf->Cell(0,15,'',0,1);//br
    $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(50,$h,$data['listdata1']['Petugas'],0,0,'C');
      $pdf->Cell(65,$h,'',0,0);
      $pdf->Cell(50,$h,$data['listdata1']['NamaWaliPasien'],0,1,'C');
      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(50,$h,$data['listdata1']['Divisi'],0,0,'C');
      $pdf->setFont('','',7);
      $pdf->Cell(65,$h,'Scan this for validate',0,0,'C');
      $pdf->setFont('','',9);
      $pdf->Cell(50,$h,'Pasien / Kel. Pasien',0,0,'C');

      //$certificate = 'file://'. __DIR__ .'/your/relative/path/to/this/file/tcpdf.crt'; 
            $certificate2 = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.crt'; 
                $key = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.key';
               
        $info = array(
                         'Name' => 'TCPDF',
                         'Location' => 'Office',
                         'Reason' => 'Testing TCPDF',
                         'ContactInfo' => 'http://www.tcpdf.org',
                         );

      $pdf->setSignature($certificate2, $key, 'tcpdfdemo', '', 2, $info);

//$resolution = array(210, 80);
$html='';
// $pdf->AddPage('P');
// $html = '
// 		<style>
// 			.h_tengah {text-align: center;}
// 			.h_kiri {text-align: left;}
// 			.h_kanan {text-align: right;}
// 			.txt_judul {font-size: 10; font-weight: bold; padding-bottom: 12px; text-align: center;}
// 			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
// 			.txt_content {font-size: 7pt; text-align: center;}
// 			.right{float:right;}
// 			.left{float:left;}
// 			.tabler {
// 				  border-collapse: collapse;
// 				  width: 100%;
// 				}

// 				.tabler td, th {
// 				  border: 1px solid #fff;
// 				  text-align: left;
// 				  padding: 8px;
// 				}

// 				.tabler tr:nth-child(even) {
// 				  background-color: #dddddd;
// 				}
// 				.tablex {
// 				  border-collapse: collapse;
// 				  width: 100%;
// 				}
// 				.tablex td, th {
// 				  border: 1px solid #000;
// 				  text-align: left;
// 				  padding: 8px;

// 				}
// 				.tablex tr:nth-child(even) {
// 				  background-color: #dddddd;
// 				}
// 		</style>';

// $html .= '
// 		<table width="100%" cellspacing="0" cellpadding="1" border="0" >
//                   <tbody> 
// 					  <tr>
// 					    <td width="20%"><img src="BASEURL;/../../public/images/gutlogo.PNG"  width="90" height="45"></td>
// 					    <td align="center" width="60%"><b>REKAP PERHITUNGAN GAJI KARYAWAN LOKAL DAN ALLOWANCE</b></td>
// 					  </tr>
// 					  <tr>
// 					    <td align="left" width="10%"><font size="8"><b>Bulan</font></b></td>
// 					    <td align="left" width="2%">:</td>
// 					    <td align="left" width="60%"></td>
// 					  </tr>
// 					  <tr>
// 					    <td align="left" width="10%"><font size="8"><b>Project</font></b></td>
// 					    <td align="left" width="2%">:</td>
// 					    <td align="left" width="60%"></td>
// 					  </tr>
// 					  <tr>
// 					    <td align="left" width="20%"><u>Lokal Jakarta</U></td>
// 					  </tr>
//                   </tbody>
//                 </table>

//                 <table width="100%"  cellspacing="0" cellpadding="3" border="1" style="border: 1px solid #000;">
//                   <tbody> 
// 					  <tr>
// 					    <td align="center"  width="10%">ID</td>
// 					    <td align="center"  width="31%">Nama</td>
// 					    <td  align="center"  width="15%">Jabatan</td>
// 					    <td  align="center"  width="15%">Gaji Sebulan</td>
// 					    <td  align="center"  width="15%">PPh 21</td>
// 					    <td  align="center"  width="15%">Gaji Bersih</td>
// 					  </tr>';
//                 $html .= ' 
//                   </tbody>
//                   <tfoot>
//                    <tr>
// 					    <td align="right"  width="56%"><b>Total</b></td>
// 					    <td  align="right"  width="15%"><b></b></td>
// 					    <td  align="right"  width="15%"><b></b></td>
// 					    <td  align="right"  width="15%"><b></b></td>
// 					  </tr>
//                   </tfoot>
//                 </table>';

            
$pdf->SetFont('', '', 9); // default font header
$pdf->writeHTML($html, true, false, true, false, '');
unlink($url.".png");

//$pdf->output();
