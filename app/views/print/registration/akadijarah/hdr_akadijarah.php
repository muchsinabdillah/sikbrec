<?php
 $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

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
$pdf->Cell(125, 4, '', 0, 0);
$pdf->SetFont('', '', 9);
$pdf->Cell(55, 4, 'No : 010/FRM/REG/RSY/Rev0/1/2020', 1, 1, 'L');
$pdf->Cell(0, 2, '', 0, 1);
$pdf->Cell(125, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Jl. Letjen Suprapto, Kav. 13 Cempaka Putih, ', 0, 1, 'L');
$pdf->Cell(125, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Jakarta Pusat 10510', 0, 1, 'L');
$pdf->Cell(125, 3, '', 0, 0);
$pdf->Cell(25, 3, 'Telp: 021-80618618, 80618619 (Hunting),', 0, 1, 'L');
$pdf->Cell(125, 3, '', 0, 0);
$pdf->Cell(25, 3, 'www.rsyarsi.co.id', 0, 1, 'L');


//make a dummy empty cell as a vertical spacer
$pdf->cell(0 ,10,'',0,1);//end of line

$pdf->setFont('','B',15);
$pdf->Cell(0 ,4,'AKAD IJARAH MULTIJASA PELAYANAN',0,1,'C');//end of line

$pdf->cell(0 ,5,'',0,1);//end of line
$pdf->setFont('','B',12);
$pdf->Cell(0 ,4,'Nomor : 003/A/MGR-KEU/III/2021',0,1,'C');//end of line

// $pdf->Image('../public/images/bismillah.png',80,30,50,'C');
// $pdf->Ln(10);

$pdf->Cell(0,5,'',0,1);//br
$pdf->setFont('','',10);

$hari = date('l', strtotime($data['listdata1']['TglCreate']));
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

$h = 6;
//HEADER--------------------------
      //row 1 (left)-------------------
      $pdf->Cell(10,7,'',0,0);
      $pdf->Cell(0,$h,'Dengan menyebut nama Allah yang Maha Pengasih lagi Maha Penyayang',0,1);
      $pdf->Cell(0,2,'',0,1);//br
      
      $pdf->Cell(10,7,'',0,0);
      $pdf->Cell(0,$h,'Akad Ijarah ini ditandatangani pada hari, '.$day.' '.$data['listdata1']['TglCreate'].' oleh dua pihak,',0,1);
      $pdf->Cell(0,5,'',0,1);//br

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'Nama',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->MultiCell(0,$h,$data['listdata1']['Petugas'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'Jabatan',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->Cell(0,$h,$data['listdata1']['Divisi'],0,1);
      $pdf->Cell(0,5,'',0,1);//br

      $pdf->Cell(10,7,'',0,0);
      $pdf->MultiCell(0,$h,'Bertindak untuk dan atas nama Rumah Sakit YARSI , yang beralamat di Jl. Letjen Suprapato Kav 13, Cempaka Putih, Jakarta Pusat untuk selanjutnya disebut sebagai Pihak I ( pertama ) dalam perjanjian ini dengan:',0,1);
      $pdf->Cell(0,2,'',0,1,'L');//br

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'Nama',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->MultiCell(0,$h,$data['listdata1']['NamaPenanggungJawab'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'Alamat',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->MultiCell(0,$h,$data['listdata1']['AlamatPenanggungJawab'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'No KTP',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->Cell(0,$h,$data['listdata1']['NoKtp'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'Pekerjaan',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->MultiCell(0,$h,$data['listdata1']['Pekerjaan'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'No Hp/Telepon',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->MultiCell(0,5,$data['listdata1']['NoHandphone'],0,1);//br
      $pdf->Cell(0,4,'',0,1);
      
      $pdf->Cell(10,7,'',0,0);
      $pdf->Cell(0,$h,'Bertindak atas '.$data['listdata1']['NamaJenisPenanngungJawab'].' atas nama :',0,1);
      $pdf->Cell(0,2,'',0,1);//br

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'Nama',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->MultiCell(0,$h,$data['listdata1']['NamaPasien'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'No. RM',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->Cell(0,$h,$data['listdata1']['NoRM'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'Jenis Kelamin',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->Cell(0,$h,$data['listdata1']['JenisKelamin'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'Tanggal Lahir',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->Cell(0,$h,$data['listdata1']['TangalLahir'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'NIK',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->Cell(0,$h,$data['listdata1']['NIKPasien'],0,1);

      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(30,$h,'Kamar',0,0);
      $pdf->Cell(4,$h,':',0,0);
      $pdf->MultiCell(0,5,$data['listdata1']['LokasiPasien'],0,1);//br
      $pdf->Cell(0,4,'',0,1);

      $pdf->Cell(10,7,'',0,0);
      $pdf->Cell(0,$h,'Untuk selanjutnya disebut sebagai Pihak II ( kedua )',0,1);
      $pdf->Cell(0,2,'',0,1);//br

      
      $h = 5;
      $pdf->Cell(10,7,'',0,0);
      $pdf->MultiCell(0,$h,'Dalam perjanjian ini kedua belah pihak dengan penuh kesadaran dan tanpa paksaan dari pihak manapun telah memahami maksud dan isi dari perjanjian ini dan sepakat mengadakan Perjanjian Ijarah untuk pelayanan kesehatan kepada pasien sebagaimana telah disebutkan di atas, dengan ketentuan dan syarat-syarat sebagai berikut :',0,1);
      $pdf->Cell(0,2,'',0,1);//br

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'1. ',0,0);
      $pdf->MultiCell(0,$h,'Pihak Pertama menyetujui untuk memberikan pelayanan kesehatan sesuai dengan Standar Prosedur Operasional di RS YARSI',0,1);
      $pdf->Cell(0,2,'',0,1);//br

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'2. ',0,0);
      $pdf->MultiCell(0,$h,'Pihak Kedua memberikan imbal jasa kepada Pihak Pertama dengan ketentuan sesuai dengan PERMENKES RI Nomor 51 Tahun 2018 sebagai berikut :',0,1);

      
      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'a. ',0,0);
      $pdf->MultiCell(0,$h,'Rawat Inap sesuai Hak kelas BPJS pihak kedua tidak dikenakan biaya.',0,1);

      $pdf->AddPage();

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'b. ',0,0);
      $pdf->MultiCell(0,$h,'Untuk peningkatan kelas pelayanan rawat inap dari kelas 3 ke kelas 2, dan dari kelas 2 ke kelas 1, harus membayar Selisih Biaya antara Tarif INA-CBG pada kelas rawat inap lebih tinggi yang dipilih dengan tariff INA-CBG pada kelas rawat inap yang sesuai dengan hak Peserta.',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'c. ',0,0);
      $pdf->MultiCell(0,$h,'Untuk peningkatan kelas pelayanan rawat inap di atas kelas 1, harus membayar Selisih Biaya paling banyak sebesar 75% ( tujuh puluh lima perseratus ) dari INACBG Kelas 1.',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'d. ',0,0);
      $pdf->MultiCell(0,$h,'Untuk peningkatan kelas pelayanan rawat inap kelas 2 naik 2 tingkat di atasnya, harus membayar selisih tarif INA-CBG antara kelas 1 dan kelas 2 serta ditambah selisih tarif INA-CBG kelas 1 paling banyak 75%.',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'e. ',0,0);
      $pdf->MultiCell(0,$h,'Untuk hak rawat kelas 3 baik Mandiri / PBI tidak dapat melakukan peningkatan kelas perawatan.',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'f. ',0,0);
      $pdf->MultiCell(0,$h,'Bersedia / Tidak Bersedia untuk penjaminan pembayaran dengan COB ( Pribadi / Asuransi / Perusahaan ).',0,1);
      $pdf->Cell(0,2,'',0,1);//br

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'3. ',0,0);
      $pdf->MultiCell(0,$h,'Pihak pertama menjelaskan mengenai peraturan sesuai dengan ketentuan',0,1);
      $pdf->Cell(20,7,'',0,0);
        $pdf->SetFont('','B',10);
                
      $pdf->MultiCell(170,$h,'PERMENKES RI Nomor 82 Tahun 2018 pasal 52 meliputi manfaat yang tidak dijamin oleh BPJS',0,1);
      $pdf->Cell(20,7,'',0,0);
      $pdf->Cell(18,$h,'Kesehatan',0,0,'L');
      $pdf->SetFont('','',10);
      $pdf->Cell(0,$h,', sebagai berikut :',0,1);
                //$pdf->Write($h,'PERMENKES RI Nomor 82 Tahun 2018 pasal 52 meliputi manfaat yang tidak dijamin oleh BPJS Kesehatan');

      $pdf->setFont('','B',10);
      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'1) ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan yang tidak dijamin meliputi :',0,1);

      $pdf->setFont('','',10);
      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'a. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan yang tidak sesuai dengan ketentuan peraturan perundang-undangan',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'b. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan yang dilakukan di Fasilitas Kesehatan yang tidak bekerja sama dengan BPJS Kesehatan, kecuali dalam keadaan darurat',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'c. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan terhadap penyakit atau cedera akibat kecelakaan kerja atau hubungan kerja yang telah dijamin oleh program jaminan Kecelakaan Kerja atau menjadi tanggungan Pemberi Kerja',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'d. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan yang dijamin oleh program jaminan kecelakaan lalu lintas yang bersifat wajib sampai nilai yang ditanggung oleh program jaminan kecelakaan lalu lintas sesuai hak kelas rawat peserta',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'e. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan yang dilakukan di luar negeri',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'f. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan untuk tujuan estetika',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'g. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan untuk mengatasi infertilitas',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'h. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan meratakan gigi atau ortodonsi',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'i. ',0,0);
      $pdf->MultiCell(0,$h,'Gangguan kesehatan / penyakit akibat ketergantungan obat dan / atau alcohol',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'j. ',0,0);
      $pdf->MultiCell(0,$h,'Gangguan kesehatan akibat sengaja menyakiti diri sendiri atau akibat melakukan hobi yang membahayakan diri sendiri',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'k. ',0,0);
      $pdf->MultiCell(0,$h,'Pengobatan komplementer, alternatif, dan tradisional, yang belum dinyatakan efektif berdasarkan penilaian teknologi kesehatan',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'l. ',0,0);
      $pdf->MultiCell(0,$h,'Pengobatan dan tindakan medis yang dikategorikan sebagai percobaan eksperimen',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'m. ',0,0);
      $pdf->MultiCell(0,$h,'Alat dan obat kontrasepsi, kosmetik',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'n. ',0,0);
      $pdf->MultiCell(0,$h,'Perbekalan kesehatan rumah tanggal',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'o. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan akibat bencana pada tanggap darurat, kejadian biasa / wabah',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'p. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan pada kejadian tak diharapkan yang dapat dicegah',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'q. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan yang diselenggarakan dalam rangka bakti social',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'r. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan akibat tindak pidana penganiayaan, kekerasan seksual, korban terorisme, dan tindak pidana perdagangan orang sesuai dengan ketentuan peraturan perundang-undangan',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'s. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan tertentu yang berkaitan dengan Kementerian Pertahanan, Tentara Nasional Indonesia, dan Kepolisian Negara Republik Indonesia',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'t. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan lainnya yang tidak ada hubungan dengan Manfaat Jaminan Kesehatan yang diberikan atau',0,1);

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'u. ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan yang sudah ditanggung dalam program lain',0,1);

      $pdf->setFont('','B',10);
      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'2) ',0,0);
      $pdf->MultiCell(0,$h,'Pelayanan kesehatan yang tidak sesuai dengan ketentuan peraturan perundang-undangan sebagaimana dimaksud pada ayat (1 ) huruf a meliputi rujukan atas permintaan sendiri dan pelayanan kesehatan lain yang tidak sesuai dengan ketentuan peraturan perundang-undangan.',0,1);
      
      $pdf->setFont('','B',10);
      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'',0,0);
      $pdf->Cell(5,$h,'3) ',0,0);
      $pdf->MultiCell(0,$h,'Gangguan kesehatan akibat sengaja menyakiti diri sendiri atau akibat melakukan hobi yang membahayakan diri sendiri sebagaimana dimaksud pada ayat (1 ) huruf j, pengobatan dan tindakan medis yang dikategorikan sebagai percobaan atau eksperimen sebagaimana dimaksud pada ayat (1) huruf l, dan kejadian tak diharapkan yang dapat dicegah sebagaimana dimaksud pada ayat (1) huruf p ditetapkan oleh Menteri',0,1);
      $pdf->Cell(0,2,'',0,1);//br
      
      $pdf->AddPage();

      $pdf->setFont('','',10);
      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'4. ',0,0);
      $pdf->MultiCell(0,$h,'Pihak Pertama menerbitkan kwitansi penerimaan imbal jasa sesuai jumlah yang diterima sebagai paket pelayanan tanpa perincian untuk perawatan sampai dengan VIP Reguler.',0,1);
      $pdf->Cell(0,2,'',0,1);//br

      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(5,$h,'5. ',0,0);
      $pdf->MultiCell(0,$h,'Pihak Kedua bersedia membayar tindakan dan perawatan Pribadi / Asuransi / Perusahaan dan tidak bisa mengubah penjamin / Alih penjaminan di tengah masa perawatan.',0,1);
      $pdf->Cell(0,5,'',0,1);//br

      $h = 5;
      $pdf->Cell(15,7,'',0,0);
      $pdf->Cell(50,$h,'Jakarta, '.$data['listdata1']['TglCreate'],0,1,'C');
      
    //   $pdf->Cell(0,3,'',0,1);//br
    //   $pdf->Cell(15,7,'',0,0);
    //   $pdf->Cell(50,$h,'Pihak II',0,0,'C');
    //   $pdf->Cell(65,$h,'',0,0);
    //   $pdf->Cell(50,$h,'Pihak I',0,1,'C');
      
    //   $pdf->Cell(137,15,'',0,0);//br

      
    // //$pdf->Image($h,$data['listdatasign']['IMAGE_PATH'].'.png',15,10,50);
    // $pdf->Image($data['listdatasign']['IMAGE_PATH'].'?ext=.png', 35, $pdf->getY(),35);
    // //$pdf->Cell(120,15,'',1,0);//br
    // $pdf->Image($data['listdatasign']['IMAGE_PATH2'].'?ext=.png', $pdf->getX(), $pdf->getY(),35);
    // $pdf->Cell(0,15,'',0,1);//br
    // $pdf->Cell(15,7,'',0,0);
    //   $pdf->Cell(50,$h,$data['listdatasign']['NAMA_PARAM_2'],0,0,'C');
    //   $pdf->Cell(65,$h,'',0,0);
    //   $pdf->Cell(50,$h,$data['listdatasign']['NAMA_PARAM_1'],0,1,'C');
    //   $pdf->Cell(15,7,'',0,0);
    //   $pdf->Cell(50,$h,'Pasien / Kel. Pasien',0,0,'C');
    //   $pdf->Cell(65,$h,'',0,0);
    //   $pdf->Cell(50,$h,'Petugas RS',0,1,'C');

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

    //QR CODE
    require_once("../App/library/phpqrcode/qrlib.php");
    $url = $data['listdata1']['uuid4'];
    $url_ext = "https://esigndocument.rsyarsi.co.id/edocakadijaroh/".$url;
    QRcode::png($url_ext, $url .".png");

        $html .= '<table width="100%" cellspacing="0" cellpadding="1" border="0" >
        <tbody> 
          <tr>
              <td></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
              <td align="center" width="25%"><font size="9">Pihak I</font></td>
              <td align="center" width="34%"><font size="9"></font></td>
              <td align="center" width="25%"><font size="9">Pihak II</font></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
              <td align="center" width="25%"><img src="'.$data['listdata1']['TTDPetugas'].'"  width="90" height="45"></td>
              <td align="center" width="34%"><img src="../public/'.$url.'.png"  width="60" height="60"></td>
              <td align="center" width="25%"><img src="'.$data['listdata1']['TTD_PasienWali'].'"  width="90" height="45"></td>
            </tr>

            <tr>
            <td align="center" width="10%"></td>
              <td align="center" width="25%"><font size="9">'.$data['listdata1']['Petugas'].'</font></td>
              <td align="center" width="34%"><font size="8">Scan this for validate.</font></td>
              <td align="center" width="25%"><font size="9">'.$data['listdata1']['NamaPenanggungJawab'].'</font></td>
            </tr>
             <tr>
             <td align="center" width="10%"></td>
             <td align="center" width="25%"><font size="9">'.$data['listdata1']['Divisi'].'</font></td>
              <td align="center" width="34%"><font size="9"></font></td>
              <td align="center" width="25%"><font size="9">Pasien / Kel. Pasien</font></td>
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
                  

//$pdf->Output();