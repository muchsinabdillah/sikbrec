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
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Kode Lokasi <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="KodeLokasi" name="KodeLokasi" onchange="showdetilroom();">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Class ID <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="ClassID" name="ClassID">
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Ward <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="Ward" name="Ward">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Room Name <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="RoomName" autocomplete="off" name="RoomName">
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Bed Name <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="BedName" autocomplete="off" name="BedName">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Tarif <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Tarif" name="Tarif">
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Include BOR <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="IncludeBOR" name="IncludeBOR">
                                             <option value="">-- PILIH INCLUDE BOR --</option>
                                             <option value="1">Ya</option>
                                             <option value="0">Tidak</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Discontinue <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="Discontinue" name="Discontinue">
                                             <option value="">-- PILIH DISCONTINUE --</option>
                                             <option value="1">Ya</option>
                                             <option value="0">Tidak</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Kelas BPJS </label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="KodeBPJS" name="KodeBPJS">
                                             <option value="">-- PILIH KELAS BPJS --</option>
                                             <option value="NON">NON KELAS</option>
                                             <option value="VVP">VVIP</option>
                                             <option value="VIP">VIP</option>
                                             <option value="UTM">UTAMA</option>
                                             <option value="KL1">KELAS 1</option>
                                             <option value="KL2">KELAS 2</option>
                                             <option value="KL3">KELAS 3</option>
                                             <option value="ICU">ICU</option>
                                             <option value="ICC">ICCU</option>
                                             <option value="NIC">NICU</option>
                                             <option value="PIC">PICU</option>
                                             <option value="IGD">IGD</option>
                                             <option value="UGD">UGD</option>
                                             <option value="SAL">RUANG BERSALIN</option>
                                             <option value="HCU">HCU</option>
                                             <option value="ISO">RUANG ISOLASI</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Publish <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="Publish" name="Publish">
                                             <option value="">-- PILIH PUBLISH --</option>
                                             <option value="1">Ya</option>
                                             <option value="0">Tidak</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Kode PDP <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="KodePDP" name="KodePDP">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Keterangan </label>
                                     <div class="col-sm-4">
                                         <textarea rows="4" class="form-control" id="Keterangan" name="Keterangan" style="resize: none"></textarea>
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
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterDataBed/MasterDataBed_ViewV04.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>