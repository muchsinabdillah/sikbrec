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
                <p class="sub-title">Form Entri Skrinning Batuk</p>
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
    <!-- /.container-fluid -->
    <section class="section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus
                                        diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- <form class="form-horizontal" id="formdata"> -->
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data"
                                id="formdata">
                                <h5>Data Pasien</h5>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NamaPasien" id="NamaPasien"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Berobat
                                    </label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="date" id="tglregistrasi"
                                            name="tglregistrasi" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. MR
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NoMR" id="NoMR" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir </label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="TglLahir" id="TglLahir" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Registrasi </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NoRegistrasi" id="NoRegistrasi"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik Tujuan
                                    </label>
                                    <div class="col-sm-3">
                                        <!-- <<<<<<< HEAD -->
                                        <input type="text" class="form-control" name="poliklinik" id="poliklinik"
                                            readonly>
                                        <input type="hidden" class="form-control" name="IdRegistrasi" id="IdRegistrasi"
                                            value="<?= $data['id'] ?>" readonly>
                                        <!-- >>>>>>> origin/badrul_inventory -->
                                    </div>
                                </div>
                                <h5>Mohon kerjasama Bapak/Ibu untuk mengisi kuisioner dibawah ini, dengan mengisi
                                    form
                                    yang telah disediakan dengan Sejujur-jujurnya </h5>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <h6 class="col-sm-5">1. Apakah anda dengan kondisi kesehatan dibawah ini
                                        </h6>
                                        <div class="col-sm-9">
                                            <div id="checkboxes">
                                                <div class="col-sm-2">
                                                    <label class="form-check-label" for="case1a">
                                                        <input class="form-check-input" type="checkbox" id="case1a"
                                                            name="case1a" value='1'> Batuk</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="form-check-label" for="case1b">
                                                        <input class="form-check-input" type="checkbox" id="case1b"
                                                            name="case1b" value="1"> Pilek</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-check-label" for="case1c">
                                                        <input class="form-check-input" type="checkbox" id="case1c"
                                                            name="case1c" value="1"> Nyeri
                                                        Tenggorokan</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="form-check-label" for="case1d">
                                                        <input class="form-check-input" type="checkbox" id="case1d"
                                                            name="case1d" value="1"> Demam</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-check-label" for="case1e">
                                                        <input class="form-check-input" type="checkbox" id="case1e"
                                                            name="case1e" value="1"> Sesak Nafas</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h6 class="col-sm-5">2. Apakah anda batuk lebih dari 2 minggu ? <sup
                                                class="color-danger">*</sup></h6>
                                        <div class="col-sm-3">
                                            </br>
                                            </br>
                                            <select name="case2" id="case2" class="form-control">
                                                <option value=""> Pilih </option>
                                                <option value="1"> YA</option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h6 class="col-sm-5">3. Riwayat berkunjung atau pulang dari daerah Pandemi
                                            Covid
                                            19 dalam 14 hari terakhir ? <sup class="color-danger">*</sup> <br />
                                            <small>(China, Jepang, Singapura, Korsel, Malaysia, Vietnam, Thailand,
                                                USA,
                                                Kanada, Jerman, Prancis, UK, Italia, UAE, Australia, Mesir
                                                Iran)</small>
                                        </h6>
                                        <div class="col-sm-3">
                                            </br>
                                            </br>
                                            <select name="case3a" id="case3a" class="form-control">
                                                <option value=""> Pilih </option>
                                                <option value="1"> YA</option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h6 class="col-sm-5">Memiliki riwayat perjalanan / tinggal di area transmisi
                                            lokal Indonesia ? <sup class="color-danger">*</sup> <br />
                                            <small>DKI Jakarta, Jawa Barat (Kab.Bekasi, Kota Depok, Kota Bekasi,
                                                Kota
                                                Bogor, Kabupaten Bogor, Kabupaten Cirebon, Kota Bandung, dan
                                                Kabupaten
                                                Bandung), Jawa Tengah (Solo), Banten (Kab. Tanggerang, dan Kota
                                                Tanggerang)</small>
                                        </h6>
                                        <div class="col-sm-3">
                                            </br>
                                            </br>
                                            <select name="case3b" id="case3b" class="form-control">
                                                <option value=""> Pilih </option>
                                                <option value="1"> YA</option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h6 class="col-sm-5">Adakah kontak dengan kasus yang sudah terkonfirmasi
                                            POSITIF
                                            COVID 19 ? <sup class="color-danger">*</sup> </h6>
                                        <div class="col-sm-3">
                                            </br>
                                            </br>
                                            <select name="case3c" id="case3c" class="form-control">
                                                <option value=""> Pilih </option>
                                                <option value="1"> YA</option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <!-- <<<<<<< HEAD  -->
                                        <h6 class="col-sm-5">4. Apakah anda mempunyai salah satu kondisi penyakit :
                                            <sup class="color-danger">*</sup>
                                            <!-- >>>>>>> origin/badrul_inventory -->
                                        </h6>
                                        <h6 class="col-sm-5"><small>-Kencing manis / Diabetes Mellitus</small></h6>
                                        <div class="col-sm-3">
                                            </br>
                                            </br>
                                            <select name="case4a" id="case4a" class="form-control">
                                                <option value=""> Pilih </option>
                                                <option value="1"> YA</option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                        </div>
                                        <h6 class="col-sm-5"><small>-Penyakit ginjal</small></h6>
                                        <div class="col-sm-3">
                                            </br>
                                            </br>
                                            <select name="case4b" id="case4b" class="form-control">
                                                <option value=""> Pilih </option>
                                                <option value="1"> YA</option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                        </div>
                                        <h6 class="col-sm-5"><small>-Kanker</small></h6>
                                        <div class="col-sm-3">
                                            </br>
                                            </br>
                                            <select name="case4c" id="case4c" class="form-control">
                                                <option value=""> Pilih </option>
                                                <option value="1"> YA</option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                        </div>
                                        <h6 class="col-sm-5"><small>-HIV/AIDs</small></h6>
                                        <div class="col-sm-3">
                                            </br>
                                            </br>
                                            <select name="case4d" id="case4d" class="form-control">
                                                <option value=""> Pilih </option>
                                                <option value="1"> YA</option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                        </div>
                                        <h6 class="col-sm-5"><small>-Minum obat steroid (prednisone ,
                                                metilprednisolon)</small></h6>
                                        <div class="col-sm-3">
                                            </br>
                                            </br>
                                            <select name="case4e" id="case4e" class="form-control">
                                                <option value=""> Pilih </option>
                                                <option value="1"> YA</option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        </br>
                                        <label for="inputPassword4">Nama / TTD Petugas</label>
                                        <div class="rumahsakit">
                                            <div class="sig">
                                                <div class="typed"></div>
                                                <canvas class="" id="ttdrumahsakit" width="300" height="100"></canvas>
                                            </div>
                                        </div>
                                        <!-- <<<<<<< HEAD  -->
                                        <label for="inputPassword4">Nama Petugas </label>
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#saksirumahsakit">
                                            <!-- >>>>>>> origin/badrul_inventory -->
                                            Input Tanda Tangan
                                        </button>
                                        <input type="hidden" name="saksi_rumah_sakit" id="saksi_rumah_sakit">

                                    </div>
                                    </br>
                                    <div class="col-md-4">
                                        <label for="inputPassword4">Nama / TTD Pasien</label>
                                        <div class="copysignature" id="pasienttd">
                                            <div class="sig">
                                                <div class="typed"></div>
                                                <canvas class="" id="gbrttdsaksipasien" width="300"
                                                    height="100"></canvas>
                                            </div>
                                        </div>
                                        <!-- <<<<<<< HEAD  -->
                                        <label for="inputPassword4" id="namajelas">Nama Pasien</label>
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#saksipasien">
                                            <!-- >>>>>>> origin/badrul_inventory -->
                                            Input Tanda Tangan
                                        </button>
                                        <input type="hidden" name="saksi_pasiens" id="saksi_pasiens">
                                    </div>


                                </div>

                                <div class="form-group">
                                    <div class="row" style="margin-right:1em;float:right;">
                                        <button type="submit" name="btnUploads" id="btnUploads"
                                            class="btn btn-primary"><i class="fa fa-save"></i> Save Data
                                            Skrinning</button>
                                        <!-- <a class="btn btn-success waves-effect" id="btnSave" name="btnSave"><span
                                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                                            Save
                                            Data Skrinning</a> -->
                                        <a onclick="MyBack()" class="btn btn-warning waves-effect" id="btnBack"
                                            name="btnBack"><span class="glyphicon glyphicon glyphicon-home"
                                                aria-hidden="true"></span>
                                            Back To Registrasi RAJAL</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section list-->
    <section class="section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>RIWAYAT <?= $data['judul'] ?> PASIEN
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <div class="demo-table">
                                <table id="example" class="table table-striped table-bordered table-sm" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">ID
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tanggal Buat
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kondisi batuk
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kondisi pilek
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kondisi Nyeri Tenggorokan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kondisi Demam
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kondisi Sesak
                                            </th>
                                            <th align='center'>
                                                <font size="1">Batuk > 2Minggu
                                            </th>
                                            <th align='center'>
                                                <font size="1">Riwayat Berkunjung
                                            </th>
                                            <th align='center'>
                                                <font size="1">Riwayat Perjalanan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kontak dengan Kasus positif Covid
                                            </th>
                                            <th align='center'>
                                                <font size="1">Diabetes
                                            </th>
                                            <th align='center'>
                                                <font size="1">Penyakit Ginjal
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kanker
                                            </th>
                                            <th align='center'>
                                                <font size="1"> HIV/AIDs
                                            </th>
                                            <th align='center'>
                                                <font size="1"> Minum Obat Steroid
                                            </th>
                                            <th align='center'>
                                                <font size="1"> TTD Pasien
                                            </th>
                                            <th align='center'>
                                                <font size="1"> TTD Petugas
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
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>
<!-- TTD -->
<div class="modal fade" id="saksipasien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saksi Pasien</h5>
                <button id="ttdsaksirumahsakit" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Silahkan tanda tangan di dalam kotak
                <div class="signature-area" id="ttdsaksipasien">
                    <!-- <h2 class="title-area">Put signature,</h2> -->
                    <!-- <label>nama</label> -->
                    <!-- <input type="text" name="nama" id="nama"> -->
                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-save" id="btn_sakspasiensig">Save</button>
                <button class="btn-clear" id="clearttdrumahsakit">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="saksirumahsakit" tabindex="-1" role="dialog" aria-labelledby="saksirumahsakit"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saksi Rumah sakit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Silahkan tanda tangan di dalam kotak
                <div class="signature-area">
                    <!-- <h2 class="title-area">Put signature,</h2> -->
                    <!-- <label>nama</label> -->
                    <!-- <input type="text" name="nama" id="nama"> -->
                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-save" id="btn_saksirumahsakitsig">Save</button>
                <button class="btn-clear">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<!-- TTD -->

<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script>
let iduser = ` <?= $data['session']->username ?>`
let namauser = ` <?= $data['session']->name ?>`
</script>
<script>
$(document).ready(function() {
    $(".btn-clear").click(function(e) {
        $(".signature-area").signaturePad().clearCanvas();
    });
    $("#clearttdrumahsakit").click(function(e) {
        $("#ttdsaksipasien").signaturePad().clearCanvas();
        console.log('clear')
    });
    $(".signature-area").signaturePad({
        penColour: '#000000',
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 90,
        lineWidth: 0,
        validateFields: true,
    })
});
</script>
<script src="<?= BASEURL; ?>/js/App/Informasi/formulir/Pelaksanaan.js"></script>
<script src="<?= BASEURL; ?>/js/App/Formulir/signaturefmr.js"></script>
<script>
$(".preloader").fadeOut();
</script>

<script src="<?= BASEURL; ?>/js/App/Formulir/FormSkrinningBatuk_View.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/Formulir/FormSkrinningBatuk_List.js"></script> -->