<?php
date_default_timezone_set('Asia/Jakarta');
$id = "";
$datenowcreate = date("Y-m-d");
$datetimenow2222 = date("Y-m-d\TH:i:s");

?>
<style>
    table {
        border: 2px solid #6C6A61;
        border-collapse: collapse;
        font-size: 10px;
    }

    th,
    td {
        border: 1px solid #bbb;
        padding: 2px 8px 0;
        font-size: 10px;
    }

    thead>tr>th {
        background-color: #C0C0C0;
        border-bottom: 2px solid #999;
        font-size: 12px;
    }
</style>
<div class="main-page">
    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi </small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form3">
                                <div class="form-group gut">
                                    <h5 class="underline mt-30"></h5>
                                    <div class="panel-heading">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Ruangan: </label>
                                        <div class="col-sm-5">
                                            <input type="Text" class="form-control" id="Ruangan" name="Ruangan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Tanggal:</label>
                                        <div class="col-sm-5">
                                            <input type="date" class="form-control" id="Tanggal" name="Tanggal">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Jadwal Shift:</label>
                                        <div class="col-sm-5">
                                            <select class="form-control" id="Jadwal_Shift" name="Jadwal_Shift">
                                                <option VALUE="">--pilih--</option>
                                                <option VALUE="Pagi">Pagi</option>
                                                <option VALUE="Sore">Sore</option>
                                                <option VALUE="Malam">Malam</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <h5 class="underline mt-30">Situation</h5>
                                                <div class="panel-heading">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> Hari Rawat Ke: </label>
                                                    <div class="col-sm-5">
                                                        <input type="Text" class="form-control" id="Hari_Rawat_Ke" name="Hari_Rawat_Ke">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> DPJP: </label>
                                                    <div class="col-sm-5">
                                                        <input type="Text" class="form-control" id="DPJP" name="DPJP">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Rawat Bersama: </label>
                                                    <div class="col-sm-5">
                                                        <input type="Text" class="form-control" id="Dokter_Rawat_Bersama" name="Dokter_Rawat_Bersama">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa Medis: </label>
                                                    <div class="col-sm-5">
                                                        <input type="Text" class="form-control" id="Diagnosa_Medis" name="Diagnosa_Medis">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> Masalah utama saat ini yang menjadi perhatian (apa dan mulai kapan): </label>
                                                    <div class="col-sm-5">
                                                        <input type="Text" class="form-control" id="Masalah_utama_saat_ini_yang_menjadi_perhatian" name="Masalah_utama_saat_ini_yang_menjadi_perhatian">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> Obat-obatan Terkini: </label>
                                                    <div class="col-sm-5">
                                                        <input type="Text" class="form-control" id="Obat_Terkini" name="Obat_Terkini">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="form-group ">
                                                        <h5 class="underline mt-30">Background</h5>
                                                        <div class="panel-heading">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Kesadaran:</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control" id="Kesadaran" name="Kesadaran">
                                                                <option VALUE="">--pilih--</option>
                                                                <option VALUE="Compos Mentisa">Compos Mentisa</option>
                                                                <option VALUE="Apatis">Apatis</option>
                                                                <option VALUE="Somnolen">Somnolen</option>
                                                                <option VALUE="Sopor Koma">Sopor Koma</option>
                                                                <option VALUE="koma">koma</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> GCS:E </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="GCS_E" name="GCS_E">
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> V: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="V" name="V">
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> M: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="M" name="M">
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Total: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="Total" name="Total">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Tingkat Ketergantungan Pasien:</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control" id="Tingkat_Ketergantungan_Pasien" name="Tingkat_Ketergantungan_Pasien">
                                                                <option VALUE="">--pilih--</option>
                                                                <option VALUE="Mandiri">Mandiri</option>
                                                                <option VALUE="Partial Care">Partial Care</option>
                                                                <option VALUE="Total Care">Total Care</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> TTV:TD: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="TTV_TD" name="TTV_TD">
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Nadi: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="Nadi" name="Nadi">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Suhu: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="Suhu" name="Suhu">
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> RR: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="RR" name="RR">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Saturasi O2: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="Saturasi_O2" name="Saturasi_O2">
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Score EWS: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="Score_EWS" name="Score_EWS">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Score Jatuh: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="Score_Jatuh" name="Score_Jatuh">
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Skala Nyeri: </label>
                                                        <div class="col-sm-1">
                                                            <input type="Text" class="form-control" id="Skala_Nyeri" name="Skala_Nyeri">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Penggunaan Restrain:</label>
                                                        <div class="col-sm-5">
                                                            <select class="form-control" id="Penggunaan_Restrain" name="Penggunaan_Restrain">
                                                                <option VALUE="">--pilih--</option>
                                                                <option VALUE="YA">YA</option>
                                                                <option VALUE="TIDAK">TIDAK</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> NGT:</label>
                                                        <div class="col-sm-1">
                                                            <select class="form-control" id="NGT" name="NGT">
                                                                <option VALUE="">--pilih--</option>
                                                                <option VALUE="YA">YA</option>
                                                                <option VALUE="TIDAK">TIDAK</option>
                                                            </select>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> TGL Pasang: </label>
                                                        <div class="col-sm-2">
                                                            <input type="date" class="form-control" id="TGL_Pasang" name="TGL_Pasang">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Folley Catheter:</label>
                                                        <div class="col-sm-1">
                                                            <select class="form-control" id="Folley_Catheter" name="Folley_Catheter">
                                                                <option VALUE="">--pilih--</option>
                                                                <option VALUE="YA">YA</option>
                                                                <option VALUE="TIDAK">TIDAK</option>
                                                            </select>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> TGL Pasang: </label>
                                                        <div class="col-sm-2">
                                                            <input type="date" class="form-control" id="TGL_Psng" name="TGL_Psng">
                                                        </div>
                                                    </div>
                                                    <a type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadfHandoverPerawat" name="btnLoadfHandoverPerawat"><span class="visible-content">Submit</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                <!-- ========== COMMON JS FILES ========== -->
                <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
                <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
                <script src="<?= BASEURL; ?>/js/App/Informasi/formulir/HandOverPerawat.js"></script>

                <script>
                    $(".preloader").fadeOut();
                </script>