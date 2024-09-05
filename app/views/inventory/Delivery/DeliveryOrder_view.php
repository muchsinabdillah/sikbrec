<div class="main-page">


    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5> Data <?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">No.Transaksi :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="No_Transaksi" id="No_Transaksi" value="<?= $data['id'] ?>" placeholder="Ketik No. Transaksi" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">No.Purchasing Order :</label> <button type="button" class="btn btn-maroon btn-sm btn-rounded " id="btnSearching" name="btnSearching">
                                        <span class="glyphicon glyphicon glyphicon-search"></span> Search</button>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="No_PurchasingOrder" id="No_PurchasingOrder" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal.Transaksi :</label>
                                    <div class="col-sm-4">
                                        <input type="datetime-local" class="form-control" name="Tgl_Transaksi" id="Tgl_Transaksi" placeholder="Isi Tanggal Transaksi">
                                    </div>

                                    
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Delivery :</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="JenisDelivery" id="JenisDelivery">
                                            <option value=""> --Pilih-- </option>
                                            <option value="REGULER">REGULER </option>
                                            <option value="LUAR">APOTEK LUAR </option>
                                            <option value="DONASI">DONASI </option>
                                            <option value="KONSINYASI">KONSINYASI </option>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan PO:</label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control input-sm " id="Keterangan_PO" name="Keterangan_PO" placeholder="Ketik Keterangan Disini" readonly></textarea>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">User Request :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="User_Request" id="User_Request" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Supplier :</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" name="PO_KodeSupplier" id="PO_KodeSupplier" />
                                        <select class="form-control js-example-basic-single" id="PO_KodeSupplierx" name="PO_KodeSupplierx" style="width:100%" readonly>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Unit :</label>
                                    <div class="col-sm-4">
                                    <input type="hidden" name="Unit" id="Unit"  />
                                    <select name="Unitx" id="Unitx" class="form-control" disabled onchange="getID(this)">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Purchase <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                      <input type="hidden" name="axPO_JenisPurchase" id="axPO_JenisPurchase"  />
                                          <select class="form-control input-sm" disabled name="axPO_JenisPurchasex" id="axPO_JenisPurchasex">
                                              <option value="">-- PILIH --</option>
                                              <option value="1">FARMASI</option>
                                              <option value="2">LOGISTIK UMUM</option>
                                          </select>
                                      </div> 
                                  </div>
                                

                                <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnNewTransaksi" name="btnNewTransaksi" disabled><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Transaction</button>
                            </form>

                            <hr>

                            <form id="user_form">
                                <div class="table-responsive demo-table" style="margin-top: 70px;">
                                    <table id="datatable_prdetail" class="display" width="100%">
                                        <div class="panel-title">
                                            <h5> Data Barang</h5>
                                        </div>
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size='1'>No</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Kode Barang</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Nama Barang</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Satuan</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Qty PO</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Qty DO</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Harga</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Expired</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>No Batch</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Disc (%) </font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Disc Rp</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Subtotal</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Tax (%)</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Tax (Rp)</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Grand Total</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Action</font>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tbody id="user_data">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5">
                                                    <font size="2">GRANDTOTAL :</font>
                                                </th>
                                                <th>
                                                    <font size="1"><input type="hidden" name="grandtotalqty" id="grandtotalqty" class="form-control grandtotalqty" readonly /></font><font size="2"><span id="grandtotalqty_tmp"></span></font>
                                                </th>
                                                <th colspan="2">
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id=""></div>
                                                    </font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LDiscProsenDisc"></div>
                                                    </font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LDiscRpDisc"></div>
                                                    </font><input type="hidden" name="diskonxRp" id="diskonxRp" class="form-control diskonxRp" readonly /><font size="2"><span id="diskonxRp_tmp"></span></font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LSubtotal"></div>
                                                    </font><input type="hidden" name="subtotalttlrp" id="subtotalttlrp" class="form-control subtotalttlrp" readonly /><font size="2"><span id="subtotalttlrp_tmp"></span></font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LTaxDisc"></div>
                                                    </font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LTaxRp"></div>
                                                    </font><input type="hidden" name="taxxRp" id="taxxRp" class="form-control taxxRp" readonly /><font size="2"><span id="taxxRp_tmp"></span></font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="Grandtotal"></div>
                                                    </font><input type="hidden" name="totalrow" id="totalrow" class="form-control totalrow" readonly /><input type="hidden" name="grandtotalxl" id="grandtotalxl" class="form-control grandtotalxl" readonly /><font size="2"><span id="grandtotalxl_tmp"></span></font>
                                                </th>
                                                <th>
                                                    <font size="1"> </font>
                                                </th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <br><br>
                                <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pembayaran <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <select class="form-control input-sm"  name="JenisPembayaran" id="JenisPembayaran" onchange="goDateTempo(this.value)">
                                              <option value="">-- PILIH --</option>
                                              <option value="KREDIT">KREDIT</option>
                                              <option value="CASH">CASH</option>
                                          </select>
                                      </div> 
                                      
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Jatuh Tempo <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                        <input type="date" class="form-control" name="DateTempo" id="DateTempo" >
                                      </div> 
                                  </div>
                            </form>
                            <br>
                            <hr>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnSimpan" name="btnSimpan" disabled><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-gold btn-rounded" id="btn_batal" name="btn_batal" disabled><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                <button class="btn btn-black btn-rounded " id="btnprint" name="btnprint" data-toggle='modal'>
                                    <i class="fa fa-print"></i>PRINT</button>
                                <button type="button" class="btn btn-grey btn-rounded" id="btn_kembali" name="btn_kembali" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
                            </div>
                        </div>
                         <!-- Modal Batal Registrasi -->
                         <div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog  modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Cetak Delivery Order</h4>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-wide btn-rounded" id="cetakan" name="cetakan"><i class="fa fa-print"></i> Cetak </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Approve ------------------------------------------------>
                        <div class="modal fade" id="btnSearching_modal" tabindex="-1" role="dialog">

                            <div class="modal-dialog modal-lg" style="width:70%">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> List Data Approved Purchase Orders</h4>
                                    </div>

                                    <div class="panel-body">
                                        <form class="form-horizontal" id="form_cuti">
                                            <div class="alert alert-success alert-dismissible">
                                                <strong>Info !</strong> Silahkan Cari Data Purchase Orders disini.
                                            </div>
                                            <div class="form-group gut">

                                                <label for="inputEmail3" class="col-sm-1 control-label">Periode:</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" name="tglawal_pr" id="tglawal_pr" placeholder="Tanggal dari" value="<?= Utils::datenowcreateNotFull() ?>">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-1 control-label">s / d</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" name="tglakhir_pr" id="tglakhir_pr" placeholder="Tanggal Sampai"value="<?= Utils::datenowcreateNotFull() ?>">
                                                </div>
                                                <a class="btn btn-danger btn-sm btn-rounded " id="btnSearching" name="btnSearching" onclick="ShowApprovedPObyDate()">
                                                    <span class="glyphicon glyphicon glyphicon-search"></span> Cari</a>
                                                </thead>
                                        </form>
                                    </div>

                                    <div class="table-responsive demo-table">
                                        <table id="datatable_pr" class="display" width="100%">
                                            <div class="panel-title">
                                                <h5> List Data</h5>
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size='1'>Kode PO</font>
                                                    </th>
                                                    <th align='center'>
                                                        <font size='1'>Tgl Transaksi</font>
                                                    </th>
                                                    <th align='center'>
                                                        <font size='1'>Petugas Input</font>
                                                    </th>
                                                    <th align='center'>
                                                        <font size='1'>Keterangan PO</font>
                                                    </th>
                                                    <th align='center'>
                                                        <font size='1'>Jenis Purchase</font>
                                                    </th>
                                                    <th align='center'>
                                                        <font size='1'>Total</font>
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
<script src="<?= BASEURL; ?>/js/App/inventory/Deliveryorder/DeliveryOrder_View.js"></script>