<?php
date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y H:i:s");

class PDF extends FPDF
 {
    function GetMargins() {
        return array(
            'left' => $this->lMargin,
            'top' => $this->tMargin,
            'right' => $this->rMargin
        );
    }
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
$pdf = new PDF('L', 'mm', 'A4');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();
$pdf->Image('../public/images/yarsi.png',10,5,38);
$pdf->Ln(5);
// cell(widht, height, text, border, end line , [ALIGN] )

// set font to arial, bold, 14pt
$pdf->setFont('Arial','',9);

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(180,4,'',0,0);
$pdf->SetFont('Arial','',10);
      $pdf->Cell(75,4,'Jl. angkasa No.19, Dukuhkrikil',0,1,'R');

      //garis----
                                    $pdf->SetFont('Arial','U',10);
                                    $pdf->Cell(6,6,'',0,0);
                                    $pdf->Cell(260,0,'',1,1);

//make a dummy empty cell as a vertical spacer
$pdf->cell(189 ,5,'',0,1);//end of line

$pdf->setFont('Arial','B',11);
$pdf->Cell(0 ,4,'Information Jasa Dokter',0,1,'C');//end of line

$pdf->Image('../public/images/bismillah.png',120,30,50,'C');
$pdf->Ln(10);

$pdf->Cell(0,3,'',0,1);//br
$pdf->setFont('Arial','',6);


//HEADER--------------------------
      //row 1 (left)-------------------
      $header = ['No.', 'Tgl. Billing', 'No. Transaksi', 'No. Registrasi', 'Nama Pasien', 'Nama Jaminan', 'Nama Dokter', 'Nama Tarif', 'Total Tarif', 'Nilai Jasa Dokter'];
      $widths = array_fill(0, count($header), 0); // Inisialisasi lebar kolom
      
      // Hitung lebar maksimum untuk setiap kolom
      foreach ($header as $index => $col) {
        $maxWidth = $pdf->GetStringWidth($col) + 10; // Tambahkan padding
        foreach ($data['listdatadetail'] as $detail) {
            $maxWidth = max($maxWidth, $pdf->GetStringWidth($detail[array_keys($detail)[$index]]));
        }
        $widths[$index] = $maxWidth; // Set lebar kolom
    }
    $totalWidth = array_sum($widths);

// Mengatur lebar kolom agar sesuai dengan halaman
$maxPageWidth = 240 - $pdf->GetMargins()['left'] - $pdf->GetMargins()['right'];
if ($totalWidth > $maxPageWidth) {
    // Hitung faktor skala
    $scaleFactor = $maxPageWidth / $totalWidth;
    $widths = array_map(function($w) use ($scaleFactor) {
        return $w * $scaleFactor;
    }, $widths);
}
      
      // Hitung lebar maksimum untuk setiap data
      foreach ($data['listdatadetail'] as $detail) {
          $widths[0] = max($widths[0], $pdf->GetStringWidth($detail ['no'])); // No.
          $widths[1] = max($widths[1], $pdf->GetStringWidth($detail['TGL_BILLING']));
          $widths[2] = max($widths[2], $pdf->GetStringWidth($detail['NO_TRS_BILLING']));
          $widths[3] = max($widths[3], $pdf->GetStringWidth($detail['NO_REGISTRASI']));
          $widths[4] = max($widths[4], $pdf->GetStringWidth($detail['PatientName']));
          $widths[5] = max($widths[5], $pdf->GetStringWidth($detail['NamaJaminan']));
          $widths[6] = max($widths[6], $pdf->GetStringWidth($detail['NM_DR']));
          $widths[7] = max($widths[7], $pdf->GetStringWidth($detail['NAMA_TARIF']));
          $widths[8] = max($widths[8], $pdf->GetStringWidth($detail['TOTAL_TARIF']));
          $widths[9] = max($widths[9], $pdf->GetStringWidth($detail['nilaijasadokter']));
      }
      
      // Menambahkan margin pada setiap kolom
      $margin = 1; // Margin
      foreach ($widths as &$width) {
          $width += $margin;
      }
      
      // Menghasilkan header tabel
      $pdf->SetFont('Arial', '', 6);
      $pdf->Cell(5, 7, '', 0, 0); // Spasi
      foreach ($header as $index => $col) {
          $pdf->Cell($widths[$index], 5, $col, 1, 0, 'C');
      }
      $pdf->Ln();
      
      // Mengisi tabel dengan data
      $pdf->SetFont('Arial', '', 6);
      $totalTarif = 0; // Inisialisasi total tarif
      $nilaijasa = 0;
      foreach ($data['listdatadetail'] as $index => $detail) {
          $pdf->Cell(5, 7, '', 0, 0); // Spasi
          $pdf->Cell($widths[0], 5, $index + 1, 1, 0); // No.
          $pdf->Cell($widths[1], 5, $detail['TGL_BILLING'], 1, 0);
          $pdf->Cell($widths[2], 5, $detail['NO_TRS_BILLING'], 1, 0);
          $pdf->Cell($widths[3], 5, $detail['NO_REGISTRASI'], 1, 0);
          $pdf->Cell($widths[4], 5, $detail['PatientName'], 1, 0);
          $pdf->Cell($widths[5], 5, $detail['NamaJaminan'], 1, 0);
          $pdf->Cell($widths[6], 5, $detail['NM_DR'], 1, 0);
          $pdf->Cell($widths[7], 5, $detail['NAMA_TARIF'], 1, 0);
          $pdf->Cell($widths[8], 5, number_format($detail['TOTAL_TARIF'], 0, ',', '.'), 1, 0); // Format dengan ribuan
          $pdf->Cell($widths[9], 5, number_format($detail['nilaijasadokter'], 0, ',', '.'), 1, 1); // Akhir baris
      
          // Tambah ke total
          $totalTarif += $detail['TOTAL_TARIF'];
          $nilaijasa += $detail['nilaijasadokter'];

      }
      
      // Menampilkan total di akhir tabel
      $pdf->Cell(5, 7, '', 0, 0); // Spasi
// $pdf->Cell(array_sum($widths) - $widths[1], 5, 'Total', 1, 0, 'C'); // Total Label

      $pdf->Cell($widths[0], 5, '', 1, 0); // No.
      $pdf->Cell($widths[1], 5, '', 1, 0);
      $pdf->Cell($widths[2], 5, '', 1, 0);
      $pdf->Cell($widths[3], 5, '', 1, 0);
      $pdf->Cell($widths[4], 5, '', 1, 0);
      $pdf->Cell($widths[5], 5, '', 1, 0);
      $pdf->Cell($widths[6], 5, '', 1, 0);
      $pdf->Cell($widths[7], 5, '', 1, 0);
      $pdf->Cell($widths[8], 5, number_format($totalTarif, 0, ',', '.'), 1, 0); // Total Tarif
      $pdf->Cell($widths[9], 5, number_format($nilaijasa, 0, ',', '.'), 1, 1); // Kolom Nilai Jasa Dokter kosong

    //      $pdf->Cell(10,5,$data['listdatadetail'][0]['no'],1,0);
    // //   $pdf->Cell(30,5,$data['listdatadetail'][0]['TGL_BILLING'],1,0);
    // //   $pdf->Cell(30,5,$data['listdatadetail'][0]['NO_TRS_BILLING'],1,0);
    // //   $pdf->Cell(30,5,$data['listdatadetail'][0]['NO_REGISTRASI'],1,0);
    // //   $pdf->Cell(30,5,$data['listdatadetail'][0]['PatientName'],1,0);
    // //   $pdf->Cell(30,5,$data['listdatadetail'][0]['NamaJaminan'],1,0);
    // //   $pdf->Cell(30,5,$data['listdatadetail'][0]['NM_DR'],1,0);
    // //   $pdf->Cell(30,5,$data['listdatadetail'][0]['NAMA_TARIF'],1,0);
    // //   $pdf->Cell(30,5,$data['listdatadetail'][0]['TOTAL_TARIF'],1,0);
    // //   $pdf->Cell(30,5,$data['listdatadetail'][0]['nilaijasadokter'],1,0);


$pdf->Output();