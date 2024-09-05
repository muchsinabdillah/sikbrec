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
                <p class="sub-title">Menampilkan Data <?= $data['judul_child'] ?>.</p>
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
                                <h5><?= $data['judul_child'] ?>
                                </h5>
                            </div>

                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Filter :</label>
                                    <div class="col-sm-3">
                                        <select name="date_type" id="date_type" class="form-control">
                                            <option readonly>--Pilih--</option>
                                            <option value='1'>Tanggal Pulang</option>
                                            <option value='2'>Tanggal Grouping</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Kirim Data Online </label>
                                    <div class="col-sm-2">
                                        <select name="jenis_rawat" id="jenis_rawat" class="form-control">
                                            <option readonly>--Pilih--</option>
                                            <option value='2'>Rawat Jalan</option>
                                            <option value='1'>Rawat Inap</option>
                                            <option value='3'>Rawat Inap & Jalan</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-2">
                                        <input class="form-control" id="start_dt" name="start_dt" type="date">
                                    </div>
                                </div>

                                <!-- <a type="button" class="btn btn-success btn-animated btn-wide " id="btnKirim" name="btnKirim"><span class="visible-content">Kirim Klaim (Online)</span><span class="hidden-content"><i class="fa fa-info"></i></span></a> -->
                                <a type="button" class="btn btn-success btn-animated btn-wide " id="btnLoad" name="btnLoad"><span class="visible-content">Load Data</span><span class="hidden-content"><i class="fa fa-info"></i></span></a>
                            </form>
                        </div>
                        <!-- <div class="table-responsive" style="margin-top: 70px;"> -->
                        <div class="demo-table" style="overflow-x:auto;">
                            <table id="example" class="display" width="100%">
                                <thead>
                                    <!-- <tr>
                                        <th colspan="2" style="text-align:center">
                                            <font size="1"> Jumlah Klaim
                                        <th colspan="2" style="text-align:center">
                                            <font size="1"> Status Pengiriman
                                    </tr> -->
                                    <tr>
                                        <th align='center'>
                                            <font size="1">Tanggal Pulang
                                        </th>
                                        <th align='center'>
                                            <font size="1">No. SEP
                                        </th>

                                        <!-- <tr>
                                        <th colspan="2" style="text-align:center">
                                            <font size="1"> Status Pengiriman
                                    </tr> -->

                                        <th align='center'>
                                            <font size="1">DC Kemkes
                                        </th>
                                        <!-- <th align='center'>
                                            <font size="1">Sudah Terkirim
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <br>
                        </div>
                        <br>

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
<script src="<?= BASEURL; ?>/js/App/Eklaim/EKlaim_KirimData.js"></script>