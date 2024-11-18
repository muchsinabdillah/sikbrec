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
                                    <!-- <label for=" inputEmail3" class="col-sm-3 control-label"> No Trs Sales <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="TransactionCodeReff" id="TransactionCodeReff"  readonly>
                                    </div> -->
                                    <label for=" inputEmail3" class="col-sm-3 control-label">No Registrasi <sup class="color-danger">*</sup></label>
                                    <!-- <div class="col-sm-1">
                                        <input type="text" class="form-control" autocomplete="off" name="NoResep" id="NoResep" readonly>
                                    </div> -->
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" autocomplete="off" name="NoRegistrasi" id="NoRegistrasi" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-maroon btn-rounded waves-effect" id="btnSearchMutasi" name="btnSearchMutasi"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="TglTransaksi" name="TglTransaksi">
                                    </div>
                                    
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nama <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NamaPasien" id="NamaPasien" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> No. MR / No. Episode <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" autocomplete="off" name="NoMR" id="NoMR" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" autocomplete="off" name="NoEpisode" id="NoEpisode" readonly>
                                    </div>
                                    
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="JenisKelamin" id="JenisKelamin" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Unit <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <input type="hidden" name="UnitCode" id="UnitCode" />
                                        <select name="UnitCodex" id="UnitCodex" onchange="getIDUnit(this)" class="form-control">
                                        </select>
                                    </div>

                                <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <textarea class="form-control input-sm" id="Alamat" name="Alamat" readonly></textarea>
                                    </div>
                                </div>
                                

                                <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Unit Sales <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <input type="hidden" name="UnitSales" id="UnitSales" />
                                        <select name="UnitSalesx" id="UnitSalesx" onchange="getIDUnitSales(this)" class="form-control">
                                        </select>
                                    </div>
                               
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jaminan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="Jaminan" id="Jaminan" readonly>
                                        <input type="hidden" class="form-control" name="KodeJaminan" id="KodeJaminan" readonly>
                                        <input type="hidden" class="form-control" name="TipePasien" id="TipePasien" readonly>
                                        <input type="hidden" class="form-control" name="KodeKelas" id="KodeKelas" readonly>
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
                                                    <font size='1'>Qty Jual</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Qty Retur</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Harga</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Subtotal</font>
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
                                                <!-- <th>
                                                    <font size="1">
                                                        <div id="LDiscProsenDisc"></div>
                                                    </font>
                                                </th> -->
                                                <!-- <th>
                                                    <font size="1">
                                                        <div id="LDiscRpDisc"></div>
                                                    </font><input type="hidden" name="diskonxRp" id="diskonxRp" class="form-control diskonxRp" readonly /><font size="2"><span id="diskonxRp_tmp"></span></font>
                                                </th> -->
                                                <th>
                                                    <!-- <font size="1">
                                                        <div id="LSubtotal"></div>
                                                    </font><input type="hidden" name="subtotalttlrp" id="subtotalttlrp" class="form-control subtotalttlrp" readonly /><font size="2"><span id="subtotalttlrp_tmp"></span></font> -->
                                                </th>
                                                <!-- <th>
                                                    <font size="1">
                                                        <div id="LTaxDisc"></div>
                                                    </font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LTaxRp"></div>
                                                    </font><input type="hidden" name="taxxRp" id="taxxRp" class="form-control taxxRp" readonly /><font size="2"><span id="taxxRp_tmp"></span></font>
                                                </th> -->
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
                            </form>
                            <br>

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
<!-- <div class="modal fade" id="btnSearching_modal" tabindex="-1" role="dialog">

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> List Data Penjualan</h4>
        </div>

        <div class="panel-body">
            <form class="form-horizontal" id="form_cuti">
                <div class="alert alert-success alert-dismissible">
                    <strong>Info !</strong> Silahkan Cari Penjualan disini.
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
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center' style="width: 3em;">
                                                <font size="1">No
                                            </th>
                                            <th align='center'>
                                                <font size="1">No. Resep
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl Resep
                                            </th>
                                            <th align='center'>
                                                <font size="1">No Registrasi
                                            </th>
                                            <th align='center'>
                                                <font size="1">Notes
                                            </th>
                                            <th align='center'>
                                                <font size="1">User
                                            </th>
                                            <th align='center'>
                                                <font size="1">Action
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

    </div>
</div>
</div> -->
<!-- /.row -->

<!-- #modal cari pasien------>
<div class="modal fade" id="btnSearching_modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" style="width:80%">
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

            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>

            <!--#END Modal Approve--------------------------------------------->
        </div>
    </div> 
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
<script src="<?= BASEURL; ?>/js/App/inventory/returjual/ReturJualReg_View.js"></script>