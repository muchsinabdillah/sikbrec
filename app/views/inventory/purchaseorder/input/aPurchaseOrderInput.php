  <?php
    date_default_timezone_set('Asia/Jakarta');
    $id = "";
    $datenowcreate = date("Y-m-d");
    $datetimenow2222 = date("Y-m-d\TH:i:s");

    ?>
  <div class="main-page">
      <section class="section" style="margin-top: -20px;">
          <div class="container-fluid">

              <div class="row">
                  <div class="col-md-12">
                      <div class="panel">
                          <div class="panel-heading">
                              <div class="panel-title">
                                  <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi </small></h5>
                              </div>
                          </div>
                          <div class="panel-body">
                              <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                  <h5 class="underline mt-30">DATA DETIL ORDER</h5>
                                  <div class="form-group  ">
                                      <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Trs <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" type="hidden" id="TglNowTemp" value="<?= $datetimenow2222 ?>" readonly autocomplete="off" name="TglNowTemp">
                                          <input class="form-control input-sm" type="text" id="PO_NoTrs" autocomplete="off" name="PO_NoTrs" readonly placeholder="No. Trs PO" autocomplete="off" value="<?= $data['id'] ?>">
                                          <input class="form-control input-sm" type="hidden" id="is_batal" autocomplete="off" name="is_batal" readonly>
                                      </div>

                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Trs <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" type="date" id="PO_TglTrs" readonly name="PO_TglTrs">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> User Input <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" readonly type="hidden" id="PO_UserIdInput" name="PO_UserIdInput" placeholder="Jenis Pasien">
                                          <input class="form-control input-sm" readonly type="text" id="PO_UserIdInputName" name="PO_UserIdInputName" placeholder="Nama User">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Supplier <sup class="color-danger">*</sup></label>

                                      <div class="col-sm-4">
                                          <select class="form-control input-sm" name="PO_KodeSupplier" id="PO_KodeSupplier">
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Purchase <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <select class="form-control input-sm" name="PO_JenisPurchase" id="PO_JenisPurchase">
                                              <option value="">-- PILIH --</option>
                                              <option value="1">FARMASI</option>
                                              <option value="2">LOGISTIK UMUM</option>
                                          </select>
                                      </div>
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Keterangan <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <textarea class="form-control input-sm" id="PO_Keterangan" name="PO_Keterangan" rows="4" style="resize: none"></textarea>
                                      </div>
                                  </div>
                              </form>
                              <div class="form-group gut">
                                  <label for=" inputEmail3" class="col-sm-2 control-label"></label>
                                  <div class="col-sm-4">
                                      <button id="btnNewTransaksi" name="btnNewTransaksi" class="btn btn-success btn-sm">
                                          NEW ORDER
                                      </button>
                                  </div>
                              </div><br><br>
                              <h5 class="underline mt-30">MASUKAN DATA BARANG</h5>
                              <div class="form-group  ">
                                  <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>">
                                  <label for="inputEmail3" class="col-sm-2 control-label"> Cari Barang <sup class="color-danger">*</sup></label>
                                  <div class="col-sm-4">
                                      <select onchange="showBarangById()" id='Po_SrcBarang' class="form-control">
                                          <option value=''>- Search Barang -</option>
                                      </select>
                                  </div>

                                  <label for=" inputEmail3" class="col-sm-2 control-label"> Harga / Satuan <sup class="color-danger">*</sup></label>
                                  <div class="col-sm-2">
                                      <input class="form-control input-sm" type="text" id="PO_Harga" name="PO_Harga" placeholder="Harga/Price" onkeypress="if(event.key == 'Enter') {goPO_DiscProsen()}">
                                  </div>
                                  <div class="col-sm-2">
                                      <input class="form-control input-sm" readonly type="text" id="PO_Satuan" name="PO_Satuan" placeholder="Satuan">
                                  </div>
                              </div>
                              <div class="form-group gut">
                                  <label for="inputEmail3" class="col-sm-2 control-label"> Disc / Tax (%) <sup class="color-danger">*</sup></label>
                                  <div class="col-sm-2">
                                      <input class="form-control input-sm" type="text" id="PO_DiscProsen" name="PO_DiscProsen" placeholder="Disc Prosen" onkeypress="if(event.key == 'Enter') {goPO_TaxProsen()}">
                                  </div>
                                  <div class="col-sm-2">
                                      <input class="form-control input-sm" type="text" id="PO_TaxProsen" name="PO_TaxProsen" placeholder="Tax Prosen" onkeypress="if(event.key == 'Enter') {goPO_Qty()}">
                                  </div>
                                  <label for=" inputEmail3" class="col-sm-2 control-label"> Qty <sup class="color-danger">*</sup></label>
                                  <div class="col-sm-1">
                                      <input class="form-control input-sm" type="text" id="PO_Qty" name="PO_Qty" onkeypress="if(event.key == 'Enter') {goAddDetil()}">
                                  </div>
                              </div> <br><br><br><br>

                              <h5 class="underline mt-30">DATA LIST BARANG</h5>
                              <div class="table-responsive">
                                  <table id="table_purchase_order" class="display table table-striped table-bordered" width="100%">
                                      <thead>
                                          <tr>
                                              <th>
                                                  <font size="1">No.</font>
                                              </th>
                                              <th>
                                                  <font size="1">Kode Barang</font>
                                              </th>
                                              <th>
                                                  <font size="1">Nama Barang</font>
                                              </th>
                                              <th>
                                                  <font size="1">Satuan</font>
                                              </th>
                                              <th>
                                                  <font size="1">Qty Order</font>
                                              </th>
                                              <th>
                                                  <font size="1">Harga</font>
                                              </th>
                                              <th>
                                                  <font size="1">Disc (%) </font>
                                              </th>
                                              <th>
                                                  <font size="1">Disc (Rp) </font>
                                              </th>
                                              <th>
                                                  <font size="1">Subtotal</font>
                                              </th>
                                              <th>
                                                  <font size="1">Tax(%)</font>
                                              </th>
                                              <th>
                                                  <font size="1">Tax(Rp)</font>
                                              </th>
                                              <th>
                                                  <font size="1">Grandtotal</font>
                                              </th>
                                              <th>
                                                  <font size="1">Action</font>
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                      <footer>
                                          <th colspan="4">
                                              <font size="1">TOTAL</font>
                                          </th>
                                          <th>
                                              <font size="1">
                                                  <div id="PO_HDR_Qty"></div>
                                              </font>
                                          </th>
                                          <th>
                                              <font size="1"></font>
                                          </th>
                                          <th>
                                              <font size="1"></font>
                                          </th>
                                          <th>
                                              <font size="1"></font>
                                          </th>
                                          <th>
                                              <font size="1">
                                                  <div id="PO_HDR_Subtotal"></div>
                                              </font>
                                          </th>
                                          <th>
                                              <font size="1"></font>
                                          </th>
                                          <th>
                                              <font size="1">
                                                  <div id="PO_HDR_TaxRp"></div>
                                              </font>
                                          </th>
                                          <th>
                                              <font size="1">
                                                  <div id="PO_HDR_Total"></div>
                                              </font>
                                          </th>
                                          <th>
                                              <font size="1"></font>
                                          </th>
                                      </footer>
                                  </table>

                              </div><br>

                              <div class="btn-group" role="group">
                                  <button class="btn btn-primary  btn-rounded " id="btnSimpan" name="btnSimpan"> Simpan</button>
                                  <button class="btn btn-danger  btn-rounded " id="btnbatal" name="btnbatal" href="#modal_alert_batal" data-toggle='modal'>
                                      Batal</button>
                                  <button class="btn btn-secondary  btn-rounded " id="btnClose" name="btnClose" >
                                      Close</button>
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

  <!-- Modal Batal Registrasi -->
  <div class="modal fade" id="modal_alert_batal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Batal Purchase Order</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="frmBatalReg">
                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-4 control-label">No. Purchase Order</label>
                          <div class="col-sm-6">
                              <input class="form-control input-sm" type="text" id="noPoBatalHdr" readonly autocomplete="off" name="noPoBatalHdr" placeholder="ketik Kata Kunci disini">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                          <div class="col-sm-6">
                              <textarea class="form-control" id="AlasanBtlPoHdr" name="AlasanBtlPoHdr" rows="3"></textarea>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnVoidTrsPoAll" name="btnVoidTrsPoAll"><i class="fa fa-plus"></i> Batal </button>
                      <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/inventory/purchaseorder/input/purchaseOrderInput_V06.js"></script>