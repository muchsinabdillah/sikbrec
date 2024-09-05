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
                                          <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="gocreate();">
                                              <span class="glyphicon glyphicon glyphicon-plus"></span> Create Purchase Order</a>
                                      </div>
                                  </h5>
                              </div>
                          </div>
                          <div class="panel-body">
                              <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                  <div class="form-group  ">
                                      <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Supplier </label>
                                      <div class="col-sm-4">
                                          <select class="form-control input-sm" name="KodeSupplier" id="KodeSupplier">
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Periode </label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" value="<?= $datenowcreate ?>" type="date" id="TglPeriodeAwal" autocomplete="off" name="TglPeriodeAwal">
                                      </div>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" value="<?= $datenowcreate ?>" type="date" id="TglPeriodeAkhir" autocomplete="off" name="TglPeriodeAkhir">
                                      </div>
                                  </div>
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                                      <div class="col-sm-4">
                                          <a class="btn btn-danger btn-sm btn-rounded " id="btnSearching" name="btnSearching">
                                              <span class="glyphicon glyphicon glyphicon-search"></span> Search</a>
                                      </div>
                                  </div>
                                  <div class="form-group  ">
                                      <div class="col-sm-12">
                                          <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                              <table id="tbl_aktif" width="100%" class="table table-striped table-hover cell-border">
                                                  <thead>
                                                      <tr>
                                                          <th align='center'>
                                                              <font size="1">No.
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">No. PO
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Tanggal
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Nama User
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Supplier
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Keterangan
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Total
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Action
                                                          </th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
                                          </div>
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
  <script src="<?= BASEURL; ?>/js/App/inventory/purchaseorder/list/purchaseOrderList_V03.js"></script>