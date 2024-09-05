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
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No. MR / No. Reg <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" name="No_MR" id="No_MR" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" autocomplete="off" name="NoRegistrasi" id="NoRegistrasi" readonly>
                                        <input type="hidden" class="form-control" autocomplete="off" name="isresep" id="isresep" value="RESEP">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Penjualan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="Tgl_Penjualan" name="Tgl_Penjualan">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <!-- <select name="Group_Transaksi" id="Group_Transaksi" class="form-control">
                                            <option value="">-- PILIH --</option>
                                            <option value="M">Pria</option>
                                            <option value="F">Wanita</option>
                                        </select> -->
                                        <input type="text" class="form-control" autocomplete="off" name="JenisKelamin" id="JenisKelamin" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No. Order / No. Episode <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" autocomplete="off" name="No_Order" id="No_Order" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-2">
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
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Order <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="datetime-local" id="Tgl_Order" name="Tgl_Order" readonly>

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
                                    
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Iter</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="Iter" id="Iter" readonly>
                                    </div>
                                    
                                </div>

                                <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Notes <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control input-sm " id="Notes" name="Notes" placeholder="Ketik Keterangan Disini"></textarea>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-maroon  waves-effect btn-rounded" id="btnNewTransaksi" name="btnNewTransaksi" disabled><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Transaction</button>


                            </form>

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
                                                <th colspan="8">
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

                            <hr>

                            <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Review Apoteker <sup class="color-danger">*</sup></label>
                                <div class="col-sm-12">
                                <textarea class="form-control input-sm " id="HasilReview" name="HasilReview" placeholder="Ketik Review Disini"></textarea>
                                </div>
                            </div>

                            <hr>
                            <br><br><br><br>
                            </form>

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-maroon waves-effect btn-rounded" id="btnSimpan" name="btnSimpan" disabled><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                <button type="button" class="btn btn-gold btn-rounded" id="btn_batal" name="btn_batal" disabled><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                <button class="btn btn-black btn-rounded " id="btnprint" name="btnprint" data-toggle='modal'>
                                    <i class="fa fa-print"></i>PRINT</button>
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
<script src="<?= BASEURL; ?>/js/App/inventory/Penjualan/PenjualanDenganResep_View.js"></script>