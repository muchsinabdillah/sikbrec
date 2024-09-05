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
                                 <h5> <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <form class="form-horizontal" id="form_cuti_dokter">
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                         <input type="hidden" class="form-control" name="NamaFullPoli" id="NamaFullPoli"  readonly>
                                     </div>

                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nama Dokter <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="NamaDokter" name="NamaDokter">
                                         <input type="hidden" class="form-control" name="NamaDokterFull" id="NamaDokterFull"  readonly>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Nama PolikLinik <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" onchange="getDataDokter()" id="NamaPoliklinik" name="NamaPoliklinik">
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Cuti <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="JenisCuti" name="JenisCuti">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Cuti <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-3">
                                         <input type="date" class="form-control" name="TglAwal" id="TglAwal">
                                     </div>
                                     <div class="col-sm-3">
                                         <input type="date" class="form-control" name="TglAkhir" id="TglAkhir">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Catatan Cuti <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-6">
                                         <textarea class="form-control input-sm" id="note" name="note"></textarea>
                                         </select>
                                     </div>
                                 </div>
                             </form>
                             <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                             <button class="btn bg-black btn-wide" id="btnreservasi" name="btnreservasi"><i class="fa fa-check"></i>Submit</button>
                             <!-- <button class="btn btn-danger btn-wide" id="btnbatal" name="btnbatal"><i class="fa fa-trash"></i>Batal</button> -->
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
 <script src="<?= BASEURL; ?>/js/App/billing/cutidokter/TransaksiCutiDokter01.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>