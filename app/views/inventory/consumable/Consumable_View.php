<div class="main-page"> 
    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <!-- <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5> -->
                                <h5>Pemakaian Barang Obat/Bhp (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Transaksi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="No_Transaksi" id="No_Transaksi" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-3 control-label"> Unit Tujuan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="Unit" id="Unit" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="TglTransaksi" name="TglTransaksi">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Grup Transaksi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="Group_Transaksi" id="Group_Transaksi" class="form-control">
                                            <option value="">-- PILIH --</option>
                                            <option value="1">FARMASI</option>
                                            <option value="2">LOGISTIK</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No Registrasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" autocomplete="off" name="NoRegistrasi" id="NoRegistrasi" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-maroon btn-rounded waves-effect" id="btnSearchReg" name="btnSearchReg"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>
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
                                    <label for="inputEmail3">Barang Yang Dipilih</label>
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
                                    <!-- <div class="form-group col-md-1">
                                        <label for="inputEmail3">HPP</label>
                                        <input type="hidden" class="form-control" autocomplete="off" name="hpp_add" id="hpp_add" maxlength="25">
                                    </div> -->
                                    <div class="orm-group col-md-2">
                                        <label for="inputEmail3" class="color-white">-</label>
                                        <button class="btn btn-maroon btn-rounded waves-effect" id="btnAdd" name="btnAdd"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                    </div>
                            </div>

                            <!-- <div class="panel-title">
                                <h5>Data Detail (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                            
                            <table id="tbl_aktif" class="display table table-striped table-bordered" cellspacing="0" width="100%">
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
                            </table> -->

                            <div class="panel-title">
                                <h5>Data Detail (<small><sup class="color-danger">*</sup> Harus diisi</small>) </h5>
                            </div>

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
                                               <!-- <th><font size="1">Satuan</font></th> -->
                                               <th><font size="1">Qty</font></th>
                                               <th><font size="1">Satuan Barang</font></th>
                                               <th><font size="1">Konversi Qty</font></th>
                                               <th><font size="1">Hpp</font></th>
                                               <th><font size="1">Total</font></th>
                                               <th><font size="1">Action</font></th>
                                             </tr>
                                           </thead>
                                                  <tbody id="user_data_closing">
                                           </tbody>
                                            <tfoot>
                                             <tr>

                                               <th colspan="2">
                                                    <font size="1">GRANDTOTAL :</font>
                                                </th>
                                                <th>
                                                    <font size="1"><div id="grandtotalqty_text"></div></font>
                                                </th>
                                                <th>
                                                    <font size="1"><input type="hidden" name="grantotalOrder_closing" id="grantotalOrder_closing" class="form-control" readonly /></font>
                                                </th>
                                                <th>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="HppTotal_text"></div>
                                                    </font><input type="hidden" name="HppTotal" id="HppTotal" class="form-control taxxRp" readonly />
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="grandtotalxl_text"></div>
                                                    </font><input type="hidden" name="grandtotalxl" id="grandtotalxl" class="form-control grandtotalxl" readonly />
                                                </th>
                                               
                                                <th>
                                                <!-- <font size="1">
                                                <input type="text" name="totalrow_closing" id="totalrow_closing" class="form-control" readonly /></font> -->
                                                </th>
                                             </tr>
                                           </tfoot>
                                         </table>
                                       </div>

                                     </div>
        </form>

                            <div class="form-group">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3">Total QTY</label>
                                    <input type="text" class="form-control" name="totalQty" id="totalQty" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3">Total Row</label>
                                    <input type="text" class="form-control"  name="totalrow_closing" id="totalrow_closing" readonly>
                                </div>
                            </div>
                            <br><br>
                            <br><br>
                          <div class="btn-group" role="group">
                                <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnSave" name="btnSave" disabled><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-gold btn-rounded" id="btn_batal" name="btn_batal" disabled><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                <button class="btn btn-black btn-rounded " id="btnprint" name="btnprint" data-toggle='modal'>
                                    <i class="fa fa-print"></i>PRINT</button>
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

<div class="modal fade" id="btnSearching_modal" tabindex="-1" role="dialog">

<div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> List Registrasi Aktif</h4>
        </div>

        <div class="panel-body">

        <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                      <li role="presentation" class="active"><a class="" href="#datadetil" aria-controls="datadetil" role="tab" data-toggle="tab">Pasien Rawat Jalan</a>
                                      </li>
                                      <li role="presentation"><a class="" href="#pendidikan" aria-controls="pendidikan" role="tab" data-toggle="tab">Pasien Rawat Inap</a></li>

                                  </ul>
                                  <!-- Tab panes -->
                                  <div class="tab-content bg-white p-15">

                                      <div role="tabpanel" class="tab-pane active" id="datadetil">

                                      <form class="form-horizontal" id="form_rajal">
                                              <div class="form-group">
                                                  <label for="inputEmail3" class="col-sm-3 control-label"> Masukan
                                                      Periode Pencarian <sup class="color-danger">*</sup></label>
                                                  <div class="col-sm-2">
                                                      <input class="form-control input-sm" type="date" id="tglawalrajal" autocomplete="off" name="tglawalrajal" placeholder="ketik Kata Kunci disini" value="<?= Utils::datenowcreateNotFull() ?>">
                                                  </div>
                                                  <div class="col-sm-2">
                                                      <input class="form-control input-sm" type="date" id="tglakhirrajal" autocomplete="off" name="tglakhirrajal" placeholder="ketik Kata Kunci disini" value="<?= Utils::datenowcreateNotFull() ?>">
                                                  </div>
                                                  <div class="col-sm-1">
                                                  <button type="button"" id="btncarirajal" class="btn btn-maroon btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                                               </div>
                                              </div>
                                          </form>

                                          <div class="demo-table"   id="tbl_rekap" style="margin-top: 10px;overflow-x:auto; ">
                                          <table id="listbillingrajal" class="display" width="100%">
                                                <!-- <div class="table-responsive" style="margin-top: 70px;">
                                <table id="listbillingrajal" class="display" width="100%"> -->
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <font size="1">No MR</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">No. Registrasi</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Nama Pasien</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Tanggal Kunjungan</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Unit</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Dokter</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Penjamin</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Nama Penjamin</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Status</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Action</font>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                          </div>


                                      </div>
                                      <div role="tabpanel" class="tab-pane" id="pendidikan">
                                          <form class="form-horizontal" id="form_resign">
                                              <div class="form-group  ">
                                                  <label for="inputEmail3" class="col-sm-3 control-label"> Masukan
                                                      Periode Pencarian <sup class="color-danger">*</sup></label>
                                                  <div class="col-sm-2">
                                                      <input class="form-control input-sm" type="date" id="tglawalranap" autocomplete="off" name="tglawalranap" placeholder="ketik Kata Kunci disini" value="<?= Utils::datenowcreateNotFull() ?>">
                                                  </div>
                                                  <div class="col-sm-2">
                                                      <input class="form-control input-sm" type="date" id="tglakhirranap" autocomplete="off" name="tglakhirranap" placeholder="ketik Kata Kunci disini" value="<?= Utils::datenowcreateNotFull() ?>">
                                                  </div>
                                                  <div class="col-sm-1">
                                                  <button type="button"" id="btncariranap" class="btn btn-maroon btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                                               </div>
                                              </div>
                                              
                                          </form>
                                          <div class="demo-table" width="100%" id="tbl_rekap" style="margin-top: 10px;overflow-x:auto;">
                                          <table id="listbillingranap" class="display" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <font size="1">No MR</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">No. Registrasi</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Nama Pasien</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Tanggal Kunjungan</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Unit</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Dokter</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Penjamin</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Nama Penjamin</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Status</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Action</font>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                          </div>
                                      </div>
                                  </div>

        </div>

        <!-- <div class="table-responsive">
            <table id="datatable_rj" class="display demo-table" width="100%">
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
        </div> -->

        <div class="modal-footer">
            <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
        </div>

        <!--#END Modal Approve--------------------------------------------->
    </div>
</div>
<!-- /.col-md-12 -->
</div>


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
<script src="<?= BASEURL; ?>/js/App/inventory/consumable/ConsumableBarang_View.js"></script>