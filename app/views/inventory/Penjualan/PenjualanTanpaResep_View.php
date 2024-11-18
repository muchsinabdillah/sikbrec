<div class="main-page">
    

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <!-- <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5> -->
                                <h5>Input Data <?= $data['judul'] ?>(<small><sup class="color-danger">*</sup> Harus diisi</small> )</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                
                            <input type="hidden" class="form-control" autocomplete="off" name="NoRegistrasi" id="NoRegistrasi" value="0">
                                        <input type="hidden" class="form-control" autocomplete="off" name="No_Order" id="No_Order">
                                        <input type="hidden" class="form-control" autocomplete="off" name="No_MR" id="No_MR">
                                        <input type="hidden" class="form-control" autocomplete="off" name="No_Episode" id="No_Episode">
                                        <input type="hidden" class="form-control" autocomplete="off" name="isresep" id="isresep" value="NON RESEP">

                            <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Penjualan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="No_Transaksi" id="No_Transaksi"  value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Pasien / NIP <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <select name="JenisPasien" id="JenisPasien" class="form-control" onchange="isKaryawan(this.value)">
                                            <option value="">-- PILIH --</option>
                                            <option value="Pasien Bebas">Pasien Bebas</option>
                                            <option value="Karyawan">Karyawan</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" name="NIP_Karyawan" id="NIP_Karyawan"  readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-maroon btn-rounded waves-effect" id="btnSearchMutasi" name="btnSearchMutasi" disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Penjualan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="Tgl_Penjualan" name="Tgl_Penjualan">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Pasien<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="Nama" id="Nama">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Lahir </label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="date" id="Tgl_Lahir" name="Tgl_Lahir" >
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin </label>
                                    <div class="col-sm-3">
                                        <select name="JenisKelamin" id="JenisKelamin" class="form-control">
                                            <option value="">-- PILIH --</option>
                                            <option value="LAKI-LAKI">Laki-laki</option>
                                            <option value="PEREMPUAN">Perempuan</option>
                                        </select>
                                        <!-- <input type="text" class="form-control" autocomplete="off" name="JenisKelamin" id="JenisKelamin" readonly> -->
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Unit <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <input type="hidden" name="Unit" id="Unit" />
                                    <select name="Unit_Select" id="Unit_Select" class="form-control" onchange="changeVal(this)">
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="Alamat" id="Alamat">
                                    </div>
                                </div>
                                

                                <div class="form-group gut">
                                    <!-- <label for=" inputEmail3" class="col-sm-2 control-label"> Jaminan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3"> -->
                                    <!-- <label for=" inputEmail3" class="col-sm-2 control-label"> Unit Farmasi <sup class="color-danger">*</sup></label> -->
                                    <div class="col-sm-3" style="display: none;">
                                    <select name="Unit_Farmasi" id="Unit_Farmasi" class="form-control">
                                        </select>
                                    </div>
                                        <input type="hidden" class="form-control" autocomplete="off" name="Jaminan" id="Jaminan" readonly>
                                        <!-- <input type="hidden" class="form-control" name="KodeJaminan" id="KodeJaminan" value="315" readonly>
                                        <input type="hidden" class="form-control" name="TipePasien" id="TipePasien" value="1" readonly> -->
                                        <input type="hidden" class="form-control" name="KodeKelas" id="KodeKelas" readonly>
                                    <!-- </div> -->
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Notes <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control input-sm " id="Notes" name="Notes" placeholder="Ketik Keterangan Disini"></textarea>
                                    </div>
                                    
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Grup Jaminan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select name="TipePasien" id="TipePasien" class="form-control" onchange="getIDPenjamin(this.value)">
                                        <option value="">--PILIH--</option>
                                        <option value="1">UMUM</option>
                                        <option value="2">ASURANSI</option>
                                        <option value="5">JAMINAN PERUSAHAAN</option>
                                            </select>
                                    </div>
                                   
                                </div>

                                <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label">  </label>
                                    <div class="col-sm-3">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jaminan <sup class="color-danger">*</sup></label></label>
                                    <div class="col-sm-3">
                                    <input type="hidden" name="KodeJaminan" id="KodeJaminan" class="form-control input-sm" readonly/>
                                    <input type="hidden" name="KodeJaminan_Nama" id="KodeJaminan_Nama" class="form-control input-sm" readonly/>
                                        <select name="KodeJaminan_Select" id="KodeJaminan_Select" class="form-control" onchange="changeValJaminan(this)">
                                            </select>
                                    <input type="hidden" name="GroupJaminan" id="GroupJaminan" class="form-control input-sm" readonly/>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnNewTransaksi" name="btnNewTransaksi" disabled><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Transaction</button>
                                
                            </form>
                            
                            <br><br><br>
                            <div class="panel-title">
                                <h5>Data Barang (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
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
                                    <div class="form-group col-md-1">
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
                                        <label for="inputEmail3">Harga</label>
                                        <input type="text" class="form-control" name="HargaProduct" id="HargaProduct" readonly>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail3">Qty</label>
                                        <input type="text" class="form-control" autocomplete="off" name="Qty" id="Qty" maxlength="25">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputEmail3">Signa Terjemahan</label>
                                        <input type="text" class="form-control" name="SignaTerjemahan" id="SignaTerjemahan">
                                    </div>
                                    <div class="orm-group col-md-1">
                                        <label for="inputEmail3" class="color-white">-</label>
                                        <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnAdd" name="btnAdd"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                    </div>
                            </div>

                            <br>
                            <br>

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
                                                    <font size='1'>Racik/ Non Racik</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Satuan</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Kode Barang</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Nama Barang</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Sigan Latin</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Signa Terjemahan</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Qty Order</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Qty Realisasi</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Harga</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Sub Total</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Discount (%)</font>
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
                                                <th colspan="7">
                                                    <font size="2">GRANDTOTAL :</font>
                                                </th>
                                               
                                               
                                               
                                                
                                                <!-- <th>
                                                    <font size="1">
                                                        <div id="LDiscProsenDisc"></div>
                                                    </font>
                                                </th> -->
                                                <th>
                                                    <font size="1"><input type="hidden" name="grandtotalqty" id="grandtotalqty" class="form-control grandtotalqty" readonly /></font><font size="2"><span id="grandtotalqty_tmp"></span></font>
                                                </th>
                                                <!-- <th>
                                                    <font size="1">
                                                        <div id="LTaxDisc"></div>
                                                    </font>
                                                </th> -->
                                                <th> <font size="1"><input type="hidden" name="hargatotal" id="hargatotal" class="form-control hargatotal" readonly /></font><font size="2"><span id="hargatotal_tmp"></span></font></th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LSubtotal"></div>
                                                    </font><input type="hidden" name="subtotalttlrp" id="subtotalttlrp" class="form-control subtotalttlrp" readonly /><font size="2"><span id="subtotalttlrp_tmp"></span></font>
                                                </th>
                                                <th>
                                                    <font size="1">
                                                        <div id="LDiscRpDisc"></div>
                                                    </font><input type="hidden" name="diskonxRp" id="diskonxRp" class="form-control diskonxRp" readonly /><font size="2"><input type="hidden" name="diskonxPros" id="diskonxPros" class="form-control" readonly /><span id="diskonxRp_tmp"></span></font>
                                                </th>
                                                <input type="hidden" name="taxxRp" id="taxxRp" class="form-control taxxRp" readonly />
                                                <!-- <font size="2"><span id="taxxRp_tmp"></span></font> -->
                                                <th>
                                                    <font size="1">
                                                        <div id="Grandtotal"></div>
                                                    </font><input type="hidden" name="totalrow" id="totalrow" class="form-control totalrow" readonly /><input type="hidden" name="grandtotalxl" id="grandtotalxl" class="form-control grandtotalxl" readonly /><font size="2"><span id="grandtotalxl_tmp"></span></font>

                                                    <font size="1"><input type="hidden" name="grantotalOrder_closing" id="grantotalOrder_closing" class="form-control" readonly /></font>
                                                </th>
                                                <th>
                                                    <font size="1"> </font>
                                                </th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>

                            <hr>

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnSimpan" name="btnSimpan" disabled><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
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

<div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static">
                            <div class="modal-dialog  modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                                        <h4 class="modal-title" id="myModalLabel">Cetak</h4>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <!-- <div class="col-sm-4">
                                            <a href="#" id="btnCetakResep" name="btnCetakResep">
                                            <p class="text-center"><strong>Cetak Resep</strong></p>
                                            <img src="<?= BASEURL; ?>/images/jenisPrint/cetakresep.Png" id="logocetaklabelpasien" class="img-round" alt="Cetak Label" width="100" height="100" style="margin-left:35px"></a>
                                        </div>

                                        <div class="col-sm-4">
                                            <a href="#" id="btnCopyResep" name="btnCopyResep">
                                            <p class="text-center"><strong>Copy Resep</strong></p>
                                            <img src="<?= BASEURL; ?>/images/jenisPrint/copyresep.png" id="logocetaklabelpasien" class="img-round" alt="Cetak Label" width="100" height="100" style="margin-left:35px"></a>
                                        </div> -->

                                        <div class="col-sm-4">
                                            <a href="#" id="btnPrintLabelAll" name="btnPrintLabelAll">
                                            <p class="text-center"><strong>Label Pasien</strong></p>
                                            <img src="<?= BASEURL; ?>/images/jenisPrint/kartu-identitas.Png" id="logocetaklabelpasien" class="img-round" alt="Cetak Label" width="100" height="100" style="margin-left:35px"></a>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="modal-footer">
                                        <!-- <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnCetakResep" name="btnCetakResep"><i class="fa fa-print"></i> Cetak Resep</button>
                                        </div>
                                        <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnCopyResep" name="btnCopyResep"><i class="fa fa-print"></i> Copy Resep</button>
                                        </div>
                                        <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnPrintLabelAll" name="btnPrintLabelAll"><i class="fa fa-print"></i> Cetak Label</button>
                                        </div> -->
                                        
                                        <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnClosePrintModal" name="btnClosePrintModal" onclick="MyBack()" data-dismiss="modal><i class="fa fa-close"></i> Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

<!-- Modal Approve ------------------------------------------------>
<div class="modal fade" id="btnSearching_modal" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

<div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"> VERIFIKASI NOMOR INDUK PEGAWAI</h4>
        </div>

        <div class="panel-body">
                <div class="alert alert-success alert-dismissible">
                    <strong>Info !</strong> Silahkan Cari Data Karyawan Disini.
                </div>
                <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-3 control-label">Ketik Nama / NIP Karyawan :</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="namakaryawan" id="namakaryawan" placeholder="Ketik kata kunci">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm btn-rounded " id="btnSearching" name="btnSearching" onclick="showDataKaryawan()">
                        <span class="glyphicon glyphicon glyphicon-search"></span> Cari</button>
                    </thead>
        </div>

        <div class="table-responsive">
        <table id="examplex" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center' style="width: 3em;">
                                                <font size="1">NIP
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl Lahir
                                            </th>
                                            <th align='center'>
                                                <font size="1">Handphone
                                            </th>
                                            <th align='center'>
                                                <font size="1">Email
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
            <a class="btn btn-default" href="#" id="CloseMe" name="CloseMe" onclick="MyBack()">Close</a>
        </div>

        <!--#END Modal Approve--------------------------------------------->

<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/inventory/Penjualan/PenjualanTanpaResep_View.js"></script>