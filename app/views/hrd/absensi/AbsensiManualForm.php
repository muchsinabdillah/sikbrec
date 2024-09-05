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
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID Transaksi :</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="IdTranasksi" id="IdTranasksi" readonly>
                                        <input type="hidden" class="form-control" name="IdTranasksiAuto" id="IdTranasksiAuto" readonly value="<?= $data['id'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal :</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" id="Absen_Tanggal" name="Absen_Tanggal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Status :</label>
                                    <div class="col-sm-2">

                                        <select class="form-control" id="Absen_Status" name="Absen_Status" onchange="disableinOut();">
                                            <option value="">- Pilih -</option>
                                            <option value="1">IN</option>
                                            <option value="2">OUT</option>
                                            <option value="3">IN-OUT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jam In :</label>
                                    <div class="col-sm-2">
                                        <input type="time" class="form-control" id="Absen_Jam" name="Absen_Jam">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jam Out :</label>
                                    <div class="col-sm-2">
                                        <input type="time" value="0" class="form-control" id="Absen_Jam_Out" name="Absen_Jam_Out">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Pegawai :</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="Hr_Nama_Pegawai" name="Hr_Nama_Pegawai">
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <button class="btn bg-danger btn-wide" id="btnreservasi" name="btnreservasi" onclick="goBack()"><i class="fa fa-times"></i>KEMBALI</button>
                            <button class="btn bg-success btn-wide" id="btnreservasi" name="btnreservasi" onclick="go_save()"><i class="fa fa-check"></i>SIMPAN</button>
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
<script src="<?= BASEURL; ?>/js/App/hrd/absensi/AbsensiManual_v03.js"></script>