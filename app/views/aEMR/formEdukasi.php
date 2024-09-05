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
                                <div class="panel panel-success no-border">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4><b>FORMULIR PEMBERIAN EDUKASI PASIEN TERINTREGRASI</b></h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <input class="form-control input-sm " id="emr_fromedukasi"
                                            name="emr_fromedukasi" type="hidden" required placeholder="Ketik Nama">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Nama
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_nama" name="emr_nama"
                                                    type="text" required placeholder="Ketik Nama">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir /
                                                Usia</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_tgllahir"
                                                    name="emr_tgllahir" type="date" required
                                                    placeholder="Ketik Tanggal Lahir">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> No.Rekamedis
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_norm" name="emr_norm"
                                                    type="text" required placeholder="Ketik No. RM">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label"> No.Registrasi
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="emr_noreg" name="emr_noreg"
                                                    type="text" value="<?= $data['noreg'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Jenis
                                                Kelamin</label>
                                            <div class="col-sm-4">
                                                <select class="form-control input-sm" name="emr_jeniskelamin"
                                                    id="emr_jeniskelamin">
                                                    <option value="">Pilih</option>
                                                    <option value="L">Laki-Laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <form id="form_edukasi">
                                            <input class="form-control input-sm " id="emr_formedukasi"
                                                name="emr_formedukasi" type="hidden">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: 1em;">
                                                    <h5><b>Kode :  Diskusi
                                                            (D)  Demonstrasi (Demo)  Ceramah (C)  Simulasi (S) 
                                                            Observasi (O) 
                                                            Praktek Langsung
                                                            (PL)</b></h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -2em;">
                                                    <h5><b>Dokter Spesialis/ dokter umum</b>
                                                    </h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Materi
                                                    Edukasi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label">a. Penjelasan
                                                    penyakit, penyebab, tanda &
                                                    gejala, prognosa</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> b. Hasil
                                                    pemeriksaan</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> c. Tindakan
                                                    medis</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> d. Perkiraan
                                                    hari
                                                    rawat</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> e. Penjelasan
                                                    komplikasi yang mungkin
                                                    terjadi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> f. Tambahan
                                                    Materi
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tambahanmateridokter"
                                                        name="emr_tambahanmateridokter" type="text" required
                                                        placeholder="Ketik Jika Ada Tambahan Materi">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tglmateridokter"
                                                        name="emr_tglmateridokter" type="date" required
                                                        placeholder="Ketik Tanggal">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Metode
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_metodemateridokter"
                                                        name="emr_metodemateridokter" type="text" required
                                                        placeholder="Ketik Metode">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">
                                                    Evaluasi</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm"
                                                        name="emr_evaluasimateridokter" id="emr_evaluasimateridokter">
                                                        <option value="">Pilih</option>
                                                        <option value="Sudah Mengerti">Sudah Mengerti</option>
                                                        <option value="Edukasi Ulang">Edukasi Ulang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Paraf /
                                                    Nama</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Edukator
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_edukatormateridokter"
                                                        name="emr_edukatormateridokter" type="text" required
                                                        placeholder="Ketik Nama Edukator">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien /
                                                    keluarga</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_penerimamateridokter"
                                                        name="emr_penerimamateridokter" type="text" required
                                                        placeholder="Ketik Nama Pasien / Wakil">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>Nutrisi</b>
                                                    </h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Materi
                                                    Edukasi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label">a. Diet dan
                                                    nutrisi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> b. Penyuluhan
                                                    nutrisi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> c. Tambahan
                                                    Materi
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tambahanmaterinutrisi"
                                                        name="emr_tambahanmaterinutrisi" type="text" required
                                                        placeholder="Ketik Jika Ada Tambahan Materi">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tglmaterinutrisi"
                                                        name="emr_tglmaterinutrisi" type="date" required
                                                        placeholder="Ketik Tanggal">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Metode
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_metodematerinutrisi"
                                                        name="emr_metodematerinutrisi" type="text" required
                                                        placeholder="Ketik Metode">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">
                                                    Evaluasi</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm"
                                                        name="emr_evaluasimaterinutrisi" id="emr_evaluasimaterinutrisi">
                                                        <option value="">Pilih</option>
                                                        <option value="Sudah Mengerti">Sudah Mengerti</option>
                                                        <option value="Edukasi Ulang">Edukasi Ulang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Paraf /
                                                    Nama</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Edukator
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_edukatormaterinutrisi"
                                                        name="emr_edukatormaterinutrisi" type="text" required
                                                        placeholder="Ketik Nama Edukator">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien /
                                                    keluarga</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_penerimamaterinutrisi"
                                                        name="emr_penerimamaterinutrisi" type="text" required
                                                        placeholder="Ketik Nama Pasien / Wakil">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>Manajemen Nyeri</b>
                                                    </h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Materi
                                                    Edukasi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label">a.
                                                    Farmakologi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> b. Non
                                                    farmakologi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tglmaterinyeri"
                                                        name="emr_tglmaterinyeri" type="date" required
                                                        placeholder="Ketik Tanggal">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Metode
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_metodematerinyeri"
                                                        name="emr_metodematerinyeri" type="text" required
                                                        placeholder="Ketik Metode">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">
                                                    Evaluasi</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm" name="emr_evaluasimaterinyeri"
                                                        id="emr_evaluasimaterinyeri">
                                                        <option value="">Pilih</option>
                                                        <option value="Sudah Mengerti">Sudah Mengerti</option>
                                                        <option value="Edukasi Ulang">Edukasi Ulang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Paraf /
                                                    Nama</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Edukator
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_edukatormaterinyeri"
                                                        name="emr_edukatormaterinyeri" type="text" required
                                                        placeholder="Ketik Nama Edukator">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien /
                                                    keluarga</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_penerimamaterinyeri"
                                                        name="emr_penerimamaterinyeri" type="text" required
                                                        placeholder="Ketik Nama Pasien / Wakil">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>Farmasi</b>
                                                    </h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Materi
                                                    Edukasi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> a. Nama obat
                                                    dan
                                                    kegunaan</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> b. Aturan
                                                    pemakaian dan dosis obat</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> c. Jumlah yang
                                                    diberikan</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> d. Cara
                                                    penyimpanan obat</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> e. Efek
                                                    samping
                                                    obat</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> f.
                                                    Kontraindikasi
                                                    obat</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> g. Tambahan
                                                    Materi
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tambahanmaterifarmasi"
                                                        name="emr_tambahanmaterifarmasi" type="text" required
                                                        placeholder="Ketik Jika Ada Tambahan Materi">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tglmaterifarmasi"
                                                        name="emr_tglmaterifarmasi" type="date" required
                                                        placeholder="Ketik Tanggal">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Metode
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_metodematerifarmasi"
                                                        name="emr_metodematerifarmasi" type="text" required
                                                        placeholder="Ketik Metode">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">
                                                    Evaluasi</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm"
                                                        name="emr_evaluasimaterifarmasi" id="emr_evaluasimaterifarmasi">
                                                        <option value="">Pilih</option>
                                                        <option value="Sudah Mengerti">Sudah Mengerti</option>
                                                        <option value="Edukasi Ulang">Edukasi Ulang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Paraf /
                                                    Nama</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Edukator
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_edukatormaterifarmasi"
                                                        name="emr_edukatormaterifarmasi" type="text" required
                                                        placeholder="Ketik Nama Edukator">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien /
                                                    keluarga</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_penerimamaterifarmasi"
                                                        name="emr_penerimamaterifarmasi" type="text" required
                                                        placeholder="Ketik Nama Pasien / Wakil">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>Perawat/ Bidan</b>
                                                    </h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Materi
                                                    Edukasi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> a. Pendidikan
                                                    kesehatan tentang :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tentangmateriperawat"
                                                        name="emr_tentangmateriperawat" type="text" required
                                                        placeholder="Ketik Tentang Materi">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> b. Penangan &
                                                    cara
                                                    perawatan di rumah</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> c. Perawatan
                                                    luka</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> d. Alat-alat
                                                    yang
                                                    perlu disiapkan di rumah</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> e. Keamanan
                                                    penggunaan alat-alat
                                                    kesehatan</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> f. Keamanan
                                                    lingkungan bermain</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> g. Keamanan
                                                    lingkungan perawatan
                                                    dirumah
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> h. Lain-lain
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tambahanmateriperawat"
                                                        name="emr_tambahanmateriperawat" type="text" required
                                                        placeholder="Ketik Jika Ada Tambahan Materi">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tglmateriperawat"
                                                        name="emr_tglmateriperawat" type="date" required
                                                        placeholder="Ketik Tanggal">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Metode
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_metodemateriperawat"
                                                        name="emr_metodemateriperawat" type="text" required
                                                        placeholder="Ketik Metode">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">
                                                    Evaluasi</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm"
                                                        name="emr_evaluasimateriperawat" id="emr_evaluasimateriperawat">
                                                        <option value="">Pilih</option>
                                                        <option value="Sudah Mengerti">Sudah Mengerti</option>
                                                        <option value="Edukasi Ulang">Edukasi Ulang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Paraf /
                                                    Nama</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Edukator
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_edukatormateriperawat"
                                                        name="emr_edukatormateriperawat" type="text" required
                                                        placeholder="Ketik Nama Edukator">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien /
                                                    keluarga</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_penerimamateriperawat"
                                                        name="emr_penerimamateriperawat" type="text" required
                                                        placeholder="Ketik Nama Pasien / Wakil">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"
                                                    style="margin-top: -1em;">
                                                    <h5><b>Tatalaksana Isolasi Mandiri</b>
                                                    </h5>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Materi
                                                    Edukasi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> a. Kondisi
                                                    Pasien
                                                    Tanpa Gejala atau gejala
                                                    Ringan</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> b. Alat yang
                                                    di
                                                    siapkan dirumah
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> c. Obat -
                                                    obatan</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> d. Kegiatan
                                                    Harian</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> e. Perubahan
                                                    kondisi Pasien menjadi
                                                    gejala sedang sampai Berat di Rujuk</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> f. Rujuk ke
                                                    Faskes
                                                    lebih lengkap
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> g.
                                                    Psikologi</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_tglmateriisolasi"
                                                        name="emr_tglmateriisolasi" type="date" required
                                                        placeholder="Ketik Tanggal">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Metode
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_metodemateriisolasi"
                                                        name="emr_metodemateriisolasi" type="text" required
                                                        placeholder="Ketik Metode">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">
                                                    Evaluasi</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control input-sm"
                                                        name="emr_evaluasimateriisolasi" id="emr_evaluasimateriisolasi">
                                                        <option value="">Pilih</option>
                                                        <option value="Sudah Mengerti">Sudah Mengerti</option>
                                                        <option value="Edukasi Ulang">Edukasi Ulang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> Paraf /
                                                    Nama</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Edukator
                                                    :</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_edukatormateriisolasi"
                                                        name="emr_edukatormateriisolasi" type="text" required
                                                        placeholder="Ketik Nama Edukator">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien /
                                                    keluarga</label>
                                                <div class="col-sm-4">
                                                    <input class="form-control input-sm " id="emr_penerimamateriisolasi"
                                                        name="emr_penerimamateriisolasi" type="text" required
                                                        placeholder="Ketik Nama Pasien / Wakil">
                                                </div>
                                            </div>

                                            <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-11 control-label"> </label>
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-primary btn-x"
                                                        onclick="BtnSimpanData()">SIMPAN</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-25">
                                <div class="panel panel-danger no-border">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h4><b>Lanjutan</b></h4>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <form id="form_edukasi_lanjutan">
                                            <div class="form-group">
                                                <table class="table table-bordered table-striped table-hover dataTable"
                                                    id="tbl_formedukasi_lanjutan" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th align="center" rowspan="2">id</th>
                                                            <th align="center" rowspan="2">Tanggal / Jam</th>
                                                            <th align="center" rowspan="2">Materi Edukasi</th>
                                                            <th align="center" colspan="2">Tanda tangan dan Nama Jelas
                                                            </th>
                                                            <th align="center" colspan="2">Evaluasi</th>
                                                        </tr>
                                                        <tr>
                                                            <th align="center">Pasien / Keluarga</th>
                                                            <th align="center">Edukator</th>
                                                            <th align="center">Sudah Mengerti</th>
                                                            <th align="center">Edukasi ulang</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2"><button type="button"
                                                                    itle="Batal Approve Yang Dipilih"
                                                                    class="btn btn-danger btn-xs"
                                                                    id="cb_btlapproveLaboall"
                                                                    name="cb_btlapproveLaboall"
                                                                    onclick="BtnBtlEdukasiLanjutan(this)"><i
                                                                        class="fa fa-ban"></i>Delete</button>&nbsp
                                                                <button type="button" class="btn btn-primary btn-xs"
                                                                    id="btn_modaledukasilanjutan"
                                                                    name="btn_modaledukasilanjutan"><span
                                                                        class="glyphicon glyphicon-check"></span> Add
                                                                    More</button>
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-12 control-label"> </label>
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

