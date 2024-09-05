<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30">Delete/<?= $data['judul'] ?> Pasien BPJS<small>( - <sup class="color-danger">*</sup>) Harus diisi </small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmsimpanrujukan">
                                <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Nomor Rujukan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="norujukan" name="norujukan" readonly placeholder="Masukkan nomor Rujukan disini">
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="#modal_Pengajuan" data-toggle='modal' class="btn btn-primary btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span></a>
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Nomor SEP <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="noseppasien" name="noseppasien" placeholder="Masukkan nomor SEP disini">
                                    </div>
                                </div>
                                <div class="form-group tglrujukan gut">
                                    <label for="tglrujukan" class="col-sm-2 control-label"> Tgl Rujukan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="date" id="tglrujukan" name="tglrujukan" class="form-control input-sm" required>
                                    </div>
                                    <label for="tglRencanaKunjungan" class="col-sm-3 control-label"> Tgl Rencana <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="date" id="tglrencanakunjungan" name="tglrencanakunjungan" class="form-control input-sm" required>
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
                                    <label for="kodefakes" class="col-sm-3 control-label"> Cari Nama Faskes <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="daftarnamafakes" name="daftarnamafakes" class="form-control input-sm">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group jnsPelayanan gut">
                                    <label for="jnsPelayanan" class="col-sm-2 control-label"> Kode Faskes <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" id="kodefaskespilih" name="kodefaskespilih" class="form-control input-sm" readonly>
                                    </div>
                                    <label for="kodefakes" class="col-sm-3 control-label"> Nama Faskes <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" id="namafaskespilih" name="namafaskespilih" class="form-control input-sm" readonly>
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
                                    <label for="jnsPelayanan" class="col-sm-2 control-label"> Kode Diagnosa <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" id="kodediagnosapilih" name="kodediagnosapilih" class="form-control input-sm" readonly>
                                    </div>
                                    <label for="kodefakes" class="col-sm-3 control-label"> Nama Diagnosa <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" id="namadiagnosapilih" name="namadiagnosapilih" class="form-control input-sm" readonly>
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
                                        <select id="polirujukan" name="polirujukan" class="form-control input-sm" required>
                                            <option value="">Pilih Poli rujukan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group jnsPelayanan gut">
                                    <label for="jnsPelayanan" class="col-sm-2 control-label"> Kode Poli <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" id="kodepolipilih" name="kodepolipilih" class="form-control input-sm" readonly>
                                    </div>
                                    <label for="kodefakes" class="col-sm-3 control-label"> Nama Poli <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" id="namapolipilih" name="namapolipilih" class="form-control input-sm" readonly>
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
                                    <div class="col-sm-8 mt-30">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> </label>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary    btn-rounded" id="btnupdate"> <span class="glyphicon glyphicon-refresh"></span>
                                                Edit Rujukan</button>
                                            <a id="deleterujukan" data-toggle="modal" href="#notif_ShowTTD_Digital" class="btn btn-success  btn-rounded"><span class="glyphicon glyphicon glyphicon glyphicon-print"></span> Print Rujukan</a>
                                            <a id="deleterujukan" data-toggle="modal" href="#modal_alert_batal" class="btn btn-danger  btn-rounded"><span class="glyphicon glyphicon glyphicon glyphicon-remove"></span> Delete Rujukan</a>
                                            <a href="#modal_Pengajuan2" id="deleterujukan" data-toggle="modal" onclick="GetKetersediaanPoliklinik();" class="btn btn-warning  btn-rounded"><span class="glyphicon glyphicon glyphicon glyphicon-search"></span> Cek Ketersediaan Poli</a>

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
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade  " id="modal_Pengajuan" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Cari Data Rujukan BPJS</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                    <div class="form-group  ">
                        <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl SEP <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="date" autocomplete="off" id="PengSEP_Tgl" name="PengSEP_Tgl">
                        </div>
                        <button type="button" onclick="GoMonitoringBPJS();" id="caridatapasienarsip" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                    </div>
                    <div class="table-responsive">
                        <table id="tbl_kunjungan_monitoring" width="100%" class="table table-striped table-hover cell-border">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        <font size="1">No Rujukan
                                    </th>
                                    <th align='center'>
                                        <font size="1">No SEP
                                    </th>
                                    <th align='center'>
                                        <font size="1">Tgl Rujukan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Tgl Rencana Kunjungan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Tgl Berlaku
                                    </th>
                                    <th align='center'>
                                        <font size="1">No. Kartu
                                    </th>
                                    <th align='center'>
                                        <font size="1">No. MR
                                    </th>
                                    <th align='center'>
                                        <font size="1">KNama Pasien
                                    </th>
                                    <th align='center'>
                                        <font size="1">Diagnosa
                                    </th>
                                    <th align='center'>
                                        <font size="1">Jenis Rawat/Poli Tujuan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Catatan
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
                    <button data-dismiss="modal" class="btn btn-secondary btn-rounded " id="close" name="close"><span class="glyphicon glyphicon glyphicon glyphicon-remove"></span> Close</button>
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
                <h4 class="modal-title" id="myModalLabel">Hapus Rujukan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmBatalReg">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. Rujukan</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="noregbatal" readonly autocomplete="off" name="noregbatal" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="alasanbatal" name="alasanbatal" rows="3"></textarea>
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
<script>
    let iduser = ` <?= $data['session']->username ?>`
    let namauser = ` <?= $data['session']->name ?>`
</script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/sweet-alert/sweetalert.min.js"></script>
<script src="<?= BASEURL; ?>/js/APP/Rujukan/updaterujukan/update.js"></script>
<script src="<?= BASEURL; ?>/js/APP/Rujukan/updaterujukan/deleterujukan.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>