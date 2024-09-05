<style type="text/css">
.signature-area {
    width: 304px;
    margin: 50px auto;
    border: 1px solid black;
}

.signature-container {
    width: 60%;
    margin: auto;
}

.signature-list {
    width: 150px;
    height: 50px;
    border: solid 1px #cfcfcf;
    margin: 10px 5px;
}

.title-area {
    font-family: cursive;
    font-style: oblique;
    font-size: 12px;
    text-align: left;
}

.btn-save {
    color: #fff;
    background: #1c84c6;
    /* padding: 0.25rem 0.5rem;
    font-size: 0.875rem; */
    line-height: 1.5;
    border-radius: 0.2rem;
    border: 1px solid transparent;
}

.btn-clear {
    color: #fff;
    background: #f7a54a;
    /* padding: 0.25rem 0.5rem;
    font-size: 0.875rem; */
    line-height: 1.5;
    border-radius: 0.2rem;
    border: 1px solid transparent;
}

.doc_preview {
	color: #777;
	font-size: 25px;
	font-family: "Roboto", Arial;
	line-height: 1.25em;
	padding: 0 0 1em 0;
	text-align: justify;
}
</style>
<div class="main-page">
    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30">e-AKAD IJARAH MULTIJASA PELAYANAN 
                                &nbsp&nbsp&nbsp
                                <!-- <button type="button"
                                                        name="btnHistory" id="btnHistory" class="btn btn-warning">Riwayat Dokumen
                                                    </button> -->
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form action="<?= BASEURL ?>/signatureDigital/SprtoPDF" method="POST" class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Episode/Registrasi</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="text" id="NoEpisode" readonly name="NoEpisode"  value="<?= $data['register']['NoEpisode'] ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="text" id="Noregis" readonly name="Noregis" value="<?= $data['register']['NoRegistrasi'] ?>">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Layanan/Ruangan</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="layanan" value="<?= $data['register']['LokasiPasien'] ?>" readonly name="layanan">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. MR</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="xnoMedrec" readonly name="xnoMedrec" value="<?= $data['register']['NoMR'] ?>">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> DPJP</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="dpjp" readonly name="dpjp" value="<?= $data['register']['namadokter'] ?>">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="xNamaPasien" readonly name="xNamaPasien" value="<?= $data['register']['PatientName'] ?>">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jaminan</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="xjaminan" readonly name="xjaminan" value="<?= $data['register']['Perusahaan'] ?>">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> TTL/Jenis Kelamin</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="text" id="xTglLahir" readonly name="xTglLahir" value="<?= $data['register']['Date_of_birth'] ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="text" id="JenisKelamin" readonly name="JenisKelamin"  value="<?= $data['register']['Gander'] ?>">
                                    </div> 
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Petugas</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="xPetugas" readonly name="xPetugas" value="<?= $data['session']->name ?>">
                                    </div>
                                </div>
                                    <div class="col-md-6 mt-25">
                                        <div class="panel panel-primary no-border">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Data Penanggung Jawab</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> Nama :</label>
                                                    <div class="col-sm-8"> 
                                                        <input class="form-control input-sm " id="nama" name="nama" type="text" required placeholder="Ketik Nama" >
                                                    </div> 
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> No. KTP :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control input-sm " id="pnj_noKTP" name="pnj_noKTP" type="text" required placeholder="Ketik NIK">
                                                    </div> 
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> Pekerjaan :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control input-sm " id="pnj_pekerjaan" name="pnj_pekerjaan" type="text" required placeholder="Ketik Pekerjaan">
                                                    </div> 
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> No. HP :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control input-sm " id="pnj_noHP" name="pnj_noHP" type="number" required placeholder="Ketik No. Handphone">
                                                    </div> 
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> Alamat :</label>
                                                    <div class="col-sm-8">
                                                    <textarea class="form-control input-sm " id="pnj_alamat" name="pnj_alamat" placeholder="Ketik Alamat"></textarea>
                                                    </div> 
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> Hubungan dengan Pasien :</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control input-sm " name="pnj_JenisOrang" id="pnj_JenisOrang" >
                                                        <option value="Diri Sendiri">Diri Sendiri</option>
                                                            <option value="Istri">Istri</option>
                                                            <option value="Suami">Suami</option>
                                                            <option value="Ayah">Ayah</option>
                                                            <option value="Ibu">Ibu</option>
                                                            <option value="Anak">Anak</option>
                                                            <option value="Kakak">Kakak</option>
                                                            <option value="Adik">Adik</option>
                                                            <option value="Teman">Teman</option>
                                                            <option value="Kerabat">Kerabat</option>
                                                            <option value="Lain-Lain">Lain-Lain</option>
                                                        </select>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-25">
                                        <div class="panel panel-success no-border">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Data Pasien</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> No RM  :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control input-sm " id="norm" name="norm" type="text" readonly required placeholder="Ketik No. MR" value="<?= $data['register']['NoMR'] ?>">
                                                    </div> 
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> Nama :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control input-sm " id="namapasien" name="namapasien" type="text" readonly required placeholder="Ketik Nama Pasien" value="<?= $data['register']['PatientName'] ?>">
                                                    </div> 
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> Jenis Kelamin :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control input-sm " id="jeniskelasmin" name="jeniskelasmin" type="text" readonly required placeholder="Ketik Jenis Kelamin" value="<?= $data['register']['Gander'] ?>">
                                                    </div> 
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> Tanggal Lahir :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control input-sm " id="tgllahir" name="tgllahir" type="date" required readonly placeholder="Ketik Nama" value="<?= $data['register']['Date_of_birth'] ?>">
                                                    </div> 
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> NIK :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control input-sm " id="nikpasien" name="nikpasien" type="text" readonly placeholder="Ketik Nama" value="<?= $data['register']['ID_Card_number'] ?>">
                                                    </div> 
                                                </div>
                                                <div class="form-group gut ">
                                                    <label for="inputEmail3" class="col-sm-4 control-label"> Kamar/Ruang Perawatan :</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control input-sm " id="kamar" name="kamar" type="text" required placeholder="Ketik Ruang Perawatan" readonly value="<?= $data['register']['LokasiPasien'] ?>">
                                                    </div> 
                                                </div> 
                                                
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-12">
                                        <h5 class="underline mt-30">Syarat dan Ketentuan Pelayanan <small> </small></h5>
                                        <div class="panel-group acc-panels" id="accordion5" role="tablist" aria-multiselectable="true">
                                        	<div class="panel panel-primary no-border">
                                        		<div class="panel-heading" role="tab" id="heading9One">
                                        			<h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion5" href="#collapse9One" aria-expanded="false" aria-controls="collapse9One" onclick="passData()">
                                                          <i class="fa fa-plus icon-plus"></i> Dengan ini saya menyatakan / I Declare (Review Document)
                                                        </a>
                                                    </h4>
                                        		</div>
                                        		<div id="collapse9One" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9One">

                                                <div class="panel-body">
                                                    Dengan menyebut nama Allah yang Maha Pengasih lagi Maha Penyayang<br>Akad Ijarah ini ditandatangani pada hari, <?= $data['hari'].' '.date('d/m/Y')?> oleh dua pihak
            <table width="100%" cellspacing="0" cellpadding="2" border="0" >
      <tbody> 

          <tr>
            <td align="left" width="30%"><font size="2">Nama<br></td>
            <td align="left" width="70%"><font size="4"><label id="NamaPetugas_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">Jabatan</td>
            <td align="left" width="70%"><font size="4"><label id="JabatanPetugas_tmp"></label></font></td>
          </tr>

      </tbody>
    </table>

    Bertindak untuk dan atas nama Rumah Sakit YARSI , yang beralamat di Jl. Letjen Suprapato Kav 13, Cempaka Putih, Jakarta Pusat untuk selanjutnya disebut sebagai <b>Pihak I ( pertama )</b> dalam perjanjian ini dengan:

    <table width="100%" cellspacing="0" cellpadding="2" border="0" >
      <tbody> 

          <tr>
            <td align="left" width="30%"><font size="2">Nama</td>
            <td align="left" width="70%"><font size="4"><label id="NamaPJawab_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">Alamat</td>
            <td align="left" width="70%"><font size="4"><label id="AlamatPJawab_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">No. KTP</td>
            <td align="left" width="70%"><font size="4"><label id="NoTKPPJawab_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">Pekerjaan</td>
            <td align="left" width="70%"><font size="4"><label id="PekerjaanPJawab_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">No Hp/Telepon</td>
            <td align="left" width="70%"><font size="4"><label id="NoHPPJawab_tmp"></label></font></td>
          </tr>

      </tbody>
    </table>

    Bertindak atas <b><span id="JenisTanggungJawab_tmp"></span></b> atas nama :

    <table width="100%" cellspacing="0" cellpadding="2" border="0" >
      <tbody> 

          <tr>
            <td align="left" width="30%"><font size="2">Nama</td>
            <td align="left" width="70%"><font size="4"><label id="NamaPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">No. RM</td>
            <td align="left" width="70%"><font size="4"><label id="NoMRPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">Jenis Kelamin</td>
            <td align="left" width="70%"><font size="4"><label id="GenderPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">Tgl Lahir</td>
            <td align="left" width="70%"><font size="4"><label id="DOBPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">NIK</td>
            <td align="left" width="70%"><font size="4"><label id="NIKPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="30%"><font size="2">Kamar</td>
            <td align="left" width="70%"><font size="4"><label id="KamarPasien_tmp"></label></font></td>
          </tr>

      </tbody>
    </table>

    Untuk selanjutnya disebut sebagai <b>Pihak II ( kedua )</b>

                                                    </div>


                                        			<div class="doc_preview">
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">Dalam perjanjian ini
                                                        kedua belah pihak dengan penuh kesadaan dan tanpa
                                                        paksaan dari pihak
                                                        manapun telah memahami maksud dan isi dari perjanjian ini dan sepakat
                                                        mengadakan Perjanjian Ijarah untuk pelayanan
                                                        kesehatan kepada pasien sebagaimana telah di sebutkan di atas, dengan
                                                        ketentuan dan syarat-syarat sebagai berikut :</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">1. &nbsp; Pihak
                                                        pertama
                                                        menyetujui untuk memberikan pelayanan kesehatan sesuai dengan Standar Prosedur
                                                        operasional di RS YARSI.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">2. &nbsp;Pihak Kedua
                                                        Memberikan imbal jasa kepada Pihak Pertama dengan ketentuan sesuai dengan
                                                        PERMENKES RI Nomor 51 Tahun 2008 Sebagai berikut :</h6>
                                                    <h6 style="margin-top:0px;margin-left:3em; margin-right:1em;">a. &nbsp;Rawat Inap
                                                        sesuai
                                                        Hak Kelas BPJS pihak kedua tidak dikenakan biaya.</h6>
                                                    <h6 style="margin-top:0px;margin-left:3em; margin-right:1em;">b. &nbsp;Untuk
                                                        peningkatan
                                                        kelas pelayanan rawat inap dari kelas 3 kek kelas 2, dan dari kelasd 2 ke kelas
                                                        1, harus membayar Selisih Biaya antara Tarif INA-CBG pada kelas rawat inap lebih
                                                        tinggi yang dipiih dengan tarif INA-CBG pada kelas rawat inap yang sesuai dengan
                                                        hak Peserta.</h6>
                                                    <h6 style="margin-top:0px;margin-left:3em; margin-right:1em;">c. &nbsp;Untuk
                                                        peningkatan
                                                        kelas pelayanan rawat inap di atas kelas 1, harus membayar Selisih Biaya paling
                                                        banyak sebesar 75%(tujuh puluh lima persen) dari INACBG kelas 1.</h6>
                                                    <h6 style="margin-top:0px;margin-left:3em; margin-right:1em;">d. &nbsp;Untuk peningkatan kelas pelayanan rawat inap kelas 2 naik 2 tingkat di atasnya, harus membayar selisih tarif INA-CBG antara kelas 1 dan kelas 2 serta ditambah selisih tarif INA-CBG kelas 1 paling banyak 75%.</h6>
                                                    <h6 style="margin-top:0px;margin-left:3em; margin-right:1em;">e. &nbsp;Untuk hak rawat kelas 3 baik Mandiri / PBI tidak dapat melakukan peningkatan kelas perawatan.</h6>
                                                    <h6 style="margin-top:0px;margin-left:3em; margin-right:1em;">f. &nbsp;Bersedia / Tidak Bersedia untuk penjaminan pembayaran dengan COB ( Pribadi / Asuransi / Perusahaan )</h6>

                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">3. &nbsp;Pihak pertama menjelaskan mengenai peraturan sesuai dengan ketentuan
                                                        PERMENKES RI Nomor 82 Tahun 2018 pasal 52 meliputi manfaat yang tidak dijamin oleh BPJS
                                                        Kesehatan, sebagai berikut :</h6>
                                                        <h6 style="margin-top:0px;margin-left:3em; margin-right:1em;"><b>1). &nbsp; Pelayanan kesehatan yang tidak dijamin meliputi :</b></h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">a. &nbsp;Pelayanan kesehatan yang tidak sesuai dengan ketentuan peraturan perundang-undangan.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">b. &nbsp;Pelayanan kesehatan yang dilakukan di Fasilitas Kesehatan yang tidak bekerja sama dengan
                                                                BPJS Kesehatan, kecuali dalam keadaan darurat.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">c. &nbsp;Pelayanan kesehatan terhadap penyakit atau cedera akibat kecelakaan kerja atau hubungan
                                                                kerja yang telah dijamin oleh program jaminan Kecelakaan Kerja atau menjadi tanggungan
                                                                Pemberi Kerja.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">d. &nbsp;Pelayanan kesehatan yang dijamin oleh program jaminan kecelakaan lalu lintas yang bersifat
                                                                wajib sampai nilai yang ditanggung oleh program jaminan kecelakaan lalu lintas sesuai hak
                                                                kelas rawat peserta.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">e. &nbsp;Pelayanan kesehatan yang dilakukan di luar negeri.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">f. &nbsp;Pelayanan kesehatan untuk tujuan estetika.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">g. &nbsp;Pelayanan untuk mengatasi infertilitas.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">h. &nbsp;Pelayanan meratakan gigi atau ortodonsi.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">i. &nbsp;Gangguan kesehatan / penyakit akibat ketergantungan obat dan / atau alcohol.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">j. &nbsp;Gangguan kesehatan akibat sengaja menyakiti diri sendiri atau akibat melakukan hobi yang
                                                                membahayakan diri sendiri.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">k. &nbsp;Pengobatan komplementer, alternatif, dan tradisional, yang belum dinyatakan efektif
                                                                berdasarkan penilaian teknologi kesehatan.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">l. &nbsp;Pengobatan dan tindakan medis yang dikategorikan sebagai percobaan eksperimen.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">m. &nbsp;Alat dan obat kontrasepsi, kosmetik.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">n. &nbsp;Perbekalan kesehatan rumah tangga.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">o. &nbsp;Pelayanan kesehatan akibat bencana pada tanggap darurat, kejadian biasa / wabah.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">p. &nbsp;Pelayanan kesehatan pada kejadian tak diharapkan yang dapat dicegah.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">q. &nbsp;Pelayanan kesehatan yang diselenggarakan dalam rangka bakti social.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">r. &nbsp;Pelayanan kesehatan akibat tindak pidana penganiayaan, kekerasan seksual, korban
                                                                terorisme, dan tindak pidana perdagangan orang sesuai dengan ketentuan peraturan
                                                                perundang-undangan.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">s. &nbsp;Pelayanan kesehatan tertentu yang berkaitan dengan Kementerian Pertahanan, Tentara
                                                                Nasional Indonesia, dan Kepolisian Negara Republik Indonesia.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">t. &nbsp;Pelayanan lainnya yang tidak ada hubungan dengan Manfaat Jaminan Kesehatan yang
                                                                diberikan atau.</h6>
                                                                <h6 style="margin-top:0px;margin-left:4em; margin-right:1em;">u. &nbsp;Pelayanan yang sudah ditanggung dalam program lain.</h6>
                                                            <h6 style="margin-top:0px;margin-left:3em; margin-right:1em;"><b>2). &nbsp;Pelayanan kesehatan yang tidak sesuai dengan ketentuan peraturan perundang-undangan
                                                            sebagaimana dimaksud pada ayat (1 ) huruf a meliputi rujukan atas permintaan sendiri dan
                                                            pelayanan kesehatan lain yang tidak sesuai dengan ketentuan peraturan perundangundangan.</b></h6> 
                                                            <h6 style="margin-top:0px;margin-left:3em; margin-right:1em;"><b>3). &nbsp;Gangguan kesehatan akibat sengaja menyakiti diri sendiri atau akibat melakukan hobi yang
                                                            membahayakan diri sendiri sebagaimana dimaksud pada ayat (1 ) huruf j, pengobatan dan
                                                            tindakan medis yang dikategorikan sebagai percobaan atau eksperimen sebagaimana
                                                            dimaksud pada ayat (1) huruf l, dan kejadian tak diharapkan yang dapat dicegah
                                                            sebagaimana dimaksud pada ayat (1) huruf p ditetapkan oleh Menteri.</b></h6> 
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">4. &nbsp;Pihak Pertama menerbitkan kwitansi penerimaan imbal jasa sesuai jumlah yang diterima sebagai
                                                            paket pelayanan tanpa perincian untuk perawatan sampai dengan VIP Reguler.</h6> 
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">5. &nbsp;Pihak Kedua bersedia membayar tindakan dan perawatan <b> Pribadi / Asuransi / Perusahaan </b> dan tidak
                                                            bisa mengubah penjamin / Alih penjaminan di tengah masa perawatan.</h6> 
                                                    <br>
                                        			</div>
                                        		</div>
                                        	</div> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkboxSyarat" onclick="checkTrue()">
                                                Saya Menyetujui Syarat & Ketentuan yang Berlaku di Rumah Sakit YARSI.
                                            </div>
                                    <h5 class="underline mt-40">Tanda Tangan Digital</h5>
                                    <div class="col-md-6">
                                        
                                        <div class="panel panel-primary no-border">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>PIHAK 1 ( Rumah Sakit )</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="rumahsakit">
                                                <div class="sig">
                                                    <div class="typed"></div>
                                                    <!-- <canvas class="" id="ttdrumahsakit" width="300" height="100"></canvas> -->
                                                    <embed src="" width="100px" height="100px" id="filettd" />
                                                </div>
                                                </div>
                                                <label for="inputPassword4">Nama Petugas</label>
                                                <div class="col-md-5"> 
                                                    <input type="hidden" class="form-control" name="idpetugas_ext" id="idpetugas_ext" readonly>
                                                    <input type="text" class="form-control" name="namapetugas_ext" id="namapetugas_ext" readonly>
                                        </div>
                                        <div class="col-md-2"> 
                                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#Modal_Approve" id="btnttd1" disabled>
                                                        Input PIN 
                                                    </button>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="panel panel-success no-border">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>PIHAK 2 ( Pasien / Keluarga Pasien )</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="copysignature" id="pasienttd">
                                                <div class="sig">
                                                    <div class="typed"></div>
                                                        <canvas class="" id="gbrttdsaksipasien" width="300"
                                                            height="100"></canvas>
                                                    </div>
                                                </div>
                                                <label for="inputPassword4" id="namajelas">Nama Jelas</label>
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#saksipasien" id="btnttd2" disabled>
                                                    Input Tanda Tangan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="saksi_rumah_sakit" id="saksi_rumah_sakit">
                                    <input type="hidden" name="saksi_pasien" id="saksi_pasien">
                                    <!-- <div class="col-md-12 mt-10"> 
                                        <P>Saya Menyetujui Syarat & Ketentuan yang Berlaku di Rumah Saki YARSI.</p>
                                    
                                    </div> -->
                                    <div class="panel-body">
                                  <h6>Dokumen ini dinyatakan sah setelah ditandatangani.<br>Dokumen akan dikirmkan ke alamat email dan no whatsapp berikut.</h6>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-1 control-label"><i class="fa fa-whatsapp" style="font-size:18px"></i> No. HP</label>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" type="text" id="nohp_send" name="nohp_send"  value="<?= $data['register']['NoHP'] ?>" placeholder="contoh: 081334233123" inputmode="numeric">
                                        </div>
                                    </div>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-1 control-label"><i class="fa fa-envelope" style="font-size:18px"></i> Email</label>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" type="text" id="email_send" name="email_send"  value="<?= $data['register']['Email'] ?>" placeholder="contoh: namapasien@gmail.com">
                                            <input class="form-control input-sm" type="hidden" id="email_send_backup" name="email_send_backup"  value="<?= $data['register']['Email'] ?>" >
                                        </div>
                                        <div class="form-check">
                                                <label>
                                                <input class="form-check-input" type="checkbox" id="ceklis_noemailx" onclick="ceklis_noemail()">
                                                Ceklis jika tidak punya email</label>
                                            </div>
                                    </div>
                                    <!-- <h6>jika ada perubahan data untuk kirim e-dokumen ini (No. HP atau Email) akan diperbarui ke data sosial pasien dan semua yang telah diinput akan tersimpan di database Rumah Sakit Yarsi.</h6> -->
                                    <h6>Semua yang telah diinput akan tersimpan di database Rumah Sakit Yarsi.</h6>
                                </div>
                                    <div class="col-md-12 mt-10"> 
                                    <button type="button"
                                                        name="tandatangan" id="tandatangan" class="btn btn-primary" disabled><i
                                                            class="fa fa-save"></i>
                                                        SIMPAN DAN KIRIM
                                                    </button>  
                                        <!-- <a onclick="MyBack()" class="btn btn-warning waves-effect"
                                            id="btnBack" name="btnBack"><span class="glyphicon glyphicon glyphicon-home"
                                                aria-hidden="true"></span>
                                            Kembali</a> -->
                                    </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.section -->
