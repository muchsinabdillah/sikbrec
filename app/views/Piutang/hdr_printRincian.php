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

// if($data['FS_JENIS_CUSTOMER'] =="Asuransi"){
//     $norekeningPL = "76666-222-64"; 
//     $namarekPL = "BSI ( BANK SYARIAH INDONESIA )";
// }else{

//   if ($data['idJaminanx'] == "384" ) {
//       $norekeningPL = "860-010-597-000";
//       $namarekPL = "BANK CIMB NIAGA";
//   } else{
//     $norekeningPL = "76666-222-56";
//       $namarekPL = "BSI ( BANK SYARIAH INDONESIA )";
//   }
      
    
// }

// if($data['Fs_Code_Jenis_Reg'] =="RJ"){
//     $jenissurat ="Tagihan Rawat Jalan";
//   }else{
//     $jenissurat ="Tagihan Rawat Inap";
//   }
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
$pdf->Cell(0 ,4,'DATA PELAYANAN MCU RAWAT JALAN',0,1,'C');//end of line

$pdf->setFont('Arial','B',12);
$pdf->Cell(0,6,$data['header']['namaperusahaan'],0,1,'C');//end of line
$pdf->Cell(0,6,'Periode : '.$data['header']['fd_periode1'].' sd '.$data['header']['fd_periode2'],0,1,'C');//end of line
$pdf->Cell(0,6,'',0,1);//br
$pdf->Cell(0,5,'',0,1);//br

// invoice Header
$pdf->setFont('Arial','B',9);
$pdf->Cell(20,5,'',0,0);//br
$pdf->cell(10 ,5,'No.',1,0,'C');
$pdf->cell(60 ,5,'Nama Peserta',1,0,'C');
$pdf->cell(45 ,5,'Tgl Transaksi',1,0,'C');
$pdf->cell(40 ,5,'Nominal',1,1,'C');//end of line

$total = 0;

foreach ($data['details'] as $detail) {
    $total += $detail['nominal'];

    $pdf->setFont('Arial','',9);
    $pdf->Cell(20,5,'',0,0); // spacer
    $pdf->Cell(10,5,$detail['No'].'.',1,0,'C');
    $pdf->Cell(60,5,$detail['namapasien'],1,0,'L');
    $pdf->Cell(45,5,date('d/m/Y', strtotime($detail['tgltransaksi'])),1,0,'C');
    $pdf->Cell(40,5,'Rp '.number_format($detail['nominal'],0,',','.'),1,1,'R');
}

// Footer
$pdf->setFont('Arial','B',9);
$pdf->Cell(20,5,'',0,0);
$pdf->Cell(115,5,'Total',1,0,'C');
$pdf->Cell(40,5,'Rp '.number_format($total,0,',','.'),1,1,'R');

// $total+= $data['nominal'];

//   // invoice Contents
//   $pdf->setFont('Arial','',9);
//   $pdf->Cell(20,5,'',0,0);//br
//   $pdf->cell(10 ,5,$data['No'].'.',1,0,'C');
//   $pdf->cell(60 ,5,$data['namapasien'],1,0,'L');
//   $pdf->cell(45 ,5,date('d/m/Y', strtotime($data['tgltransaksi'])),1,0,'C');
//   $pdf->cell(40 ,5,'Rp '.number_format($data['nominal'],0,',','.'),1,1,'R');//end of line

// // invoice Footer
// $pdf->setFont('Arial','B',9);
// $pdf->Cell(20,5,'',0,0);//br
// $pdf->cell(115 ,5,'Total',1,0,'C');
// $pdf->cell(40,5,number_format($total,0,',','.'),1,1,'R');//end of line

// invoice Contents
$pdf->setFont('Arial','',9);
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->cell(40 ,5,'Brebes, '.$tglnow.' '.$bulanx.' '.$tahunnow,0,1,'l');//end of line

$pdf->setFont('Arial','U',9);
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->Cell(0,10,'',0,1);//br
$pdf->Cell(20,5,'',0,0);//br
$pdf->cell(40 ,1,'Uun Kurniasih, SKep, Ners',0,1,'l');//end of line

$pdf->setFont('Arial','',9);
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
