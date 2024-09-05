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
                                <h5 class="underline mt-30">AKAD IJARAH MULTIJASA PELAYANAN <small> - <sup
                                            class="color-danger">*</sup>) Harus diisi
                                    </small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form action="<?= BASEURL ?>/signatureDigital/SprtoPDF" method="POST"
                                class="form-horizontal" id="frmSimpanTrsRegistrasi">

                                <div class="form-group">
                                    <h6 style="margin-top:0px;margin-left:5em; margin-right:5em;">Dengan menyebut nama
                                        ALLAH yang Maha
                                        Pengasih lagi Maha Penyayang. &emsp;&emsp;<big style="font-size:25px">
                                            ِبِسْمِ
                                            اللَّهِ الرَّحْمَنِ
                                            الرَّحِيْم
                                        </big>
                                    </h6>
                                    <h6 style="margin-top:0px;margin-left:5em; margin-right:5em;">Akad ijarah ini di
                                        tanda tangani pada
                                        hari, <?= $data['hari'] ?>
                                        <?= date("d/m/y") ?> oleh dua pihak,</h6>
                                </div>
                                <hr>

                                <div class="form-group">
                                    <label style="margin-top:0px;margin-left:4em; margin-right:4em; font-size:15px;"
                                        for="inputEmail3" id="namapihak1">Nama &emsp; :
                                        <?= $data['session']->name ?></label>
                                </div>
                                <div class="form-group">
                                    <label style="margin-top:0px;margin-left:4em; margin-right:4em; font-size:15px;"
                                        for="inputEmail3">Jabatan &nbsp;: Staff
                                        Admission & Billing</label>
                                </div>
                                <div class="form-group">
                                    <h6 style="margin-top:0px;margin-left:5em; margin-right:5em;">Bertindak untuk dan
                                        atas nama Rumah Sakit YARSI, yang beralamat di Jl.
                                        Letjen Suprapto No.Kav 13, RW.5, Cemp. Putih Tim., Kec. Cemp. Putih, Kota
                                        Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10510 untuk selanjutnya
                                        disebut sebagai Pihak 1 (pertama) dalam perjanjian ini dengan :</h6>
                                </div>

                                <div class="form-group">
                                    <!-- <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>"> -->
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama :<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="nama" name="nama" type="text"
                                            placeholder="Ketik Nama">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">No. KTP :<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="noKTP" name="noKTP" type="text"
                                            placeholder="Ketik No KTP">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>"> -->
                                    <label for="inputEmail3" class="col-sm-2 control-label">Pekerjaan :<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="pekerjaan" name="pekerjaan"
                                            type="text" placeholder="Ketik Pekerjaan">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">No. HP :<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="noHP" name="noHP" type="text"
                                            placeholder="Ketik No HP">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Alamat :<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <textarea class="form-control input-sm " id="alamat" name="alamat"
                                            placeholder="Ketik Alamat"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h6 style="margin-top:0px;margin-left:5em; margin-right:5em;">Bertindak untuk dan
                                        atas nama (nama diri sendiri, atau mewakili pasien) :</h6>
                                </div>

                                <div class="form-group">
                                    <!-- <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>"> -->
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama :<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="namapasien" name="namapasien"
                                            type="text" placeholder="Ketik Nama Pasien">
                                    </div>
                                    <!-- <label for="nama pasien" class="col-sm-2 control-label">Nama: <sup class="color-danger">*</sup></label> -->
                                    <label for="inputEmail3" class="col-sm-1 control-label">Jenis Kelamin
                                        :<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select class="form-control input-sm" name="jeniskelasmin" id="jeniskelasmin">
                                            <option value="Laki-laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                        <!-- <input class="form-control input-sm " id="namapasien" name="namapasien" type="text" placeholder="Ketik Nama Pasien"> -->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>"> -->
                                    <label for="inputEmail3" class="col-sm-2 control-label">No RM :<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="norm" name="norm" type="text"
                                            placeholder="Ketik No Rekam Medis" value="<?= $data['noregistrasi'] ?>">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Tanggal Lahir
                                        :<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="tgllahir" name="tgllahir" type="date" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>"> -->
                                    <label for="inputEmail3" class="col-sm-2 control-label">No Registrasi :<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="Noregis" name="Noregis" type="text"
                                            placeholder="Ketik No Registrasi" value="<?= $data['noregistrasi'] ?>">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Kamar :<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="kamar" name="kamar" type="text"
                                            placeholder="Ketik Kamar">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group" style="background-color:#F5F5F5;">
                                    <br>
                                    <br>
                                    <label style="margin-top:0px;margin-left:4em; margin-right:4em; font-size:15px;"
                                        for="inputEmail3">Untuk selanjutnya di
                                        sebut sebagai Pihak 2 (kedua) :</label>
                                    <br>
                                    <h6 style="margin-top:0px;margin-left:5em; margin-right:5em;">Dalam perjanjian ini
                                        kedua belah pihak dengan penuh kesadaan dan tanpa
                                        paksaan dari pihak
                                        manapun telah memahami maksud dan isi dari perjanjian ini dan sepakat
                                        mengadakan Perjanjian Ijarah untuk pelayanan
                                        kesehatan kepada pasien sebagaimana telah di sebutkan di atas, dengan
                                        ketentuan dan syarat-syarat sebagai berikut :</h6>
                                    <h6 style="margin-top:0px;margin-left:5em; margin-right:5em;">1. &nbsp; Pihak
                                        pertama
                                        menyetujui untuk memberikan pelayanan kesehatan sesuai dengan Standar Prosedur
                                        operasional di RS YARSI.</h6>
                                    <h6 style="margin-top:0px;margin-left:5em; margin-right:5em;">2. &nbsp;Pihak Kedua
                                        Memberikan imbal jasa kepada Pihak Pertama dengan ketentuan sesuai dengan
                                        PERMENKES RI Nomor 51 Tahun 2008 Sebagai berikut :</h6>
                                    <h6 style="margin-top:0px;margin-left:7em; margin-right:5em;">a. &nbsp;Rawat Inap
                                        sesuai
                                        Hak Kelas BPJS pihak kedua tidak dikenakan biaya.</h6>
                                    <h6 style="margin-top:0px;margin-left:7em; margin-right:5em;">b. &nbsp;Untuk
                                        peningkatan
                                        kelas pelayanan rawat inap dari kelas 3 kek kelas 2, dan dari kelasd 2 ke kelas
                                        1, harus membayar Selisih Biaya antara Tarif INA-CBG pada kelas rawat inap lebih
                                        tinggi yang dipiih dengan tarif INA-CBG pada kelas rawat inap yang sesuai dengan
                                        hak Peserta.</h6>
                                    <h6 style="margin-top:0px;margin-left:7em; margin-right:5em;">c. &nbsp;Untuk
                                        peningkatan
                                        kelas pelayanan rawat inap di atas kelas 1, harus membayar Selisih Biaya paling
                                        banyak sebesar 75%(tujuh puluh lima persen) dari INACBG kelas 1.</h6>
                                    <h6 style="margin-top:0px;margin-left:5em; margin-right:5em;">3. &nbsp;Pihak pertama
                                        menerbitkan kwitansi penerimaan imbal jasa sesuai jumalh yang diterima sebagai
                                        paket pelayanan tanpa perincian untuk perawatan sampai dengan VIP Reguler.</h6>
                                    <h6 style="margin-top:0px;margin-left:5em; margin-right:5em;">4. &nbsp;Pihak kedua
                                        bersedia membayar tindakan dan perawatan Pribadi/Asuransi/Perusahaan dan tidak
                                        bisa mengubah penjamin/Alih penjamin di tengah mas perawatan.</h6>
                                    <br>
                                </div>
                                <br>
                                <br>


                                 
                                <div class="form-row" style="margin-left:6em; margin-right:6em;">
                                    <div class="form-group col-md-4">
                                        <label for="inputEmail4">Pihak 1</label>
                                        <div class="rumahsakit">
                                            <div class="sig">
                                                <div class="typed"></div>
                                                <canvas class="" id="ttdrumahsakit" width="300" height="100"></canvas>
                                            </div>
                                        </div>
                                        <label for="inputPassword4"><?= $data['session']->name ?></label>
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#saksirumahsakit">
                                            Input Tanda Tangan
                                        </button>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputPassword4">Pihak 2</label>
                                        <div class="copysignature" id="pasienttd">
                                            <div class="sig">
                                                <div class="typed"></div>
                                                <canvas class="" id="gbrttdsaksipasien" width="300"
                                                    height="100"></canvas>
                                            </div>
                                        </div>
                                        <label for="inputPassword4" id="namajelas">Nama Jelas</label>
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#saksipasien">
                                            Input Tanda Tangan
                                        </button>
                                    </div>
                                    <input type="hidden" name="saksi_rumah_sakit" id="saksi_rumah_sakit">
                                    <input type="hidden" name="saksi_pasien" id="saksi_pasien">
                                </div>
                                <br>
                                <!-- <div class="btn-group" role="group">
                                    <button type="submit" id="tandatangan" class="btn btn-primary">Submit</button>
                                </div> -->
                                <div class="form-group">
                                    <br>
                                    <br>
                                    <label for="nama pasien" class="col-sm-5 control-label"
                                        style="margin-right:12em;float:right;"><button type="submit" name="tandatangan"
                                            id="tandatangan" class="btn btn-primary"><i class="fa fa-save"></i>
                                            Save Data
                                        </button> <a onclick="MyBack()" class="btn btn-warning waves-effect"
                                            id="btnBack" name="btnBack"><span class="glyphicon glyphicon glyphicon-home"
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

<script src="<?= BASEURL; ?>/js/App/SPR/spr.js"></script>
<script src="<?= BASEURL; ?>/js/App/SPR/signaturespr.js"></script>