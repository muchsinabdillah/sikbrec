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
                                        <input type="text" class="form-control" name="NoOrderTransaksi" id="NoOrderTransaksi" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-3 control-label"> No Order Mutasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="NoOrderMutasi" id="NoOrderMutasi"  readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-maroon btn-rounded waves-effect" id="btnSearchMutasi" name="btnSearchMutasi"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> </btuuon>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Awal Order <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="jenistransaksi" id="jenistransaksi" class="form-control">
                                                            <option value="">-- PILIH --</option>
                                                            <option value="REGULER">REGULER</option>
                                                            <option value="CITO">CITO</option>
                                                        </select>
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
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="TglTransaksi" name="TglTransaksi">
                                    </div>

                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Lokasi Awal Order <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <input type="hidden" name="LokasiAwalOrder" id="LokasiAwalOrder" />
                                        <select name="LokasiAwalOrderx" id="LokasiAwalOrderx" onchange="getIDAwal(this)" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Keterangan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <textarea class="form-control input-sm " id="Notes" name="Notes" placeholder="Ketik Keterangan Disini"></textarea>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Lokasi Tujuan Stok  <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <input type="hidden" name="LokasiTujuanStok" id="LokasiTujuanStok" />
                                        <select name="LokasiTujuanStokx" id="LokasiTujuanStokx" onchange="getIDTujuan(this)"  class="form-control">
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnNewPurchase" name="btnNewPurchase"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Transaction</button>
                           <br><br> 
                             <!-- <div class="panel-title">
                                <h5>Data Barang (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                            <div class="form-group">
                            <div class="form-group col-md-3">
                                        <label for="inputEmail3">Nama Barang</label>
                                        <select id='nama_Barang' style="width: 100%;" class="form-control " name='nama_Barang'>
                                        <option value='0'>- Search Barang -</option>
                                    </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3">Nama Barang</label>
                                        <input type="text" class="form-control" autocomplete="off" name="xNamaBarang" id="xNamaBarang" readonly>
                                        <input type="hidden" class="form-control" autocomplete="off" readonly name="xIdBarang" id="xIdBarang" maxlength="25">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3">Satuan</label>
                                        <input type="text" class="form-control" autocomplete="off" name="Satuan" id="Satuan" maxlength="25" readonly>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Qty Stok</label>
                                        <input type="text" class="form-control" autocomplete="off" name="QtyStok" id="QtyStok" maxlength="25" readonly>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Qty</label>
                                        <input type="text" class="form-control" autocomplete="off" name="Qty" id="Qty" maxlength="25">
                                    </div>
                                    <div class="orm-group col-md-2">
                                        <label for="inputEmail3" class="color-white">-</label>
                                        <a class="btn btn-maroon waves-effect" id="btnAdd" name="btnAdd"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a>
                                    </div>
                            </div> -->

                           <div class="panel-title">
                                <h5>Data Detail (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                             <!-- 
                            <form id="user_form">
                                <div class="table-responsive" style="margin-top: 70px;">
                            <table id="datatable_prdetail" class="display" width="100%">
                                        <div class="panel-title">
                                            <h5> Data Barang</h5>
                                        </div>
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
                                             <font size="1">Qty Order
                                         </th>
                                         <th align='center'>
                                             <font size="1">Qty Mutasi
                                         </th>
                                         <th align='center'>
                                             <font size="1">Hpp
                                         </th>
                                         <th align='center'>
                                             <font size="1">Total
                                         </th>
                                         <th align='center'>
                                             <font size="1">Action
                                         </th>

                                            </tr>
                                        </thead>
                                        <tbody id="user_data">
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th colspan="5">
                                                    <font size="1">GRANDTOTAL :</font>
                                                </th>
                                                <th>
                                                    <font size="1"><input type="text" name="grandtotalqty" id="grandtotalqty" class="form-control grandtotalqty" readonly /></font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LTaxRp"></div>
                                                    </font><input type="text" name="HppTotal" id="HppTotal" class="form-control taxxRp" readonly />
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="Grandtotal"></div>
                                                    </font><input type="text" name="totalrow" id="totalrow" class="form-control totalrow" readonly /><input type="text" name="grandtotalxl" id="grandtotalxl" class="form-control grandtotalxl" readonly />
                                                </th>
                                                <th>
                                                </th>
                                              

                                            </tr>
                                        </thead>
                                    </table>
                                    </div>
                            </form> -->

                            <!-- <a class="btn btn-primary" title="Tambah Baris" id="add_row_closing" name="add_row_closing" style="margin-top: 30px;">
            <i class="fa fa-plus-square"></i> Add</a> -->

            <hr>
            
            <form id="user_form">
           <div class="form-group">
            <div class="panel-title">
                  <span class="glyphicon glyphicon-list"></span> Data Barang
              </div>
                                       <!-- tabel------------>
                                       <div class="table-responsive">
                                           <table class="table demo-table" id="datadetail">
                                           <thead>
                                             <tr>
                                               <th><font size="1">Kode Barang</font></th>
                                               <th><font size="1">Nama barang</font></th>
                                               <th><font size="1">Satuan</font></th>
                                               <th><font size="1">Qty Order</font></th>
                                               <th><font size="1">Qty Mutasi</font></th>
                                               <th><font size="1">Hpp</font></th>
                                               <th><font size="1">Total</font></th>
                                               <th><font size="1">Action</font></th>
                                             </tr>
                                           </thead>
                                                  <tbody id="user_data_closing">
                                           </tbody>
                                            <tfoot>
                                             <tr>

                                               <th colspan="4">
                                                    <font size="1">GRANDTOTAL :</font>
                                                </th>
                                                <th>
                                                    <font size="1"><input type="hidden" name="grantotalOrder_closing" id="grantotalOrder_closing" class="form-control" readonly /></font>
                                                    <div id="LTaxRp"></div>
                                                    <font size="1"><input type="hidden" name="grandtotalqty" id="grandtotalqty" class="form-control" readonly /></font>
                                                    <div id="grandtotalqty_text"></div>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LTaxRp"></div>
                                                    </font><input type="hidden" name="HppTotal" id="HppTotal" class="form-control taxxRp" readonly />
                                                    <div id="HppTotal_text"></div>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="Grandtotal"></div>
                                                    </font><input type="hidden" name="totalrow" id="totalrow" class="form-control" readonly /><input type="hidden" name="grandtotalxl" id="grandtotalxl" class="form-control grandtotalxl" readonly />
                                                    <div id="grandtotalxl_text"></div>
                                                </th>
                                                <th>
                                                </th>
                                             </tr>
                                            </tfoot>
                                         </table>
                                       </div>

                                     </div>
        </form>

        <div class="row col-sm-8 btn-group">
                                <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-gold btn-rounded" id="btn_batal" name="btn_batal"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                <button type="button" class="btn btn-grey btn-rounded" id="btn_back" name="btn_back" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
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
 <div class="modal fade" id="btnSearching_modal" tabindex="-1" role="dialog">

<div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> List Data Approved Purchase Orders</h4>
        </div>

        <div class="panel-body">
            <form class="form-horizontal" id="form_cuti">
                <div class="alert alert-success alert-dismissible">
                    <strong>Info !</strong> Silahkan Cari Order Mutasi disini.
                </div>
                <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-1 control-label">Periode:</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="tglawal" id="tglawal" placeholder="Tanggal dari" value="<?= Utils::datenowcreateNotFull() ?>">
                    </div>
                    <label for="inputEmail3" class="col-sm-1 control-label">s / d</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="tglakhir" id="tglakhir" placeholder="Tanggal Sampai"value="<?= Utils::datenowcreateNotFull() ?>">
                    </div>
                    <a class="btn btn-danger btn-sm btn-rounded " id="btnSearching" name="btnSearching" onclick="ShowApprovedDatabyDate()">
                        <span class="glyphicon glyphicon glyphicon-search"></span> Cari</a>
                    </thead>
            </form>
        </div>

        <div class="table-responsive">
            <table id="datatable_pr" class="display demo-table" width="100%">
                <div class="panel-title">
                    <h5> List Data</h5>
                </div>
                <thead>
                    <tr>
                        <th align='center'>
                            <font size='1'>No. Transaksi</font>
                        </th>
                        <th align='center'>
                            <font size='1'>Tgl Transaksi</font>
                        </th>
                        <th align='center'>
                            <font size='1'>Petugas Input</font>
                        </th>
                        <th align='center'>
                            <font size='1'>Keterangan</font>
                        </th>
                        <th align='center'>
                            <font size='1'>Jenis Request</font>
                        </th>
                        <th align='center'>
                            <font size='1'>Status</font>
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
<script src="<?= BASEURL; ?>/js/App/inventory/mutasiBarang/MutasiBarang_View.js"></script>