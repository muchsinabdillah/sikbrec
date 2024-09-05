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
                             <!-- Nav tabs -->
                             <ul class="nav nav-tabs border-bottom border-primary">
                                 <li class="active"><a data-toggle="tab" href="#generalinfo">General Info</a></li>
                                 <!--
                                 <li><a data-toggle="tab" href="#detail">Detail</a></li>-->
                             </ul>
                             <!-- Tab panes -->
                             <div class="tab-content bg-white p-15">
                                 <div id="generalinfo" class="tab-pane fade in active">
                                     <div class="panel-body">
                                         <form class="form-horizontal" id="form_cuti">
                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Entry </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="TglEntry" id="TglEntry" readonly>
                                                 </div>
                                             </div>
                                             <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label"> User Entry </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" id="UserEntry" name="UserEntry" readonly>
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Note <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" id="Note" name="Note">
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Berlaku <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="date" class="form-control" name="TglBerlaku" id="TglBerlaku" >
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Expired <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="date" class="form-control" name="TglExpired" id="TglExpired" >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label"> Kode Instalasi <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                             <select class="form-control js-example-basic-single" id="kd_instalasi" name="kd_instalasi">
                                                         <option value="">-- PILIH --</option>
                                                         <option value="RJ">RJ - RAWAT JALAN</option>
                                                         <option value="RI">RI - RAWAT INAP</option>
                                                         <option value="LAB">LAB - LABORATORIUM</option>
                                                         <option value="RAD">RAD - RADIOLOGI</option>
                                                     </select>
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Status <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <select class="form-control js-example-basic-single" id="Status" name="Status" disabled>
                                                         <option value="">-- PILIH --</option>
                                                         <option value="1">Batal</option>
                                                         <option value="0">Aktif</option>
                                                     </select>
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Batal</label>
                                                 <div class="col-sm-4">
                                                     <input type="date" class="form-control" name="TglBatal" id="TglBatal" readonly>
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Alasan Batal</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="AlasanBatal" id="AlasanBatal" readonly>
                                                 </div>
                                             </div>


                                            
                                     </div>
                                 </div>

                                 <div id="detail" class="tab-pane fade">

                                     <div class="panel-body">

                                     <form class="form-horizontal" method="post" action="" enctype="multipart/form-data" id="form_import">
                                     <div class="form-group">
                                     <div class="col-sm-3">
                                  <input type="file" name="file_import" id="file_import" class="pull-left">
                                </div>
                                     <div class="col-sm-8">
                                     <button type="submit" name="btnUploads" id="btnUploads" class="btn btn-success  btn-rounded"><i class="fa fa-save"></i> Upload</button>
                                     </div>

                                     
                                 </div>
                                </form>
                                 <br>
                                     <table id="datadetail" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                 <thead>
                                     <tr>
                                         <th align='center'>
                                             <font size="1">ID TR TARIF
                                         </th>
                                         <th align='center'>
                                             <font size="1">ID Tarif
                                         </th>
                                         <th align='center'>
                                             <font size="1">Group Tarif
                                         </th>
                                         <th align='center'>
                                             <font size="1">Nilai
                                         </th>
                                         <th align='center'>
                                             <font size="1">Kelas ID
                                         </th>
                                         <th align='center'>
                                             <font size="1">Group Tarif 2
                                         </th>
                                         <th align='center'>
                                             <font size="1">ID TR Tarif Paket
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
                             <div class="panel-body">
                                 <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                                 <button class="btn bg-black btn-wide" id="btnreservasi" name="btnreservasi"><i class="fa fa-check"></i>Submit</button>
                                 <button type="button" class="btn bg-danger btn-wide" id="btnbatal" name="btnbatal"><i class="fa fa-trash"></i>Batal</button>
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
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/Tarif/TransaksiTarif/TransaksiTarifRad_View.js"></script>