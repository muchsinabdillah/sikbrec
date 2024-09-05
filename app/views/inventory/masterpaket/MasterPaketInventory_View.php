<div class="main-page">

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
                            <form class="form-horizontal" id="form_data">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Paket<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" autocomplete="off" name="nama_paket" id="nama_paket" placeholder="Isi nama paket disini">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Status <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4"> 
                                        <select class="form-control" name="status" id="status">
                                            <option value="">- PILIH -</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label">User Create<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" autocomplete="off" name="user_create" id="user_create" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=" inputEmail3" class="col-sm-2 control-label">User Update<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" autocomplete="off" name="user_update" id="user_update" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label">Date Create<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" autocomplete="off" name="date_create" id="date_create" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=" inputEmail3" class="col-sm-2 control-label">Date Update<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" autocomplete="off" name="date_update" id="date_update" readonly>
                                    </div>
                                </div>
                            </form>

                            <div class="panel-title">
                                <h5>Data Barang (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-md-3">
                                    <label for="inputEmail3">Cari Barang</label>
                                    <input class="form-control containerX" id="nama_Barang" name="nama_Barang" type="text" placeholder="Ketik Nama Barang (min. 3 karakter)">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputEmail3">Barang Yang Dipilih <small><sup class="color-danger">*</sup></small></label>
                                    <input type="text" class="form-control" autocomplete="off" readonly
                                        name="xNamaBarang" id="xNamaBarang" >
                                    <input type="hidden" class="form-control" autocomplete="off" readonly
                                        name="xIdBarang" id="xIdBarang" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail3">Satuan Beli</label>
                                    <input type="text" class="form-control" autocomplete="off" readonly
                                        name="SatuanBarang" id="SatuanBarang" maxlength="25">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail3">Unit Satuan</label>
                                    <input type="text" class="form-control" autocomplete="off" readonly
                                        name="SatuanBarang_Konversi" id="SatuanBarang_Konversi">
                                    <input type="hidden" class="form-control" autocomplete="off" readonly
                                        name="Konversi_Satuan" id="Konversi_Satuan">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="inputEmail3">Qty <small><sup class="color-danger">*</sup></small></label></label>
                                    <input type="number" class="form-control" autocomplete="off" name="qty_Barang"
                                        id="qty_Barang" maxlength="25">
                                </div>
                                <div class="col-md-1">
                                    <label for="inputEmail3" class="color-white">-</label>
                                    <button class="btn btn-maroon  waves-effect btn-rounded" id="pr_btnAdd" name="pr_btnAdd"><span
                                            class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                <div class="form-group col-md-3">
                                    <label for="inputEmail3">Cari Barang</label>
                                    <input class="form-control containerX" id="nama_Barang" name="nama_Barang" type="text" placeholder="Ketik Nama Barang (min. 3 karakter)">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputEmail3">Barang Yang Dipilih</label>
                                    <input type="text" class="form-control" autocomplete="off" readonly
                                        name="xNamaBarang" id="xNamaBarang" >
                                    <input type="hidden" class="form-control" autocomplete="off" readonly
                                        name="xIdBarang" id="xIdBarang" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail3">Satuan Beli</label>
                                    <input type="text" class="form-control" autocomplete="off" readonly
                                        name="SatuanBarang" id="SatuanBarang" maxlength="25">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail3">Unit Satuan</label>
                                    <input type="text" class="form-control" autocomplete="off" readonly
                                        name="SatuanBarang_Konversi" id="SatuanBarang_Konversi">
                                    <input type="hidden" class="form-control" autocomplete="off" readonly
                                        name="Konversi_Satuan" id="Konversi_Satuan">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="inputEmail3">Qty</label>
                                    <input type="number" class="form-control" autocomplete="off" name="qty_Barang"
                                        id="qty_Barang" maxlength="25">
                                </div>
                                <div class="col-md-1">
                                    <label for="inputEmail3" class="color-white">-</label>
                                    <button class="btn btn-maroon  waves-effect btn-rounded" id="pr_btnAdd" name="pr_btnAdd"><span
                                            class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                </div>
                            </div> -->

                            <br>  <br> 
                            <!-- <table id="tbl_aktif" class="display table table-striped table-bordered" cellspacing="0" width="100%"> -->
                            <div class="panel-body p-20">
                                <div class="demo-table table-responsive" style="overflow-x:auto;margin-top: 10px;" id="tbl_rekap">
                                    <table id="tbl_aktif" class="display" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">ID
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Kode Barang
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama barang
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Qty
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
                                </div>
                            </div>

                            <div class="row" style="margin-left:1em;float:left;">
                                <a class="btn btn-primary waves-effect" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</a>
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
<script src="<?= BASEURL; ?>/js/App/inventory/masterpaket/MasterPaketInventory_View.js"></script>