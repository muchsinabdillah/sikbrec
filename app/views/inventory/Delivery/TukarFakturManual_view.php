<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?><span style="margin-left: 10px;" class="label label-success">Manual</span></h2>
                <p class="sub-title">Menampilkan Data <?= $data['judul'] ?>.</p>
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


    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5> Data Transaksi</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">No.Transaksi :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="No_Transaksi" id="No_Transaksi" value="<?= $data['id'] ?>"  readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Transaksi :</label>
                                        <div class="col-sm-3">
                                            <input type="datetime-local" class="form-control" name="Tgl_trs" id="Tgl_trs">
                                        </div>
                                    
                                </div>
                                <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label">No. PO (RS):</label>  
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="No_Purchase_Order" id="No_Purchase_Order" placeholder="No. Purchase Order Rumah Sakit">
                                            </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label">No. DO (RS):</label>  
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="No_Delivery_Order" id="No_Delivery_Order" placeholder="No. Delivery Order Rumah Sakit">
                                            </div>
                                </div>
                                <div class="panel-title">
                                    <h5> Data Faktur</h5>
                                </div>
                                <br>
                                <div class="form-group gut"> 
                                        <label for="inputEmail3" class="col-sm-2 control-label">Suppllier :</label>
                                        <div class="col-sm-3">
                                        <input type="hidden" name="PO_KodeSupplier" id="PO_KodeSupplier" />
                                            <select class="form-control js-example-basic-single" id="PO_KodeSupplierx" name="PO_KodeSupplierx" style="width:100%" >
                                            </select>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label">Unit :</label>
                                        <div class="col-sm-3">
                                        <input type="hidden" name="Unit" id="Unit"  />
                                        <select name="Unitx" id="Unitx" class="form-control" onchange="getID(this)">
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">No. Faktur PBF :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NoFakturPBF" id="NoFakturPBF" placeholder="Masukan No. Faktur PBF">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tgl Faktur PBF :</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="TglFakturPBF" id="TglFakturPBF" >
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tgl Jatuh Tempo :</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="TglJatuhTempo" id="TglJatuhTempo" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">No Faktur Pajak :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NoFakturPajak" id="NoFakturPajak" placeholder="Masukan No. Faktur Pajak">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                   
                                        <label for="inputEmail3" class="col-sm-2 control-label">Include PPN :</label>
                                        <div class="col-sm-3">
                                        <select class="form-control" name="IncludePPN" id="IncludePPN" onchange="calcPPN()"> 
                                                <option value="1">YA </option>
                                                <option value="0">TIDAK </option>
                                            </select>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label">Tipe Hutang :</label>
                                        <div class="col-sm-3">
                                        <select class="form-control" name="TipeHutang" id="TipeHutang">
                                                <option value=""> --Pilih-- </option>
                                                <option value="1">MEDIS </option>
                                                <option value="2">NON MEDIS </option>
                                                <option value="3">ASSET </option>
                                            </select>
                                        </div>
                                </div> 
                                <div class="form-group gut"> 
                                        <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="Keterangan" id="Keterangan" >
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label">No. Rek Supplier :</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="RekeningSupplier" id="RekeningSupplier"  placeholder="Masukan No. Rek Supplier">
                                        </div>
                                </div> 
                                <div class="form-group gut"> 
                                        <label for="inputEmail3" class="col-sm-2 control-label">Nama Bank Supplier :</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="RekeningBank" id="RekeningBank" placeholder="Masukan Nama Bank">
                                        </div>
                                         
                                </div> 
                                <div class="panel-title">
                                    <h5> Data NIlai Faktur</h5>
                                </div>
                                <br>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nilai Faktur :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NilaiFaktur" id="NilaiFaktur" onfocusout="calcPPN()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nilai Diskon :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NilaiDiskon" id="NilaiDiskon" onfocusout="calcPPN()">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nilai PPN (11%) :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NilaiPPN" id="NilaiPPN" disabled >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nilai Biaya Lain :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NilaiBiayaLain" id="NilaiBiayaLain" onfocusout="calcPPN()">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Nilai Pph 23 :</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NilaiPph23" id="NilaiPph23"  >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nilai Grandtotal:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NilaiGrandTotal" id="NilaiGrandTotal" readonly >
                                    </div>
                                     
                                </div>
                                <button type="button" class="btn btn-primary waves-effect" id="btnSimpan" name="btnSimpan" ><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-danger" id="btn_batal" name="btn_batal" ><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                <button type="button" class="btn btn-warning" id="btn_kembali" name="btn_kembali" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
                            </form>  
                        </div>
                      
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
<script src="<?= BASEURL; ?>/js/App/inventory/Deliveryorder/TukarFakturManual_View.js"></script>