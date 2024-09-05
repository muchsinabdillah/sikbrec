<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Form Entri Maintenance Aset.</p>
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
                                <!-- <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5> -->
                                <h5>Data Asset (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-4 control-label"> Nama Perangkat <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="AssetData" id="AssetData" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="date" id="TglTransaksi" name="TglTransaksi">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-4 control-label"> Petugas <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" autocomplete="off" readonly name="KodePetugas" id="KodePetugas">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" readonly name="NamaPetugas" id="NamaPetugas">
                                    </div>
                                </div>

                                <h5 class="underline mt-30">Detail Maintenance</h5>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Ganti/Upgrade Ram <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="Ram" id="Ram" class="form-control">
                                            <option value="0"> Tidak </option>
                                            <option value="1"> YA </option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Cleaning <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="Cleaning" id="Cleaning" class="form-control">
                                            <option value="0"> Tidak </option>
                                            <option value="1"> YA </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Repair Windows<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="Repair" id="Repair" class="form-control">
                                            <option value="0"> Tidak </option>
                                            <option value="1"> YA </option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Instal Aplikasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="Install_app" id="Install_app" class="form-control">
                                            <option value="0"> Tidak </option>
                                            <option value="1"> YA </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Ganti/Repair SSD<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="SSD" id="SSD" class="form-control">
                                            <option value="0"> Tidak </option>
                                            <option value="1"> YA </option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Ganti/Repair Charger Laptop<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="CHARGER" id="CHARGER" class="form-control">
                                            <option value="0"> Tidak </option>
                                            <option value="1"> YA </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Ganti/Repair LCD<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="LCD" id="LCD" class="form-control">
                                            <option value="0"> Tidak </option>
                                            <option value="1"> YA </option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Ganti/Repair ADAPTER<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="ADAPTER" id="ADAPTER" class="form-control">
                                            <option value="0"> Tidak </option>
                                            <option value="1"> YA </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Ganti/Repair Keyboard<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="KEYBOARD" id="KEYBOARD" class="form-control">
                                            <option value="0"> Tidak </option>
                                            <option value="1"> YA </option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Keterangan<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" autocomplete="off" name="keterangan" id="keterangan" maxlength="25">
                                    </div>
                                </div>
                            </form>

                            <div class="row col-sm-8">
                                <a class="btn btn-primary waves-effect" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</a>
                                <a class="btn btn-danger" id="btn_batal" name="btn_batal"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</a>
                                <a class="btn btn-warning" id="btn_batal" name="btn_batal" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</a>
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
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/inventory/maintenance/MaintenanceAsetIT_View.js"></script>