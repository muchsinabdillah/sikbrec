<?php
date_default_timezone_set('Asia/Jakarta');
$id = "";
$datenowcreate = date("Y-m-d");
$datetimenow2222 = date("Y-m-d\TH:i:s");

?>
<style type="text/css">
    .signature-area {
        width: 304px;
        margin: 50px auto;
        border: 1px solid black;
    }

    .signature-container {
        width: 60%;
        margin: auto;
    }

    .signature-list {
        width: 150px;
        height: 50px;
        border: solid 1px #cfcfcf;
        margin: 10px 5px;
    }

    .title-area {
        font-family: cursive;
        font-style: oblique;
        font-size: 12px;
        text-align: left;
    }

    .btn-save {
        color: #fff;
        background: #1c84c6;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
        border: 1px solid transparent;
    }

    .btn-clear {
        color: #fff;
        background: #f7a54a;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
        border: 1px solid transparent;
    }
</style>

<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Formulir Edukasi Pasien</p>
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
                                <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus
                                        diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- <form class="form-horizontal" id="formdata"> -->
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data" id="formdata">
                                <h5>Data Pasien</h5>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NamaPasien" id="NamaPasien" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Berobat
                                    </label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="date" id="Tanggal" name="Tanggal" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. MR
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NoMR" id="NoMR" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir </label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="Tgl_Lahir" id="Tgl_Lahir" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Registrasi </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NoRegistrasi" id="NoRegistrasi" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik Tujuan
                                    </label>
                                    <div class="col-sm-3">
                                        <!-- <<<<<<< HEAD -->
                                        <input type="text" class="form-control" name="PoliTujuan" id="PoliTujuan" readonly>
                                        <input type="hidden" class="form-control" name="IdRegistrasi" id="IdRegistrasi" value="<?= $data['noregistrasi'] ?>" readonly>
                                        <!-- >>>>>>> origin/badrul_inventory -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Episode </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NoEpisode" id="NoEpisode" readonly>
                                    </div>
                                </div>
                                <!-- </form>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form1"> -->
                                <h5>A. Asessment Kebutuhan Edukasi</h5>
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h5>Data Pasien</h5>
                                    </div>
                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-2">1. Tinggal Bersama :
                                            </h6>
                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="TinggalBersama">
                                                        <input class="form-check-input" type="radio" id="TinggalBersama" name="TinggalBersama" value="Anak"> Anak</label>

                                                    <label class="form-check-label" for="TinggalBersama">
                                                        <input class="form-check-input" type="radio" id="TinggalBersama" name="TinggalBersama" value="Orang tua"> Orang tua</label>
                                                </div>
                                            </div>
                                            <div class="form-group gut">
                                                <div class="col-sm-2">
                                                    <div id="checkboxes">
                                                        </br>
                                                        <label class="form-check-label" for="TinggalBersama">
                                                            <input class="form-check-input" type="radio" id="TinggalBersama" name="TinggalBersama" value="Sendiri">Sendiri</label>

                                                        <label class="form-check-label" for="TinggalBersama">
                                                            <input class="form-check-input" type="radio" id="TinggalBersama" name="TinggalBersama" value="Suami/Istri*">Suami/Istri*</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-2">2. Bahasa :
                                            </h6>
                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <input class="form-check-input" type="radio" id="Bahasa" name="Bahasa" value="Indonesia">Indonesia</label>

                                                    <label class="form-check-label" for="Bahasa">
                                                        <input class="form-check-input" type="radio" id="Bahasa" name="Bahasa" value="Mandarin">Mandarin</label>
                                                </div>
                                            </div>
                                            <div class="form-group gut">
                                                <div class="col-sm-2">
                                                    <div id="checkboxes">
                                                        </br>
                                                        <label class="form-check-label" for="Bahasa">
                                                            <input class="form-check-input" type="radio" id="Bahasa" name="Bahasa" value="English">English</label>

                                                        <label class="form-check-label" for="Bahasa">
                                                            <input class="form-check-input" type="radio" id="Bahasa" name="Bahasa" value="DLL*">DLL*</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-2">3. Hambatan :
                                            </h6>
                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="Hambatan1">
                                                        <input class="form-check-input" type="checkbox" id="Hambatan1" name="Hambatan" value="tidak ada">tidak ada</label>

                                                    <label class="form-check-label" for="Hambatan2">
                                                        <input class="form-check-input" type="checkbox" id="Hambatan2" name="Hambatan" value="Gangguan Pendengaran">Gangguan Pendengaran</label>

                                                    <label class="form-check-label" for="Hambatan3">
                                                        <input class="form-check-input" type="checkbox" id="Hambatan3" name="Hambatan" value="Secara Fisiologis Tidak Mampu Belajar">Secara Fisiologis Tidak Mampu Belajar</label>
                                                </div>
                                            </div>
                                            <div class="form-group gut">
                                                <div class="col-sm-2">
                                                    <div id="checkboxes">
                                                        </br>
                                                        <label class="form-check-label" for="Hambatan4">
                                                            <input class="form-check-input" type="checkbox" id="Hambatan4" name="Hambatan" value="Gangguan Emosi">Gangguan Emosi</label>

                                                        <label class="form-check-label" for="Hambatan5">
                                                            <input class="form-check-input" type="checkbox" id="Hambatan5" name="Hambatan" value="Gangguan Bicara">Gangguan Bicara</label>

                                                        <label class="form-check-label" for="Hambatan6">
                                                            <input class="form-check-input" type="checkbox" id="Hambatan6" name="Hambatan" value="Perokok Aktif/Pasif*">Perokok Aktif/Pasif*</label>
                                                    </div>
                                                </div>
                                                <div class="form-group gut">
                                                    <div class="col-sm-2">
                                                        <div id="checkboxes">
                                                            </br>
                                                            <label class="form-check-label" for="Hambatan7">
                                                                <input class="form-check-input" type="checkbox" id="Hambatan7" name="Hambatan" value="Motivasi Kurang/Buruk">Motivasi Kurang/Buruk</label>

                                                            <label class="form-check-label" for="Hambatan8">
                                                                <input class="form-check-input" type="checkbox" id="Hambatan8" name="Hambatan" value="Memori Hilang">Memori Hilang</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group gut">
                                                        <div class="col-sm-1">
                                                            <div id="checkboxes">
                                                                </br>
                                                                <label class="form-check-label" for="Hambatan9">
                                                                    <input class="form-check-input" type="checkbox" id="Hambatan9" name="Hambatan" value="Fisik Lemah">Fisik Lemah</label>

                                                                <label class="form-check-label" for="Hambatan10">
                                                                    <input class="form-check-input" type="checkbox" id="Hambatan10" name="Hambatan" value="Alkoholik">Alkoholik</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <div class="col-sm-12">
                                                    <h6 class="col-sm-2">4. Kemampuan Sholat :
                                                    </h6>
                                                    <div class="col-sm-2">
                                                        <div id="checkboxes">
                                                            </br>
                                                            <label class="form-check-label" for="KemampuanSolat">
                                                                <input class="form-check-input" type="radio" id="KemampuanSolat" name="KemampuanSolat" value="Berdiri">Berdiri</label>

                                                            <label class="form-check-label" for="KemampuanSolat">
                                                                <input class="form-check-input" type="radio" id="KemampuanSolat" name="KemampuanSolat" value="Duduk">Duduk</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group gut">
                                                        <div class="col-sm-2">
                                                            <div id="checkboxes">
                                                                </br>
                                                                <label class="form-check-label" for="KemampuanSolat">
                                                                    <input class="form-check-input" type="radio" id="KemampuanSolat" name="KemampuanSolat" value="Berbaring">Berbaring</label>

                                                                <label class="form-check-label" for="KemampuanSolat">
                                                                    <input class="form-check-input" type="radio" id="KemampuanSolat" name="KemampuanSolat" value="Anggukan Kepala*">Anggukan Kepala*</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group gut">
                                                            <div class="col-sm-2">
                                                                <div id="checkboxes">
                                                                    </br>
                                                                    <label class="form-check-label" for="KemampuanSolat">
                                                                        <input class="form-check-input" type="radio" id="KemampuanSolat" name="KemampuanSolat" value="Isyarat Lainya">Isyarat Lainya</label>

                                                                    <label class="form-check-label" for="KemampuanSolat">
                                                                        <input class="form-check-input" type="radio" id="KemampuanSolat" name="KemampuanSolat" value="Dengan Hati">Dengan Hati</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <div class="col-sm-12">
                                                    <h6 class="col-sm-3">5. Kemampuan Membaca Al-Qur'an :<sup class="color-danger">*</sup>
                                                    </h6>
                                                    <div class="col-sm-2">
                                                        <div id="checkboxes">
                                                            </br>
                                                            <label class="form-check-label" for="KemampuanMembacaAl_Quran">
                                                                <input class="form-check-input" type="radio" id="KemampuanMembacaAl_Quran" name="KemampuanMembacaAl_Quran" value="Mampu">Mampu</label>

                                                            <label class="form-check-label" for="KemampuanMembacaAl_Quran">
                                                                <input class="form-check-input" type="radio" id="KemampuanMembacaAl_Quran" name="KemampuanMembacaAl_Quran" value="Tidak Mampu">Tidak Mampu</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-3">6. Edukasi Diberikan Kepada :
                                            </h6>
                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="EdukasiDiberikanKepada">
                                                        <input class="form-check-input" type="radio" id="EdukasiDiberikanKepada" name="EdukasiDiberikanKepada" value="Pasien">Pasien</label>

                                                    <label class="form-check-label" for="EdukasiDiberikanKepada">
                                                        <input class="form-check-input" type="radio" id="EdukasiDiberikanKepada" name="EdukasiDiberikanKepada" value="Orang Tua (Ayah/Ibu**)">Orang Tua (Ayah/Ibu**)</label>
                                                </div>
                                            </div>
                                            <div class="form-group gut">
                                                <div class="col-sm-6">
                                                    <div id="checkboxes">
                                                        </br>
                                                        <label class="form-check-label" for="EdukasiDiberikanKepada">
                                                            <input class="form-check-input" type="radio" id="EdukasiDiberikanKepada" name="EdukasiDiberikanKepada" value="Keluarga(Suami,Istri,Kakak,Adik**)">Keluarga(Suami,Istri,Kakak,Adik**)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-2">7. Kemampuan Bahasa :
                                            </h6>
                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="KemampuanBahasa">
                                                        <input class="form-check-input" type="radio" id="KemampuanBahasa" name="KemampuanBahasa" value="Indonesia">Indonesia</label>

                                                    <label class="form-check-label" for="KemampuanBahasa">
                                                        <input class="form-check-input" type="radio" id="KemampuanBahasa" name="KemampuanBahasa" value="Daerah">Daerah</label>
                                                </div>
                                            </div>
                                            <div class="form-group gut">
                                                <div class="col-sm-2">
                                                    <div id="checkboxes">
                                                        </br>
                                                        <label class="form-check-label" for="KemampuanBahasa">
                                                            <input class="form-check-input" type="radio" id="KemampuanBahasa" name="KemampuanBahasa" value="Asing">Asing</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-3">8. Perlu Penerjemah : <sup class="color-danger">*</sup></h6>
                                            <div class="col-sm-4">
                                                </br>
                                                <select name="PerluPenerjemah" id="PerluPenerjemah" class="form-control" for="PerluPenerjemah">
                                                    <option value=""> Pilih </option>
                                                    <option value="Ya"> YA</option>
                                                    <option value="Tidak"> Tidak </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-3">9. Baca Dan Tulis : <sup class="color-danger">*</sup></h6>
                                            <div class="col-sm-4">
                                                </br>
                                                <select name="BacadanTulis" id="BacadanTulis" class="form-control" for="BacadanTulis">
                                                    <option readonly>--Pilih--</option>
                                                    <option value="Bisa"> Bisa </option>
                                                    <option value="Tidak"> Tidak </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-3">10. Kepercayaan Lainya : <sup class="color-danger">*</sup></h6>
                                            <div class="col-sm-4">
                                                </br>
                                                <select name="Kepercayaanlainya" id="Kepercayaanlainya" class="form-control" for="Kepercayaanlainya">
                                                    <option readonly>--Pilih--</option>
                                                    <option value="Ada"> Ada </option>
                                                    <option value="Tidak Ada"> Tidak Ada </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-3">11. Kesediaan Menerima Edukasi : <sup class="color-danger">*</sup></h6>
                                            <div class="col-sm-4">
                                                </br>
                                                <select name="KesediaanMenerimaEdukasi" id="KesediaanMenerimaEdukasi" class="form-control" for="KesediaanMenerimaEdukasi">
                                                    <option readonly>--Pilih--</option>
                                                    <option value="Ada"> Ada </option>
                                                    <option value="Tidak"> Tidak </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-3">12. Cara Edukasi : <sup class="color-danger">*</sup></h6>
                                            <div class="col-sm-4">
                                                </br>
                                                <select name="CaraEdukasi" id="CaraEdukasi" class="form-control" for="CaraEdukasi">
                                                    <option readonly>--Pilih--</option>
                                                    <option value="Lisan"> Lisan </option>
                                                    <option value="Tulisan"> Tulisan </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <div class="col-sm-12">
                                            <h6 class="col-sm-2">13. Kebutuhan Edukasi :
                                            </h6>
                                            <div class="col-sm-4">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Hak Untuk Berpartisipasi Pada Proses Pelayanan">Hak Untuk Berpartisipasi Pada Proses Pelayanan</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Proses Pemberian Inform Concent">Proses Pemberian Inform Concent</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Penggunaan Obat Secara Efektif & Aman Efek Samping Serta Interaksinya">Penggunaan Obat Secara Efektif & Aman Efek Samping Serta Interaksinya</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Kondisi Kesehatan,Diagnosis pasti dan Penatalaksaanya">Kondisi Kesehatan,Diagnosis pasti dan Penatalaksanaanya</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Lain-lain ...........">Lain-lain ...........</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Prosedur Pemerikasaan Penunjang">Prosedur Pemerikasaan Penunjang</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Diet Dan Nutrisi">Diet Dan Nutrisi</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Manejemen Nyeri">Manejemen Nyeri</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Penggunaan Alat Medis Yang Aman">Penggunaan Alat Medis Yang Aman</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Bahaya Merokok">Bahaya Merokok</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Teknik Rehabilitasi">Teknik Rehabilitasi</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="RujukanEdukasi">Rujukan Edukasi</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasi">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasi" name="KebutuhanEdukasi" value="Cuci Tangan Yang Benar">Cuci Tangan Yang Benar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group gut">
                                        <div class="col-sm-10">
                                            <h6 class="col-sm-3">14. Kebutuhan Edukasi Islami :
                                            </h6>
                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Fiqih Bersuci">Fiqih Bersuci</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Fiqih Sholat">Fiqih Sholat</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Quranic Healing">Quranic Healing
                                                    </label>

                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Lain-lain .....">Lain-lain .....</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Talqin">Talqin</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Kholwat/Ikhtilat">Kholwat/Ikhtilat</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Motivasi Spiritual">Motivasi Spiritual</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Doa & Dzikir">Doa & Dzikir</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Menjaga Aurat">Menjaga Aurat</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Fiqih Wanita">Fiqih Wanita</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div id="checkboxes">
                                                    </br>
                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Ruqyah Syar'iyyah">Ruqyah Syar'iyyah</label>

                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Sholat Tahajud">Sholat Tahajud
                                                    </label>

                                                    <label class="form-check-label" for="KebutuhanEdukasiIslami">
                                                        <input class="form-check-input" type="checkbox" id="KebutuhanEdukasiIslami" name="KebutuhanEdukasiIslami" value="Penggunaan Obat Secara Syariah">Penggunaan Obat Secara Syariah</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <h5>B. Pelaksanaan Edukasi</h5>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">TGL & Jam
                                        Edukasi:</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" id="TglJamEdukasi" name="TglJamEdukasi">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Materi Edukasi
                                            Berdasarkan Kebutuhan: </label>
                                        <div class="col-sm-3">
                                            <input type="Text" class="form-control" id="Materi_Edukasi_Berdasarkan_Kebutuhan" name="Materi_Edukasi_Berdasarkan_Kebutuhan">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Kode Leaflet:</label>
                                        <div class="col-sm-3">
                                            <input type="Text" class="form-control" id="Kode_Leaflet" name="Kode_Leaflet">
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Lama Edukasi
                                                (Menit):</label>
                                            <div class="col-sm-3">
                                                <input type="time" class="form-control" id="Lama_Edukasi" name="Lama_Edukasi">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Hasil
                                            Verifikasi:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="Hasil_Verifikasi" name="Hasil_Verifikasi">
                                                <option VALUE="">--pilih--</option>
                                                <option VALUE="Sudah Mengerti">Sudah Mengerti</option>
                                                <option VALUE="Re Edukasi">Re Edukasi</option>
                                                <option VALUE="Re Demonstrasi">Re Demonstrasi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">TGL REEDUKASI /
                                                REDEMONSTRASI:</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="Tgl_Reedukasi_Redemonstrasi" name="Tgl_Reedukasi_Redemonstrasi">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> PEMBERI EDUKASI:
                                        </label>
                                        <div class="col-sm-3">
                                            <input type="Text" class="form-control" id="Pemberi_Edukasi" name="Pemberi_Edukasi">
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> PASIEN KELUARGA(HUBUNGAN): </label>
                                            <div class="col-sm-3">
                                                <input type="Text" class="form-control" id="Pasien_keluarga_Hubungan" name="Pasien_keluarga_Hubungan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <div class="col-md-4">
                                        </br>
                                        <label for="inputPassword4">Pemberi Edukasi</label>
                                        <div class="rumahsakit">
                                            <div class="sig">
                                                <div class="typed"></div>
                                                <canvas class="" id="ttdrumahsakit" width="300" height="100"></canvas>
                                            </div>
                                        </div>
                                        <!-- <<<<<<< HEAD  -->
                                        <label for="inputPassword4">Pemberi Edukasi</label>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#saksirumahsakit">
                                            <!-- <> -->
                                            Input Tanda Tangan
                                        </button>
                                        <input type="hidden" name="saksi_rumah_sakit" id="saksi_rumah_sakit">
                                    </div>
                                    <br>
                                    <div class="col-md-4">
                                        <label for="inputPassword4">PASIEN KELUARGA(HUBUNGAN):</label>
                                        <div class="copysignature" id="pasienttd">
                                            <div class="sig">
                                                <div class="typed"></div>
                                                <canvas class="" id="gbrttdsaksipasien" width="300" height="100"></canvas>
                                            </div>
                                        </div>
                                        <!-- <<<<<<< HEAD  -->
                                        <label for="inputPassword4" id="namajelas">Nama Jelas</label>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#saksipasien">
                                            Input Tanda Tangan
                                        </button>
                                        <input type="hidden" name="saksi_pasiens" id="saksi_pasiens">
                                    </div>

                                </div>



                                <!-- <div class="btn-group" role="group">
                                            <div data-toggle="tooltip" data-placement="left" title="Klik Submit untuk menyimpan Formulir Pelaksanaan Edukasi"> [?]

                                                <button type="submit" id="tandatangan" name="tandatangan" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div> -->

                                <div class="form-group">
                                    <div class="row" style="margin-right:1em;float:right;">
                                        <a type="button" class="btn btn-success btn-animated btn-wide" id="btnSave" name="btnSave"><span class="visible-content">Simpan</span><span class="hidden-content"><i class="fa fa-cloud"></i></span></a>
                                        <a onclick="MyBack()" class="btn btn-warning waves-effect" id="btnBack" name="btnBack"><span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
                                            Back To Registrasi RAJAL</a>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="saksipasien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saksi Pasien</h5>
                <button id="ttdsaksirumahsakit" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Silahkan tanda tangan di dalam kotak
                <div class="signature-area" id="ttdsaksipasien">

                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-save" id="btn_sakspasiensig">Save</button>
                <button class="btn-clear" id="clearttdrumahsakit">Clear</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="saksirumahsakit" tabindex="-1" role="dialog" aria-labelledby="saksirumahsakit" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saksi Rumah sakit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Silahkan tanda tangan di dalam kotak
                <div class="signature-area">

                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-save" id="btn_saksirumahsakitsig">Save</button>
                <button class="btn-clear">Clear</button>

            </div>
        </div>
    </div>
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

                <!-- /.main-wrapper -->
                <!-- ========== COMMON JS FILES ========== -->
                <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
                <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
                <!-- <script>
                    $(".preloader").fadeOut();
                </script> -->
                <script>
                    let iduser = ` <?= $data['session']->username ?>`
                    let namauser = ` <?= $data['session']->name ?>`
                </script>
                <script>
                    $(document).ready(function() {
                        $(".btn-clear").click(function(e) {
                            $(".signature-area").signaturePad().clearCanvas();
                        });
                        $("#clearttdrumahsakit").click(function(e) {
                            $("#ttdsaksipasien").signaturePad().clearCanvas();
                            console.log('clear')
                        });
                        $(".signature-area").signaturePad({
                            penColour: '#000000',
                            drawOnly: true,
                            drawBezierCurves: true,
                            lineTop: 90,
                            lineWidth: 0,
                            validateFields: true,
                        })

                    });
                </script>
                <script src="<?= BASEURL; ?>/js/App/Informasi/formulir/Formulir.js"></script>
                <!-- <script src="<?= BASEURL; ?>/js/App/Informasi/formulir/Pelaksanaan.js"></script> -->
                <script src="<?= BASEURL; ?>/js/App/Formulir/signaturefmr.js"></script>

                <script>
                    $(".preloader").fadeOut();
                </script>