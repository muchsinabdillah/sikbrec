<div class="main-page">

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <!-- <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5> -->
                                <h5>Input Data <?= $data['judul'] ?><(<small><sup class="color-danger">*</sup> Harus diisi</small> )</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Penjualan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="No_Transaksi" id="No_Transaksi" value="<?= $data['notrs'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label">No. Reg <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" autocomplete="off" name="NoRegistrasi" id="NoRegistrasi" readonly>
                                        <input type="hidden" class="form-control" autocomplete="off" name="isresep" id="isresep" value="CONSUMABLE"> 
                                        <input type="hidden" class="form-control" autocomplete="off" name="GroupJaminan" id="GroupJaminan" >
                                        <input type="hidden" class="form-control" autocomplete="off" name="KodeGroupJaminan" id="KodeGroupJaminan" >
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-maroon btn-rounded waves-effect" id="btnSearchReg" name="btnSearchReg"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Penjualan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="Tgl_Penjualan" name="Tgl_Penjualan">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3"> 
                                        <input type="text" class="form-control" autocomplete="off" name="JenisKelamin" id="JenisKelamin" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label">No. Episode <sup class="color-danger">*</sup></label>
                                   
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="No_Episode" id="No_Episode" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Lahir / Umur <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="date" id="Tgl_Lahir" name="Tgl_Lahir" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" autocomplete="off" name="Umur" id="Umur" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No. MR <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="No_MR" id="No_MR" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Pasien<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="Nama" id="Nama" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> DPJP <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="Dokter" id="Dokter" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="Alamat" id="Alamat" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Unit <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="Unit" id="Unit" class="form-control">
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Unit Farmasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <select name="Unit_Farmasi" id="Unit_Farmasi" class="form-control">
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jaminan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="Jaminan" id="Jaminan" readonly>
                                        <input type="hidden" class="form-control" name="KodeJaminan" id="KodeJaminan" readonly>
                                        <input type="hidden" class="form-control" name="TipePasien" id="TipePasien" readonly>
                                        <input type="hidden" class="form-control" name="KodeKelas" id="KodeKelas" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Notes <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control input-sm " id="Notes" name="Notes" placeholder="Ketik Keterangan Disini"></textarea>
                                    </div>
                                </div>
                                <div class="form-group gut"> 
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Kelas <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                    <input type="text" class="form-control" name="Kelasid" id="Kelasid" readonly> 
                                    </div>
                                    <div class="col-sm-3">
                                    <input type="text" class="form-control" name="KelasNama" id="KelasNama" readonly>
                                     
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
                                    <div class="orm-group col-md-2">
                                        <label for="inputEmail3" class="color-white">-</label>
                                        <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnAdd" name="btnAdd"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                    </div>
                            </div>

                            <br>
                            <br>

                            <hr>

                            <!-- <form id="user_form">
                                <div class="panel-body p-20">
                                    <div class="demo-table" style="overflow-x:auto;">
                                        <table id="example" class="display" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align='center' style="width: 2em;">
                                                        <font size="1">No
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Kode Barang
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Nama
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Qty Order
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Qty Realisasi
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Harga
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Satuan
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form> -->

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
                                                    <font size='1'>Satuan</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Kode Barang</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Nama Barang</font>
                                                </th> 
                                                <th align='center'>
                                                    <font size='1'>Qty Jual</font>
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
                                                <!-- <th align='center'>
                                                    <font size='1'>Action</font>
                                                </th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tbody id="user_data">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4">
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
                                                </th>
                                                <!-- <th>
                                                    <font size="1"> </font>
                                                </th> -->

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>

                            <hr>

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnSimpan" name="btnSimpan" disabled><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-gold btn-rounded" id="btn_batal" name="btn_batal" disabled><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                <!-- <button class="btn btn-black btn-rounded " id="btnprint" name="btnprint" data-toggle='modal'>
                                    <i class="fa fa-print"></i>PRINT</button> -->
                                <button type="button" class="btn btn-grey btn-rounded" id="btn_kembali" name="btn_kembali" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
                            </div>

                            <!-- <div class="row col-sm-8" style="margin-left: 90em;">
                                <button type="button" class="btn btn-primary waves-effect" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-danger" id="btn_batal" name="btn_batal"><i class="fa fa-trash" aria-hidden="true"></i>Batal</button>
                                <button type="button" class="btn btn-warning" id="btn_batal" name="btn_batal" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
                            </div> -->

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
<div class="modal fade" id="modal_editsigna" tabindex="-1" role="dialog">

  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Edit Signa Terjemahan</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <form id="form_editsigna">
            <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-8 control-label"> ID</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="id_detail" name="id_detail" readonly>
                  </div>
                </div>
                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-8 control-label"> Nama Obat</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="namaobat_signa" name="namaobat_signa" readonly>
                  </div>
                </div>

                <div class="form-group gut">
                <label for=" inputEmail3" class="col-sm-8 control-label"> Signa Latin</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="Signa_latin" name="Signa_latin" readonly>
                  </div>
                </div>

                <div class="form-group gut">
                <label for=" inputEmail3" class="col-sm-8 control-label"> Signa Terjemahan</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="Signa_edit" name="Signa_edit" >
                  </div>
                </div>

          </form>
        </div>
      </div>
      <div class="modal-footer">
        <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
        <button type="button" class="btn btn-maroon"  id="Save_Signa" name="Save_Signa">Save</button>
      </div>
    </div>
  </div>
</div>
<!--#END Modal Approve--------------------------------------------->
<!-- #modal cari pasien------>
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
</div>
<!-- #modal cari pasien------>
<div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog  modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Cetak</h4>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnCetakResep" name="btnCetakResep"><i class="fa fa-print"></i> Cetak Resep</button>
                                        </div>
                                        <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnCopyResep" name="btnCopyResep"><i class="fa fa-print"></i> Copy Resep</button>
                                        </div>
                                        <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnPrintLabelAll" name="btnPrintLabelAll"><i class="fa fa-print"></i> Cetak Label</button>
                                        </div>
                                        
                                           
                                    </div>
                                </div>
                            </div>
                        </div>



</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/inventory/consumablecharged/entry.js"></script>