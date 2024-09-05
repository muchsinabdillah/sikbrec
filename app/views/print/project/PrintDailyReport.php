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

    $html .= '
		<table width="100%" cellspacing="0" cellpadding="1" border="0" >
                  <tbody> 
					  <tr>
					    <td width="20%"><img src="../../img/gutlogo.png"  width="90" height="45"></td>
					    <td align="center" width="60%"><b>' . $data['slip01']['NM_PROJECT'] . '</b></td>
					  </tr>
					  <tr>
					    <td align="left" width="25%"><font size="8"><b>Job Order</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="50%">' . $data['slip01']['KD_JO'] . '</td>
					     <td align="left" width="15%"><font size="8"><b>Tanggal / Date</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="15%">' . DATE("d-M-y", strtotime($data['slip01']['FD_TGL'])) . '</td>
					  </tr>
					  <tr>
					    <td align="left" width="25%"><font size="8"><b>Langganan / Client</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="50%">' . $data['slip01']['NM_CLIENT'] . '</td>
					  </tr>
					  <tr>
					    <td align="left" width="25%"><font size="8"><b>Lokasi / Location</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="50%">' . $data['slip01']['LOKASI_KERJA'] . '</td>
					     <td align="left" width="30%"><font size="8"><b>Jml Pekerja / Number of Manpower</font></b></td>
					  </tr>
					  <tr>
					    <td align="left" width="77%"><font size="9"><b><U>LAPORAN KERJA HARIAN /  DAILY WORK REPORT</font></U></b></td>

					     <td align="left" width="15%"><font size="8"><b>Orang / Person</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="15%">' . $data['slip01']['TOTAL_PEG'] . '</td>
					  </tr>
					  <tr>
					    <td align="left" width="25%"><font size="8"><b>1. Lokasi Kerja / Work Location</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="50%">' . $data['slip01']['LOKASI_KERJA'] . '</td>
					  </tr>';
                      $no=0;
    foreach ($data['slip02'] as $row) {
    $no++;
        $html .= '
					  <tr>
					    <td align="left" width="25%"><font size="8"><b>' . $no . '. ' . $row['TIPE_PEG'] . '</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="50%">' . $row['Nama'] . '</td>
					  </tr>';
                      
    }
        $html .= '
                  </tbody>
                </table>';

    foreach ($data['slip03'] as $row) {
        $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
                  <tbody> 
                    <tr>
					    <td></td>
					  </tr>
					  <tr>
					    <td align="left" width="15%"><font size="8"><b>' . $row['NAMA_TIM'] . '</font></b></td>
					    <td align="left" width="2%">:</td>
					    <td align="left" width="60%">' . $row['TIM_DESCRIPTION'] .'</td>
					  </tr>
                </tbody>
                </table>';
                $html .= '  <table width="100%"  cellspacing="0" cellpadding="3" border="1" style="border: 1px solid #000;">
                                    <tbody> 
                                        <tr>
                                            <td align="center"  width="5%">No</td>
                                            <td align="center"  width="40%">Nama</td>
                                            <td  align="center"  width="26%">Jabatan</td>
                                            <td  align="center"  width="14%">Mulai</td>
                                            <td  align="center"  width="14%">Selesai</td>
                                        </tr>'; 
                $nodr=1;
                foreach ($data['slip04'] as $rowA) {
                    if($rowA['KD_TIM'] ==$row['KD_TIM']){
                            $html .= '
                                        <tr>
                                            <td align="left"  width="5%">' . $nodr++ . '</td>
                                            <td align="left"  width="40%">' . $rowA['Nama'] . '</td>
                                            <td  align="center"  width="26%">' . $rowA['JABATAN'] . '</td>
                                            <td  align="center"  width="14%">' . $rowA['Date_Start'] . '</td>
                                            <td  align="center"  width="14%">' . $rowA['Date_End'] . '</td>
                                        </tr>';
                    }
                            
                    
                }
                $html .= '      </tbody>
                                </table>';
                
    }


