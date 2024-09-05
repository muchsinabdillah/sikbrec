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
                                 <h5><?= $data['judul'] ?></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <form class="form-horizontal" id="form_cuti">
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label">Periode Bulan</label>
                                     <div class="col-sm-4">
                                         <input type="month" class="form-control" name="Hr_Periode" id="Hr_Periode">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label">Kode Jo</label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Hr_LokasiProject_Updt" name="Hr_LokasiProject_Updt">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                     <div class="col-sm-4">
                                         <input type="hidden" class="form-control" name="Hr_Group_Absen" id="Hr_Group_Absen" readonly>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                                     <div class="col-sm-4">
                                         <input type="hidden" class="form-control" name="Hr_LokasiProject" id="Hr_LokasiProject" readonly>
                                     </div>
                                     <div class="col-sm-2">

                                     </div>
                                 </div>
                                 <hr>
                             </form>
                             <button class="btn bg-success btn-wide" id="btnJadwalCreate" name="btnJadwalCreate" onclick="getInfoPayroll()"><i class="fa fa-gear"></i>LOAD</button>
                             <button class="btn btn-info" id="btn_printrekapgaji" name="btn_printrekapgaji">PRINT REKAP</button>
                             <button class="btn btn-info" id="btn_printproduktivitas" name="btn_printproduktivitas">PRINT PRODUKTIVITAS</button>
                             <div class="table-responsive" style="margin-top: 50px;">
                                 <table id="example" width="100%" class="table table-striped table-hover cell-border">
                                     <thead>
                                         <tr>
                                             <th align='center' width="4%">
                                                 <font size="1">Kode Transaksi
                                             </th>
                                             <th align='center' width="10%">
                                                 <font size="1">Nama Pegawai
                                             </th>
                                             <th align='center' width="10%">
                                                 <font size="1">Kode JO
                                             </th>
                                             <th align='center' width="10%">
                                                 <font size="1">TUNJANGAN POKOK
                                             </th>
                                             <th align='center' width="10%">
                                                 <font size="1">UPAH POKOK
                                             </th>
                                             <th align='center' width="10%">
                                                 <font size="1">LEMBUR
                                             </th>
                                             <th align='center' width="10%">
                                                 <font size="1">POTONGAN ABSENSI
                                             </th>
                                             <th align='center'>
                                                 <font size="1">PPH21
                                             </th>
                                             <th align='center'>
                                                 <font size="1">POTONGAN TL/PSW
                                             </th>
                                             <th align='center'>
                                                 <font size="1">KASBON
                                             </th>
                                             <th align='center'>
                                                 <font size="1">Gaji Diterima
                                             </th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                     </tbody>
                                     <tfoot>
                                         <tr>
                                             <th></th>
                                             <th></th>
                                             <th></th>
                                             <th></th>
                                             <th></th>
                                             <th></th>
                                             <th></th>
                                             <th></th>
                                             <th></th>
                                             <th></th>
                                             <th></th>
                                         </tr>
                                     </tfoot>
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
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/informasi/HRD/InfoPayroll_v02.js"></script>