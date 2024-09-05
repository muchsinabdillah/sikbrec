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
                                    <select name="LayananOrderMutasi" id="LayananOrderMutasi" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="TglTransaksi" name="TglTransaksi">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Layanan Tujuan Mutasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="LayananTujuanMutasi" id="LayananTujuanMutasi" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Order Mutasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                                        <select name="jenistransaksi" id="jenistransaksi" class="form-control">
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
                                        <textarea class="form-control input-sm " id="Notes" name="Notes" placeholder="Ketik Keterangan Disini"></textarea>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Stok <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="JenisStok" id="JenisStok" class="form-control">
                                                            <option value="">-- PILIH --</option>
                                                            <option value="STOK">STOK</option>
                                                            <option value="NON STOK">NON STOK</option>
                                                        </select>
                                    </div>
                                </div>
                            </form>
                            <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnNewPurchase" name="btnNewPurchase"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Transaction</button>
                            <br><br><br>
                            <div class="panel-title">
                                <h5>Data Barang (<small><sup class="color-danger">*</sup> Harus diisi</small>) 
                            <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnPaket" name="btnPaket"> Paket</button></h5>
                            </div>
                            

                            <div class="form-group">
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3">Cari Barang</label>
                                        <!-- <select id='nama_Barang' style="width: 100%;" class="form-control " name='nama_Barang'>
                                        <option value='0'>- Search Barang -</option>
                                    </select> -->
                                    <input class="form-control containerX" id="nama_Barang" name="nama_Barang" type="text" placeholder="Ketik Nama Barang (min. 3 karakter)">
                                    </div>
                                    <div class="form-group col-md-2">
                                    <label for="inputEmail3">Nama Barang</label>
                                    <input type="text" class="form-control" autocomplete="off" readonly name="xNamaBarang" id="xNamaBarang" maxlength="25">
                                    <input type="hidden" class="form-control" autocomplete="off" readonly name="xIdBarang" id="xIdBarang" maxlength="25">
                                </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3">Satuan</label>
                                        <input type="hidden" class="form-control" autocomplete="off" name="Satuan" id="Satuan" readonly>
                                        <input type="text" class="form-control" autocomplete="off" name="Satuan_Konversi" id="Satuan_Konversi" readonly>
                                        <input type="hidden" class="form-control" autocomplete="off" readonly name="Konversi_satuan" id="Konversi_satuan" >
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Qty Stok</label>
                                        <input type="text" class="form-control" autocomplete="off" name="QtyStok" id="QtyStok" maxlength="25" readonly  >
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Qty</label>
                                        <input type="text" class="form-control" autocomplete="off" name="QtyOrder" id="QtyOrder" maxlength="25">
                                    </div>
                                    <div class="orm-group col-md-2">
                                        <label for="inputEmail3" class="color-white">-</label>
                                        <button class="btn btn-maroon waves-effect btn-rounded" id="btnAdd" name="btnAdd"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                    </div>
                            </div>

                            <div class="panel-title">
                                <h5>Data Detail (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
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
                                            <font size="1">Satuan Terkecil
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

                            <div class="form-group">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3">Total Row</label>
                                    <input type="text" class="form-control" value="1" name="pr_totalRow" id="pr_totalRow" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3">Total Qty</label>
                                    <input type="text" class="form-control" value="1" name="pr_totalQty" id="pr_totalQty" readonly>
                                </div>
                            </div>

                            <div class="row col-sm-8 btn-group">
                                <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-gold btn-rounded" id="btn_batal" name="btn_batal"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                <button type="button" class="btn btn-grey btn-rounded" id="btn_batal" name="btn_batal" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
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

 <!-- Modal Approve ------------------------------------------------>
 <div class="modal fade" id="btnPaket_modal" tabindex="-1" role="dialog">

<div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> List Data Paket</h4>
        </div>

        <div class="panel-body">
                <div class="alert alert-success alert-dismissible">
                    <strong>Info !</strong> Silahkan Cari Data Paket.
                </div>

                <div class="form-group gut">
                    <label for="inputEmail3" class="col-sm-2 control-label">Kata Kunci:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="ketik kata kunci disini" >
                    </div>
                    <!-- <div class="col-sm-3">
                        <input type="date" class="form-control" name="tglawal" id="tglawal" placeholder="Tanggal dari" value="<?= Utils::datenowcreateNotFull() ?>">
                    </div> -->
                    <!-- <label for="inputEmail3" class="col-sm-1 control-label">s / d</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="tglakhir" id="tglakhir" placeholder="Tanggal Sampai"value="<?= Utils::datenowcreateNotFull() ?>">
                    </div> -->
                    <button type="button" class="btn btn-danger btn-sm btn-rounded " id="btnSearching" name="btnSearching" onclick="showDataPaket()">
                        <span class="glyphicon glyphicon glyphicon-search"></span> Cari</button>
                    </thead>
        </div>

        <div class="table-responsive">
            <table id="datatable_pkt" class="display demo-table" width="100%">
                <div class="panel-title">
                    <h5> List Data</h5>
                </div>
                <thead>
                    <tr>
                        <th align='center'>
                            <font size='1'>Nama Paket</font>
                        </th>
                        <th align='center'>
                            <font size='1'>User Create</font>
                        </th>
                        <th align='center'>
                            <font size='1'>Date Create</font>
                        </th>
                        <th align='center'>
                            <font size='1'>Action</font>
                        </th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
        </div>

        <!--#END Modal Approve--------------------------------------------->
    </div>
</div>
<!-- /.col-md-12 -->
</div>
<!-- /.row -->

 <!-- Modal Approve ------------------------------------------------>
 <div class="modal fade" id="btnPaketDetail_modal" tabindex="-1" role="dialog">

<div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> List Data Paket Detail</h4>
        </div>

        <div class="panel-body">

        <input type="hidden" class="form-control" name="id_header_paket" id="id_header_paket" >
        <div class="table-responsive">
            <table id="datatable_pktdtl" class="display demo-table" width="100%">
                <div class="panel-title">
                    <h5> List Data</h5>
                </div>
                <thead>
                    <tr>
                        <th align='center'>
                            <font size='1'>Product Code</font>
                        </th>
                        <th align='center'>
                            <font size='1'>Nama Product</font>
                        </th>
                        <th align='center'>
                            <font size='1'>Qty</font>
                        </th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnPaketPilih" name="btnPaketPilih"> Pilih Paket</button>
            <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
        </div>

        <!--#END Modal Approve--------------------------------------------->
    </div>
</div>
<!-- /.col-md-12 -->
</div>

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
<script src="<?= BASEURL; ?>/js/App/inventory/orderMutasiBarang/OrderMutasiBarang_View.js"></script>