<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30"><?= $data['judul'] ?> Pasien BPJS <small>( - <sup class="color-danger">*</sup>) Harus diisi </small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmsimpanrujukan">
                                <h5 class="underline mt-30">Data SPR SIMRS <small> Data yang tampil berdasarkan Entrian SPR di EMR. </small></h5>
                                <div class="form-group tglrujukan gut">
                                    <label for="kodefakes" class="col-sm-2 control-label"> ID SIMRS <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_ID" name="SIMRS_ID" value="<?= $data['id'] ?>">
                                    </div>
                                    <label for="kodefakes" class="col-sm-2 control-label"> Jenis Kontrol <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_JENIS_SEP" name="SIMRS_JENIS_SEP">
                                    </div>
                                </div>
                                <div class="form-group tglrujukan gut">
                                    <label for="kodefakes" class="col-sm-2 control-label"> Nama Pasien <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_NamaPasien" name="SIMRS_NamaPasien">
                                    </div>
                                    <label for="tglRencanaKunjungan" class="col-sm-2 control-label"> No. MR <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_NoMR" name="SIMRS_NoMR">
                                    </div>
                                </div>
                                <div class="form-group tglrujukan gut">
                                    <label for="kodefakes" class="col-sm-2 control-label"> No. Episode <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_NoEpisode" name="SIMRS_NoEpisode">
                                    </div>
                                    <label for="tglRencanaKunjungan" class="col-sm-2 control-label"> No. Registrasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_Registrasi" name="SIMRS_Registrasi">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="kodefakes" class="col-sm-2 control-label"> Poli/Rawat Akhir <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_RoomPoliAkhir" name="SIMRS_RoomPoliAkhir" value="<?= $data['id'] ?>">
                                    </div>
                                    <label for="kodefakes" class="col-sm-2 control-label"> Tgl Berobat/Plg <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_TglBerobat" name="SIMRS_TglBerobat">
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_TglPulang" name="SIMRS_TglPulang">
                                    </div>

                                </div>
                                <div class="form-group tglrujukan gut">
                                    <label for="kodefakes" class="col-sm-2 control-label"> Tujuan Poli <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_Poli" name="SIMRS_Poli">
                                    </div>
                                    <label for="tglRencanaKunjungan" class="col-sm-2 control-label"> Tujuan Dokter <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_Dokter" name="SIMRS_Dokter">
                                    </div>
                                </div>
                                <div class="form-group tglrujukan gut">
                                    <label for="kodefakes" class="col-sm-2 control-label"> Keterangan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_Ket" name="SIMRS_Ket">
                                    </div>
                                    <label for="tglRencanaKunjungan" class="col-sm-2 control-label"> No. reservasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" readonly type="text" id="SIMRS_NoReservasi" name="SIMRS_NoReservasi">
                                    </div>
                                </div>
                                <h5 class="underline mt-30"> Data BPJS <small>( - <sup class="color-danger">*</sup>) Harus diisi </small></h5>
                                <div class="form-group datainsertrujukan gut">
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
                                </div>
                                <div class="form-group gut ">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kontrol<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" readonly autocomplete="off" value="2" type="text" id="BPJS_KodeJenisKontrol" name="BPJS_KodeJenisKontrol">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly autocomplete="off" value="Rencana Kontrol" type="text" id="SPRI_NamaJenisKontrol" name="SPRI_NamaJenisKontrol">
                                    </div>
                                    <small>1 Untuk SPRI, 2 untuk Rencana Kontrol</small>
                                </div>
                                <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Nomor SEP <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="BPJS_NoSEP" name="BPJS_NoSEP" placeholder="Masukkan nomor SEP disini">
                                    </div>
                                    <div class="col-sm-1" style="margin-left: -25px;">
                                        <a href="#modal_Pengajuan" data-toggle='modal' class="btn btn-primary btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span></a>
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Nomor Kartu <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="BPJS_NoKartu" name="BPJS_NoKartu" placeholder="Masukkan nomor SEP disini">
                                    </div>
                                </div>
                                <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label">Diagnosa<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <input class="form-control input-sm" readonly type="text" id="BPJS_Diagnosa" name="BPJS_Diagnosa" placeholder="Masukkan nomor SEP disini">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Poliklinik : </label>
                                    <div class="col-sm-3">
                                        <select id='BPJS_cariPoliBPJSx' style="width: 100%;" name='BPJS_cariPoliBPJSx' class="form-control" onchange="GoCariDokterKontrol();">

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
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
                                </div>
                            </form>
                            <div class="form-group keterangan gut">
                                <div class="col-sm-6 mt-30">
                                    <label for="inputEmail3" class="col-sm-4 control-label"> </label>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-primary  btn-rounded" id="btnsimpan">
                                            <i class="fa fa-save"></i> Simpan</button>
                                        <a href="#modal_Pengajuan2" id="deleterujukan" data-toggle="modal" onclick="GetKetersediaanPoliklinik();" class="btn btn-warning  btn-rounded"><span class="glyphicon glyphicon glyphicon glyphicon-search"></span> Cek Ketersediaan Poli</a>
                                        <button class="btn btn-secondary  btn-rounded " id="close" name="close" onclick="MyBack()">
                                            <i class="fa fa-mail-reply-all"></i> Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_Pengajuan" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Cari Kunjungan SEP</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
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
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-3 control-label"> No. Kartu Peserta <sup class="color-danger">*</sup></label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" maxlength="13" id="MNoKartuPeserta" autocomplete="off" name="MNoKartuPeserta" placeholder="No. Kartu Peserta">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-3 control-label"></label>
                        <div class="col-sm-2">
                            <button type="button" onclick="GoMonitoringBPJS();" id="caridatapasienarsip" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                    <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                        <table id="tbl_kunjungan_monitoring" width="100%" class="table table-striped table-hover cell-border">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        <font size="1">No SEP
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
                <div class="btn-group" role="group">
                    <button data-dismiss="modal" class="btn btn-secondary btn-rounded " id="close" name="close"> Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------> 
<div class="modal fade" id="modal_Pengajuan2" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Cek Ketersediaan Poliklinik</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                    <br>
                    <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                        <table id="tbl_Ketersediaan_Poli" width="100%" class="table table-striped table-hover cell-border">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        <font size="1">Kode Poli
                                    </th>
                                    <th align='center'>
                                        <font size="1">Nama Poli
                                    </th>
                                    <th align='center'>
                                        <font size="1">Kapasitas
                                    </th>
                                    <th align='center'>
                                        <font size="1">Jumlah Rujukan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Presentase
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
                <div class="btn-group" role="group">
                    <button data-dismiss="modal" class="btn btn-secondary btn-rounded " id="close" name="close"> <i class="fa fa-mail-reply-all"></i> Close</button>
                </div>
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
                <h4 class="modal-title" id="myModalLabel">Cetak</h4>
            </div>
            <div class="modal-body">
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
<!-- Modal -->
<!-- Modal Batal Registrasi -->
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
                            <small>Silahkan Masukan Alasan cetak selengkap mungkin, untuk memudahkan Tracing Data.</small>
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
<script>
    let iduser = ` <?= $data['session']->username ?>`
    let namauser = ` <?= $data['session']->name ?>`
</script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/sweet-alert/sweetalert.min.js"></script>
<script src="<?= BASEURL; ?>/js/APP/bridgingbpjs/rencanakontrol/createrencanakontrol_v02.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>