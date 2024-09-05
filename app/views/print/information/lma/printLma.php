<?php
date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y H:i:s");

class PDF extends FPDF
 {

//Cell with horizontal scaling if text is too wide
 function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
 {
     //Get string width
     $str_width=$this->GetStringWidth($txt);

     //Calculate ratio to fit cell
     if($w==0)
         $w = $this->w-$this->rMargin-$this->x;
     $ratio = ($w-$this->cMargin*2)/$str_width;

     $fit = ($ratio < 1 || ($ratio > 1 && $force));
     if ($fit)
     {
         if ($scale)
         {
             //Calculate horizontal scaling
             $horiz_scale=$ratio*100.0;
             //Set horizontal scaling
             $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
         }
         else
         {
             //Calculate character spacing in points
             $char_space=($w-$this->cMargin*2-$str_width)/max(strlen($txt)-1,1)*$this->k;
             //Set character spacing
             $this->_out(sprintf('BT %.2F Tc ET',$char_space));
         }
         //Override user alignment (since text will fill up cell)
         $align='';
     }

     //Pass on to Cell method
     $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

     //Reset character spacing/horizontal scaling
     if ($fit)
         $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
 }

 //Cell with horizontal scaling only if necessary
 function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
 {
     $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
 }

 //Cell with horizontal scaling always
 function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
 {
     $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
 }

 //Cell with character spacing only if necessary
 function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
 {
     $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
 }

 //Cell with character spacing always
 function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
 {
     //Same as calling CellFit directly
     $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
 }

}

 

date_default_timezone_set('Asia/Jakarta');
//$datenow = Date("d/m/Y H:i:s");
$datenow = Utils::seCurrentDateTime();
$pdf = new PDF('P','mm','A4');
//$pdf->SetAutoPageBreak(true,2);
//$datereal = date('d-m-Y');
$daterreal = Utils::datenowcreateNotFull();

$pdf->AddPage();
$pdf->Image('../public/images/yarsi.png',10,5,38);
$pdf->Ln(5);
// cell(widht, height, text, border, end line , [ALIGN] )

// set font to arial, bold, 14pt
$pdf->setFont('Arial','',9);

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(110,4,'',0,0);
$pdf->SetFont('Arial','',10);
      $pdf->Cell(75,4,'Jl. Letjen Suprapto, Cempaka Putih, Jakarta 10510',0,1,'R');

      //garis----
                                    $pdf->SetFont('Arial','U',10);
                                    $pdf->Cell(6,6,'',0,0);
                                    $pdf->Cell(180,0,'',1,1);

//make a dummy empty cell as a vertical spacer
$pdf->cell(189 ,5,'',0,1);//end of line

$pdf->setFont('Arial','B',11);
$pdf->Cell(0 ,4,'SURAT PERMINTAAN RAWAT / LAPORAN MEDIS AWAL',0,1,'C');//end of line

$pdf->Image('../public/images/bismillah.png',80,30,50,'C');
$pdf->Ln(10);

$pdf->Cell(0,3,'',0,1);//br
$pdf->setFont('Arial','',10);