<!-- Modal -->
<div class="modal fade" id="modaledukasilanjutan" style="overflow-y: auto" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal4Label" data-backdrop-color="gray">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color:brown;">
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                <h4 class="modal-title" style="color: white;"> Input Masalah Keperawatan</h4>
            </div>
            <div class="modal-body">
                <form id="form_edukasilanjutan">
                    <input class="form-control input-sm " id="emr_edukasilanjut" name="emr_edukasilanjut" type="hidden">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"> ID :</label>
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="emr_id_edukasilanjutan"
                                    name="emr_id_edukasilanjutan" type="text" required placeholder="Ketik ID" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"> NO.MR :</label>
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="emr_mr_edukasilanjutan"
                                    name="emr_mr_edukasilanjutan" type="text" required placeholder="Ketik MR" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label"> No.Registrasi :</label>
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="emr_noreg_edukasilanjutan"
                                    name="emr_noreg_edukasilanjutan" type="text" required
                                    placeholder="Ketik No Registrasi" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-12 control-label" style="margin-top: 2em;"> Isi data
                                sesuai dengan kolom yang
                                sudah tersedia !</label>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-12 control-label" style="margin-top: 2em;"> </label>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal
                                Edukasi :</label>
                            <div class="col-sm-10">
                                <input class="form-control input-sm " id="emr_tgl_edukasilanjutan"
                                    name="emr_tgl_edukasilanjutan" type="date" required placeholder="Ketik Tanggal">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Materi Edukasi :</label>
                            <div class="col-sm-10">
                                <textarea class="form-control input-sm " id="emr_materi_edukasilanjutan"
                                    name="emr_materi_edukasilanjutan" placeholder="Ketik Materi"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Pasien / Wakil :</label>
                            <div class="col-sm-10">
                                <input class="form-control input-sm " id="emr_penerima_edukasilanjutan"
                                    name="emr_penerima_edukasilanjutan" type="text" required
                                    placeholder="Ketik Pasien / Wakil">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-12 control-label"> </label>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Edukator :</label>
                            <div class="col-sm-10">
                                <input class="form-control input-sm " id="emr_edukator_edukasilanjutan"
                                    name="emr_edukator_edukasilanjutan" type="text" required
                                    placeholder="Ketik Edukator">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Evaluasi :</label>
                            <div class="col-sm-10">
                                <select class="form-control input-sm" name="emr_evaluasi_edukasilanjutan"
                                    id="emr_evaluasi_edukasilanjutan">
                                    <option value="">Pilih</option>
                                    <option value="Sudah Mengerti">Sudah Mengerti</option>
                                    <option value="Edukasi Ulang">Edukasi Ulang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseMasalahKeperawatan"
                    onclick="btnCloseModalEdukasiLanjutan()"><i class="fa fa-times"></i>Close</button>
                <button type="button" class="btn bg-primary btn-wide" id="btnSaveMasalahKeperawatan"
                    onclick="btnSaveModalEdukasiLanjutan()"><i class="fa fa-file"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- <script>
let iduser = ` <?= $data['session']->username ?>`
let namauser = ` <?= $data['session']->name ?>`
</script> -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/sweet-alert/sweetalert.min.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>
<script src="<?= BASEURL; ?>/js/App/aemr/formEdukasi.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/Signature/signature.js"></script> -->