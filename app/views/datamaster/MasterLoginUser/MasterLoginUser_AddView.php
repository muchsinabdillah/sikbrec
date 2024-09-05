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
                                 <h5>Input <?= $data['judul'] ?> <small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <div class="alert alert-info" role="alert">
                                 <strong>Info!</strong> Jika Pegawai Memiliki NIK, Silahkan Masukan NIP agar NOPIN tergenerate Otomatis. Jika tidak Klik tombol + untuk generate NOPIN baru.</br>
                                 <strong>Info!</strong> Akses ADMINISTRATOR hanya dimiliki IT RSU YARSI saja.</br>
                                 <strong>Info!</strong> Status LOCK terjadi jika User salah masukan Password 3 Kali.</br>
                             </div>
                             <form class="form-horizontal" id="form_cuti">
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> ID :</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="IdTranasksiAuto" id="IdTranasksiAuto" readonly value="<?= $data['id'] ?>">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> NIP <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Mst_ID_Pegawai" name="Mst_ID_Pegawai" onchange="slice_word()">
                                         </select>
                                         <small>Masukan NIP Pegawai yang di Berikan HRD.</small>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pegawai <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" autocomplete="off" name="Mst_NamaPegawai" id="Mst_NamaPegawai">
                                         <small>Edit Nama Kembali, Jika Belum Sesuai.</small>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Username/PIN <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-3">
                                         <input type="text" class="form-control" autocomplete="off" id="Mst_Username" maxlength="4" name="Mst_Username">
                                         <small>Akan Terisi Otomatis, Jika Anda Masukan NIP Pegawai yang di Berikan HRD.</small>
                                     </div>
                                     <div class="col-sm-1">
                                         <button type="button" class="btn btn-primary" id="searchpins" name="searchpins"><span class="glyphicon glyphicon glyphicon-plus"></span></button>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Password <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="password" class="form-control" id="Mst_Password" autocomplete="off" name="Mst_Password">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Aktif <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Mst_Status" name="Mst_Status">
                                             <option value="">-- PILIH --</option>
                                             <option value="1">AKTIF</option>
                                             <option value="0">NON AKTIF</option>
                                             <option value="2">LOCK</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Administrator <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Mst_Admin" name="Mst_Admin">
                                             <option value="">-- PILIH --</option>
                                             <option value="0">TIDAK</option>
                                             <option value="1">YA</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> NIK KTP </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" autocomplete="off" name="Mst_NIKKTP" id="Mst_NIKKTP">
                                     </div>
                                 </div>
                                 <hr>
                                 <h5>Data Kebutuhan Akses EMR</h5>
                                 <div class="form-group ">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Job Title <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="Mst_JobTitle" id="Mst_JobTitle" autocomplete="off">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Group User <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Mst_GroupUser" name="Mst_GroupUser">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Designation ID <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Mst_DesignationID" name="Mst_DesignationID">
                                             <option value=''>-- PILIH --</option>
                                             <option value='2'>2 - MEDREC</option>
                                             <option value='6'>6 - NURSING - DOKTER</option>
                                             <option value='9'>9 - ADMISION</option>
                                             <option value='10'>10 - KASIR</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Menu 1 <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Mst_Menu1" name="Mst_Menu1">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Menu 2 <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Mst_Menu2" name="Mst_Menu2">
                                         </select>
                                     </div>
                                 </div>
                             </form>
                             <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                             <button class="btn bg-black btn-wide" id="btnreservasi" name="btnreservasi" onclick="myJsFunc()"><i class="fa fa-check"></i>Submit</button>
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
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/MasterLoginUser_v02.js"></script>