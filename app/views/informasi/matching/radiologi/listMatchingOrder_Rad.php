<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>

<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <!-- <p class="sub-title">Menampilkan Data <?= $data['judul'] ?>.</p> -->
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
                                <h5>Menampilkan Data List <?= $data['judul'] ?>
                                </h5>
                            </div>

                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <form class="form-horizontal" id="form_cuti">


                                    <label for="inputEmail3" class="col-sm-1 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAwal"
                                            onfocusout="TrigerTgl()" id="PeriodeAwal">
                                    </div>
                                    <!-- <label for="inputEmail3" class="col-sm-1 control-label">S/d</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAkhir" onfocusout="TrigerTgl()" id="PeriodeAkhir">
                                    </div> -->
                                    <a type="button" class="btn btn-success btn-animated btn-wide"
                                        id="btnLoadInformation" name="btnLoadInformation"><span
                                            class="visible-content">Load</span><span class="hidden-content"><i
                                                class="fa fa-gear"></i></span></a>
                                    <!-- <button type="button" class="btn btn-primary btn-animated btn-wide"
                                        id="btnAddNewOrder" name="btnAddNewOrder"><span class="visible-content">Add New
                                            Order</span><span class="hidden-content"><i
                                                class="fa fa-plus"></i></span></button> -->
                                </form>
                            </div>
                            <hr>

                            <div class="demo-table" style="overflow-x:auto;">
                                <table id="datatable" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">WO ID
                                            </th>
                                            <th align='center'>
                                                <font size="1">ACC Number
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tanggal Pemeriksaan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Pasien
                                            </th>
                                            <th align='center'>
                                                <font size="1">No. MR
                                            </th>
                                            <th align='center'>
                                                <font size="1">No. Registrasi
                                            </th>
                                            <th align='center'>
                                                <font size="1">No. Episode
                                            </th>
                                            <th align='center'>
                                                <font size="1">Triger Date
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Pemeriksaan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Dokter Order
                                            </th>
                                            <th align='center'>
                                                <font size="1">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                                <br>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-SM" role="document">
        <div class="modal-content" style="width: 150%;margin-left:-20%">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Silahkan Pilih No Registrasi !....</h4>
            </div>
            <div class="modal-body ">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">

                        <div class="form-group">
                            <!-- <label for="inputEmail3" class="col-sm-2 control-label">Id Lab</label> -->
                            <div class="col-sm-2">
                                <input type="hidden" class="form-control" name="IDRad" id="IDRad" readonly>
                            </div>
                            <!-- <label for="inputEmail3" class="col-sm-1 control-label">No MR</label> -->
                            <div class="col-sm-2">
                                <input type="hidden" class="form-control" name="IDNoMR" id="IDNoMR" readonly>
                            </div>
                            <!-- <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Registrasi</label> -->
                            <div class="col-sm-2">
                                <input type="hidden" class="form-control" name="DateRad" id="DateRad" readonly>
                            </div>
                        </div>

                        <div class="demo-table" style="overflow-x:auto; margin :1%">
                            <table id="datatablex" class="display" width="100%">
                                <thead>
                                    <tr>
                                        <th align='center'>
                                            <font size="1">Nama Pasien
                                        </th>
                                        <th align='center'>
                                            <font size="1">No. MR
                                        </th>
                                        <th align='center'>
                                            <font size="1">No. Registrasi
                                        </th>
                                        <th align='center'>
                                            <font size="1">No. Episode
                                        </th>
                                        <th align='center'>
                                            <font size="1">Dokter
                                        </th>
                                        <th align='center'>
                                            <font size="1">Jaminan
                                        </th>
                                        <th align='center'>
                                            <font size="1">Tanggal Kunjungan
                                        </th>
                                        <th align='center'>
                                            <font size="1">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <br>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                        data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
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
<script src="<?= BASEURL; ?>/js/App/Matching/Radiologi/listMatchingOrderRadiologi.js"></script>