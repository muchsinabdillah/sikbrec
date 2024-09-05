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
                            <form class="form-horizontal" id="form_trs_lembur">
                                <span class="label label-primary" class="col-sm-2">Informasi Data Pegawai</span>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Pegawai :</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="Hr_Nama_Pegawai" name="Hr_Nama_Pegawai">
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Kode JO :</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="Hr_ID_Lokasi" name="Hr_ID_Lokasi">
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <span class="label label-primary" class="col-sm-2">Informasi Data Transaksi</span>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID Transaksi :</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="IdTranasksi" id="IdTranasksi" readonly>
                                        <input type="hidden" class="form-control" name="IdTranasksiAuto" id="IdTranasksiAuto" readonly value="<?= $data['id'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lembur :</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="Hr_tglcuti_awal" name="Hr_tglcuti_awal" onchange="getWaktuLembur();">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jam Awal :</label>
                                    <div class="col-sm-2">
                                        <input type="time" class="form-control" id="Hr_Jam_Awal" name="Hr_Jam_Awal" onchange="getJam();">
                                    </div>
                                    <label class="col-sm-1 text-center">sd</label>
                                    <div class="col-sm-2">
                                        <input type="time" class="form-control" id="Hr_Jam_Akhir" name="Hr_Jam_Akhir" onchange="getJam();">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jumlah Jam :</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" id="Hr_jumlah_Lembur" name="Hr_jumlah_Lembur" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Lembur :</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="Hr_Jenis_lembur" name="Hr_Jenis_lembur">
                                            <option value="1">Lembur Hari Biasa</option>
                                            <option value="2">Lembur Hari Libur</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Catatan :</label>
                                    <div class="col-sm-10">
                                        <textarea id="catatan" rows="5" name="catatan" class="form-control"></textarea>
                                    </div>
                                </div>
                            </form>
                            <button class="btn bg-success btn-wide" id="btnreservasi" name="btnreservasi" onclick="SaveTRsLembur()"><i class="fa fa-check"></i>SIMPAN</button>
                            <button class="btn bg-danger btn-wide" id="btnreservasi" name="btnreservasi" onclick="BatalTRsLembur()"><i class="fa fa-times"></i>BATAL</button>
                            <button type="button" class="btn bg-secondary btn-wide" data-dismiss="modal">KEMBALI</button>
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
<script src="<?= BASEURL; ?>/js/App/hrd/absensi/Lembur_v04.js"></script>