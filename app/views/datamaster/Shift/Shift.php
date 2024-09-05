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
                                  <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small> </h5>
                              </div>
                          </div>
                          <div class="panel-body">
                              <form class="form-horizontal" id="form_cuti">
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> ID Transaksi </label>
                                      <div class="col-sm-4">
                                          <input type="text" autocomplete="off" class="form-control" name="IdTranasksi" id="IdTranasksi" readonly value="<?= $data['id'] ?>">
                                          <input type="hidden" autocomplete="off" class="form-control" name="IdTranasksiAuto" id="IdTranasksiAuto" readonly value="<?= $data['id'] ?>">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-3 control-label"> Finger IN kurang dari </label>
                                      <div class="col-sm-2">
                                          <input type="number" autocomplete="off" class="form-control" id="masuk_kurang" name="masuk_kurang">
                                      </div> (menit)
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Kode Shift <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input type="text" autocomplete="off" class="form-control" id="Mst_KodeShift" name="Mst_KodeShift">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-3 control-label"> Finger IN lebih dari </label>
                                      <div class="col-sm-2">
                                          <input type="number" autocomplete="off" class="form-control" id="masuk_lebih" name="masuk_lebih">
                                      </div> (menit)
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nama Shift <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input type="text" autocomplete="off" class="form-control" id="Mst_NamaShift" name="Mst_NamaShift">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-3 control-label"> Finger OUT kurang dari </label>
                                      <div class="col-sm-2">
                                          <input type="number" autocomplete="off" class="form-control" id="keluar_kurang" name="keluar_kurang">
                                      </div> (menit)
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Jam Awal Shift <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input type="time" autocomplete="off" class="form-control" id="Mst_JamAwal" name="Mst_JamAwal">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-3 control-label"> Finger OUT lebih dari </label>
                                      <div class="col-sm-2">
                                          <input type="number" autocomplete="off" class="form-control" id="keluar_lebih" name="keluar_lebih">
                                      </div> (menit)
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Jam Akhir Shift <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input type="time" autocomplete="off" class="form-control" id="Mst_JamAkhir" name="Mst_JamAkhir">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Kode Group Shift <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <select class="form-control js-example-basic-single" id="Mst_KodeGroupShift" name="Mst_KodeGroupShift">
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Status <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <select class="form-control" id="MSt_Status" name="MSt_Status">
                                              <option value="1">AKTIF</option>
                                              <option value="0">NON AKTIF</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">

                                  </div>
                                  <div class="form-group">

                                  </div>
                                  <div class="form-group">

                                  </div>
                                  <div class="form-group">

                                  </div>
                              </form>
                              <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                              <button class="btn bg-black btn-wide" id="btnAddShift" name="btnAddShift" onclick="go_save()"><i class="fa fa-check"></i>Submit</button>
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
  <script src="<?= BASEURL; ?>/js/App/MasterData/Shift_v06.js"></script>