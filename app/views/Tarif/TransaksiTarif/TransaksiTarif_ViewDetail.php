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
                          <div class="alert alert-success alert-dismissible">
                                        <p> <strong>Info !</strong> File Import Yang Disupport Hanya .CSV (Comma Separated  Value) !</p>
                                        <p> <strong>Info !</strong> Maksimal File Size 8 MB !</p>
                             </div>
                              <form class="form-horizontal" method="post" action="" enctype="multipart/form-data" id="formUploadManual">
                                  <div class="form-group  ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> ID TR TARIF<sup class="color-danger">*</sup></label>
                                      <div class="col-sm-3">
                                          <input class="form-control input-sm" autocomplete="off" type="text" id="idtrs" readonly value="<?= $data['id'] ?>" name="idtrs">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-1 control-label"> Tgl Berlaku</label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" autocomplete="off" type="date" id="TglBerlaku" readonly name="TglBerlaku">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-1 control-label"> Tgl Expired </label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" autocomplete="off" type="date" id="TglExpired" readonly name="TglExpired">
                                      </div>
                                   
                                  </div>
                                  <div class="form-group  ">
                                  <label for="inputEmail3" class="col-sm-2 control-label"> Note</label>
                                      <div class="col-sm-6">
                                          <input class="form-control input-sm" autocomplete="off" type="text" id="Note" readonly name="Note">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-1 control-label">Kd Instalasi</label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" autocomplete="off" type="text" id="kd_instalasi" readonly name="kd_instalasi">
                                      </div>
                                  </div>
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Pilih File <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input type="file" name="file" id="file" class="control-label">
                                      </div>
                                  </div>
                                  <button type="submit" name="btnUploads" id="btnUploads" class="btn btn-primary  btn-rounded"><span class="glyphicon glyphicon-import"></span> Import</button>
                                  &nbsp&nbsp&nbsp&nbsp
                                  <button onclick="getTemplateCSV()" type="button" name="btnDownloadTemplate" id="btnDownloadTemplate" class="btn btn-warning  btn-rounded"><span class="glyphicon glyphicon-save-file"></span> Download Template</button>
                              </form>
                              <h5 class="underline mt-30">LIST DATA DETAIL TRANSAKSI TARIF</h5>
                              <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                              <table id="datadetail" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                 <thead>
                                     <tr>
                                         <th align='center'>
                                             <font size="1">ID TR TARIF
                                         </th>
                                         <th align='center'>
                                             <font size="1">ID Tarif
                                         </th>
                                         <th align='center'>
                                             <font size="1">Group Tarif
                                         </th>
                                         <th align='center'>
                                             <font size="1">Nilai
                                         </th>
                                         <th align='center'>
                                             <font size="1">Kelas ID
                                         </th>
                                         <th align='center'>
                                             <font size="1">Group Tarif 2
                                         </th>
                                         <th align='center'>
                                             <font size="1">ID TR Tarif Paket
                                         </th>
                                         <th align='center'>
                                             <font size="1">KD Instalasi
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

  </div>
  <!-- /.content-container -->
  </div>
  <!-- /.content-wrapper -->

  </div>
  <!-- /.main-wrapper -->

  <!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
  <div class="modal fade" id="modal_Pengajuan2" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

      <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> Cek Ketersediaan Poliklinik</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                      <br>
                      <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                          <table id="tbl_Ketersediaan_Poli" width="100%" class="table table-striped table-hover cell-border">
                              <thead>
                                  <tr>
                                      <th align='center'>
                                          <font size="1">Kode Poli
                                      </th>
                                      <th align='center'>
                                          <font size="1">Nama Poli
                                      </th>
                                      <th align='center'>
                                          <font size="1">Kapasitas
                                      </th>
                                      <th align='center'>
                                          <font size="1">Jumlah Rujukan
                                      </th>
                                      <th align='center'>
                                          <font size="1">Presentase
                                      </th>

                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button data-dismiss="modal" class="btn btn-secondary btn-rounded " id="close" name="close"> <i class="fa fa-mail-reply-all"></i> Close</button>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--#END Modal Untuk Notif Resep---------------------------->
  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/Tarif/TransaksiTarif/TransaksiTarif_ViewDetail.js"></script>