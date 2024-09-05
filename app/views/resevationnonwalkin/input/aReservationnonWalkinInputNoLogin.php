<?php
date_default_timezone_set('Asia/Jakarta');
$id = "";
$datenowcreate = date("Y-m-d");
$datetimenow2222 = date("Y-m-d\TH:i:s");

?>
<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi
                                    </small></h5>

                            </div>

                            <div class="alert alert-success alert-dismissible">
                                <p> <strong>Info !</strong> Jika ada perubahan data Rekam Medik Seperti Alamat, tgl
                                    lahir, dan lain-lain silahkan rubah dari menu Medical record dan refresh kembali
                                    halaman ini</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <h5 class="underline mt-30">Data Pasien Berobat (SIMRS)</h5>
                                <div class="form-group  asdas">
                                    <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>">
                                    <input class="form-control input-sm " id="iswalkin" readonly name="iswalkin" type="hidden" value="<?= $data['iswalkin'] ?>">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Sudah Punya No MR <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="nomormr" id="nomormr" class="form-control input-sm" required>
                                            <option value="1">YA</option>
                                            <!-- <option value="1">Ya</option>
                                            <option value="0">Tidak</option> -->
                                        </select>
                                        <!-- <input class="form-control input-sm" type="hidden" id="TglNowTemp" value="<?= $datetimenow2222 ?>" readonly autocomplete="off" name="TglNowTemp"> -->
                                        <!-- <input class="form-control input-sm" type="text" id="PasienNoMR" autocomplete="off" name="PasienNoMR" placeholder="Scan barcode Here" onchange="showIDMxR();" autocomplete="off"> -->
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="jeniskelamin" id="jeniskelamin" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group nomrdanttl gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> NO. RM <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="Normpasien" readonly name="Normpasien" type="text" placeholder="Normpasien">

                                    </div>
                                    <div class="col-sm-2">
                                        <a href="#myModal" data-toggle="modal" class="btn btn-primary btn-sm btn-rounded " id="btn_caridatamr">
                                            <span class="glyphicon glyphicon glyphicon-search"></span></a>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> TTL Pasien <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="PasienUsia" name="PasienUsia" type="date" onchange="umurpasien(event)" placeholder="Ketik Usia Pasien">
                                    </div>
                                </div>
                                <div class="form-group namapasienusia gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="PasienNama" name="PasienNama" type="text" placeholder="Ketik Nama Pasien" onkeyup="namePatient()" required>
                                        <span id='errorPatienname'></span>

                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Usia <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="umur" name="umur" type="text" placeholder="Ketik Usia Pasien">
                                    </div>
                                </div>
                                <div class="form-group alamat gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat <sup class="color-danger">*</sup></label>
                                    <!-- <label for="inputEmail3" class="col-sm-2 control-label"> Alamat </label> -->
                                    <div class="col-sm-4">
                                        <textarea class="form-control input-sm" id="PasienAlamat" name="PasienAlamat" rows="2" style="resize: none" required></textarea>
                                        <!--
                                        *) Jika ada perubahan data Rekam Medik Seperti Alamat, tgl lahir, dan lain-lain silahkan rubah dari menu Medical record dan refresh kembali halaman ini
                                    -->
                                    </div>

                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Pekerjaan </label>
                                    <div class="col-sm-4">
                                        <select name="PasienPekerjaan" id="PasienPekerjaan" class="form-control">
                                            <option value='P N S'>P N S</option>
                                            <option value='I R T'>I R T</option>
                                            <option value='BURUH'>BURUH</option>
                                            <option value='PELAJAR'>PELAJAR</option>
                                            <option value='MAHASISWA'>MAHASISWA</option>
                                            <option value='WIRASWASTA'>WIRASWASTA</option>
                                            <option value='TIDAK BEKERJA'>TIDAK BEKERJA</option>
                                            <option value='PEDAGANG'>PEDAGANG</option>
                                            <option value='KARYAWAN/TI'>KARYAWAN/TI</option>
                                            <option value='SWASTA'>SWASTA</option>
                                            <option value='KARYAWAN RS'>KARYAWAN RS</option>
                                            <option value='PETANI'>PETANI</option>
                                            <option value='ZUSTER'>ZUSTER</option>
                                            <option value='BIDAN'>BIDAN</option>
                                            <option value='DOKTER'>DOKTER</option>
                                            <option value='TUKANG'>TUKANG</option>
                                            <option value='SOPIR'>SOPIR</option>
                                            <option value='DOSEN'>DOSEN</option>
                                            <option value='GURU'>GURU</option>
                                            <option value='BUMN'>BUMN</option>
                                            <option value='PENSIUNAN'>PENSIUNAN</option>
                                            <option value='ABRI'>ABRI</option>
                                            <option value='POLRI'>POLRI</option>
                                            <option value='NOTARIS'>NOTARIS</option>
                                            <option value='ADVOKAT'>ADVOKAT</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group alamat gut">
                                    <label for="namapasien" class="col-sm-2 control-label">Provinsi </label>
                                    <div class="col-sm-4">
                                        <select class="col-sm-10" name="Medical_Provinsi" id="Medical_Provinsi" style="width:100%">
                                        </select>


                                        <div id="error_Medical_Provinsi"></div>
                                    </div>

                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tanda Pengenal</label>
                                    <div class="col-sm-4">
                                        <select name="Medrec_IdPengenal" id="Medrec_IdPengenal" class="form-control" style="margin-bottom: 5px;">
                                            <option value='KTP'>KTP</option>
                                            <option value='SIM'>SIM</option>
                                            <option value='KTA'>KTA</option>
                                            <option value='KTM'>KTM</option>
                                            <option value='PASPORT'>PASPORT</option>
                                            <option value='KT PELAJAR'>KT PELAJAR</option>
                                            <option value='KIA'>KIA</option>

                                        </select>
                                    </div>

                                </div>

                                <div class="form-group alamat gut">

                                    <label for="namapasien" class="col-sm-2 control-label">Kab/Kodya </label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="Medrec_kabupaten" id="Medrec_kabupaten" style="width:100%">
                                        </select>
                                        <div id="error_Medrec_kabupaten"></div>
                                    </div>

                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nik </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="nik" name="nik" type="text" placeholder="Ketik (-) jika tidak ada" required>
                                    </div>

                                </div>

                                <div class="form-group alamat gut">

                                    <label for="namapasien" class="col-sm-2 control-label">Kecamatan </label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="Medrec_Kecamatan" id="Medrec_Kecamatan" style="width:100%">
                                        </select>
                                    </div>

                                    <label for="namapasien" class="col-sm-2 control-label">Tpt Lahir </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" autocomplete="off" id="Medrec_Tpt_lahir" name="Medrec_Tpt_lahir" type="text" placeholder="Ketik Tpt Lahir disini" class="containerX">
                                        <div id="error_Medrec_Tpt_lahir"></div>
                                    </div>

                                </div>

                                <div class="form-group alamat gut">

                                    <label for="namapasien" class="col-sm-2 control-label">Kelurahan </label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="Medrec_Kelurahan" id="Medrec_Kelurahan" style="width:100%">
                                        </select>
                                        <div id="error_Medrec_Kelurahan"></div>
                                    </div>

                                    <label for="namapasien" class="col-sm-2 control-label">Status Nikah <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="Medrec_statusNikah" id="Medrec_statusNikah" class="form-control">
                                            <option value='BELUM MENIKAH'>BELUM MENIKAH</option>
                                            <option value='NIKAH'>NIKAH</option>
                                            <option value='DUDA'>DUDA</option>
                                            <option value='JANDA'>JANDA</option>
                                            <option value='CERAI'>CERAI</option>
                                        </select>
                                        <div id="error_Medrec_statusNikah"></div>
                                    </div>



                                </div>



                                <div class="form-group alamat gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Home Phone </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="homephone" name="homephone" type="text" placeholder="Ketik Nomor TLP" required>
                                    </div>

                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Mobile Phone </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="mobilephone" name="mobilephone" type="text" placeholder="Ketik Mobile Phone Pasien" required>
                                    </div>
                                </div>

                                <div class="form-group alamat gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Email </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="email" name="email" type="text" placeholder="Ketik (-) jika tidak ada" required>
                                    </div>

                                    <label for="namapasien" class="col-sm-2 control-label">Agama </label>
                                    <div class="col-sm-4">
                                        <select name="Medical_Agama" id="Medical_Agama" class="form-control">
                                            <option value='Islam'>Islam</option>
                                            <option value='Katholik'>Katholik</option>
                                            <option value='Kristen Protestan'>Kristen Protestan</option>
                                            <option value='Budha'>Budha</option>
                                            <option value='Hindu'>Hindu</option>
                                            <option value='Konghucu'>Konghucu</option>
                                        </select>
                                        <div id="error_Medical_Agama"></div>
                                    </div>

                                </div>

                                <div class="form-group alamat gut">
                                    <label for="namapasien" class="col-sm-2 control-label">Bahasa </label>
                                    <div class="col-sm-4">
                                        <select name="Medrec_Bahasa" id="Medrec_Bahasa" class="form-control">
                                            <option value='BAHASA INDONESIA'>BAHASA INDONESIA</option>
                                            <option value='BAHASA DAERAH'>BAHASA DAERAH</option>
                                            <option value='BAHASA ASING'>BAHASA ASING</option>
                                        </select>
                                    </div>

                                    <label for="namapasien" class="col-sm-2 control-label">Warganegara </label>
                                    <div class="col-sm-4">
                                        <select name="Medrec_Warganegara" id="Medrec_Warganegara" class="form-control">

                                            <option value='WNI'>WNI</option>
                                            <option value='WNA'>WNA</option>
                                        </select>
                                        <div id="error_Medrec_Warganegara"></div>
                                    </div>
                                </div>

                                <div class="form-group alamat gut">
                                    <label for="namapasien" class="col-sm-2 control-label">Kodepos </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " autocomplete="off" id="Medrec_Kodepos" name="Medrec_Kodepos" type="text" placeholder="Ketik Kodepos disini" readonly>

                                    </div>

                                    <label for="namapasien" class="col-sm-2 control-label">Pendidikan </label>
                                    <div class="col-sm-4">
                                        <select name="Medrec_Pendidikan" id="Medrec_Pendidikan" class="form-control">
                                            <option value='Belum Sekolah'>Belum Sekolah</option>
                                            <option value='TK'>TK</option>
                                            <option value='SD'>SD</option>
                                            <option value='SMP'>SMP</option>
                                            <option value='SMU'>SMU</option>
                                            <option value='D1'>D1</option>
                                            <option value='D3'>D3</option>
                                            <option value='S1'>S1</option>
                                            <option value='S2'>S2</option>
                                            <option value='S3'>S3</option>
                                            <option value='Aktif TK'>Aktif TK</option>
                                            <option value='Aktif Aktif SD'>SD</option>
                                            <option value='Aktif SMP'>Aktif SMP</option>
                                            <option value='Aktif SMU'>Aktif SMU</option>
                                            <option value='Aktif D1'>Aktif D1</option>
                                            <option value='Aktif D2'>Aktif D2</option>
                                            <option value='Aktif D3'>Aktif D3</option>
                                            <option value='Aktif S1'>Aktif S1</option>
                                            <option value='Aktif S2'>Aktif S2</option>
                                            <option value='Aktif S3'>Aktif S3</option>
                                            <option value='Pesantren'>Pesantren</option>
                                            <option value='Tidak Sekolah'>Tidak Sekolah</option>
                                        </select>
                                        <div id="Medrec_Pendidikan"></div>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="namapasien" class="col-sm-2 control-label">Etnis </label>
                                    <div class="col-sm-4">
                                        <select name="Medrec_Etnis" id="Medrec_Etnis" class="form-control">
                                            <option value='JAWA'>JAWA</option>
                                            <option value='SUNDA'>SUNDA</option>
                                            <option value='MADURA'>MADURA</option>
                                            <option value='ASING'>ASING</option>
                                            <option value='BATAK'>BATAK</option>
                                            <option value='ARAB'>ARAB</option>
                                            <option value='LAIN-LAIN'>LAIN-LAIN</option>
                                        </select>
                                    </div>

                                    <label for="namapasien" class="col-sm-2 control-label">Nama Ibu Kandung </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " autocomplete="off" id="Medrec_NamaIbuKandung" name="Medrec_NamaIbuKandung" type="text" placeholder="Ketik Ibu Kandung disini">
                                    </div>
                                    <div id="error_Medrec_Ibu_Kandung"></div>
                                </div>
                                <div class="form-group gut">
                                    <label for="namapasien" class="col-sm-2 control-label">Cob </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " autocomplete="off" id="cobname" name="cobname" readonly type="text">
                                    </div>

                                    <label for="namapasien" class="col-sm-2 control-label">Note Registrasi </label>
                                    <div class="col-sm-4">
                                    <input class="form-control input-sm " autocomplete="off" id="noteregistrasi" name="noteregistrasi" readonly type="text">
                                    </div>
                                    <div id="error_Medrec_Ibu_Kandung"></div>
                                </div>


                                <h5 class="underline mt-30"> Data BPJS <small>( - <sup class="color-danger">*</sup>)
                                        Harus diisi </small></h5>
                                <div class="alert alert-danger alert-dismissible">
                                    <p> <strong>Info !</strong> Penerbitan Surat Kontrol JKN di peruntukan hanya untuk
                                        pasien yang Kontrol Ulang dengan Poliklinik yang sama dengan Surat Rujukan.</p>
                                    <p> <strong>Info !</strong> Untuk No. SEP silahkan Cari No SEP Pasien terakhir ke
                                        Poli yang sama dengan Rujukan, jika sudah klik Verify.</p>
                                    <p> <strong>Info !</strong> Gunakan Tombol Search SEP untuk mencari SEP terakhir
                                        dari Poliklinik yang sesuai Surat Rujukan dan Rencana Kontrol.</p>
                                </div>
                                <!-- <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> No. Renc Kontrol <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="BPJS_NoRencKontrol" name="BPJS_NoRencKontrol" placeholder="Masukkan nomor Rencana Kontrol disini">
                                    </div>
                                    <label for="tglRencanaKunjungan" class="col-sm-2 control-label"> Tgl Rencana Kontrol<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="date" id="SIMRS_TglKontrol" name="SIMRS_TglKontrol" class="form-control input-sm">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" readonly id="SIMRS_Jam" name="SIMRS_Jam" class="form-control input-sm">
                                    </div>
                                </div> -->
                                <input class="form-control input-sm" readonly type="hidden" id="BPJS_NoRencKontrol" name="BPJS_NoRencKontrol" placeholder="Masukkan nomor Rencana Kontrol disini">
                                <div class="form-group gut ">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kontrol<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" readonly autocomplete="off" value="2" type="text" id="BPJS_KodeJenisKontrol" name="BPJS_KodeJenisKontrol">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly autocomplete="off" value="Rencana Kontrol" type="text" id="SPRI_NamaJenisKontrol" name="SPRI_NamaJenisKontrol">
                                    </div>
                                    <label for="kodefakes" class="col-sm-2 control-label"> Jenis Kontrol <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_JENIS_SEP" name="SIMRS_JENIS_SEP">
                                    </div>
                                </div>
                                <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Nomor SEP <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="BPJS_NoSEP" name="BPJS_NoSEP" placeholder="Masukkan nomor SEP disini">
                                    </div>
                                    <div class="col-sm-1" style="margin-left: -25px;">
                                        <a href="#" data-toggle='modal' class="btn btn-primary btn-sm" onclick="verifySEp()"><span class="glyphicon glyphicon glyphicon-search"></span>Verify</a>
                                    </div>
                                    <div class="col-sm-1" style="margin-left: -25px;">
                                        <a href="#" data-toggle='modal' class="btn btn-success btn-sm" onclick="searchsep()"><span class="glyphicon glyphicon glyphicon-search"></span>SEP</a>
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Nomor Kartu <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="BPJS_NoKartu" name="BPJS_NoKartu" placeholder="Masukkan nomor kartu disini">
                                    </div>
                                </div>
                                <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label">Diagnosa<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <input class="form-control input-sm" readonly type="text" id="BPJS_Diagnosa" name="BPJS_Diagnosa" placeholder="Masukkan diagnosa disini">
                                    </div>
                                </div>
                                <div class="form-group datainsertrujukan gut">
                                    <label for="tglRencanaKunjungan" class="col-sm-2 control-label"> No. Registrasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_Registrasi" name="SIMRS_Registrasi" value="<?= $data['id'] ?>">
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Nomor Rujukan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="BPJS_xNorujukan" name="BPJS_xNorujukan" placeholder="Masukkan nomor kartu disini">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik Rujukan :
                                    </label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" readonly type="text" id="BPJS_xKodePoliRujukan" name="BPJS_xKodePoliRujukan">

                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="BPJS_xNamaPoliRujukan" name="BPJS_xNamaPoliRujukan">

                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Faskes Perujuk <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" readonly type="text" id="JenisRujukanFaskesBPJSx" name="JenisRujukanFaskesBPJSx" placeholder="Masukkan nomor kartu disini">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="JenisRujukanFaskesBPJSxName" name="JenisRujukanFaskesBPJSxName" placeholder="Masukkan nomor kartu disini">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Poliklinik Saat ini
                                        <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" readonly type="text" id="polisaatini" name="polisaatini">
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Poliklinik Kontrol
                                        <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" readonly type="text" id="kodepoliterpilihSimrs" name="kodepoliterpilihSimrs">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="namapoliterpilihSimrs" name="namapoliterpilihSimrs">
                                    </div>
                                </div>
                                <!-- <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik Dipilih <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input readonly class="form-control input-sm" type="text" id="KodePoliklinikBPJS" name="KodePoliklinikBPJS">
                                    </div>
                                    <div class="col-sm-6" style="margin-left: -20px;">
                                        <input readonly class="form-control input-sm" type="text" id="NamaPoliklinikBPJS" name="NamaPoliklinikBPJS">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Dokter : </label>
                                    <div class="col-sm-4">
                                        <select id='cariDokterBPJS' style="width: 100%;" name='cariDokterBPJS' class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Dipilih <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input readonly class="form-control input-sm" type="text" id="KodeDokterBPJS" name="KodeDokterBPJS">
                                    </div>
                                    <div class="col-sm-6" style="margin-left: -20px;">
                                        <input readonly class="form-control input-sm" type="text" id="NamaDokterBPJS" name="NamaDokterBPJS">
                                    </div>
                                </div> -->


                                <h5 class="underline mt-30">DATA RENCANA KONTROL PASIEN <span><a href="#" data-toggle='modal' class="btn btn-primary btn-sm" onclick="ShowRencanaKontrol()"><span class="glyphicon glyphicon glyphicon-search"></span>Lihat Rencana
                                            Kontrol</a></span>
                                </h5>


                                <div class="form-group jenispembayaran gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nomor Booking <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" type="text" readonly id="PasienNoBooking" name="PasienNoBooking" placeholder="Scan barcode Here">
                                            <input class="form-control input-sm" type="hidden" id="PasienJenisDaftar" name="PasienJenisDaftar">
                                        </div>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" type="text" id="ID_KontrolUlangEMR" name="ID_KontrolUlangEMR" placeholder="ID Kontrol Ulang" readonly>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group jenispembayaran gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Pembayaran <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="pembayaran" id="pembayaran" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                            <option value="1">Pribadi</option>
                                            <option value="2">Asuransi</option>
                                            <option value="5">Jaminan Perusahaan</option>
                                        </select>
                                    </div>

                                </div>


                                <div class="form-group jenispembayaran gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Penjamin <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="penjamin" id="penjamin" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Dokter <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="dokter" id="dokter" class="form-control input-sm" onchange="getJamPraktek(this.value)" required>
                                            <option value="">--Pilih--</option>
                                        </select>
                                    </div>

                                </div>


                                <div class="form-group poliklinik gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Poliklinik <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="poliklinik" id="poliklinik" onchange="getDataPoliklinikSearch()" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                            <?php

                                            foreach ($data['poliklinik'] as $poliklinik) : ?>

                                                <option value="<?= $poliklinik['ID'] ?>"><?= $poliklinik['NamaUnit'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jam Praktek <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="jampraktek" id="jampraktek" class="form-control  input-sm" onchange="GetSession(this.value)" required>
                                            <option value="">--Pilih--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group shiftpraktek gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Reservasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="tglreservasi" name="tglreservasi" type="date" placeholder="Ketik Usia Pasien" onchange="harireservasi(event);" required>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Shift Praktek <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <!--
                                        <select name="shiftpraktek" id="shiftpraktek" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                        </select>-->
                                        <input class="form-control input-sm " id="shiftpraktek" readonly name="shiftpraktek" type="text" placeholder="Sesion Praktek">
                                    </div>
                                </div>
                                <div class="form-group antrian gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Antrian </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="antrian" readonly name="antrian" type="text" placeholder="No. Antrian Pasien">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="new" readonly name="new" type="text">
                                    </div>
                                </div>
                                <div class="form-group keterangan gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Keterangan </label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control input-sm" id="Keterangan" name="Keterangan" rows="4" style="resize: none" required></textarea>
                                    </div>
                                    <div class="col-sm-6 mt-30">

                                        <label for="inputEmail3" class="col-sm-4 control-label"> </label>


                                        <div class="btn-group" role="group">
                                            <button class="btn btn-success  btn-rounded " id="btnsimpan">
                                                Simpan</button>
                                            <!-- <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'> Simpan</button> -->
                                            <!-- <a href="#modal_alert_batal" data-toggle="modal" class="btn btn-danger  btn-rounded" onclick="getNobokingalasan()">Batal</a> -->
                                            <!-- <a class="btn btn-danger  btn-rounded " id="batal" name="batal" data-target="#modal_alert_batals" data-toggle='modal'>
                                                Batal</a> -->
                                            <!-- <button class="btn btn-secondary  btn-rounded " id="close" name="close" >
                                                Close</button> -->
                                            <!-- <a class="btn btn-secondary  btn-rounded" href=" <?= BASEURL ?>/aReservasiPasienWalkin">Close</a> -->
                                        </div>
                            </form>


                        </div>
                    </div>

                    <!-- <div class=" form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Cara Masuk <sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm" type="hidden" id="caramasukid" readonly name="caramasukid">
                                                    <select class="col-sm-9" name="caramasuk" id="caramasuk" onchange="getreferal();getdatacaramasuk(this)">
                                                    </select>
                                                    <input class="form-control input-sm" type="hidden" id="showcaramasukfix" readonly name="showcaramasukfix">
                                                </div>
                                        </div>
                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Nama Referral <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-1">
                                                <input class="form-control input-sm" type="text" id="referralid" readonly name="referralid">
                                            </div>
                                            <div class="col-sm-3">
                                                <div id="hide_referal">
                                                    <select class="form-control" name="referral" id="referral" onchange="getreferalname();getadministrasinilai()">
                                                    </select>
                                                </div>
                                                <input class="form-control input-sm" type="text" id="showrefferalfix" readonly name="showrefferalfix">
                                            </div>
                                        </div>
                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Jenis Administrasi <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm" type="hidden" id="jenisadministrasiid" readonly name="jenisadministrasiid">
                                                <select class="col-sm-9 js-example-basic-single" name="jenisadministrasi" id="jenisadministrasi" onchange="getadministrasinilai()">
                                                </select>
                                                <input class="form-control input-sm" type="hidden" id="showadministrasifix" readonly name="showadministrasifix">
                                            </div>
                                        </div>
                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Nilai Administrasi <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm" type="text" id="jenisadminnilai" readonly name="jenisadminnilai">
                                            </div>
                                        </div> -->

                    <!-- <div class="btn-group" role="group">
                                <button class="btn btn-success  btn-rounded " id="btnprint" name="btnprint">
                                    PRINT/ORDER PENUNJANG</button>
                                <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'> Simpan</button>
                                <button class="btn btn-danger  btn-rounded " id="batal" name="batal" href="#modal_alert_batal" data-toggle='modal'>
                                    Batal</button>
                                <button class="btn btn-secondary  btn-rounded " id="close" name="close" onclick="test_showModal()">
                                    Close</button>
                            </div> -->

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
<!-- /.main-page -->
<div class="right-sidebar bg-white fixed-sidebar">
    <div class="sidebar-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Useful Sidebar <i class="fa fa-times close-icon"></i></h4>
                    <p>Code for help is added within the main page. Check for code below the example.</p>
                    <p>You can use this sidebar to help your end-users. You can enter any HTML in this sidebar.</p>
                    <p>This sidebar can be a 'fixed to top' or you can unpin it to scroll with main page.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <!-- /.col-md-12 -->

                <div class="text-center mt-20">
                    <button type="button" class="btn btn-success btn-labeled">Purchase Now<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                </div>
                <!-- /.text-center -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.sidebar-content -->
</div>
<!-- /.right-sidebar -->

</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Rekam Medik Pasien <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong> Untuk Pencarian bisa Dilakukan Pencarian dengan Nama, No. MR, Tgl Lahir,
                        Alamat, dll.</p>
                    <p> <strong>Info !</strong> Untuk Pencarian dengan Tanggal Lahir silahhkan ketik dengan cara
                        dd/mm/yyyy.</p>
                    <p> <strong>Info !</strong> Contoh : 01/01/1991.</p>
                </div>
                <div class="form-horizontal" id="form_cuti">
                    <label for="inputEmail3" class="col-sm-3 control-label"> Masukan Kata Kunci <sup class="color-danger">*</sup></label>

                    <div class="form-group  ">
                        <div class="col-sm-3">
                            <select id="cmbxcrimr" name="cmbxcrimr" style="width: 100%;" class="form-control ">
                                <option value="1">NAMA PASIEN</option>
                                <option value="2">TGL LAHIR</option>
                                <option value="3">NO. MR</option>
                                <option value="4">ALAMAT</option>
                                <option value="5">NO. IDENTITAS</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" type="text" id="txSearchData" autocomplete="off" name="txSearchData" placeholder="ketik Kata Kunci disini">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="btnSearchMrAktif" class="btn btn-success btn-wide btn-rounded" onclick="cariRekamMedikPasien()"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-load-data" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>No MR</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Lahir</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="datamedicalrecord">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Modal Batal Registrasi -->
<div class="modal fade" id="modal_alert_batal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Batal Registrasi</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmBatalReg">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. Registrasi</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="noregbatal" readonly name="noregbatal" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="alasanbatal" name="alasanbatal" rows="3"></textarea>
                        </div>
                    </div>
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnVoidTrsReg" name="btnVoidTrsReg" onclick="batalreservasi()"><i class="fa fa-plus"></i> Batal </button>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalcariDataReservasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Reservasi <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong> Data Reservasi yang Muncul adalah data reservasi pada hari ini.</p>
                    <p> <strong>Info !</strong> Silahkan klik tombol search untuk menampilkan data reservasi hari ini.
                    </p>
                </div>
                <form class="form-horizontal" id="form_cuti">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-3 control-label"> Periode <sup class="color-danger">*</sup></label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="tglawal_Search" id="tglawal_Search">
                        </div>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="tglakhir_Search" id="tglakhir_Search">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-default btn-rounded" id="btnCariReservasi" name="btnCariReservasi" onclick="getDataReservasiWalkin()">
                                <span class="glyphicon glyphicon-search"></span> Search
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="table-load-data-reservasi" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th align='center'>
                                    No
                                </th>
                                <th align='center'>
                                    No. MR
                                </th>
                                <th align='center'>
                                    Nama Pasien
                                </th>
                                <th align='center'>
                                    Tgl Booking
                                </th>
                                <th align='center'>
                                    Poliklinik
                                </th>
                                <th align='center'>
                                    Dokter
                                </th>
                                <th align='center'>
                                    No. Antrian
                                </th>
                                <th align='center'>
                                    Jenis Pembayaran
                                </th>
                                <th align='center'>
                                    Jam Praktek
                                </th>
                                <th align='center'>
                                    Alamat
                                </th>
                                <th align='center'>
                                    Tgl Lahir
                                </th>
                            </tr>
                        </thead>
                        <tbody id="datareservasi"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcReservasi" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_VerifBPJS" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Input SEP BPJS Kesehatan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                    <h5 class="underline mt-30">Verifikasi Kepesertaan BPJS Kesehatan</h5>
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Rujukan Dari <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisRujukanFaskesBPJS" nama="JenisRujukanFaskesBPJS" class="form-control input-sm">
                                <option value="1">Faskes 1</option>
                                <option value="2">Faskes 2</option>
                            </select>
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> No. Kartu/KTP/RJ <sup class="color-danger">*</sup></label>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" type="text" id="idPesertaBPJS" name="idPesertaBPJS">
                        </div>
                        <div class="col-sm-1" style="margin-left: -25px;">
                            <button class="btn btn-primary btn-sm" type="button" id="btnCekKepesertaan" name="btnCekKepesertaan">INQUIRY</button>
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Cari Berdasarkan <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisPencarianBPJS" nama="JenisPencarianBPJS" class="form-control input-sm">
                                <option value="1">NIK</option>
                                <option value="2">KARTU PESERTA</option>
                                <option value="3">RUJUKAN ONLINE</option>
                            </select>
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Rujukan <sup class="color-danger">*</sup></label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="idppkrujukanBPJS" name="idppkrujukanBPJS" type="text">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="namappkrujukanBPJS" readonly name="namappkrujukanBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No. Kartu BPJS <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="nokartubpjs" readonly name="nokartubpjs" type="text">
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> Diagnosa <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="norujukanBPJS" readonly name="norujukanBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No. NIK </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="nonikktpBPJS" readonly name="nonikktpBPJS" type="text">
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> Status Peserta </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="statuspesertaBPJS" readonly name="statuspesertaBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Peserta </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="admpatientName" readonly name="admpatientName" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Keterangan
                            PRB </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="keteranganprbBPJS" readonly name="keteranganprbBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Hak Kelas </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="idhakKelas" readonly name="idhakKelas" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="hakKelas" readonly name="hakKelas" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> COB - No. Asuransi </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="cobnosuratBPJS" readonly name="cobnosuratBPJS" type="text">
                        </div>
                    </div>


                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Faskes </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="idfaskes" readonly name="idfaskes" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="namafaskes" readonly name="namafaskes" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> COB - Nama Asuransi </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="cobNamaAsuransiBPJS" readonly name="cobNamaAsuransiBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No. Rujukan </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="norujukan" readonly name="norujukan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pelayanan </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="kdjenispelayananbpjsBPJS" readonly name="kdjenispelayananbpjsBPJS" type="text">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="nmjenispelayananbpjsBPJS" readonly name="nmjenispelayananbpjsBPJS" type="text">
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> kelas Perawatan </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="kdkelasperawatanBPJS" readonly name="kdkelasperawatanBPJS" type="text">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="nmkelasperawatanBPJS" readonly name="nmkelasperawatanBPJS" type="text">
                        </div>
                    </div>
                    <h5 class="underline mt-30">DATA KLINIS SEP PASIEN</h5>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa Awal <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id='isDiagnosaawalBPJS' class="form-control" onchange="good();">
                                <option value='0'>- Search WBS ID -</option>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa Terpilih </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm" type="text" id="kdDiagnosaawalBPJSChoose" readonly name="kdDiagnosaawalBPJSChoose">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" type="text" id="nmDiagnosaawalBPJSChoose" readonly name="nmDiagnosaawalBPJSChoose">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> COB </label>
                        <div class="col-sm-4">
                            <select id="isDiagnosaawalBPJSx" name="isDiagnosaawalBPJSx" class="col-sm-9">
                                <option value="0">TIDAK</option>
                                <option value="1">YA</option>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> Katarak</label>
                        <div class="col-sm-4">
                            <select id="iscatarakBPJS" name="iscatarakBPJS" class="col-sm-9">
                                <option value="0">TIDAK</option>
                                <option value="1">YA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No. Surat Kontrol <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="NoSuratKontrolBPJS" name="NoSuratKontrolBPJS" placeholder="Ketik No. Surat Kontrol">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Catatan <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <textarea class="form-control input-sm" id="iscatatanBPJS" name="iscatatanBPJS" rows="4"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn bg-success  btn-wide" id="btnFinishPayroll" name="btnFinishPayroll" onclick="AddTempLBByIDByLuar()"><i class="fa fa-check"> </i> SIMPAN SEP</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="Notif_awal_registrasi2" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Data Polis Asuransi </h4>
            </div>
            <form id="FrmDataPolisKartu">
                <div class="modal-body">
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. ID</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="Kartu_ID" readonly name="Kartu_ID">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. Rekam Medik</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="kartu_NoRM" readonly name="kartu_NoRM">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pasien </label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="Kartu_NamaPasien" readonly name="Kartu_NamaPasien" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Group Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="Kartu_GroupJaminan" readonly name="Kartu_GroupJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamagroupJaminan_Asr" readonly name="Kartu_NamagroupJaminan_Asr" type="text" placeholder="Ketik Nama Group Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="Kartu_NamaJaminan" readonly name="Kartu_NamaJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamaJaminanx_Asr" readonly name="Kartu_NamaJaminanx_Asr" type="text" placeholder="Ketik Nama Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">No. Kartu Polis </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="Kartu_NoPeserta" name="Kartu_NoPeserta" type="number" placeholder="No. Kartu Polis">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Hak Kelas</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="Kartu_HakKelas" id="Kartu_HakKelas">
                                <option value=""></option>
                                <option value="KELAS 1">KELAS 1</option>
                                <option value="KELAS 2">KELAS 2</option>
                                <option value="KELAS 3">KELAS 3</option>
                                <option value="KELAS VIP">KELAS VIP</option>
                                <option value="KELAS VVIP">KELAS VVIP</option>
                            </select>

                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Status Peserta</label>
                        <div class="col-sm-8">
                            <select id="Kartu_StatusPeserta" name="Kartu_StatusPeserta" class="form-control input-sm ">
                                <option value=""></option>
                                <option value="PESERTA">PESERTA</option>
                                <option value="SUAMI">SUAMI</option>
                                <option value="ISTRI">ISTRI</option>
                                <option value="AYAH">AYAH</option>
                                <option value="IBU">IBU</option>
                                <option value="ANAK 1">ANAK 1</option>
                                <option value="ANAK 2">ANAK 2</option>
                                <option value="ANAK 3">ANAK 3</option>
                                <option value="ANAK 4">ANAK 4</option>
                                <option value="ANAK 5">ANAK 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pemegang Kartu</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="Kartu_NamaPemegangKartu" name="Kartu_NamaPemegangKartu" type="text" placeholder="Ketik Nama Pemegang Kartu">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="Kartu_Keterangan" name="Kartu_Keterangan" type="text" placeholder="Ketik Keterangan">
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">
                    <button class="btn btn-primary" id="btnSavePoli" name="btnSavePoli"> Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cetak</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong>
                        Pada Kunungan ke 2 berdasarkan No. Rujukan ini. Tidak di buatkan No. Reservasi Otomatis dari
                        SIMRS, hanya di buatkan
                        saja Surat Kontrol dan kemudian di cetak dan diberikan ke Pasien Sebagai Bukti Kontrol
                        Selanjutnya.
                    </p>
                    <p> <strong>Info !</strong> Mulai 1 Januari 2023 - Khusus untuk Pasien BPJS Kesehatan Kunjungan ke 2
                        Poliklinik berdasarkan No. Rujukan. Diharuskan melakukan Reservasi via Mobile JKN.
                        Silahkan informasikan ke Pasien untuk Melakukan Reservasi via Mobile JKN untuk menghindari
                        Antrian Saat Mendaftar di Hari H.</p>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak SPRI</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoBPJS.Png" id="logocetakbuktiSEP" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnclosemodalcetak" name="btnclosemodalcetak"><i class="fa fa-times"></i>CLOSE</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="notif_Cetak_peringatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Syarat dan Kebijakan ( Entri Kontrol Ulang Pasien )</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p>
                        Entri Surat Kontrol / Reservasi via SIMRS pada modul ini berlaku baik itu Pasien BPJS Kesehatan
                        maupun Non BPJS Kesehatan.
                        <b>Proses ini merupakan proses Mandatory yang harus di lakukan ketika Pasien Pasca Rawat Inap
                            atau Kontrol
                            Ulang pada Poli.</b>
                        Adapun beberapa ketentuan yang Harus Di Pahami adalah sebagai berikut :
                    </p>
                    <br>
                    <p>
                        1. Untuk Pasien <b>Post Rawat Inap</b>, Jika Pasien BPJS Kesehatan maka dibuatkan Reservasi
                        Online langsung dari SIMRS dan juga Bukti Surat Kontrol
                        BPJS Kesehatan sebagai Bukti Kontrol berikutnya.
                    </p>
                    <br>
                    <p>
                        2. Untuk Pasien <b>Kunjungan ke 2 dengan Rujukan baik Faskes 1 atau 2 </b>,
                        Jika Pasien BPJS Kesehatan dengan <b>Poli yang sama dengan Poli yang tertera di surat
                            Kontrol</b>
                        maka hanya di buatkan Surat
                        Kontrol BPJS Kesehatan sebagai Bukti Kontrol berikutnya.
                    </p>
                    <br>
                    <p>
                        3. Untuk Pasien BPJS Kesehatan sebagaimana sudah di sebutkan pada Point No. 2 di atas
                        <b>DI WAJIBKAN MELAKUKAN RESERVASI VIA MOBILE JKN</b>
                        untuk mengambil antrian ke Poliklinik. Untuk menghindari Antrian saat pasien Mendaftar pada Hari
                        H.
                        <b>ketentuan ini berlaku per 1 Januari 2023</b>
                    </p>
                    <br>
                    <p>
                        4. Untuk Pasien Non BPJS Kesehatan tidak ada Perubahan / tetap di buatkan Reservasi Online dan
                        akan di kirim
                        info langsung Via Whatsapp ke Nomor Pasien.
                    </p>
                    <br>
                    <p>
                        Kebijakan ini dibuat sebagai bentuk dukungan RS YARSI sebagai Rumah Sakit Percontohan untuk
                        Implementasi Mobile JKN
                        BPJS Kesehatan.
                    </p>
                </div>
                <div class="form-check">

                    <input class="form-check-input" type="checkbox" id="checkboxSyarat" onclick="checkTrue()">
                    Saya Sudah mengerti Syarat dan Kebijakan yang di buat di atas.
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" onclick="closemodalSyarat()" id="btnCloseModalSyarat" name="btnCloseModalSyarat"><i class="fa fa-times"></i>CLOSE</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="notif_ShowTTD_Digital" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Entri Alasan Cetak Anda disini</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmDigitalSign">
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. SPRI</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signNoSep" readonly autocomplete="off" name="signNoSep">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Cetak</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signAlasanCetak" autocomplete="off" name="signAlasanCetak" placeholder="ketik Alasan Cetak disini">
                            <small>Silahkan Masukan Alasan cetak selengkap mungkin, untuk memudahkan Tracing
                                Data.</small>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btncetakDigital" name="btncetakDigital"><i class="fa fa-print"></i> PRINT </button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_Pengajuan2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data SEP Pasien <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong> Silahkan Masukan No. Kartu BPJS Kesehatan.</p>

                </div>
                <form class="form-horizontal" id="form_cuti">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"> No. Kartu <sup class="color-danger">*</sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="nokartu" id="nokartu">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-default btn-rounded" id="btnCariReservasi" name="btnCariReservasi" onclick="getDataReservasiWalkin()">
                                <span class="glyphicon glyphicon-search"></span> Verify
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="table-load-data-reservasi" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th align='center'>
                                    No
                                </th>
                                <th align='center'>
                                    No. MR
                                </th>
                                <th align='center'>
                                    Nama Pasien
                                </th>
                                <th align='center'>
                                    Tgl Booking
                                </th>
                                <th align='center'>
                                    Poliklinik
                                </th>
                                <th align='center'>
                                    Dokter
                                </th>
                                <th align='center'>
                                    No. Antrian
                                </th>
                                <th align='center'>
                                    Jenis Pembayaran
                                </th>
                                <th align='center'>
                                    Jam Praktek
                                </th>
                                <th align='center'>
                                    Alamat
                                </th>
                                <th align='center'>
                                    Tgl Lahir
                                </th>
                            </tr>
                        </thead>
                        <tbody id="datareservasi"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcReservasi" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Untuk Notif Resep ------------------------------------------------>

<!-- Modal Lihat Rencana Kontrol--------------------------------------------->
<div class="modal fade" id="myModalLihatRencanaKontrol" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">SURAT KETERANGAN KONTROL JKN
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"> No. RM </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatid" name="lihatid" type="hidden" readonly>
                        <input class="form-control input-sm" id="lihatNoMR" name="lihatNoMR" readonly>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-3 control-label"> Nama </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatNama" name="lihatNama" readonly>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-3 control-label"> Tanggal Surat Rujukan </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatTglSurat" name="lihatTglSurat" readonly>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-3 control-label"> Diagnosa </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatDiagnosa" name="lihatDiagnosa" readonly>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-3 control-label">Terapi </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatTerapi" name="lihatTerapi" readonly>
                    </div>
                    <br><br><br>
                    <label for="inputEmail3" class="col-sm-10 control-label"> Belum Dapat Dikembalikan Ke Fasilitas
                        Perujuk/PPK Dengan Alasan :</label>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> </label>
                    <div class="col-sm-9" style="margin-left:-3em">
                        <textarea class="form-control input-sm" id="lihatAlasan_BelumDapat1" name="lihatAlasan_BelumDapat1" rows="3" style="resize: none" required readonly></textarea>
                    </div>
                    <!-- <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> 2. :</label>
                    <div class="col-sm-8" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatAlasan_BelumDapat2" name="lihatAlasan_BelumDapat2">
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> 3. :</label>
                    <div class="col-sm-8" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatAlasan_BelumDapat3" name="lihatAlasan_BelumDapat3">
                    </div> -->
                    <br><br><br><br>
                    <label for="inputEmail3" class="col-sm-10 control-label"> Rencana Tidak Lanjut Yang Akan Dilakukan
                        Pada Kunjungan Selanjutnya :</label>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> </label>
                    <div class="col-sm-9" style="margin-left:-3em">
                        <textarea class="form-control input-sm" id="lihatAlasan_TidakLanjut1" name="lihatAlasan_TidakLanjut1" rows="3" style="resize: none" required readonly></textarea>
                    </div>
                    <!-- <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> 2. :</label>
                    <div class="col-sm-8" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatAlasan_TidakLanjut2"
                            name="lihatAlasan_TidakLanjut2">
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> 3. :</label>
                    <div class="col-sm-8" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatAlasan_TidakLanjut3"
                            name="lihatAlasan_TidakLanjut3">
                    </div> -->
                    <br><br><br><br>
                    <label for="inputEmail3" class="col-sm-10 control-label"> Surat Keterangan Ini Digunakan untuk 1
                        (Satu) Kali Kunjungan Dengan Diagnosa Diatas Pada Kunjungan :</label>
                    <br><br>
                    <!-- <label for="inputEmail3" class="col-sm-1 control-label"> <input type="checkbox" id="cekTglKontrol"
                            name="cekTglKontrol" readonly>
                    </label> -->

                    <label for="inputEmail3" class="col-sm-4 control-label">Kontrol Kembali Ke
                        RS Tanggal :
                    </label>
                    <!-- <div class="col-sm-3" style="margin-left:-5em">
                        <input class="form-control input-sm" id="lihatTglKembaliKontrol" name="lihatTglKembaliKontrol" readonly>
                    </div> -->
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table id="table-load-data-kontrol" class="display table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        ID
                                    </th>
                                    <th align='center'>
                                        Tgl Kontrol
                                    </th>
                                    <th align='center'>
                                        Polklinik
                                    </th>
                                    <th align='center'>
                                        Keterangan
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> <input type="checkbox" id="cekKonsulSelesai" name="cekKonsulSelesai" onclick="return false;">
                    </label>
                    <label for="inputEmail3" class="col-sm-4 control-label" style="margin-left:-4em">Konsultasi Selesai
                    </label>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-2 control-label" style="margin-left:20em"> Tanggal : </label>
                    <div class="col-sm-2" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatTempatTTD" name="lihatTempatTTD" placeholder="Jakarta," readonly>
                    </div>
                    <div class="col-sm-4" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatTglTTD" name="lihatTglTTD" readonly>
                    </div>
                    <br><br>
                    <img for="inputEmail3" class="col-sm-3 control-label" id="dokterSignature" src="" style="width:15%;margin-left:40em">
                    <label for="inputEmail3" class="col-sm-3 control-label" style="margin-left:40em">(............................................)
                    </label>
                    <label for="inputEmail3" class="col-sm-3 control-label" style="margin-left:44em"> Nama & TTD DPJP
                    </label>
                    <br><br><br><br><br>


                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Lihat Rencana Kontrol-->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script>
    $(document).ready(function() {
        $(".preloader").fadeOut();
    });
</script>
<script src="<?= BASEURL; ?>/js/App/reservation/nonwalkin/reservationnonwalkinNoLogin.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/registration/input/inputregistratrationrajal_V16.js"></script> -->