<?php
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

date_default_timezone_set('Asia/Jakarta');
$datenow = Date("d/m/Y");
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false);
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
					    <td align="center" width="100%"><font size="14"><b>PERKIRAAN BIAYA PERAWATAN NON OPERASI</font></b></td>
					  </tr>

                      <tr>
                      <td></td>
                    </tr>

                      <tr>
                      <td width="5%"></td>
					    <td width="95%"><font size="10"><b>IDENTITAS PASIEN :</font></b></td>
					  </tr>

            <tr>
                      <td width="5%"></td>
					    <td width="25%"><font size="10">Nama</font></td>
					    <td width="2%">:</td>
					    <td width="58%"><font size="10">'.$data['listdata1']['NamaPasien'].'</font></td>
					  </tr>

            <tr>
                      <td width="5%"></td>
					    <td width="25%"><font size="10">No. RM</font></td>
					    <td width="2%">:</td>
					    <td width="58%"><font size="10">'.$data['listdata1']['NoMR'].'</font></td>
					  </tr>

            <tr>
                      <td width="5%"></td>
					    <td width="25%"><font size="10">Rencana Perawatan</font></td>
					    <td width="2%">:</td>
					    <td width="58%"><font size="10">'.$data['listdata1']['RencanaPerawatan'].'</font></td>
					  </tr>

            <tr>
                      <td width="5%"></td>
					    <td width="25%"><font size="10">Diagnosa Medis</font></td>
					    <td width="2%">:</td>
					    <td width="58%"><font size="10">'.$data['listdata1']['DiagnosaMedis'].'</font></td>
					  </tr>

            <tr>
              <td width="5%"></td>
              <td width="25%"><font size="10">DPJP</font></td>
              <td width="2%">:</td>
              <td width="58%"><font size="10">'.$data['listdata1']['DPJP'].'</font></td>
            </tr>

            <tr>
              <td width="5%"></td>
              <td width="25%"><font size="10">Kamar Perawatan / Kelas</font></td>
              <td width="2%">:</td>
              <td width="58%"><font size="10">'.$data['listdata1']['KamaPerawatan'].' / '.$data['listdata1']['Kelas'].'</font></td>
            </tr>

            <tr>
              <td width="5%"></td>
              <td width="25%"><font size="10">Perkiraan Lama Rawat</font></td>
              <td width="2%">:</td>
              <td width="58%"><font size="10">'.$data['listdata1']['PerkiraanLamaRawat'].'</font></td>
            </tr>

            <tr>
                      <td></td>
                    </tr>

            <tr>
                      <td width="5%"></td>
					    <td width="95%"><font size="10"><b>PERKIRAAN BIAYA :</font></b></td>
					  </tr>

            <tr>
            <td width="10%"></td>
            <td width="20%"><font size="10">- RUMAH SAKIT</font></td>
            <td width="2%">:</td>
            <td width="5%">1. </td>
            <td width="20%">Kamar Perawatan </td>
            <td width="2%">:</td>
            <td width="7%">@ Rp.</td>
            <td width="11%" align="right">'.number_format($data['listdata1']['RS_KamarPerawatan'],0,',','.').'</td>
            <td width="4%"></td>
            <td width="19%">'.$data['listdata1']['RS_KamarPerawatan_ket'].'</td>
          </tr>

          <tr>
            <td width="10%"></td>
            <td width="20%"></td>
            <td width="2%"></td>
            <td width="5%">2. </td>
            <td width="20%">Kamar Intensive Care</td>
            <td width="2%">:</td>
            <td width="7%">@ Rp.</td>
            <td width="11%" align="right">'.number_format($data['listdata1']['RS_KamarIntensive'],0,',','.').'</td>
            <td width="4%"></td>
            <td width="19%">'.$data['listdata1']['RS_KamarIntensive_ket'].'</td>
          </tr>

          <tr>
          <td width="10%"></td>
          <td width="20%"></td>
          <td width="2%"></td>
          <td width="5%">3. </td>
          <td width="20%">Laboratorium</td>
          <td width="2%">:</td>
          <td width="7%">± Rp.</td>
          <td width="11%" align="right">'.number_format($data['listdata1']['RS_Lab'],0,',','.').'</td>
            <td width="4%"></td>
          <td width="19%">'.$data['listdata1']['RS_Lab_ket'].'</td>
        </tr>

        <tr>
        <td width="10%"></td>
        <td width="20%"></td>
        <td width="2%"></td>
        <td width="5%">4. </td>
        <td width="20%">Radiologi</td>
        <td width="2%">:</td>
        <td width="7%">± Rp.</td>
        <td width="11%" align="right">'.number_format($data['listdata1']['RS_Radiologi'],0,',','.').'</td>
            <td width="4%"></td>
        <td width="19%">'.$data['listdata1']['RS_Radiologi_ket'].'</td>
      </tr>

      <tr>
      <td width="10%"></td>
      <td width="20%"></td>
      <td width="2%"></td>
      <td width="5%">5. </td>
      <td width="20%">Farmasi</td>
      <td width="2%">:</td>
      <td width="7%">± Rp.</td>
      <td width="11%" align="right">'.number_format($data['listdata1']['RS_Farmasi'],0,',','.').'</td>
            <td width="4%"></td>
      <td width="19%">'.$data['listdata1']['RS_Farmasi_ket'].'</td>
    </tr>

    <tr>
    <td width="10%"></td>
    <td width="20%"></td>
    <td width="2%"></td>
    <td width="5%">6. </td>
    <td width="20%">BHP di perawatan</td>
    <td width="2%">:</td>
    <td width="7%">± Rp.</td>
    <td width="11%" align="right">'.number_format($data['listdata1']['RS_BHP'],0,',','.').'</td>
            <td width="4%"></td>
    <td width="19%">'.$data['listdata1']['RS_BHP_ket'].'</td>
  </tr>

  <tr>
    <td width="10%"></td>
    <td width="20%"></td>
    <td width="2%"></td>
    <td width="5%">7. </td>
    <td width="20%">Administrasi</td>
    <td width="2%">:</td>
    <td width="7%">± Rp.</td>
    <td width="11%" align="right">'.number_format($data['listdata1']['RS_Administrasi'],0,',','.').'</td>
            <td width="4%"></td>
    <td width="19%">'.$data['listdata1']['RS_Administrasi_ket'].'</td>
  </tr>


  <tr>
                      <td></td>
                    </tr>


  <tr>
  <td width="10%"></td>
  <td width="20%"><font size="10">- JASA DOKTER</font></td>
  <td width="2%">:</td>
  <td width="5%">1. </td>
  <td width="20%">Visite DPJP</td>
  <td width="2%">:</td>
  <td width="7%">@ Rp.</td>
  <td width="11%" align="right">'.number_format($data['listdata1']['JD_VisiteDPJP'],0,',','.').'</td>
            <td width="4%"></td>
  <td width="19%">'.$data['listdata1']['JD_VisiteDPJP_ket'].'</td>
