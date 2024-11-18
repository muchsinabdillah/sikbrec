<?php
 $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

 date_default_timezone_set('Asia/Jakarta');
 $datenow = Date("d/m/Y");
 $pdf->setPrintHeader(false);
 $pdf->setPrintFooter(false);
 //$pdf->SetAutoPageBreak(false);
 $pdf->AddPage();

$pdf->Image('../public/images/yarsi.png',15,10,50);
$pdf->Ln(-5);
// cell(widht, height, text, border, end line , [ALIGN] )

// set font to , bold, 14pt
$pdf->setFont('','',9);

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(210, 4, '', 0, 0);
$pdf->SetFont('', '', 9);
$pdf->Cell(55, 4, 'No : 010/FRM/REG/RSY/Rev0/1/2020', 1, 1, 'L');
$pdf->Cell(0, 2, '', 0, 1);
$pdf->Cell(210, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Jl. Letjen Suprapto, Kav. 13 Cempaka Putih, ', 0, 1, 'L');
$pdf->Cell(210, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Jakarta Pusat 10510', 0, 1, 'L');
$pdf->Cell(210, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Telp: 021-80618618, 80618619 (Hunting),', 0, 1, 'L');
$pdf->Cell(210, 3, '', 0, 0);
$pdf->Cell(25, 3, 'www.rsyarsi.co.id', 0, 1, 'L');


//make a dummy empty cell as a vertical spacer
$pdf->cell(0 ,10,'',0,1);//end of line

$pdf->setFont('','B',15);
$pdf->Cell(0 ,4,'Informasi Penjualan',0,1,'C');//end of line
$pdf->Cell(0,5,'',0,1);//br

$pdf->setFont('','B',8);
$pdf->CellFitScale(6,5,'NO',1,0);
$pdf->CellFitScale(25,5,'NO. Transaksi',1,0);
$pdf->CellFitScale(25,5,'Tgl Transaksi',1,0);
$pdf->CellFitScale(25,5,'User',1,0);
$pdf->CellFitScale(25,5,'No. Registrasi',1,0);
$pdf->CellFitScale(15,5,'No. Resep',1,0);
$pdf->CellFitScale(15,5,'No. MR',1,0);
$pdf->CellFitScale(25,5,'Nama Pasien',1,0);
$pdf->CellFitScale(25,5,'Jaminan',1,0);
$pdf->CellFitScale(10,5,'Kode Barang',1,0);
$pdf->CellFitScale(20,5,'Nama Barang',1,0);
$pdf->CellFitScale(6,5,'Qty',1,0);
$pdf->CellFitScale(15,5,'Satuan',1,0);
$pdf->CellFitScale(15,5,'Harga',1,0);
$pdf->CellFitScale(15,5,'Diskon',1,0);
$pdf->CellFitScale(15,5,'Grandtotal',1,1);
$border=1;
$hb=10;
$t_qty = 0;
$t_harga = 0;
$t_disc = 0;
$t_grandtotal = 0;
$pdf->setFont('','',8);
    foreach ($data['listdata1'] as $key){

    // $pdf->setFont('', '', 7); 
    // $x = $pdf->GetX(); 
    // $y = $pdf->GetY(); 
    // $pdf->MultiCell(6, $hb, $key['no'],  $border, 1); 
    // $pdf->SetXY($x + 6, $y); 
    // $pdf->MultiCell(25, $hb, $key['TransactionCode'], $border, 1); 
    // $pdf->SetXY($x + 31, $y); 
    // $pdf->MultiCell(25, $hb,  $key['TransactionDate'], $border, 1); 
    // $pdf->SetXY($x + 56, $y); 
    // $pdf->MultiCell(25, $hb, $key['NamaUserCreate'],  $border, 1); 
    // $pdf->SetXY($x + 81, $y); 
    // $pdf->MultiCell(25, $hb, $key['NoRegistrasi'], $border, 1); 
    // $pdf->SetXY($x + 106, $y); 
    // $pdf->MultiCell(15, $hb, $key['NoResep'], $border, 1); 
    // $pdf->SetXY($x + 121, $y); 
    // $pdf->MultiCell(15, $hb, $key['NoMR'], $border, 1); 
    // $pdf->SetXY($x + 136, $y); 
    // $pdf->MultiCell(25, $hb, $key['NamaPembeli'], $border, 1); 
    // $pdf->SetXY($x + 161, $y); 
    // $pdf->MultiCell(25, $hb, $key['NamaJaminan'], $border, 1); 
    // $pdf->SetXY($x + 186, $y); 
    // $pdf->MultiCell(10, $hb, $key['ProductCode'], $border, 1); 
    // $pdf->SetXY($x + 196, $y); 
    // $pdf->MultiCell(20, $hb, $key['ProductName'], $border, 1);
    // $pdf->SetXY($x + 216, $y); 
    // $pdf->MultiCell(6, $hb, number_format($key['Qty']), $border, 1);
    // $pdf->SetXY($x + 222, $y); 
    // $pdf->MultiCell(15, $hb, $key['Satuan'], $border, 1);
    // $pdf->SetXY($x + 237, $y); 
    // $pdf->MultiCell(15, $hb, number_format($key['Harga']), $border, 1);
    // $pdf->SetXY($x + 252, $y); 
    // $pdf->MultiCell(15, $hb, number_format($key['Discount']), $border, 1);
    // $pdf->SetXY($x + 267, $y); 
    // $pdf->MultiCell(15, $hb, number_format($key['Grandtotal']), $border, 1);

        $pdf->CellFitScale(6,5, $key['no'],1,0);
        $pdf->CellFitScale(25,5,$key['TransactionCode'],1,0);
        $pdf->CellFitScale(25,5,$key['TransactionDate'],1,0);
        $pdf->CellFitScale(25,5,$key['NamaUserCreate'],1,0);
        $pdf->CellFitScale(25,5,$key['NoRegistrasi'],1,0);
        $pdf->CellFitScale(15,5,$key['NoResep'],1,0);
        $pdf->CellFitScale(15,5,$key['NoMR'],1,0);
        $pdf->CellFitScale(25,5,$key['NamaPembeli'],1,0);
        $pdf->CellFitScale(25,5,$key['NamaJaminan'],1,0);
        $pdf->CellFitScale(10,5,$key['ProductCode'],1,0);
        $pdf->CellFitScale(20,5,$key['ProductName'],1,0);
        $pdf->CellFitScale(6,5, number_format($key['Qty']),1,0);
        $pdf->CellFitScale(15,5,$key['Satuan'],1,0);
        $pdf->CellFitScale(15,5,number_format($key['Harga']),1,0);
        $pdf->CellFitScale(15,5,number_format($key['Discount']),1,0);
        $pdf->CellFitScale(15,5,number_format($key['Grandtotal']),1,1);

        $t_qty += $key['Qty'];
        $t_harga += $key['Harga'];
        $t_disc += $key['Discount'];
        $t_grandtotal += $key['Grandtotal'];
    }
        $pdf->setFont('','B',8);
        $pdf->CellFitScale(216,5,'Total',1,0,'C');
        $pdf->CellFitScale(6,5,number_format($t_qty),1,0);
        $pdf->CellFitScale(15,5,'',1,0);
        $pdf->CellFitScale(15,5,number_format($t_harga),1,0);
        $pdf->CellFitScale(15,5,number_format($t_disc),1,0);
        $pdf->CellFitScale(15,5,number_format($t_grandtotal),1,1);
      $html='';
$html = '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 10; padding-bottom: 12px; text-align: center;}
			.header_kolom {background-color: #cccccc; text-align: center}
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

    //QR CODE
    // require_once("../App/library/phpqrcode/qrlib.php");
    // $url = $data['listdata1']['uuid4'];
    // $url_ext = "https://esigndocument.rsyarsi.co.id/edocakadijaroh/".$url;
    // QRcode::png($url_ext, $url .".png");

    //     $html .= '<table width="100%" cellspacing="0" cellpadding="4" border="0.1" >
    //     <thead>
    //         <tr>
    //                         <td align="center" class="txt_content"><font size="9">NO</font></td>
    //                         <th align="center" class="txt_content"><font size="9">NO. Transaksi</font></th>
    //                         <th align="center" class="txt_content"><font size="9">Tgl Transaksi</font></th>
    //                         <th align="center" class="txt_content"><font size="9">User</font></th>
    //                         <th align="center" class="txt_content"><font size="9">No. Registrasi</font></th>
    //                         <th align="center" class="txt_content"><font size="9">No. Resep</font></th>
    //                         <th align="center" class="txt_content"><font size="9">No. MR</font></th>
    //                         <th align="center" class="txt_content"><font size="9">Nama Pasien</font></th>
    //                         <th align="center" class="txt_content"><font size="9">Jaminan</font></th>
    //                         <th align="center" class="txt_content"><font size="9">Kode Barang</font></th>
    //                         <th align="center" class="txt_content"><font size="9">Nama Barang</font></th>
    //                         <th align="center" class="txt_content"><font size="9">Qty</font></th>
    //                         <th align="center" class="txt_content"><font size="9">Satuan</font></th>
    //                         <th align="center" class="txt_content"><font size="9">Harga</font></th>
    //                         <th align="center" class="txt_content"><font size="9">Diskon</font></th> 
    //                         <th align="center" class="txt_content"><font size="9">Grandtotal</font></th> 
    //         </tr>
    //         </thead>

    //         <tbody>';
    //         foreach($data['listdata1'] as $key){
    //             $html .= '<tr>
    //             <td align="center"><font size="9">'.$key['no'].'</font></td>
    //             <td align="left"><font size="9">'.$key['TransactionCode'].'</font></td>
    //             <td align="left"><font size="9">'.$key['TransactionDate'].'</font></td>
    //             <td align="left"><font size="9">'.$key['NamaUserCreate'].'</font></td>
    //             <td align="left"><font size="9">'.$key['NoRegistrasi'].'</font></td>
    //             <td align="left"><font size="9">'.$key['NoResep'].'</font></td>
    //             <td align="left"><font size="9">'.$key['NoMR'].'</font></td>
    //             <td align="left"><font size="9">'.$key['NamaPembeli'].'</font></td>
    //             <td align="left"><font size="9">'.$key['NamaJaminan'].'</font></td>
    //             <td align="left"><font size="9">'.$key['ProductCode'].'</font></td>
    //             <td align="left"><font size="9">'.$key['ProductName'].'</font></td>
    //             <td align="left"><font size="9">'.$key['Qty'].'</font></td>
    //             <td align="left"><font size="9">'.$key['Satuan'].'</font></td>
    //             <td align="left"><font size="9">'.$key['Harga'].'</font></td>
    //             <td align="left"><font size="9">'.$key['Discount'].'</font></td>
    //             <td align="left"><font size="9">'.$key['Grandtotal'].'</font></td>
    //             </tr>
    //             ';
    //         }
            
    //   $html .= '      
    //     </tbody>
    //   </table>';
      


      $certificate = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.crt'; 
        $key = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.key';

        $info = array(
                         'Name' => 'TCPDF',
                         'Location' => 'Office',
                         'Reason' => 'Testing TCPDF',
                         'ContactInfo' => 'http://www.tcpdf.org',
                         );

      $pdf->setSignature($certificate, $key, 'tcpdfdemo', '', 2, $info);

      $pdf->writeHTML($html, true, false, true, false, '');

      //unlink($url.".png");
                  

//$pdf->Output();