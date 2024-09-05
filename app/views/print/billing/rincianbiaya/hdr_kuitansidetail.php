<?php

class PDF extends TCPDF
{
    // Page header
    function Header()
    {
        $this->Image('../public/images/yarsi.png', 10, 4, 55);
        $this->Image('../public/images/footer2.png', 144, 0, 40);
    }


    // Page footer
    function Footer()
    {
        $this->getY();
        $this->Image('../public/images/footer_1.png', 0, 135, 210, 13);
    }
}

$pdf = new PDF('L', 'mm', 'A5', true, 'UTF-8', false);

date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y");
$datetimenow = Date("d/m/Y H:i:s");
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);
$pdf->SetAutoPageBreak(false);
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


// $pdf->Ln(10);
$pdf->Cell(0, 5, '', 0, 1); //br
$pdf->setFont('', '', 10);
//$pdf->Cell(140,6,'',0,0);//br
// $pdf->Cell(0,6,'No. : KUI0809230009',1,0);//br

// $hari = date('l', strtotime($data['listdata1']['TglCreate']));
//                     if ($hari == 'Sunday'){
//                         $day = 'Minggu';
//                     }elseif($hari == 'Monday'){
//                         $day = 'Senin';
//                     }elseif($hari == 'Tuesday'){
//                         $day = 'Selasa';
//                     }elseif($hari == 'Wednesday'){
//                         $day = 'Rabu';
//                     }elseif($hari == 'Thursday'){
//                         $day = 'Kamis';
//                     }elseif($hari == 'Friday'){
//                         $day  = 'Jumat';
//                     }elseif($hari == 'Saturday'){
//                         $day = 'Sabtu';
//                     }

$h = 6;


$html = '';
$html = '
		<style>
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

$html .= '
      <br><br>
      <table width="100%" cellspacing="0" cellpadding="0.3" border="0" >
      <tbody> 
          <tr>
          <td align="Center" width="100%"><font size="12"><b><u>' . $data['judul'] . '</u></b></font></td>
          </tr>

          <tr>
          <td width="35%"></td>
          <td align="Center" width="30%"><font size="12"><i>' . $data['judul_eng'] . '</i></font></td>
          <td width="11%"></td>
          <td style="border: 1px solid black;border-collapse: collapse" width=:"14%"> No. ' . $data['listdataheader']['NoKwitansi'] . '</td>
          </tr>

          <tr>
          <td></td>
          </tr>


          <tr>
          <td align="left" width="10%"></td>
          <td align="left" width="25%"><font size="11">Telah Terima Dari /</font><br><i>Received From</i></td>
          <td align="left" width="2%">:</td>
          <td align="left" width="63%">' . $data['listdataheader']['billto'] . '</td>
          </tr>

          <tr>
          <td align="left" width="10%"></td>
          <td align="left" width="25%"><font size="11">Nama Pasien /</font><br><i>Patient\'s Name</i></td>
          <td align="left" width="2%">:</td>
          <td align="left" width="63%">' . $data['listdataheader']['PatientName'] . '</td>
          </tr>';



if ($data['kodereg'] != 'PB') {
    $html .= '

            <tr>
            <td align="left" width="10%"></td>
            <td align="left" width="25%"><font size="11">No. Rekam Medis /</font><br><i>Medical Record No.</i></td>
            <td align="left" width="2%">:</td>
            <td align="left" width="63%">' . $data['listdataheader']['NoMR'] . '</td>
            </tr>

            <tr>
            <td align="left" width="10%"></td>
            <td align="left" width="25%"><font size="11">Penjamin Bayar /</font><br><i>Payer</i></td>
            <td align="left" width="2%">:</td>
            <td align="left" width="63%">' . $data['listdataheader']['NamaJaminan'] . '</td>
            </tr>
            ';
}

$html .= '
          <tr>
          <td align="left" width="10%"></td>
          <td align="left" width="25%"><font size="11">Untuk Pembayaran /</font><br><i>In Payment Of</i></td>
          <td align="left" width="2%">:</td>
          <td align="left" width="63%">' . $data['listdataheader']['NamaUnit'] . '</td>
          </tr>

          <tr>
          <td align="left" width="10%"></td>
          <td align="left" width="25%"><font size="11">Jumlah  /</font><br><i>Total</i></td>
          <td align="left" width="2%">:</td>
          <td align="left" width="63%">Rp. ' . $data['listdataheader']['TotalPaid'] . '<br><i><font size="10">' . $data['listdataheader']['Terbilang'] . '</font></i></td>
          </tr>

          <tr>
          <td align="left" width="10%"></td>
          <td align="left" width="25%"><font size="11">Tipe Pembayaran  /</font><br><i>Type Payment </i></td>
          <td align="left" width="2%">:</td>
          <td align="left" width="63%">';
