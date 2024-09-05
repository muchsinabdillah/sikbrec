<?php
$GLOBALS['listdataheader'] = $data['listdataheader'];

class PDF extends TCPDF
{
    var $htmlHeader;

    public function setHtmlHeader($htmlHeader)
    {
        $this->htmlHeader = $htmlHeader;
    }

    public function Header()
    {
        $this->Image('../public/images/yarsi.png', 10, 4, 40);
        $this->Image('../public/images/footer2.png', 167, 0, 35);
        $this->setFont('', '', 10);
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

        $html = '
        <br><br><br><br><br>
        <table width="100%" cellspacing="0" cellpadding="1" border="0" >
        <tbody> 
          <tr>
            <td width="40%"></td>
            <td  align="right" width="60%"><font size="9">Jl. Letjen Suprapto, Cempaka Putih, Jakarta 10510</font></td>
            </tr>
            <tr>
            <td align="Center" width="100%"><font size="12"><b>' . 'RESUME MEDIS<br>
            DISCHARGE SUMMARY' . '</b></font></td>
            </tr>
            <tr>
            <td align="Center" width="100%"></td>
            </tr>
  
            <tr>
            <td align="left" width="2%"></td>
            <td align="left" width="18%"><font size="10">Nama Pasien</font></td>
            <td align="left" width="2%">:</td>
            <td align="left" width="45%">' . $GLOBALS['listdataheader']['Nama_Pasien'] . '</td>
            
            <td align="left" width="20%"><font size="10">Tanggal Masuk</font></td>
            <td align="left" width="2%">:</td>
            <td align="left" width="73%">' . $GLOBALS['listdataheader']['Tgl_Berobat'] . '</td>
            </tr>
            <tr> 
            <td align="left" width="2%"></td>
             <td align="left" width="65%"><font size="8"><i>patient`s Name</i> </font></td>
             <td align="left" width="25%"><font size="8"><i>Date of Admission</i> </font></td>
             </tr>
  
             <tr>
             <td align="left" width="2%"></td>
             <td align="left" width="18%"><font size="10">No MR</font></td>
             <td align="left" width="2%">:</td>
             <td align="left" width="45%">' . $GLOBALS['listdataheader']['No_MR'] . '</td>
             
             <td align="left" width="20%"><font size="10">Tanggal Keluar</font></td>
             <td align="left" width="2%">:</td>
             <td align="left" width="73%">' . $GLOBALS['listdataheader']['Tgl_Pulang'] . '</td>
             </tr>
             <tr>
             <td align="left" width="2%"></td>
             <td align="left" width="65%"><font size="8"><i>Medical Record Number</i> </font></td>
              <td align="left" width="25%"><font size="8"><i>Date of Discharge</i> </font></td>
              </tr>

              <tr>
              <td align="left" width="2%"></td>
              <td align="left" width="18%"><font size="10">Tanggal Lahir</font></td>
              <td align="left" width="2%">:</td>
              <td align="left" width="45%">' . $GLOBALS['listdataheader']['Tgl_lahir'] . '</td>
              </tr>
              <tr>  
              <td align="left" width="2%"></td>
               <td align="left" width="65%"><font size="8"><i>Date Of Birth</i> </font></td>
               </tr>
             </tbody>
             </table>
             <hr>
          ';
          
        $this->writeHTML($html, true, false, true, false, '');
    }
   

    // Page footer
    function Footer()
    {
        $this->getY();
        $this->Image('../public/images/footer2.png',175, 265, 30,'R');
        $this->Image('../public/images/footer_1.png', 0, 284, 210, 13);
    }
}


$pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);

date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y");
$datetimenow = Date("d/m/Y H:i:s");
$pdf->setPrintHeader(true);
$pdf->SetAutoPageBreak(TRUE,35);
 $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+45, PDF_MARGIN_RIGHT);
$html = '';
$pdf->setHeaderData($html .= '
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
            </style>
');
$pdf->setPrintFooter(true);
$pdf->AddPage();

$html .= '
<table width="100%" cellspacing="0" cellpadding="1" border="0" >
        <tbody> 
<tr>
              <td align="left" width="33%"><font size="10"><b>Diagnosa Masuk</b></font></td>
              <td align="left" width="2%">:</td>
              <td align="left" width="65%">' . $GLOBALS['listdataheader']['Diagnosa_Awal'] . '</td>
              </tr>
              <tr>                   
               <td align="left" width="33%"><font size="8"><i>Admitting Diagnosis</i> </font></td>
               </tr>

               <tr>
              <td align="left" width="33%"><font size="10"><b>Komorbiditas</b></font></td>
              <td align="left" width="2%">:</td>
              <td align="left" width="65%">' . $GLOBALS['listdataheader']['Komordibitas'] . '</td>
              </tr>
              <tr>                   
               <td align="left" width="33%"><font size="8"><i>Komorbiditas</i> </font></td>
               </tr>

               <tr>
              <td align="left" width="33%"><font size="10"><b>Indikasi Masuk Rawat Inap</b></font></td>
              <td align="left" width="2%">:</td>
              <td align="left" width="65%">' . $GLOBALS['listdataheader']['Alasan_Dirawat_Inap'] . '</td>
              </tr>
              <tr>                   
               <td align="left" width="33%"><font size="8"><i>Reason for Admission</i> </font></td>
               </tr>

               <tr>
               <td align="left" width="33%"><font size="10"><b>Temuan Fisik Penting </b></font></td>
               <td align="left" width="2%">:</td>
               <td align="left" width="65%">' . $GLOBALS['listdataheader']['Anjuran'] . '</td>
               </tr>
               <tr>                   
                <td align="left" width="33%"><font size="10"><b>dan temuan Lainnya</b> </font></td>
                </tr>

                <tr>
              <td align="left" width="33%"><font size="10"><b>Tanggal Gejala Diketahui</b></font></td>
              <td align="left" width="2%">:</td>
              <td align="left" width="65%">' . $GLOBALS['listdataheader']['Tgl_Gejala'] . '</td>
              </tr>
              <tr>                   
               <td align="left" width="33%"><font size="8"><i>The date of first symptom</i> </font></td>
               </tr>

               <tr>
               <td align="left" width="33%"><font size="10"><b>Anamnesa/Riwayat penyakit</b></font></td>
               <td align="left" width="2%">:</td>
               <td align="left" width="7%"><font size="10">RPS</font></td>
               <td align="left" width="2%">:</td>
               <td align="left" width="56%">' . $GLOBALS['listdataheader']['Riwayat_Penyakit'] . '</td>
               </tr>
               <tr>                   
                <td align="left" width="33%"><font size="8"><i>Anamnesis/medical history</i> </font></td>
                </tr>

                <tr>
               <td align="left" width="25%"><font size="10"><b>Tanda-tanda Vital</b></font></td>
               <td align="left" width="2%">:</td>
               <td align="left" width="7%"><font size="10">GCS</font></td>
               <td align="left" width="2%">:</td>
               <td align="left" width="5%">' . $GLOBALS['listdataheader']['TTV_Gcs'] . '</td>
               <td align="left" width="7%"><font size="10">B.P</font></td>
               <td align="left" width="2%">:</td>
               <td align="left" width="5%">' . $GLOBALS['listdataheader']['TTV_Bp'] . '</td>
               <td align="left" width="7%"><font size="10">H.R</font></td>
               <td align="left" width="2%">:</td>
               <td align="left" width="5%">' . $GLOBALS['listdataheader']['TTV_Hr'] . '</td>
               <td align="left" width="7%"><font size="10">R.R</font></td>
               <td align="left" width="2%">:</td>
               <td align="left" width="5%">' . $GLOBALS['listdataheader']['TTV_Rr'] . '</td>
               <td align="left" width="8%"><font size="10">Temp</font></td>
               <td align="left" width="2%">:</td>
               <td align="left" width="5%">' . $GLOBALS['listdataheader']['TTV_T'] . '</td>
               </tr>
               <tr>                   
                <td align="left" width="16%"><font size="8"><i>Vital Sign</i> </font></td>
                </tr>
                <tr>                   
                <td align="right" width="34%"><font size="10">Others</font></td>
                <td align="left" width="2%">:</td>
                <td align="left" width="64%">' . $GLOBALS['listdataheader']['TTV_Others'] . '</td>
                </tr>

                <tr>
                <td align="left" width="42%"><font size="10"><b>Pemeriksaan penunjang diagnosa</b></font></td>
                <td align="left" width="2%">:</td>
                <td align="left" width="56%">' . $GLOBALS['listdataheader']['H_Penunjang'] . '</td>
                </tr>
                <tr>                   
                 <td align="left" width="42%"><font size="8"><i>Diagnostic examinations</i> </font></td>
                 </tr>

                 <tr>
                 <td align="left" width="42%"><font size="10"><b>Tindakan operatif dan tanggal dilakukan</b></font></td>
                 <td align="left" width="2%">:</td>
                 <td align="left" width="56%">' . $GLOBALS['listdataheader']['treatment'] . '</td>
                 </tr>
                 <tr>                   
                  <td align="left" width="42%"><font size="8"><i>Procedure and date of procedure</i> </font></td>
                  </tr>

                  <tr>
                 <td align="left" width="42%"><font size="10"><b>Diagnosa akhir</b></font></td>
                 <td align="left" width="2%">:</td>
                 <td align="left" width="56%">' . $GLOBALS['listdataheader']['Diagnosa_Akhir'] . '</td>
                 </tr>
                 <tr>                   
                  <td align="left" width="42%"><font size="8"><i>Discharge Diagnosis</i> </font></td>
                  </tr>

                  <tr>
                  <td align="left" width="42%"><font size="10"><b>Obat-obatan yang diberikan</b></font></td>
                  <td align="left" width="2%">:</td>
                  <td align="left" width="56%">' . $GLOBALS['listdataheader']['Obat_obatan'] . '</td>
                  </tr>
                  <tr>                   
                   <td align="left" width="42%"><font size="8"><i>Discharge Medicaction</i> </font></td>
                   </tr>

                   <tr>
                   <td align="left" width="42%"><font size="10"><b>Obat-obatan Pulang</b></font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="56%">' . $GLOBALS['listdataheader']['Obat_obatanPulang'] . '</td>
                   </tr>

                   <tr>
                   <td align="left" width="42%"><font size="10"><b>Kondisi pasien saat pulang/ditransfer</b></font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="56%">' . $GLOBALS['listdataheader']['STUATUSPULANG'] . '</td>
                   </tr>
                   <tr>                   
                   <td align="left" width="42%"><font size="8"><i>Discharge Condition</i> </font></td>
                   </tr>

                   <tr>
                   <td align="left" width="22%"><font size="10"><b>Tindak Lanjut</b></font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="76%">' . $GLOBALS['listdataheader']['Tindak_Lanjut'] . '</td>
                   </tr>
                   <tr>                   
                   <td align="left" width="22%"><font size="8"><i>Follow up</i> </font></td>
                   </tr>

                   <tr>
                   <td align="left" width="22%"><font size="10"><b>Kontrol Kembali</b></font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="74%">' . $GLOBALS['listdataheader']['TglKontrol'] .'-'.$GLOBALS['listdataheader']['Jam']. '<br>'.$GLOBALS['listdataheader']['Poliklinik'].'</td>
                   </tr>
                   <tr>                   
                   <td align="left" width="22%"><font size="8"><i>Back to control</i> </font></td>
                   </tr>
    
    

                    </tbody>
        </table><hr>
';


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
$pdf->setFont('', '', 10);
//$pdf->Cell(140,6,'ddd',0,0);//br
// $pdf->Cell(0,6,'No. : KUI0809230009',1,0);//br

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

$datenow2 = date('d F Y');

$h = 6;




$html .= '
            <table width="100%" cellspacing="0" cellpadding="1" border="0" >
            <tbody> 
            ';
$tarifobat_fix = 0;
// foreach ($data['listdetail_obat'] as $row) {
//     $html .= '
//             <tr>
//             <td align="left" width="54%"><font size="9">' . $row['NamaProduk'] . '</font></td>
//             <td align="right" width="6%"><font size="9">' . $row['Qty'] . '</font></td>
//             <td align="right" width="20%"><font size="9">' . number_format($row['Harga'], 0, ',', '.') . '</font></td>
//             <td align="right" width="20%"><font size="9">' . number_format($row['TotalTarif'], 0, ',', '.') . '</font></td>
//             </tr>
//             ';
//     if ($row['status'] >= '2') {
//         $tarifobat_fix += $row['TotalTarif'];
//     }
// }
$html .= '
            </tbody>
            </table>';



  //QR CODE
  require_once("../App/library/phpqrcode/qrlib.php");
  $url = $data['uuid4'];
  $url_ext = "https://esigndocument.rsyarsi.co.id/".$url;
  QRcode::png($url_ext, $url .".png");

$html .= '<hr><table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tbody> 
        <tr>
        <td></td>
        </tr>
            <tr>
            <td align="left" width="100%"><font size="8">' . $day . ', ' . $datenow2 . '</font></td>
            </tr>

            <tr>
            <td align="left" width="100%"><font size="8">Dokter yang merawat,</font></td>
            </tr>
            <tr>
            <td align="left" width="100%"><font size="8"> attending physician,</font></td>
            </tr>
           

            <tr>
            <td align="left" width="50%"><img src="../public/'.$url.'.png"  width="60" height="60"></td>
            </tr>

             <tr>
              <td align="left" width="100%"><font size="8"><u>' . $data['listdatasign']['username'] . '</u></font></td>
            </tr>


        </tbody>
      </table>';


$pdf->writeHTML($html, true, false, true, false, '');

    //   //QR CODE
    //   require_once("../App/library/phpqrcode/qrlib.php");
    //   $url = $data['uuid4'];
    //   $url_ext = "https://esigndocument.rsyarsi.co.id/".$url;
    //   QRcode::png($url_ext, $url .".png");
  
    //               //Garis---
    //               $gety = $pdf->getY();
    //              //$pdf->Line(15, $gety, 210-15, $gety);
    //              //QR Code
    //              $pdf->Image($url.".png", 25, $gety+10, 25, 25, "png");
  //Hapus file qr code nya
  unlink($url.".png");

$certificate = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.crt';
    $key = 'file://' . $_SERVER["DOCUMENT_ROOT"] . 'SIKBREC/public/server.key';
    
    $info = array(
        'Name' => 'TCPDF',
        'Location' => 'Office',
        'Reason' => 'Testing TCPDF',
        'ContactInfo' => 'http://www.tcpdf.org',
    );
    
    $pdf->setSignature($certificate, $key, 'tcpdfdemo', '', 2, $info);
