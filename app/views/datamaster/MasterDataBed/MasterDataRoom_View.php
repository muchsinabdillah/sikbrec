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
                                 <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <form class="form-horizontal" id="form_cuti">
                                 <div class="alert alert-info left-icon-alert" role="alert">
                                     <strong>Informasi !</strong> Data Roomname, Class ID, dan Jumlah Bed tidak bisa di edit jika sudah dikirim Ke BPJS Aplicares.
                                     <br> <strong>Informasi !</strong> Jumlah Bed diisi dengan Jumlah Bed yang menjadi acuan ke BPJS di masing-masing Ruangan.
                                     <br> <strong>Informasi !</strong> Silahkan Masukan Unit Usaha, untuk Kebutuhn Data Pendapatan Di Masing-Masing Unit.
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Room Name <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" autocomplete="off" id="RoomName" name="RoomName" maxlength="70">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Class ID <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="ClassID" name="ClassID">
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Class Name <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="ClassName" readonly name="ClassName" maxlength="70">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Jumlah Bed <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" autocomplete="off" id="JumlahBed" name="JumlahBed">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Lantai <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="LantaiID" name="LantaiID">
                                             <option value="1">Lantai 1</option>
                                             <option value="2">Lantai 2</option>
                                             <option value="3">Lantai 3</option>
                                             <option value="4">Lantai 4</option>
                                             <option value="5">Lantai 5</option>
                                             <option value="6">Lantai 6</option>
                                             <option value="7">Lantai 7</option>
                                             <option value="8">Lantai 8</option>
                                             <option value="9">Lantai 9</option>
                                             <option value="10">Lantai 10</option>
                                             <option value="11">Lantai 11</option>
                                             <option value="12">Lantai 12</option>
                                             <option value="13">Lantai 13</option>
                                             <option value="14">Lantai 14</option>
                                             <option value="15">Lantai 15</option>
                                             <option value="16">Lantai 16</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Unit Usaha <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="UnitID" name="UnitID">
                                         </select>
                                     </div>
                                 </div>
                             </form>
                             <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                             <button class="btn bg-black btn-wide" id="btnSave" name="btnSave"><i class="fa fa-check"></i>Submit</button>
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
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterDataBed/MasterDataRoom_View03.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>