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
        font-size: 10px;
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
                            <div class="form-group">
                                <form class="form-horizontal" id="form_cuti">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAwal" id="PeriodeAwal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">S/d</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAkhir" id="PeriodeAkhir">
                                    </div>
                                </form>
                                <button type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadInformation" name="btnLoadInformation"><span class="visible-content">Load</span><span class="hidden-content"><i class="fa fa-gear"></i></span></button>

                                <button type="button" class="btn btn-success btn-animated btn-wide" id="excelLanscape" name="excelLanscape"><span class="visible-content" class="btn btn-primary">Excel<span class="hidden-content"></span></button>
                            </div>
                            <hr>
                            <div class="panel-body">
                                <div class="demo-table" style="overflow-x:auto;margin-top: 70px;">
                                    <table id="loaddata" class="display" width="100%">
                                        <!-- <div class="table-responsive" style="margin-top: 70px;">
                                <table id="loaddata" class="display" width="100%"> -->
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">No. MR
                                                </th>
                                                <th align='center'>
                                                    <font size="1">No. Registrasi
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama Pasien
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Type Patient
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Alamat
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama Perusahaan
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Jenis Reg
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama Ruang Awal
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama Ruang Akhir
                                                </th>

                                                <th align='center'>
                                                    <font size="1">Kelas Perawatan Awal
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Kelas Perawatan Akhir
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Tgl Masuk
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Tgl Keluar
                                                </th>
                                                <th align='center'>
                                                    <font size="1">LOS
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Tgl Lahir
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Umur Tahun
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Umur Hari
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Berat Akhir
                                                </th>

                                                <th align='center'>
                                                    <font size="1">Jenis Kelamin
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Status Keluar
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Diagnosa EMR Dokter
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Diagnosa Utama
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Diagnosa Procedure
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Dokter DPJP
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Billing
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
<script src="<?= BASEURL; ?>/js/App/informasi/registration/RekapPasien/Information_RekapPasien_V01.js"></script>