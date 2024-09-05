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
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Nama <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NamaDokter" name="NamaDokter" maxlength="50">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Spesialis <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Spesialis" name="Spesialis">
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Job Title <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select name="JobTitle" id="JobTitle" class="form-control">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Category <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select name="Category" id="Category" class="form-control">
                                             <option value="">-- PILIH CATEGORY --</option>
                                             <option value="6">dr. Spesialis</option>
                                             <option value="7">dr.Umum</option>
                                             <option value="8">dr. Gigi</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Grup Perawatan <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select name="GrupPerawatan" id="GrupPerawatan" class="form-control">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Alamat </label>
                                     <div class="col-sm-4">
                                         <textarea rows="4" class="form-control" id="AlamatDokter" name="AlamatDokter" style="resize: none"></textarea>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Kota </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Kota" name="Kota">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir </label>
                                     <div class="col-sm-4">
                                         <input type="date" class="form-control" id="TglLahirDokter" name="TglLahirDokter">
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Telpon </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="TlpDokter" name="TlpDokter">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> No. Handphone </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NOHP" name="NOHP">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Email </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="EmailDokter" name="EmailDokter">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Fix Salary </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="FixSalary" name="FixSalary">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> No. SIP</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NOSIP" name="NOSIP">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Share Konsul <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="ShareKonsul" name="ShareKonsul">
                                         <small>Contoh : ketik Angka 60 Jika 60%</small>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Praktek <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="Praktek" name="Praktek">
                                             <option value="">-- PILIH PRAKTEK --</option>
                                             <option value="1">Ya</option>
                                             <option value="0">Tidak</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Status <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="Status" name="Status">
                                             <option value="">-- PILIH STATUS --</option>
                                             <option value="1">Aktif</option>
                                             <option value="0">Tidak Aktif</option>
                                         </select>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Permanen <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="Permanen" name="Permanen">
                                             <option value="">-- PILIH PERMANEN --</option>
                                             <option value="1">Ya</option>
                                             <option value="0">Tidak</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> NPWP </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NPWP" name="NPWP">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nama Bank</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NamaBank" name="NamaBank">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> No. Rekening </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Norek" name="Norek">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Atas Nama Rekening</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="AtasnamaRek" name="AtasnamaRek">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> FS FI <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="FSFI" name="FSFI">
                                             <option value="">-- PILIH FS FI --</option>
                                             <option value="1">Ya</option>
                                             <option value="0">Tidak</option>
                                         </select>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> FS FI Prosen<sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="FSFIProsen" name="FSFIProsen">
                                             <option value="">-- PILIH FS FI PROSEN--</option>
                                             <option value="1">Ya</option>
                                             <option value="0">Tidak</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nilai FI <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NilaiFI" name="NilaiFI">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> FS GI GF <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="FSGIGF" name="FSGIGF">
                                             <option value="">-- PILIH FS GI GF --</option>
                                             <option value='NON'>NON</option>
                                             <option value='GI'>GI</option>
                                             <option value='GF'>GF Honorer</option>
                                             <option value='GFU'>GF Tetap</option>
                                         </select>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nilai GI GF <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NilaiGIGF" name="NilaiGIGF">
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label">Kode Tipe Jasa <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="KodeTipeJasa" name="KodeTipeJasa">
                                             <option value="">-- PILIH KODE TIPE JASA --</option>
                                             <option value='SPES'>SPES</option>
                                             <option value='UMUM'>UMUM</option>
                                         </select>
                                     </div>

                                     <label for="inputEmail3" class="col-sm-2 control-label">Group Spesialis<sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control" id="GroupSpesialis" name="GroupSpesialis">
                                         </select>
                                     </div>
                                 </div>

                                 <div class="form-group gut">

                                     <label for="inputEmail3" class="col-sm-2 control-label">ID Dokter BPJS</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="IDDokter_BPJS" name="IDDokter_BPJS">
                                     </div>

                                     <label for="inputEmail3" class="col-sm-2 control-label">Code Antrian<sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="CodeAntrian" name="CodeAntrian">
                                     </div>

                                 </div>
                                 <div class="form-group gut">

                                     <label for="inputEmail3" class="col-sm-2 control-label">Pendidikan</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Pendidikan" name="Pendidikan">
                                     </div>

                                     <label for="inputEmail3" class="col-sm-2 control-label">Description<sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Description" name="Description">
                                     </div>

                                 </div>
                                 <div class="form-group gut"> 
                                     <label for="inputEmail3" class="col-sm-2 control-label">Pelatihan</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Pelatihan" name="Pelatihan">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label">NIK <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="number" class="form-control" id="NIK" name="NIK">
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
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterDataDokter/MasterDataDokter_View_V02.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>