<?php
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
        $this->writeHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $this->htmlHeader,
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = 'top',
            $autopadding = true
        );
    }
    // Page header
    // function Header()
    //     {
    //         $this->Image('../public/images/yarsi.png',10,4,40);
    //         $this->Image('../public/images/footer2.png',100,0,35);
    //         $this->Cell(0,10,'',0,1);//br
    //         $this->setFont('','',10);

    //         $html='';
    //         $html = '
    //             <style>
    //               .h_tengah {text-align: center;}
    //               .h_kiri {text-align: left;}
    //               .h_kanan {text-align: right;}
    //               .txt_judul {font-size: 10; font-weight: bold; padding-bottom: 12px; text-align: center;}
    //               .header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
    //               .txt_content {font-size: 7pt; text-align: center;}
    //               .right{float:right;}
    //               .left{float:left;}
    //               .tabler {
    //                   border-collapse: collapse;
    //                   width: 100%;
    //                 }

    //                 .tabler td, th {
    //                   border: 1px solid #fff;
    //                   text-align: left;
    //                   padding: 8px;
    //                 }

    //                 .tabler tr:nth-child(even) {
    //                   background-color: #dddddd;
    //                 }
    //                 .tablex {
    //                   border-collapse: collapse;
    //                   width: 100%;
    //                 }
    //                 .tablex td, th {
    //                   border: 1px solid #000;
    //                   text-align: left;
    //                   padding: 8px;

    //                 }
    //                 .tablex tr:nth-child(even) {
    //                   background-color: #dddddd;
    //                 }
    //             </style>';

    //               $html .= '
    //               <table width="100%" cellspacing="0" cellpadding="1" border="0" >
    //               <tbody> 
    //                 <tr>
    //                   <td width="40%"></td>
    //                   <td width="60%"><font size="9">Jl. Letjen Suprapto, Cempaka Putih, Jakarta 10510</font></td>
    //                   </tr>
    //                 <hr>
    //                   <tr>
    //                   <td align="Center" width="100%"><font size="12"><b>'.$GLOBALS['judul'].'</b></font></td>
    //                   </tr>
    //                   <hr>

    //                   <tr>
    //                   <td align="left" width="25%"><font size="10">Nama Pasien</font></td>
    //                   <td align="left" width="2%">:</td>
    //                   <td align="left" width="73%">'.$GLOBALS['listdataheader']['PatientName'].'</td>
    //                   </tr>

    //                     <tr>
    //                   <td align="left" width="25%"><font size="10">No. Regis</font></td>
    //                   <td align="left" width="2%">:</td>
    //                   <td align="left" width="73%">'.$GLOBALS['listdataheader']['NoRegistrasi'].'</td>
    //                   </tr>

    //                   <tr>
    //                   <td align="left" width="25%"><font size="10">No. Resep</font></td>
    //                   <td align="left" width="2%">:</td>
    //                   <td align="left" width="73%">'.$GLOBALS['listdataheader']['NoReff'].'</td>
    //                   </tr>

    //                   <tr>
    //                   <td align="left" width="25%"><font size="10">Tgl Resep</font></td>
    //                   <td align="left" width="2%">:</td>
    //                   <td align="left" width="73%">'.$GLOBALS['listdataheader']['TglKunjungan'].'</td>
    //                   </tr>
    //                   <hr>

    //                   <tr>
    //                   <td align="left" width="54%"><font size="9"><b>Nama Obat</b></font></td>
    //                   <td align="right" width="6%"><font size="9"><b>Qty</b></font></td>
    //                   <td align="right" width="20%"><font size="9"><b>Harga Satuan</b></font></td>
    //                   <td align="right" width="20%"><font size="9"><b>Total Harga</b></font></td>
    //                   </tr>

    //                           </tbody>
    //               </table>
    //                   ';

    //       $this->writeHTML($html, true, false, true, false, '');


    //     }


    // Page footer
    function Footer()
    {
        $this->getY();
        // $this->Image('../public/images/footer_1.png', 0, 198, 150, 13);
    }
}


$pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);

