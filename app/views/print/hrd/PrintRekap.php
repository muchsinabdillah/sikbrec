<?php
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
//$resolution = array(210, 80);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage('P');
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

$periode = $data['periode'];
$lokasiproject = $data['lokasiproject'];
$html .= '
		<table width="100%" cellspacing="0" cellpadding="1" border="0" >
                  <tbody> 
					  <tr>
					    <td width="20%"><img src="BASEURL;/../../public/images/gutlogo.PNG"  width="90" height="45"></td>
					    <td align="center" width="60%"><b>REKAP PERHITUNGAN GAJI KARYAWAN LOKAL DAN ALLOWANCE</b></td>
					  </tr>
					  <tr>
					    <td align="left" width="10%"><font size="8"><b>Bulan</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="60%">' . $periode . '</td>
					  </tr>
					  <tr>
					    <td align="left" width="10%"><font size="8"><b>Project</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="60%">' . $lokasiproject . '</td>
					  </tr>
					  <tr>
					    <td align="left" width="20%"><u>Lokal Jakarta</U></td>
					  </tr>
                  </tbody>
                </table>

                <table width="100%"  cellspacing="0" cellpadding="3" border="1" style="border: 1px solid #000;">
                  <tbody> 
					  <tr>
					    <td align="center"  width="10%">ID</td>
					    <td align="center"  width="31%">Nama</td>
					    <td  align="center"  width="15%">Jabatan</td>
					    <td  align="center"  width="15%">Gaji Sebulan</td>
					    <td  align="center"  width="15%">PPh 21</td>
					    <td  align="center"  width="15%">Gaji Bersih</td>
					  </tr>';
                $total_gaji = 0;
                $total_pph = 0;
                $total_gajibersih = 0;
                foreach ($data['listInfoPayroll'] as $row)  {
                $html .= '
					   <tr>
					    <td align="left"  width="10%">' . $row['ID'] . '</td>
					    <td align="left"  width="31%">' . $row['Nama'] . '</td>
					    <td  align="left"  width="15%">Jabatan</td>
					    <td  align="right"  width="15%">' . number_format($row['SUB_TOTAL'], 0, ",", ".") . '</td>
					    <td  align="right"  width="15%">' . number_format($row['PPH21'], 0, ",", ".") . '</td>
					    <td  align="right"  width="15%">' . number_format($row['GRAND_TOTAL'], 0, ",", ".") . '</td>
					  </tr>';
                $total_gaji += $row['SUB_TOTAL'];
                $total_pph += $row['PPH21'];
                $total_gajibersih += $row['GRAND_TOTAL'];    
                }
                $html .= ' 
                  </tbody>
                  <tfoot>
                   <tr>
					    <td align="right"  width="56%"><b>Total</b></td>
					    <td  align="right"  width="15%"><b>' . number_format($total_gaji, 0, ",", ".") . '</b></td>
					    <td  align="right"  width="15%"><b>' . number_format($total_pph, 0, ",", ".") . '</b></td>
					    <td  align="right"  width="15%"><b>' . number_format($total_gajibersih, 0, ",", ".") . '</b></td>
					  </tr>
                  </tfoot>
                </table>';

            
$pdf->SetFont('', '', 9); // default font header
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->output();
?>
<script src="<?= BASEURL; ?>/js/App/informasi/HRD/InfoPayroll_v02.js"></script>