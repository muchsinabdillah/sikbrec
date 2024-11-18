<div class="main-page"> 
    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <!-- <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5> -->
                                <h5>Adjusment Stok (<small><sup class="color-danger">*</sup> Harus diisi</small>)
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Transaksi <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <div>
                                            <input type="text" class="form-control" name="No_Transaksi" id="No_Transaksi"
                                                value="<?= $data['id'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                         
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-1 control-label"> Unit <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <input type="hidden" name="Unit" id="Unit" />
                                        <select name="Unit_Select" id="Unit_Select" class="form-control" onchange="getIDUnit(this)">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="TglTransaksi"
                                            name="TglTransaksi">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Keterangan <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control input-sm " id="Notes" name="Notes" placeholder="Ketik Keterangan Disini"></textarea>
                                    </div>
                                </div>
                            </form>
                            <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnNewPurchase" name="btnNewPurchase"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Transaction</button>
                            <br><br><br>
                            <div class="panel-title">
                                <h5>Data Barang (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                            <div class="form-group">
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail3">Nama Barang</label>
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
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Satuan</label>
                                        <input type="text" class="form-control" autocomplete="off" name="Satuan" id="Satuan" readonly>
                                        <input type="hidden" class="form-control" autocomplete="off" name="Satuan_Konversi" id="Satuan_Konversi" readonly>
                                        <input type="hidden" class="form-control" autocomplete="off" readonly name="Konversi_satuan" id="Konversi_satuan" >
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Qty Stok</label>
                                        <input type="text" class="form-control" autocomplete="off" name="QtyStok" id="QtyStok" maxlength="25" readonly  >
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Qty Curr</label>
                                        <input type="text" class="form-control" autocomplete="off" name="QtyCurrent" id="QtyCurrent" maxlength="25">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Batch</label>
                                        <input type="text" class="form-control" autocomplete="off" name="BatchAdd" id="BatchAdd" >
                                        
                                        <input type="hidden" class="form-control" autocomplete="off" name="QtyAdj" id="QtyAdj" maxlength="25">
                                        <input type="hidden" class="form-control" autocomplete="off" name="hpp_add" id="hpp_add" maxlength="25">
                                    </div> 
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Expired Date</label>
                                        <input type="date" class="form-control" autocomplete="off" name="ExpiredDateAdd" id="ExpiredDateAdd" >
                                    </div> 
                                    <!-- <div class="form-group col-md-1">
                                        <label for="inputEmail3">Qty Adj</label>
                                    </div>  -->
                                    <div class="orm-group col-md-2">
                                        <label for="inputEmail3" class="color-white">-</label>
                                        <button type="button" class="btn btn-maroon btn-rounded waves-effect" id="btnAdd" name="btnAdd"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                    </div>
                            </div>
                            <form id="user_form">
                            <table id="tbl_aktif" class="table demo-table" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th align='center'>
                                            <font size="1">Kode
                                        </th>
                                        <th align='center'>
                                            <font size="1">Nama Barang
                                        </th>
                                        <th align='center'>
                                            <font size="1">Satuan
                                        </th>
                                        <th align='center'>
                                            <font size="1">Qty Stok
                                        </th>
                                        <th align='center'>
                                            <font size="1">Qty Adj
                                        </th>
                                        <th align='center'>
                                            <font size="1">Qty Akhir
                                        </th>
                                        <th align='center'>
                                            <font size="1">Hpp
                                        </th>
                                        <th align='center'>
                                            <font size="1">Persediaan
                                        </th>
                                        <th align='center'>
                                            <font size="1">Batch
                                        </th>
                                        <th align='center'>
                                            <font size="1">Expired
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

                                               <th colspan="5">
                                                    <font size="1">GRANDTOTAL :</font>
                                                </th>
                                                <th>
                                                    <font size="1"><input type="text" name="ttl_qtyAkhir" id="ttl_qtyAkhir" class="form-control" readonly /></font>
                                                </th>
                                                <th>
                                                    <font size="1"><input type="hidden" name="grantotalOrder_closing" id="grantotalOrder_closing" class="form-control" readonly /></font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LTaxRp"></div>
                                                    </font><input type="text" name="grandtotalxl" id="grandtotalxl" class="form-control grandtotalxl" readonly />
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="Grandtotal"></div>
                                                    </font><input type="hidden" name="totalrow_closing" id="totalrow_closing" class="form-control" readonly />
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="Grandtotal"></div>
                                                    </font> 
                                                </th>
                                                <th>
                                                <!-- <font size="1">
                                                <input type="text" name="totalrow_closing" id="totalrow_closing" class="form-control" readonly /></font> -->
                                                </th>
                                             </tr>
                                           </tfoot>
                            </table>
                            </form>
                            </br> 

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnSave" name="btnSave" disabled><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-grey btn-rounded" id="btn_kembali" name="btn_kembali" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
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
<script src="<?= BASEURL; ?>/js/App/inventory/adjusment/adjusment_transaction.js"></script>