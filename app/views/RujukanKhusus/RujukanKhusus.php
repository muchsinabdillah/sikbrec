<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30"><?= $data['judul'] ?><small>( - <sup
                                            class="color-danger">*</sup>) Harus diisi </small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmsimpanrujukankhusus">
                                <div class="form-group datainsertrujukan">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> ID TRS <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="text" readonly id="IdTrsAuto"
                                            name="IdTrsAuto">
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="#modal_Pengajuan" data-toggle='modal'
                                            class="btn btn-primary btn-sm"><span
                                                class="glyphicon glyphicon glyphicon-search"></span></a>
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Nomor Rujukan <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="nomorrujukan"
                                            name="nomorrujukan" placeholder="Masukkan No. Rujukan disini">
                                    </div>
                                </div>
                                <div class="form-group datainsertrujukan">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"><sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <span onclick="newTransaction()" class="btn btn-primary">NEW TRANSAKSI</span>
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label">Status
                                        Bridging</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text" id="StausBridging"
                                            name="StausBridging">
                                    </div>
                                </div>
                                <hr>
                                <h5 class="underline mt-30">Silahkan Masukan Diagnosa & Procedure</h5>
                                <div class="form-group datainsertrujukan">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Diagnosa Tipe <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="tipediagnosa" name="tipediagnosa" class="form-control input-sm"
                                            required>
                                            <option value="">--Pilih Tipe Diagnosa--</option>
                                            <option value="P">Primer</option>
                                            <option value="S">Sekunder</option>
                                        </select>
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Diagnosa Rujukan <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="diagnosarujukanKhusus" name="diagnosarujukanKhusus"
                                            class="form-control input-sm">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Diagnosa Kode <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text"
                                            id="diagnosarujukanKhususkode" name="diagnosarujukanKhususkode">
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Diagnosa Name <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text"
                                            id="diagnosarujukanKhususName" name="diagnosarujukanKhususName">
                                    </div>
                                </div>
                                <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Procedure <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="prosedurRujukanKhusus" name="prosedurRujukanKhusus"
                                            class="form-control input-sm" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group datainsertrujukan gut">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Procedure Kode <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text"
                                            id="prosedurRujukanKhususKode" name="prosedurRujukanKhususKode">
                                    </div>
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> Procedure Name <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" readonly type="text"
                                            id="prosedurRujukanKhususName" name="prosedurRujukanKhususName">
                                    </div>

                                </div>
                                <div class="form-group datainsertrujukan">
                                    <label for="datainsertrujukan" class="col-sm-2 control-label"> <sup
                                            class="color-danger"></sup></label>
                                    <div class="col-sm-3">
                                        <button class="btn btn-primary" id="btnaddDetila">
                                            <span class="glyphicon glyphicon-plus"></span></button>
                                    </div>
                                </div>
                                <!-- <div class="table-responsive" id="tbl_rekap" style="margin-top: 10px;">
                                    <table id="tbllistrujukankhusus" width="100%" class="table table-striped table-hover cell-border"> -->
                                <div class="panel-body">
                                    <div class="demo-table" style="overflow-x:auto;margin-top: 10px;" id="tbl_rekap">
                                        <table id="tbllistrujukankhusus" class="display" width="100%"
                                            class="table table-striped table-hover cell-border">
                                            <thead>
                                                <tr>

                                                    <th align='center'>
                                                        <font size="1">No.
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Diagnosa Tipe
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Diagnosa
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Procedure
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id='leveldiagnosa'>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group keterangan gut">
                                <div class="col-sm-6 mt-30">
                                    <label for="inputEmail3" class="col-sm-4 control-label"> </label>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-success  " id="btnsimpan">
                                            <span class="glyphicon glyphicon-ok"></span> Simpan</button>
                                        <a id="deleterujukan" data-toggle="modal" href="#modal_alert_batal"
                                            class="btn btn-danger  btn-rounded"><span
                                                class="glyphicon glyphicon glyphicon glyphicon-remove"></span> Delete
                                            Rujukan</a>
                                        <a class="btn btn-dark " href=" <?= BASEURL ?>/aReservasiPasienWalkin">Close</a>
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
<div class="modal fade" id="modal_Pengajuan" role="dialog" style="overflow-y: auto" data-backdrop="static"
    data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Cari Data Rujukan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                    <div class="form-group  ">
                        <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Rujukan <sup
                                class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="date" autocomplete="off" id="PengSEP_Tgl"
                                name="PengSEP_Tgl">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-3 control-label"></label>
                        <div class="col-sm-2">
                            <button type="button" onclick="GoMonitoringBPJS();" id="caridatapasienarsip"
                                class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                    <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                        <table id="tbl_kunjungan_monitoring" width="100%"
                            class="table table-striped table-hover cell-border">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        <font size="1">No Rujukan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Nama Pasien
                                    </th>
                                    <th align='center'>
                                        <font size="1">No Kartu
                                    </th>
                                    <th align='center'>
                                        <font size="1">Diagnosa
                                    </th>
                                    <th align='center'>
                                        <font size="1">Tgl Rujukan Awal
                                    </th>
                                    <th align='center'>
                                        <font size="1">Tgl Rujukan Akhir
                                    </th>
                                    <th align='center'>
                                        <font size="1">Status Bridging
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
                    <button data-dismiss="modal" class="btn btn-secondary btn-rounded " id="close" name="close">
                        Close</button>
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
                <h4 class="modal-title" id="myModalLabel">Hapus Rujukan Khusus</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmBatalHdr">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. Rujukan</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="noregbatal" readonly autocomplete="off"
                                name="noregbatal" placeholder="ketik Kata Kunci disini">
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
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnVoidTrsReg"
                        name="btnVoidTrsReg"><i class="fa fa-plus"></i> Batal </button>
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                        data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Batal Registrasi -->
<div class="modal fade" id="modal_alert_batal_dtl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Hapus Rujukan Khusus</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmBatalDtl">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. ID</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="noregbataldtl" readonly
                                autocomplete="off" name="noregbataldtl" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="alasanbataldtl" name="alasanbataldtl"
                                rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnVoidDtlRuj"
                        name="btnVoidDtlRuj"><i class="fa fa-plus"></i> Batal </button>
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                        data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
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
<!-- <script src="<?= BASEURL; ?>/js/APP/Rujukan/inputrujukan.js"></script> -->
<script src="<?= BASEURL; ?>/js/APP/RujukanKhusus/RujukanKhusus1.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>