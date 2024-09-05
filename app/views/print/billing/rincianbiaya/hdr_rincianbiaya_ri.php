<?php
//$GLOBALS['judul'] = $data['judul'];
$GLOBALS['listdataheader'] = $data['listdataheader'];
class PDF extends TCPDF
{

    // var $htmlHeader;

    // public function setHtmlHeader($htmlHeader)
    // {
    //     $this->htmlHeader = $htmlHeader;
    // }

    // public function Header()
    // {
    //     $this->Image('../public/images/yarsi.png', 10, 4, 40);
    //     $this->Image('../public/images/footer2.png', 100, 0, 35);
    //     $this->writeHTMLCell(
    //         $w = 0,
    //         $h = 0,
    //         $x = '',
    //         $y = '',
    //         $this->htmlHeader,
    //         $border = 0,
    //         $ln = 1,
    //         $fill = 0,
    //         $reseth = true,
    //         $align = 'top',
    //         $autopadding = true
    //     );
    // }
    // Page header
    function Header()
    {
        $this->Image('../public/images/yarsi.png', 10, 4, 40);
        $this->Image('../public/images/LogoGabungCert.png',150,0,45);

        $this->Cell(0, 18, '', 0, 1); //br
        $this->setFont('', 'b', 12);
        $this->Cell(0, 5, 'RINCIAN BIAYA RAWAT INAP', 'B', 1,'C');
        //$this->Line(15, 26, $this->w - 15, 26);

        $this->setFont('', '', 10);
        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Nama Pasien', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(80, 5, $GLOBALS['listdataheader']['PatientName'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(25, 5, 'No. RM', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(70, 5, $GLOBALS['listdataheader']['NoMR'], 0, 1);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Tanggal Lahir', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(80, 5, $GLOBALS['listdataheader']['DateOfBirth'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(25, 5, 'No. Registrasi', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(70, 5, $GLOBALS['listdataheader']['NoRegistrasi'], 0, 1);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Jenis Kelamin', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(80, 5, $GLOBALS['listdataheader']['Gander'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(25, 5, 'Alih Status Dari', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(70, 5, $GLOBALS['listdataheader']['NoRegisRWJ'], 0, 1);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Alamat', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->CellFitScale(80, 5, $GLOBALS['listdataheader']['Address'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(25, 5, 'Tanggal Masuk', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(70, 5, $GLOBALS['listdataheader']['TglKunjungan'], 0, 1);
        
        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Penjamin', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->CellFitScale(80, 5, $GLOBALS['listdataheader']['NamaJaminan'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(25, 5, 'Tanggal Keluar', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(70, 5, $GLOBALS['listdataheader']['TglPulang'], 0, 1);

         
        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'DPJP', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->CellFitScale(80, 5, $GLOBALS['listdataheader']['NamaDokter'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(25, 5, 'Kelas Rawat', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(70, 5, $GLOBALS['listdataheader']['IdUnit'], 0, 1);

         
        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Ruang Rawat', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->CellFitScale(80, 5, $GLOBALS['listdataheader']['NamaUnit'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(25, 5, 'COB', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->CellFitScale(70, 5, $GLOBALS['listdataheader']['NamaCOB'], 0, 1);

        //Header-------------------------
        $this->SetFont('','B',10);
        $this->Cell(2,5,'','BT',0);
        $this->Cell(86,5,'Pelayanan','BT',0);
        $this->Cell(25,5,'Tanggal','BT',0,'C');
        $this->Cell(7,5,'Qty','BT',0,'R');
        $this->Cell(23,5,'Harga','BT',0,'R');
        $this->Cell(13,5,'Disc','BT',0,'R');
        $this->Cell(23,5,'Total','BT',1,'R');


        // $html = '
    	// <style>
    	// 	.h_tengah {text-align: center;}
    	// 	.h_kiri {text-align: left;}
    	// 	.h_kanan {text-align: right;}
    	// 	.txt_judul {font-size: 10; font-weight: bold; padding-bottom: 12px; text-align: center;}
    	// 	.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
    	// 	.txt_content {font-size: 7pt; text-align: center;}
    	// 	.right{float:right;}
    	// 	.left{float:left;}
    	// 	.tabler {
    	// 		  border-collapse: collapse;
    	// 		  width: 100%;
    	// 		}

    	// 		.tabler td, th {
    	// 		  border: 1px solid #fff;
    	// 		  text-align: left;
    	// 		  padding: 8px;
    	// 		}

    	// 		.tabler tr:nth-child(even) {
    	// 		  background-color: #dddddd;
    	// 		}
    	// 		.tablex {
    	// 		  border-collapse: collapse;
    	// 		  width: 100%;
    	// 		}
    	// 		.tablex td, th {
    	// 		  border: 1px solid #000;
    	// 		  text-align: left;
    	// 		  padding: 8px;

    	// 		}
    	// 		.tablex tr:nth-child(even) {
    	// 		  background-color: #dddddd;
    	// 		}
    	// </style>';

        // $html .= '
        //               <table width="100%" cellspacing="0" cellpadding="1" border="0" >
        //               <tbody>
        //                 <tr>
        //                   <td width="40%"></td>
        //                   </tr>
        //                   <br>
        //                   <tr>
        //                   <td align="Center" width="100%"><font size="12"><b>'.$GLOBALS['judul'].'</b></font></td>
        //                   </tr>
        //                   </tbody></table><hr>
        //                   <table width="100%" cellspacing="0" cellpadding="1" border="0" >
        //                   <tbody>
        //                   <tr>
        //                   <td align="left" width="15%"><font size="10">Nama Pasien</font></td>
        //                   <td align="left" width="1%">:</td>
        //                   <td align="left" width="34%">'.$GLOBALS['listdataheader']['PatientName'].'</td>
        //                   <td align="left" width="15%">Dokter</td>
        //                   <td align="left" width="1%">:</td>
        //                   <td align="left" width="34%">'.$GLOBALS['listdataheader']['NamaDokter'].'</td>
        //                   </tr>
                
        //                   <tr>
        //                   <td align="left" width="15%"><font size="10">No MR/Reg</font></td>
        //                   <td align="left" width="1%">:</td>
        //                   <td align="left" width="10%">'.$GLOBALS['listdataheader']['NoMR'].'</td>
        //                   <td align="left" width="1%">/</td>
        //                   <td align="left" width="23%">'.$GLOBALS['listdataheader']['NoRegistrasi'].'</td>
        //                   <td align="left" width="15%">Instalasi</td>
        //                   <td align="left" width="1%">:</td>
        //                   <td align="left" width="34%">'.$GLOBALS['listdataheader']['NamaUnit'].'</td>
        //                   </tr>
                
        //                   <tr>
        //                   <td align="left" width="15%"><font size="10">Tgl Lahir</font></td>
        //                   <td align="left" width="1%">:</td>
        //                   <td align="left" width="34%">'.$GLOBALS['listdataheader']['DateOfBirth'].'</td>
        //                   <td align="left" width="15%">Penjamin</td>
        //                   <td align="left" width="1%">:</td>
        //                   <td align="left" width="34%">'.$GLOBALS['listdataheader']['NamaJaminan'].'</td>
        //                   </tr>
                
        //                   <tr>
        //                   <td align="left" width="15%"><font size="10">Tgl Kunjungan</font></td>
        //                   <td align="left" width="1%">:</td>
        //                   <td align="left" width="34%">'.$GLOBALS['listdataheader']['TglKunjungan'].'</td>
        //                   <td align="left" width="15%">No SEP</td>
        //                   <td align="left" width="1%">:</td>
        //                   <td align="left" width="34%">'.$GLOBALS['listdataheader']['NoSEP'].'</td>
        //                   </tr>
                
        //                   <tr>
        //                   <td align="left" width="15%"><font size="10">Tgl Pulang</font></td>
        //                   <td align="left" width="1%">:</td>
        //                   <td align="left" width="34%">'.$GLOBALS['listdataheader']['TglKunjungan'].'</td>
        //                   <td align="left" width="15%"></td>
        //                   <td align="left" width="1%"></td>
        //                   <td align="left" width="34%"></td>
        //                   </tr>
                
        //                   </tbody>
        //                   </table>
        //                   <hr>
        //                   <table width="100%" cellspacing="0" cellpadding="1" border="0" >
        // <tbody>
        //     <tr>
        //         <td align="left" width="50%"><font size="11"><b>Pelayanan</b></font></td>
        //         <td align="right" width="15%"><font size="11"><b>Harga</b></font></td>
        //         <td align="right" width="5%"><font size="11"><b>Qty</b></font></td>
        //         <td align="right" width="15%"><font size="11"><b>Diskon</b></font></td>
        //         <td align="right" width="15%"><font size="11"><b>Total</b></font></td>
        //     </tr></tbody></table><hr>
        //   ';
        // $this->writeHTML($html, true, false, true, false, '');

    }


    // Page footer
    public function Footer() {
         $this->Image('../public/images/footer_1.png', 0, 284, 210, 13);
        // Position at 15 mm from bottom
        $this->SetY(-23);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    
}


$pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);

date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y");
$datetimenow = Date("d/m/Y H:i:s");
$datenow2 = date('d F Y');
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+37, PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(true);
$html = '<style>
.h_tengah {text-align: center;}
.h_kiri {text-align: left;}
.h_kanan {text-align: right;}
.txt_judul {font-size: 10; font-weight: bold; padding-bottom: 12px; text-align: center;}
.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
.txt_content {font-size: 7pt; text-align: center;}
.right{float:right;}
.left{float:left;}
.tabler {
      border-collapse: collapse;
      width: 100%;
    }

    .tabler td, th {
      border: 1px solid #fff;
      text-align: left;
      padding: 8px;
    }

    .tabler tr:nth-child(even) {
      background-color: #dddddd;
    }
    .tablex {
      border-collapse: collapse;
      width: 100%;
    }
    .tablex td, th {
      border: 1px solid #000;
      text-align: left;
      padding: 8px;

    }
    .tablex tr:nth-child(even) {
      background-color: #dddddd;
    }
</style>';
$pdf->setPrintFooter(true);
$pdf->SetAutoPageBreak(true,25);
$pdf->getAliasNumPage();
$pdf->AddPage();


$certificate = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.crt';
$key = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.key';

$info = array(
    'Name' => 'TCPDF',
    'Location' => 'Office',
    'Reason' => 'Testing TCPDF',
    'ContactInfo' => 'http://www.tcpdf.org',
);

$pdf->setSignature($certificate, $key, 'tcpdfdemo', '', 2, $info);

$pdf->setFont('', '', 10);

$hari = date('l');
if ($hari == 'Sunday') {
    $day = 'Minggu';
} elseif ($hari == 'Monday') {
    $day = 'Senin';
} elseif ($hari == 'Tuesday') {
    $day = 'Selasa';
} elseif ($hari == 'Wednesday') {
    $day = 'Rabu';
} elseif ($hari == 'Thursday') {
    $day = 'Kamis';
} elseif ($hari == 'Friday') {
    $day  = 'Jumat';
} elseif ($hari == 'Saturday') {
    $day = 'Sabtu';
}

$grandtotal_rj = 0;
//BIAYA RAWAT JALAN
if ($data['listdataheader']['NoRegisRWJ'] != null || $data['listdataheader']['NoRegisRWJ'] != ''){
//BIAYA KLINIK
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>
<tr>
            <td align="left" width="100%"><b><u></u>'.$data['listdataheader']['NamaUnit_RWJ'].'</b></td>
        </tr>
';
$totaltarif_klinik_rj = 0;
$footer_subtotal = false;
foreach ($data['listdetail_klinik_rj'] as $row){
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['NamaProduct_ext'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%">'.number_format($row['Qty'],0,',','.').'</td>
            <td align="right" width="13%">'.number_format($row['Tarif'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['TotalTarif'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_klinik_rj += $row['TotalTarif'];
   $footer_subtotal = true;
}
    $html .= '
    </tbody>
        </table>';
//#END BIAYA KLINIK

//BIAYA OPERASI
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_operasi_rj = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_operasi_rj'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b>TINDAKAN OPERASI</b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['namatindakanop'].'</td>
            <td align="right" width="15%">'.number_format($row['TarifSatuan'],0,',','.').'</td>
            <td align="right" width="5%"></td>
            <td align="right" width="15%">'.number_format($row['Diskon_Value'],0,',','.').'</td>
            <td align="right" width="15%">'.number_format($row['Tarif'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_operasi_rj += $row['Tarif'];
   $footer_subtotal = true;
}
$html .= '
</tbody>
        </table>';
 
//#END BIAYA OPERASI

//BIAYA LABORATORIUM
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';


$totaltarif_lab_rj = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_lab_rj'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b>LABORATORIUM</b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['NamaTes'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%"></td>
            <td align="right" width="13%">'.number_format($row['TarifKelas'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['Tarif'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_lab_rj += $row['Tarif'];
   $footer_subtotal = true;
}
$html .= '
</tbody>
        </table>';
//#END BIAYA LABORATORIUM

//BIAYA RADIOLOGI
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0">
<tbody>';

$totaltarif_radiologi_rj = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_radiologi_rj'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b>RADIOLOGI</b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['REQUESTED_PROC_DESC'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%"></td>
            <td align="right" width="13%">'.number_format($row['Tarif'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['Service_Charge'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_radiologi_rj += $row['Service_Charge'];
   $footer_subtotal = true;
}
$html .= '
</tbody>
        </table>';
//#END BIAYA RADIOLOGI

//BIAYA FARMASI 
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_farmasi_rj = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_farmasi_rj'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b>FARMASI</b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['NamaProduk'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%">'.number_format($row['Qty'],0,',','.').'</td>
            <td align="right" width="13%">'.number_format($row['Harga'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['TotalTarif'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_farmasi_rj += $row['TotalTarif'];
   $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
       
//#END BIAYA FARMASI 

$subtotal_rj = $totaltarif_klinik_rj+$totaltarif_operasi_rj+$totaltarif_lab_rj+$totaltarif_radiologi_rj+$totaltarif_farmasi_rj;
//$discount_global = $data['listdataheader']['ValueDiscount'];
$discount_global_rj = 0;
$grandtotal_rj = $subtotal_rj-$discount_global_rj;

$html .= '<hr>
<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>
        <tr>
            <td align="left" width="50%"><b>Sub Total</b></td>
            <td align="right" width="50%"><b>'.number_format($grandtotal_rj,0,',','.').'</b></td>
        </tr>
</tbody>
</table>
<hr>
';

//#END BIAYA RAWAT JALAN
}

//BIAYA PAKET
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_paketop = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_paketop'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b><u>PAKET OPERASI TINDAKAN</u></b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['nama_paket'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%">'.$row['qty'].'</td>
            <td align="right" width="13%">'.number_format($row['harga'],0,',','.').'</td>
            <td align="right" width="7%"></td>
            <td align="right" width="13%">'.number_format($row['harga'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_paketop += $row['harga'];
   $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
        
    if ($footer_subtotal){
        $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>'.number_format($totaltarif_paketop,0,',','.').'</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
        }
//#END BIAYA PAKET

//BIAYA KAMAR
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_kamar = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_kamar'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b><u>KAMAR PERAWATAN</u></b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="62%">'.$row['namakamar'].'</td>
            <td align="right" width="5%">'.$row['lamarawat'].'</td>
            <td align="right" width="13%">'.number_format($row['Tarif'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon'].'</td>
            <td align="right" width="13%">'.number_format($row['biayakamar'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_kamar += $row['biayakamar'];
   $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
        
    if ($footer_subtotal){
        $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>'.number_format($totaltarif_kamar,0,',','.').'</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
        }
//#END BIAYA KAMAR

//BIAYA VISIT DAN TINDAKAN
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_visit = 0;
$footer_subtotal = false;
$first = true;
$subtotal_category = 0;
$lastitem = '';
foreach ($data['listdetail_visit'] as $row){
    //JUDUL CATEGORY (VISIT DAN TINDAKAN)
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b><u>VISITE DAN TINDAKAN</u></b></td>
        </tr>
    ';
     $first = false;
    }

    $category = $row['category'];
    //sub judul category
    if ($lastitem != $category){
        $html .= '
        <tr>
            <td align="left" width="100%"><b>'.$category.'</b></td>
        </tr>
    ';
    $no = 1;
    }

    $subtotal_category += $row['Tarif'];

    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['description'].'</td>
            <td align="center" width="12%">'.$row['VisitDate'].'</td>
            <td align="right" width="5%">'.number_format($row['Quantity'],0,',','.').'</td>
            <td align="right" width="13%">'.number_format($row['Harga'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['Tarif'],0,',','.').'</td>
        </tr>
   ';
   
   if($no == $row['countid'] && $lastitem==$category){
        $html .= '
        <tr>
            <td align="right" width="100%"><b>'.number_format($subtotal_category,0,',','.').'</b></td>
        </tr>
        ';
        $subtotal_category = 0;
   }
   $no++;
   $lastitem = $category;
   
   $totaltarif_visit += $row['Tarif'];
   $footer_subtotal = true;

}
$html .= '</tbody>
        </table>';
        
    if ($footer_subtotal){
        $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>'.number_format($totaltarif_visit,0,',','.').'</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
        }
//#END BIAYA VISIT DAN TINDAKAN

//BIAYA OPERASI
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_operasi = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_operasi'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b><u>TINDAKAN OPERASI</u></b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['namatindakanop'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%"></td>
            <td align="right" width="13%">'.number_format($row['TarifSatuan'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['Tarif'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_operasi += $row['Tarif'];
   $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
        
    if ($footer_subtotal){
        $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>'.number_format($totaltarif_operasi,0,',','.').'</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
        }
//#END BIAYA OPERASI

//BIAYA LABORATORIUM
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';


$totaltarif_lab = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_lab'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b><u>LABORATORIUM</u></b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['NamaTes'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%"></td>
            <td align="right" width="13%">'.number_format($row['TarifKelas'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['Tarif'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_lab += $row['Tarif'];
   $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
    if ($footer_subtotal){
        $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>'.number_format($totaltarif_lab,0,',','.').'</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
        }
//#END BIAYA LABORATORIUM

//BIAYA RADIOLOGI
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0">
<tbody>';

$totaltarif_radiologi = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_radiologi'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b><u>RADIOLOGI</u></b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['REQUESTED_PROC_DESC'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%"></td>
            <td align="right" width="13%">'.number_format($row['Tarif'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['Service_Charge'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_radiologi += $row['Service_Charge'];
   $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
    if ($footer_subtotal){
        $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>'.number_format($totaltarif_radiologi,0,',','.').'</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
        }
//#END BIAYA RADIOLOGI

//Terusannya nih nak el badrule+


if (!empty($data['listdetail_bhp']) || !empty($data['listdetail_obat']) || !empty($data['listdetail_retur'])){
    $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
    <tbody>
    <tr>
            <td align="left" width="100%"><b><u>FARMASI</u></b></td>
        </tr>
    </tbody>
        </table>';
}


//BIAYA FARMASI (BHP) -modelnya done
//BIAYA FARMASI BHP
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_bhp = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_bhp'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b>Bahan Habis Pakai</b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="50%">'.$row['NamaProduk'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%">'.number_format($row['Qty'],0,',','.').'</td>
            <td align="right" width="13%">'.number_format($row['Harga'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['TotalTarif'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_bhp += $row['TotalTarif'];
   $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
    if ($footer_subtotal){
        $html .= '
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"></td>
                            <td align="right" width="50%"><b>'.number_format($totaltarif_bhp,0,',','.').'</b></td>
                        </tr>
                </tbody>
                </table>
                
        ';
        }
//#END BIAYA FARMASI BHP

//BIAYA FARMASI (RESEP) -modelnya done
//BIAYA FARMASI RESEP
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_obat = 0;
$footer_subtotal = false;
$first = true;

foreach ($data['listdetail_obat'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b>Resep</b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
        <td align="left" width="50%">'.$row['NamaProduk'].'</td>
        <td align="center" width="12%">'.$row['TglOrder'].'</td>
        <td align="right" width="5%">'.number_format($row['Qty'],0,',','.').'</td>
        <td align="right" width="13%">'.number_format($row['Harga'],0,',','.').'</td>
        <td align="right" width="7%">'.$row['diskon_persen'].'</td>
        <td align="right" width="13%">'.number_format($row['TotalTarif'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_obat += $row['TotalTarif'];
   $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
    if ($footer_subtotal){
        $html .= '
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"></td>
                            <td align="right" width="50%"><b>'.number_format($totaltarif_obat,0,',','.').'</b></td>
                        </tr>
                </tbody>
                </table>
                
        ';
        }
//#END BIAYA FARMASI RESEP

//BIAYA FARMASI (RETUR) -modelnya done
//BIAYA FARMASI RETUR
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_retur = 0;
$footer_subtotal = false;
$first = true;
// var_dump($data['listdetail_bhp']);
// exit;
// if($data['listdetail_bhp'] == [0]){
//     var_dump('anjay');
//     exit;
// }
foreach ($data['listdetail_retur'] as $row){
    if ($first){
        $html .= '
        <tr>
            <td align="left" width="100%"><b>Retur</b></td>
        </tr>
    ';
     $first = false;
    }
    $html .= '
        <tr>
           <td align="left" width="50%">'.$row['NamaProduk'].'</td>
            <td align="center" width="12%">'.$row['TglOrder'].'</td>
            <td align="right" width="5%">'.number_format($row['Qty'],0,',','.').'</td>
            <td align="right" width="13%">'.number_format($row['Harga'],0,',','.').'</td>
            <td align="right" width="7%">'.$row['diskon_persen'].'</td>
            <td align="right" width="13%">'.number_format($row['TotalTarif'],0,',','.').'</td>
        </tr>
   ';
   $totaltarif_retur += $row['TotalTarif'];
   $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';

    if ($footer_subtotal){
        $html .= '
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"></td>
                            <td align="right" width="50%"><b>'.number_format($totaltarif_retur,0,',','.').'</b></td>
                        </tr>
                </tbody>
                </table>
                
        ';
        }
//#END BIAYA FARMASI RETUR

$totaltarif_farmasi=$totaltarif_bhp+$totaltarif_obat+$totaltarif_retur;
//SUB TOTAL FARMASI
if (!empty($data['listdetail_bhp']) || !empty($data['listdetail_obat']) || !empty($data['listdetail_retur'])){
    $html .= '<hr><table width="100%" cellspacing="0" cellpadding="1" border="0" >
    <tbody>
    <tr>
        <td align="left" width="50%"><b>Sub Total</b></td>
        <td align="right" width="50%"><b>'.number_format($totaltarif_farmasi,0,',','.').'</b></td>
    </tr>
    </tbody>
        </table><hr>';
}

$subtotal = $totaltarif_paketop+$totaltarif_kamar+$totaltarif_operasi+$totaltarif_visit+$totaltarif_lab+$totaltarif_radiologi+$totaltarif_farmasi+$grandtotal_rj;
$discount_global = $data['listdataheader']['Discount'];
//$grandtotal = $subtotal-$discount_global;
$biaya_adm = $data['listdataheader']['BiayaAdm'];
$biaya_materai = $data['listdataheader']['materai'];
$totalbill = $subtotal + $biaya_adm + $biaya_materai;
$grandtotal_all = $totalbill - $discount_global;

//TOTAL
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
    <tbody>
    <tr>
        <td align="left" width="100%"></td>
    </tr>
    </tbody>
        </table>
        <table width="100%" cellspacing="0" cellpadding="1" border="0" >
    <tbody>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="20%"><font size="11"><b>Total Biaya</b></font></td>
        <td align="right" width="20%"><font size="11"><b>'.number_format($subtotal,0,',','.').'</b></font></td>
    </tr>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="20%"><font size="11"><b>Administrasi</b></font></td>
        <td align="right" width="20%"><font size="11"><b>'.number_format($biaya_adm,0,',','.').'</b></font></td>
    </tr>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="20%"><font size="11"><b>Materai</b></font></td>
        <td align="right" width="20%"><font size="11"><b>'.number_format($biaya_materai,0,',','.').'</b></font></td>
    </tr>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="20%"><font size="11"><b>Total Bill</b></font></td>
        <td align="right" width="20%"><font size="11"><b>'.number_format($totalbill,0,',','.').'</b></font></td>
    </tr>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="20%"><font size="11"><b>Discount</b></font></td>
        <td align="right" width="20%"><font size="11"><b>'.number_format($discount_global,0,',','.').'</b></font></td>
    </tr>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="20%"><font size="11"><b>Total Keseluruhan</b></font></td>
        <td align="right" width="20%"><font size="11"><b>'.number_format($grandtotal_all,0,',','.').'</b></font></td>
    </tr>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="40%"><hr></td>
    </tr>
    </tbody>
    </table>';

    $total_payment = 0;
    //PAYMENT
    foreach ($data['listdata_payment'] as $row) {
        // if ($row['TipePembayaran'] == 'Piutang Asuransi' || $row['TipePembayaran'] == 'Piutang Perusahaan'){
        //   $tipepembayaran = $row['TipePembayaran'].'<br><i>('.$row['Billto'].')</i>';
        // }else{
          $tipepembayaran = $row['TipePembayaran'];
        //}
        $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
        <tbody>
          <tr>
          <td align="left" width="60%"></td>
          <td align="left" width="20%"><b>'.$tipepembayaran.'</B></td>
          <td align="right" width="20%"><b>'.$row['TotalPaid'].'</B></td>
          </tr></tbody>
    </table>
        ';
        $total_payment += $row['TotalPaid'];
      }

      $total_selisih = $grandtotal_all - $total_payment;

      $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
    <tbody>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="40%"><hr></td>
    </tr>
    <tr>
    <td align="left" width="60%"></td>
    <td align="left" width="20%"><font size="11"><b>Total</b></font></td>
    <td align="right" width="20%"><font size="11"><b>'.number_format($total_selisih,0,',','.').'</b></font></td>
    </tr>
    </tbody>
    </table>';

      //Dicetak
$html .= '
<hr>
<table width="100%" cellspacing="0" cellpadding="0" border="0" >
<tbody>
<tr>
    <td width="100%"></td>
</tr>
</tbody>
</table>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
    <tbody>
    <tr>
    <td align="left" width="90%"><font size="8"><i>Cetakan ke : '.$data['cetakanke']['CetakanKe'].'</i></font></td>
     </tr>
    <tr>
    <td align="left" width="5%"></td>
        <td align="left" width="95%">Jakarta, '.$datetimenow.'</td>
    </tr>
    <tr>
    <td align="left" width="5%"></td>
   <td align="left" width="95%">Dicetak Oleh</td>
</tr>
    <tr>
    <td align="left" width="5%"></td>
    <td align="left" width="95%"><img src="'.$data['listdatasign']['AWSSign'].'"  width="70" height="30"></td>
     </tr>
    <tr>
    <td align="left" width="5%"></td>
    <td align="left" width="95%">'.$data['listdatasign']['username'].'</td>
    </tr>
</tbody>
</table>';


//QR CODE
require_once("../App/library/phpqrcode/qrlib.php");
$url = $data['uuid4'];
$url_ext = "https://esigndocument.rsyarsi.co.id/".$url;
QRcode::png($url_ext, $url .".png");
$html .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" >
<tbody>
<tr>
    <td width="80%"></td>
    <td width="20%" align="center"><img src="../public/'.$url.'.png"  width="60" height="60"></td>
</tr>
<tr>
    <td width="80%"></td>
    <td width="20%" align="center"><font size="8">Scan this for validate.</font></td>
</tr>
</tbody>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');

unlink($url.".png");

// //QR CODE CELL
// require_once("../App/library/phpqrcode/qrlib.php");
// $url = $data['uuid4'];
// QRcode::png($url, $url .".png");
// $gety = $pdf->getY();
// $pdf->Image($url.".png", 155, $gety, 25, 25, "png");
// $gety = $pdf->getY();
// $gety = $pdf->SetY($gety);
// $pdf->Cell(0, 23, '', 0, 1); //br
// $pdf->Cell(125, 5, '', 0, 0); //br
// $pdf->setFont('', 'I', 7);
// $pdf->Cell(0, 5, 'Scan this for validate', 0, 1,'C'); //br