$br = '';
foreach ($data['listdatadetail'] as $row) {
    if ($row['No'] > 1) {
        $br = '<br>';
    }
    $html .= $br . $row['TipePembayaran'] . ' : ' . $row['TotalPaid'];
}
$html .= '</td>
          </tr>
          <tr>
          <td align="left" width="10%"></td>
          <td align="left" width="90%"><font size="8"><i>Tanggal dicetak: ' . $datetimenow . '<br>Cetakan ke : 1 </i></font></td>
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
            <td align="center" width="10%"></td>
              <td align="center" width="25%"></td>
              <td align="center" width="34%"><font size="10"></font></td>
              <td align="center" width="25%"><font size="10"><b>Jakarta, ' . $datenow . '</b></font></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
              <td align="center" width="25%"><img src="../public/' . $url . '.png"  width="40" height="40"></td>
              <td align="center" width="34%"></td>
              <td align="center" width="25%"><img src="awssign"  width="70" height="30"></td>
            </tr>

             <tr>
             <td align="center" width="10%"></td>
              <td align="center" width="25%"><font size="7">Scan this for validate.</font></td>
              <td align="center" width="34%"><font size="9"></font></td>
              <td align="center" width="25%"><font size="9">' . $data['listdataheader']['Kasir'] . '</font></td>
            </tr>

        </tbody>
      </table>';


$pdf->writeHTML($html, true, false, true, false, '');

unlink($url . ".png");

// // membuat halaman baru
// $pdf->AddPage();
// //Margin top
// $pdf->Cell(10,15,'',0,1);
// //Line 1
// $pdf->SetFont('','BU',12);
// $pdf->Cell(190,7,$data['judul'],0,1,'C');
// //Line 2
// $pdf->SetFont('','I',11);
// $pdf->Cell(73,7,'',0,0);
// $pdf->Cell(65,7,$data['judul_eng'],0,0);
// //Line 3
// $pdf->SetFont('','',11);
// $pdf->Cell(0,7,'No. : ',1,1);

// // Memberikan space kebawah agar tidak terlalu rapat
// $pdf->Cell(10,5,'',0,1);
// //1
// $pdf->SetFont('','',11);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(190,1,'Telah Terima Dari /           :   ',0,1);
// $pdf->SetFont('','I',10);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(0,6,'Received From',0,1);
// $pdf->Cell(10,1,'',0,1);//br
// //2
// $pdf->SetFont('','',11);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(190,1,'Nama Pasien /                  :   ',0,1);
// $pdf->SetFont('','I',10);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(0,6,"Patient's Name",0,1);
// $pdf->Cell(10,1,'',0,1);//br
// //3
// $pdf->SetFont('','',11);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(190,1,'No. Rekam Medis /           :   ',0,1);
// $pdf->SetFont('','I',10);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(0,6,'Medical Record No.',0,1);
// $pdf->Cell(10,1,'',0,1);//br
// //4
// $pdf->SetFont('','',11);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(190,1,'Penjamin Bayar /              :   ',0,1);
// $pdf->SetFont('','I',10);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(0,6,'Payer',0,1);
// $pdf->Cell(10,1,'',0,1);//br
// //5
// $pdf->SetFont('','',11);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(190,1,'Untuk Pembayaran /         :   ',0,1);
// $pdf->SetFont('','I',10);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(0,6,'In Payment Of',0,1);
// $pdf->Cell(10,1,'',0,1);//br
// //5
// $pdf->SetFont('','',11);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(190,1,'Jumlah /                            :   Rp. ',0,1);
// $pdf->SetFont('','I',10);
// $pdf->Cell(15,2,'',0,1);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(50,1,'Total',0,0);
// $pdf->MultiCell(0,3,' rupiah',0,1);
// $pdf->Cell(10,3,'',0,1);//br

// $pdf->SetFont('','',11);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(48,1,'Tipe Pembayaran /           :',0,1);
// $pdf->SetFont('','I',10);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(48,6,'Type Payment',0,0);
// $pdf->Cell(15,6,'',0,0);
// $pdf->Cell(48,6,'',0,0);
// $pdf->SetFont('','',11);
// $pdf->Cell(10,3,' : ',0,1);
// $pdf->Cell(10,1,'',0,1);//br


// $pdf->Cell(10,2,'',0,1);//br
// $pdf->Cell(15,0,'',0,0);
// $pdf->SetFont('','I',8);
// $datenow = Date("d/m/Y H.i.s");
// $pdf->Cell(15,0,'Tanggal dicetak : '.$datenow,0,0);
// $pdf->Cell(120,0,'',0,0);
// $pdf->SetFont('','B',10);
// $pdf->Cell(10,0,'Jakarta, ',0,1);
// $pdf->Cell(10,20,'',0,1);
// $pdf->SetFont('','',10);
// $pdf->Cell(145,0,'',0,0);
// $pdf->Cell(0,0,'',0,0,'C');