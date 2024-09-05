<?php
 $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

 date_default_timezone_set('Asia/Jakarta');
 $datenow = Date("d/m/Y");
 $pdf->setPrintHeader(false);
 $pdf->setPrintFooter(false);
 //$pdf->SetAutoPageBreak(false);
 $pdf->AddPage();
 $pdf->Ln(-5);

// cell(widht, height, text, border, end line , [ALIGN] )
$pdf->Cell(125, 4, '', 0, 0);
$pdf->SetFont('', '', 9);
$pdf->Cell(55, 4, 'No : 010/FRM/REG/RSY/Rev0/1/2020', 1, 1, 'L');



// $pdf->Image('../public/images/bismillah.png',80,30,50,'C');
// $pdf->Ln(10);

$pdf->Cell(0,5,'',0,1);//br
$pdf->setFont('','',10);

// $hari = date('l', strtotime($data['listdata1']['TglCreate']));
//                     if ($hari == 'Sunday'){
//                         $day = 'Minggu';
//                     }elseif($hari == 'Monday'){
//                         $day = 'Senin';
//                     }elseif($hari == 'Tuesday'){
//                         $day = 'Selasa';
//                     }elseif($hari == 'Wednesday'){
//                         $day = 'Rabu';
//                     }elseif($hari == 'Thursday'){
//                         $day = 'Kamis';
//                     }elseif($hari == 'Friday'){
//                         $day  = 'Jumat';
//                     }elseif($hari == 'Saturday'){
//                         $day = 'Sabtu';
//                     }

