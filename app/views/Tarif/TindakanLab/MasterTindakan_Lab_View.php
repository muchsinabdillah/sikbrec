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
                                 <li><a data-toggle="tab" href="#layanan">Nilai Rujukan</a></li>
                             </ul>
                             <!-- Tab panes -->
                             <div class="tab-content bg-white p-15">
                                 <div id="generalinfo" class="tab-pane fade in active">
                                     <div class="panel-body">
                                         <form class="form-horizontal" id="form_cuti">
                                         <input type="hidden" class="form-control" name="kd_instalasi" id="kd_instalasi" value="<?= $data['kd_instalasi'] ?>" readonly>
                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Kode Tes <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Kode Alat </label>
                                                 <div class="col-sm-4">
                                                 <input type="text" class="form-control" name="KodeAlat" id="KodeAlat" >
                                                </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Kode Kelompok <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="KodeKelompok" id="KodeKelompok" >
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Tes <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="NamaTes" id="NamaTes"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Nama Panjang</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="NamaTes1" id="NamaTes1" >
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="Jenis" id="Jenis"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Sample </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="JenisSample" id="JenisSample"  >
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Satuan </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="Satuan" id="Satuan"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Kelompok </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="Kelompok" id="Kelompok"  >
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Hasil </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="Hasil" id="Hasil"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> L60 LP </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="L60_LP" id="L60_LP"  >
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> L60 Digit </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="L60_DIGIT" id="L60_DIGIT"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Currency </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="Currency" id="Currency"  >
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> JenisHsl</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="JenisHsl" id="JenisHsl"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Pecahan </label>
                                                 <div class="col-sm-4">
                                                 <select class="form-control" id="Pecahan" name="Pecahan">
                                                         <option value="">-- PILIH --</option>
                                                         <option value="1">Ya</option>
                                                         <option value="0">Tidak</option>
                                                     </select>
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> ExtenNR</label>
                                                 <div class="col-sm-4">
                                                 <select class="form-control" id="ExtenNR" name="ExtenNR">
                                                         <option value="">-- PILIH --</option>
                                                         <option value="1">Ya</option>
                                                         <option value="0">Tidak</option>
                                                     </select>
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Header </label>
                                                 <div class="col-sm-4">
                                                 <select class="form-control" id="Header" name="Header">
                                                         <option value="">-- PILIH --</option>
                                                         <option value="1">Ya</option>
                                                         <option value="0">Tidak</option>
                                                     </select>
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> TempHasilM</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="TempHasilM" id="TempHasilM"  >
                                                 </div>
                                             </div>

                                            
                                     </div>
                                 </div>

                                 <div id="layanan" class="tab-pane fade">

                                     <div class="panel-body">

                                     <div class="form-group">
                                     <div class="col-sm-4">
                                         <button type="button" class="btn bg-black btn-animated btn-wide" id="btnAdd" name="btnAdd" href="#ViewDetail" data-toggle='modal'><span class="visible-content">Add New</span><span class="hidden-content"><i class="fa fa-plus"></i></span></button>
                                     </div>
                                 </div>
                                 <br>

                                     <table id="datalayanan" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                 <thead>
                                     <tr>
                                         <th align='center'>
                                             <font size="1">ID
                                         </th>
                                         <th align='center'>
                                             <font size="1">Parameter Usia
                                         </th>
                                         
                                         <th align='center'>
                                             <font size="1">Usia 1(hari)
                                         </th>
                                         <th align='center'>
                                             <font size="1">Usia 2(hari)
                                         </th>
                                         <th align='center'>
                                             <font size="1">G
                                         </th>
                                         <th align='center'>
                                             <font size="1">Jenis Sample
                                         </th>
                                         <th align='center'>
                                             <font size="1">NR Awal
                                         </th>
                                         <th align='center'>
                                             <font size="1">NR Akhir
                                         </th>
                                         <th align='center'>
                                             <font size="1">Satuan Rujukan
                                         </th>
                                         <th align='center'>
                                             <font size="1">Catatan
                                         </th>
                                         <th align='center'>
                                             <font size="1">Batas Atas
                                         </th>
                                         <th align='center'>
                                             <font size="1">Batas Bawah
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


 <!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="ViewDetail" tabindex="-1" role="dialog">

<div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"> Nilai Rujukan </h4>
        </div>
        <div class="modal-body">

        <div class="panel-body">
                                         <form class="form-horizontal" id="form_detail">
                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="IdAuto_detail" id="IdAuto_detail" readonly>
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Kode Tes </label>
                                                 <div class="col-sm-4">
                                                 <input type="text" class="form-control" name="KodeTesDetail" id="KodeTesDetail" readonly>
                                                </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Parameter Lab </label>
                                                 <div class="col-sm-4">
                                                 <select name="ParameterLab" id="ParameterLab" class="form-control" >
                                         </select>
                                                </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Usia 1(hari) </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="U1" id="U1"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Usia 2(hari)</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="U2" id="U2" >
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> G</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="G" id="G"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Sample </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="JenisSample_Detail" id="JenisSample_Detail"  >
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> NR Awal </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="NRAwal" id="NRAwal"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> NR Akhir </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="NRAkhir" id="NRAkhir"  >
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Satuan Rujukan </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="SatuanRujukan_Detail" id="SatuanRujukan_Detail"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Catatan </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="Catatan" id="Catatan"  >
                                                 </div>
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Batas Atas </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="BatasAtas" id="BatasAtas"  >
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Batas Bawah </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="BatasBawah" id="BatasBawah"  >
                                                 </div>
                                             </div>
                                             <button type="button" class="btn bg-black btn-animated btn-wide" id="btnSave" name="btnSave"><span class="visible-content">Save</span><span class="hidden-content"><i class="fa fa-plus"></i></span></button>
                                            </form>

                                            
                                     </div>


        </div>
        <div class="modal-footer">

        </div>
    </div>
</div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->


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
 <script src="<?= BASEURL; ?>/js/App/Tarif/TindakanLab/MasterTindakan_Lab_View.js"></script>