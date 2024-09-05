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
                            <div class="col-md-12 mt-25">
                                <div class="panel panel-primary no-border">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5><b>IDENTITAS PASIEN</b></h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> No Registrasi
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_noreg" name="emr_noreg"
                                                    value="<?= $data['noreg'] ?>" type="text" required
                                                    placeholder="Ketik No Registrasi">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label"> No MR:</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_norm" name="emr_norm"
                                                    type="text" required placeholder="Ketik No MR">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_namapasien"
                                                    name="emr_namapasien" type="text" required placeholder="Ketik Nama">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Nama
                                                Jaminan:</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_jaminan"
                                                    name="emr_jaminan" type="text" required
                                                    placeholder="Ketik Nama Jaminan">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Umur / Kelamin
                                                :</label>
                                            <div class="col-sm-1">
                                                <input class="form-control input-sm " id="emr_umur" name="emr_umur"
                                                    type="number" required placeholder="Ketik Umur">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-1 control-label">/Th</label>
                                            <div class="col-sm-2">
                                                <select class="form-control input-sm" name="emr_jeniskelamin"
                                                    id="emr_jeniskelamin">
                                                    <option value="">Pilih</option>
                                                    <option value="L">Laki-Laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Masuk
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_tglmasuk"
                                                    name="emr_tglmasuk" type="date" required
                                                    placeholder="Ketik tanggal masuk">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Agama
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_agama" name="emr_agama"
                                                    type="text" required placeholder="Ketik Agama">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal keluar
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_tglkeluar"
                                                    name="emr_tglkeluar" type="date" required
                                                    placeholder="Ketik Tanggal Keluar">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Pekerjaaan
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_pekerjaan"
                                                    name="emr_pekerjaan" type="text" required
                                                    placeholder="Ketik Pekerjaan">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Pengirim
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_dokterpengirim"
                                                    name="emr_dokterpengirim" type="text" required
                                                    placeholder="Ketik Dokter Pengirim">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Alamat
                                                :</label>
                                            <div class="col-sm-4">
                                                <textarea class="form-control input-sm " id="emr_alamat"
                                                    name="emr_alamat" placeholder="Ketik Alamat"></textarea>
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Yang Merawat
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_dokteryangmerawat"
                                                    name="emr_dokteryangmerawat" type="text" required
                                                    placeholder="Ketik Dokter Yang Merawat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- isi -->
                            <div class="col-md-12 mt-25">
                                <div class="panel panel-danger no-border">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4><b>RESUME MEDIS</b></h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <form id="resume_medis">
                                            <input class="form-control input-sm " id="resumemedis" name="resumemedis"
                                                type="hidden">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Alasan datang
                                                    ke
                                                    RS</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm" name="emr_alasandatang"
                                                        id="emr_alasandatang">
                                                        <option value="">Pilih</option>
                                                        <option value="Penyakit">Penyakit</option>
                                                        <option value="KLL">KLL</option>
                                                        <option value="Kecelakaan kerja">Kecelakaan kerja</option>
                                                        <option value="Kecelakaan lain">Kecelakaan lain</option>
                                                        <option value="VR">VR</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>1. Jenis Kasus</b></h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Bedah
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm" name="emr_bedah"
                                                        id="emr_bedah">
                                                        <option value="">Pilih</option>
                                                        <option value="Trauma">Trauma</option>
                                                        <option value="Non Trauma">Non Trauma</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Non Bedah
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm" name="emr_nonbedah"
                                                        id="emr_nonbedah">
                                                        <option value="">Pilih</option>
                                                        <option value="Interna">Interna</option>
                                                        <option value="Anak">Anak</option>
                                                        <option value="Obsgin">Obsgin</option>
                                                        <option value="Lainnya">Lainnya</option>
                                                    </select>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Jika Lainnya,
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_nonbedahlainnya"
                                                        name="emr_nonbedahlainnya" type="text" required
                                                        placeholder="Ketik Pilihan Lainnya">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>2. Diagnosis Awal</b></h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> a. Anamnesis
                                                    singkat
                                                    :</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control input-sm " id="emr_anamnesissingkat"
                                                        name="emr_anamnesissingkat"
                                                        placeholder="Ketik Anamnesis Singkat"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> b. Pemeriksaan
                                                    Fisik : Keadaan Umum penderita :</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control input-sm " id="emr_pemeriksaan"
                                                        name="emr_pemeriksaan" type="text" required
                                                        placeholder="Ketik Keadaan Umum">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tensi
                                                    :</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="emr_tensi"
                                                        name="emr_tensi" type="text" required placeholder="Ketik Tensi">
                                                </div>
                                                <div class="col-sm-1">
                                                    <input class="form-control input-sm " id="emr_tensimmhg"
                                                        name="emr_tensimmhg" type="text" required value="MmHg" readonly>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Suhu
                                                    :</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="emr_suhu" name="emr_suhu"
                                                        type="text" required placeholder="Ketik Suhu">
                                                </div>
                                                <div class="col-sm-1">
                                                    <input class="form-control input-sm " id="emr_suhuc"
                                                        name="emr_suhuc" type="text" required value="°C" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nadi
                                                    :</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="emr_nadi" name="emr_nadi"
                                                        type="text" required placeholder="Ketik Nadi">
                                                </div>
                                                <div class="col-sm-1">
                                                    <input class="form-control input-sm " id="emr_nadimenit"
                                                        name="emr_nadimenit" type="text" required value="X/menit"
                                                        readonly>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nafas
                                                    :</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="emr_nafas"
                                                        name="emr_nafas" type="text" required placeholder="Ketik Nafas">
                                                </div>
                                                <div class="col-sm-1">
                                                    <input class="form-control input-sm " id="emr_nafasmenit"
                                                        name="emr_nafasmenit" type="text" required value="X/menit"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> BB
                                                    :</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="emr_bb" name="emr_bb"
                                                        type="text" required placeholder="Ketik Berat Badan">
                                                </div>
                                                <div class="col-sm-1">
                                                    <input class="form-control input-sm " id="emr_bbkg" name="emr_bbkg"
                                                        type="text" required value="Kg" readonly>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> TB
                                                    :</label>
                                                <div class="col-sm-3">
                                                    <input class="form-control input-sm " id="emr_tb" name="emr_tb"
                                                        type="text" required placeholder="Ketik Tinggi Badan">
                                                </div>
                                                <div class="col-sm-1">
                                                    <input class="form-control input-sm " id="emr_tbcm" name="emr_tbcm"
                                                        type="text" required value="Cm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> c. Laboratorium
                                                    *)
                                                    :</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control input-sm " id="emr_laboratorium"
                                                        name="emr_laboratorium"
                                                        placeholder="Ketik keterangan Laboratorium"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> d. Pemeriks.
                                                    Radiologi *)
                                                    :</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control input-sm " id="emr_radiologi"
                                                        name="emr_radiologi"
                                                        placeholder="Ketik Pemeriksaan Radiologi"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> e. Pemeriksaan
                                                    lainnya *)

                                                    :</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control input-sm " id="emr_pemeriksaanlainnya"
                                                        name="emr_pemeriksaanlainnya"
                                                        placeholder="Ketik Pemeriksaan Lainnya"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>3. Terapi / Tindakan</b></h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Terapi/Tindakan
                                                    yang diberikan :</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control input-sm " id="emr_tindakan"
                                                        name="emr_tindakan"
                                                        placeholder="Ketik Terapi Yang Diberikan"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>4. Diagnosis Akhir</b></h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosis Akhir
                                                    :</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control input-sm " id="emr_diagnosisakhir"
                                                        name="emr_diagnosisakhir"
                                                        placeholder="Ketik Diagnosis Akhir"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Kategori Kasus
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm" name="emr_kategorikasus"
                                                        id="emr_kategorikasus">
                                                        <option value="">Pilih</option>
                                                        <option value="Akut">Akut</option>
                                                        <option value="Subakut">Subakut</option>
                                                        <option value="Kronis">Kronis</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>5. Tindakan Lanjut</b></h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="checkbox" id="emr_sembuh" name="emr_sembuh"
                                                        style="margin-top:-3em;"> <b>Sembuh</b>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="checkbox" id="emr_dipulangkan" name="emr_dipulangkan"
                                                        style="margin-top:-3em;"> <b>Dipulangkan</b>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Dipulangkan,
                                                    untuk
                                                    kontrol/ berobat jalan periodik tiap</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_dipulangkanuntuk"
                                                        name="emr_dipulangkanuntuk" type="text" required
                                                        placeholder="Ketik Waktu">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Dirujuk ke
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_dirurukke"
                                                        name="emr_dirurukke" type="text" required
                                                        placeholder="Ketik Dirujuk Ke">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Atas dasar
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm" name="emr_atasdasar"
                                                        id="emr_atasdasar">
                                                        <option value="">Pilih</option>
                                                        <option value="Tempat penuh">Tempat penuh</option>
                                                        <option value="Pengobatan lebih lanjut">Pengobatan lebih lanjut
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-10 control-label"> </label>
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-primary btn-x"
                                                        onclick="BtnSimpanData()">SIMPAN</button>
                                                </div>
                                                <div class="col-sm-1"><button type="button"
                                                        class="btn btn-primary btn-x"
                                                        onclick="BtnPrintResumeMedis()">PRINT</button>
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
<script src="<?= BASEURL; ?>/js/App/aemr/resumeMedis.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/Signature/signature.js"></script> -->