$h = 6;


      $html='';
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

        $html .= '<table width="100%" cellspacing="0" cellpadding="5" border="1" >
        <tbody> 

            <tr>
            <td align="center" width="30%"><img src="../public/images/yarsi.png"  width="120" height="45"></td>
              <td align="center" width="30%"><font size="11"><b>RS YARSI</b><br>JL. Letjen Suprapto Cempaka Putih, Jakarta 10510</font></td>
              <td align="center" width="40%"><font size="11"><b>PERSETUJUAN UMUM RAWAT INAP / GENERAL CONSENT</b></font></td>
            </tr>

        </tbody>
      </table>';

      $jm_pribadi = '';
      $jm_bpjs = '';
      $jm_perusahaan = '';
      $jm_asuransi = '';

      if ($data['listdata1']['jaminan_pribadi'] == 1){
        $jm_pribadi = 'Pribadi ';
      }

      if ($data['listdata1']['jaminan_bpjs'] == 1){
        $jm_bpjs = 'Dijamin oleh BPJS ';
      }

      if ($data['listdata1']['jaminan_perusahaan'] == 1){
        $jm_perusahaan = 'Dijamin oleh Perusahaan ';
      }

      if ($data['listdata1']['jaminan_asuransi'] == 1){
        $jm_asuransi = 'Dijamin oleh Asuransi ';
      }

      $html .= '<table width="100%" cellspacing="0" cellpadding="4" border="0.1" >
      <tbody> 

          <tr>
          <td align="left" width="100%"><u>Saya yang bertanda tangan di bawah ini adalah pasien / wali pasien </u><br><b><i>This is to certify as a patient trusty</b></i></td>
          </tr>

          <tr>
          <td align="left" width="10%"><u>Nama :</u><br><b><i>Name</b></i></td>
          <td align="left" width="40%">'.$data['listdata1']['NamaPenanggungJawab'].'</td>
          <td align="left" width="10%"><u>Gender: '.$data['listdata1']['JenisKelamin_Inisial'].'</u><br><b><i>Sex '.$data['listdata1']['JenisKelamin_Eng'].'</b></i></td>
          <td align="left" width="10%"><u>Umur :</u><br><b><i>Age</b></i></td>
          <td align="left" width="20%">'.$data['listdata1']['Tahun'].'</td>
          <td align="left" width="10%">Tahun<br></td>
          </tr>

          <tr>
          <td align="left" width="10%"><u>Alamat :</u><br><b><i>Address</b></i></td>
          <td align="left" width="50%">'.$data['listdata1']['AlamatPenanggungJawab'].'</td>
          <td align="left" width="15%"><u>No. Telp</u><br><b><i>Telephone</b></i></td>
          <td align="left" width="25%">'.$data['listdata1']['NoHandphone'].'</td>
          </tr>

          <tr>
          <td align="left" width="25%"><u>Hubungan dengan pasien :</u><br><b><i>Relationship to the patient</b></i></td>
          <td align="left" width="75%">'.$data['listdata1']['NamaJenisPenanngungJawab'].'</td>
          </tr>

          <tr>
          <td align="left" width="100%"><u>Bahwa karena penyakit yang diderita pasien, dengan ini menyatakan sesungguhnya telah memberikan PERSETUJUAN untuk dilakukan perawatan di Unit Perawatan / Pelayanan rawat jalan **)</u><br><b><i>About the illness that the patient has been suffered, I declare that I give consent for patient’s treatment in the service unit.</b></i></td>
          </tr>

          <tr>
          <td align="left" width="100%"><u>Terhadap Pasien :</u><br><b><i>For the Patient</b></i></td>
          </tr>

          <tr>
          <td align="left" width="10%"><u>Nama :</u><br><b><i>Name</b></i></td>
          <td align="left" width="40%">'.$data['listdata1']['NamaPasien'].'</td>
          <td align="left" width="10%"><u>Gender: '.$data['listdata1']['JenisKelaminPasien'].'</u><br><b><i>Sex '.$data['listdata1']['JenisKelaminPasienEng'].'</b></i></td>
          <td align="left" width="15%"><u>Tgl Lahir :</u><br><b><i>Date of Birth</b></i></td>
          <td align="left" width="25%">'.$data['listdata1']['TangalLahirPasien'].'</td>
          </tr>

          <tr>
          <td align="left" width="10%"><u>No RM :</u><br><b><i>MR Number</b></i></td>
          <td align="left" width="40%">'.$data['listdata1']['NoRMPasien'].'</td>
          <td align="left" width="10%"><u>Agama</u><br><b><i>Religion</b></i></td>
          <td align="left" width="40%">'.$data['listdata1']['AgamaPasien'].'</td>
          </tr>

          <tr>
          <td align="left" width="10%"><u>Alamat :</u><br><b><i>Address</b></i></td>
          <td align="left" width="50%">'.$data['listdata1']['AlamatPasien'].'</td>
          <td align="left" width="15%"><u>No. Telp</u><br><b><i>Telephone</b></i></td>
          <td align="left" width="25%">'.$data['listdata1']['NoHPPasien'].'</td>
          </tr>

          <tr>
          <td align="left" width="25%"><u>No. Tanda Pengenal '.$data['listdata1']['JenisPengenalPasien'].': </u><br><b><i>Identity number.</b></i></td>
          <td align="left" width="75%">'.$data['listdata1']['NIKPasien'].'</td>
          </tr>

          <tr>
          <td align="left" width="37%"><u>Pembayaran tagihan selama perawatan : </u><br><b><i>Bill payment during treatment</b></i></td>
          <td align="left" width="63%">'.$jm_pribadi.$jm_bpjs.$jm_perusahaan.$jm_asuransi.$data['listdata1']['jaminan_namaPerusahaan'].'</td>
          </tr>

      </tbody>
    </table>
    <br pagebreak="true"/>';

    $html .= '
    <table width="100%" cellspacing="0" cellpadding="5" border="0" >
        <tbody> 

        <tr>
        <td align="left" width="100%"><img src="../public/images/yarsi.png"  width="120" height="45"></td>
        </tr>

        <br><br>
            <tr>
            <td align="left" width="100%">Saya juga menyatakan <b><i>( I declare ) </b></i>:</td>
            </tr>

            <tr>
              <td align="left" width="5%">1. </td>
              <td align="left" width="95%">Saya mengetahui bahwa saya memiliki kondisi yang membutuhkan perawatan medis, saya mengizinkan dokter dan profesional kesehatan lainnya untuk melakukan prosedur diagnostik dan untuk memberikan pengobatan medis seperti yang diperlukan dalam penilaian profesional mereka. Prosedur diagnostik dan perawatan medis <u>termasuk terapi tidak terbatas</u> pada electrocardiograms, x-rays, tes darah terapi fisik, dan pemberian obat,pemasangan NGT, Kateterd dll. Tindakan yang berisiko tinggi akan saya berikan persetujuan secara tertulis diluar persetujuan ini. <b><i>( I know that I have conditions that require medical care, I allow doctors and other health professionals to perform diagnostic procedures and to provide medical treatment as required in their professional assessment. medical diagnostic and treatment procedures including, not limited to, electrocardiograms, x-rays, physical therapy therapies, and drug delivery. A high-risk action will grant written consent outside this general agreement ).</b></i></td>
            </tr>

            <tr>
              <td align="left" width="5%">2. </td>
              <td align="left" width="95%">Sudah mendapat informasi dan membaca peraturan / tata tertib dan persyaratan kelengkapan administrasi pasien yang akan di rawat jalan RS Yarsi, juga hak dan kewajiban sebagai pasien dan sudah memahaminya serta bersedia mematuhi semua peraturan. <b><i>( Have been informed and read the rules / rules and requirements of administrative proficiency of patients who will be hospitalized in Rs Yrasi, as well as the rights and obligations as a patient and have understood it and are willing to comply with all regulations ).</b></i></td>
            </tr>

            <tr>
              <td align="left" width="5%">3. </td>
              <td align="left" width="95%">'.$data['listdata1']['consen_kuasa'].' memberi KUASA kepada Rumah Sakit untuk melepas informasi medis saya/pasien bila diperlukan untuk keperluan pengurusan asuransi atau keperluan lain sesuai aturan yang berlaku. <b><i>( '.$data['listdata1']['consen_kuasa_eng'].' authorizing the hospital to release my medical / patient information when necessary for insurance or other purposes as required ).</b></i></td>
            </tr>

            <tr>
              <td align="left" width="5%">4. </td>
              <td align="left" width="95%">'.$data['listdata1']['consen_kondisiPasien'].' petugas Rumah Sakit menginformasikan segala sesuatu yang berhubungan dengan kondisi kesehatan saya kepada keluarga : suami / istri / anak / saudara kandung / orangtua *). <b><i>( '.$data['listdata1']['consen_kondisiPasien_eng'].' hospital officials inform everything related to my health condition to the family : husband / wife / child / sibling / parent ).</b></i></td>
            </tr>';

            $html .= '
    <table width="100%" cellspacing="0" cellpadding="2" border="1" >
        <tbody> 

        <tr>
        <td align="center" width="20%">Suami</td>
        <td align="center" width="20%">Istri</td>
        <td align="center" width="20%">Anak</td>
        <td align="center" width="20%">Saudara Kandung</td>
        <td align="center" width="20%">Orangtua</td>
        </tr>';

        foreach ($data['listdata2'] as $key){
          $html.= '
          <tr>
          <td align="center" width="20%">'.$key['Keluarga_Suami'].'</td>
          <td align="center" width="20%">'.$key['Keluarga_Istri'].'</td>
          <td align="center" width="20%">'.$key['Keluarga_Anak'].'</td>
          <td align="center" width="20%">'.$key['Keluarga_SaudaraKandung'].'</td>
          <td align="center" width="20%">'.$key['Keluarga_Orangtua'].'</td>
          </tr>
          ';
        }

        $html .= '
        </tbody>
        </table>
        ';

            $html .= '
            <tr>
            <td align="left" width="100%"></td>
          </tr>
            <tr>
              <td align="left" width="5%">5. </td>
              <td align="left" width="95%">Bersedia membayar penuh biaya tindakan yang tidak ditanggung oleh asuransi / perusahaan atau biaya non medis seperti: telephone / fax, supplemen, obat herbal, minyak kayu putih, makanan extra, tissue, underpad dll. ( khusus untuk peserta Asuransi / pasien Perusahaan yang bekerja sama dengan RS Yarsi ). <b><i>( Willing to pay the full cost of the action not covered by the insurance / company or non-medical costs such as telephone, fax, supplement, herbal medicine, eucalyptus oil, extra food, tissue, underpad and others (especially for insurance participants / with Rs Yarsi )</b></i></td>
            </tr>

            <tr>
              <td align="left" width="5%">6. </td>
              <td align="left" width="95%">Bersedia menerima segala sanksi dan konsekuensi yang terjadi apabila tidak mematuhi peraturan yang berlaku di RS Yarsi yang sudah saya setujui dan tanda tangani. <b><i>( Willing to accept any sanctions that occur if not obey the rules that apply in rs yarsi that I have agreed and sign ).</b></i></td>
          </tr>

          <tr>
          <td align="left" width="5%">7. </td>
          <td align="left" width="95%">Bersedia sebagai contact person terhadap hal-hal yang berhubungan dengan pasien. <b><i>( Willing as a person contact to the things related to the patient ).</b></i></td>
      </tr>

        <tr>
        <td align="left" width="5%">8. </td>
        <td align="left" width="95%">Dapat memahami tindakan kedokteran pada keadaan gawat darurat dalam rangka menyelamatkan jiwa pasien, tanpa didahului permintaan persetujuan sebelumnya. <b><i>( Can understand the medical action in emergency situations in order to save the soul of the patient, without prior request for prior approval ).</b></i></td>
    </tr>

    <tr>
        <td align="left" width="5%">9. </td>
        <td align="left" width="95%">Saya bertanggung jawab atas kehilangan, kerusakan dan pencurian terhadap barang berharga yang saya bawa selama menjalankan perawatan. <b><i>( I am responsible for the loss, damage and theft of the valuables I carry during the course of the maintenance ).</b></i></td>
    </tr>
    <br><br>

    <tr>
    <td align="left" width="5%">10. </td>
    <td align="left" width="95%">Telah menerima informasi dan menyetujui tata cara mengajukan dan mengatasi keluhan terkait pelayanan medis yang dilakukan terhadap diri saya. <b><i>( Have received information and approved the procedure for filing and resolving complaints related to medical services performed on self ).</b></i></td>
</tr>

  <tr>
      <td align="left" width="5%"></td>
      <td align="left" width="8%">10.1 </td>
      <td align="left" width="87%">PELAYANAN KESEHATAN : Pelayanan Kesehatan di rumah sakit atas indikasi medis, meliputi preventif, promotive, Kuratif, dan rehabilitatief ( a.i. pemeriksaan umum, pemeriksaan rontgen / radiologi, pemeriksaan Laboratorium, pengobatan rutin, perawatan, retapi bermain pada anak, prosedur pemasangan infus, Kateter, nasogatric tube / NGT, suntikan dan evaluasi ). <b><i>( Hospital health services are performed on medical indications, including preventive, promotive, curative and rehabilitative ( i.e. general examinations, X-ray / radiology examinations, laboratory test, routine traetment, treatment, playground therapy in children, infusion procedure, catheter, nasogastric tube / NGT, injections and evaluation ).</b></i></td>
  </tr>

  <tr>
      <td align="left" width="5%"></td>
      <td align="left" width="8%">10.2 </td>
      <td align="left" width="87%"><b>PELAYANAN SYARIAH UNTUK PASIEN MUSLIM / MUSLIMAH</b> <br> Dengan ini saya menyetujui pelayanan syariah yang diberikan oleh petugas rumah sakit meliputi :</td>
  </tr>

  <tr>
  <td align="left" width="5%"></td>
  <td align="left" width="8%"></td>
  <td align="left" width="4%">a. </td>
  <td align="left" width="83%">Penjagaan aurat dengan pemakaian hijab, penutup dada ibu menyusui, menutup tirai pada saat tindakan / pemeriksaan.</td>
</tr>

<tr>
<td align="left" width="5%"></td>
<td align="left" width="8%"></td>
<td align="left" width="4%">b. </td>
<td align="left" width="83%">Penjagaan thoharoh dengan pendamping wudhu atau tayamum.</td>
</tr>

    <tr>
    <td align="left" width="5%"></td>
    <td align="left" width="8%"></td>
    <td align="left" width="4%">c. </td>
    <td align="left" width="83%">Penjagaan ibadah dengan bersedia diingatkan untuk melaksanakan sholat pada waktu sholat dan bersedia didampingi petugas kerohanian bila memerlukan.</td>
    </tr>

    <tr>
      <td align="left" width="5%"></td>
      <td align="left" width="8%"></td>
      <td align="left" width="4%">d. </td>
      <td align="left" width="83%">Penjagaan khalwat dan ihtilat dengan bersedia selama perawatan ditunggu oleh keluarga ( mahramnya )</td>
    </tr>

    <tr>
    <td align="left" width="5%"></td>
    <td align="left" width="8%"></td>
    <td align="left" width="4%">e. </td>
    <td align="left" width="83%">Bersedia mengikuti kebijakan halal gizi dengan tidak menggunakan peralatan makan untuk makanan selain yang disajikan oleh rumah sakit.</td>
  </tr>

  <tr>
  <td align="left" width="5%"></td>
  <td align="left" width="8%"></td>
  <td align="left" width="4%">f. </td>
  <td align="left" width="83%">Pelayanan sakaratul maut, bersedia untuk pendamping sakaratul maut ( talqin )</td>
</tr>

<tr>
    <td align="left" width="5%">11. </td>
    <td align="left" width="95%">INFORMASI DAN RAHASIA KESEHATAN PASIEN :</td>
</tr>

<tr>
<td align="left" width="5%"></td>
<td align="left" width="8%">11.1 </td>
<td align="left" width="87%">Memberi kuasa kepada setiap tenaga kesehatan yang merawat pasien untuk memeriksa dan atau memberitahukan informasi kesehatan pasien kepada pemberi pelayanan kesehatan lain yang turut merawat selama di Rumah Sakit. <b><i>( Authorize each health worker who treats the patient to check and / or notify the patient’s health information to other health care providers who take care of while in the hospital ).</b></i></td>
</tr>

<tr>
<td align="left" width="5%"></td>
<td align="left" width="8%">11.2 </td>
<td align="left" width="87%">Pelepasan informasi kesehatan pasien dan resume medis kepada perusahaan penjamin biaya / perusahaan / asuransi/verifikator asuransi keperluan klaim asuransi hanya dapat dilakukan apabila perusahaan penjamin biaya/perusahaan asuransi / verifikator asuransi telah bekerjasama dengan Rumah Sakit. Dalam hal perusahaan penjamin biaya/perusahaan asuransi / verifikator asuransi tidak bekerjasama dengan Rumah Sakit maka informasi medis dn resume medis dapat diberikan berdasarkan permohonan tertulis / surat kuasa dari pasien / keluarga / wali pasien. <b><i>( Release of patient  health information and medical resume to the guarantor company the cost/insurance company / insurance verifier for insurance claim needs can only be made if the cost guarantee company/insurance company / insurance verifier has cooperated with the hospital. In the event that the guarantor company / insurance company / insurance verifier does not cooperate with the Hospital, medical information and medical resume can be provided based on a written application / power of attoney form the patient / family / guardian of the patient ).</b></i></td>
</tr>

<tr>
    <td align="left" width="5%">12. </td>
    <td align="left" width="95%">'.$data['listdata1']['consen_aksesKeluarga'].' Rumah Sakit memberikan akses bagi keluarga dan orang lain yang akan mengunjungi / menemui saya. ( sebutkan nama / profesi bila ada permintaan khusus : '.$data['listdata1']['consen_privasiKhusus_add'].' <br><b><i>( '.$data['listdata1']['consen_aksesKeluarga_eng'].' hospital giving access to families and others who will visit / meet me. Please specify the name / profession if ther is a special request )</b></i></td>
</tr>

<tr>
    <td align="left" width="5%">13. </td>
    <td align="left" width="95%">Saya '.$data['listdata1']['consen_privasiKhusus'].' Privasi Khusus. Sebutkan bila ada permintaan Privasi Khusus :  <b><i>( '.$data['listdata1']['consen_privasiKhusus_eng'].' Special Privacy. Please specify if there is a special privacy reguest )</b></i>'.$data['listdata1']['consen_privasiKhusus_add'].'</td>
</tr>

<tr>
    <td align="left" width="5%">14. </td>
    <td align="left" width="95%">KELUHAN : Saran / Keluhan terkait pelayanan Rumah Sakit tetap mengedepankan musyawarah dan mencari solusi. <b><i>( Suggestions / Complaints realted to Hospital services still prioritize deliberation and find solutions )</b></i></td>
</tr>

<tr>
    <td align="left" width="5%">15. </td>
    <td align="left" width="95%">RUMAH SAKIT SEBAGAI RUMAH SAKIT PENDIDIKAN : Rumah sakit merupakan rumah sakit pendidikan dan menjadi tempat praktik klinik bagi mahasiswa kedokteran dan profesi lain, oleh karena itu mahasiswa terlibat dalam proses pemberian pelayanan kesehatan kepada pasien. <b><i>( The Hospital is an Education hospital and is aclinical pratice place for medical students and other professions, therefore students are involved in the process of providing health services to patients ).</b></i></td>
</tr>

<tr>
    <td align="left" width="5%">16. </td>
    <td align="left" width="95%"><b>NILAI-NILAI KEPERCAYAAN ( '.$data['listdata1']['consen_nilaikepercayaan'].' ), Sebutkan : '.$data['listdata1']['consen_nilaikepercayaan_add'].'</b></td>
</tr>

        </tbody>
      </table>';

      //QR CODE
      require_once("../App/library/phpqrcode/qrlib.php");
      $url = $data['listdata1']['uuid4'];
      $url_ext = "https://esigndocument.rsyarsi.co.id/edocgenconsen/".$url;
      QRcode::png($url_ext, $url .".png");

      $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
        <tbody> 
          <tr>
              <td></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
            <td align="center" width="25%"><font size="10">Diterima oleh,<br><b><i>Received by</b></i></font></td>
              <td align="center" width="34%"><font size="10"></font></td>
              <td align="center" width="25%"><font size="10">Pasien / Wali <br><b><i>Patient / Family Patient </b></i></font></td>
              
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
              <td align="center" width="34%"><font size="10"></font></td>
              <td align="center" width="25%"><font size="10">'.$data['listdata1']['NamaPenanggungJawab'].'</font></td>
            </tr>
             <tr>
             <td align="center" width="10%"></td>
              <td align="center" width="25%"><font size="9">'.$data['listdata1']['Divisi'].'</font></td>
              <td align="center" width="34%"><font size="8">Scan this for validate</font></td>
              <td align="center" width="25%"><font size="9"></font></td>
            </tr>

        </tbody>
      </table>';


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

unlink($url.".png");

    // $h = 5;

    // $pdf->Image('../public/images/yarsi.png',15,10,50);
    // $pdf->Ln(15);
    // $pdf->Cell(5,$h,'',0,0);

    // $pdf->Cell(5,$h,'',0,0);
    // $pdf->Cell(5,$h,'11. ',0,0);
    // $pdf->MultiCell(0,$h,'INFORMASI DAN RAHASIA KESEHATAN PASIEN :',0,1);

    // $pdf->Cell(10,$h,'',0,0);
    // $pdf->Cell(8,$h,'11.1 ',0,0);
    // $pdf->MultiCell(0,$h,'Memberi kuasa kepada setiap tenaga kesehatan yang merawat pasien untuk memeriksa dan atau memberitahukan informasi kesehatan pasien kepada pemberi pelayanan kesehatan lain yang turut merawat selama di Rumah Sakit. ( Authorize each health worker who treats the patient to check and / or notify the patient’s health information to other health care providers who take care of while in the hospital ).',0,1);

    // $pdf->Cell(10,$h,'',0,0);
    // $pdf->Cell(8,$h,'11.2 ',0,0);
    // $pdf->MultiCell(0,$h,'Pelepasan informasi kesehatan pasien dan resume medis kepada perusahaan penjamin biaya / perusahaan / asuransi/verifikator asuransi keperluan klaim asuransi hanya dapat dilakukan apabila perusahaan penjamin biaya/perusahaan asuransi / verifikator asuransi telah bekerjasama dengan Rumah Sakit. Dalam hal perusahaan penjamin biaya/perusahaan asuransi / verifikator asuransi tidak bekerjasama dengan Rumah Sakit maka informasi medis dn resume medis dapat diberikan berdasarkan permohonan tertulis / surat kuasa dari pasien / keluarga / wali pasien. ( Release of patient  health information and medical resume to the guarantor company the cost/insurance company / insurance verifier for insurance claim needs can only be made if the cost guarantee company/insurance company / insurance verifier has cooperated with the hospital. In the event that the guarantor company / insurance company / insurance verifier does not cooperate with the Hospital, medical information and medical resume can be provided based on a written application / power of attoney form the patient / family / guardian of the patient ).',0,1);

    // $pdf->Cell(5,$h,'',0,0);
    // $pdf->Cell(5,$h,'12. ',0,0);
    // $pdf->MultiCell(0,$h,'Mengijinkan / tidak mengijinkan*) Rumah Sakit memberikan akses bagi keluarga dan orang lain yang akan mengunjungi / menemui saya. ( sebutkan nama / profesi bila ada permintaan khusus  : ................................................................................................................................................................................ ( Allowing / not allowing. hospital giving access to families and others who will visit / meet me. Please specify the name / profession if ther is a special request ) :...........................................................................',0,1);

    // $pdf->Cell(5,$h,'',0,0);
    // $pdf->Cell(5,$h,'13. ',0,0);
    // $pdf->MultiCell(0,$h,'Saya menginginkan / tidak menginginkan*) Privasi Khusus. Sebutkan bila ada permintaan Privasi Khusus : ........................................................................................................................................................................... ( I want /do not want) Special Privacy. Please specify if there is a special privacy reguest ) : ......................',0,1);

    // $pdf->Cell(5,$h,'',0,0);
    // $pdf->Cell(5,$h,'14. ',0,0);
    // $pdf->MultiCell(0,$h,'KELUHAN : Saran / Keluhan terkait pelayanan Rumah Sakit tetap mengedepankan musyawarah dan mencari solusi. ( Suggestions / Complaints realted to Hospital services still prioritize deliberation and find solutions )',0,1);

    // $pdf->Cell(5,$h,'',0,0);
    // $pdf->Cell(5,$h,'15. ',0,0);
    // $pdf->MultiCell(0,$h,'RUMAH SAKIT SEBAGAI RUMAH SAKIT PENDIDIKAN : Rumah sakit merupakan rumah sakit pendidikan dan menjadi tempat praktik klinik bagi mahasiswa kedokteran dan profesi lain, oleh karena itu mahasiswa terlibat dalam proses pemberian pelayanan kesehatan kepada pasien. ( The Hospital is an Education hospital and is aclinical pratice place for medical students and other professions, therefore students are involved in the process of providing health services to patients ).',0,1);

    // $pdf->Cell(5,$h,'',0,0);
    // $pdf->Cell(5,$h,'16. ',0,0);
    // $pdf->MultiCell(0,$h,'NILAI-NILAI KEPERCAYAAN ( ADA / TIDAK ), Sebutkan : ....',0,1);
    // $pdf->Cell(5,1,'',0,1);

    
    // $pdf->Cell(15,7,'',0,0);
    // $pdf->Cell(50,$h,'Jakarta, '.date('d/m/Y'),0,1,'C');

//$pdf->Output();