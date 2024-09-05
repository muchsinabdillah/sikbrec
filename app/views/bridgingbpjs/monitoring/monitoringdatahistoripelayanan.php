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
                                  <div class="form-group  ">
                                      <label for="inputEmail3" class="col-sm-3 control-label"> Periode <sup
                                              class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" type="date" id="MTglKunjunganBPJS"
                                              autocomplete="off" name="MTglKunjunganBPJS"
                                              placeholder="ketik Kata Kunci disini">
                                      </div>
                                      <div class="col-sm-1">
                                          S.D
                                      </div>
                                      <div class="col-sm-2" style="margin-left: -40px;">
                                          <input class="form-control input-sm" type="date" id="MTglKunjunganBPJS_akhir"
                                              autocomplete="off" name="MTglKunjunganBPJS_akhir"
                                              placeholder="ketik Kata Kunci disini">
                                      </div>
                                  </div>
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-3 control-label"> No. Kartu Peserta <sup
                                              class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" type="text" maxlength="13"
                                              id="MNoKartuPeserta" autocomplete="off" name="MNoKartuPeserta"
                                              placeholder="No. Kartu Peserta">
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
                                                          <font size="1">No SEP
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">No Kartu
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">No Rujukan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Tgl SEP
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Nama Pasien
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Jenis Pelayanan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Diagnosa
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Kelas Rawat
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Layanan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Tgl Pulang
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">PPK Pelayanan
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
                  <h4 class="modal-title"> Update Tanggal Pulang SEP</h4>
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
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Status Pulang <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <select id="StatusPulangBPJS" nama="StatusPulangBPJS" class="form-control input-sm">
                                  <option value="">-- PILIH --</option>
                                  <option value="1">Atas Persetujuan Dokter</option>
                                  <option value="3">Atas Permintaan Sendiri</option>
                                  <option value="4">Meninggal</option>
                                  <option value="5">Lain-lain</option>
                              </select>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. Surat Meninggal <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="MNoSuratMeninggalBPJS"
                                  name="MNoSuratMeninggalBPJS">
                              <small>*) Diisi Jika Status Pulang Meninggal</small>
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Meninggal <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="TglMeninggalBPJS" name="TglMeninggalBPJS"
                                  type="date">
                              <small>*) Diisi Jika Status Pulang Meninggal</small>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Pulang <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="date" id="MTglPulangBPJS"
                                  name="MTglPulangBPJS">
                              <small>*) Diisi Jika Status Pulang Meninggal</small>
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> No. PL Manual <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="MNoPLManualBPJS" name="MNoPLManualBPJS"
                                  type="text">
                              <small>*) Diisi Jika Status Pulang Meninggal</small>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button class="btn bg-success  btn-wide" id="btnCreateSEP" name="btnCreateSEP"><i class="fa fa-check">
                      </i> PROSES</button>
              </div>
          </div>
      </div>
  </div>
  <!--#END Modal Untuk Notif Resep---------------------------->
  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/bridgingbpjs/monitoring/listMonitoringHistoryPelayananBPJS_v01.js"></script>