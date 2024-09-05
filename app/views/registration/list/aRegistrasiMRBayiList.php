<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Menampilkan Data <?= $data['judul'] ?>.</p>
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

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?> (Rawat Inap)

                                </h5>
                                <div class="panel-body p-20">

                                    <div class="table-responsive demo-table" style="overflow-x:auto;">
                                        <table id="example" class="display" width="100%">
                                            <!-- <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%"> -->
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size="1"> ID
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1"> No MR Ibu
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1"> No Registrasi Ibu
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1"> Nama Ibu
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1"> Nama Bayi
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1"> Ruang Rawat Asal
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1"> Ruang Rawat Tujuan
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1"> Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal DATA SOSIAL PASIEN-->
                            <div class="modal fade" id="ModalInputMRBAru" role="dialog" style="overflow-y: auto" data-backdrop="static">
                                <div class="modal-dialog  modal-lg">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Medical Record Pasien</h4>
                                        </div>
                                        <form id="FRMcreatemr">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12 form-group">
                                                        <div class="col-sm-12">
                                                            <ul class="nav nav-tabs">
                                                                <li class="active"><a data-toggle="tab" href="#home" style="background-color:#ffc7c7;">Data Sosial </a></li>
                                                                <li><a data-toggle="tab" href="#pekerjaan" style="background-color:#2fcee9;">Data
                                                                        Pekerjaan</a></li>
                                                                <li><a data-toggle="tab" href="#menu1" style="background-color:#c7ffcd;">Data
                                                                        Keluarga</a></li>
                                                                <li><a data-toggle="tab" href="#arsip_rajal" style="background-color:#e6fffd;">Arsip
                                                                        Rawat Jalan</a></li>
                                                                <li><a data-toggle="tab" href="#arsip_ranap" style="background-color:#e9e6ff;">Arsip
                                                                        Rawat Inap</a></li>
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div id="home" class="tab-pane fade in active">
                                                                    <br>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">No. MR <sup class="color-danger">*</sup></label>
                                                                        <input class="form-control input-sm" id="iswalkin" name="iswalkin" type="hidden" readonly>
                                                                        <input class="form-control input-sm" id="ID_MRPermintaaBayi" name="ID_MRPermintaaBayi" type="hidden" readonly>
                                                                        <div class="col-sm-2">
                                                                            <input class="form-control input-sm" id="Medrec_NoMR" required name="Medrec_NoMR" type="text" readonly placeholder="Ketik No. MR disini" class="containerX">
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <select name="Medrec_Status" id="Medrec_Status" class="form-control">
                                                                                <option value='1'>AKTIF</option>
                                                                                <option value='0'>NON AKTIF</option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Td Pengenal : <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <select name="Medrec_IdPengenal" id="Medrec_IdPengenal" class="form-control">
                                                                                <option value='KTP'>KTP</option>
                                                                                <option value='SIM'>SIM</option>
                                                                                <option value='KTA'>KTA</option>
                                                                                <option value='KTM'>KTM</option>
                                                                                <option value='PASPORT'>PASPORT</option>
                                                                                <option value='KT PELAJAR'>KT PELAJAR</option>
                                                                                <option value='KIA'>KIA</option>
                                                                            </select>
                                                                            <div id="error_Medrec_IdPengenal"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Nama Pasien <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <input class="form-control input-sm" id="Medrec_NamaPasien" autocomplete="off" name="Medrec_NamaPasien" type="text">
                                                                            <div id="error_Medrec_NamaPasien"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Nomor Identitas <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control input-sm" autocomplete="off" id="Medrec_NoIdPengenal" name="Medrec_NoIdPengenal" type="text" placeholder="Ketik NomorID disini" class="containerX">
                                                                            <div id="error_Medrec_NoIdPengenal"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="IhsNumber" class="col-sm-2 col-form-label">No. IHS Satu Sehat <sup
                                                                                class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <input class="form-control input-sm" id="Medrec_IhsNumber"
                                                                                autocomplete="off" name="Medrec_IhsNumber" readonly type="text">
                                                                            <div id="error_Medrec_IhsNumber"></div>
                                                                        </div>
                            
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Alamat <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <textarea id="Medrec_Alamat" name="Medrec_Alamat"></textarea>
                                                                            <div id="error_Medrec_Alamat"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Bin/Bt </label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control input-sm" id="Medrec_Bin" autocomplete="off" name="Medrec_Bin" type="text" placeholder="Ketik NomorID disini" class="containerX">
                                                                            <div id="error_Medrec_Bin"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Jenis Kelamin <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <select name="Medical_JKel" id="Medical_JKel" class="form-control">
                                                                                <option value=''></option>
                                                                                <option value='P'>Perempuan</option>
                                                                                <option value='L'>laki-Laki</option>
                                                                            </select>
                                                                            <div id="error_Medical_JKel"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Agama <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <select name="Medical_Agama" id="Medical_Agama" class="form-control">
                                                                                <option value='Islam'>Islam</option>
                                                                                <option value='Katholik'>Katholik</option>
                                                                                <option value='Kristen Protestan'>Kristen Protestan</option>
                                                                                <option value='Budha'>Budha</option>
                                                                                <option value='Hindu'>Hindu</option>
                                                                                <option value='Konghucu'>Konghucu</option>
                                                                            </select>
                                                                            <div id="error_Medical_Agama"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Provinsi <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <select class="col-sm-10" name="Medical_Provinsi" id="Medical_Provinsi" style="width:100%">
                                                                            </select>
                                                                            <div id="error_Medical_Provinsi"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Warganegara <sup class="color-danger">*</sup></label>
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
                                                                            <select class="form-control" name="Medrec_kabupaten" id="Medrec_kabupaten" style="width:100%">
                                                                            </select>
                                                                            <div id="error_Medrec_kabupaten"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Tpt Lahir <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control input-sm" autocomplete="off" id="Medrec_Tpt_lahir" name="Medrec_Tpt_lahir" type="text" placeholder="Ketik Tpt Lahir disini" class="containerX">
                                                                            <div id="error_Medrec_Tpt_lahir"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Kecamatan <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control" name="Medrec_Kecamatan" id="Medrec_Kecamatan" style="width:100%">
                                                                            </select>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Tgl Lahir <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control input-sm " id="Medrec_Tgl_Lahir" name="Medrec_Tgl_Lahir" type="date">
                                                                            <div id="error_Medrec_Tgl_Lahir"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Kelurahan <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control" name="Medrec_Kelurahan" id="Medrec_Kelurahan" style="width:100%">
                                                                            </select>
                                                                            <div id="error_Medrec_Kelurahan"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Status Nikah <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <select name="Medrec_statusNikah" id="Medrec_statusNikah" class="form-control">
                                                                                <option value='BELUM MENIKAH'>BELUM MENIKAH</option>
                                                                                <option value='NIKAH'>NIKAH</option>
                                                                                <option value='DUDA'>DUDA</option>
                                                                                <option value='JANDA'>JANDA</option>
                                                                                <option value='CERAI'>CERAI</option>
                                                                            </select>
                                                                            <div id="error_Medrec_statusNikah"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Home Phone <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <input class="form-control input-sm " id="Medrec_HomePhone" autocomplete="off" name="Medrec_HomePhone" type="text">
                                                                            <div id="error_Medrec_HomePhone"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Handphone <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control input-sm " id="Medrec_handphone" autocomplete="off" name="Medrec_handphone" type="text">
                                                                            <div id="error_Medrec_handphone"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Pendidikan <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <select name="Medrec_Pendidikan" id="Medrec_Pendidikan" class="form-control">
                                                                                <option value='Belum Sekolah'>Belum Sekolah</option>
                                                                                <option value='TK'>TK</option>
                                                                                <option value='SD'>SD</option>
                                                                                <option value='SMP'>SMP</option>
                                                                                <option value='SMU'>SMU</option>
                                                                                <option value='D1'>D1</option>
                                                                                <option value='D3'>D3</option>
                                                                                <option value='S1'>S1</option>
                                                                                <option value='S2'>S2</option>
                                                                                <option value='S3'>S3</option>
                                                                                <option value='Aktif TK'>Aktif TK</option>
                                                                                <option value='Aktif Aktif SD'>SD</option>
                                                                                <option value='Aktif SMP'>Aktif SMP</option>
                                                                                <option value='Aktif SMU'>Aktif SMU</option>
                                                                                <option value='Aktif D1'>Aktif D1</option>
                                                                                <option value='Aktif D2'>Aktif D2</option>
                                                                                <option value='Aktif D3'>Aktif D3</option>
                                                                                <option value='Aktif S1'>Aktif S1</option>
                                                                                <option value='Aktif S2'>Aktif S2</option>
                                                                                <option value='Aktif S3'>Aktif S3</option>
                                                                                <option value='Pesantren'>Pesantren</option>
                                                                                <option value='Tidak Sekolah'>Tidak Sekolah</option>
                                                                            </select>
                                                                            <div id="Medrec_Pendidikan"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Pekerjaan <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <select name="Medrec_Pekerjaan" id="Medrec_Pekerjaan" class="form-control">
                                                                                <option value='P N S'>P N S</option>
                                                                                <option value='I R T'>I R T</option>
                                                                                <option value='BURUH'>BURUH</option>
                                                                                <option value='PELAJAR'>PELAJAR</option>
                                                                                <option value='MAHASISWA'>MAHASISWA</option>
                                                                                <option value='WIRASWASTA'>WIRASWASTA</option>
                                                                                <option value='TIDAK BEKERJA'>TIDAK BEKERJA</option>
                                                                                <option value='PEDAGANG'>PEDAGANG</option>
                                                                                <option value='KARYAWAN/TI'>KARYAWAN/TI</option>
                                                                                <option value='SWASTA'>SWASTA</option>
                                                                                <option value='KARYAWAN RS'>KARYAWAN RS</option>
                                                                                <option value='PETANI'>PETANI</option>
                                                                                <option value='ZUSTER'>ZUSTER</option>
                                                                                <option value='BIDAN'>BIDAN</option>
                                                                                <option value='DOKTER'>DOKTER</option>
                                                                                <option value='TUKANG'>TUKANG</option>
                                                                                <option value='SOPIR'>SOPIR</option>
                                                                                <option value='DOSEN'>DOSEN</option>
                                                                                <option value='GURU'>GURU</option>
                                                                                <option value='BUMN'>BUMN</option>
                                                                                <option value='PENSIUNAN'>PENSIUNAN</option>
                                                                                <option value='ABRI'>ABRI</option>
                                                                                <option value='POLRI'>POLRI</option>
                                                                                <option value='NOTARIS'>NOTARIS</option>
                                                                                <option value='ADVOKAT'>ADVOKAT</option>
                                                                            </select>
                                                                            <div id="Medrec_Pekerjaan"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Email <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <input class="form-control input-sm " id="Medrec_Email" autocomplete="off" name="Medrec_Email" type="Email" placeholder="Contoh: noname@email.com">
                                                                            <div id="Medrec_Medrec_Email"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Nama Ibu Kandung
                                                                            <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control input-sm " autocomplete="off" id="Medrec_NamaIbuKandung" name="Medrec_NamaIbuKandung" type="text" placeholder="Ketik Ibu Kandung disini">
                                                                        </div>
                                                                        <div id="error_Medrec_Ibu_Kandung"></div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Bahasa <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <select name="Medrec_Bahasa" id="Medrec_Bahasa" class="form-control">
                                                                                <option value='BAHASA INDONESIA'>BAHASA INDONESIA</option>
                                                                                <option value='BAHASA DAERAH'>BAHASA DAERAH</option>
                                                                                <option value='BAHASA ASING'>BAHASA ASING</option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Etnis <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <select name="Medrec_Etnis" id="Medrec_Etnis" class="form-control">
                                                                                <option value='JAWA'>JAWA</option>
                                                                                <option value='SUNDA'>SUNDA</option>
                                                                                <option value='MADURA'>MADURA</option>
                                                                                <option value='ASING'>ASING</option>
                                                                                <option value='BATAK'>BATAK</option>
                                                                                <option value='ARAB'>ARAB</option>
                                                                                <option value='LAIN-LAIN'>LAIN-LAIN</option>
                                                                            </select>
                                                                        </div>
                                                                        <div id="error_Medrec_Ibu_Kandung"></div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Kodepos <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <input class="form-control input-sm " autocomplete="off" id="Medrec_Kodepos" name="Medrec_Kodepos" type="text" placeholder="Ketik Kodepos disini" readonly>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">MR Ibu </label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control input-sm " autocomplete="off" id="Medrec_Ibu_Kandung" name="Medrec_Ibu_Kandung" type="text" placeholder="Ketik MR Ibu Kandung disini">
                                                                        </div>
                                                                        <div id="error_Medrec_Ibu_Kandung"></div>
                                                                    </div>
                                                                    <input class="form-control input-sm" id="statusmr" name="statusmr" type="hidden" readonly>
                                                                </div>
                                                                <div id="pekerjaan" class="tab-pane fade"><br>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Nama Perusahaan <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <input class="form-control input-sm " autocomplete="off" id="Medrec_PerusahaanNama" name="Medrec_PerusahaanNama" type="text" placeholder="Ketik Nama Perusahaan disini">
                                                                            <div id="error_Medrec_PerusahaanNama"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Alamat Perusahaan
                                                                            <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <textarea id="Medrec_PerusahaanAlamat" autocomplete="off" name="Medrec_PerusahaanAlamat"></textarea>
                                                                            <div id="error_Medrec_PerusahaanAlamat"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Telepon <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <input class="form-control input-sm " autocomplete="off" id="Medrec_PerusahaanTlp" name="Medrec_PerusahaanTlp" type="text" placeholder="Ketik Nama No Tlp disini">
                                                                            <div id="error_Medrec_NamaPerusahaan"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Fax Perusahaan <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control input-sm " autocomplete="off" id="Medrec_PerusahaanFax" name="Medrec_PerusahaanFax" type="text" placeholder="Ketik Nama No Fax disini">
                                                                            <div id="error_Medrec_PerusahaanFax"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="menu1" class="tab-pane fade">
                                                                    <h3>Dalam Keadaan Darurat</h3> <br>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">Nama <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <input class="form-control input-sm " autocomplete="off" id="Medrec_DaruratNama" name="Medrec_DaruratNama" type="text" placeholder="Ketik Nama Darurat disini">
                                                                            <div id="error_Medrec_DaruratNama"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Alamat Perusahaan
                                                                            <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <textarea id="Medrec_DaruratAlamat" autocomplete="off" name="Medrec_DaruratAlamat"></textarea>
                                                                            <div id="error_Medrec_DaruratAlamat"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-bottom:3px;">
                                                                        <label for="namapasien" class="col-sm-2 col-form-label">No. Tlp <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-4">
                                                                            <input class="form-control input-sm " autocomplete="off" id="Medrec_DaruratTlp" name="Medrec_DaruratTlp" type="text" placeholder="Ketik Nama No Tlp disini">
                                                                            <div id="error_Medrec_DaruratTlp"></div>
                                                                        </div>
                                                                        <label for="namapasien" class="col-sm-3 col-form-label">Hubungan <sup class="color-danger">*</sup></label>
                                                                        <div class="col-sm-3">
                                                                            <select name="Medrec_DaruratHub" id="Medrec_DaruratHub" class="form-control">
                                                                                <option value=''></option>
                                                                                <option value='BELUM MENIKAH'>BELUM MENIKAH</option>
                                                                                <option value='NIKAH'>NIKAH</option>
                                                                                <option value='DUDA'>DUDA</option>
                                                                                <option value='JANDA'>JANDA</option>
                                                                                <option value='CERAI'>CERAI</option>
                                                                            </select>
                                                                            <div id="error_Medrec_DaruratHub"></div>
                                                                        </div>
                                                                    </div>
                                                                </div><br>
                                                                <div id="arsip_rajal" class="tab-pane fade">
                                                                    <div class="table-responsive">
                                                                        <table id="tbl_arsip_rajal" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th align='center'>
                                                                                        <font size='2'>No Registrasi</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>No. MR</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Tgl Kunjungan</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Unit Instalasi</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Dokter</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Tipe Pasien</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Status</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Diagnosa</font>
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div id="arsip_ranap" class="tab-pane fade">
                                                                    <div class="table-responsive">
                                                                        <table id="tbl_arsip_ranap" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th align='center'>
                                                                                        <font size='2'>No. MR</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Nama Pasien</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>No Registrasi</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Tgl Masuk</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Tgl Pulang</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Nama Dokter</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Jenis Pasien</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Nama Kelas</font>
                                                                                    </th>
                                                                                    <th align='center'>
                                                                                        <font size='2'>Penjamin</font>
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="Load_ArsipRanap"> </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </form>
                                        <div class="modal-footer">
                                            <p style="margin-left:1em;float:left;"><b>Petugas Input : </b></p>
                                            <div id="petugasinput" style="margin-left:1em;float:left;"></div>
                                            <div id="jaminput" style="margin-left:1em;float:left;"></div> <br>
                                            <p style="margin-left:-7em;float:left;"><b>Last Update : </b></p>
                                            <div id="petugasupdate" style="margin-left:1em;float:left;"> </div>
                                            <div id="jamupdate" style="margin-left:1em;float:left;"></div>
                                            </p>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-info btn-rounded" id="print_kartumr" name="print_kartumr">
                                                    <span class="glyphicon glyphicon-print"></span> Print Kartu MR
                                                </button>
                                                <button type="button" class="btn btn-primary btn-rounded" id="simapnMR" name="simapnMR">
                                                    <span class="glyphicon glyphicon-save"></span> SIMPAN
                                                </button>
                                                <a data-dismiss="modal" class="btn btn-success btn-rounded" href="#" id="CloseMeMR" name="CloseMeMR">Keluar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal DATA SOSIAL PASIEN -->
                            <!-- Modal CARI MR-->
                            <div class="modal fade" id="modalcariDataMRSave" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static">
                                <div class="modal-dialog  modal-lg">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"> List Data Duplikat</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <div class="col-sm-12">
                                                        <input type="hidden" name="totalrow" id="totalrow" class="form-control totalrow" />
                                                        <div class="alert alert-success alert-dismissible">
                                                            <p> <strong>Info !</strong> Ini adalah List Data Kemiripan yang sudah ada di Database.
                                                            </p>
                                                            <p> <strong>Info !</strong> Silahkan Periksa Dahulu Datanya apakah benar sudah ada diD
                                                                dalam Database atau belum.</p>
                                                            <p> <strong>Info !</strong> PASTIKAN DATA YANG ANDA INPUT BENAR TIDAK ADA SEBELUM NYA !!
                                                                Jika anda yakin belum ada, silahkan anda lanjut dengan cara klik tombol LANJUT
                                                                SIMPAN.</p>
                                                        </div>
                                                        <!-- tabel------------>


                                                        <div class="table-responsive">
                                                            <table class="display table table-striped table-bordered" id="table-id" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <font size="1">No. MR</font>
                                                                        </th>
                                                                        <th>
                                                                            <font size="1">Nama Pasien</font>
                                                                        </th>
                                                                        <th>
                                                                            <font size="1">Alamat Pasien</font>
                                                                        </th>
                                                                        <th>
                                                                            <font size="1">Tgl Lahir</font>
                                                                        </th>
                                                                        <th>
                                                                            <font size="1">Nama Ibu / Phone </font>
                                                                        </th>
                                                                        <th>
                                                                            <font size="1">ID. Card Number </font>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="user_data">
                                                                </tbody>

                                                            </table>
                                                        </div>

                                                    </div><br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="simapnMRx" name="simapnMRx">
                                                <span class="glyphicon glyphicon-save"></span> LANJUT SIMPAN
                                            </button>
                                            <a data-dismiss="modal" class="btn btn-success" href="#" id="CloseMeC" name="CloseMeC">Close</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal CARI MR-->
                            <!-- Modal Untuk Notif Resep ------------------------------------------------>
                            <div class="modal fade" id="Notif_awal_registrasi" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

                                <div class="modal-dialog modal-md">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"> Silahkan Pilih Jenis Pasien </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <p class="text-center"><strong>Pasien Umum</strong></p><br>

                                                    <img src="<?= BASEURL; ?>/images/jenis_reg/LogoPasienUmum.Png" id="logopasienumum" class="img-circle person" alt="Random Name" width="150" height="150">


                                                </div>

                                                <div class="col-sm-4">
                                                    <p class="text-center"><strong>Pasien BPJS</strong></p><br>
                                                    <img src="<?= BASEURL; ?>/images/jenis_reg/LogoBPJS.png" id="logopasienbpjs" data-toggle="modal" class="img-circle person" alt="Random Name" width="150" height="150">
                                                </div>

                                                <div class="col-sm-4">
                                                    <p class="text-center"><strong>Pasien ADMEDIKA</strong></p><br>
                                                    <img src="<?= BASEURL; ?>/images/jenis_reg/ADMEDIKA.png" id="logopasienadmedika" class="img-circle person" alt="Random Name" width="150" height="150">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <p class="text-center"><strong>Pasien Karyawan</strong></p><br>

                                                    <img src="<?= BASEURL; ?>/images/jenis_reg/employes.png" id="pasienkaryawan" class="img-circle person" alt="Random Name" width="150" height="150">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--#END Modal Untuk Notif Resep---------------------------->
                            <!-- Modal Daftar Pasien Ranap-->
                            <div class="modal fade" id="modal_regist_ranap" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog  modal-lg">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" id="close">&times;</button>
                                            <h4 class="modal-title">Pendaftaran Pasien Rawat Inap</h4>
                                        </div>
                                        <form id="frmSimpanTrsRegistrasiRanap">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <form class="form-horizontal" id="frmSimpanTrsRegistrasiRanap">
                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Daftar</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" name="PasienJenisDaftar" id="PasienJenisDaftar" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> ID SPR </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                                            </div>
                                                            <label for=" inputEmail3" class="col-sm-2 control-label"> No MR </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" name="NoMR" id="NoMR" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="NamaPasien" name="NamaPasien" readonly>
                                                            </div>
                                                            <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="DOB" name="DOB" readonly>
                                                            </div>
                                                        </div>
                                                    
                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> NIK </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="NikPasien" name="NikPasien" readonly>
                                                            </div>
                                                            <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat </label>
                                                            <div class="col-sm-4">
                                                                <textarea rows="2" class="form-control" id="AlamatPasien" name="AlamatPasien" style="resize: none" readonly></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> No Reg RI </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="NoREGRI" name="NoREGRI" value="<?= $data['id'] ?>" readonly>
                                                            </div>
                                                            <label for=" inputEmail3" class="col-sm-2 control-label"> No Episode </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="NoEpisode" name="NoEpisode" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group gut" style="display: none;">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> No Reg RWJ </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="NoRegistrasi" name="NoRegistrasi" readonly>
                                                            </div>
                                                            <label for=" inputEmail3" class="col-sm-2 control-label"> No Episode RWJ</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="NoEpisodeRWJ" name="NoEpisodeRWJ" readonly>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Penjamin<sup class="color-danger">*</sup></label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control js-example-basic-single" id="TipePenjamin" name="TipePenjamin">
                                                                </select>
                                                            </div>

                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Cat. Ranap<sup class="color-danger">*</sup></label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control js-example-basic-single" id="JenisRawat" name="JenisRawat">
                                                                    <option value="">-- PILIH --</option>
                                                                    <option value="KEPERAWATAN UMUM DEWASA">KEPERAWATAN UMUM DEWASA</option>
                                                                    <option value="KEPERAWATAN KEBIDANAN">KEPERAWATAN KEBIDANAN</option>
                                                                    <option value="KEPERAWATAN ANAK">KEPERAWATAN ANAK</option>
                                                                    <option value="KEPERAWATAN PERINATOLOGI">KEPERAWATAN PERINATOLOGI</option>
                                                                    <option value="KEPERAWATAN ICU">KEPERAWATAN ICU</option>
                                                                    <option value="KEPERAWATAN HCU">KEPERAWATAN HCU</option>
                                                                    <option value="KEPERAWATAN PICU">KEPERAWATAN PICU</option>
                                                                    <option value="KEPERAWATAN NICU">KEPERAWATAN NICU</option>
                                                                    <option value="KEPERAWATAN NEONATUS">KEPERAWATAN NEONATUS</option>
                                                                    <option value="KAMAR OPERASI">KAMAR OPERASI</option>
                                                                    <option value="CARHLAB">CARHLAB</option>
                                                                    <option value="ENDOSCOPY">ENDOSCOPY</option>
                                                                    <option value="RADIOLOGY">RADIOLOGY</option>
                                                                    <option value="IGD">IGD</option>
                                                                    <option value="RUANG VK">RUANG VK</option>
                                                                    <option value="KEPERAWATAN ODC">KEPERAWATAN ODC</option>
                                                                    <option value="INSTALASI REHABILITASI MEDIK">INSTALASI REHABILITASI MEDIK</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Nama Penjamin<sup class="color-danger">*</sup></label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control js-example-basic-single" id="NamaPenjamin" name="NamaPenjamin" onchange="getidnamajaminan(this);">
                                                                </select>
                                                                <input type="text" class="form-control" id="NamaPenjaminTemp" name="NamaPenjaminTemp" readonly>
                                                            </div>

                                                            <label for="inputEmail3" class="col-sm-2 control-label"> No. SEP<sup class="color-danger">*</sup></label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="NoSEP" name="NoSEP" readonly>
                                                            </div>

                                                        </div>

                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Cara Masuk<sup class="color-danger">*</sup></label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control js-example-basic-single" id="caramasuk" name="caramasuk">
                                                                </select>
                                                            </div>


                                                            <label for="inputEmail3" class="col-sm-2 control-label"> DPJP<sup class="color-danger">*</sup></label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control js-example-basic-single" id="NamaDokter" name="NamaDokter">
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Nama Referal</label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control js-example-basic-single" id="referral" name="referral">
                                                                </select>
                                                            </div>

                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Kelas<sup class="color-danger">*</sup></label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control js-example-basic-single" id="Kelas" name="Kelas">
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Paket<sup class="color-danger">*</sup></label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control js-example-basic-single" id="Paket" name="Paket">
                                                                    <option value="">-- PILIH -- </option>
                                                                    <option value="1">Ya</option>
                                                                    <option value="0">Tidak</option>
                                                                </select>
                                                            </div>
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Note registrasi<sup class="color-danger">*</sup></label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control input-sm " id="pxNoteRegistrasi" name="pxNoteRegistrasi" type="text" placeholder="Masukan Note Registrasi">
                                                            </div>
                                                        </div>

                                                        <div class="form-group gut">
                                                            <label for="inputEmail3" class="col-sm-2 control-label"> Nama COB </label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control input-sm " name="COB" id="COB">
                                                                </select>
                                                            </div>

                                                        </div>


                                                    </form>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-success  btn-rounded " id="btnprint" name="btnprint">
                                                            PRINT/ORDER PENUNJANG</button>
                                                        <button class="btn btn-warning  btn-rounded " id="btnSepCeki" name="btnSepCeki" href="#modal_BPJSCekPesertaa" data-toggle='modal'> SEP</button>
                                                        <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'> Simpan</button>
                                                        <!--
                                  <button class="btn btn-danger  btn-rounded " id="batal" name="batal" href="#modal_alert_batal" data-toggle='modal'>
                                      Batal</button>-->
                                                        <button class="btn btn-danger  btn-rounded " onclick="Passingbatal()" id="batal" name="batal" href="#modal_alert_batal" data-toggle='modal'>
                                                            Batal</button>
                                                        <button class="btn btn-secondary  btn-rounded " id="close" name="close">
                                                            Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- /.col-md-12 -->

                                    <!-- Modal Daftar Pasien-->

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
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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
<script src="<?= BASEURL; ?>/js/App/registration/list/listRegistrasiMRbayi.js"></script>