//8------------------------
                $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
                                <tbody> 
                                    <tr>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td align="left" width="15%"><font size="8"><b>8</font></b></td>
                                        <td align="left" width="60%">Peralatan Kerja / Tools & Equipment</td>
                                    </tr>

                                </tbody>
                                </table>';

                $html .= '<table width="100%"  cellspacing="0" cellpadding="3" border="1" style="border: 1px solid #000;">
                                <tbody> 
                                    <tr>
                                        <td align="center"  width="5%">No</td>
                                        <td align="center"  width="50%">Alat / Tools</td>
                                        <td  align="center"  width="44%">Jml / Qty</td>
                                    </tr>';
$noequip=1;
foreach ($data['slip05'] as $row) {
                $html .= '
                                    <tr>
                                        <td align="left"  width="5%">' . $noequip++ . '</td>
                                        <td align="left"  width="50%">' . $row['NAMA_BARANG'] . '</td>
                                        <td  align="center"  width="14%">' . $row['QTY'] . '</td>
                                        <td  align="center"  width="10%">' . $row['SATUAN'] . '</td>
                                        <td  align="center"  width="10%"></td>
                                        <td  align="center"  width="10%"></td>
                                    </tr>';
}
                $html .= '
                    </table>';
//-------#END ------------------
//9------------------------
        $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
                  <tbody> 
                    <tr>
					    <td></td>
					  </tr>

					   <tr>
					    <td align="left" width="15%"><font size="8"><b>9</font></b></td>
					    <td align="left" width="60%">Pekerjaan Yang Dilakukan / Activities Has Been Done</td>
					  </tr>

                  </tbody>
                </table>';

        $html .= '<table width="100%"  cellspacing="0" cellpadding="3" border="1" style="border: 1px solid #000;">
                  <tbody> 
					  <tr>
					    <td align="center"  width="5%">No</td>
					    <td align="center"  width="94%">Uraian Pekerjaan / Work Description</td>
					  </tr>';
$nosudah = 1;
foreach ($data['slip06'] as $row) {
        $html .= '
					   <tr>
					    <td align="left"  width="5%">' . $nosudah++ . '</td>
					    <td align="left"  width="94%">' . $row['NAMA_TIM'] . ' ' . $row['KEGIATAN'] . '</td>
					  </tr>';      
}
        $html .= '
                </table>';
//-------#END ------------------
//10------------------------
        $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
                  <tbody> 
                    <tr>
					    <td></td>
					  </tr>

					   <tr>
					    <td align="left" width="15%"><font size="8"><b>10</font></b></td>
					    <td align="left" width="60%">Rencana Pekerjaan Besok / Plan Work Tommorow</td>
					  </tr>

                  </tbody>
                </table>';

        $html .= '<table width="100%"  cellspacing="0" cellpadding="3" border="1" style="border: 1px solid #000;">
                  <tbody> ';
$noplan = 1;
foreach ($data['slip07'] as $row) {
        $html .= '
					   <tr>
					    <td align="left"  width="99%">- ' . $row['NAMA_TIM'] . ' ' . $row['PLANNING'] . '</td>
					  </tr>';
}
        $html .= '
                </table>';
//-------#END ------------------
//11------------------------
        $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
                  <tbody> 
                    <tr>
					    <td></td>
					  </tr>

					   <tr>
					    <td align="left" width="15%"><font size="8"><b>11</font></b></td>
					    <td align="left" width="60%">Cuaca / Weather</td>
					  </tr>

					  <tr>
					    <td align="center" width="4%"><font size="7">00:00</font></td>
					    <td align="center" width="4%"><font size="7">01:00</font></td>
					    <td align="center" width="4%"><font size="7">02:00</font></td>
					    <td align="center" width="4%"><font size="7">03:00</font></td>
					    <td align="center" width="4%"><font size="7">04:00</font></td>
					    <td align="center" width="4%"><font size="7">05:00</font></td>
					    <td align="center" width="4%"><font size="7">06:00</font></td>
					    <td align="center" width="4%"><font size="7">07:00</font></td>
					    <td align="center" width="4%"><font size="7">08:00</font></td>
					    <td align="center" width="4%"><font size="7">09:00</font></td>
					    <td align="center" width="4%"><font size="7">10:00</font></td>

					    <td align="center" width="4%"><font size="7">11:00</font></td>
					    <td align="center" width="4%"><font size="7">12:00</font></td>
					    <td align="center" width="4%"><font size="7">13:00</font></td>
					    <td align="center" width="4%"><font size="7">14:00</font></td>
					    <td align="center" width="4%"><font size="7">15:00</font></td>
					    <td align="center" width="4%"><font size="7">16:00</font></td>
					    <td align="center" width="4%"><font size="7">17:00</font></td>
					    <td align="center" width="4%"><font size="7">18:00</font></td>
					    <td align="center" width="4%"><font size="7">19:00</font></td>
					    <td align="center" width="4%"><font size="7">20:00</font></td>
					    <td align="center" width="4%"><font size="7">21:00</font></td>
					    <td align="center" width="4%"><font size="7">22:00</font></td>
					    <td align="center" width="4%"><font size="7">23:00</font></td>
					  </tr>

                  </tbody>
                </table>';

        $html .= '<table width="100%"  cellspacing="0" cellpadding="3" border="1" style="border: 1px solid #000;">
                  <tbody> ';
