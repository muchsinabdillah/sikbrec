<div class="main-page">

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h2 class="title"><?= $data['judul'] ?></h2><br>
                                <!-- <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5> -->
                                 
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Transaksi <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="IdAuto" id="IdAuto"
                                            value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> User Entri <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" autocomplete="off"
                                            name="pr_userEntriCode" id="pr_userEntriCode" readonly>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="pr_userEntri"
                                            id="pr_userEntri" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="pr_TglTransaksi"
                                            name="pr_TglTransaksi">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Status <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" autocomplete="off" name="pr_status"
                                            id="pr_status" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select name="pr_jenistransaksi" id="pr_jenistransaksi" class="form-control">
                                            <option value="">-- PILIH --</option>
                                            <option value="1">FARMASI</option>
                                            <option value="2">LOGISTIK</option>
                                        </select>
                                    </div>

                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Unit <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="pr_unitTrnasaksi" id="pr_unitTrnasaksi" class="form-control">
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group gut">

                                    <label for=" inputEmail3" class="col-sm-7 control-label"> Keterangan <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                            <textarea class="form-control input-sm " id="pr_ketTransaksi" name="pr_ketTransaksi" placeholder="Ketik Keterangan Disini"></textarea>
                                    </div>

                                </div>
                            </form>
                            <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnNewPurchase"
                                name="btnNewPurchase"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                New Transaction</button>
                                <hr>
                            <div class="panel-title">
                                <h5>Data Barang (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-md-3">
                                    <label for="inputEmail3">Cari Barang</label>
                                    <!-- <select id='nama_Barang' style="width: 100%;" class="form-control "
                                        name='nama_Barang'>
                                        <option value='0'>- Search Barang -</option>
                                    </select> -->
                                    <input class="form-control containerX" id="nama_Barang" name="nama_Barang" type="text" placeholder="Ketik Nama Barang (min. 3 karakter)">
                                    <!-- <input type="hidden" class="form-control" autocomplete="off" readonly
                                        name="kodebarang" id="kodebarang"> -->
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
                            </div>
                                
                             <br>  <br> 
                            <!-- <table id="tbl_aktif" class="display table table-striped table-bordered" cellspacing="0" width="100%"> -->
                            <div class="panel-body p-20">
                                <div class="demo-table table-responsive" style="overflow-x:auto;margin-top: 10px;" id="tbl_rekap">
                                    <table id="tbl_aktif" class="display" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">No
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Kode Barang
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama barang
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Satuan
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Stok Min/Max
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Qty Order
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tbody id="user_data">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th>Total Qty :</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3">Total QTY</label>
                                    <input type="text" class="form-control" value="0" name="pr_totalQty"
                                        id="pr_totalQty" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3">Total Row</label>
                                    <input type="text" class="form-control" value="0" name="pr_totalRow"
                                        id="pr_totalRow" readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row col-sm-8 btn-group">
                                <a class="btn btn-maroon waves-effect btn-rounded" id="pr_btnSave" name="pr_btnSave"><span
                                        class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</a>
                                <a class="btn btn-gold btn-rounded" id="pr_btn_batal" name="pr_btn_batal"><i class="fa fa-trash"
                                        aria-hidden="true"></i>Hapus</a>
                                <button class="btn btn-black btn-rounded " id="btnprint" name="btnprint"
                                    data-toggle='modal'>
                                    <i class="fa fa-print"></i>PRINT</button>
                                <a class="btn btn-grey btn-rounded" id="pr_btn_kembali" name="pr_btn_kembali"
                                    onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
                <!-- Modal Batal Registrasi -->
                <div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog  modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Cetak Purchase Requestion</h4>
                            </div>

                            <div class="modal-footer">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-wide btn-rounded" id="cetakan"
                                        name="cetakan"><i class="fa fa-print"></i> Cetak </button>

                                </div>
                                <!-- /.btn-group -->
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
<script src="<?= BASEURL; ?>/js/jquery.autocomplete.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/inventory/purchase/PurchasingForm_View.js"></script>