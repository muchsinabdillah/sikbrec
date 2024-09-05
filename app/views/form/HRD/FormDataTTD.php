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
                <p class="sub-title">Silahkan Input Transaksi Disini.</p>
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

                            <!-- Tab panes -->
                            <div class="panel-body">
                                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data"
                                    id="formUploadManual">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> ID </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="iddata" name="iddata"
                                                value="<?= $data['idmrx'] ?>" readonly>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> NIK</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="nikPegawai" name="nikPegawai"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pegawai </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="NamaPegawai" name="NamaPegawai"
                                                readonly>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pegawai</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="JenisPegawai"
                                                name="JenisPegawai" readonly>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Data SIP</h5>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Awal SIP </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" id="tglAwalTTD" name="tglAwalTTD">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Akhir SIP </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" id="tglAkhirTTD" name="tglAkhirTTD">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Doc </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="jenisdoc" name="jenisdoc">
                                                <option value="">-- PILIH --</option>
                                                <option value="SIP">SIP</option>
                                            </select>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> No. Surat </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="noSuratSIP" name="noSuratSIP">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> File </label>
                                        <div class="col-sm-4">
                                            <input type="file" name="file" id="file" class="form-control"
                                                value="/path/to/file.jpg">
                                        </div>
                                        <!-- <div class="col-md-4">
                                            <label for="inputPassword4">Nama / TTD Pegawai</label>
                                            <div class="rumahsakit">
                                                <div class="sig">
                                                    <div class="typed"></div>
                                                    <canvas class="" id="ttdrumahsakit" width="300"
                                                        height="100"></canvas>
                                                </div>
                                            </div>
                                            <label for="inputPassword4">Nama Pegawai </label>
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#saksirumahsakit">
                                                Input Tanda Tangan
                                            </button>
                                            <input type="file" name="saksi_rumah_sakit" id="saksi_rumah_sakit">
                                        </div> -->
                                    </div>
                                    <div class="form-group">
                                        <div class="row" style="margin-right:1em;float:right;">
                                            <button type="submit" name="btnUploads" id="btnUploads"
                                                class="btn btn-success  btn-rounded"><i class="fa fa-save"></i> Upload
                                                Document</button>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="table-responsive">
                                        <table id="example" class="display" width="100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th align='center'> No </th> -->
                                                    <th align='center'> No. </th>
                                                    <th align='center'> Nama</th>
                                                    <th align='center'> Tgl Awal SIP</th>
                                                    <th align='center'> Tgl Akhir SIP</th>
                                                    <th align='center'> No Surat</th>
                                                    <th align='center'> Jenis File</th>
                                                    <th align='center'> Ext</th>
                                                    <th align='center'> Date Update</th>
                                                    <th align='center'> User Update</th>
                                                    <th align='center'>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>



                                </form>



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
<!-- /.main-wrapper -->
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
<!-- <script src="<?= BASEURL; ?>/js/App/Informasi/formulir/Pelaksanaan.js"></script> -->
<script src="<?= BASEURL; ?>/js/App/Formulir/signaturefmr.js"></script>
<script>
$(".preloader").fadeOut();
</script>
<script src="<?= BASEURL; ?>/js/App/hrd/upload/uploadDataTTD.js"></script>