</tr>

<tr>
  <td width="10%"></td>
  <td width="20%"></td>
  <td width="2%"></td>
  <td width="5%">2. </td>
  <td width="20%">Visite di Intensive Care</td>
  <td width="2%">:</td>
  <td width="7%">@ Rp.</td>
  <td width="11%" align="right">'.number_format($data['listdata1']['JD_VisiteIntesive'],0,',','.').'</td>
            <td width="4%"></td>
  <td width="19%">'.$data['listdata1']['JD_VisiteIntesive_ket'].'</td>
</tr>

<tr>
  <td width="10%"></td>
  <td width="20%"></td>
  <td width="2%"></td>
  <td width="5%">3. </td>
  <td width="20%">Visite Konsul Anastesi</td>
  <td width="2%">:</td>
  <td width="7%">@ Rp.</td>
  <td width="11%" align="right">'.number_format($data['listdata1']['JD_VisiteKonsulAnestesi'],0,',','.').'</td>
            <td width="4%"></td>
  <td width="19%">'.$data['listdata1']['JD_VisiteKonsulAnestesi_ket'].'</td>
</tr>

<tr>
  <td width="10%"></td>
  <td width="20%"></td>
  <td width="2%"></td>
  <td width="5%">4. </td>
  <td width="20%">Visite Konsul Internis</td>
  <td width="2%">:</td>
  <td width="7%">@ Rp.</td>
  <td width="11%" align="right">'.number_format($data['listdata1']['JD_VisiteKonsulInternis'],0,',','.').'</td>
            <td width="4%"></td>
  <td width="19%">'.$data['listdata1']['JD_VisiteKonsulInternis_ket'].'</td>
</tr>


<tr>
<td width="12%"></td>
<td width="45%" align="right"><font size="10"><b>Jumlah</b></font></td>
<td width="2%">:</td>
<td width="7%" align="left"><b> Rp. </b></td>
<td width="11%" align="right"><b>'.number_format($data['listdata1']['Jumlah'],0,',','.').'</b></td>
</tr>

<tr>
                      <td width="5%"></td>
					    <td width="95%"><font size="10">Keterangan :</font></td>
					  </tr>

            <tr>
                      <td width="10%"></td>
                      <td width="5%">1. </td>
					    <td width="85%"><font size="10">Rincian Biaya perawatan tersebut bersifat fleksibel, dapat bertambah / berubah berdasarkan kondisi pasien saat perawatan.</font></td>
					  </tr>

            <tr>
                      <td width="10%"></td>
                      <td width="5%">2. </td>
					    <td width="85%"><font size="10">Biaya tersebut dapat berubah sewaktu-waktu tanpa adanya pemberitahuan terlebih dahulu.</font></td>
					  </tr>

            <tr>
            <td width="10%"></td>
        </tr>

            <tr>
            <td width="10%"></td>
            <td width="20%">Keterangan Lainnya: </td>
          <td width="70%"><font size="10">'.$data['listdata1']['KeteranganLainnya'].'</font></td>
        </tr>

            <tr>
            <td></td>
          </tr>
          
        <tr>
        <td width="13%"></td>
<td width="25%" >Jakarta, '.$data['listdata1']['TglCreate_sign'].'</td>
</tr>

                  </tbody>
                </table>';

                //QR CODE
       require_once("../App/library/phpqrcode/qrlib.php");
       $url = $data['listdata1']['uuid4'];
       $url_ext = "https://esigndocument.rsyarsi.co.id/edocbiayanonoperasi/".$url;
       QRcode::png($url_ext, $url .".png");

                $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
        <tbody> 
          <tr>
              <td></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
              <td align="center" width="25%"><font size="10">Di Buat oleh, </font></td>
              <td align="center" width="34%"><font size="9"></font></td>
              <td align="center" width="25%"><font size="10">Diterima dan di pahami</font></td>
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
              <td align="center" width="34%"></td>
              <td align="center" width="25%"></td>
            </tr>

        </tbody>
      </table>';

            
$pdf->SetFont('', '', 10); // default font header
$pdf->writeHTML($html, true, false, true, false, '');
unlink($url.".png");

//$pdf->output();
