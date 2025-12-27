<?php
   date_default_timezone_set('Asia/Jakarta');
$pdf = new FPDF('P','mm','A4');
// $datereal = date('d-m-Y');
$bulan = Date('m');

if ($bulan == '01'){
  $bulanx = 'Januari';
}elseif($bulan == '02'){
  $bulanx = 'Februari';
}elseif($bulan == '03'){
  $bulanx = 'Maret';
}elseif($bulan == '04'){
  $bulanx = 'April';
}elseif($bulan == '05'){
  $bulanx = 'Mei';
}elseif($bulan == '06'){
  $bulanx = 'Juni';
}elseif($bulan == '07'){
  $bulanx = 'Juli';
}elseif($bulan == '08'){
  $bulanx = 'Agustus';
}elseif($bulan == '09'){
  $bulanx = 'September';
}elseif($bulan == '10'){
  $bulanx = 'Oktober';
}elseif($bulan == '11'){
  $bulanx = 'November';
}elseif($bulan == '12'){
  $bulanx = 'Desember';
}
$tglnow = Date('d');
$tahunnow = Date('Y');

if($data['FS_JENIS_CUSTOMER'] =="Asuransi"){
    $norekeningPL = "76666-222-64"; 
    $namarekPL = "BSI ( BANK SYARIAH INDONESIA )";
}else{

  if ($data['idJaminanx'] == "384" ) {
      $norekeningPL = "860-010-597-000";
      $namarekPL = "BANK CIMB NIAGA";
  } else{
    $norekeningPL = "76666-222-56";
      $namarekPL = "BSI ( BANK SYARIAH INDONESIA )";
  }
      
    
}

if($data['Fs_Code_Jenis_Reg'] =="RJ"){
    $jenissurat ="Tagihan Rawat Pemeriksaan Mata MCU";
  }else{
    $jenissurat ="Tagihan Rawat Inap";
  }

$pdf->AddPage();
$pdf->Image('../public/images/yarsi.png',25,20,50);
$pdf->Ln(10);
// cell(widht, height, text, border, end line , [ALIGN] )

// set font to arial, bold, 14pt
$pdf->setFont('Arial','',9);

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(110,4,'',0,0);
$pdf->Cell(59 ,5,'Jl. Pemuda No.19, Desa Blubuk',0,1);//end of line

$pdf->Cell(110,4,'',0,0);
$pdf->Cell(34 ,4,'Kec. Losari, Kabupaten Brebes, Jawa Tengah 52255',0,1);//end of line

$pdf->Cell(110,4,'',0,0);
$pdf->Cell(30 ,4,'Phone 0811-1901-1119',0,1);

$pdf->Cell(110,4,'',0,0);
$pdf->Cell(34 ,4,'www.brebeseyecenter.com',0,1);//end of line

$pdf->Cell(110,4,'',0,0);
$pdf->Cell(34 ,4,'',0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->cell(189 ,10,'',0,1);//end of line

$pdf->setFont('Arial','BU',18);
$pdf->Cell(0 ,4,'SURAT TAGIHAN',0,1,'C');//end of line

$pdf->setFont('Arial','B',10);
$pdf->Cell(0,6,$data['keterangan'],0,1,'C');//end of line

$pdf->Cell(0,6,'',0,1);//br
$pdf->setFont('Arial','',10);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(0,5,$data['FD_TGL_TRSx'],0,1,'R');

$pdf->setFont('Arial','',10);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(18,5,'No. Surat',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->Cell(0,5,$data['keterangan'],0,1);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(18,5,'Lampiran',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->Cell(0,5,'1 Berkas',0,1);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(18,5,'Hal',0,0);
$pdf->Cell(2,5,':',0,0);
$pdf->Cell(0,5,$jenissurat,0,1);
$pdf->Cell(20,5,'',0,1);

$pdf->setFont('Arial','',10);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(0,5,'Kepada Yth.',0,1);
$pdf->Cell(20,5,'',0,0);
$pdf->MultiCell(0,5,$data['namaperusahaan'],0,1);
$pdf->Cell(20,5,'',0,0);
$pdf->MultiCell(0,5,$data['FS_Alamat_Tagih'],0,1);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(0,5,'Up : Bagian Claim',0,1);
$pdf->Cell(0,5,'',0,1);//br

$pdf->setFont('Arial','',10);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(0,5,'Dengan Hormat,',0,1);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(0,5,'Bersama surat ini kami kirimkan kwitansi biaya Pemeriksaan Mata MCU',0,1);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(0,5,'Karyawan/Peserta : ',0,1);
$pdf->Cell(20,5,'',0,1);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(0,5,'Nama Karyawan   : ( Terlampir )',0,1);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(0,5,'Nama Pasien        : ( Terlampir )',0,1);
$pdf->Cell(0,5,'',0,1);//br
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(0,5,'Adapun Jumlah biaya Pemeriksaan Mata MCU tersebut sebesar Rp. '.number_format($data['FN_TOTAL_TAGIH'],0,',','.'),0,1);

// invoice Contents
$pdf->setFont('Arial','',10);
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->cell(0 ,5,'Untuk pembayarannya harap Bapak/ Ibu transfer ke rekening kami: :',0,1,'L');
$pdf->Cell(20,5,'',0,0);//br
$pdf->Cell(29,5,'Nama Bank         :',0,0);
$pdf->cell(0 ,5,'BANK BRI',0,1,'L');
 
$pdf->Cell(20,5,'',0,0);//br
$pdf->cell(0 ,5,'No. Rekening      : 0028-0100-26255-67',0,1,'L');  
$pdf->Cell(20,5,'',0,0);//br
$pdf->cell(0 ,5,'Atas Nama          : BREBES EYE CENTER',0,1,'L');
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->Cell(0,5,'Atas perhatiannya saya ucapkan terima kasih. ',0,1);
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->cell(40 ,5,'Brebes, '.$tglnow.' '.$bulanx.' '.$tahunnow,0,1,'l');//end of line

$pdf->setFont('Arial','U',10);
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->cell(40 ,1,'Uun Kurniasih, SKep, Ners',0,1,'l');//end of line

$pdf->setFont('Arial','',10);
$pdf->Cell(0,1,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->cell(40 ,5,'Manager Operasional',0,1,'l');//end of line

/*/ cell(widht, height, text, border, end line , [ALIGN] )

// set font to arial, bold, 14pt
$pdf->setFont('Arial','',12);

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(50,5,'Petugas,',0,0,'C');
$pdf->Cell(80,5,'Mengetahui ,',0,1,'C');
$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(80,5,'Kepala Kasir,',0,0,'C');

$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(80,5,'',0,0,'C');
$pdf->Cell(70 ,5,'',0,1);//end of line
$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(80,5,'',0,0,'C');
$pdf->Cell(70 ,5,'',0,1);//end of line$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(80,5,'',0,0,'C');
$pdf->Cell(70 ,5,'',0,1);//end of line$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(80,5,'',0,0,'C');
$pdf->Cell(70 ,5,'',0,1);//end of line$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(80,5,'',0,0,'C');
$pdf->Cell(70 ,5,'',0,1);//end of line$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(80,5,'',0,0,'C');
$pdf->Cell(70 ,5,'',0,1);//end of line$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(80,5,'',0,0,'C');
$pdf->Cell(70 ,5,'',0,1);//end of line

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(50,5,'(___________________)',0,0,'C');
$pdf->Cell(80,5,'(___________________)',0,0,'C');
*/


$pdf->Output();
?>
