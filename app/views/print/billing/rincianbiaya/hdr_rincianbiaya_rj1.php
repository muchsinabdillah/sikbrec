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
        $this->Image('../public/images/yarsi.png', 14, 4, 40);
        $this->Image('../public/images/footer2.png', 250, 0, 35);

        $this->Cell(0, 18, '', 0, 1); //br
        $this->setFont('', '', 10);
        $this->Cell(1, 1, 'Jl. Letjen Suprapto No.Kav 13,', 0, 1);
        $this->Cell(1, 1, 'RT.10/RW.5, Cemp. Putih Tim., Kec.', 0, 1);
        $this->Cell(1, 1, 'Cemp. Putih, Kota Jakarta Pusat,', 0, 1);
        $this->Cell(1, 1, 'Daerah Khusus Ibukota Jakarta', 0, 1);
        $this->Cell(1, 1, '10510, Telp. (021) 80618618 / 80618619', 0, 1);

        $this->setFont('', 'b', 12);
        if ($GLOBALS['listdataheader']['IdUnit'] == '1') {
            $judul = '* RINCIAN NOTA BIAYA GAWAT DARURAT *';
        } elseif ($GLOBALS['listdataheader']['IdUnit'] == '53') {
            $judul = '* RINCIAN NOTA BIAYA MEDICAL CHECK UP *';
        } else {
            $judul = '* RINCIAN NOTA RAWAT JALAN *';
        }
        $this->Cell(0, 5, $judul, 'B', 1, 'C');
        //$this->Line(15, 26, $this->w - 15, 26);

        $this->setFont('', '', 10);
        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Nama Pasien', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(80, 5, $GLOBALS['listdataheader']['PatientName'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Dokter', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->CellFitScale(60, 5, $GLOBALS['listdataheader']['NamaDokter'], 0, 1);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'No. MR/Reg', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(80, 5, $GLOBALS['listdataheader']['NoMR'] . ' / ' . $GLOBALS['listdataheader']['NoRegistrasi'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Instalasi', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->CellFitScale(60, 5, $GLOBALS['listdataheader']['NamaUnit'], 0, 1);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Tgl Lahir', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(80, 5, $GLOBALS['listdataheader']['DateOfBirth'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Penjamin', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->CellFitScale(60, 5, $GLOBALS['listdataheader']['NamaJaminan'], 0, 1);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Tgl Kunjungan', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(80, 5, $GLOBALS['listdataheader']['TglKunjungan'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'No. SEP', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(60, 5, $GLOBALS['listdataheader']['NoSEP'], 0, 1);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'Tgl Pulang', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(80, 5, $GLOBALS['listdataheader']['TglKunjungan'], 0, 0);

        $this->Cell(2, 5, '', 0, 0);
        $this->Cell(23, 5, 'COB', 0, 0);
        $this->Cell(2, 5, ':', 0, 0);
        $this->Cell(60, 5, $GLOBALS['listdataheader']['NoSEP'], 0, 1);

        //Header-------------------------
        $this->SetFont('', 'B', 10);
        // $this->Cell(1, 5, '', 'TB', 0);
        $this->Cell(90, 5, 'Pelayanan',  'TB', 0);
        $this->Cell(65, 5, '',  'TB', 0);
        $this->Cell(25, 5, 'Harga',  'TB', 0, 'R');
        $this->Cell(15, 5, 'Qty',  'TB', 0, 'R');
        $this->Cell(30, 5, 'Diskon',  'TB', 0, 'R');
        $this->Cell(40, 5, 'Total',  'TB', 0, 'R');
        $this->Cell(15, 5, 'NoBayar',  'TB', 1, 'R');



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
    public function Footer()
    {
        $this->Image('../public/images/footer_1.png', 0, 284, 210, 13);
        // Position at 15 mm from bottom
        $this->SetY(-23);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


$pdf = new PDF('L', 'mm', 'A4', true, 'UTF-8', false);

date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y");
$datetimenow = Date("d/m/Y H:i:s");
$datenow2 = date('d F Y');
$pdf->setPrintHeader(true);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 50, PDF_MARGIN_RIGHT);
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
$pdf->SetAutoPageBreak(true, 20);
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


$h = 6;
//BIAYA pay
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';
$totaltarif_klinik = 0;
$footer_subtotal = false;
$first = true;

foreach ($data['listdetail_pay'] as $row) {
    if ($first) {
        $html .= '
        <tr>
            <td align="left" width="100%"><b>BIAYA PAY</b></td>
        </tr>
    ';
        $first = false;
    }
    $html .= '
        <tr>
        <td align="left" width="1%"></td>
            <td align="left" width="34%">' . $row['No'] .  '</td>
            <td align="left" width="24%">' . '...............................................................' . '</td>
            <td align="right" width="9%">' . number_format($row['BILL'], 0, ',', '.') . '</td>
            <td align="right" width="6%">' . number_format($row['BILL'], 0, ',', '.') . '</td>
            <td align="right" width="11%">' . number_format($row['BILL'], 0, ',', '.') . '</td>
            <td align="right" width="16%">' . number_format($row['BILL'], 0, ',', '.') . '</td>
            <td align="left" width="34%">' . $row['NoBayar'] .  '</td>


        </tr>
   ';
    $totaltarif_klinik += $row['BILL'];
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
if ($footer_subtotal) {
    $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>' . number_format($totaltarif_klinik, 0, ',', '.') . '</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
}
//#END BIAYA pay

//BIAYA KLINIK
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';
$totaltarif_klinik = 0;
$footer_subtotal = false;
foreach ($data['listdetail_klinik'] as $row) {
    $html .= '
        <tr>
        <td align="left" width="1%"></td>
            <td align="left" width="34%">' . $row['NamaProduct_ext'] .  '</td>
            <td align="left" width="24%">' . '...............................................................' . '</td>
            <td align="right" width="9%">' . number_format($row['Tarif'], 0, ',', '.') . '</td>
            <td align="right" width="6%">' . number_format($row['Qty'], 0, ',', '.') . '</td>
            <td align="right" width="11%">' . number_format($row['Diskon_Value'], 0, ',', '.') . '</td>
            <td align="right" width="16%">' . number_format($row['TotalTarif'], 0, ',', '.') . '</td>
        </tr>
   ';
    $totaltarif_klinik += $row['TotalTarif'];
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
if ($footer_subtotal) {
    $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>' . number_format($totaltarif_klinik, 0, ',', '.') . '</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
}
//#END BIAYA KLINIK

//BIAYA OPERASI
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_operasi = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_operasi'] as $row) {
    if ($first) {
        $html .= '
        <tr>
            <td align="left" width="100%"><b>TINDAKAN OPERASI</b></td>
        </tr>
    ';
        $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="34%">' . $row['namatindakanop'] . '</td>
            <td align="left" width="24%">' . '...............................................................' . '</td>
            <td align="right" width="9%">' . number_format($row['TarifSatuan'], 0, ',', '.') . '</td>
            <td align="right" width="6%"></td>
            <td align="right" width="11%">' . number_format($row['Diskon_Value'], 0, ',', '.') . '</td>
            <td align="right" width="16%">' . number_format($row['Tarif'], 0, ',', '.') . '</td>
        </tr>
   ';
    $totaltarif_operasi += $row['Tarif'];
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';

if ($footer_subtotal) {
    $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>' . number_format($totaltarif_operasi, 0, ',', '.') . '</b></td>
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
foreach ($data['listdetail_lab'] as $row) {
    if ($first) {
        $html .= '
        <tr>
            <td align="left" width="100%"><b>LABORATORIUM</b></td>
        </tr>
    ';
        $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="34%">' . $row['NamaTes'] . '</td>
            <td align="left" width="24%">' . '...............................................................' . '</td>
            <td align="right" width="9%">' . number_format($row['TarifKelas'], 0, ',', '.') . '</td>
            <td align="right" width="6%">' . '' . '</td>
            <td align="right" width="11%">' . number_format($row['Diskon_Value'], 0, ',', '.') . '</td>
            <td align="right" width="16%">' . number_format($row['Tarif'], 0, ',', '.') . '</td>
        </tr>
   ';
    $totaltarif_lab += $row['Tarif'];
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
if ($footer_subtotal) {
    $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>' . number_format($totaltarif_lab, 0, ',', '.') . '</b></td>
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
foreach ($data['listdetail_radiologi'] as $row) {
    if ($first) {
        $html .= '
        <tr>
            <td align="left" width="100%"><b>RADIOLOGI</b></td>
        </tr>
    ';
        $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="34%">' . $row['REQUESTED_PROC_DESC'] . '</td>
            <td align="left" width="24%">' . '...............................................................' . '</td>
            <td align="right" width="9%">' . number_format($row['Tarif'], 0, ',', '.') . '</td>
            <td align="right" width="6%"></td>
            <td align="right" width="11%">' . number_format($row['DiscountRp'], 0, ',', '.') . '</td>
            <td align="right" width="16%">' . number_format($row['Service_Charge'], 0, ',', '.') . '</td>
        </tr>
   ';
    $totaltarif_radiologi += $row['Service_Charge'];
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
if ($footer_subtotal) {
    $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>' . number_format($totaltarif_radiologi, 0, ',', '.') . '</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
}
//#END BIAYA RADIOLOGI

//Terusannya nih nak el badrule+

//BIAYA MCU -modelnya done
//BIAYA MCU
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
<tbody>';

$totaltarif_mcu = 0;
$footer_subtotal = false;
$first = true;
foreach ($data['listdetail_mcu'] as $row) {
    if ($first) {
        $html .= '
        <tr>
            <td align="left" width="100%"><b>MCU</b></td>
        </tr>
    ';
        $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="34%">' . $row['NamaPemeriksaan'] . '</td>
            <td align="left" width="24%">' . '...............................................................' . '</td>
            <td align="right" width="9%">' . number_format($totaltarif_mcu, 0, ',', '.') . '</td>
            <td align="right" width="6%"></td>
            <td align="right" width="11%">' . number_format($totaltarif_mcu, 0, ',', '.') . '</td>
            <td align="right" width="16%">' . number_format($totaltarif_mcu, 0, ',', '.') . '</td>
        </tr>
   ';
    //    $totaltarif_mcu ;
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
if ($footer_subtotal) {
    $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"><b>Sub Total</b></td>
                            <td align="right" width="50%"><b>' . number_format($totaltarif_mcu, 0, ',', '.') . '</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
}
//#END BIAYA MCU

if (!empty($data['listdetail_bhp']) || !empty($data['listdetail_obat']) || !empty($data['listdetail_retur'])) {
    $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
    <tbody>
    <tr>
            <td align="left" width="100%"><b>FARMASI</b></td>
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
foreach ($data['listdetail_bhp'] as $row) {
    if ($first) {
        $html .= '
        <tr>
            <td align="left" width="100%"><b>Bahan Habis Pakai</b></td>
        </tr>
    ';
        $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="34%">' . $row['NamaProduk'] . '</td>
            <td align="left" width="24%">' . '...............................................................' . '</td>
            <td align="right" width="9%">' . number_format($row['Harga'], 0, ',', '.') . '</td>
            <td align="right" width="6%">' . number_format($row['Qty'], 0, ',', '.') . '</td>
            <td align="right" width="11%">' . number_format($row['Discount'], 0, ',', '.') . '</td>
            <td align="right" width="16%">' . number_format($row['TotalTarif'], 0, ',', '.') . '</td>
        </tr>
   ';
    $totaltarif_bhp += $row['TotalTarif'];
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
if ($footer_subtotal) {
    $html .= '
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"></td>
                            <td align="right" width="50%"><b>' . number_format($totaltarif_bhp, 0, ',', '.') . '</b></td>
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

foreach ($data['listdetail_obat'] as $row) {
    if ($first) {
        $html .= '
        <tr>
            <td align="left" width="100%"><b>Resep</b></td>
        </tr>
    ';
        $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="34%">' . $row['NamaProduk'] . '</td>
            <td align="left" width="24%">' . '...............................................................' . '</td>
            <td align="right" width="9%">' . number_format($row['Harga'], 0, ',', '.') . '</td>
            <td align="right" width="6%">' . number_format($row['Qty'], 0, ',', '.') . '</td>
            <td align="right" width="11%">' . number_format($row['Discount'], 0, ',', '.') . '</td>
            <td align="right" width="16%">' . number_format($row['TotalTarif'], 0, ',', '.') . '</td>
        </tr>
   ';
    $totaltarif_obat += $row['TotalTarif'];
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
if ($footer_subtotal) {
    $html .= '
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"></td>
                            <td align="right" width="50%"><b>' . number_format($totaltarif_obat, 0, ',', '.') . '</b></td>
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
foreach ($data['listdetail_retur'] as $row) {
    if ($first) {
        $html .= '
        <tr>
            <td align="left" width="100%"><b>Retur</b></td>
        </tr>
    ';
        $first = false;
    }
    $html .= '
        <tr>
            <td align="left" width="34%">' . $row['NamaProduk'] . '</td>
            <td align="left" width="24%">' . '...............................................................' . '</td>
            <td align="right" width="9%">' . number_format($row['Harga'], 0, ',', '.') . '</td>
            <td align="right" width="6%">' . number_format($row['Qty'], 0, ',', '.') . '</td>
            <td align="right" width="11%">' . number_format($row['Discount'], 0, ',', '.') . '</td>
            <td align="right" width="16%">' . number_format($row['TotalTarif'], 0, ',', '.') . '</td>
        </tr>
   ';
    $totaltarif_retur += $row['TotalTarif'];
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';

if ($footer_subtotal) {
    $html .= '
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="50%"></td>
                            <td align="right" width="50%"><b>' . number_format($totaltarif_retur, 0, ',', '.') . '</b></td>
                        </tr>
                </tbody>
                </table>
                
        ';
}
//#END BIAYA FARMASI RETUR

$totaltarif_farmasi = $totaltarif_bhp + $totaltarif_obat + $totaltarif_retur;
//SUB TOTAL FARMASI
if (!empty($data['listdetail_bhp']) || !empty($data['listdetail_obat']) || !empty($data['listdetail_retur'])) {
    $html .= '<hr><table width="100%" cellspacing="0" cellpadding="1" border="0" >
    <tbody>
    <tr>
        <td align="left" width="50%"><b>Sub Total</b></td>
        <td align="right" width="50%"><b>' . number_format($totaltarif_farmasi, 0, ',', '.') . '</b></td>
    </tr>
    </tbody>
        </table><hr>';
}

$subtotal = $totaltarif_klinik + $totaltarif_operasi + $totaltarif_lab + $totaltarif_radiologi + $totaltarif_farmasi;
$discount_global = $data['listdataheader']['ValueDiscount'];
$grandtotal = $subtotal - $discount_global;

//TOTAL
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
    <tbody>
    <tr>
        <td align="left" width="100%"></td>
    </tr>
    </tbody>
        </table>
        <table width="100%" cellspacing="0" cellpadding="2" border="0" >
    <tbody>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="20%"><font size="11"><b>Total</b></font></td>
        <td align="right" width="20%"><font size="11"><b>' . number_format($subtotal, 0, ',', '.') . '</b></font></td>
    </tr>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="20%"><font size="11"><b>Discount</b></font></td>
        <td align="right" width="20%"><font size="11"><b>' . number_format($discount_global, 0, ',', '.') . '</b></font></td>
    </tr>
    <tr>
        <td align="left" width="60%"></td>
        <td align="left" width="20%"><font size="11"><b>Grand Total</b></font></td>
        <td align="right" width="20%"><font size="11"><b>' . number_format($grandtotal, 0, ',', '.') . '</b></font></td>
    </tr>
    </tbody>
    </table>';

$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
    <tbody>
    <tr>
        <td align="left" width="100%"></td>
    </tr>
    </tbody>
    </table>';

//PAYMENT
foreach ($data['listdata_payment'] as $row) {
    if ($row['TipePembayaran'] == 'Piutang Asuransi' || $row['TipePembayaran'] == 'Piutang Perusahaan') {
        $tipepembayaran = $row['TipePembayaran'] . '<br><i>(' . $row['Billto'] . ')</i>';
    } else {
        $tipepembayaran = $row['TipePembayaran'];
    }
    $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
        <tbody>
          <tr>
          <td align="left" width="60%"></td>
          <td align="left" width="20%"><b>' . $tipepembayaran . '</B></td>
          <td align="right" width="20%"><b>' . $row['TotalPaid'] . '</B></td>
          </tr></tbody>
    </table>
        ';
}

//Dicetak
$html .= '
    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
    <tbody>
    <tr>
        <td align="left" width="100%"><font size="8">' . $day . ', ' . $datenow2 . '</font></td>
    </tr>
    <tr>
    <td align="left" width="100%"><font size="8">Dicetak Oleh</font></td>
    </tr>
    <tr>
    <td align="left" width="100%"><img src="' . $data['listdatasign']['AWSSign'] . '"  width="70" height="30"></td>
     </tr>
    <tr>
    <td align="left" width="100%"><font size="8">' . $data['listdatasign']['username'] . '</font></td>
    </tr>
    <tr>
    <td align="center" width="100%"><font size="8">Rincian Biaya Ini Bukan Bukti Pembayaran</font></td>
    </tr>
    <tr>
    <td align="center" width="100%"><font size="8">Transaksi Rawat Jalan dan Penunjang Medis Tidak Dapat Dikembalikan</font></td>
    </tr>
</tbody>
</table>';

//QR CODE
require_once("../App/library/phpqrcode/qrlib.php");
$url = $data['uuid4'];
$url_ext = "https://esigndocument.rsyarsi.co.id/" . $url;
QRcode::png($url_ext, $url . ".png");
$html .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" >
<tbody>
<tr>
    <td width="80%"></td>
    <td width="20%" align="center"><img src="../public/' . $url . '.png"  width="60" height="60"></td>
</tr>
<tr>
    <td width="80%"></td>
    <td width="20%" align="center"><font size="8">Scan this for validate.</font></td>
</tr>
</tbody>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');

unlink($url . ".png");

// //QR CODE
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