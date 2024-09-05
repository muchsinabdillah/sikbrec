<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>
<style type="text/css">
    body {
        font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
    }

    /* Table */
    table {
        margin: auto;
        font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
        font-size: 12px;

    }

    .demo-table {
        border-collapse: collapse;
        font-size: 13px;
    }

    .demo-table th,
    .demo-table td {
        border-bottom: 1px solid #ffd3d3;
        border-left: 1px solid #ffd3d3;
        padding: 7px 17px;
    }

    .demo-table th,
    .demo-table td:last-child {
        border-right: 1px solid #ffd3d3;
    }

    .demo-table td:first-child {
        border-top: 1px solid #ffd3d3;
    }

    .demo-table td:last-child {
        border-bottom: 0;
    }

    caption {
        caption-side: top;
        margin-bottom: 10px;
    }

    /* Table Header */
    .demo-table thead th {
        background-color: #990000;
        color: #FFFFFF;
        border-color: #c75c5c !important;
        text-transform: uppercase;
    }

    /* Table Body */
    .demo-table tbody td {
        color: #353535;
    }

    .demo-table tbody tr:nth-child(odd) td {
        background-color: #fff1f1;
    }

    .demo-table tbody tr:hover th,
    .demo-table tbody tr:hover td {
        background-color: #ffffa2;
        border-color: #ffff0f;
        transition: all .2s;
    }

    .demo-table tfoot th {
        background-color: #e06666;
        color: #FFFFFF;
        border-color: #c75c5c !important;
        text-transform: uppercase;
    }
</style>
<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Menampilkan Data <?= $data['judul'] ?>.</p>
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div>

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?> List
                                </h5>
                            </div>

                        </div>
                        <div class="panel-body">

                            <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                <li role="presentation" class="active"><a class="" href="#listorder" aria-controls="listorder" role="tab" data-toggle="tab">List Order</a>
                                </li>
                                <li role="presentation"><a class="" href="#listpemakaian" aria-controls="listpemakaian" role="tab" data-toggle="tab">List Pemakaian</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content bg-white p-15">

                                <div role="tabpanel" class="tab-pane active form-horizontal" id="listorder">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" name="PeriodeAwal" onfocusout="TrigerTgl()" id="PeriodeAwal">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label">S/d</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" name="PeriodeAkhir" onfocusout="TrigerTgl()" id="PeriodeAkhir">
                                        </div>
                                        <div class="col-sm-1">
                                            <a type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadInformation" name="btnLoadInformation"><span class="visible-content">Search</span><span class="hidden-content"><i class="fa fa-search fa-spin"></i></span></a>
                                        </div>
                                    </div>

                            <!-- <div class="table-responsive" style="margin-top: 70px;"> -->
                            <div class="demo-table" style="overflow-x:auto;">
                                <table id="datatable" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">Id
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tanggal Order
                                            </th>
                                            <th align='center'>
                                                <font size="1">No. MR
                                            </th>
                                            <th align='center'>
                                                <font size="1">No. Registrasi
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jenis Darah
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Pasien
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jaminan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Golongan Darah
                                            </th>
                                            <th align='center'>
                                                <font size="1">User Order
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jenis Order
                                            </th>
                                            <th align='center'>
                                                <font size="1">Status
                                            </th>
                                            <th align='center'>
                                                <font size="1">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <!-- <tfoot>
                                        <th align='center' colspan="11">Hasil</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tfoot> -->
                                        </table>

                                        <br>
                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane form-horizontal" id="listpemakaian">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" name="PeriodeAwal_use" onfocusout="TrigerTgl()" id="PeriodeAwal_use">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label">S/d</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" name="PeriodeAkhir_use" onfocusout="TrigerTgl()" id="PeriodeAkhir_use">
                                        </div>
                                        <div class="col-sm-1">
                                            <a type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadInformation_use" name="btnLoadInformation_use"><span class="visible-content">Search</span><span class="hidden-content"><i class="fa fa-search fa-spin"></i></span></a>
                                        </div>
                                    </div>

                                    <!-- <div class="table-responsive" style="margin-top: 70px;"> -->
                                    <div class="demo-table" style="overflow-x:auto;">
                                        <table id="datatable_listuse" class="display" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size="1">ID
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">ID Order
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Tanggal Pakai
                                                    </th>
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
                                                        <font size="1">Tgl Lahir
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Golongan Darah
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Qty Total
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Keterangan
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">User Create
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">User Update
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <!-- <tfoot>
                                        <th align='center' colspan="11">Hasil</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tfoot> -->
                                        </table>

                                        <br>
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
<script src="<?= BASEURL; ?>/js/App/odc/ListOrderDarah.js"></script>