</div>
<div class="modal fade" id="saksipasien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PIHAK 2 ( Pasien / Keluarga Pasien )</h5>
            </div>
            <div class="modal-body">
                <div class="signature-area" id="ttdsaksipasien">
                    <!-- <h2 class="title-area">Put signature,</h2> -->
                    <!-- <label>nama</label> -->
                    <!-- <input type="text" name="nama" id="nama"> -->
                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-save" id="btn-save">Save</button>
                <button class="btn-clear" id="clearttdrumahsakit">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="saksirumahsakit" tabindex="-1" role="dialog" aria-labelledby="saksirumahsakit"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PIHAK 1 ( Rumah Sakit )</h5>
            </div>
            <div class="modal-body">
                Silahkan tanda tangan di dalam kotak
                <div class="signature-area"> 
                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="canvasttdsaksi" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="ttdsaksirumahsakit btn-save">Save</button>
                <button class="btn-clear">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSend" tabindex="-1" role="dialog" aria-labelledby="modalrumahsakit"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kirim Document e-Akad Ijaroh</h5>
            </div>
            <div class="modal-body">
            <div class="row">
                    <div class="col-sm-6">
                        <input type="hidden" id="param_id" name="param_id"></>
                        <p class="text-center"><strong>Send WhatsApp</strong></p><br>
                        <form id="TheForm" method="post" action="halaman/Print/print_bukti_reg.php" target="TheWindow">
                            <input type="hidden" name="cetaknoregis" id="cetaknoregis" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/sosmed/whatsapp.Png" id="whatsapp" class="img-circle" alt="Random Name" width="150" height="150">
                    </div>
                    <div class="col-sm-6">
                        <p class="text-center"><strong>Send Email </strong></p><br>
                        <img src="<?= BASEURL; ?>/images/sosmed/email.png" id="sendmail" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button class="ttdsaksirumahsakit btn-save">Save</button>
                <button class="btn-clear">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHistory" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Riwayat Dokumen</h5>
            </div>
            <div class="modal-body">
            <div class="demo-table" width="100%" id="tbl_rekap" style="margin-top: 10px;overflow-x:auto;">
            <table id="tbl_arsip" class="table table-striped table-hover cell-border">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate_sign</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> AwsUrlDocuments</th>
                                                           <th align='center'> uuid4</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
            </div>
            </div>

            <div class="modal-footer">
                    <button type="button" class="btn btn-gray" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal Approve ------------------------------------------------>
