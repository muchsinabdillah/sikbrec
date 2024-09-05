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
                                <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup> Harus diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">

                            <!-- Tab panes -->
                            <div class="tab-content bg-white p-15">
                                <div id="generalinfo" class="tab-pane fade in active">
                                    <div class="panel-body">
                                        <form class="form-horizontal" id="form_dataRS">

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama RS </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Name" name="Name">
                                                    <input class="form-control input-sm " id="id_Order" name="id_Order" type="hidden" value="<?= $data['id'] ?>" readonly>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-1 control-label"> Kode RS</label>
                                                <div class="col-sm-1">
                                                    <input type="text" class="form-control" id="Kode" name="Kode">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Alamat </label>
                                                <div class="col-sm-4">
                                                    <textarea type="text" class="form-control" id="alamat" name="alamat"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> RT </label>
                                                <div class="col-sm-1">
                                                    <input type="text" class="form-control" id="RT" name="RT">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-1 control-label"> RW </label>
                                                <div class="col-sm-1">
                                                    <input type="text" class="form-control" id="RW" name="RW">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Provinsi </label>
                                                <div class="col-sm-1">
                                                    <input type="text" autocomplete="off" class="form-control" id="kd_Provinsi" name="kd_Provinsi">
                                                </div>

                                                <div class="col-sm-2">
                                                    <select class="col-sm-10" name="Medical_Provinsi" id="Medical_Provinsi" style="width:100%">
                                                        <option value="">Pilih</option>
                                                    </select>

                                                    <div id="error_Medical_Provinsi">
                                                    </div>
                                                </div>

                                                <label for="inputEmail3" class="col-sm-2 control-label"> Kota/Kab </label>
                                                <div class="col-sm-1">
                                                    <input type="text" autocomplete="off" class="form-control" id="kd_Kota" name="kd_Kota">
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" name="Medrec_kabupaten" id="Medrec_kabupaten" style="width:100%">
                                                    </select>
                                                    <div id="error_Medrec_kabupaten"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Kecamatan </label>
                                                <div class="col-sm-1">
                                                    <input type="text" autocomplete="off" class="form-control" id="kd_Kecamatan" name="kd_Kecamatan">
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" name="Medrec_Kecamatan" id="Medrec_Kecamatan" style="width:100%">
                                                    </select>
                                                </div>

                                                <label for="inputEmail3" class="col-sm-2 control-label"> Kelurahan </label>
                                                <div class="col-sm-1">
                                                    <input type="text" autocomplete="off" class="form-control" id="kd_Kelurahan" name="kd_Kelurahan">
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" name="Medrec_Kelurahan" id="Medrec_Kelurahan" style="width:100%">
                                                    </select>
                                                    <div id="error_Medrec_Kelurahan"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Kode Pos </label>
                                                <div class="col-sm-3">
                                                    <input type="text" autocomplete="off" class="form-control" id="Kd_Pos" name="Kd_Pos">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Longitude </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Longitude" name="Longitude">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Latitude </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Latitude" name="Latitude">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-right:1em;float:right;">
                                                <a class="btn btn-primary waves-effect" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan / Update</a>
                                                <!-- <a class="btn btn-danger" id="btn_batal" name="btn_batal"><i class="fa fa-trash" aria-hidden="true"></i>
                                                        Batal</a> -->
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
<script src="<?= BASEURL; ?>/js/App/datars/DataRS.js"></script>