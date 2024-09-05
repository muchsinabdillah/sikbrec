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
                                          <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR"
                                              onclick="gocreatebonsementara();">
                                              <span class="glyphicon glyphicon glyphicon-plus"></span> Buat Pengajuan Bon Sementara</a>
                                      </div>
                                  </h5>
                              </div>
                          </div>
                          <div class="panel-body">
                              <form class="form-horizontal" id="frmSimpanTrsRegistrasi">


                                  <!-- <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                      <table id="tbl_arsip" width="100%"
                                          class="table table-striped table-hover cell-border"> -->
                                  <div class="panel-body p-20">
                                    <div class="table-responsive">
                                        <table id="tbl_arsipa" class="display"  width="100%">
                                        <thead>
                                                  <tr>
                                                      <th align='center'>
                                                          <font size="1">ID
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">No. Trs Pengajuan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Tanggal Pengajuan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Nama Pegawai
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Keterangan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Nilai Pengajuan
                                                      </th> 
                                                      <th align='center'>
                                                          <font size="1">Status Realisasi
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Action
                                                      </th>
                                                  </tr>
                                              </thead>
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

  <!-- Modal Konfirmasi Pesan SIMPAN -->
  <div class="modal fade " id="modal_edit_sep" tabindex="-1" role="dialog">
      <div class="modal-dialog  modal-md">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"> Update No. SEP Pasien </h4>
              </div>
              <div class="modal-body">
                  <form id="frmUpdateSEP">
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">ID :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="NOID_Reg" name="NOID_Reg"
                                  maxlength="19" readonly>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">No SEP Lama :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="NoSEPLama" name="NoSEPLama"
                                  maxlength="19" readonly>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">No SEP Baru :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" autocomplete="off" id="NoSEPBaru"
                                  name="NoSEPBaru" maxlength="19">
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button data-toggle='modal' class="btn btn-primary btn-sm" type="button" id="btnUpdateSEP"
                      name="btnUpdateSEP">
                      UPDATE
                  </button>
              </div>
          </div>
      </div>
  </div>
  <!-- Modal Konfirmasi Pesan SIMPAN end -->


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

  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/finance/pengajuanbonsementara.js"></script>