<div class="modal fade" id="Modal_Approve" tabindex="-1" role="dialog">

<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Saksi Rumah sakit</h4>
        </div>
    <br>
        <div class="panel-body">
            <form class="form-horizontal">
               <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-2 control-label">No PIN:</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="nopin" id="nopin" placeholder="Isi No PIN Anda dan Tekan Enter" inputmode="numeric">
                    </div>
                    <div class="col-sm-1">
                    <button type="button" class="btn btn-sm btn-default" id='btnpinttd' onclick="goGetApproveName()">Enter</button>
                    </div>
                   
                </div>

                <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-2 control-label">Nama:</label>   <div class="col-sm-2">
                        <input type="text" class="form-control" name="nopin_ext" id="nopin_ext" readonly>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="nama_ext" id="nama_ext" readonly>
                    </div>
                </div>

                <div class="form-group gut">  
                <label for="inputEmail3" class="col-sm-3 control-label">Digital Sign:</label>
                <div class="col-sm-7">
                <embed src="" width="100px" height="100px" id="file" />

                </div>
                </div>
                    
            </form>
        </div>
        <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary btn-sm " id="btnSearching" name="btnSearching" onclick="goSaveApprove()"> Simpan</button> -->
            <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
        </div>

        <!--#END Modal Approve--------------------------------------------->
    </div>
</div>
<!-- /.col-md-12 -->
</div>


<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script>
let iduser = ` <?= $data['session']->username ?>`
let namauser = ` <?= $data['session']->name ?>`
</script>
<script>
$(document).ready(function() {
    $(".btn-clear").click(function(e) {
        $(".signature-area").signaturePad().clearCanvas();
    });
    $("#clearttdrumahsakit").click(function(e) {
        $("#ttdsaksipasien").signaturePad().clearCanvas();
        console.log('clear')
    });
    $(".signature-area").signaturePad({
        penColour: '#000000',
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 90,
        lineWidth: 0,
        validateFields: true,
    })

});
</script>

<script src="<?= BASEURL; ?>/js/App/SPR/spr.js"></script>
<script src="<?= BASEURL; ?>/js/App/SPR/signaturespr.js"></script>