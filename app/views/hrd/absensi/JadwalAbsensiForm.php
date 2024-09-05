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
                                <h5 class="underline mt-30"><?= $data['judul'] ?> <small><?= $data['judul_child'] ?> </small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Pegawai</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="Hr_Nama_Pegawai" name="Hr_Nama_Pegawai">
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Kode JO</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="Hr_LokasiProject" name="Hr_LokasiProject">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode Bulan</label>
                                    <div class="col-sm-4">
                                        <input type="month" class="form-control" name="Hr_Periode" id="Hr_Periode">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-4">
                                        <input type="hidden" class="form-control" name="Hr_Group_Absen" id="Hr_Group_Absen" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-2">

                                    </div>
                                </div>
                                <hr>
                            </form>
                            <button class="btn bg-success btn-wide" id="btnJadwalCreate" name="btnJadwalCreate" onclick="loadJdwl()"><i class="fa fa-folder-open"></i>LOAD</button>
                            <button class="btn bg-danger btn-wide" id="btnUpdateJadwal" name="btnUpdateJadwal" onclick="pasingkode()" data-toggle="modal" data-target="#Notif_awal_registrasi"><i class="fa fa-hourglass-start"></i>UPDATE JADWAL</button>

                            <div class="table-responsive" width="100%" style="margin-top: 10px;">
                                <table id="example" class="table table-striped table-hover cell-border">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">Hari
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tanggal
                                            </th>
                                            <th align='center'>
                                                <font size="1">L
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Shift
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jadwal Masuk
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jadwal Keluar
                                            </th>
                                            <th align='center'>
                                                <font size="1">Keterangan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kode JO
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
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="Notif_awal_registrasi" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Informasi </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_cuti">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Kode Shift</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="Hr_Kode_Shift" name="Hr_Kode_Shift">
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label">Kode JO</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="Hr_LokasiProject_Updt" name="Hr_LokasiProject_Updt">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="Hr_PeriodeUPdt1" id="Hr_PeriodeUPdt1">
                        </div>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="Hr_PeriodeUPdt2" id="Hr_PeriodeUPdt2">
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="UpdtJadwalGo" name="UpdtJadwalGo" onclick="SendUpdate()">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!--#END Modal Print---------------------------->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/hrd/absensi/JadwalAbsensi_v01.js"></script>