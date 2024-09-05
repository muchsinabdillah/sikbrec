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
					    <td align="center" width="60%"><b>TABEL PRODUKTIVITAS KERJA</b>
					    <br>' . $periode . '
					    <br>' . $lokasiproject . '
					    </td>
					  </tr>
                  </tbody>
                </table>

                <table width="100%"  cellspacing="0" cellpadding="3" border="1" style="border: 1px solid #000;">
                  <tbody> 
					  <tr>
					    <td align="center"  width="5%">No</td>
					    <td align="center"  width="10%">ID</td>
					    <td align="center"  width="35%">Nama</td>
					    <td  align="center"  width="10%">Jam Hari Kerja</td>
					    <td  align="center"  width="10%">Jam Hari Normal</td>
					    <td  align="center"  width="10%">Jam Kerja Normal</td>
					    <td  align="center"  width="10%">Jam Hari Lembur</td>
					    <td  align="center"  width="11%">Produktivitas</td>
					  </tr>';
                $total_gaji = 0;
                $total_pph = 0;
                $total_gajibersih = 0;
                $no = 1;
foreach ($data['listInfoProduktifitas'] as $row) {
    $html .= '
					   <tr>
					    <td align="left"  width="5%">' . $no++ . '</td>
					    <td align="left"  width="10%">' . $row['ID'] . '</td>
					    <td align="left"  width="35%">' . $row['Nama'] . '</td>
					    <td  align="right"  width="10%">' . $row['JUMLAH_HARI_MASUK'] . '</td>
					    <td  align="right"  width="10%">' . $row['JUMLAH_HARI_NORMAL'] . '</td>
					    <td  align="right"  width="10%">' . $row['JUMLAH_JAM_MASUK'] . '</td>
					    <td  align="right"  width="10%">' . $row['JUMLAH_JAM_LEMBUR'] . '</td>
					    <td  align="right"  width="11%">' . $row['PRODUCTIVITY'] . '%</td>
					  </tr>';        
}
                $html .= ' 
                  </tbody> 
                </table>';


                $pdf->SetFont('', '', 9); // default font header
                $pdf->writeHTML($html, true, false, true, false, '');
                $pdf->output();
?>
<script src="<?= BASEURL; ?>/js/App/informasi/HRD/InfoPayroll_v02.js"></script>