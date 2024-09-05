<?php
//$GLOBALS['judul'] = $data['judul'];
$GLOBALS['listdataheader'] = $data['listdataheader'];
class PDF extends TCPDF
{
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
        $this->Cell(8, 5, 'NO',  'TB', 0);
        $this->Cell(90, 5, 'KETERANGAN',  'TB', 0);
        $this->Cell(33, 5, 'GROUP',  'TB', 0, 'R');
        $this->Cell(35, 5, 'BILL',  'TB', 0, 'R');
        $this->Cell(35, 5, 'KEKURANGAN',  'TB', 0, 'R');
        $this->Cell(35, 5, 'ASURANSI',  'TB', 0, 'R');
        $this->Cell(30, 5, 'No Bayar',  'TB', 1, 'R');
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
$totaltarif_asuransi = 0;
$totaltarif = 0;
$totaltarif_kekurangan = 0;
$footer_subtotal = false;

foreach ($data['listdetail_pay'] as $row) {

    $html .= '
        <tr>
        <td align="left" width="1%"></td>
            <td align="center" width="2%">' . $row['No'] .  '</td>
            <td align="left" width="33%">' . $row['Keterangan'] .  '</td>
            <td align="right" width="13%">' . $row['jenis_tarif'] . '</td>
            <td align="right" width="13%">' . number_format($row['BILL'], 0, ',', '.') . '</td>
            <td align="right" width="13%">' . number_format($row['Kekurangan'], 0, ',', '.') . '</td>
            <td align="right" width="14%">' . number_format($row['ASURANSI'], 0, ',', '.') . '</td>
            <td align="left" width="34%">' . $row['NoBayar'] .  '</td>


        </tr>
   ';
    $totaltarif += $row['BILL'];
    $totaltarif_kekurangan += $row['Kekurangan'];
    $totaltarif_asuransi += $row['ASURANSI'];
    $footer_subtotal = true;
}
$html .= '</tbody>
        </table>';
if ($footer_subtotal) {
    $html .= '<hr>
                <table width="100%" cellspacing="0" cellpadding="1" border="0" >
                <tbody>
                        <tr>
                            <td align="left" width="45%"><b>Sub Total</b></td>
                            <td align="right" width="17%"><b>' . number_format($totaltarif, 0, ',', '.') . '</b></td>
                            <td align="right" width="13%"><b>' . number_format($totaltarif_kekurangan, 0, ',', '.') . '</b></td>
                            <td align="right" width="14%"><b>' . number_format($totaltarif_asuransi, 0, ',', '.') . '</b></td>
                        </tr>
                </tbody>
                </table>
                <hr>
        ';
}
//#END BIAYA pay

$subtotal = $totaltarif + $totaltarif_kekurangan + $totaltarif_asuransi;
$discount_global = $data['listdataheader']['ValueDiscount'];
$grandtotal = $totaltarif - $discount_global;

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
        <td align="right" width="20%"><font size="11"><b>' . number_format($totaltarif, 0, ',', '.') . '</b></font></td>
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
