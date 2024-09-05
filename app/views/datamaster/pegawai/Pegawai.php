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
                                 <h5>Input <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small> </h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <!-- Nav tabs -->
                             <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                 <li role="presentation" class="active"><a class="" href="#datadetil" aria-controls="datadetil" role="tab" data-toggle="tab">Data Detil</a></li>
                                 <li role="presentation"><a class="" href="#pendidikan" aria-controls="pendidikan" role="tab" data-toggle="tab">Pendidikan</a></li>
                                 <li role="presentation"><a class="" href="#keluarga" aria-controls="keluarga" role="tab" data-toggle="tab">Keluarga</a></li>
                                 <li role="presentation"><a class="" href="#kontrakkerja" aria-controls="kontrakkerja" role="tab" data-toggle="tab">Kontrak Kerja</a></li>
                                 <li role="presentation"><a class="" href="#pelatihankerja" aria-controls="pelatihankerja" role="tab" data-toggle="tab">Pelatihan Kerja</a></li>
                                 <li role="presentation"><a class="" href="#suratperingatan" aria-controls="suratperingatan" role="tab" data-toggle="tab">Surat Peringatan</a></li>
                                 <li role="presentation"><a class="" href="#resign" aria-controls="resign" role="tab" data-toggle="tab">Resign</a></li>
                             </ul>

                             <!-- Tab panes -->
                             <div class="tab-content bg-white p-15">

                                 <div role="tabpanel" class="tab-pane active" id="datadetil">
                                     <form id="FRMcreatemr">
                                         <div class="form-group row">
                                             <label for="staticEmail" class="col-sm-2 col-form-label">Cari Pegawai</label>
                                             <div class="col-sm-3">
                                                 <button class="btn btn-primary" id="btnSearch" name="btnSearch" onclick="showDataAllPegawai()"><span class="glyphicon glyphicon-search"></span> CARI DATA</button>
                                             </div>
                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">No. ID</label>
                                             <div class="col-sm-2">
                                                 <input class="form-control input-sm" id="hrd_id" required name="hrd_id" type="text" readonly placeholder="Ketik No. ID disini" class="containerX">
                                             </div>
                                             <div class="col-sm-2">
                                                 <select name="hrd_status" id="hrd_status" class="form-control">
                                                     <option value='1'>AKTIF</option>
                                                     <option value='0'>NON AKTIF</option>
                                                 </select>
                                             </div>

                                             <label for="namapasien" class="col-sm-3 col-form-label">GUT ID <sup class="color-danger">*</sup></label>

                                             <div class="col-sm-3">

                                                 <input class="form-control input-sm" id="hrd_nip" name="hrd_nip" autocomplete="off" type="text" placeholder="Ketik GUT ID disini" class="containerX">
                                                 <div id="error_Medrec_NoIdPengenal"></div>
                                             </div>
                                         </div>

                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Nama Pegawai <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm" id="hrd_namapegawai" name="hrd_namapegawai" type="text" autocomplete="off">
                                                 <div id="error_Medrec_NamaPasien"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Department</label>
                                             <div class="col-sm-3">
                                                 <select name="hrd_department" id="hrd_department" class="form-control">
                                                 </select>
                                                 <div id="error_Medrec_IdPengenal"></div>
                                             </div>
                                         </div>

                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Alamat <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <textarea class="form-control" id="hrd_alamat" name="hrd_alamat" rows="4" cols="34" style="resize: none;"></textarea>
                                                 <div id="error_Medrec_Alamat"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Unit Kerja</label>
                                             <div class="col-sm-3">
                                                 <select name="hrd_unitkerja" id="hrd_unitkerja" class="form-control">
                                                 </select>
                                                 <div id="error_Medrec_Bin"></div>
                                             </div>
                                         </div>

                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Alamat Domisili <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <textarea class="form-control" id="hrd_alamat_domisili" name="hrd_alamat_domisili" rows="4" cols="34" style="resize: none;"></textarea>
                                                 <div id="error_Medrec_AlamatDomisili"></div>
                                             </div>

                                             <label for="namapasien" class="col-sm-3 col-form-label">Jabatan</label>
                                             <div class="col-sm-3">
                                                 <select name="hrd_jabatan" id="hrd_jabatan" class="form-control">
                                                 </select>
                                                 <div id="error_Medical_JKel"></div>
                                             </div>
                                         </div>

                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label"></label>
                                             <div class="col-sm-4">
                                                 <div id="error_Medical_JKel"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Status Pegawai <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <select name="hrd_status_pegawai" id="hrd_status_pegawai" class="form-control">
                                                 </select>
                                                 <div id="error_Medical_Agama"></div>
                                             </div>
                                         </div>

                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Jenis Kelamin <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select name="hrd_jeniskelamin" id="hrd_jeniskelamin" class="form-control">
                                                     <option value=''>-- PILIH --</option>
                                                     <option value='2'>Perempuan</option>
                                                     <option value='1'>laki-Laki</option>
                                                 </select>
                                                 <div id="error_Medical_JKel"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Agama <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <select name="hrd_agama" id="hrd_agama" class="form-control">
                                                 </select>
                                                 <div id="error_Medical_Agama"></div>
                                             </div>
                                         </div>

                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Provinsi <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select class="form-control" name="Medical_Provinsi" id="Medical_Provinsi" onchange="getKabupaten();">
                                                 </select>
                                                 <div id="error_Medical_Provinsi"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Warganegara </label>
                                             <div class="col-sm-3">
                                                 <select name="Medrec_Warganegara" id="Medrec_Warganegara" class="form-control">

                                                     <option value='WNI'>WNI</option>
                                                     <option value='WNA'>WNA</option>
                                                 </select>
                                                 <div id="error_Medrec_Warganegara"></div>
                                             </div>
                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Kab/Kodya <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select class="form-control" name="Medrec_kabupaten" id="Medrec_kabupaten">
                                                 </select>
                                                 <div id="error_Medrec_kabupaten"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Tempat Lahir <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm" id="Medrec_Tpt_lahir" name="Medrec_Tpt_lahir" type="text" placeholder="Ketik Tpt Lahir disini" class="containerX">
                                                 <div id="error_Medrec_Tpt_lahir"></div>
                                             </div>
                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Kecamatan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select class="form-control" name="Medrec_Kecamatan" id="Medrec_Kecamatan">
                                                 </select>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Tanggal Lahir <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm " id="Medrec_Tgl_Lahir" name="Medrec_Tgl_Lahir" type="date">
                                                 <div id="error_Medrec_Tgl_Lahir"></div>
                                             </div>
                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Kelurahan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select class="form-control" name="Medrec_Kelurahan" id="Medrec_Kelurahan">
                                                 </select>
                                                 <div id="error_Medrec_Kelurahan"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Status Nikah <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <select name="Hrd_statusNikah" id="Hrd_statusNikah" class="form-control"></select>
                                                 <div id="error_Medrec_statusNikah"></div>
                                             </div>
                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Kode Pos</label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm " id="Medrec_Kodepos" name="Medrec_Kodepos" type="text" placeholder="Ketik Kodepos disini" readonly>
                                                 <div id="error_Medrec_HomePhone"></div>
                                             </div>

                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Home Phone <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm " id="hrd_HomePhone" autocomplete="off" autocomplete="off" name="hrd_HomePhone" type="text" placeholder="Ketik No. Homephone disini">
                                                 <div id="error_Medrec_HomePhone"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Handphone <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm " id="hrd_handphone" autocomplete="off" name="hrd_handphone" type="text" placeholder="Ketik No. handphone">
                                                 <div id="error_Medrec_handphone"></div>
                                             </div>
                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Pendidikan </label>
                                             <div class="col-sm-4">
                                                 <select name="hrd_Pendidikan" id="hrd_Pendidikan" class="form-control">
                                                 </select>
                                                 <div id="Medrec_Pendidikan"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Status Pajak <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <select name="hrd_status_pajak" id="hrd_status_pajak" class="form-control">
                                                     <option value=''>-- PILIH --</option>
                                                     <option value='TK-0'>TK-0</option>
                                                     <option value='K-0'>K-0</option>
                                                     <option value='K-1'>K-1</option>
                                                     <option value='K-2'>K-2</option>
                                                     <option value='K-3'>K-3</option>
                                                 </select>
                                                 <div id="Medrec_Pekerjaan"></div>
                                             </div>
                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Jurusan </label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm " id="hrd_jurusan2" autocomplete="off" name="hrd_jurusan2" type="Email" placeholder="Ketik Jurusan">
                                                 <div id="Medrec_Medrec_Email"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Jumlah Tanggungan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm " id="hrd_jmltanggungan" autocomplete="off" name="hrd_jmltanggungan" type="text" placeholder="Ketik Jumlah tanggungan disini">
                                             </div>
                                             <div id="error_Medrec_Ibu_Kandung"></div>

                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">No. NPWP </label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm " id="hrd_npwp" autocomplete="off" name="hrd_npwp" type="Email" placeholder="Ketik No. NPWP disini">
                                                 <div id="Medrec_Medrec_Email"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">No. KTP </label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm " id="hrd_ktp" autocomplete="off" name="hrd_ktp" type="text" placeholder="Ketik KTP disini">
                                             </div>
                                             <div id="error_Medrec_Ibu_Kandung"></div>

                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">No. BPJS TK </label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm " id="hrd_bpjstk" autocomplete="off" name="hrd_bpjstk" type="Email" placeholder="Ketik No. BPJS Tenagakerja disini">
                                                 <div id="Medrec_Medrec_Email"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">No. BPJS KESEHATAN </label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm " id="hrd_bpjs_kes" autocomplete="off" name="hrd_bpjs_kes" type="text" placeholder="Ketik BPJS Kesehatan disini">
                                             </div>
                                             <div id="error_Medrec_Ibu_Kandung"></div>

                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">No. Rekening </label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm " id="hrd_norekenig" autocomplete="off" name="hrd_norekenig" type="Email" placeholder="Ketik No. Rekening disini">
                                                 <div id="Medrec_Medrec_Email"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Hak Kelas </label>
                                             <div class="col-sm-3">
                                                 <select name="hrd_hakKelas" id="hrd_hakKelas" class="form-control">
                                                     <option value=''>-- PILIH --</option>
                                                     <option value='1'>KELAS I</option>
                                                     <option value='2'>KELAS II</option>
                                                     <option value='3'>KELAS III</option>
                                                     <option value='4'>KELAS VIP</option>
                                                     <option value='5'>KELAS VVIP</option>
                                                 </select>
                                             </div>
                                             <div id="error_Medrec_Ibu_Kandung"></div>

                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label">Nama Bank </label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm " id="hrd_namabank" autocomplete="off" name="hrd_namabank" type="Email" placeholder="Ketik Nama Bank disini" value="BANK CIMB">
                                                 <div id="Medrec_Medrec_Email"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label"> Tipe Karyawan <sup class="color-danger">*</sup>
                                             </label>
                                             <div class="col-sm-3">
                                                 <select name="hrd_tipeKaryawan" id="hrd_tipeKaryawan" class="form-control">
                                                     <option value=''>-- PILIH --</option>
                                                     <option value='Internal'>Internal</option>
                                                     <option value='Eksternal'>Eksternal</option>
                                                 </select>
                                             </div>
                                             <div id="error_Medrec_Ibu_Kandung"></div>

                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label"> </label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm " id="hrd_str" value="0" autocomplete="off" readonly name="hrd_str" type="hidden" placeholder="Ketik No. STR disini">
                                                 <div id="Medrec_Medrec_Email"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label">Tanggal Masuk <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm " id="hrd_tglmasuk" autocomplete="off" name="hrd_tglmasuk" type="date">
                                             </div>
                                             <div id="error_Medrec_Ibu_Kandung"></div>

                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label"> </label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm " id="hrd_plafonRajal" value="0" name="hrd_plafonRajal" type="hidden" placeholder="Ketik Plafon Rajal disini">
                                                 <div id="Medrec_Medrec_Email"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label"> </label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm " value="0" id="hrd_plafonRanap" name="hrd_plafonRanap" type="hidden" placeholder="Ketik Plafon Ranap disini">
                                                 <div id="Medrec_Medrec_Email"></div>
                                             </div>
                                             <div id="error_Medrec_Ibu_Kandung"></div>

                                         </div>
                                         <div class="row" style="margin-bottom:3px;">
                                             <label for="namapasien" class="col-sm-2 col-form-label"> </label>
                                             <div class="col-sm-4">

                                                 <div id="Medrec_Medrec_Email"></div>
                                             </div>
                                             <label for="namapasien" class="col-sm-3 col-form-label"> </label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm " value="0" id="hrd_hakKelas_PlafonRS" name="hrd_hakKelas_PlafonRS" type="hidden" placeholder="Ketik Plafon Ranap disini">

                                             </div>
                                             <div id="error_Medrec_Ibu_Kandung"></div>

                                         </div>
                                         <input class="form-control input-sm" id="statusmr" name="statusmr" type="hidden" readonly>
                                     </form>
                                     <button class="btn btn-primary" id="btnsimpanTrsReg" name="btnsimpanTrsReg"> Finish</button>
                                     <button class="btn btn-secondary" id="close" name="close">Close</button>
                                 </div>
                                 <div role="tabpanel" class="tab-pane" id="pendidikan">
                                     <form class="form-horizontal" id="form_resign">
                                         <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label">Jenis Pendidikan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select name="hrd_jenis_Pendidikan" id="hrd_jenis_Pendidikan" class="form-control">
                                                     <option value=''>-- PILIH --</option>
                                                     <option value='SD'>SD</option>
                                                     <option value='SMP'>SMP</option>
                                                     <option value='SMA'>SMA</option>
                                                     <option value='SMK'>SMK</option>
                                                     <option value='D1'>D1</option>
                                                     <option value='D2'>D2</option>
                                                     <option value='D3'>D3</option>
                                                     <option value='S1'>S1</option>
                                                     <option value='S2'>S2</option>
                                                     <option value='S3'>S3</option>
                                                     <option value='LAINLAIN'>LAIN-LAIN</option>
                                                 </select>
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Inst. Pendidikan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm" id="hrd_Nama_Pendidikan" name="hrd_Nama_Pendidikan" type="text" placeholder="Ketik Nama Instansi Pendidikan disini" class="containerX">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label"> Tahun Lulus <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control" id="hrd_Tahun_Lulus" name="hrd_Tahun_Lulus" type="date" placeholder="Ketik Nomor NIP disini" class="containerX">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Jurusan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control" id="hrd_Jurusan" name="hrd_Jurusan" type="text" placeholder="Ketik Jurusan disini" class="containerX">
                                             </div>
                                         </div>
                                     </form>
                                     <div class="form-group">
                                         <label for=" inputEmail3" class="col-sm-2 control-label"></label>
                                         <div class="col-sm-2">
                                             <button class="btn btn-danger" id="adds" name="adds" onclick="add_Pendidikan();"> ADD</button>
                                         </div>
                                     </div>
                                     <h3 style="margin-top: 80px;">Data Pendidikan</h3>
                                     <div class="table-responsive" id="tbl_rekap" style="margin-top: 10px;">
                                         <table id="tblPendidikan" width="100%" class="table table-striped table-hover cell-border">
                                             <thead>
                                                 <tr>
                                                     <th align='center'>
                                                         <font size="1">No.
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Jenis Pendidikan
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Nama Pendidikan
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Jurusan Pendidikan
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tahun Lulus
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
                                 <div role="tabpanel" class="tab-pane" id="keluarga">
                                     <form class="form-horizontal" id="form_resign">
                                         <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label">Jenis Keluarga <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select name="hrd_jenis_Keluarga" id="hrd_jenis_Keluarga" class="form-control">
                                                     <option value=''>-- PILIH --</option>
                                                     <option value='1'>SUAMI</option>
                                                     <option value='2'>ISTRI</option>
                                                     <option value='3'>ANAK 1</option>
                                                     <option value='4'>ANAK 2</option>
                                                     <option value='5'>ANAK 3</option>
                                                     <option value='6'>ANAK 4</option>
                                                     <option value='7'>ANAK 5</option>
                                                 </select>
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Tempat Lahir <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control" id="hrd_tempat_lahir" name="hrd_tempat_lahir" type="text" placeholder="Ketik Nama Tempat Lahir disini" class="containerX">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">Tahun Lahir <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control" id="hrd_Tahun_lahir" name="hrd_Tahun_lahir" type="date" placeholder="Ketik  disini" class="containerX">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Nama Keluarga <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm" id="hrd_nama_keluarga" name="hrd_nama_keluarga" type="text" placeholder="Ketik Nama Keluarga disini" class="containerX">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">No. KTP <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control" id="hrd_Kel_NoKtp" name="hrd_Kel_NoKtp" type="number" placeholder="Ketik  No. Ktpdisini" class="containerX">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">No. KK <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm" id="hrd_Kel_NoKK" name="hrd_Kel_NoKK" type="number" placeholder="Ketik No. KK disini" class="containerX">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">No. Tlp <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm" id="hrd_Kel_Tlp" name="hrd_Kel_Tlp" type="number" placeholder="Ketik No. Tlp disini" class="containerX">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">No. BPJS <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm" id="hrd_Kel_BPJS" name="hrd_Kel_BPJS" type="text" placeholder="Ketik No. BPJS disini" class="containerX">
                                             </div>
                                         </div>
                                     </form>
                                     <div class="form-group">
                                         <label for=" inputEmail3" class="col-sm-2 control-label"></label>
                                         <div class="col-sm-2">
                                             <button class="btn btn-danger" id="addkeluarga" name="addkeluarga" onclick="add_keluarga();"> ADD</button>
                                         </div>
                                     </div>
                                     <h3 style="margin-top: 80px;">Data Keluarga</h3>
                                     <div class="table-responsive" id="tbl_rekap" style="margin-top: 10px;">
                                         <table id="tbl_keluargax" width="100%" class="table table-striped table-hover cell-border">
                                             <thead>
                                                 <tr>
                                                     <th align='center'>
                                                         <font size="1">No.
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Jenis Keluarga
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Nama Keluarga
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tgl Lahir
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tpt Lahir
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">NIK
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">No. KK
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">No. Tlp
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">No. BPJS
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
                                 <div role="tabpanel" class="tab-pane" id="kontrakkerja">
                                     <form class="form-horizontal" id="form_resign">
                                         <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label">Status Kerja <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select name="hrd_status_kerja2" id="hrd_status_kerja2" class="form-control">
                                                 </select>
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Kode JO <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-2">
                                                 <select name="hrd_Lokasi" id="hrd_Lokasi" class="form-control" onchange="searchnilaiumklokasi()">
                                                 </select>
                                             </div>
                                             <div class="col-sm-2">
                                                 <input class="form-control input-sm" id="hrd_nilaiumk_lokasi" name="hrd_nilaiumk_lokasi" type="text" placeholder="" class="containerX" readonly>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">Grade <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select name="Hrd_Grade" id="Hrd_Grade" class="form-control">
                                                     <option value="HELPER">HELPER</option>
                                                     <option value="SEMISKILL">SEMI SKILL </option>
                                                     <option value="SKILL">SKILL</option>
                                                     <option value="FOREMAN">FOREMAN</option>
                                                     <option value="SPV">SPV</option>
                                                     <option value="LAIN">LAIN-LAIN</option>
                                                 </select>
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Tipe <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <select name="Hrd_Tipe" id="Hrd_Tipe" class="form-control" onchange="valtipe()">
                                                     <option value="A">TIPE A</option>
                                                     <option value="B">TIPE B</option>
                                                     <option value="C">TIPE C</option>
                                                 </select>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">Awal kontrak <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control" id="hrd_tgl_awal_kontrak" name="hrd_tgl_awal_kontrak" type="date" placeholder="Ketik Nama Instansi Pendidikan disini" class="containerX">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Akhir kontrak <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control" id="hrd_tgl_akhir_kontrak" name="hrd_tgl_akhir_kontrak" type="date" placeholder="Ketik Nomor NIP disini" class="containerX">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">UMK Sepakat <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control" id="hrd_nilai_UMK" name="hrd_nilai_UMK" type="number" placeholder="Ketik UMK disini" class="containerX">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">No. Surat <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control" id="hrd_no_surat_statuskerjad" name="hrd_no_surat_statuskerjad" type="text" placeholder="Ketik No. Surat disini" class="containerX">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">Tipe Kontrak <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select name="Hrd_Tipe_Kontrak" id="Hrd_Tipe_Kontrak" class="form-control">
                                                     <option value="1">BULANAN</option>
                                                     <option value="2">HARIAN</option>
                                                 </select>
                                             </div>
                                         </div>
                                     </form>
                                     <div class="form-group">
                                         <label for=" inputEmail3" class="col-sm-2 control-label"></label>
                                         <div class="col-sm-2">
                                             <button class="btn btn-danger" id="addsts" name="addsts" onclick="add_datastatus_Kerja();"> ADD</button>
                                         </div>
                                     </div>
                                     <h3 style="margin-top: 80px;">Data Kontrak Kerja</h3>
                                     <div class="table-responsive" id="tbl_rekap" style="margin-top: 10px;">
                                         <table id="tbl_status_kerja" width="100%" class="table table-striped table-hover cell-border">
                                             <thead>
                                                 <tr>
                                                     <th align='center'>
                                                         <font size="1">No.
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Status Kerja
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tgl Awal
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tgl Akhir
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">SK
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Lokasi
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">TIPE
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Grade
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tipe Kontrak
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
                                 <div role="tabpanel" class="tab-pane" id="pelatihankerja">
                                     <form class="form-horizontal" id="form_resign">
                                         <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label">Jenis Pelatihan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select name="hrd_jenis_Pelatihan" id="hrd_jenis_Pelatihan" class="form-control">
                                                     <option value=''>-- PILIH --</option>
                                                     <option value='INTERNAL'>INTERNAL</option>
                                                     <option value='EXTERNAL'>EXTERNAL</option>
                                                 </select>
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Nama Pelatihan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control" id="hrd_nama_pelatihan" name="hrd_nama_pelatihan" type="text" placeholder="Ketik Nama Pelatihan disini" class="containerX">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">Tgl Awal <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control" id="hrd_tgl_mulai_pelatihan" name="hrd_tgl_mulai_pelatihan" type="date" placeholder="Ketik disini" class="containerX">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Tgl Akhir <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control" id="hrd_tgl_akhir_pelatihan" name="hrd_tgl_akhir_pelatihan" type="date" placeholder="Ketik Tgl Penempatan disini" class="containerX">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">Alamat <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <textarea class="form-control" id="hrd_alamat_Pelatihan" name="hrd_alamat_Pelatihan" rows="4"></textarea>
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Lama Pelatihan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control" id="hrd_lama_pelatihan" name="hrd_lama_pelatihan" type="number" placeholder="Ketik Angka Jam" class="containerX">
                                                 <small>*) Diisi untuk pelatihan Internal ( dalam satuan jam. Ex : 1 )</small>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">No. Sertifikat <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <input class="form-control input-sm" id="hrd_noSertifikat_pelatihan" name="hrd_noSertifikat_pelatihan" type="text" placeholder="Ketik No. Sertifikat disini" class="containerX">
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Masa Berlaku <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm" id="hrd_tglexpiredsertifikat" name="hrd_tglexpiredsertifikat" type="date" placeholder="Ketik No. Sertifikat disini" class="containerX">
                                             </div>
                                         </div>
                                     </form>
                                     <div class="form-group">
                                         <label for=" inputEmail3" class="col-sm-2 control-label"></label>
                                         <div class="col-sm-2">
                                             <button class="btn btn-danger" id="addkeluarga" name="addkeluarga" onclick="add_pelatihan_kerja();"> ADD</button>
                                         </div>
                                     </div>
                                     <h3 style="margin-top: 80px;">Data Pelatihan</h3>
                                     <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                         <table id="tbl_pelatihan" class="table table-striped table-hover cell-border">
                                             <thead>
                                                 <tr>
                                                     <th align='center'>
                                                         <font size="1">No.
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Jenis Pelatihan
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Nama Pelatihan
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tgl Awal
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tgl Akhir
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Alamat Pelatihan
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Lama Pelatihan Internal (Jam)
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">No. Sertifikat
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tgl Berlaku
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
                                 <div role="tabpanel" class="tab-pane" id="suratperingatan">
                                     <form class="form-horizontal" id="form_resign">
                                         <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label">Jenis SP <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <select name="hrd_jenis_sp" id="hrd_jenis_sp" class="form-control">
                                                 </select>
                                             </div>
                                             <label for="inputEmail3" class="col-sm-2 control-label">Keterangan SP <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-4">
                                                 <textarea id="hrd_keterangan_sp" name="hrd_keterangan_sp" rows="4" class="form-control"></textarea>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">Tanggal SP <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm" id="hrd_tgl_sp" name="hrd_tgl_sp" type="date" placeholder="Ketik Nama Instansi Pendidikan disini" class="containerX">
                                             </div>
                                             <label for="namapasien" class="col-sm-2 col-form-label"> Sampai Dengan <sup class="color-danger">*</sup></label>
                                             <div class="col-sm-3">
                                                 <input class="form-control input-sm" id="hrd_tgl_sp2" name="hrd_tgl_sp2" type="date" placeholder="Ketik Nama Instansi Pendidikan disini" class="containerX">
                                             </div>
                                         </div>
                                     </form>
                                     <div class="form-group">
                                         <label for=" inputEmail3" class="col-sm-2 control-label"></label>
                                         <div class="col-sm-2">
                                             <button class="btn btn-danger" id="addsp" name="addsp"> ADD</button>
                                         </div>
                                     </div>
                                     <h3 style="margin-top: 80px;">Data SP Kerja</h3>
                                     <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                         <table id="tbl_sp" width="100%" class="table table-striped table-hover cell-border">
                                             <thead>
                                                 <tr>
                                                     <th align='center'>
                                                         <font size="1">No.
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Jenis SP
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tanggal SP Awal
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Tanggal SP Akhir
                                                     </th>
                                                     <th align='center'>
                                                         <font size="1">Keterangan
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
                                 <div role="tabpanel" class="tab-pane" id="resign">
                                     <form class="form-horizontal" id="form_resign">
                                         <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Resign </label>
                                             <div class="col-sm-4">
                                                 <input class="form-control" id="hrd_tgl_resign" name="hrd_tgl_resign" type="date" placeholder="Ketik Nama Instansi Pendidikan disini" class="containerX">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for=" inputEmail3" class="col-sm-2 control-label">Keterangan </label>
                                             <div class="col-sm-4">
                                                 <textarea class="form-control" id="hrd_keterangan_resign" name="hrd_keterangan_resign" rows="4"></textarea>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for="inputEmail3" class="col-sm-2 control-label"> Atribut Pegawai </label>
                                             <div class="col-sm-4">
                                                 <textarea class="form-control" id="hrd_keterangan_atributx" name="hrd_keterangan_atributx" rows="4"></textarea>
                                                 <br> <small>*) Silahkan ketik attribut yang sudah di kembalikan disini.</small>
                                             </div>
                                         </div>
                                     </form>
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
 <div class="modal fade" id="loadMdlLogbook" tabindex="-1" role="dialog" style="overflow-y: auto">

     <div class="modal-dialog modal-lg">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h5 class="underline mt-30"> List Data Pegawai </h4>
             </div>
             <div class="modal-body">
                 <div class="table-responsive">
                     <table id="tblpeagwaiAll" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                         <thead>
                             <tr>
                                 <th align='center'>
                                     <font size="1">GUT ID
                                 </th>
                                 <th align='center'>
                                     <font size="1">Nama
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
             <div class="modal-footer">
                 <div class="form-group row" style="margin-right:1em;float:right;">
                     <button class="btn btn-secondary" data-dismiss="modal" name="btnclose">
                         Close</button>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/Pegawai_v11.js"></script>