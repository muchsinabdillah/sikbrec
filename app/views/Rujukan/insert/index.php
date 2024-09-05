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

                                <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Nomor SEP <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="noseppasien" name="noseppasien" placeholder="Masukkan nomor SEP disini">
                                    </div>
                                    <div class="col-sm-1" style="margin-left: -25px;">
                                        <a href="#modal_Pengajuan" data-toggle='modal' class="btn btn-primary btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span></a>
                                    </div>
                                </div>
                                <div class="form-group tglrujukan gut">
                                    <label for="tglrujukan" class="col-sm-2 control-label"> Tgl Rujukan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="date" id="tglrujukan" name="tglrujukan" class="form-control input-sm">
                                    </div>
                                    <label for="tglRencanaKunjungan" class="col-sm-3 control-label"> Tgl Rencana <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="date" id="tglrencanakunjungan" name="tglrencanakunjungan" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="form-group jnsPelayanan gut">
                                    <label for="jnsPelayanan" class="col-sm-2 control-label"> Jenis Faskes <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="jenisfakes" name="jenisfakes" class="form-control input-sm">
                                            <option value="">--Pilih Faskes--</option>
                                            <option value="1">Faskes 1</option>
                                            <option value="2">Faskes 2</option>
                                        </select>
                                    </div>
                                    <label for="kodefakes" class="col-sm-3 control-label"> Daftar Nama Faskes <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="daftarnamafakes" name="daftarnamafakes" class="form-control input-sm">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group jnsPelayanan gut">
                                    <label for="jnsPelayanan" class="col-sm-2 control-label"> Jenis Pelayanan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="jenispelayanan" name="jenispelayanan" class="form-control input-sm">
                                            <option value="">--Pilih Faskes--</option>
                                            <option value="1">Rawat Inap</option>
                                            <option value="2">Rawat Jalan </option>
                                        </select>
                                    </div>
                                    <label for="kodefakes" class="col-sm-3 control-label"> Diagnosa Rujukan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="diagnosarujukan" name="diagnosarujukan" class="form-control input-sm">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group jnsPelayanan gut">
                                    <label for="jnsPelayanan" class="col-sm-2 control-label"> Tipe Rujukan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="tiperujukan" name="tiperujukan" class="form-control input-sm">
                                            <option value="">--Pilih Tipe jenis Rujukan--</option>
                                            <option value="0">Penuh</option>
                                            <option value="1">Partial</option>
                                            <option value="2">Balik PRB</option>
                                        </select>
                                    </div>
                                    <label for="kodefakes" class="col-sm-3 control-label"> Poli Rujukan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="polirujukan" name="polirujukan" class="form-control input-sm">
                                            <option value="">Pilih Poli rujukan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group jnsPelayanan gut">
                                    <label for="jnsPelayanan" class="col-sm-2 control-label"> Catatan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <textarea class="form-control input-sm" placeholder="wajib di isi minimal 5 karakter" name="catatan" id="catatan"></textarea>
                                    </div>
                                    <label for="tglRencanaKunjungan" class="col-sm-3 control-label"> DPJP <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" readonly id="dpjp" name="dpjp" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="form-group keterangan gut">
                                    <div class="col-sm-6 mt-30">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> </label>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary  btn-rounded" id="btnsimpan">
                                                <span class="glyphicon glyphicon-ok "></span> Simpan</button>
                                            <a href="#modal_Pengajuan2" id="deleterujukan" data-toggle="modal" onclick="GetKetersediaanPoliklinik();" class="btn btn-warning  btn-rounded"><span class="glyphicon glyphicon glyphicon glyphicon-search"></span> Cek Ketersediaan Poli</a>
                                            <a href="#modal_Sarana" id="deleterujukan" data-toggle="modal" onclick="GetKetersediaanSarana();" class="btn btn-warning  btn-rounded"><span class="glyphicon glyphicon glyphicon glyphicon-search"></span> Cek List Sarana</a>
                                        </div>

                                    </div>
                                </div>
                            </form>
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
                <h4 class="modal-title"> Cek Ketersediaan Poliklinik <span class="label label-success" id="namFas">

                    </span></h4>
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
                    <button data-dismiss="modal" class="btn btn-secondary btn-rounded " id="close" name="close"> Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_Sarana" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Cek List Sarana <span class="label label-success" id="namFas2">

                    </span></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                    <br>
                    <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                        <table id="tbl_Ketersediaan_Sarana" width="100%" class="table table-striped table-hover cell-border">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        <font size="1">Kode Sarana
                                    </th>
                                    <th align='center'>
                                        <font size="1">Nama Sarana
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
                        <label for="inputEmail3" class="col-sm-4 control-label">No. Rujukan</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signNoRujukan" readonly autocomplete="off" name="signNoRujukan">
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
<!--#END Modal Untuk Notif Resep---------------------------->
<script>
    let iduser = ` <?= $data['session']->username ?>`
    let namauser = ` <?= $data['session']->name ?>`
</script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/sweet-alert/sweetalert.min.js"></script>
<script src="<?= BASEURL; ?>/js/APP/Rujukan/inputrujukan.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>