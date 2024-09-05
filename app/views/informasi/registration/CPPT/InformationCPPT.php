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
                                        <input type="date" class="form-control" onfocusout="TrigerTgl()" name="PeriodeAwal" id="PeriodeAwal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">S/d</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" onfocusout="TrigerTgl()" name="PeriodeAkhir" id="PeriodeAkhir">
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Pasien</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="Noregistrasi" name="Noregistrasi">
                                        </select>
                                    </div>

                                    <div class="col-sm-1">
                                    </div>

                                    <a type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadInformation" name="btnLoadInformation"><span class="visible-content">Load</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>

                                    <button type="button" class="btn btn-success btn-animated btn-wide" id="excelLanscape" name="excelLanscape"><span class="visible-content" class="btn btn-primary">Excel<span class="hidden-content"></span></button>
                                </div>
                            </form>

                            <hr>
                            <!-- <div class="table-responsive" style="margin-top: 70px;">
                                <table id="datatable" class="display" width="100%"> -->
                            <div class="demo-table" style="overflow-x:auto;">
                                <table id="datatable" class="display" width="100%">

                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size='1'>No</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'> Tanggal</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>No. MR</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>Nama Pasien</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>No. Registrasi</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>Tanggal Lahir</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>Tgl Masuk</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>S (Anamnesa)</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>S (RPD)</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>O (TTV)</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>O (Pemeriksaan Fisik)</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>A</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>P (Rencatan Tata Laksana)</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>P (Instruksi Non Medis)</font>
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
<script src="<?= BASEURL; ?>/js/App/informasi/registration/CPPT/Information_CPPT_V01.js"></script>