date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y");
$datetimenow = Date("d/m/Y H:i:s");
$pdf->setPrintHeader(true);
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
            <br><br><br>
 <table width="100%" cellspacing="0" cellpadding="1" border="0" >
               <tbody> 
                 <tr>
                   <td width="40%"></td>
                   <td  align="right" width="60%"><font size="9">Jl. Letjen Suprapto, Cempaka Putih, Jakarta 10510</font></td>
                   </tr>
                   <tr>
                   <td align="Center" width="100%"><font size="12"><b>' . 'RESUME MEDIS
                   DISCHARGE SUMMARY' . '</b></font></td>
                   </tr>
         
                   <tr>
                   <td align="left" width="2%"></td>
                   <td align="left" width="18%"><font size="10">Nama Pasien</font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="35%">' . $data['listdataheader']['PatientName'] . '</td>
                   
                   <td align="left" width="20%"><font size="10">Tanggal Masuk</font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="73%">' . $data['listdataheader']['PatientName'] . '</td>
                   </tr>
                   <tr> 
                   <td align="left" width="2%"></td>
                    <td align="left" width="55%"><font size="8"><i>patient`s Name</i> </font></td>
                    <td align="left" width="25%"><font size="8"><i>Date of Admission</i> </font></td>
                    </tr>
         
                    <tr>
                    <td align="left" width="2%"></td>
                    <td align="left" width="18%"><font size="10">No MR</font></td>
                    <td align="left" width="2%">:</td>
                    <td align="left" width="35%">' . $data['listdataheader']['PatientName'] . '</td>
                    
                    <td align="left" width="20%"><font size="10">Tanggal Keluar</font></td>
                    <td align="left" width="2%">:</td>
                    <td align="left" width="73%">' . $data['listdataheader']['PatientName'] . '</td>
                    </tr>
                    <tr>
                    <td align="left" width="2%"></td>
                    <td align="left" width="55%"><font size="8"><i>Medical Record Number</i> </font></td>
                     <td align="left" width="25%"><font size="8"><i>Date of Discharge</i> </font></td>
                     </tr>

                     <tr>
                     <td align="left" width="2%"></td>
                     <td align="left" width="18%"><font size="10">Tanggal Lahir</font></td>
                     <td align="left" width="2%">:</td>
                     <td align="left" width="35%">' . $data['listdataheader']['PatientName'] . '</td>
                     </tr>
                     <tr>  
                     <td align="left" width="2%"></td>
                      <td align="left" width="55%"><font size="8"><i>Date Of Birth</i> </font></td>
                      </tr>
<hr>
                    <tr>
                     <td align="center" width="25%"><font size="10"><b>Diagnosa Masuk</b></font></td>
                     <td align="left" width="2%">:</td>
                     <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                     </tr>
                     <tr>                   
                      <td align="center" width="23%"><font size="8"><i>Admitting Diagnosis</i> </font></td>
                      </tr>

                      <tr>
                     <td align="center" width="22%"><font size="10"><b>Komorbiditas</b></font></td>
                     <td align="left" width="2%">:</td>
                     <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                     </tr>
                     <tr>                   
                      <td align="center" width="18%"><font size="8"><i>Komorbiditas</i> </font></td>
                      </tr>

                      <tr>
                     <td align="center" width="33%"><font size="10"><b>Indikasi Masuk Rawat Inap</b></font></td>
                     <td align="left" width="2%">:</td>
                     <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                     </tr>
                     <tr>                   
                      <td align="center" width="24%"><font size="8"><i>Reason for Admission</i> </font></td>
                      </tr>

                      <tr>
                      <td align="center" width="29%"><font size="10"><b>Temuan Fisik Penting </b></font></td>
                      <td align="left" width="2%">:</td>
                      <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                      </tr>
                      <tr>                   
                       <td align="center" width="28%"><font size="10"><b>dan temuan Lainnya</b> </font></td>
                       </tr>

                       <tr>
                     <td align="center" width="32%"><font size="10"><b>Tanggal Gejala Diketahui</b></font></td>
                     <td align="left" width="2%">:</td>
                     <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                     </tr>
                     <tr>                   
                      <td align="center" width="27%"><font size="8"><i>The date of first symptom</i> </font></td>
                      </tr>

                      <tr>
                      <td align="center" width="35%"><font size="10"><b>Anamnesa/Riwayat penyakit</b></font></td>
                      <td align="left" width="2%">:</td>
                      <td align="left" width="7%"><font size="10">RPS</font></td>
                      <td align="left" width="2%">:</td>
                      <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                      </tr>
                      <tr>                   
                       <td align="center" width="28%"><font size="8"><i>Anamnesis/medical history</i> </font></td>
                       </tr>

                       <tr>
                      <td align="center" width="25%"><font size="10"><b>Tanda-tanda Vital</b></font></td>
                      <td align="left" width="2%">:</td>
                      <td align="left" width="7%"><font size="10">GCS</font></td>
                      <td align="left" width="2%">:</td>
                      <td align="left" width="5%">' . $data['listdataheader']['PatientName'] . '</td>
                      <td align="left" width="7%"><font size="10">B.P</font></td>
                      <td align="left" width="2%">:</td>
                      <td align="left" width="5%">' . $data['listdataheader']['PatientName'] . '</td>
                      <td align="left" width="7%"><font size="10">H.R</font></td>
                      <td align="left" width="2%">:</td>
                      <td align="left" width="5%">' . $data['listdataheader']['PatientName'] . '</td>
                      <td align="left" width="7%"><font size="10">R.R</font></td>
                      <td align="left" width="2%">:</td>
                      <td align="left" width="5%">' . $data['listdataheader']['PatientName'] . '</td>
                      <td align="left" width="8%"><font size="10">Temp</font></td>
                      <td align="left" width="2%">:</td>
                      <td align="left" width="5%">' . $data['listdataheader']['PatientName'] . '</td>
                      </tr>
                      <tr>                   
                       <td align="center" width="16%"><font size="8"><i>Vital Sign</i> </font></td>
                       </tr>
                       <tr>                   
                       <td align="right" width="34%"><font size="10">Others</font></td>
                       <td align="left" width="2%">:</td>
                       <td align="left" width="5%">' . $data['listdataheader']['PatientName'] . '</td>
                       </tr>

                       <tr>
                       <td align="center" width="38%"><font size="10"><b>Pemeriksaan penunjang diagno</b></font></td>
                       <td align="left" width="2%">:</td>
                       <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                       </tr>
                       <tr>                   
                        <td align="center" width="26%"><font size="8"><i>Diagnostic examinations</i> </font></td>
                        </tr>

                        <tr>
                        <td align="center" width="45%"><font size="10"><b>Tindakan operatif dan tanggal dilakukan</b></font></td>
                        <td align="left" width="2%">:</td>
                        <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                        </tr>
                        <tr>                   
                         <td align="center" width="32%"><font size="8"><i>Procedure and date of procedure</i> </font></td>
                         </tr>

                         <tr>
                        <td align="center" width="23%"><font size="10"><b>Diagnosa akhir</b></font></td>
                        <td align="left" width="2%">:</td>
                        <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                        </tr>
                        <tr>                   
                         <td align="center" width="23%"><font size="8"><i>Discharge Diagnosis</i> </font></td>
                         </tr>

                         <tr>
                         <td align="center" width="34%"><font size="10"><b>Obat-obatan yang diberikan</b></font></td>
                         <td align="left" width="2%">:</td>
                         <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                         </tr>
                         <tr>                   
                          <td align="center" width="24%"><font size="8"><i>Discharge Medicaction</i> </font></td>
                          </tr>

                          <tr>
                          <td align="center" width="27%"><font size="10"><b>Obat-obatan Pulang</b></font></td>
                          <td align="left" width="2%">:</td>
                          <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                          </tr>

                          <tr>
                          <td align="center" width="43%"><font size="10"><b>Kondisi pasien saat pulang/ditransfer</b></font></td>
                          <td align="left" width="2%">:</td>
                          <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                          </tr>
                          <tr>                   
                          <td align="center" width="23%"><font size="8"><i>Discharge Condition</i> </font></td>
                          </tr>

                          <tr>
                          <td align="center" width="22%"><font size="10"><b>Tindak Lanjut</b></font></td>
                          <td align="left" width="2%">:</td>
                          <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                          </tr>
                          <tr>                   
                          <td align="center" width="16%"><font size="8"><i>Follow up</i> </font></td>
                          </tr>

                          <tr>
                          <td align="center" width="24%"><font size="10"><b>Kontrol Kembali</b></font></td>
                          <td align="left" width="2%">:</td>
                          <td align="left" width="75%">' . $data['listdataheader']['PatientName'] . '</td>
                          </tr>
                          <tr>                   
                          <td align="center" width="19%"><font size="8"><i>Back to control</i> </font></td>
                          </tr>
           
           
 
                           </tbody>
               </table>');
$pdf->setPrintFooter(true);
$pdf->SetAutoPageBreak(true);
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

$grandtotal = $tarifobat_fix - $data['listdataheader']['ValueDiscount'];




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
              <td align="left" width="100%"><img src="' . $data['listdatasign']['AWSSign'] . '"  width="70" height="30"></td>
            </tr>

             <tr>
              <td align="left" width="100%"><font size="8"><u>' . $data['listdatasign']['username'] . '</u></font></td>
            </tr>


        </tbody>
      </table>';


$pdf->writeHTML($html, true, false, true, false, '');
