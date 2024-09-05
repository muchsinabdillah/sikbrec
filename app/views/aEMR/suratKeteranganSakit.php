<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <!-- <h1><?= $data['judul'] ?></h1> -->
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- isi -->
                            <div class="col-md-12 mt-25">
                                <div class="panel panel-danger no-border">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4><b>SURAT KETERANGAN SAKIT</b></h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <form id="suratketerangansakit">
                                            <input class="form-control input-sm " id="emr_suket" name="emr_suket"
                                                type="hidden">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em; margin-bottom: 3em;">
                                                    <h5><b>Yang bertanda tangan dibawah ini menerangkan bahwa :</b></h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control input-sm " id="emr_noreg" name="emr_noreg"
                                                    type="hidden" value="<?= $data['noreg'] ?>">
                                                <input class="form-control input-sm " id="emr_norm" name="emr_norm"
                                                    type="hidden">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_namapasien"
                                                        name="emr_namapasien" type="text" required
                                                        placeholder="Ketik Nama">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir /
                                                    Usia</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tgllahir"
                                                        name="emr_tgllahir" type="date" required
                                                        placeholder="Ketik Tanggal Lahir / Usia">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Pekerjaan
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_pekerjaan"
                                                        name="emr_pekerjaan" type="text" required
                                                        placeholder="Ketik Pekerjaan">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Alamat</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control input-sm " id="emr_Alamat"
                                                        name="emr_Alamat" placeholder="Ketik Alamat"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em; margin-bottom: 3em;">
                                                    <h5><b>Berdasarkan hasil pemeriksaan yang telah dilakukan, pasien
                                                            tersebut dalam keadaan Sakit,
                                                            sehingga perlu beristirahat selama ..... ( ..... ) hari</b>
                                                    </h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal
                                                    Istirahat
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emer_tglistirahat"
                                                        name="emer_tglistirahat" type="date" required
                                                        placeholder="Ketik Tanggal Istirahat">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_diagnosa"
                                                        name="emr_diagnosa" type="text" required
                                                        placeholder="Ketik Diagnosa">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Kontrol kembali
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_kontrolulang"
                                                        name="emr_kontrolulang" type="date" required
                                                        placeholder="Ketik Kapan Kontrol Ullang">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em; margin-bottom: 3em;">
                                                    <h5><b>Demikian surat keterangan ini di berikan untuk diketahui dan
                                                            dipergunakan sebagai mana
                                                            mestinya</b>
                                                    </h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-6 control-label"> </label>
                                                <label for="inputEmail3" class="col-sm-2 control-label">
                                                    Jakarta,</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tanggalsaatini"
                                                        name="emr_tanggalsaatini" type="date" required
                                                        placeholder="Ketik Tanggal">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-6 control-label"> </label>
                                                <label for="inputEmail3" class="col-sm-2 control-label">
                                                    Dokter,</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_dokter"
                                                        name="emr_dokter" type="text" required
                                                        placeholder="Ketik Nama dokter">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-10 control-label"> </label>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-primary btn-x"
                                                        onclick="BtnSimpanData()">SIMPAN</button> <button type="button"
                                                        class="btn btn-primary btn-x"
                                                        onclick="BtnPrintSuratKeteranganSakit()">PRINT</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>

</div>

<!-- <script>
let iduser = ` <?= $data['session']->username ?>`
let namauser = ` <?= $data['session']->name ?>`
</script> -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/sweet-alert/sweetalert.min.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>
<script src="<?= BASEURL; ?>/js/App/aemr/suratKeteranganSakit.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/Signature/signature.js"></script> -->