//HEADER--------------------------
      //row 1 (left)-------------------
      $pdf->Cell(5,7,'',0,0);
      $pdf->Cell(30,5,'No MR',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->Cell(65,5,$data['listdata1']['NoMR'],1,0);
      //row 1 (right)
      $pdf->Cell(25,5,'Jenis Kelamin',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->Cell(0,5,$data['listdata1']['gender'],1,1);

      //row 2 (left)-------------------
      $pdf->Cell(5,7,'',0,0);
      $pdf->Cell(30,5,'Nama Pasien',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->CellFitScale(65,5,$data['listdata1']['PatientName'],1,0);
      //row 2 (right)
      $pdf->Cell(25,5,'Tgl Lahir',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->Cell(0,5,$data['listdata1']['tgllahir'],1,1);

      //row 3 (left)-------------------
      $pdf->Cell(5,7,'',0,0);
      $pdf->Cell(30,5,'Ruang Perawatan',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->CellFitScale(65,5,$data['listdata1']['jenisrawat'],1,0);
      //row 3 (right)
      $pdf->Cell(25,5,'Dokter Periksa',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->CellFitScale(0,5,$data['listdata1']['dr_pemeriksa'],1,1);

      //row 4 (left)-------------------
      $pdf->Cell(5,7,'',0,0);
      $pdf->Cell(30,5,'Isolasi',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->CellFitScale(65,5,$data['listdata1']['Isolasi'],1,0);
      //row 4 (right)
      $pdf->Cell(25,5,'DPJP',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->CellFitScale(0,5,$data['listdata1']['dpjp'],1,1);

      //row 5 (left)-------------------
      $pdf->Cell(5,7,'',0,0);
      $pdf->Cell(30,5,'Keterangan',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->CellFitScale(65,5,$data['listdata1']['keterangan'],1,0);    
      //row 4 (right)
      $pdf->Cell(25,5,'Tgl Masuk',0,0);
      $pdf->Cell(3,5,':',0,0);
      $pdf->CellFitScale(0,5,$data['listdata1']['tglmasuk'],1,1);  
      $pdf->Cell(0,2,'',0,1);//br
//#END HEADER--------------------------

//Judul---------
$pdf->setFont('Arial','B',10);
$pdf->Cell(5,5,'',0,0);
$pdf->Cell(5,5,'RIWAYAT PENYAKIT DAN PEMERIKSAAN FISIK',0,1);

$pdf->setFont('Arial','',10);
$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'1. Keluhan Utama',0,0);
$pdf->MultiCell(0,5,$data['listdata1']['keluhanutama'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'2. Sejak kapan keluhan dirasakan',0,0);
$pdf->MultiCell(0,5,$data['listdata1']['tglmulaikeluhan'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'3. Indikasi rawat inap',0,0);
$pdf->MultiCell(0,5,$data['listdata1']['IndikasiRawat'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'4. Riwayat penyakit dahulu',0,0);
$pdf->MultiCell(0,5,$data['listdata1']['RiwayatPenyakitDulu'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'5. Tanda-tanda Vital',0,0);
$pdf->MultiCell(0,5,$data['listdata1']['TTV'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'6. Hasil pemerisakaan fisik',0,0);
$pdf->MultiCell(0,5,$data['listdata1']['PemeriksaanFisik'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'7. Hasil pemeriksaan penunjang',0,0);
$pdf->MultiCell(0,5,$data['listdata1']['PemeriksaanPenunjang'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'8. Diagnosa awal / masuk',0,0);
$pdf->MultiCell(0,5,$data['listdata1']['DiagnosaAwal'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(120,5,'9. Apakah pasien pernah dirawat/ didiagnosa yang sama sebelumnya?',0,0);
$pdf->MultiCell(0,5,$data['listdata1']['DiagnosaRawatSama'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'   Jika Ya, kapan?',0,0);
$pdf->Cell(50,5,$data['listdata1']['TglDiagnosaSama'],1,0);
$pdf->Cell(20,5,'Dimana?',0,0);
$pdf->Cell(45,5,$data['listdata1']['Dimana'],1,1);

$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(70,5,'10. Apakah keluhan / diagnosa pasien saat ini berhubungan / disebabkan oleh :*',0,1);

//-----------------
$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Radang pada usus 12 jari',0,0);
$pdf->Cell(25,5,$data['listdata1']['RadangUsus12Jari'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Penyakit kongenital / bawaan lahir',0,0);
$pdf->Cell(25,5,$data['listdata1']['BawaanLahir'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Tukak / ulkus pada lambung / usus 12 jari',0,0);
$pdf->Cell(25,5,$data['listdata1']['TukakLambung'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Komplikasi kehamilan / persalinan',0,0);
$pdf->Cell(25,5,$data['listdata1']['KomplikasiHamil'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Masalah psikosomatis / kejiwaan',0,0);
$pdf->Cell(25,5,$data['listdata1']['Kejiwaan'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Penyakit pada saluran reproduksi',0,0);
$pdf->Cell(25,5,$data['listdata1']['SaluranProduksi'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Penyakit jantung dan pembuluh darah',0,0);
$pdf->Cell(25,5,$data['listdata1']['PenyakitJantung'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Penggunaan alat konstrasepsi / KB',0,0);
$pdf->Cell(25,5,$data['listdata1']['KB'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Tumor / benjolan / kista',0,0);
$pdf->Cell(25,5,$data['listdata1']['Tumor'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Hepatitis',0,0);
$pdf->Cell(25,5,$data['listdata1']['Hepatitis'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Penyakit tekanan darah tinggi',0,0);
$pdf->Cell(25,5,$data['listdata1']['DarahTinggi'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Kelainan pada tulang belakang',0,0);
$pdf->Cell(25,5,$data['listdata1']['TulangBelakang'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Diabetes Melitus',0,0);
$pdf->Cell(25,5,$data['listdata1']['DM'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Penyakit pada gigi dan komplikasinya',0,0);
$pdf->Cell(25,5,$data['listdata1']['Gigi'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Tuberculosis',0,0);
$pdf->Cell(25,5,$data['listdata1']['Tuberculosis'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Hormonal',0,0);
$pdf->Cell(25,5,$data['listdata1']['Hormonal'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Batu pada ginjal / saluran kemih',0,0);
$pdf->Cell(25,5,$data['listdata1']['BatuGinjal'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Geriatri',0,0);
$pdf->Cell(25,5,$data['listdata1']['Geriatri'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Batu Empedu',0,0);
$pdf->Cell(25,5,$data['listdata1']['BatuEmpedu'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Drugs abuse / Alkoholisme',0,0);
$pdf->Cell(25,5,$data['listdata1']['Alkoholisme'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Penyakit / kelainan pada darah',0,0);
$pdf->Cell(25,5,$data['listdata1']['KelainanDarah'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Kecelakaan kerja / KLL',0,0);
$pdf->Cell(25,5,$data['listdata1']['KLL'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Penyakit pada tonsil / Adenoid',0,0);
$pdf->Cell(25,5,$data['listdata1']['Tonsil'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Tentamen Suicide',0,0);
$pdf->Cell(25,5,$data['listdata1']['Tentamen'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Kelainan rongga hidung / Sinus',0,0);
$pdf->Cell(25,5,$data['listdata1']['Sinus'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'STDH / HIV / AID / ARC',0,0);
$pdf->Cell(25,5,$data['listdata1']['STDH'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Penyakit pada telinga',0,0);
$pdf->Cell(25,5,$data['listdata1']['Telinga'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Kosmetik',0,0);
$pdf->Cell(25,5,$data['listdata1']['Kosmetik'],1,1,'C');

$pdf->Cell(12,5,'',0,0);//br
$pdf->CellFitScale(65,5,'Asthma',0,0);
$pdf->Cell(25,5,$data['listdata1']['Asthma'],1,0,'C');

$pdf->Cell(3,5,'',0,0);//br
$pdf->CellFitScale(60,5,'Radang pada usus buntu / appendiks',0,0);
$pdf->Cell(25,5,$data['listdata1']['Appendiks'],1,1,'C');
//--------------------

$pdf->Cell(0,2,'',0,1);


//judul
$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(50,5,'11. Terapi saat ini :',0,1);

//kotak
$pdf->Cell(13,5,'',0,0);//br
$pdf->MultiCell(0,5,$data['listdata1']['TerapiSaatini'],1,1);

$pdf->Cell(11,5,'',0,0);//br
$pdf->Cell(50,5,'Medical Spesialstik :',0,1);
//kotak
$pdf->Cell(13,5,'',0,0);//br
$pdf->MultiCell(0,5,$data['listdata1']['MedicalSpesialistik'],1,1);

$gety = $pdf->getY();

if(($gety>250.00125 && $gety<252.000000) || $gety < 230.000000){
$pdf->SetAutoPageBreak(true,2);  
}else{
$pdf->SetAutoPageBreak(true,50);  
}


$pdf->Cell(0,1,'',0,1);
//nomor 12
$pdf->Cell(5,5,'',0,0);//br
$pdf->Cell(80,5,'12. Untuk tindakan Operatif, mohon informasi :',0,0);
$pdf->Cell(55,5,'13. Perkiraan lama rawat (hari) :',0,0);
$pdf->Cell(10,5,$data['listdata1']['LamaRawat'],1,1);

$pdf->Cell(12,5,'',0,0);//br
$pdf->Cell(30,5,'Nama Operasi :',0,0);
$pdf->Cell(5,5,'1. ',0,0);
$pdf->Cell(74,5,$data['listdata1']['Operasi1'],1,0);
$pdf->Cell(30,5,'Jenis Anestesi',0,0);
$pdf->Cell(40,5,$data['listdata1']['JenisAnastesi'],1,1);

$pdf->Cell(12,5,'',0,0);//br
$pdf->Cell(30,5,'',0,0);
$pdf->Cell(5,5,'2. ',0,0);
$pdf->Cell(74,5,$data['listdata1']['Operasi2'],1,0);
$pdf->CellFitScale(30,5,'Status Pembedahan',0,0);
$pdf->Cell(40,5,$data['listdata1']['StatusPembedahan'],1,1);

$pdf->Cell(12,5,'',0,0);//br
$pdf->Cell(30,5,'',0,0);
$pdf->Cell(45,5,'Waktu jadwal pembedahan',0,0);
$pdf->Cell(34,5,$data['listdata1']['JadwalBedah'],1,0);
$pdf->CellFitScale(30,5,'Jumlah Sayatan',0,0);
$pdf->Cell(40,5,$data['listdata1']['JumlahSayatan'],1,1);





//-----------------------------------
$pdf->Cell(5,5,'',0,0);
$pdf->Cell(86,5,'Saya, Dokter yang merawat dengan ini menyatakan bahwa keterangan tersebut di atas adalah benar dan lengkap.',0,1);
$pdf->Cell(0,1,'',0,1);//br

$pdf->setFont('Arial','',10);
$pdf->Cell(5,5,'',0,0);
$pdf->Cell(70,5,'Jakarta,'.$datenow,0,0,'L');
$pdf->Cell(85,5,'Perawatan ini berhubungan dengan kecelakanaan?',0,0);
$pdf->Cell(25,5,$data['listdata1']['Kecelakaan'],1,1);

$pdf->Cell(5,5,'',0,0);
$pdf->Cell(70,5,'Dokter yang Merawat,',0,0,'L');
$pdf->Cell(65,5,'Tgl. Kecelakaan',0,0);
$pdf->Cell(45,5,$data['listdata1']['TglKecelakaan'].' '.$data['listdata1']['JamKecelakaan'],1,1);

$pdf->Cell(5,5,'',0,0);
$pdf->Cell(70,5,'',0,0,'L');
$pdf->Cell(35,5,'Sebab Kecelakaan',0,0);
$pdf->Cell(75,5,$data['listdata1']['SebabKecelakaan'],1,1);

$pdf->Cell(0,11,'',0,1);//br

$pdf->Cell(5,5,'',0,0);
$pdf->Cell(70,8,$data['listdata1']['dr_pemeriksa'],0,1,'L');

//$pdf->Image($Foto,7,7,40);
//$pdf->Ln(5);

// Close the connection.
                  

$pdf->Output();