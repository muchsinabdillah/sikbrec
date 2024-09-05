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
                <p class="sub-title">Menampilkan Data <?= $data['judul'] ?>.</p>
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
                                <h5 class="underline mt-30">Persetujuan Umum Rawat Inap / General CONSENT
                                    <small> - <sup class="color-danger">*</sup>) Harus diisi
                                    </small>
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <form action="<?= BASEURL ?>/signatureDigital/SprtoPDF" method="POST"
                                            class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                            <div class="form-group">
                                                <h6 style="margin-top:0px;margin-left:2em; margin-right:2em;">Yang
                                                    bertanda
                                                    tangan di bawah
                                                    ini :</h6>
                                            </div>
                                            <div class="form-group">
                                                <!-- <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>"> -->
                                                <label for="inputEmail3" class="col-sm-2 control-label">Nama :<sup
                                                        class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="namapasien"
                                                        name="namapasien" type="text" placeholder="Ketik Nama Pasien">
                                                </div>
                                                <!-- <label for="nama pasien" class="col-sm-2 control-label">Nama: <sup class="color-danger">*</sup></label> -->
                                                <label for="inputEmail3" class="col-sm-1 control-label">Jenis Kelamin
                                                    :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control input-sm" name="jeniskelamin"
                                                        id="jeniskelamin">
                                                        <option value="Laki-laki">Laki-Laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>
                                                    <!-- <input class="form-control input-sm " id="namapasien" name="namapasien" type="text" placeholder="Ketik Nama Pasien"> -->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <!-- <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>"> -->
                                                <label for="inputEmail3" class="col-sm-2 control-label">No Kartu
                                                    Identitas :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="kartuidentitas"
                                                        name="kartuidentitas" type="text"
                                                        placeholder="No Kartu identitas">
                                                </div>
                                                <label for="inputEmail3"
                                                    class="col-sm-1 col-form-label control-label">Selaku
                                                    :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" name="penanggungjawab"
                                                        id="penanggungjawab">
                                                        <option value="Diri Sendiri">Diri Sendiri</option>
                                                        <option value="Istri">Istri</option>
                                                        <option value="Suami">Suami</option>
                                                        <option value="Ayah">Ayah</option>
                                                        <option value="Ibu">Ibu</option>
                                                        <option value="Anak">Anak</option>
                                                        <option value="Kakak">Kakak</option>
                                                        <option value="Adik">Adik</option>
                                                        <option value="Teman">Teman</option>
                                                        <option value="Kerabat">Kerabat</option>
                                                        <option value="">Lain-Lain</option>
                                                    </select>
                                                </div>
                                                <label for="inputEmail3"
                                                    class="col-sm-1 col-form-label control-label">Dari
                                                    Pasien</label>

                                            </div>
                                            <div class="form-group">
                                                <!-- <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>"> -->

                                                <label for="inputEmail3" class="col-sm-2 control-label">Alamat :<sup
                                                        class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <textarea class="form-control input-sm " id="alamat" name="alamat"
                                                        placeholder="Alamat"></textarea>
                                                </div>
                                                <!-- <label for="Dari Pasien">n<sup class="color-white">*</sup></label> -->
                                            </div>
                                            <hr>
                                            <!-- <div class="form-inline row">

                                            </div> -->
                                            <h6 style="margin-bottom: 0px; margin-left:1em; margin-right:1em;">Bahwa
                                                karena penyakit
                                                yang diderita
                                                pasien, dengan ini
                                                menyatakan sesungguhnya telah memberikan persetujuan untuk
                                                dilakukan perawatan di unit perawatan atau pelayanan rawat :
                                            </h6>
                                            <small
                                                style="margin-top: 0px; margin-left:1em; margin-right:1em; font-style: italic;">About
                                                the
                                                illiness that
                                                the
                                                patient has
                                                been suffered, I declare that I give consent for patient's
                                                treatment in the service unit :
                                            </small>
                                            <hr style=" margin-left: 25px; margin-right: 25px;">

                                            <h6 style="margin-bottom: 0px; margin-left: 25px;">Terhadap Pasien :
                                            </h6>
                                            <small style="margin-top: 0px; margin-left: 25px; font-style: italic;">For
                                                The Patient :
                                            </small>
                                            <br>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">Nama :
                                                    <sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="namapasien"
                                                        name="namapasien" type="text" placeholder="Ketik Nama Pasien">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-1 control-label">Jenis
                                                    Kelamin :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control input-sm" name="jeniskelamin"
                                                        id="jeniskelamin">
                                                        <option value="Laki-laki">Laki-Laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>
                                                    <!-- <input class="form-control input-sm " id="namapasien"
                                                        name="namapasien" type="date" placeholder="Ketik Nama Pasien"> -->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">No Kartu
                                                    Identitas :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="kartuidentitasPasien"
                                                        name="kartuidentitasPasien" type="text"
                                                        placeholder="No Kartu identitas">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-1 control-label">Tanggal Lahir
                                                    :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="TglLahirPasien"
                                                        name="TglLahirPasien" type="date">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">No Telephone
                                                    :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="NoTelephonePasien"
                                                        name="NoTelephonePasien" type="text" placeholder="No Telephone">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-1 control-label">Agama
                                                    :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control input-sm" name="Agama" id="Agama">
                                                        <option value="1">Islam</option>
                                                        <option value="2">Kristen</option>
                                                        <option value="3">Hindu</option>
                                                        <option value="4">Budha</option>
                                                        <option value="5">Lain-Lain</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama pasien" class="col-sm-2 control-label">Alamat :
                                                    <sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <textarea class="form-control input-sm"></textarea>
                                                </div>
                                            </div>
                                            <br>
                                            <h6 style="margin-bottom: 0px; margin-left: 25px;">No. Tanda Pengenal
                                                (Ktp/Sim/Passport/Kitas) :</h6>
                                            <small
                                                style="margin-bottom: 0px; margin-left: 25px; font-style:italic">Identity
                                                Number :</small>
                                            <br>
                                            <div class="form-group">
                                                <label for="nama pasien" class="col-sm-2 control-label">jenis Identitas
                                                    :
                                                    <sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control input-sm" name="JenisIdentitas"
                                                        id="JenisIdentitas">
                                                        <option value="1">KTP</option>
                                                        <option value="2">SIM</option>
                                                        <option value="3">PASSPORT</option>
                                                        <option value="4">KITAS</option>
                                                    </select>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-1 control-label">No
                                                    Identitas :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="NoIdentitas"
                                                        name="NoIdentitas" type="text" placeholder="No identitas">
                                                </div>
                                            </div>
                                            <br>
                                            <h6 style="margin-bottom: 0px; margin-left: 25px;">Pembayaran tagihan selama
                                                perawatan :</h6>
                                            <small style="margin-bottom: 0px; margin-left: 25px; font-style:italic">Bill
                                                payment during treatment :</small>
                                            <br>
                                            <div class="form-group">
                                                <label for="nama pasien" class="col-sm-2 control-label">Jenis Pembayaran
                                                    :
                                                    <sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control input-sm" name="JenisPembayaran"
                                                        id="JenisPembayaran">
                                                        <option value="PRIBADI">Pribadi</option>
                                                        <option value="BPJS">Dijamin oleh BPJS</option>
                                                        <option value="JaminanPerusahaan">Dijamin Oleh
                                                            Perusahaan
                                                        </option>
                                                        <option value="Asuransi">Dijamin oleh Asuransi</option>
                                                    </select>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-1 control-label">Total
                                                    biaya :<sup class="color-danger">*</sup></label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="NoIdentitas"
                                                        name="NoIdentitas" type="text" placeholder="Total Biaya">
                                                </div>
                                                Rp
                                            </div>
                                            <br>
                                            <hr style="margin-left: 25px; margin-right: 25px;">
                                            <br>


                                            <!-- endi jumbotron -->
                                            <div class="form-row" style="margin-left:6em; margin-right:6em;">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4">Saksi Rumah Sakit / TTD Petugas</label>
                                                    <div class="rumahsakit">
                                                        <div class="sig">
                                                            <div class="typed"></div>
                                                            <canvas class="" id="ttdrumahsakit" width="300"
                                                                height="100"></canvas>
                                                        </div>
                                                    </div>
                                                    <label for="inputPassword4">Nama Petugas</label>
                                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#saksirumahsakit">
                                                        Input Tanda Tangan
                                                    </button>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4">Saksi Pasien / TTD Pasien</label>
                                                    <div class="copysignature" id="pasienttd">
                                                        <div class="sig">
                                                            <div class="typed"></div>
                                                            <canvas class="" id="gbrttdsaksipasien" width="300"
                                                                height="100"></canvas>
                                                        </div>
                                                    </div>
                                                    <label for="inputPassword4">Nama Pasien</label>
                                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#saksipasien">
                                                        Input Tanda Tangan
                                                    </button>

                                                </div>
                                                <input type="hidden" name="saksi_rumah_sakit" id="saksi_rumah_sakit">
                                                <input type="hidden" name="saksi_pasien" id="saksi_pasien">
                                            </div>

                                            <div class="form-group">
                                                <br>
                                                <br>
                                                <label for="nama pasien" class="col-sm-5 control-label"
                                                    style="margin-right:12em;float:right;"><button type="submit"
                                                        name="btnSave" id="btnSave" class="btn btn-primary"><i
                                                            class="fa fa-save"></i>
                                                        Save Data SPR
                                                    </button> <a onclick="MyBack()" class="btn btn-warning waves-effect"
                                                        id="btnBack" name="btnBack"><span
                                                            class="glyphicon glyphicon glyphicon-home"
                                                            aria-hidden="true"></span>
                                                        Kembali</a></label>
                                            </div>
                                        </form>
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
<div class="modal fade" id="saksipasien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saksi Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                <button class="btn-save" id="btn-save">Save</button>
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
                <button id="ttdsaksirumahsakit" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                        <canvas class="sign-pad" id="canvasttdsaksi" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="ttdsaksirumahsakit btn-save">Save</button>
                <button class="btn-clear">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
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
<script src="<?= BASEURL; ?>/js/App/SPR/spr.js"></script>
<script src="<?= BASEURL; ?>/js/App/SPR/signaturespr.js"></script>