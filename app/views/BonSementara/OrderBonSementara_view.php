<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Silahkan Input Transaksi Disini.</p>
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
                                <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">

                            <!-- Tab panes -->
                            <div class="tab-content bg-white p-15">
                                <div id="generalinfo" class="tab-pane fade in active">
                                    <div class="panel-body">
                                        <form class="form-horizontal" id="form_cuti"> 
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> ID </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="ID" name="ID" value="<?= $data['id'] ?>" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID Transaksi</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="No_Transaksi" name="No_Transaksi" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control input-sm" type="date" id="Tgl_Transaksi" name="Tgl_Transaksi">
                                                    </div>
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nominal </label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="Nominal" name="Nominal">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pegawai </label>
                                                    <div class="col-sm-4">
                                                        <select name="Pegawai" id="Pegawai" class="form-control">
                                                        </select>
                                                    </div>
                                                    <!-- <label for="inputEmail3" class="col-sm-2 control-label"> Status </label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="Status" name="Status">
                                                        </select>
                                                    </div> -->
                                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan </label>
                                                    <div class="col-sm-4">
                                                        <textarea class="form-control input-sm" id="keterangan" name="keterangan" rows="4" style="resize: none"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-right:1em;float:right;">
                                                    <a class="btn btn-primary waves-effect" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</a>
                                                    <a class="btn btn-danger" id="btn_batal" name="btn_batal"><i class="fa fa-trash" aria-hidden="true"></i>
                                                        Batal</a>
                                                    <a class="btn btn-grey" id="btn_kembali" name="btn_kembali" onclick="MyBack()"><i class="fa fa-close" aria-hidden="true"></i>
                                                        Kembali</a>
                                                </div>
                                            </div>
                                    </div>

                                    </form>



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
<script src="<?= BASEURL; ?>/js/App/OrderBonSementara/OrderBonSementara_View.js"></script>