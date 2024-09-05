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
                                <h5 style="margin-top:0px">Data Pasien</h5>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="IdAuto" id="IdAuto"
                                            value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nama </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="NamaDokter" name="NamaDokter"
                                            maxlength="50" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Spesialis </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="Spesialis" name="Spesialis"
                                            readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Job Title </label>

                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="JobTitle" name="JobTitle"
                                            maxlength="50" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Category </label>

                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="Category" name="Category"
                                            maxlength="50" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Grup Perawatan </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="GrupPerawatan" name="GrupPerawatan"
                                            maxlength="50" readonly>
                                    </div>
                                </div>

                                <hr>
                                <div class="panel-title">
                                    <h5>Upload Foto</h5>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> File </label>
                                    <div class="col-sm-4">
                                        <input type="file" name="fileImage" id="fileImage" class="form-control">
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
                                <h5>Riwayat <?= $data['judul'] ?>
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
                                                <font size="1">Nama Dokter
                                            </th>
                                            <th align='center'>
                                                <font size="1">Spesialis
                                            </th>
                                            <th align='center'>
                                                <font size="1">Job Title
                                            </th>
                                            <th align='center'>
                                                <font size="1">Category
                                            </th>
                                            <th align='center'>
                                                <font size="1">Grup Perawatan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Foto
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

<script src="<?= BASEURL; ?>/js/App/MasterData/MasterDataDokter/MasterDataDokter_Image.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/Formulir/FormSkrinningBatuk_List.js"></script> -->