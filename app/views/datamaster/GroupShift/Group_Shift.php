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
                                 <h5>Input Master <?= $data['judul'] ?> <small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <form class="form-horizontal" id="form_cuti">
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> ID Transaksi </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="IdTranasksi" id="IdTranasksi" value="<?= $data['id'] ?>" readonly>
                                         <input type="hidden" class="form-control" name="IdTranasksiAuto" id="IdTranasksiAuto" value="<?= $data['id'] ?>" readonly>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Kelas 1 </label>
                                     <div class="col-sm-2">
                                         <input type="number" class="form-control" id="Mst_Kelas1" name="Mst_Kelas1">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Kode Group Shift <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="number" class="form-control" id="Mst_KodeGroupShift" name="Mst_KodeGroupShift">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Kelas 2 </label>
                                     <div class="col-sm-2">
                                         <input type="number" class="form-control" id="Mst_Kelas2" name="Mst_Kelas2">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nama Group Shift <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Mst_NamaGroupShift" name="Mst_NamaGroupShift">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Kelas 3 </label>
                                     <div class="col-sm-2">
                                         <input type="number" class="form-control" id="Mst_Kelas3" name="Mst_Kelas3">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Jml Hari/Jam kerja <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-2">
                                         <input type="number" class="form-control" id="Mst_ValuehariGroup" name="Mst_ValuehariGroup">
                                     </div>
                                     <div class="col-sm-2">
                                         <input type="number" class="form-control" id="Mst_ValueGroupShift" name="Mst_ValueGroupShift">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Kelas 4 </label>
                                     <div class="col-sm-2">
                                         <input type="number" class="form-control" id="Mst_Kelas4" name="Mst_Kelas4">
                                     </div>
                                 </div>
                             </form>
                             <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                             <button class="btn bg-black btn-wide" id="btnreservasi" name="btnreservasi" onclick="go_save()"><i class="fa fa-check"></i>Submit</button>
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
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/GroupShift_v08.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>