<div class="main-page">

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <!-- <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5> -->
                                <h5><?= $data['judul'] ?> (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Transaksi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-3 control-label"> Layanan Order Mutasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="LayananOrderMutasi" id="LayananOrderMutasi" class="form-control" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="TglTransaksi" name="TglTransaksi" disabled>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Layanan Tujuan Mutasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="LayananTujuanMutasi" id="LayananTujuanMutasi" class="form-control" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Order Mutasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                                        <select name="jenistransaksi" id="jenistransaksi" class="form-control" disabled>
                                                            <option value="">-- PILIH --</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="CITO">CITO</option>
                                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> User Input <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="UserInput" id="UserInput" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Keterangan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="Notes" id="Notes" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Stok <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="JenisStok" id="JenisStok" class="form-control" disabled>
                                                            <option value="">-- PILIH --</option>
                                                            <option value="STOK">STOK</option>
                                                            <option value="NON STOK">NON STOK</option>
                                                        </select>
                                    </div>
                                </div>
                            </form>
                            <br>

                            <div class="panel-title">
                                <h5>Data Detail </h5>
                            </div>
                            
                            <table id="tbl_aktif" class="display table table-striped table-bordered demo-table" cellspacing="0" width="100%">
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

                                    </tr>
                                </tfoot>
                            </table>

                            <!-- <div class="form-group">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3">Total QTY</label>
                                    <input type="text" class="form-control" value="1" name="pr_totalRow" id="pr_totalRow" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3">Total Row</label>
                                    <input type="text" class="form-control" value="1" name="pr_totalQty" id="pr_totalQty" readonly>
                                </div>
                            </div> -->

                            <div class="btn-group" role="group">
                                <a class="btn btn-maroon waves-effect btn-rounded" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Approve</a>

                                <!-- <a class="btn btn-danger" id="pr_btn_batal" name="pr_btn_batal"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</a> -->

                                <a class="btn btn-gold btn-rounded" id="pr_btn_kembali" name="pr_btn_kembali" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</a>
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

      <!-- Modal Approve ------------------------------------------------>
      <div class="modal fade" id="Modal_Approve" tabindex="-1" role="dialog">

<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Data Approved</h4>
        </div>
    <br>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-2 control-label">No PIN:</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="nopin" id="nopin" placeholder="Isi No PIN Anda dan Tekan Enter">
                    </div>
                </div>

                <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-2 control-label">Nama:</label>   <div class="col-sm-2">
                        <input type="text" class="form-control" name="nopin_ext" id="nopin_ext" readonly>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="nama_ext" id="nama_ext" readonly>
                    </div>
                </div>

                <div class="form-group gut">  
                <label for="inputEmail3" class="col-sm-3 control-label">Digital Sign:</label>
                <div class="col-sm-7">
                <embed src="" width="100px" height="100px" id="file" />

                </div>
                </div>
                    
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn-rounded btn-maroon btn-sm " id="btnSearching" name="btnSearching" onclick="goSaveApprove()"> Approve</button>
            <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
        </div>

        <!--#END Modal Approve--------------------------------------------->
    </div>
</div>
<!-- /.col-md-12 -->
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
<script src="<?= BASEURL; ?>/js/App/inventory/Approve/view/ApproveOM_View.js"></script>