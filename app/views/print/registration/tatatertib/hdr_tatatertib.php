<?php
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y");
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//$pdf->SetAutoPageBreak(false);
$pdf->AddPage();


      //$certificate = 'file://'. __DIR__ .'/your/relative/path/to/this/file/tcpdf.crt'; 
            $certificate2 = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.crt'; 
                $key = 'file://'.$_SERVER["DOCUMENT_ROOT"] .'SIKBREC/public/server.key';
               
        $info = array(
                         'Name' => 'TCPDF',
                         'Location' => 'Office',
                         'Reason' => 'Testing TCPDF',
                         'ContactInfo' => 'http://www.tcpdf.org',
                         );

      $pdf->setSignature($certificate2, $key, 'tcpdfdemo', '', 2, $info);

      
$pdf->Cell(135, 4, '', 0, 0);
$pdf->SetFont('', '', 9);
$pdf->Cell(55, 4, 'No : 010/FRM/REG/RSY/Rev0/1/2020', 1, 1, 'L');
//$pdf->Ln(5);

//$resolution = array(210, 80);
$html='';
// $pdf->AddPage('P');
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
					    <td width="60%"><img src="../public/images/yarsi.png"  width="140" height="50"></td>
                        <td width="40%">Jl. Letjen Suprapto, Kav. 13 Cempaka Putih,<br>Jakarta Pusat 10510<br>Telp: 021-80618618, 80618619 (Hunting), <br>www.rsyarsi.co.id
                        </td>
					  </tr>
					  <tr>
					    <td width="20%"></td>
					    <td align="center" width="60%"><font size="14"><b>TATA TERTIB PASIEN</font></b></td>
					    <td width="20%"></td>
					  </tr>

                      <tr>
                      <td></td>
                    </tr>

                      <tr>
                      <td width="5%"></td>
					    <td width="90%"><font size="10"><b>BAGI PASIEN, KELUARGA PASIEN & PENGUNJUNG</font></b></td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">1. </td>
					    <td width="82%">Pasien, Keluarga / Penjaga pasien dan pengunjung harap menjaga keamanan barang bergharga milik pribadi dari risiko hilang atau rusak.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">2. </td>
					    <td width="82%">Rumah Sakit tidak bertanggungjawab atas segala bentuk kehilangan dan kerusakan barang barang milik pasien, keluarga dan pengunjung.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">3. </td>
					    <td width="82%">Kerusakan barang barang milik Rumah Sakit yang disebabkan oleh pasien, keluarga / penunggu dan pengunjung menjadi tanggung jawab pasien.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">4. </td>
					    <td width="82%">Pasien, keluarga / penjaga pasien dan pengunjung tidak boleh membawa/mengambil barang barang milik Rumah Sakit</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">5. </td>
					    <td width="82%">Rumah Sakit berhak memindahkan pasien ke kamar lain sesuai dengan kelas perawatan dan penyakit pasien.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">6. </td>
					    <td width="82%">Pasien, Keluarga / Penjaga pasien dan pengunjung tidak boleh membawa atau mengirimkan makanan yang mengandung makanan tidak halal (mengandung babi, dll).</td>
					  </tr>

            <tr>
                      <td width="8%"></td>
                      <td width="5%">7. </td>
					    <td width="82%">Penjagaan aurat dengan pemakaian  hijab, penutup dada ibu menyusui, menutup tirai pada saat tindakan / pemeriksaan.</td>
					  </tr>

            <tr>
                      <td width="8%"></td>
                      <td width="5%">8. </td>
					    <td width="82%">Penjagaan thoharoh dengan pendamping wudhu atau tayamum.</td>
					  </tr>

            <tr>
            <td width="8%"></td>
            <td width="5%">9. </td>
    <td width="82%">Penjagaan ibadah dengan bersedia diingatkan untuk melaksanakan sholat pada waktu sholat dan bersedia didampingi petugas kerohanian bila memerlukan.</td>
  </tr>

        <tr>
        <td width="8%"></td>
        <td width="5%">10. </td>
      <td width="82%">Penjagaan khalwat dan ihtilat dengan bersedia selama perawatan ditunggu oleh keluarga ( mahramnya ).</td>
      </tr>

      <tr>
      <td width="8%"></td>
      <td width="5%">11. </td>
    <td width="82%">Bersedia mengikuti kebijakan halal gizi dengan tidak menggunakan peralatan makan untuk makanan selain yang disajikan oleh rumah sakit.</td>
    </tr>

    <tr>
    <td width="8%"></td>
    <td width="5%">12. </td>
  <td width="82%">Pelayanan sakaratul maut, bersedia untuk pendamping sakaratul maut ( talqin ).</td>
  </tr>

                      <tr>
                      <td></td>
                    </tr>

                      <tr>
                      <td width="5%"></td>
					    <td width="90%"><font size="10"><b>BAGI KELUARGA PASIEN / PENUNGGU PASIEN</font></b></td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">1. </td>
					    <td width="82%">Selama menjalani masa perawatan, pasien boleh dijaga oleh 1 ( satu ) orang dengan memakai identitas penunggu pasien. Kartu identitas pasien dapat ditukar di bagian Administrasi IGD lantai 1.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">2. </td>
					    <td width="82%">Jika penunggu pasien ingin berganti dengan yang lain, harap dilakukan penukaran kartu tunggu di bagian Administrasi dan Billing.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%"></td>
					    <td width="15%">Jam penukaran :</td>
					    <td width="67%">Pagi : 07.00 – 21.00 WIB ( di bagian Billing Lantai 2 )<br>Malam : 21.00 – 07.00 WIB ( di bagian Admiistrasi IGD Lantai 1 )</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">3. </td>
					    <td width="82%">Dilarang menempati tempat tidur pasien/tempat tidur pasien yang kosong untuk tidur, duduk , atau menempatkan barang-barang.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">4. </td>
					    <td width="82%">Dilarang merokok, minum-minuman keras dan membawa senjata tajam.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">5. </td>
					    <td width="82%">Tidak dibenarkan membawa barang-barang berharga.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">6. </td>
					    <td width="82%">Diwajibkan untuk menjaga kebersihan, ketenangan & keamanan di dalam ruangan.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">7. </td>
					    <td width="82%">Harap membuang sampah di tempat yang telah disediakan.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">8. </td>
					    <td width="82%">Harus menggunakan alas kaki.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">9. </td>
					    <td width="82%">Harus menggunakan masker bagi yang menderita saluran pernafasan & menunggu pasien dengan sakit saluran pernafasan.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">10. </td>
					    <td width="82%">Tidak menggunakan tikar dan sejenisnya di Rumah Sakit</td>
					  </tr>

                      <tr>
                      <td></td>
                    </tr>

                      <tr>
                      <td width="5%"></td>
					    <td width="90%"><font size="10"><b>BAGI PENUNGGU PASIEN</font></b></td>
					  </tr>
                      
                      <tr>
                      <td width="8%"></td>
                      <td width="5%">1. </td>
					    <td width="15%">Jam berkunjung :</td>
					    <td width="67%">Pagi : 11.00 – 13.00 WIB<br>Siang : 17.00 – 19.00 WIB</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">2. </td>
					    <td width="82%">Tidak diperkenankan membawa anak berusia dibawah 13 tahun.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">3. </td>
					    <td width="82%">Dilarang menempati tempat tidur pasien maupun tempat tidur yang kosong.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">4. </td>
					    <td width="82%">Dilarang merokok, minum-minum keras & membawa senjata tajam di lingkungan Rumah Sakit.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">5. </td>
					    <td width="82%">Harap membuang sampah di tempat yang telah di sediakan.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">6. </td>
					    <td width="82%">Bila masuk ke kamar pasien lakukan secara bergantian.</td>
					  </tr>

                      <tr>
                      <td width="8%"></td>
                      <td width="5%">7. </td>
					    <td width="82%">Harus menggunakan alas kaki.</td>
					  </tr>

                      <tr>
                         <td width="75%"></td>
					    <td width="25%" >Jakarta, '.$data['listdata1']['TglCreate_sign'].'</td>
					  </tr>

                  </tbody>
                </table>';

                //QR CODE
    require_once("../App/library/phpqrcode/qrlib.php");
    $url = $data['listdata1']['uuid4'];
    $url_ext = "https://esigndocument.rsyarsi.co.id/edoctatatertib/".$url;
    QRcode::png($url_ext, $url .".png");

                $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
        <tbody> 
          <tr>
              <td></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
            <td align="center" width="25%"><font size="10"><b>Petugas</font></b></td>
              <td align="center" width="34%"><font size="9"></font></td>
              <td align="center" width="25%"><font size="10"><b>Wali / Pasien</font></b></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
              <td align="center" width="25%"><img src="'.$data['listdata1']['TTDPetugas'].'"  width="90" height="45"></td>
              <td align="center" width="34%"><img src="../public/'.$url.'.png"  width="60" height="60"></td>
              <td align="center" width="25%"><img src="'.$data['listdata1']['TTD_PasienWali'].'"  width="90" height="45"></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
              <td align="center" width="25%"><font size="10">'.$data['listdata1']['Petugas'].'</font></td>
              <td align="center" width="34%"><font size="8">Scan this for validate.</font></td>
              <td align="center" width="25%"><font size="10">'.$data['listdata1']['NamaWaliPasien'].'</font></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
              <td align="center" width="25%"><font size="10">'.$data['listdata1']['Divisi'].'</font></td>
              
            </tr>

        </tbody>
      </table>';

            
$pdf->SetFont('', '', 10); // default font header
$pdf->writeHTML($html, true, false, true, false, '');
unlink($url.".png");

//$pdf->output();
