<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <div class="row breadcrumb-div">
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="<?= BASEURL; ?>"><i class="fa fa-home"></i> Home</a></li>
                    <li class="active"><?= $data['judul'] ?></li>
                    <li class="active"><?= $data['judul_child'] ?></li>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmSimpanTrsRegistrasiRanap">
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Daftar</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="PasienJenisDaftar" id="PasienJenisDaftar" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID SPR </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No MR </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NoMR" id="NoMR" value="<?= $data['nomr'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="NamaPasien" name="NamaPasien" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="DOB" name="DOB" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> NIK </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="NikPasien" name="NikPasien" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat </label>
                                    <div class="col-sm-4">
                                        <textarea rows="2" class="form-control" id="AlamatPasien" name="AlamatPasien" style="resize: none" readonly></textarea>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Reg RI </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="NoREGRI" name="NoREGRI" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No Episode </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="NoEpisode" name="NoEpisode" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut" style="display: none;">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Reg RWJ </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="NoRegistrasi" name="NoRegistrasi" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No Episode RWJ</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="NoEpisodeRWJ" name="NoEpisodeRWJ" readonly>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Penjamin<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="TipePenjamin" name="TipePenjamin">
                                        </select>
                                    </div>

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Cat. Ranap<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="JenisRawat" name="JenisRawat">
                                            <option value="">-- PILIH --</option>
                                            <option value="KEPERAWATAN UMUM DEWASA">KEPERAWATAN UMUM DEWASA</option>
                                            <option value="KEPERAWATAN KEBIDANAN">KEPERAWATAN KEBIDANAN</option>
                                            <option value="KEPERAWATAN ANAK">KEPERAWATAN ANAK</option>
                                            <option value="KEPERAWATAN PERINATOLOGI">KEPERAWATAN PERINATOLOGI</option>
                                            <option value="KEPERAWATAN ICU">KEPERAWATAN ICU</option>
                                            <option value="KEPERAWATAN HCU">KEPERAWATAN HCU</option>
                                            <option value="KEPERAWATAN PICU">KEPERAWATAN PICU</option>
                                            <option value="KEPERAWATAN NICU">KEPERAWATAN NICU</option>
                                            <option value="KEPERAWATAN NEONATUS">KEPERAWATAN NEONATUS</option>
                                            <option value="KAMAR OPERASI">KAMAR OPERASI</option>
                                            <option value="CARHLAB">CARHLAB</option>
                                            <option value="ENDOSCOPY">ENDOSCOPY</option>
                                            <option value="RADIOLOGY">RADIOLOGY</option>
                                            <option value="IGD">IGD</option>
                                            <option value="RUANG VK">RUANG VK</option>
                                            <option value="KEPERAWATAN ODC">KEPERAWATAN ODC</option>
                                            <option value="INSTALASI REHABILITASI MEDIK">INSTALASI REHABILITASI MEDIK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Penjamin<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="NamaPenjamin" name="NamaPenjamin" onchange="getidnamajaminan(this);">
                                        </select>
                                        <input type="text" class="form-control" id="NamaPenjaminTemp" name="NamaPenjaminTemp" readonly>
                                    </div>

                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. SEP<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="NoSEP" name="NoSEP" readonly>
                                    </div>

                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Cara Masuk<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="caramasuk" name="caramasuk">
                                        </select>
                                    </div>


                                    <label for="inputEmail3" class="col-sm-2 control-label"> DPJP<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="NamaDokter" name="NamaDokter">
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Referal</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="referral" name="referral">
                                        </select>
                                    </div>

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Kelas<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="Kelas" name="Kelas">
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Paket<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="Paket" name="Paket">
                                            <option value="">-- PILIH -- </option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Note registrasi<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="pxNoteRegistrasi" name="pxNoteRegistrasi" type="text" placeholder="Masukan Note Registrasi">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama COB </label>
                                    <div class="col-sm-4">
                                        <select class="form-control input-sm " name="COB" id="COB">
                                        </select>
                                    </div>

                                </div>


                            </form>
                            <!--
                             <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                             <button class="btn bg-black btn-wide" id="btnreservasi" name="btnreservasi"  ><i class="fa fa-check"></i>Submit</button>-->
                            <div class="btn-group" role="group">
                                <button class="btn btn-success  btn-rounded " id="btnprint" name="btnprint">
                                    PRINT/ORDER PENUNJANG</button>
                                <button class="btn btn-warning  btn-rounded " id="btnSepCeki" name="btnSepCeki" href="#modal_BPJSCekPesertaa" data-toggle='modal'> SEP</button>
                                <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'> Simpan</button>
                                <!--
                                  <button class="btn btn-danger  btn-rounded " id="batal" name="batal" href="#modal_alert_batal" data-toggle='modal'>
                                      Batal</button>-->
                                <button class="btn btn-danger  btn-rounded " onclick="Passingbatal()" id="batal" name="batal" href="#modal_alert_batal" data-toggle='modal'>
                                    Batal</button>
                                <button class="btn btn-secondary  btn-rounded " id="close" name="close">
                                    Close</button>
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
<!-- /.main-page -->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="Notif_awal_registrasi" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Silahkan Pilih Jenis Pasien </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien Umum</strong></p><br>

                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoPasienUmum.Png" id="logopasienumum" class="img-circle person" alt="Random Name" width="150" height="150">


                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien BPJS</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoBPJS.png" id="logopasienbpjs" data-toggle="modal" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien ADMEDIKA</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/ADMEDIKA.png" id="logopasienadmedika" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien Karyawan</strong></p><br>

                        <img src="<?= BASEURL; ?>/images/jenis_reg/employes.png" id="pasienkaryawan" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_VerifBPJS" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Input SEP BPJS Kesehatan</h4>
            </div>
            <div class="modal-body">
                <!--  awal untuk tab-->
                <!-- Nav tabs -->
                <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                    <li role="presentation" class="active"><a class="" href="#datadetil" aria-controls="datadetil" role="tab" data-toggle="tab">Data SEP</a></li>
                    <li role="presentation"><a class="" href="#pendidikan" aria-controls="pendidikan" role="tab" data-toggle="tab">Data History Kunjungan</a></li>
                    <li role="presentation"><a class="" href="#documenscan" aria-controls="documenscan" role="tab" data-toggle="tab">Data Document Scan</a></li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content bg-white p-15">
                    <div role="tabpanel" class="tab-pane active" id="datadetil">
                        <form class="form-horizontal" id="form_kepesertaan_Bpjs_create">
                            <h5 class="underline mt-30">Data Pasien / Rujukan </h5>
                            <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Asal Rujukan<sup class="color-danger">*</sup></label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="JenisFaskesKodeBPJS" value="2" readonly name="JenisFaskesKodeBPJS" type="text">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="JenisFaskesNamaBPJS" readonly name="JenisFaskesNamaBPJS" type="text">
                                </div>
                                <label for=" inputEmail3" class="col-sm-2 control-label"> No. Registrasi <sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="NoRegistrasiSIMRSBPJS" readonly name="NoRegistrasiSIMRSBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Rujukan Kode<sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="idppkrujukanBPJS" readonly name="idppkrujukanBPJS" type="text">
                                </div>
                                <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Rujukan Nama<sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="namappkrujukanBPJS" readonly name="namappkrujukanBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. Rujukan </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="norujukan" name="norujukan" autocomplete="off" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. Surat Kontrol <sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" type="text" id="NoSuratKontrolBPJS" autocomplete="off" name="NoSuratKontrolBPJS" placeholder="Ketik No. Surat Kontrol">
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Tgl. Rujukan </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="TglRujukan" readonly name="TglRujukan" type="date" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. NIK </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="nonikktpBPJS" readonly name="nonikktpBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. Kartu BPJS <sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="nokartubpjs" readonly name="nokartubpjs" type="text">
                                </div>
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Status Peserta </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="statuspesertaBPJS" readonly name="statuspesertaBPJS" type="text">
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Peserta </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="namapesertaBPJS" readonly name="namapesertaBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Keterangan PRB </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="keteranganprbBPJS" readonly name="keteranganprbBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Hak Kelas </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="idhakKelasBPJS" readonly name="idhakKelasBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="hakKelasBPJS" readonly name="hakKelasBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> COB - No. Asuransi </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="cobnosuratBPJS" readonly name="cobnosuratBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Faskes </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="idfaskesBPJS" readonly name="idfaskesBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="namafaskesBPJS" readonly name="namafaskesBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> COB - Nama Asuransi </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="cobNamaAsuransiBPJS" readonly name="cobNamaAsuransiBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Peserta </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="jenisPesertaKodeBPJS" readonly name="jenisPesertaKodeBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="jenisPesertaNamaBPJS" readonly name="jenisPesertaNamaBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="jenisKelaminKodeBPJS" readonly name="jenisKelaminKodeBPJS" type="text">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="jenisKelaminNamaBPJS" readonly name="jenisKelaminNamaBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pelayanan </label>
                                <div class="col-sm-4">
                                    <select id="isJenisPelayananBPJS" name="isJenisPelayananBPJS" style="width: 100%;" class="form-control ">
                                        <option value="2">RAWAT JALAN</option>
                                        <option value="1">RAWAT INAP</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Tgl SEP </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="TglSEP" name="TglSEP" type="date">
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Naik Kelas </label>
                                <div class="col-sm-4">
                                    <select id="isNaikKelasBPJS" name="isNaikKelasBPJS" style="width: 100%;" class="form-control ">
                                        <option value="">TIDAK</option>
                                        <option value="1">YA</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Kelas Perawatan </label>
                                <div class="col-sm-4">
                                    <select id="kdkelasperawatanBPJS" name="kdkelasperawatanBPJS" class="form-control ">
                                        <option value="">-- PILIH --</option>
                                        <option value="1">VVIP</option>
                                        <option value="2">VIP</option>
                                        <option value="3">Kelas 1</option>
                                        <option value="4">Kelas 2</option>
                                        <option value="5">Kelas 3</option>
                                        <option value="6">ICCU</option>
                                        <option value="7">ICU</option>
                                    </select>
                                    <small>Diisi Jika Naik Kelas.</small>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Pembiayaan </label>
                                <div class="col-sm-4">
                                    <select id="PembiayaanNiakKelasBPJS" name="PembiayaanNiakKelasBPJS" style="width: 100%;" class="form-control ">
                                        <option value="">-- PILIH --</option>
                                        <option value="1">PRIBADI</option>
                                        <option value="2">PEMBERI KERJA</option>
                                        <option value="3">ASURANSI KESEHATAN TAMBAHAN</option>
                                    </select>
                                    <small>Diisi Jika Naik Kelas.</small>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Penanggung Jawab </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="PenanggungJawabBiaya" autocomplete="off" name="PenanggungJawabBiaya" type="text">
                                    <small>Diisi Jika Naik Kelas.</small>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. MR</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="NoMRBPJS" autocomplete="off" name="NoMRBPJS" type="text">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. Hp</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="NoHpBPJS" autocomplete="off" name="NoHpBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Lahir</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " readonly id="TglLahirBPJS" autocomplete="off" name="TglLahirBPJS" type="text">
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> COB </label>
                                <div class="col-sm-4">
                                    <select id="isCobBPJS" name="isCobBPJS" style="width: 100%;" class="form-control ">
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
                                <label for="inputEmail3" class="col-sm-2 control-label"> Eksekutif </label>
                                <div class="col-sm-4">
                                    <select id="isEksekutifBPJS" name="isEksekutifBPJS" style="width: 100%;" class="form-control ">
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal TMT <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input readonly class="form-control input-sm" type="text" id="TglTMTBPJS" name="TglTMTBPJS">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Diagnosa : </label>
                                <div class="col-sm-10">
                                    <select id='caridiagnosaBPJS2' style="width: 100%;" class="form-control " name='caridiagnosaBPJS2'>
                                        <option value='0'>- Search Diagnosa -</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa Dipilih <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input readonly class="form-control input-sm" type="text" id="KodeDiagnosaBPJS" name="KodeDiagnosaBPJS">
                                </div>
                                <div class="col-sm-8" style="margin-left: -20px;">
                                    <input readonly class="form-control input-sm" type="text" id="NamaDiagnosaBPJS" name="NamaDiagnosaBPJS">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Poliklinik : </label>
                                <div class="col-sm-10">
                                    <select id='cariPoliklinikBPJS' style="width: 100%;" name='cariPoliklinikBPJS' class="form-control ">
                                        <option value='0'>- Search Poliklinik -</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik Dipilih <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input readonly class="form-control input-sm" type="text" id="KodePoliklinikBPJS" name="KodePoliklinikBPJS">
                                </div>
                                <div class="col-sm-8" style="margin-left: -20px;">
                                    <input readonly class="form-control input-sm" type="text" id="NamaPoliklinikBPJS" name="NamaPoliklinikBPJS">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Dokter : </label>
                                <div class="col-sm-10">
                                    <select id='cariDokterBPJS' style="width: 100%;" name='cariDokterBPJS' class="form-control ">
                                        <option value='0'>- Search Dokter -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Dipilih <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input readonly class="form-control input-sm" type="text" id="KodeDokterBPJS" name="KodeDokterBPJS">
                                </div>
                                <div class="col-sm-8" style="margin-left: -20px;">
                                    <input readonly class="form-control input-sm" type="text" id="NamaDokterBPJS" name="NamaDokterBPJS">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Tujuan Kunjungan :</label>
                                <div class="col-sm-4">
                                    <select id='TujuanKunjunganBPJS' style="width: 100%;" name='TujuanKunjunganBPJS' class="form-control ">
                                        <option value=''>- PILIH -</option>
                                        <option value='0'>NORMAL</option>
                                        <option value='1'>PROSEDUR</option>
                                        <option value='2'>KONSUL DOKTER</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Flag Procedure :</label>
                                <div class="col-sm-4">
                                    <select id='FlagProcedureBPJS' style="width: 100%;" name='FlagProcedureBPJS' class="form-control ">
                                        <option value=''>- PILIH -</option>
                                        <option value='0'>Prosedur Tidak Berkelanjutan</option>
                                        <option value='1'>Prosedur dan Terapi Berkelanjutan</option>
                                    </select>
                                    <small>Dikosongkan, Jika Tujuan Kunjungan Normal</small>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Penunjang :</label>
                                <div class="col-sm-4">
                                    <select id='PenujangBPJS' style="width: 100%;" name='PenujangBPJS' class="form-control ">
                                        <option value=''>- PILIH -</option>
                                        <option value='0'>NORMAL</option>
                                        <option value='1'>Radioterapi</option>
                                        <option value='2'>Kemoterapi</option>
                                        <option value='3'>Rehabilitasi Medik</option>
                                        <option value='4'>Rehabilitasi Psikososial</option>
                                        <option value='5'>Transfusi Darah</option>
                                        <option value='6'>Pelayanan Gigi</option>
                                        <option value='7'>Laboratorium</option>
                                        <option value='8'>USG</option>
                                        <option value='9'>Farmasi</option>
                                        <option value='10'>Lain-Lain</option>
                                        <option value='11'>MRI</option>
                                        <option value='12'>HEMODIALISA</option>
                                    </select>
                                    <small>Dikosongkan, Jika Tujuan Kunjungan Normal</small>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Asesment Pelayanan :</label>
                                <div class="col-sm-4">
                                    <select id='AsesmentPelayananBPJS' style="width: 100%;" name='AsesmentPelayananBPJS' class="form-control ">
                                        <option value=''>- PILIH -</option>
                                        <option value='1'>Poli spesialis tidak tersedia pada hari sebelumnya</option>
                                        <option value='2'>Jam Poli telah berakhir pada hari sebelumnya</option>
                                        <option value='3'>Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya</option>
                                        <option value='4'>Atas Instruksi RS</option>
                                    </select>
                                    <small>Dikosongkan, Jika Poli tujuan berbeda dengan poli rujukan dan hari beda. Diisi, Jika Tujuan Adlah konsul Dokter.</small>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Catatan <sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <textarea class="form-control input-sm" id="iscatatanBPJS" name="iscatatanBPJS" rows="4"></textarea>
                                </div>

                            </div>
                            <h5 class="underline mt-30">DATA KECELAKAAN <small> Jika Pasien Kecelakaan</small><button class="btn btn-danger btn-sm" type="button" id="btnRefreshKecamatan" name="btnRefreshKecamatan">Refresh Kecamatan</button></h5>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Laka Lantas :</label>
                                <div class="col-sm-4">
                                    <select id='LakaLantasBPJS' style="width: 100%;" name='LakaLantasBPJS' class="form-control ">
                                        <option value='0'>Bukan Kecelakaan lalu lintas [BKLL]</option>
                                        <option value='1'>KLL dan bukan kecelakaan Kerja [BKK]</option>
                                        <option value='2'>KLL dan KK</option>
                                        <option value='3'>KK</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Tgl Kejadian :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" type="date" id="TglKejadianBPJS" name="TglKejadianBPJS" placeholder="Ketik No. Surat Kontrol">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control input-sm" id="LakaLantasKetBPJS" name="LakaLantasKetBPJS" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Suplesi :</label>
                                <div class="col-sm-4">
                                    <select id='SuplesiBPJS' style="width: 100%;" name='SuplesiBPJS' class="form-control ">
                                        <option value='0'>TIDAK</option>
                                        <option value='1'>YA</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">No. Suplesi :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" type="text" id="NoSuplesiBPJS" name="NoSuplesiBPJS" placeholder="Ketik No. Surat Kontrol">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Provinsi :</label>
                                <div class="col-sm-4">
                                    <select id='cariProvinsi' style="width: 100%;" name='cariProvinsi' class="form-control ">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Provinsi Kode:</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSProvinsi" name="SuplesiBPJSProvinsi" placeholder="Kode Provinsi">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Provinsi Nama :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSProvinsiName" name="SuplesiBPJSProvinsiName" placeholder="Nama Provinsi">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Kabupaten :</label>
                                <div class="col-sm-4">
                                    <select id='cariKabupaten' style="width: 100%;" name='cariKabupaten' class="form-control ">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Kabupaten Kode:</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKabupaten" name="SuplesiBPJSKabupaten" placeholder="Ketik No. Surat Kontrol">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Kabupaten Nama :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKabupatenName" name="SuplesiBPJSKabupatenName" placeholder="Ketik No. Surat Kontrol">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan :</label>
                                <div class="col-sm-4">
                                    <select id='cariKecamatan' style="width: 100%;" name='cariKecamatan' class="form-control ">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan Kode:</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKecamatan" name="SuplesiBPJSKecamatan" placeholder="Ketik No. Surat Kontrol">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan Nama :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKecamatanName" name="SuplesiBPJSKecamatanName" placeholder="Ketik No. Surat Kontrol">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pendidikan">
                        <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                            <div class="form-group  ">
                                <label for="inputEmail3" class="col-sm-3 control-label"> Periode <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input class="form-control input-sm" type="date" id="MTglKunjunganBPJS" autocomplete="off" name="MTglKunjunganBPJS" placeholder="ketik Kata Kunci disini">
                                </div>
                                <div class="col-sm-1">
                                    S.D
                                </div>
                                <div class="col-sm-2" style="margin-left: -40px;">
                                    <input class="form-control input-sm" type="date" id="MTglKunjunganBPJS_akhir" autocomplete="off" name="MTglKunjunganBPJS_akhir" placeholder="ketik Kata Kunci disini">
                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                <div class="col-sm-2">
                                    <button type="button" onclick="GoMonitoringBPJS();" id="caridatapasienarsip" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                                </div>
                            </div>
                            <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                <table id="tbl_history_Kunjungan" width="100%" class="table table-striped table-hover cell-border">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">No SEP
                                            </th>
                                            <th align='center'>
                                                <font size="1">No Kartu
                                            </th>
                                            <th align='center'>
                                                <font size="1">No Rujukan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl SEP
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Pasien
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jenis Pelayanan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Diagnosa
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kelas Rawat
                                            </th>
                                            <th align='center'>
                                                <font size="1">Layanan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl Pulang
                                            </th>
                                            <th align='center'>
                                                <font size="1">PPK Pelayanan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="documenscan">
                        <h1>COMING SOON ....... !!!!!!!</h1>
                    </div>
                    <!--  akhir untuk tab-->
                </div>
                <div class="modal-footer">
                    <button class="btn bg-success  btn-wide" id="btnCreateSEP" name="btnCreateSEP"><i class="fa fa-check"> </i> SIMPAN SEP</button>
                </div>
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
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="Modal_Karyawn_Polis" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Data Polis Karyawan </h4>
            </div>
            <form id="frmKartuRSYarsi">
                <div class="modal-body">
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. ID</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="Kartu_ID2" readonly name="Kartu_ID2">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Group Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="RSY_Kartu_GroupJaminan" readonly name="RSY_Kartu_GroupJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamagroupJaminan" readonly name="Kartu_NamagroupJaminan" type="text" placeholder="Ketik Nama Group Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="RSY_Kartu_NamaJaminan" readonly name="RSY_Kartu_NamaJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamaJaminanx" readonly name="Kartu_NamaJaminanx" type="text" placeholder="Ketik Nama Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. Rekam Medik</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="RSY_kartu_NoRM" readonly name="RSY_kartu_NoRM">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pasien </label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_Kartu_NamaPasien" readonly name="RSY_Kartu_NamaPasien" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">NIK Karyawan</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="RSY_Kartu_NoPeserta" name="RSY_Kartu_NoPeserta" type="number" placeholder="Ketik NIK Karyawan">
                            <a href="#" class="btn btn-success" id="btnValidateNIK" name="btnValidateNIK"> Validate</a>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Karyawan</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_Kartu_NamaPemegangKartu" name="RSY_Kartu_NamaPemegangKartu" type="text" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Hak Kelas</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_Kartu_HakKelas" name="RSY_Kartu_HakKelas" type="text" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Plafon RJ</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_Kartu_PlafonRJ" name="RSY_Kartu_PlafonRJ" type="text" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Plafon RI</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_PlafonRI" name="RSY_PlafonRI" type="text" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Status Peserta</label>
                        <div class="col-sm-8">
                            <select id="RSY_Kartu_StatusPeserta" name="RSY_Kartu_StatusPeserta" class="form-control input-sm ">
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
                        <label for="dokter" class="col-sm-4 col-form-label">Status Kepegawaian</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_stsPeg" name="RSY_stsPeg" type="text" readonly>
                        </div>
                    </div>
            </form>

        </div>
        <div class="modal-footer">
            <div class="form-group row" style="margin-right:1em;float:right;">
                <button class="btn btn-primary" id="btnSavePoli2" name="btnSavePoli2"> Simpan</button>
            </div>
        </div>
    </div>
</div>

</div>
<!--#END Modal Untuk Notif Resep---------------------------->




<div class="right-sidebar bg-white fixed-sidebar">
    <div class="sidebar-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Useful Sidebar <i class="fa fa-times close-icon"></i></h4>
                    <p>Code for help is added within the main page. Check for code below the example.</p>
                    <p>You can use this sidebar to help your end-users. You can enter any HTML in this sidebar.</p>
                    <p>This sidebar can be a 'fixed to top' or you can unpin it to scroll with main page.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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

<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_BPJSCekRujukanMulti" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Verifikasi Kepesertaan BPJS Kesehatan Multi</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-3 control-label"> No. Kartu <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="MultiNoKartu" autocomplete="off" name="MultiNoKartu" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-3 control-label"></label>
                        <div class="col-sm-2">
                            <button type="button" id="btnCariRujukanMulti" name="btnCariRujukanMulti" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                    <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                        <table id="tbl_kunjungan_monitoring" width="100%" class="table table-striped table-hover cell-border">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        <font size="1">No Rujukan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Keluhan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Tgl Kunjungan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Diagnosa
                                    </th>
                                    <th align='center'>
                                        <font size="1">Jenis Pelayanan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Poli Rujukan
                                    </th>
                                    <th align='center'>
                                        <font size="1">PPK Perujuk
                                    </th>
                                    <th align='center'>
                                        <font size="1">Nama Pasien
                                    </th>
                                    <th align='center'>
                                        <font size="1">Kode Peserta
                                    </th>
                                    <th align='center'>
                                        <font size="1">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->

<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_BPJSCekPesertaa" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Verifikasi Kepesertaan BPJS Kesehatan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pasien <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisxPasienBPJS" nama="JenisxPasienBPJS" class="form-control input-sm">
                                <option value="1">Rawat Jalan</option>
                                <option value="2">IGD/Ranap</option>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> Rujukan Dari <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisRujukanFaskesBPJSx" nama="JenisRujukanFaskesBPJSx" class="form-control input-sm">
                                <option value="1">Faskes 1</option>
                                <option value="2">Faskes 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Cari Berdasarkan <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisPencarianBPJS" nama="JenisPencarianBPJS" class="form-control input-sm">
                                <option value="3">No. RUJUKAN</option>
                                <option value="1">NIK</option>
                                <option value="2">KARTU PESERTA</option>
                            </select>
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> No. Kartu/KTP/RJ <sup class="color-danger">*</sup></label>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" autocomplete="off" type="text" id="idPesertaBPJS" name="idPesertaBPJS">
                        </div>
                        <div class="col-sm-1" style="margin-left: -25px;">
                            <button class="btn btn-danger btn-sm" type="button" id="btnCekRujukanMulti" name="btnCekRujukanMulti">Kartu</button>
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Asal <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id='cariPPKRujukanBPJS2' style="width: 100%;" class="form-control " name='cariPPKRujukanBPJS2'>
                                <option value='0'>- Search PPK Rujukan -</option>
                            </select>
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> </label>
                        <div class="col-sm-4">
                            <button class="btn btn-primary btn-sm" type="button" id="btnCekKepesertaan" name="btnCekKepesertaan">Search</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default btn-sm" type="button" id="btnCloseVerifikasi" name="btnCloseVerifikasi">Close</button>
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseVerifikasiz" data-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->

<!-- Modal Batal Registrasi -->
<div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cetak Registrasi Pasien dan Order Penunjang</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak Bukti Registrasi</strong></p><br>
                        <form id="TheForm" method="post" action="halaman/Print/print_bukti_reg.php" target="TheWindow">
                            <input type="hidden" name="cetaknoregis" id="cetaknoregis" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoPasienUmum.Png" id="logocetakbuktireg" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak LOA </strong></p><br>
                        <form id="TheForm2" method="post" action="halaman/Print/print_bukti_loa_admedika.php" target="TheWindow2">
                            <input type="hidden" name="cetaknoregis2" id="cetaknoregis2" />
                            <input type="hidden" name="namajaminanlab" id="namajaminanlab" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/ADMEDIKA.png" id="logocetakbuktiloa" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak Label Pasien</strong></p><br>
                        <form id="TheForm3" method="post" action="halaman/Print/print_label_pasien.php" target="TheWindow3">
                            <input type="hidden" name="cetaklabel" id="cetaklabel" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenisPrint/kartu-identitas.Png" id="logocetaklabelpasien" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak SEP</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoBPJS.Png" id="logocetakbuktiSEP" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak Gelang Anak</strong></p><br>
                        <form id="TheForm4" method="post" action="halaman/Print/print_gelang_anak.php" target="TheWindow4">
                            <input type="hidden" name="cetakgelanganak" id="cetakgelanganak" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenisPrint/baby.jpg" id="logocetakgelanganak" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak Gelang Dewasa</strong></p><br>
                        <form id="TheForm5" method="post" action="halaman/Print/print_gelang_dewasa.php" target="TheWindow5">
                            <input type="hidden" name="cetakgelangdewasa" id="cetakgelangdewasa" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenisPrint/wristband.png" id="logocetakgelangdewasa" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                            <input class="form-control input-sm" type="text" id="noregbatal" readonly autocomplete="off" name="noregbatal" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. SEP</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="nosepbatal" readonly autocomplete="off" name="nosepbatal" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="alasanbatal" name="alasanbatal" rows="3"></textarea>
                            <span><b>AGAR MUDAH DI VERIFIKASI DI KEMUDIAN HARI, MOHON MASUKAN ALASAN BATAL DENGAN JELAS !. Contoh :</b></span>
                            <span><b>Dibatalkan karena pasien tidak jadi berobat. Sudah konfirmasi perawat xx</b></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnVoidTrsReg" name="btnVoidTrsReg"><i class="fa fa-plus"></i> Batal </button>
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Batal Registrasi -->
<div class="modal fade" id="notif_ShowTTD_Digital" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Show Sign Digital </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmDigitalSign">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. Registrasi</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signNoRegistrasi" readonly autocomplete="off" name="signNoRegistrasi">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. SEP</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signNoSep" readonly autocomplete="off" name="signNoSep">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Nama Pasien/Keluarga</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signNama" autocomplete="off" name="signNama" readonly placeholder="ketik Nama Pasien/Keluarga disini">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Cetak Tanpa Digital Sign</label>
                        <div class="col-sm-6">
                            <select id="tanpaDigitalSign" name="tanpaDigitalSign" style="width: 100%;" class="form-control" onchange="gotanpaDigitalSign();">
                                <option value="0">TIDAK</option>
                                <option value="1">YA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Cetak</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signAlasanCetak" autocomplete="off" name="signAlasanCetak" placeholder="ketik Alasan Cetak disini">
                            <small>Silahkan Masukan Alasan cetak selengkap mungkin, untuk memudahkan Tracing Data.</small>
                        </div>

                    </div>
                    <div class="form-group gut ">
                        <div class="col-sm-4" style="margin-left: 30px;">
                            <div id="ImagesDigitalSEP"></div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-warning btn-wide btn-rounded" id="btnRefreshSign" name="btnRefreshSign"><i class="fa fa-refresh"></i> REFRESH </button>
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btncetakSep" name="btncetakSep"><i class="fa fa-print"></i> PRINT </button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- ========== COMMON JS FILES ========== -->

  <!-- Modal Data Pasien Ranap Aktif ------------------------------------------------>
  <div class="modal fade" id="modal_caripasien" tabindex="-1" role="dialog" style="overflow-y: auto">

<div class="modal-dialog" style="width:80%">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"> List Order Operasi</h4>
      <form id="transfer_pasien">
    </div>
    <div class="modal-body">
        <hr>
     <div class="table-responsive">
      <table id="examplex" class="table table-bordered table-striped table-hover js-basic-example dataTable" style="width:100%">
 <thead>
    <tr>
        <th>ID Operasi</th>
        <th>No MR</th>
        <th>No Registrasi</th>
        <th>No Episode</th>
        <th>Tgl Operasi</th>
        <th>Nama Pasien</th>
        <th>Dokter Operator</th>
        <th>Petugas Order</th>
        <th>Action</th>
    </tr>
</thead>
   <tbody>
</tbody>
</table>
</div>

          </form>
    </div>
    <div class="modal-footer">
      <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
    </div>
  </div>
</div>
</div>
<!--#END Data Pasien Ranap Aktif ---------------------------->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<!--<script src="<?= BASEURL; ?>/js/App/MasterData/MasterDataKarcis/MasterDataKarcis_V03.js"></script>-->

<script src="<?= BASEURL; ?>/js/App/registration/input/inputregistratrationranap_V08.js"></script>