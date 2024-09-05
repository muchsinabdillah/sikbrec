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
                <p class="sub-title">Silahkan Input Transaksi Disini.</p>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <div class="row breadcrumb-div">
            <div class="col-md-6">
                <ul class="breadcrumb">
                    <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#"><?= $data['judul'] ?></a></li>
                    <li class="active"><?= $data['judul_child'] ?></li>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <section class="section pt-10">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel border-primary no-border border-3-top" data-panel-control>
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30"><?= $data['judul'] ?> <small><?= $data['judul_child'] ?></small></h5>
                                <br><button class="btn btn-primary" id="btnreservasi" name="btnreservasi" onclick="newTrsSurat()">NEW</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" width="100%">
                                <table id="example" class="table table-striped table-hover cell-border">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">No Transaksi
                                            </th>
                                            <th align='center'>
                                                <font size="1">Pegawai
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tanggal Awal
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tanggal Akhir
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jumlah Hari
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jenis
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kode JO
                                            </th>
                                            <th align='center'>
                                                <font size="1">Keterangan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
<!-- /.main-page -->
<!--#END Modal Print---------------------------->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/hrd/absensi/Surat_v01.js"></script>