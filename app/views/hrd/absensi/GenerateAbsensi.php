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
                                     <label for="inputEmail3" class="col-sm-2 control-label">Kode JO</label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="Hr_Pilih_Lokasi" name="Hr_Pilih_Lokasi">
                                         </select>
                                     </div>

                                     <label for="inputEmail3" class="col-sm-2 control-label">Periode Bulan</label>
                                     <div class="col-sm-4">
                                         <input type="month" class="form-control" name="Hr_Periode" id="Hr_Periode">
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
                             <button class="btn bg-success btn-wide" id="btnJadwalCreate" name="btnJadwalCreate" onclick="loadJdwl()"><i class="fa fa-gear"></i>GENERATE</button>
                             <button class="btn btn-primary btn-wide" id="btnUpdateJadwal" name="btnUpdateJadwal" data-toggle="modal" onclick="clearformlembur()" data-target="#Notif_awal_registrasi"><i class="fa fa-plus"></i>TAMBAH LEMBUR</button>
                             <button class="btn btn-danger btn-wide" id="btnUpdateJadwal" name="btnUpdateJadwal" data-toggle="modal" data-target="#modal_Absensi_Manual"><i class="fa fa-users"></i>LOG ABSENSI</button>

                             <!-- Nav tabs -->
                             <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                 <li role="presentation" class="active"><a class="" href="#datadetil" aria-controls="datadetil" role="tab" data-toggle="tab">Data Absensi</a></li>
                                 <li role="presentation"><a class="" href="#pendidikan" aria-controls="pendidikan" role="tab" data-toggle="tab">Data Lembur</a></li>
                             </ul>

                             <!-- Tab panes -->
                             <div class="tab-content bg-white p-15">
                                 <div role="tabpanel" class="tab-pane active" id="datadetil">
                                     <div class="table-responsive" width="50%">
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
                                                     <th align='center' width="30%">
                                                         <font size="1">Nama
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
                                                         <font size="1">Nama Pegawai
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
 <!-- Modal Absensi Manual  ------------------------------------------------>
 <div class="modal fade" id="modal_Absensi_Manual">

     <div class="modal-dialog modal-lg">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title"> Edit Data Log Absensi Manual </h4>
             </div>
             <div class="modal-body">
                 <form class="form-horizontal" id="form_cuti">
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">ID Transaksi :</label>
                         <div class="col-sm-2">
                             <input type="text" class="form-control" name="IdTranasksi" id="IdTranasksi" readonly>
                             <input type="hidden" class="form-control" name="IdTranasksiAuto" id="IdTranasksiAuto" readonly>
                         </div>
                         <div class="col-sm-2">
                             <a href="#" class="btn btn-primary" id="btnViewListDetil" name="btnViewListDetil"><i class="fa fa-search"></i> Log Absensi </a>
                         </div>
                         <label for="inputEmail3" class="col-sm-2 control-label">Tanggal :</label>
                         <div class="col-sm-4">
                             <input type="date" class="form-control" id="Absen_Tanggal" name="Absen_Tanggal">
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Jam :</label>
                         <div class="col-sm-4">
                             <input type="time" class="form-control" id="Absen_Jam" name="Absen_Jam">
                             <input type="hidden" value="0" class="form-control" id="Absen_PIN" name="Absen_PIN">
                         </div>
                         <label for="inputEmail3" class="col-sm-2 control-label">Pegawai :</label>
                         <div class="col-sm-4">
                             <select class="form-control" id="Hr_Nama_Pegawai2" name="Hr_Nama_Pegawai2">
                             </select>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Status :</label>
                         <div class="col-sm-4">
                             <select class="form-control" id="Absen_Status" name="Absen_Status">
                                 <option value="">- Pilih -</option>
                                 <option value="1">IN</option>
                                 <option value="2">OUT</option>
                             </select>
                         </div>
                         <label for="inputEmail3" class="col-sm-2 control-label"></label>
                         <div class="col-sm-4">

                         </div>
                     </div>
                 </form>
                 <div class="panel panel-default" id="pnlViewListDetil">
                     <div class="panel-heading">
                         <h3 class="panel-title">List Data Absensi Manual <span class="badge badge-secondary" id="panelhideme">
                                 <font size="1"><i class="fa fa-remove"></i> HIDE ME</font>
                             </span></h3>
                     </div>
                     <div class="panel-body">
                         <div class="table-responsive">
                             <table id="tblabsensimanual" width="100%" class="table table-striped table-hover cell-border">
                                 <thead>
                                     <tr>
                                         <th align='center'>
                                             <font size="1">ID
                                         </th>
                                         <th align='center'>
                                             <font size="1">Tanggal dan Jam
                                         </th>
                                         <th align='center'>
                                             <font size="1">ID Pegawai
                                         </th>
                                         <th align='center'>
                                             <font size="1">Nama Pegawai
                                         </th>
                                         <th align='center'>
                                             <font size="1">OI
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
             <div class="modal-footer">
                 <button class="btn btn-success  btn-wide" id="btnreservasi" name="btnreservasi" onclick="myJsFunc()"><i class="fa fa-plus"></i>TAMBAH</button>
                 <button type="button" class="btn btn-secondary  btn-wide" data-dismiss="modal"><i class="fa fa-mail-reply-all"></i>KEMBALI</button>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Absensi Manual ------------------------------------------------>
 <!-- Modal Untuk Notif Resep ------------------------------------------------>
 <div class="modal fade" id="Notif_awal_registrasi" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

     <div class="modal-dialog modal-lg">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title"> Tambah Lembur </h4>
             </div>
             <div class="modal-body">
                 <form class="form-horizontal" id="form_trs_lembur">
                     <span class="label label-primary" class="col-sm-2">Informasi Data Pegawai</span>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Nama Pegawai :</label>
                         <div class="col-sm-4">
                             <select class="form-control  " id="Hr_Nama_Pegawai" name="Hr_Nama_Pegawai">
                             </select>
                         </div>
                         <label for="inputEmail3" class="col-sm-2 control-label">Kode JO :</label>
                         <div class="col-sm-4">
                             <select class="form-control" id="Hr_ID_Lokasi" name="Hr_ID_Lokasi">
                             </select>
                         </div>
                     </div>
                     <hr>
                     <span class="label label-primary" class="col-sm-2">Informasi Data Transaksi</span>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label"> ID Transaksi :</label>
                         <div class="col-sm-2">
                             <input type="text" class="form-control" name="IdTranasksiL" id="IdTranasksiL" readonly>
                             <input type="text" class="form-control" name="IdTranasksiAutoL" id="IdTranasksiAutoL" readonly>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lembur :</label>
                         <div class="col-sm-4">
                             <input type="date" class="form-control" id="Hr_tglcuti_awal" name="Hr_tglcuti_awal">
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Jam Awal :</label>
                         <div class="col-sm-2">
                             <input type="time" class="form-control" id="Hr_Jam_Awal" name="Hr_Jam_Awal" onchange="getJam();">
                         </div>
                         <label class="col-sm-1 text-center">sd</label>
                         <div class="col-sm-2">
                             <input type="time" class="form-control" id="Hr_Jam_Akhir" name="Hr_Jam_Akhir" onchange="getJam();">
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label"> Jumlah Jam :</label>
                         <div class="col-sm-2">
                             <input type="number" class="form-control" id="Hr_jumlah_Lembur" name="Hr_jumlah_Lembur" readonly>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Jenis Lembur :</label>
                         <div class="col-sm-4">
                             <select class="form-control js-example-basic-single" id="Hr_Jenis_lembur" name="Hr_Jenis_lembur">
                                 <option value="1">Lembur Hari Biasa</option>
                                 <option value="2">Lembur Hari Libur</option>
                             </select>
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Catatan :</label>
                         <div class="col-sm-10">
                             <textarea id="catatan" rows="5" name="catatan" class="form-control"></textarea>
                         </div>
                     </div>
                 </form>

             </div>
             <div class="modal-footer">
                 <button class="btn bg-success btn-wide" id="btnreservasi" name="btnreservasi" onclick="SaveTRsLembur()"><i class="fa fa-plus"></i>SIMPAN</button>
                 <button class="btn btn-danger btn-wide" id="btnreservasi" name="btnreservasi" onclick="BatalTRsLembur()"><i class="fa fa-remove"></i>BATAL</button>
                 <button type="button" class="btn btn-secondary btn-wide" data-dismiss="modal"><i class="fa fa-mail-reply-all"></i>KELUAR</button>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Untuk Notif Resep ------------------------------------------------>
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/hrd/absensi/Generate_Absensi_v03.js"></script>