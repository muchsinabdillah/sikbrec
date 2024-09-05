<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Form Entri.</p>
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
                                <h5>Data Header (<small><sup class="color-danger">*</sup> Harus diisi</small>)

                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Transaksi <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <div>
                                            <input type="text" class="form-control" name="IdAuto" id="IdAuto"
                                                value="<?= $data['id'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group" role="group" id="btnSadas">
                                            <a href="#myModal" data-toggle="modal"
                                                class="btn btn-primary btn-sm btn-rounded " id="btn_caridatamr">
                                                <span class="glyphicon glyphicon glyphicon-search"></span></a>
                                        </div>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-1 control-label"> No DO <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="noDO" id="noDO" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group" role="group" id="btnSadas">
                                            <a href="#myModal" data-toggle="modal"
                                                class="btn btn-primary btn-sm btn-rounded " id="btn_caridatamr">
                                                <span class="glyphicon glyphicon glyphicon-search"></span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="tf_TglTransaksi"
                                            name="tf_TglTransaksi">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Keterangan <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="rb_ket" id="rb_ket">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Supplier <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" name="IdSupplier" id="IdSupplier">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="IdSupplier" id="IdSupplier">
                                    </div>
                                </div>
                            </form>
                            <a class="btn btn-info  waves-effect" id="btnNewPurchase" name="btnNewPurchase"><span
                                    class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Load</a>
                            </br></br>
                            <div class="panel-title">
                                <h5>Data Detail (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>

                            <table id="tbl_aktif" class="display table table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th align='center'>
                                            <font size="1">No DO
                                        </th>
                                        <th align='center'>
                                            <font size="1">Tgl DO
                                        </th>
                                        <th align='center'>
                                            <font size="1">Nilai DO
                                        </th>
                                        <th align='center'>
                                            <font size="1">Nilai Faktur
                                        </th>
                                        <th align='center'>
                                            <font size="1">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tbody id="user_data">
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label for=" inputEmail3" class="col-sm-1 control-label"> Total QTY <sup
                                        class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="IdSupplier" id="IdSupplier">
                                </div>
                                <label for=" inputEmail3" class="col-sm-1 control-label"> Grand Total <sup
                                        class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="IdSupplier" id="IdSupplier">
                                </div>
                            </div>
                            </br>
                            <div class="row col-sm-8">
                                <a class="btn btn-primary waves-effect" id="pr_btnSave" name="pr_btnSave"><span
                                        class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</a>
                                <a class="btn btn-danger" id="pr_btn_batal" name="pr_btn_batal"><i class="fa fa-trash"
                                        aria-hidden="true"></i>Hapus</a>
                                <a class="btn btn-warning" id="pr_btn_kembali" name="pr_btn_kembali"
                                    onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</a>
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
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <!-- /.col-md-12 -->

                <div class="text-center mt-20">
                    <button type="button" class="btn btn-success btn-labeled">Purchase Now<span
                            class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
<script src="<?= BASEURL; ?>/js/App/inventory/purchase/PurchasingForm_View.js"></script>