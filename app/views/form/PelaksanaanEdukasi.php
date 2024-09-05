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
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi
                                    </small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form2">
                                <div class="form-group gut">
                                    <h5 class="underline mt-30">Pelaksanaan Edukasi</h5>
                                    <div class="panel-heading">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">TGL & Jam
                                            Edukasi:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="TglJamEdukasi"
                                                name="TglJamEdukasi">
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Materi Edukasi
                                                Berdasarkan Kebutuhan: </label>
                                            <div class="col-sm-3">
                                                <input type="Text" class="form-control"
                                                    id="Materi_Edukasi_Berdasarkan_Kebutuhan"
                                                    name="Materi_Edukasi_Berdasarkan_Kebutuhan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Kode Leaflet:</label>
                                        <div class="col-sm-3">
                                            <input type="Text" class="form-control" id="Kode_Leaflet"
                                                name="Kode_Leaflet">
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Lama Edukasi
                                                (Menit):</label>
                                            <div class="col-sm-3">
                                                <input type="time" class="form-control" id="Lama_Edukasi"
                                                    name="Lama_Edukasi">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Hasil
                                            Verifikasi:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="Hasil_Verifikasi" name="Hasil_Verifikasi">
                                                <option VALUE="">--pilih--</option>
                                                <option VALUE="Sudah Mengerti">Sudah Mengerti</option>
                                                <option VALUE="Re Edukasi">Re Edukasi</option>
                                                <option VALUE="Re Demonstrasi">Re Demonstrasi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">TGL REEDUKASI /
                                                REDEMONSTRASI:</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="Tgl_Reedukasi_Redemonstrasi"
                                                    name="Tgl_Reedukasi_Redemonstrasi">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> PEMBERI EDUKASI:
                                        </label>
                                        <div class="col-sm-3">
                                            <input type="Text" class="form-control" id="Pemberi_Edukasi"
                                                name="Pemberi_Edukasi">
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> PASIEN
                                                KELUARGA(HUBUNGAN): </label>
                                            <div class="col-sm-3">
                                                <input type="Text" class="form-control" id="Pasien_keluarga_Hubungan"
                                                    name="Pasien_keluarga_Hubungan">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- isitdd -->
                                    <!-- <div class="modal fade" id="formtandatangan" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

                                        <div class="modal-dialog modal-lg"> -->
                                    <!-- endi jumbotron -->
                                    <div class="form-row">
                                        <div class="col-sm-3">
                                            <label for="inputPassword4">Pemberi Edukasi</label>
                                            <div class="rumahsakit">
                                                <div class="sig">
                                                    <div class="typed"></div>
                                                    <canvas class="" id="ttdrumahsakit" width="300"
                                                        height="100"></canvas>
                                                </div>
                                            </div>
                                            <label for="inputPassword4">Pemberi Edukasi</label>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#saksirumahsakit">
                                                Input Tanda Tangan
                                            </button>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">PASIEN KELUARGA(HUBUNGAN):</label>
                                            <div class="copysignature" id="pasienttd">
                                                <div class="sig">
                                                    <div class="typed"></div>
                                                    <canvas class="" id="gbrttdsaksipasien" width="300"
                                                        height="100"></canvas>
                                                </div>
                                            </div>
                                            <label for="inputPassword4" id="namajelas">Nama Jelas</label>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#saksipasien">
                                                Input Tanda Tangan
                                            </button>
                                        </div>
                                        <input type="hidden" name="saksi_rumah_sakit" id="saksi_rumah_sakit">
                                        <input type="hidden" name="saksi_pasiens" id="saksi_pasiens">
                                    </div>



                                    <div class="btn-group" role="group">
                                        <button type="submit" id="tandatangan" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--
                        <a type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadPelaksanaan" name="btnLoadPelaksanaan"><span class="visible-content">Submit</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>
                        --?

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