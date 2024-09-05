<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline"><?= $data['judul'] ?>
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmInfoKasir">
                                <!-- Update -->
                                <div class="col-md-12">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Management Berkas Tagihan Piutang</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                        <div class="alert alert-info" role="alert"> 
                                            <strong>Informasi !</strong> Data periode Piutang di tampilkan adalah Data Piutang yang telah di buatkan Invoie Penagihan, bukan berdasarkan tanggal pasien pulang.
                                            Ketentuan ini sudah di sepakati bersama dengan Keuangan terkait Pengakuan Piutang berdasarkan Tanggal Invoice dikirim.
                                        </div>

                                            <div class="form-group gut">
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Periode Trs Tagihan
                                                </label>
                                                <div class="col-sm-2">
                                                    <input type="date" name="PeriodeAwal" id="PeriodeAwal" style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Sd/
                                                </label>
                                                <div class="col-sm-2">
                                                    <input type="date" name="PeriodeAkhir" id="PeriodeAkhir" style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>

                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label">Jenis Berkas</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control js-example-basic-single" id="JenisBerkas" name="JenisBerkas" style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                        <option value=""></option>
                                                        <option VALUE="0">Berkas Belum Dikirim</option>
                                                        <option VALUE="1">Berkas Sudah Dikirm</option>
                                                        <option VALUE="2">Berkas Sudah Diterima</option>
                                                        <option VALUE="3">Berkas All</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <label for="inputEmail3" class="col-sm-10 control-label"></label>

                                            <a type="button" class="btn btn-success btn-animated btn-wide" id="btn_loaddata" name="btn_loaddata"><span class="visible-content">Load</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>

                                            <div class="panel-body">
                                                <div class="demo-table" style="overflow-x:auto;">
                                                    <table id="BerkasPiutangdetail" class="display" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th align='center'>Kode Piutang</th>
                                                                <th align='center'>Nama Jaminan</th>
                                                                <th align='center'>Tgl Piutang</th>
                                                                <th align='center'>Jaminan</th>
                                                                <th align='center'>Nilai Piutang</th>
                                                                <th align='center'>Status Kirim</th>
                                                                <th align='center'>Status Diterima</th>
                                                                <th align='center'>Data Pengirim</th>
                                                                <th align='center'>Data Penerima</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>




                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="modal_alert_Updatekirim" tabindex="-1" role="dialog" style="overflow-y: auto">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Pesan Konfirmasi </h4>
            </div>
            <div class="modal-body">
                <form id="frmBatalReg">
                    <p>Apakah Anda Yakin Ingin Update Data ini ?</p>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="doktexr" class="col-sm-4 col-form-label">ID: </label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="KirimNoTagihan" readonly name="KirimNoTagihan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pengirim : </label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="KirimPetugas" name="KirimPetugas" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Tgl Pengirim : </label>
                        <div class="col-sm-8">
                            <div class="input-group datepick">
                                <input class="form-control input-sm " id="Kirimtgl" name="Kirimtgl" type="date">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">

                    <button class="btn btn-primary" id="btnKirimTagihan" name="btnKirimTagihan"> YA </button>
                    <button class="btn btn-danger" id="btnVoidTrsRegBatalHdr" name="btnVoidTrsRegBatalHdr">
                        TIDAK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="modal_alert_UpdateDiterima" tabindex="-1" role="dialog" style="overflow-y: auto">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Pesan Konfirmasi </h4>
            </div>
            <div class="modal-body">
                <form id="frmBatalReg">
                    <p>Apakah Anda Yakin Ingin Update Data ini ?</p>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="doktexr" class="col-sm-4 col-form-label">ID: </label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="KirimNoTagihanditerima" readonly name="KirimNoTagihanditerima" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pengirim : </label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="KirimPetugasDiterima" name="KirimPetugasDiterima" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Tgl Pengirim : </label>
                        <div class="col-sm-8">
                            <div class="input-group datepick">
                                <input class="form-control input-sm " id="KirimtglDiterima" name="KirimtglDiterima" type="date">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">

                    <button class="btn btn-primary" id="btnKirimTagihanDiterima" name="btnKirimTagihanDiterima"> YA </button>
                    <button class="btn btn-danger" id="btnVoidTrsRegBatalHdr" name="btnVoidTrsRegBatalHdr">
                        TIDAK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="modal_alert_batal_kirim" tabindex="-1" role="dialog" style="overflow-y: auto">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Pesan Konfirmasi </h4>
            </div>
            <div class="modal-body">
                <form id="frmBatalReg">
                    <p>Apakah Anda Yakin Ingin Batalkan Pengiriman Berkas ini ?</p>
                    <div class="row" style="margin-bottom:3px;">
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="KirimNoTagihanBatalKirim" readonly name="KirimNoTagihanBatalKirim" type="hidden" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">

                    <button class="btn btn-primary" id="btnTrsKirim" name="btnTrsKirim"> YA </button>
                    <button class="btn btn-danger" id="btnVoidTrsRegBatal" name="btnVoidTrsRegBatal">
                        TIDAK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="modal_alert_batal_diterima" tabindex="-1" role="dialog" style="overflow-y: auto">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Pesan Konfirmasi </h4>
            </div>
            <div class="modal-body">
                <form id="frmBatalReg">
                    <p>Apakah Anda Yakin Ingin Batalkan ini ?</p>
                    <div class="row" style="margin-bottom:3px;">
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="KirimNoTagihanBatalDiterima" readonly name="KirimNoTagihanBatalDiterima" type="hidden" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">

                    <button class="btn btn-primary" id="btnTrsDiterimabatal" name="btnTrsDiterimabatal"> YA </button>
                    <button class="btn btn-danger" id="btnVoidTrsRegBatal" name="btnVoidTrsRegBatal">
                        TIDAK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
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
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/finance/PengirimanBerkasPiutang.js"></script>