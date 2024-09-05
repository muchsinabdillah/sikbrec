  <div class="main-page">
      <div class="container-fluid">
          <div class="row page-title-div">
              <div class="col-md-6">
                  <h2 class="title"><?= $data['judul'] ?></h2>
                  <p class="sub-title">Silahkan Input Transaksi Disini.</p>
              </div>
              <!-- /.col-md-6 -->
          </div>
          <!-- /.row -->
          <div class="row breadcrumb-div">
              <div class="col-sm-6">
                  <ul class="breadcrumb">
                      <li><a href="<?= BASEURL; ?>"><i class="fa fa-home"></i> Home</a></li>
                      <li class="active"><?= $data['judul'] ?></li>
                      <li class="active"><?= $data['judul_child'] ?></li>
                  </ul>
              </div>
          </div>
          <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

      <section class="section">
          <div class="container-fluid">

              <div class="row">
                  <div class="col-md-12">
                      <div class="panel">
                          <div class="panel-heading">
                              <div class="panel-title">
                                  <h5>Input Master Data <?= $data['judul'] ?> <small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                              </div>
                          </div>
                          <div class="panel-body">
                              <form class="form-horizontal" id="form_cuti">
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> ID Transaksi :</label>
                                      <div class="col-sm-2">
                                          <input type="text" class="form-control" name="IdTranasksi" id="IdTranasksi" readonly value="<?= $data['id'] ?>">
                                          <input type="hidden" class="form-control" name="IdTranasksiAuto" id="IdTranasksiAuto" readonly value="<?= $data['id'] ?>">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nama Komponen <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input type="text" class="form-control" id="Mst_NamaKOmponen" name="Mst_NamaKOmponen">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label">Jenis Komponen <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <select class="form-control js-example-basic-single" id="Mst_JenisKomponen" name="Mst_JenisKomponen">
                                              <option value="KOMPONEN IMBALAN">KOMPONEN IMBALAN</option>
                                              <option value="POTONGAN">POTONGAN</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label">Nilai Komponen <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input type="number" class="form-control" id="Mst_NilaiKomponen" name="Mst_NilaiKomponen">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label">No. Urut <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input type="number" class="form-control" id="Mst_NoUrut" name="Mst_NoUrut">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label">Status <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <select class="form-control js-example-basic-single" id="Mst_Aktif" name="Mst_Aktif">
                                              <option value="1">AKTIF</option>
                                              <option value="0">NON AKTIF</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label">Pinjaman Kantor <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <select class="form-control js-example-basic-single" id="Mst_isPinjaman" name="Mst_isPinjaman">
                                              <option value="0">TIDAK</option>
                                              <option value="1">YA</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label">Keterangan </label>
                                      <div class="col-sm-10">
                                          <textarea id="Mst_Catatan" rows="5" name="Mst_Catatan" class="form-control"></textarea>
                                      </div>
                                  </div>
                              </form>
                              <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                              <button class="btn bg-black btn-wide" id="btnAddKomponenPayroll" name="btnAddKomponenPayroll" onclick="go_save()"><i class="fa fa-check"></i>Submit</button>
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
  <!-- ========== COMMON JS FILES ========== -->

  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/MasterData/KomponenPayroll_v05.js"></script>
  <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>