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
                                 <h5>Data Login User <small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <form class="form-horizontal" id="form_add_akses">
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="IdTranasksiAuto" id="IdTranasksiAuto" readonly value="<?= $data['id'] ?>">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pegawai <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="Mst_NamaPegawai" id="Mst_NamaPegawai" readonly>
                                     </div>
                                 </div>
                                 <hr>
                                 <h5>Akses Transaksi </h5>
                                 <div class="alert alert-info" role="alert">
                                     <strong>Info!</strong> Jika Hak Akses User adalah ADMINISTRATOR, <b>TIDAK PERLU TAMBAHKAN HAK ASES</b>, secara otomatis semua Akses Terbuka.</br>
                                     <strong>Info!</strong> Akses <b>CREATE</b> ditambahkan Untuk Kebutuhan Create/Update Transaksi di masing-masing Form.</br>
                                     <strong>Info!</strong> Akses <b>DELETE</b> ditambahkan Untuk Kebutuhan Delete Transaksi di masing-masing Form.</br>
                                     <strong>Info!</strong> Jika ada perubahan <b>CREATE</b> / <b>DELETE</b> silahkan rubah di kolom Table List Data Hak Akses User di bawah.</br>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Hak Akses <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Mst_ID_Hak_Akses" name="Mst_ID_Hak_Akses"></select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Create<sup class="color-danger">*</sup></label>
                                     <div class="col-sm-2">
                                         <select class="form-control js-example-basic-single" id="Mst_Create" name="Mst_Create">
                                             <option value="">-- PILIH --</option>
                                             <option value="1">YA</option>
                                             <option value="0">TIDAK</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Delete<sup class="color-danger">*</sup></label>
                                     <div class="col-sm-2">
                                         <select class="form-control js-example-basic-single" id="Mst_Delete" name="Mst_Delete">
                                             <option value="">-- PILIH --</option>
                                             <option value="1">YA</option>
                                             <option value="0">TIDAK</option>
                                         </select>
                                     </div>
                                 </div>
                             </form>
                             <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                             <button class="btn bg-black btn-wide" id="btnreservasi" name="btnreservasi"><i class="fa fa-check"></i>TAMBAH AKSES</button>
                             <button href="#modal_copi_data" data-toggle='modal' class="btn bg-danger btn-wide" id="btnreservasi" name="btnreservasi"><i class="fa fa-copy"></i>COPY HAK AKSES</button>

                             <h5>List Data Hak Akses User</h5>
                             <div class="table-responsive" style="margin-top: 20px;">
                                 <table id="tblHakAkses" width="100%" class="table table-striped table-hover cell-border">
                                     <thead>
                                         <tr>
                                             <th align='center'>
                                                 <font size="1">No.
                                             </th>
                                             <th align='center'>
                                                 <font size="1">Menu
                                             </th>
                                             <th align='center'>
                                                 <font size="1">Sub Menu
                                             </th>
                                             <th align='center'>
                                                 <font size="1">Create
                                             </th>
                                             <th align='center'>
                                                 <font size="1">Delete
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

 <!-- Modal Batal Registrasi -->
 <div class="modal fade" id="modal_copi_data" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog  modal-md" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel">Copi Hak Akses </h4>
             </div>
             <div class="modal-body">
                 <form class="form-horizontal" id="frmDigitalSign">
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-4 control-label">Cari User</label>
                         <div class="col-sm-8">
                             <select class="form-control js-example-basic-single" id="Mst_UserCopi_Hak_Akses" name="Mst_UserCopi_Hak_Akses"></select>
                         </div>
                     </div>
                 </form>
             </div>
             <div class="modal-footer">
                 <div class="btn-group" role="group">
                     <button type="button" class="btn btn-warning btn-wide btn-rounded" id="btnCopyHakAkses" name="btnCopyHakAkses"><i class="fa fa-refresh"></i> SIMPAN </button>
                     <button type="button" class="btn btn-grey btn-wide btn-rounded" id="btnModalSrcfingerClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                 </div>
                 <!-- /.btn-group -->
             </div>
         </div>
     </div>
 </div>
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/MasterLoginUserHakAkses_V01.js"></script>