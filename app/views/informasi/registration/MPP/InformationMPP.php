<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
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
                                <h5><?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAwal" id="PeriodeAwal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">S/d</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAkhir" id="PeriodeAkhir">
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Form</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="JenisForm"
                                            name="JenisForm">
                                            <option value="">-- PILIH --</option>
                                            <option value="Form_A">FORM A</option>
                                            <option value="Form_B">FORM B</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-1">
                                    </div>

                                    <a type="button" class="btn btn-success btn-animated btn-wide"
                                        id="btnLoadInformation" name="btnLoadInformation"><span
                                            class="visible-content">Load</span><span class="hidden-content"><i
                                                class="fa fa-gear"></i></span></a>
                                </div>
                            </form>

                            <hr>
                            <!-- <div class="table-responsive">
                                <table id="datatable" class="display" width="100%"  style="display: none"> -->
                            <div class="panel-body">
                                <div class="demo-table" style="overflow-x:auto;">
                                    <table id="datatable" class="display" width="100%" style="display: none">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>NoEpisode</th>
                                                <th align='center'>NamaPasien</th>
                                                <th align='center'>NoRegistrasi</th>
                                                <th align='center'>NoMR</th>
                                                <th align='center'>Tgl_Lahir</th>
                                                <th align='center'>Umur</th>
                                                <th align='center'>JenisKelamin</th>
                                                <th align='center'>RuangPerawatan</th>
                                                <th align='center'>Identf_Resiko_Tinggi</th>
                                                <th align='center'>IdentfPotensi_Komplen_Tinggi</th>
                                                <th align='center'>IdentfPotensi_Peny_Kronis</th>
                                                <th align='center'>IdentfPotensi_Renc_plg_Komplex</th>
                                                <th align='center'>IdentfPotensi_Membutuhkan_Kontinu</th>
                                                <th align='center'>IdentfPotensi_kasus_rawat_lama</th>
                                                <th align='center'>IdentfPotensi_biaya_tinggi</th>
                                                <th align='center'>IdentfPotensi_Perkiraan_maslh_Financial</th>
                                                <th align='center'>IdentfPotensi_Kasus_rumit</th>
                                                <th align='center'>IdentfPotensi_Riwayat_Gangguan_Mental</th>
                                                <th align='center'>IdentfPotensi_Bunuh_diri</th>
                                                <th align='center'>IdentfPotensi_terlantar</th>
                                                <th align='center'>IdentfPotensi_tinggalSendiri</th>
                                                <th align='center'>IdentfPotensi_narkoba</th>
                                                <th align='center'>Asesment_Riwayat_Saatini</th>
                                                <th align='center'>Riwayat_Kesehatan</th>
                                                <th align='center'>Psiko_spiritual_sosial</th>
                                                <th align='center'>Dukungan_Kel</th>
                                                <th align='center'>Pemahaman_Kesehatan</th>
                                                <th align='center'>Financial</th>
                                                <th align='center'>DPJP_Utama</th>
                                                <th align='center'>DPJP_Raber</th>
                                                <th align='center'>Diagnosis_Medis</th>
                                                <th align='center'>Identifikasi_Masalah</th>
                                                <th align='center'>Perencanaan_Pelayanan</th>
                                                <th align='center'>Case_Manager</th>
                                                <th align='center'>Hipertensi</th>
                                                <th align='center'>Hipertensi_ket</th>
                                                <th align='center'>Jantung</th>
                                                <th align='center'>Jantung_ket</th>
                                                <th align='center'>DM</th>
                                                <th align='center'>DM_ket</th>
                                                <th align='center'>PPOK</th>
                                                <th align='center'>PPOK_ket</th>
                                                <th align='center'>Kanker</th>
                                                <th align='center'>Kanker_ket</th>
                                                <th align='center'>Lain_lain</th>
                                                <th align='center'>Lain_lain_ket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <table id="datatable2" class="display" width="100%" style="display: none">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>NoEpisode</th>
                                                <th align='center'>NamaPasien</th>
                                                <th align='center'>NoRegistrasi</th>
                                                <th align='center'>NoMR</th>
                                                <th align='center'>Tgl_Lahir</th>
                                                <th align='center'>Umur</th>
                                                <th align='center'>JenisKelamin</th>
                                                <th align='center'>RuangPerawatan</th>
                                                <th align='center'>Penjamin</th>
                                                <th align='center'>HasilPelayanan</th>
                                                <th align='center'>Terminasi</th>
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
                    <button type="button" class="btn btn-success btn-labeled">Purchase Now<span
                            class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
<script src="<?= BASEURL; ?>/js/App/informasi/registration/MPP/Information_MPP_V01.js"></script>