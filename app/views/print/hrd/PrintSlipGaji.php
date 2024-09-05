<?php
$pdf = new TCPDF('L', 'mm', 'A5', true, 'UTF-8', false);
//$resolution = array(210, 80);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage('L');

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


$html .= '  <table width="100%" cellspacing="0" cellpadding="2" border="1" style="border: 1px solid #000;">
                <tbody> 
                    <tr>
                        <td rowspan="2" width="34%"><b>PT. GUT</b><br>JL. KENANGAN NO. 1<br>JAKARTA TIMUR<br>021889384343</td>
                        <td rowspan="2" width="33%" align="center"><font size="15"><b>SLIP GAJI</b></font></td>
                        <td rowspan="2" width="33%" class="h_kiri"><p style="text-align:right"> PRIVATE & CONFIDENTIAL</p></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
            </table>';
            
$html .= '  <table class="tabler" width="100%" cellspacing="0" cellpadding="1" border="2">
                <tbody> 
                    <tr>
                        <td width="20%"> GUT ID </td>
                        <td width="2%">:</td>
                        <td width="35%" class="h_kiri">' . $data['slip01']['nip'] . '</td>
                        <td width="20%"> Bank </td>
                        <td width="2%">:</td>
                        <td class="h_kanan"width="22%">' . $data['slip01']['NamaBank'] . '</td>
                    </tr>
                    <tr>
                        <td width="20%"> Nama </td>
                        <td width="2%">:</td>
                        <td width="35%" class="h_kiri">' . $data['slip01']['nama'] . '</td>
                        <td width="20%"> Transfer </td>
                        <td width="2%">:</td>
                        <td class="h_kanan"width="22%">' . $data['slip01']['No_Rek'] . '</td>
                    </tr>
                    <tr>
                        <td width="20%"> Jabatan </td>
                        <td width="2%">:</td>
                        <td width="35%" class="h_kiri">' . $data['slip01']['JabatanFungsional'] . '</td>
                        <td width="20%"> Periode </td>
                        <td width="2%">:</td>
                        <td class="h_kanan"width="22%">' . $data['slip01']['Periode'] . '</td>
                    </tr>
                </tbody>
            </table>';


            $html .= '<table width="100%" class="tabler" cellspacing="0" cellpadding="2" border="0">
                    <tr>
				<td width="15%"></td>
				<td  width="43%"></td>
				<td  width="42%"></td>
					</tr>
					</table>
                <table width="100%" class="tabler" cellspacing="0" cellpadding="2" border="2">
                    <tr>
				<td width="15%">INFORMASI</td>
				<td  width="43%">PENDAPATAN</td>
				<td  width="42%">PENGURANGAN</td>
					</tr>
					</table>
                <table width="100%" class="tabler" cellspacing="0" cellpadding="2" border="2">
				';
$first = true;
$total_pendapatan = 0;
$total_potongan = 0;
foreach ($data['slip02'] as $row) {
    $pendapatan = '';
    $pengurangan = '';
    $nilai_pendapatan = null;
    $nilai_potongan = null;
    if ($row['JENIS_KOMPONEN'] == 'POTONGAN') {
        $pengurangan = $row['NAMA_KOMPONEN'];
        $nilai_potongan = number_format($row['nilai'], 0, ",", ".");
        $total_potongan += $row['nilai'];
    } else {
        $pendapatan = $row['NAMA_KOMPONEN'];
        $nilai_pendapatan = number_format($row['nilai'], 0, ",", ".");
        $total_pendapatan += $row['nilai'];
    }

    //INFORMASI
    if ($first == true) {
        $periodex = DATE("M - Y", strtotime($data['slip01']['Periode']));
    } else {
        $periodex = null;
    }
    $first = false;
                $html .='
					<tr>
				<td  width="15%">'.$periodex.'</td>
				<td  width="25%">'.$pendapatan.'</td>
				<td  width="15%" align="rigth">'.$nilai_pendapatan.'</td>
				<td  width="3%" align="rigth"></td>
				  <td  width="25%">'.$pengurangan.'</td>
				  <td  width="17%" align="rigth">'.$nilai_potongan.'</td>
					</tr>';
}
            $nilai_total = $total_pendapatan - $total_potongan;
		$html .='
					</table>
					<table width="100%" class="tabler" cellspacing="0" cellpadding="2" border="0">
                    <tr>
				<td width="15%"></td>
				<td  width="43%"></td>
				<td  width="42%"></td>
					</tr>
					</table>
					<table width="100%" class="tabler" cellspacing="0" cellpadding="2" border="2">
                    <tr>
				<td  width="15%"></td>
				<td  width="25%">TOTAL PENDAPATAN</td>
				<td  width="15%" align="rigth">'.number_format($total_pendapatan,0,",",".").'</td>
				<td  width="3%" align="rigth"></td>
				  <td  width="25%">TOTAL POTONGAN</td>
				  <td  width="17%" align="rigth">'.number_format($total_potongan,0,",",".").'</td>
					</tr>
					</table>

					<table width="100%" class="tabler" cellspacing="0" cellpadding="2" border="0">
                    <tr>
				<td width="15%"></td>
				<td  width="43%"></td>
				<td  width="42%"></td>
					</tr>
					</table>
					<table width="100%" class="tabler" cellspacing="0" cellpadding="2" border="0">
                    <tr>
				<td  width="15%"></td>
				<td  width="25%"></td>
				<td  width="15%" align="rigth"></td>
				<td  width="3%" align="rigth"></td>
				  <td  width="25%"><b>PENDAPATAN BERSIH</b></td>
				  <td  width="17%" align="rigth"><b>'.number_format($nilai_total,0,",",".").'</b></td>
					</tr>
					</table>
					';
$pdf->SetFont('', '', 9); // default font header
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->output();
?>
 