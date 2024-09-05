  <?php
    date_default_timezone_set('Asia/Jakarta');
    $id = "";
    $datenowcreate = date("Y-m-d");
    $datetimenow = date("Y-m-d\TH:i:s");
    ?>
  <div class="main-page">
      <section class="section" style="margin-top: -20px;">
          <div class="container-fluid">

              <div class="row">
                  <div class="col-md-12">
                      <div class="panel">
                          <div class="panel-heading">
                              <div class="panel-title">
                                  <h5 class="underline mt-30"><?= $data['judul'] ?><small></small>
                                      <div class="btn-group" role="group">
                                      </div>
                                  </h5>
                              </div>
                          </div>
                          <div class="panel-body">

                              <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-3 control-label"> No. Booking/Registrasi
                                          <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-6">
                                          <input class="form-control input-sm" type="text" maxlength="20" id="MNoTrs"
                                              autocomplete="off" name="MNoTrs"
                                              placeholder="Masukan No. Booking/Registrasi">
                                      </div>
                                  </div>
                                  <div class="form-group  ">
                                      <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                      <div class="col-sm-2">
                                          <button type="button" onclick="GoMonitoringBPJS();" id="caridatapasienarsip"
                                              class="btn btn-success btn-wide btn-rounded"><i
                                                  class="fa fa-search"></i>Search</button>
                                      </div>
                                  </div>
                                  <!-- <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                      <table id="tbl_kunjungan_monitoring" width="100%" class="table table-striped table-hover cell-border"> -->
                                  <div class="panel-body">
                                      <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                          <table id="tbl_kunjungan_monitoring" class="display" width="100%"
                                              class="table table-striped table-hover cell-border">
                                              <thead>
                                                  <tr>
                                                      <th align='center'>
                                                          <font size="1">Waktu RS
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Waktu
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Nama Task
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Task ID
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Kode Transaksi
                                                      </th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </form>
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
  <!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
  <div class="modal fade" id="modal_UpdateTglPulang" role="dialog" style="overflow-y: auto" data-backdrop="static"
      data-keyboard="false">

      <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> Hapus SEP Internal</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                      <h5 class="underline mt-30">Data Tanggal Pulang</h5>

                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. SEP <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" id="MNoSEPBPJS"
                                  name="MNoSEPBPJS">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> No. Rujukan <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" readonly id="MNoRujukanSEPBPJS"
                                  name="MNoRujukanSEPBPJS">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Kode Poli Rujukan <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" readonly id="KodePoliRujukanBPJS"
                                  name="KodePoliRujukanBPJS">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Rujukan <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="TglRujukanBPJS" readonly name="TglRujukanBPJS"
                                  type="date">
                          </div>
                      </div>

                  </form>
              </div>
              <div class="modal-footer">
                  <button class="btn bg-success  btn-wide" id="btnHapusInternal" name="btnHapusInternal"><i
                          class="fa fa-check"> </i> PROSES</button>
              </div>
          </div>
      </div>
  </div>
  <!--#END Modal Untuk Notif Resep---------------------------->
  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/bridgingbpjs/antrianonline/listantrianonline.js"></script>