foreach ($data['slip08'] as $row) {
                  $html .='
					    <tr>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_00'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_001'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_002'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_003'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_004'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_005'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_006'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_007'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_008'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_009'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0010'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0011'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0012'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0013'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0014'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0015'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0016'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0017'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0018'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0019'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0020'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0021'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0022'].'</font></td>
					    <td align="center" width="4%"><font size="7">'.$row['JAM_0023'].'</font></td>
					  </tr>';       
}
            $html.='
                </table>';
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
                  <tbody> 
                    <tr>
					    <td></td>
					  </tr>

					  <tr>
					    <td align="center" width="4%"><font size="7">V</font></td>
					    <td align="center" width="2%"><font size="7">:</font></td>
					    <td align="left" width="25%"><font size="7">Cerah / Bright</font></td>
					    <td align="center" width="4%"><font size="7">X</font></td>
					    <td align="center" width="2%"><font size="7">:</font></td>
					    <td align="left" width="25%"><font size="7">Hujan / Rain or Drizzle</font></td>
					  </tr>

                  </tbody>
                </table>';
//-------#END ------------------
//11------------------------
$html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
                  <tbody> 
                    <tr>
					    <td></td>
					  </tr>

					  <tr>
					    <td align="center" width="25%"><font size="8">Mengetahui / Acknowledged by</font></td>
					    <td align="center" width="44%"><font size="8"></font></td>
					    <td align="center" width="25%"><font size="8">Dibuat Oleh / Prepared by</font></td>
					  </tr>

					  <tr>
					    <td></td>
					  </tr>
					  <tr>
					    <td></td>
					  </tr>
					  <tr>
					    <td></td>
					  </tr>

					  <tr>
					    <td align="center" width="25%"><font size="8"><b>Chairunafis</b></font></td>
					    <td align="center" width="44%"><font size="8"></font></td>
					    <td align="center" width="25%"><font size="8"><b>Ahmad Arifin</b></font></td>
					  </tr>
					   <tr>
					    <td align="center" width="25%"><font size="8">PT. KRAKATAU DAYA LISTRIK</font></td>
					    <td align="center" width="44%"><font size="8"></font></td>
					    <td align="center" width="25%"><font size="8">PT. GRAHA USAHA TEKNIK</font></td>
					  </tr>

                  </tbody>
                </table>
                <br pagebreak="true"/>';

            $html .= '<table width="100%" cellspacing="0" cellpadding="5" border="1" >
					  <tr>
					  ';
$jml_kolom = 3;

$cnt = 0;
foreach ($data['slip09'] as $row) {
    if ($cnt >= $jml_kolom) {
        $html .= '</tr><tr>';
        $cnt = 0;
    }

    $cnt++;
                       $html .= '
                                <td width="32%" align=center>       
                                <div>
                                    <img src=  "' . BASEURL . $row['images_location'] . '"  width="480" height="240">
                                </div>     
                                <div>
                                    '.$row['CAPTION'].'
                                </div>  
                                </td>
                                            ';

		}

		$html .= '</tr>

                </table>';
$pdf->SetFont('', '', 9); // default font header
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->output();