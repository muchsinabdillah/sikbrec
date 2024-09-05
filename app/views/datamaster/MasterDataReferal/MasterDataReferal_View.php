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
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Grup Referal <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="GrupReferal" name="GrupReferal">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nama Referal <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NamaReferal" autocomplete="false" name="NamaReferal" maxlength="50">
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat </label>
                                     <div class="col-sm-4">
                                         <textarea rows="4" class="form-control" id="AlamatReferal" name="AlamatReferal" style="resize: none"></textarea>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Contact Person </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="PICName" name="PICName">
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Tlp Contact Person </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="TlpPIC" name="TlpPIC">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> No. Rekening </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NoRekening" name="NoRekening">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nama Bank </label>
                                     <div class="col-sm-4">
                                         <select name="NamaBank" id="NamaBank" class="form-control">
                                             <option value="">-- Pilih Nama Bank --</option>
                                             <option value="Bank Mandiri">Bank Mandiri</option>
                                             <option value="Bank Mandiri Syariah">Bank Mandiri Syariah</option>
                                             <option value="Bank CIMB">Bank CIMB</option>
                                             <option value="Bank BCA">Bank BCA</option>
                                             <option value="Bank BCA Syariah">Bank BCA Syariah</option>
                                             <option value="Bank BNI">Bank BNI</option>
                                             <option value="Bank BNI Syariah">Bank BNI Syariah</option>
                                             <option value="Bank BRI">Bank BRI</option>
                                             <option value="Bank BRI Syariah">Bank BRI Syariah</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Pemegang Rekening </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="PemegangRekening" name="PemegangRekening">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Referal Fee (Asuransi)</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="ReferalFeeAsuransi" name="ReferalFeeAsuransi">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Referal Fee </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="ReferalFee" name="ReferalFee">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Diskon Per Item</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="DiskonPerItem" name="DiskonPerItem">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Status <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Status" name="Status">
                                             <option value="">-- PILIH --</option>
                                             <option value="1">Aktif</option>
                                             <option value="0">Tidak Aktif</option>
                                         </select>
                                     </div>
                                 </div>
                             </form>
                             <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                             <button class="btn bg-black btn-wide" id="btnreservasi" name="btnreservasi"><i class="fa fa-check"></i>Submit</button>
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
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterDataReferal/MasterDataReferal_V01.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>