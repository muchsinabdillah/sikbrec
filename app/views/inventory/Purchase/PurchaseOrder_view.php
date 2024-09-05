<div class="main-page">

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4> Data <?= $data['judul'] ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">No.Transaksi :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="No_Transaksi" id="No_Transaksi" value="<?= $data['id'] ?>" placeholder="Ketik No. Transaksi" readonly>
                                        <input type="hidden" class="form-control" name="action" id="action" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">No.Request :</label>
                                    <button type="button" class="btn btn-maroon btn-sm btn-rounded " id="btnSearching" name="btnSearching">
                                        <span class="glyphicon glyphicon glyphicon-search"></span> Search</button>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="No_Request" id="No_Request" placeholder="Masukkan No.Request" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Transaksi :</label>
                                    <div class="col-sm-4">
                                        <input type="datetime-local" class="form-control" name="Tgl_Transaksi" id="Tgl_Transaksi" placeholder="Masukkan Tanggal Transaksi">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Request :</label>
                                    <div class="col-sm-4">
                                        <input type="datetime-local" class="form-control" name="Tgl_Request" id="Tgl_Request" placeholder="Masukkan Tanggal Request" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">User Entri :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="User_Entri" id="User_Entri" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">User Request :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="User_Request" id="User_Request" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">

                                    
                                    <label for="inputEmail3" class="col-sm-2 control-label">Unit Request :</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" class="form-control" name="Unit_Request" id="Unit_Request">
                                        <select name="Unit_Requestx" id="Unit_Requestx" class="form-control" readonly>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Request :</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" class="form-control" name="Jenis_Request" id="Jenis_Request">
                                        <select name="Jenis_Requestx" id="Jenis_Requestx" class="form-control" readonly>
                                            <option value="">-- PILIH --</option>
                                            <option value="1">FARMASI</option>
                                            <option value="2">LOGISTIK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Status :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="Status" id="Status" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan PR :</label>
                                    <div class="col-sm-4">
                                        <textarea readonly class="form-control input-sm " id="PR_Keterangan" name="PR_Keterangan" placeholder="Ketik Keterangan Disini"></textarea>
                                    </div>
                                   
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Supplier :</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="PO_KodeSupplierx" name="PO_KodeSupplierx" onchange="getIDSupplier(this)" style="width:100%">
                                        </select>
                                        <input type="hidden" class="form-control" name="PO_KodeSupplier" id="PO_KodeSupplier"  readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control input-sm " id="PO_Keterangan" name="PO_Keterangan" placeholder="Ketik Keterangan Disini"></textarea>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnNewTransaksi" name="btnNewTransaksi" disabled><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Transaction</button>
                            </form>

                            <hr>

                            <form id="user_form">
                                <div class="demo-table table-responsive" style="margin-top: 20px;">
                                    <table id="datatable_prdetail" class="display" width="100%">
                                        
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
                                                    <font size='1'>Qty MR</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Qty Order</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Harga</font>
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
                                                    <font size="1"><input type="hidden" name="grandtotalqty" id="grandtotalqty" class="form-control grandtotalqty"  /></font>
                                                    <font size="2"><span id="grandtotalqty_tmp"></span></font>
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
                                                    </font><font size="2"><input type="hidden" name="diskonxRp" id="diskonxRp" class="form-control"  />
                                                    <span id="diskonxRp_tmp"></span></font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LSubtotal"></div>
                                                    </font><font size="2"><input type="hidden" name="subtotalttlrp" id="subtotalttlrp" class="form-control"/><span id="subtotalttlrp_tmp"></span></font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LTaxDisc"></div>
                                                    </font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LTaxRp"></div>
                                                    </font><font size="2"><input type="hidden" name="taxxRp" id="taxxRp" class="form-control"  /><span id="taxxRp_tmp"></span></font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="Grandtotal"></div>
                                                    </font><input type="hidden" name="totalrow" id="totalrow" class="form-control totalrow" readonly /><input type="hidden" name="grandtotalxl" id="grandtotalxl" class="form-control"  /><font size="2">
                                                    <span id="grandtotalxl_tmp"></span></font>
                                                </th>
                                                <th>
                                                    <font size="1"> </font>
                                                </th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                            <br>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-maroon btn-rounded" id="btnSimpan" name="btnSimpan" disabled><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-gold btn-rounded" id="btn_batal" name="btn_batal" disabled><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                <button class="btn btn-black btn-rounded " id="btnprint" name="btnprint" data-toggle='modal'>
                                    <i class="fa fa-print"></i>PRINT</button>
                                <button type="button" class="btn btn-grey btn-rounded" id="btn_kembali" name="btn_kembali" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
                            </div>

                            <div style="float: right;">
                                <button type="button" class="btn btn-gold btn-rounded" id="btnCloseTrs" name="btnCloseTrs" title="Klik tombol Close ini jika PO yang di buat tidak kunjung datang barangnya!" ><i class="fa fa-archive" aria-hidden="true"></i> Close Purchase Order</button>
                        </div>
                        <!-- Modal Batal Registrasi -->
                        <div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog  modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Cetak Purchase Order</h4>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-wide btn-rounded" id="cetakan" name="cetakan"><i class="fa fa-print"></i> Cetak </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="notif_konversi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog  modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Konversi Satuan Purcahse Order</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group"> 
                                                <label for="inputEmail3" class="col-sm-2 control-label">Id:</label> 
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="Kon_Detailid" id="Kon_Detailid" placeholder="Masukkan No.Request" readonly>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label">Satuan :</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="Kon_SatuanBesar" id="Kon_SatuanBesar" placeholder="Masukkan No.Request" readonly>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label">Qty Awal :</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="Kon_QtyAwal" id="Kon_QtyAwal" placeholder="Masukkan No.Request" readonly>
                                                </div>
                                            </div> 
                                        </div> 
                                        <br>
                                        <div class="row"> 
                                            <div class="form-group"> 
                                                <h5 class="underline mt-30">Silahkan Rubah Isi Satuan Disini</h5>
                                                <label for="inputEmail3" class="col-sm-2 control-label">Pilih Satuan :</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control js-example-basic-single" id="PilihKonversi" name="PilihKonversi" onchange="getIdDetailKonversiPo(this)" style="width:100%">
                                                    </select>
                                                    <input type="hidden" class="form-control" name="PilihKonversikode" id="PilihKonversikode"  readonly>
                                                </div>
                                            </div> 
                                        </div> <br>
                                        <div class="row"> 
                                            <div class="form-group">  
                                                <label for="inputEmail3" class="col-sm-2 control-label">Satuan Beli :</label>
                                                <div class="col-sm-2"> 
                                                    <input type="text" class="form-control" name="Kon_DataSatBesar" id="Kon_DataSatBesar"  readonly>
                                                </div>
                                            
                                                <label for="inputEmail3" class="col-sm-2 control-label">Satuan Jual :</label>
                                                <div class="col-sm-2"> 
                                                    <input type="text" class="form-control" name="Kon_DataSatKecil" id="Kon_DataSatKecil"  readonly>
                                                </div>  
                                                <label for="inputEmail3" class="col-sm-2 control-label">Konversi Satuan :</label>
                                                <div class="col-sm-2"> 
                                                    <input type="text" class="form-control" name="Kon_KonversiDatasatuan" id="Kon_KonversiDatasatuan"  readonly>
                                                </div>
                                            </div>  
                                        </div> 
                                        <br>
                                        <div class="row"> 
                                            <div class="form-group">  
                                                <label for="inputEmail3" class="col-sm-2 control-label">Qty Beli ( Satuan Beli ) :</label>
                                                <div class="col-sm-2"> 
                                                    <input type="text" class="form-control" name="Kon_EntriQty" id="Kon_EntriQty" onkeyup="calculatedata()" >
                                                </div>
                                            
                                                <label for="inputEmail3" class="col-sm-2 control-label">Total Qty Beli :</label>
                                                <div class="col-sm-2"> 
                                                    <input type="text" class="form-control" name="Kon_EntriQtyTotal" id="Kon_EntriQtyTotal"  readonly>
                                                </div>  
                                                 
                                            </div>  
                                        </div> 
                                    </div> 
                                    <div class="modal-footer">

                                        <div class="btn-group" role="group"> 
                                            <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnUpdateKonersi" name="btnUpdateKonersi"> Update </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                        <!-- /.btn-group -->
                                        <!-- Modal Approve ------------------------------------------------>
                                        <div class="modal fade" id="btnSearching_modal" tabindex="-1" role="dialog">

                                            <div class="modal-dialog modal-lg" style="width:70%">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title"> List Data Approved Purchase Requestion</h4>
                                                    </div>

                                                    <div class="panel-body">
                                                        <form class="form-horizontal" id="form_cuti">
                                                            <div class="alert alert-success alert-dismissible">
                                                                <strong>Info !</strong> Silahkan Cari Data Purchase Requestion disini.
                                                            </div>
                                                            <div class="form-group gut">

                                                                <label for="inputEmail3" class="col-sm-1 control-label">Periode:</label>
                                                                <div class="col-sm-3">
                                                                    <input type="date" class="form-control" name="tglawal_pr" id="tglawal_pr" placeholder="Tanggal dari" value="<?= Utils::datenowcreateNotFull() ?>">
                                                                </div>
                                                                <label for="inputEmail3" class="col-sm-1 control-label">s / d</label>
                                                                <div class="col-sm-3">
                                                                    <input type="date" class="form-control" name="tglakhir_pr" id="tglakhir_pr" placeholder="Tanggal Sampai" value="<?= Utils::datenowcreateNotFull() ?>">
                                                                </div>
                                                                <a class="btn btn-maroon btn-sm btn-rounded " id="btnSearching" name="btnSearching" onclick="ShowApprovedPRbyDate()">
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
                                                                        <font size='1'>No. Transaksi</font>
                                                                    </th>
                                                                    <th align='center'>
                                                                        <font size='1'>Tgl Transaksi</font>
                                                                    </th>
                                                                    <th align='center'>
                                                                        <font size='1'>Petugas & Unit Input</font>
                                                                    </th>
                                                                    <th align='center'>
                                                                        <font size='1'>Status</font>
                                                                    </th>
                                                                    <th align='center'>
                                                                        <font size='1'>Jenis Request</font>
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
                                    <!-- /.section -->
                                </div>

                                <!-- /.content-container -->
                            </div>
                            <!-- /.content-wrapper -->

                        </div>
                        <!-- /.main-wrapper -->
                        <!-- ========== COMMON JS FILES ========== -->
                        <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
                        <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
                        <script src="<?= BASEURL; ?>/js/App/inventory/purchaseorder/input/purchaseOrderInput_V06.js"></script>