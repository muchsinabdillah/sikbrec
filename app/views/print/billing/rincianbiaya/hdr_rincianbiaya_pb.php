<?php
class PDF extends TCPDF
{
  var $htmlHeader;

    public function setHtmlHeader($htmlHeader) {
        $this->htmlHeader = $htmlHeader;
    }

    public function Header() {
              $this->Image('../public/images/yarsi.png',10,4,40);
        $this->Image('../public/images/LogoGabungCert.png',90,0,45);
        $this->writeHTMLCell(
            $w = 0, $h = 0, $x = '', $y = '',
            $this->htmlHeader, $border = 0, $ln = 1, $fill = 0,
            $reseth = true, $align = 'top', $autopadding = true);
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
        $this->Image('../public/images/footer_1.png',0,198,150, 13);

    }

}


 $pdf = new PDF('P', 'mm', 'A5', true, 'UTF-8', false);

 date_default_timezone_set('Asia/Jakarta');
 $datenow = Date("d/m/Y");
 $datetimenow = Date("d/m/Y H:i:s");
 $pdf->setPrintHeader(true);
 $html = '';
 $pdf->setHeaderData($html.= '
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
                   <td width="60%"><font size="9">Jl. Letjen Suprapto, Cempaka Putih, Jakarta 10510</font></td>
                   </tr>
                 <hr>
                   <tr>
                   <td align="Center" width="100%"><font size="12"><b>'.$data['judul'].'</b></font></td>
                   </tr>
                   <hr>
         
                   <tr>
                   <td align="left" width="25%"><font size="10">Nama Pasien</font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="73%">'.$data['listdataheader']['PatientName'].'</td>
                   </tr>
         
                     <tr>
                   <td align="left" width="25%"><font size="10">No. Regis</font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="73%">'.$data['listdataheader']['NoRegistrasi'].'</td>
                   </tr>
         
                   <tr>
                   <td align="left" width="25%"><font size="10">No. Resep</font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="73%">'.$data['listdataheader']['NoReff'].'</td>
                   </tr>
                   
                   <tr>
                   <td align="left" width="25%"><font size="10">Tgl Resep</font></td>
                   <td align="left" width="2%">:</td>
                   <td align="left" width="73%">'.$data['listdataheader']['TglKunjungan'].'</td>
                   </tr>
                   <hr>
 
                   <tr>
                   <td align="left" width="54%"><font size="9"><b>Nama Obat</b></font></td>
                   <td align="right" width="6%"><font size="9"><b>Qty</b></font></td>
                   <td align="right" width="20%"><font size="9"><b>Harga Satuan</b></font></td>
                   <td align="right" width="20%"><font size="9"><b>Total Harga</b></font></td>
                   </tr>
                   <hr>
 
                           </tbody>
               </table>');
 $pdf->setPrintFooter(true);
 $pdf->SetAutoPageBreak(true);
 $pdf->AddPage();

 
 $certificate = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.crt'; 
    $key = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.key';

    $info = array(
                     'Name' => 'TCPDF',
                     'Location' => 'Office',
                     'Reason' => 'Testing TCPDF',
                     'ContactInfo' => 'http://www.tcpdf.org',
                     );

      $pdf->setSignature($certificate, $key, 'tcpdfdemo', '', 2, $info);


// $pdf->Ln(10);
$pdf->setFont('','',10);
//$pdf->Cell(140,6,'ddd',0,0);//br
// $pdf->Cell(0,6,'No. : KUI0809230009',1,0);//br

$hari = date('l');
                    if ($hari == 'Sunday'){
                        $day = 'Minggu';
                    }elseif($hari == 'Monday'){
                        $day = 'Senin';
                    }elseif($hari == 'Tuesday'){
                        $day = 'Selasa';
                    }elseif($hari == 'Wednesday'){
                        $day = 'Rabu';
                    }elseif($hari == 'Thursday'){
                        $day = 'Kamis';
                    }elseif($hari == 'Friday'){
                        $day  = 'Jumat';
                    }elseif($hari == 'Saturday'){
                        $day = 'Sabtu';
                    }
                    
$datenow2 = date('d F Y');

$h = 6;


     

            $html .= '
            <table width="100%" cellspacing="0" cellpadding="1" border="0" >
            <tbody> 
            ';
            $tarifobat_fix = 0;
            foreach ($data['listdetail_obat'] as $row) {
            $html .='
            <tr>
            <td align="left" width="54%"><font size="9">'.$row['NamaProduk'].'</font></td>
            <td align="right" width="6%"><font size="9">'.$row['Qty'].'</font></td>
            <td align="right" width="20%"><font size="9">'.number_format($row['Harga'],0,',','.').'</font></td>
            <td align="right" width="20%"><font size="9">'.number_format($row['TotalTarif'],0,',','.').'</font></td>
            </tr>
            ';
                if ($row['status'] >= '2'){
                    $tarifobat_fix += $row['TotalTarif'];
                  } 
            }
            $html .= '
            </tbody>
            </table>';

            $grandtotal = $tarifobat_fix - $data['listdataheader']['ValueDiscount'];
            
            $html .='<hr>
            <table width="100%" cellspacing="0" cellpadding="1" border="0" >
            <tbody> 
            <tr>
            <td align="left" width="54%"></td>
            <td align="left" width="26%"><font size="9"><b>Total</B></font></td>
            <td align="right" width="20%"><font size="9"><b>'.number_format($tarifobat_fix,0,',','.').'</B></font></td>
            </tr>
            <tr>

            <td align="left" width="54%"></td>
            <td align="left" width="26%"><font size="9"><b>Discount</B></font></td>
            <td align="right" width="20%"><font size="9"><b>'.number_format($data['listdataheader']['ValueDiscount'],0,',','.').'</font></B></td>
            </tr>
            <tr>

            <td align="left" width="54%"></td>
            <td align="left" width="26%"><font size="9"><b>Grand Total</B></font></td>
            <td align="right" width="20%"><font size="9"><b>'.number_format($grandtotal,0,',','.').'</B></font></td>
            </tr>
            
          <tr>
          <td></td>
          </tr>';

          foreach ($data['listdata_payment'] as $row) {
            if ($row['TipePembayaran'] == 'Piutang Asuransi' || $row['TipePembayaran'] == 'Piutang Perusahaan'){
              $tipepembayaran = $row['TipePembayaran'].'<br><i>('.$row['Billto'].')</i>';
            }else{
              $tipepembayaran = $row['TipePembayaran'];
            }
            $html .= '
              <tr>
              <td align="left" width="54%"></td>
              <td align="left" width="26%"><font size="9"><b>'.$tipepembayaran.'</B></font></td>
              <td align="right" width="20%"><font size="9"><b>'.$row['TotalPaid'].'</B></font></td>
              </tr>
            ';
          }
        
          
          $html .= '
          
      </tbody>
    </table>';


      $html .= '<hr><table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tbody> 
        <tr>
        <td></td>
        </tr>
           <tr>
           <td align="left" width="90%"><font size="8"><i>Cetakan ke : '.$data['cetakanke']['CetakanKe'].'</i></font></td>
            </tr>
            <tr>
            <td align="left" width="100%"><font size="8">'.$day.', '.$datenow2.'</font></td>
            </tr>

            <tr>
            <td align="left" width="100%"><font size="8">Kasir,</font></td>
            </tr>

            <tr>
              <td align="left" width="100%"><img src="'.$data['listdatasign']['AWSSign'].'"  width="70" height="30"></td>
            </tr>

             <tr>
              <td align="left" width="100%"><font size="8"><u>'.$data['listdatasign']['username'].'</u></font></td>
            </tr>

            <tr>
              <td align="center" width="100%"><font size="8">Rincian Biaya Ini Bukan Bukti Pembayaran</font></td>
            </tr>
            <tr>
            <td align="center" width="100%"><font size="8">Transaksi Tidak Dapat Dikembalikan</font></td>
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


