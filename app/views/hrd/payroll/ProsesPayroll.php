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
                             <button class="btn btn-success" id="btnJadwalCreate" name="btnJadwalCreate" onclick="GenerateHdr()">TRANSAKSI BARU</button>
                             <form class="form-horizontal" id="form_cuti">
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label">No. Transaksi</label>
                                     <div class="col-sm-2">
                                         <input type="text" class="form-control" name="Payroll_IDtrs" id="Payroll_IDtrs">
                                     </div>
                                     <div class="col-sm-2">
                                         <a href="#" class="btn btn-primary" id="btnSearch" name="btnSearch" data-toggle="modal" data-target="#Notif_awal_registrasi"><i class="fa fa-search"></i></a>
                                         <a href="#modal_alert_print" data-toggle="modal" class="btn btn-info"><i class="fa fa-print"></i></a>
                                     </div>

                                     <label for="inputEmail3" class="col-sm-2 control-label">Kode JO</label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Payroll_Lokasi" name="Payroll_Lokasi">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-2 control-label">Nama Pegawai</label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Payroll_Pegawai" name="Payroll_Pegawai">
                                         </select>
                                     </div>

                                     <label for="inputEmail3" class="col-sm-2 control-label">Periode Bulan</label>
                                     <div class="col-sm-4">
                                         <input type="month" class="form-control" name="Payroll_Periode" id="Payroll_Periode">
                                     </div>
                                 </div>
                                 <hr>
                             </form>
                             <button class="btn bg-success btn-wide" id="btnJadwalCreateDtl" name="btnJadwalCreateDtl" onclick="GenerateDtl()"><i class="fa fa-gear"></i>PROSES GAJI</button>
                             <button class="btn btn-danger btn-wide" id="btnCancelPayroll" name="btnCancelPayroll" onclick="VoidTRansaksi()"><i class="fa fa-remove"></i>BATAL</button>
                             <button class="btn btn-primary btn-wide" id="btnSelesaiPayroll" name="btnSelesaiPayroll" onclick="FinishTRansaksi()"><i class="fa fa-mail-reply-all"></i>SELESAI</button>

                             <!-- Nav tabs -->
                             <ul class="nav nav-tabs border-bottom border-primary" role="tablist" style="margin-top: 20px;">
                                 <li role="presentation" class="active"><a class="" href="#payroll" aria-controls="payroll" role="tab" data-toggle="tab">Proses Penggajian</a></li>
                                 <li role="presentation"><a class="" href="#absensi" aria-controls="absensi" role="tab" data-toggle="tab">Data Absensi</a></li>
                                 <li role="presentation"><a class="" href="#pendidikan" aria-controls="pendidikan" role="tab" data-toggle="tab">Data Data Lembur</a></li>
                             </ul>

                             <!-- Tab panes -->
                             <div class="tab-content bg-white p-15">
                                 <div role="tabpanel" class="tab-pane active" id="payroll">
                                     <section class="section pt-12">
                                         <div class="container-fluid">
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="panel border-primary no-border border-3-top" data-panel-control>
                                                         <div class="panel-heading">
                                                             <div class="panel-title">
                                                                 <h5>Komponen Pendapatan</h5>
                                                             </div>
                                                         </div>
                                                         <div class="panel-body">
                                                             <div class="table-responsive">
                                                                 <table id="tblkomponenImbalan" width="100%" class="table table-striped table-hover cell-border">
                                                                     <thead>
                                                                         <tr>
                                                                             <th align='center'>
                                                                                 <font size="1">No.
                                                                             </th>
                                                                             <th align='center'>
                                                                                 <font size="1">Nama Komponen
                                                                             </th>
                                                                             <th align='center'>
                                                                                 <font size="1">NIlai
                                                                             </th>
                                                                         </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                     </tbody>
                                                                     <tfoot>
                                                                         <tr>
                                                                             <th>Total Pendapatan</th>
                                                                             <th></th>
                                                                             <th></th>
                                                                         </tr>
                                                                     </tfoot>
                                                                 </table>
                                                             </div>

                                                         </div>
                                                     </div>
                                                     <!-- /.panel -->
                                                 </div>
                                                 <!-- /.col-md-6 -->

                                                 <div class="col-md-6">
                                                     <div class="panel border-primary no-border border-3-top" data-panel-control>
                                                         <div class="panel-heading">
                                                             <div class="panel-title">
                                                                 <h5>Perhitungan Payroll</h5>
                                                             </div>
                                                         </div>
                                                         <div class="panel-body">
                                                             <form class="form-horizontal" id="form_cuti">
                                                                 <div class="alert alert-success" role="alert" id="howtoalert">
                                                                     <p>- Klik Textbox Pph21 untuk Mengedit Nilai PPH21.</p>
                                                                     <p>- Klik Textbox Koperasi untuk Mengedit Nilai Koperasi.</p>
                                                                 </div>
                                                                 <div class="form-group">
                                                                     <label for="inputEmail3" class="col-sm-4 control-label">Total Gaji </label>
                                                                     <div class="col-sm-4">
                                                                         <input type="text" class="form-control" name="SUBTOTAL" id="SUBTOTAL" readonly>

                                                                     </div>
                                                                 </div>
                                                                 <hr>
                                                                 <div class="form-group">
                                                                     <label for="inputEmail3" class="col-sm-4 control-label">PPH21 </label>
                                                                     <div class="col-sm-4">
                                                                         <input type="text" class="form-control" name="PPH_21" id="PPH_21" readonly onclick="ShowForm('23')">
                                                                     </div>

                                                                     <div class="col-sm-1">

                                                                     </div>
                                                                 </div>
                                                                 <div class="form-group">
                                                                     <label for="inputEmail3" class="col-sm-4 control-label">Kasbon </label>
                                                                     <div class="col-sm-4">
                                                                         <input type="text" class="form-control" name="KASBON" id="KASBON" readonly onclick="ShowForm('25')">
                                                                     </div>
                                                                     <div class="col-sm-1">

                                                                     </div>
                                                                 </div>

                                                                 <hr>
                                                                 <div class="form-group">
                                                                     <label for="inputEmail3" class="col-sm-4 control-label">Gaji Diterima</label>
                                                                     <div class="col-sm-4">
                                                                         <input type="text" class="form-control" name="GRANTOTAL_GAJI" id="GRANTOTAL_GAJI" readonly>
                                                                     </div>
                                                                     <label for="inputEmail3" class="col-sm-1 control-label"><i></i></label>
                                                                     <div class="col-sm-1">

                                                                     </div>
                                                                 </div>
                                                                 <hr>
                                                             </form>
                                                         </div>
                                                     </div>
                                                     <!-- /.panel -->
                                                 </div>
                                                 <!-- /.col-md-6 -->
                                             </div>
                                             <!-- /.row -->
                                         </div>
                                         <!-- /.container-fluid -->
                                     </section>
                                     <!-- /.section -->
                                     <section class="section pt-12" style="margin-top: -60px;">
                                         <div class="container-fluid">
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="panel border-primary no-border border-3-top" data-panel-control>
                                                         <div class="panel-heading">
                                                             <div class="panel-title">
                                                                 <h5>Komponen Potongan</h5>
                                                             </div>
                                                         </div>
                                                         <div class="panel-body">
                                                             <div class="table-responsive">
                                                                 <table id="tblkomponenPotongan" width="100%" class="table table-striped table-hover cell-border">
                                                                     <thead>
                                                                         <tr>
                                                                             <th align='center'>
                                                                                 <font size="1">No.
                                                                             </th>
                                                                             <th align='center'>
                                                                                 <font size="1">Nama Komponen
                                                                             </th>
                                                                             <th align='center'>
                                                                                 <font size="1">NIlai
                                                                             </th>
                                                                         </tr>
                                                                     </thead>
                                                                     <tbody>
                                                                     </tbody>
                                                                     <tfoot>
                                                                         <tr>
                                                                             <th>Total Potongan</th>
                                                                             <th></th>
                                                                             <th></th>
                                                                         </tr>
                                                                     </tfoot>
                                                                 </table>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <!-- /.panel -->
                                                 </div>
                                                 <!-- /.col-md-6 -->
                                             </div>
                                             <!-- /.row -->
                                         </div>
                                         <!-- /.container-fluid -->
                                     </section>
                                     <!-- /.section -->
                                 </div>
                                 <div role="tabpanel" class="tab-pane" id="absensi">
                                     <div class="table-responsive" width="100%">
                                         <table id="example" class="table table-striped table-hover cell-border">
                                             <thead>
                                                 <tr>
                                                     <th align='center' width="4%">
                                                         <font size="1">Hari
                                                     </th>
                                                     <th align='center' width="4%">
                                                         <font size="1">Tanggal
                                                     </th>
                                                     <th align='center' width="10%">
                                                         <font size="1">Jadwal IN
                                                     </th>
                                                     <th align='center' width="10%">
                                                         <font size="1">Jadwal OUT
                                                     </th>
                                                     <th align='center' width="10%">
                                                         <font size="1">Absen IN
                                                     </th>
                                                     <th align='center' width="10%">
                                                         <font size="1">Absen OUT
                                                     </th>
                                                     <th align='center' width="10%">
                                                         <font size="1">Telat (Menit)
                                                     </th>
                                                     <th align='center' width="10%">
                                                         <font size="1">Plg Awal (Menit)
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Lokasi
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Keterangan
                                                     </th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                                 <div role="tabpanel" class="tab-pane" id="pendidikan">
                                     <div class="table-responsive" width="100%">
                                         <table id="example2" class="table table-striped table-hover cell-border">
                                             <thead>
                                                 <tr>
                                                     <th align='center'>
                                                         <font size="1">No. SPL
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Jenis Lembur
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Lokasi
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tgl Lembur
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Jam Masuk
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Jam Keluar
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Jumlah (Jam)
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Alasan
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Lokasi
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

 <!-- Modal Untuk Notif Resep ------------------------------------------------>
 <div class="modal fade" id="Notif_awal_registrasi" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

     <div class="modal-dialog modal-lg">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title"> Pencarian Transaksi Payroll </h4>
             </div>
             <div class="modal-body">
                 <form class="form-horizontal" id="form_cuti">
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Periode Bulan</label>
                         <div class="col-sm-3">
                             <input type="month" class="form-control" name="SrcPeriodeBln" id="SrcPeriodeBln">
                         </div>
                         <label for="inputEmail3" class="col-sm-2 control-label">Kode JO</label>
                         <div class="col-sm-3">
                             <select class="form-control" id="SrcKodeJO" name="SrcKodeJO">
                             </select>
                         </div>
                         <button type="button" class="btn btn-danger" onclick="ShowDataListPayroll()">Search</button>
                     </div>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label"></label>
                         <div class="col-sm-4">

                         </div>
                         <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                         <div class="col-sm-4">
                         </div>
                         <div class="col-sm-2">

                         </div>
                     </div>
                     <hr>
                 </form>
                 <div class="table-responsive">
                     <table id="tblCariPayroll" width="100%" class="table table-striped table-hover cell-border">
                         <thead>
                             <tr>
                                 <th align='center'>
                                     <font size="1">No. Transaksi
                                 </th>
                                 <th align='center'>
                                     <font size="1">Peiode
                                 </th>
                                 <th align='center'>
                                     <font size="1">Kode JO
                                 </th>
                                 <th align='center'>
                                     <font size="1">Nama Pegawai
                                 </th>
                                 <th align='center'>
                                     <font size="1">Nilai Gaji
                                 </th>
                                 <th align='center'>
                                     <font size="1">Status Transaksi
                                 </th>
                                 <th align='center'>
                                     <font size="1">Action
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
                             </tr>
                         </tfoot>
                     </table>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>
 <!--#END Modal Untuk Notif Resep---------------------------->
 <!-- Modal Print ------------------------------------------------>
 <div class="modal fade" id="modal_alert_print" tabindex="-1" role="dialog" style="overflow-y: auto">

     <div class="modal-dialog modal-md">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title"> Print </h4>
             </div>
             <div class="modal-body">
                 <button class="btn btn-info" id="btnprint" name="btnprint">
                     <i class="fa fa-print" aria-hidden="true"></i> PRINT SLIP</button>
                 <button class="btn btn-info" id="btnprint2" name="btnprint2">
                     PRINT ABSENSI</button>
             </div>
             <div class="modal-footer">
                 <div class="form-group row" style="margin-right:1em;float:right;">
                     <button class="btn btn-secondary" data-dismiss="modal" name="btnclose">
                         Close</button>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!--#END Modal Print---------------------------->
 <!-- Modal EDIT VALUE KOMPONEN ------------------------------------------------>
 <!-- Modal Untuk Notif Resep ------------------------------------------------>
 <div class="modal fade" id="Modal_verifikasi" tabindex="-1" role="dialog" style="overflow-y: auto">

     <div class="modal-dialog modal-md">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title"> Verifikasi Nilai Komponen </h4>
             </div>
             <form id="frmKartuRSYarsi">
                 <div class="modal-body">
                     <div class="row" style="margin-bottom:3px;">
                         <label for="namapasien" class="col-sm-4 col-form-label">No. ID</label>

                         <div class="col-sm-4">
                             <input class="form-control input-sm" type="text" id="JM_ID" readonly name="JM_ID">
                         </div>
                     </div>
                     <div class="row" style="margin-bottom:3px;">
                         <label for="dokter" class="col-sm-4 col-form-label">No. Transaksi </label>
                         <div class="col-sm-8">
                             <input class="form-control input-sm " id="xNOTransaksi" readonly name="xNOTransaksi" type="text" placeholder="Ketik Nama Pasien">
                         </div>
                     </div>
                     <div class="row" style="margin-bottom:3px;">
                         <label for="dokter" class="col-sm-4 col-form-label">Nama Komponen </label>
                         <div class="col-sm-8">
                             <input class="form-control input-sm " id="xNamaKomponen" readonly name="xNamaKomponen" type="text" placeholder="Ketik Nama Pasien">
                         </div>
                     </div>
                     <div class="row" style="margin-bottom:3px;">
                         <label for="namapasien" class="col-sm-4 col-form-label">Nilai Komponen</label>
                         <div class="col-sm-4">
                             <input class="form-control input-sm" type="text" id="xNIlaiKomponen" name="xNIlaiKomponen">
                         </div>
                     </div>
                 </div>
             </form>
             <div class="modal-footer">
                 <div class="form-group row" style="margin-right:1em;float:right;">
                     <button class="btn btn-primary" id="btnSavePoli2" name="btnSavePoli2"> Simpan</button>
                 </div>
             </div>
         </div>
     </div>

 </div>
 <!--#END Modal Untuk Notif Resep---------------------------->
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/hrd/payroll/ProsesPayroll_v07.js"></script>