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
                                  <h5 class="underline mt-30"><?= $data['judul'] ?><small></small><a
                                          class="btn btn-primary btn-sm btn-rounded " id="btncreateMR"
                                          href="#modal_Pengajuan" data-toggle='modal'>
                                          <span class="glyphicon glyphicon glyphicon-plus"></span> Create Pengajuan</a>
                                      <div class="btn-group" role="group">
                                      </div>
                                  </h5>
                              </div>
                          </div>
                          <div class="panel-body">

                              <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                  <div class="form-group  ">
                                      <label for="inputEmail3" class="col-sm-3 control-label"> Periode <sup
                                              class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" type="date" id="MTglKunjunganBPJS"
                                              autocomplete="off" name="MTglKunjunganBPJS"
                                              placeholder="ketik Kata Kunci disini">
                                      </div>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" type="date" id="MTglKunjungan2BPJS"
                                              autocomplete="off" name="MTglKunjungan2BPJS"
                                              placeholder="ketik Kata Kunci disini">
                                      </div>
                                  </div>
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-3 control-label"> Jenis Filter <sup
                                              class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <select id="MJenisPelayananBPJS" nama="MJenisPelayananBPJS"
                                              class="form-control input-sm" style="width: 100%;">
                                              <option value="">-- PILIH --</option>
                                              <option value="1">Pengajuan Backdate</option>
                                              <option value="2">Pengajuan Fingerprint</option>
                                          </select>
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
                                      <table id="tbl_kunjungan_monitoring" width="100%"
                                          class="table table-striped table-hover cell-border"> -->
                                  <div class="panel-body">
                                      <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                          <table id="tbl_kunjungan_monitoring" class="display" width="100%"
                                              class="table table-striped table-hover cell-border">
                                              <thead>
                                                  <tr>
                                                      <th align='center'>
                                                          <font size="1">No. Kartu
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Tgl Entry
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Tgl SEP
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">User Entry
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Jenis Pelayanan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Jenis Pengajuan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Catatan
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
  <div class="modal fade" id="modal_Pengajuan" role="dialog" style="overflow-y: auto" data-backdrop="static"
      data-keyboard="false">

      <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> Form Entri Pengajuan Approval SEP</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No.Kartu <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" maxlength="13" type="text" id="PengSEP_NoKartu"
                                  autocomplete="off" name="PengSEP_NoKartu">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl SEP <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-3">
                              <input class="form-control input-sm" type="date" autocomplete="off" id="PengSEP_Tgl"
                                  name="PengSEP_Tgl">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pelayanan <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <select id="isJenisPelayananBPJS" name="isJenisPelayananBPJS" style="width: 100%;"
                                  class="form-control ">
                                  <option value="">-- PILIH --</option>
                                  <option value="2">RAWAT JALAN</option>
                                  <option value="1">RAWAT INAP</option>
                              </select>
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Pengajuan <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <select id="isJenisPelayananPengajuanBPJS" name="isJenisPelayananPengajuanBPJS"
                                  style="width: 100%;" class="form-control ">
                                  <option value="">-- PILIH --</option>
                                  <option value="2">Pengajuan Fingerprint</option>
                                  <option value="1">Pengajuan Backdate</option>
                              </select>
                          </div>
                      </div>

                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Catatan <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <textarea class="form-control input-sm" id="iscatatanBPJS" name="iscatatanBPJS"
                                  rows="4"></textarea>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button class="btn btn-primary btn-rounded " id="savetrs" name="savetrs"> Simpan</button>
                      <button class="btn btn-danger btn-rounded " onclick="Passingbatal()" id="batal" name="batal"
                          href="#modal_alert_batal" data-toggle='modal'> Batal</button>
                      <button data-dismiss="modal" class="btn btn-secondary btn-rounded " id="close" name="close">
                          Close</button>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--#END Modal Untuk Notif Resep---------------------------->
  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/bridgingbpjs/approvalsep/pengajuan/pengajuanappsep_v01.js"></script>