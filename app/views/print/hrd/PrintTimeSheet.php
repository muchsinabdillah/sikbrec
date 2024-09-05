<?php
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
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

$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="1" style="border: 1px solid #000;">
                  <tbody> 
					  <tr>
					    <td rowspan="3" align="left"  width="33%"><b>PT. Graha Usaha Teknik</b><br>Jl. Asem Baris Raya No. 100A Kebon Baru Tebet, Jakarta 12830<br>Telp: 021-8378-7333, <br>Fax: 021-8378-7222</td>
					    <td align="center"  width="33%">Hanya Untuk Internal</td>
					    <td rowspan="2" align="center"  width="17%">Hari Kerja Normal</td>
					    <td rowspan="3" align="left"  width="18%">Doc No : 2.21.27<br>Revision : 01<br>Date : 06.09.2018</td>
					  </tr>
					  <tr>
					    <td align="center" width="33%">PERHITUNGAN JUMLAH JAM KERJA</td>
					  </tr>
					  <tr>
					    <td align="center" width="33%">TIME SHEET (TS)</td>
					    <td align="center" width="17%">6 Hari Kerja<br>Bulanan UMK</td>
					  </tr>
                  </tbody>
                </table>

                <table width="100%" cellspacing="0" cellpadding="1" border="1" style="border: 1px solid #000;">
                  <tbody> 
					  <tr>
					    <td align="center"  width="10%">Personel ID</td>
					    <td align="center"  width="23%">Nama</td>
					    <td  align="center"  width="15%">Status Pernikahan</td>
					    <td  align="center"  width="15%">Jumlah Anak</td>
					    <td  align="center"  width="23%">NPWP</td>
					    <td  align="center"  width="15%">Bulan</td>
					  </tr>
					   <tr>
					    <td align="center"  width="10%"><b>' . $data['listTimesheet1']['nip'] . '</b></td>
					    <td align="center"  width="23%"><b>' . $data['listTimesheet1']['nama']  . '</b></td>
					    <td  align="center"  width="15%"><b>' . $data['listTimesheet1']['Status_Menikah']  . '</b></td>
					    <td  align="center"  width="15%"><b>' . $data['listTimesheet1']['Jml_Anak'] . '</b></td>
					    <td  align="center"  width="23%"><b>' . $data['listTimesheet1']['punya_npwp'] . '</b></td>
					    <td  align="center"  width="15%"><b></b></td>
					  </tr>
                  </tbody>
                </table>

                <table width="100%" cellspacing="0" cellpadding="1" border="1" style="border: 1px solid #000;">
                  <tbody> 
					  <tr>
					    <td align="center"  width="20%">Waktu Time</td>
					    <td align="center"  width="20%">Jam Kerja</td>
					    <td rowspan="2" align="center"  width="5%">Travel</td>
					    <td  align="center"  width="5%">Absen</td>
					    <td rowspan="3" align="center"  width="5%">All Code</td>
					    <td rowspan="3" align="center"  width="5%">Total Waktu Telat</td>
					    <td  rowspan="2" align="center"  width="25%">Proyek</td>
					    <td  rowspan="3" align="center"  width="16%">Note</td>
					  </tr>
					  <tr>
					    <td rowspan="2" align="center"  width="10%">Date</td>
					    <td rowspan="2" align="center"  width="5%">Start</td>
					    <td rowspan="2" align="center"  width="5%">Finish</td>
					    <td align="center"  width="4%">Biasa Normal</td>
					    <td align="center"  width="16%">Lembur/Overtime</td>
					    <td  align="center"  width="5%">Tanpa Keterangan</td>
					  </tr>
					   <tr>
					    <td align="center"  width="4%">A</td>
					    <td align="center"  width="4%">B</td>
					    <td align="center"  width="4%">C</td>
					    <td align="center"  width="4%">D</td>
					    <td align="center"  width="4%">E</td>
					    <td align="center"  width="5%"></td>
					    <td align="center"  width="5%"></td>
					    <td align="center"  width="25%">Side/Project</td>
					  </tr>
                  </tbody>
                </table>';
            foreach ($data['listTimesheet2'] as $row) {
                    if ($row['jam1'] == null) {
                        $jam1 = null;
                    } else {
                        $jam1 = number_format($row['jam1'], 2, ".", ",");
                    }

                    if ($row['jam2'] == null) {
                        $jam2 = null;
                    } else {
                        $jam2 = number_format($row['jam2'], 2, ".", ",");
                    }

                    if ($row['jam3'] == null) {
                        $jam3 = null;
                    } else {
                        $jam3 = number_format($row['jam3'], 2, ".", ",");
                    }

                    if ($row['jam4'] == null) {
                        $jam4 = null;
                    } else {
                        $jam4 = number_format($row['jam4'], 2, ".", ",");
                    }
                $html .='
                <table width="100%" cellspacing="0" cellpadding="3" border="1" style="border: 1px solid #000;">
                  <tbody> 
					   <tr>
					    <td align="center"  width="10%">'.$row['TGL_JADWAL'].'</td>
					    <td align="center"  width="5%">'.$row['JAM_ABSEN_MASUK'].'</td>
					    <td align="center"  width="5%">'.$row['JAM_SHIFT_KELUAR'].'</td>
					    <td align="center"  width="4%">'.$row['KODE_CUTI'].'</td>
					    <td align="center"  width="4%">'.$jam1.'</td>
					    <td align="center"  width="4%">'.$jam2.'</td>
					    <td align="center"  width="4%">'.$jam3.'</td>
					    <td align="center"  width="4%">'.$jam4.'</td>
					    <td align="center"  width="5%"></td>
					    <td align="center"  width="5%">'.$row['KetAbsensi'].'</td>
					    <td align="center"  width="5%">-</td>
					    <td align="center"  width="5%">'.$row['JML_TELAT'].'</td>
					    <td align="left"  width="25%">'.$row['NM_LOKASI'].'</td>
					    <td align="left"  width="16%">'.$row['NOTE'].'</td>
					  </tr>
                  </tbody>
                </table>
                ';	       	
            }

            $totalPendapatan = $data['listTimesheet4']['TUNJANGAN_POKOK'] + $data['listTimesheet4']['UPAH_POKOK'] + $data['listTimesheet4']['LEMBUR'];
            $totalPendapatan2 = $totalPendapatan - $data['listTimesheet4']['POTONGAN_ABSENSI'];
            $totaldibayar = $totalPendapatan2 - $data['listTimesheet4']['PPH21'] - $data['listTimesheet4']['KASBON'];
         
            $html .= '
             <table width="100%" class="tablex" cellspacing="0" cellpadding="2" border="0">
                    <tr>
				<td width="15%"></td>
				<td  width="45%"></td>
				<td  width="43%"></td>
					</tr>
					</table>

            <table width="100%" cellspacing="0" cellpadding="1" border="1" style="border: 1px solid #000;">
                  <tbody> 
					  <tr>
					    <td align="left"  width="40%">Upah Pokok / Bulan</td>
					    <td  align="right"  width="20%">Rp. '.number_format($data['listTimesheet4']['UPAH_POKOK'],2,".",",").' </td> 
					    <td rowspan="7" align="center"  width="41%">FORM-A</td>
					  </tr>
					   <tr>
					    <td align="left"  width="40%">Tunjangan Tetap / Bulan</td>
					    <td  align="right"  width="20%">Rp. '.number_format($data['listTimesheet4']['TUNJANGAN_POKOK'],2,".",",").'</td> 
					  </tr>
					  <tr>
					    <td rowspan="4" align="left"  width="7%">Lembur</td>
					    <td rowspan="4" align="left"  width="8%">Overtime</td>
					    <td align="right"  width="25%">150% x '.$data['listTimesheet3']['JAM1'].' x Rp. '.number_format($data['listTimesheet1']['NILAI_LEMBUR_PERJAM'],2,".",",").'</td>
					    <td  align="right"  width="20%">Rp. '.number_format($data['listTimesheet3']['NILAI_KELAS1'],2,".",",").'</td>
					  </tr>
					  <tr>
					    <td align="right"  width="25%">200% x '. $data['listTimesheet3']['JAM2'].' x Rp. '.number_format($data['listTimesheet1']['NILAI_LEMBUR_PERJAM'],2,".",",").'</td>
					    <td  align="right"  width="20%">Rp. '.number_format($data['listTimesheet3']['NILAI_KELAS2'],2,".",",").'</td>
					  </tr>
					  <tr>
					    <td align="right"  width="25%">300% x '.$data['listTimesheet3']['JAM3'].' x Rp. '.number_format($data['listTimesheet1']['NILAI_LEMBUR_PERJAM'],2,".",",").'</td>
					    <td  align="right"  width="20%">Rp. '.number_format($data['listTimesheet3']['NILAI_KELAS3'],2,".",",").'</td>
					  </tr>
					  <tr>
					    <td align="right"  width="25%">400% x '. $data['listTimesheet3']['JAM4'].' x Rp. '.number_format($data['listTimesheet1']['NILAI_LEMBUR_PERJAM'],2,".",",").'</td>
					    <td  align="right"  width="20%">Rp. '.number_format($data['listTimesheet3']['NILAI_KELAS4'],2,".",",").'</td>
					  </tr>
					  <tr>
					    <td  align="left"  width="15%">Pot Absen</td>
					    <td align="right"  width="25%">'.number_format($data['listTimesheet1']['HARI_POT_ABSEN'],2,".",",").' x Rp. '.number_format($data['listTimesheet1']['NILAI_POT_ABSEN'],2,".",",").'</td>
					    <td  align="right"  width="20%">Rp. '.number_format($data['listTimesheet1']['ttlpotongan'],2,".",",").'</td>
					  </tr>
					   <tr>
					    <td align="center"  width="40%">Total Upah Tanpa Pot</td>
					    <td  align="right"  width="20%">Rp. '.number_format($totalPendapatan,2,".",",").'</td>
					    <td  align="right"  width="21%"></td>
					    <td  align="right"  width="20%"></td>
					  </tr>
					  <tr>
					    <td align="center"  width="40%">Potongan TL/PSW</td>
					    <td  align="right"  width="20%">Rp. '.number_format($data['listTimesheet4']['POTONGAN_ABSENSI'],2,".",",").' </td>
					    <td  align="right"  width="41%"></td>
					  </tr>
					  <tr>
					    <td align="center"  width="40%">Total Upah</td>
					    <td  align="right"  width="20%">Rp. '.number_format($totalPendapatan2,2,".",",").'</td>
					    <td  align="right"  width="41%"></td>
					  </tr>
					   <tr>
					    <td align="center"  width="20%">Total Upah</td>
					    <td align="center"  width="20%">Potongan Pph 21</td>
					    <td  align="right"  width="20%"></td>
					    <td  align="center"  width="21%">Potongan Kasbon</td>
					    <td  align="center"  width="20%">Total Dibayar</td>
					  </tr>
					  <tr>
					    <td align="right"  width="20%">Rp. '.number_format($totalPendapatan2,2,".",",").'</td>   
					    <td align="right"  width="20%">Rp. '.number_format($data['listTimesheet4']['PPH21'],2,".",",").'</td> 
					    <td  align="right"  width="20%"></td>
					    <td  align="center"  width="21%">'.number_format($data['listTimesheet4']['KASBON'],2,".",",").'</td>
					    <td  align="center"  width="20%">Rp. '.number_format($totaldibayar,2,".",",").'</td>
					  </tr>
					   <tr>
					    <td align="center"  width="20%"></td>
					    <td align="center"  width="10%">Grup</td>
					    <td align="center"  width="20%">Nama dan Tanda Tangan Pelaksana</td>
					    <td rowspan="4" align="right"  width="51%"></td>
					  </tr>
					  <tr>
					    <td align="center"  width="10%"></td>
					    <td rowspan="3" align="center"  width="10%"></td>
					    <td rowspan="3" align="center"  width="10%"></td>
					    <td rowspan="3" align="center"  width="20%"></td>
					  </tr>
					    <tr>
					    <td align="center"  width="10%"></td>
					  </tr>
					    <tr>
					    <td align="center"  width="10%"></td>
					  </tr>
                  </tbody>
                </table>';
         
$pdf->SetFont('', '', 9); // default font header
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->output();
?>
 