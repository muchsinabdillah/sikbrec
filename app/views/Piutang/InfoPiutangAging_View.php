<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
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

    /* .border-ranap {
    border-left-color: #1E90FF;
    border-left-style: groove;
    border-left-width: 7px;
}

.border-rajal {
    border-left-color: #B22222;
    border-left-style: groove;
    border-left-width: 7px;
}

.border-walkin {
    border-left-color: #808080;
    border-left-style: groove;
    border-left-width: 7px;
}

.border-bebas {
    border-left-color: teal;
    border-left-style: groove;
    border-left-width: 7px;
}

.cover {
    transform: translateY(-100%);
} */


    /* input transparant */
    input {
        /* width: 300px; */
        padding: 10px 20px;
        border-color: transparent;
        border-bottom: 5px solid darkgrey;
        font-size: 15px;
        background: transparent;
    }

    input:focus {
        outline: none;
    }

    input::-webkit-input-placeholder {
        padding-left: 5px;
        font-size: 15px;
        color: #3c3c3c;
    }

    input:-moz-placeholder {
        /* Firefox 18- */
        padding-left: 5px;
        font-size: 15px;
        color: #3c3c3c;
    }

    input::-moz-placeholder {
        /* Firefox 19+ */
        padding-left: 5px;
        font-size: 15px;
        color: #3c3c3c;
    }

    input:-ms-input-placeholder {
        padding-left: 5px;
        font-size: 15px;
        color: #3c3c3c;
    }
</style>
<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline"><?= $data['judul'] ?>
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmInfoFaktur">
                                <!-- Update -->
                                <div class="col-md-12">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <header class="w3-container w3-indigo" style="padding:5px">
                                                <span class="glyphicon glyphicon-envelope"></span> Silahkan Masukan Periode Piutang Aging Anda.
                                            </header>

                                        </div>
                                        <div class="panel-body">
                                            <div class="alert alert-info" role="alert"> 
                                                <strong>Informasi !</strong> Data periode Piutang di tampilkan adalah Data Piutang yang telah di buatkan Invoie Penagihan, bukan berdasarkan tanggal pasien pulang.
                                                Ketentuan ini sudah di sepakati bersama dengan Keuangan terkait Pengakuan Piutang berdasarkan Tanggal Invoice dikirim.
                                            </div> 
                                            <div class="form-group gut">
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Periode
                                                </label>
                                                <div class="col-sm-2">
                                                    <input type="date" name="PeriodeAwal" id="PeriodeAwal" style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Sd/
                                                </label>
                                                <div class="col-sm-2">
                                                    <input type="date" name="PeriodeAkhir" id="PeriodeAkhir" style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                            </div>

                                            <label for="inputEmail3" class="col-sm-10 control-label"></label>

                                            <a type="button" class="btn btn-success btn-animated btn-wide" id="LoadData" name="LoadData"><span class="visible-content">Load</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>
                                            <button type="button" class="btn btn-success btn-animated btn-wide" id="excelLanscape" name="excelLanscape"><span class="visible-content" class="btn btn-primary">Excel<span class="hidden-content"></span></button>
                                            <hr>
                                            <div class="panel panel-danger">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h5><i class="glyphicon glyphicon-tasks" aria-hidden="true"></i> List Data
                                                            Informasi</h5>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="demo-table" style="overflow-x:auto;">
                                                        <table id="table-load-data" class="display" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <!-- <th align='center'>
                                                                        <font size="1">NO.
                                                                    </th> -->
                                                                    <th align='center'>
                                                                        <font size="1">Nama Jaminan
                                                                    </th>
                                                                    <th align='center'>
                                                                        <font size="1">0-45
                                                                    </th>
                                                                    <th align='center'>
                                                                        <font size="1">45-60
                                                                    </th>
                                                                    <th align='center'>
                                                                        <font size="1">60-90
                                                                    </th>
                                                                    <th align='center'>
                                                                        <font size="1">90-120
                                                                    </th> 
                                                                    <th align='center'>
                                                                        <font size="1">>120
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <!-- <th></th> -->
                                                                    <th>Total Saldo :</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th> 

                                                                </tr>
                                                            </tfoot>
                                                        </table>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>




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
<script src="<?= BASEURL; ?>/js/App/Informasi/Piutang/InfoPiutangAging.js"></script>