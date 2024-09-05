<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?><small>( - <sup class="color-danger">*</sup>) Harus diisi </small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-horizontal" id="frmsimpanrujukan">
                                <h5 class="underline mt-30">Data Pasien Berobat (SIMRS)</h5>

                                <h5 class="underline mt-30">Input Data Rujukan Khusus</h5>
                                <div class="form-group datainsertrujukan gut">
                                    <label for="nosep" class="col-sm-1 control-label">Nomor Rujukan<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-5">
                                        <div class="col-sm-6">
                                            <input class="form-control input-sm" type="text" id="nomorrujukan" name="nomorrujukan" placeholder="Masukkan nomor SEP disini">
                                            <!-- <input class="form-control input-sm" type="hidden" id="PasienJenisDaftar" name="PasienJenisDaftar"> -->
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="#modalcaridatasep" data-toggle="modal" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group jnsPelayanan gut">

                                </div>
                                <div class="from-group kodefakes gut">

                                </div>
                                <div class="form-group jnsPelayanan gut">

                                </div>
                                <div class="from-group kodefakes gut">
                                    <label for="tglrujukan" class="col-sm-2 control-label">PPK Rujukan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ppkrujukan" id="ppkrujukan" class="form-control input-sm">
                                        <select id="ppkrujukandata" name="ppkrujukandata" class="form-control input-sm">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group jnsPelayanan gut">
                                    <!-- <label for="jnsPelayanan" class="col-sm-4 control-label"> Primer <sup class="color-danger">*</sup></label> -->
                                    <div class="col-sm-2">
                                        <select id="tipefakes" name="tipefakes" class="form-control input-sm" required>
                                            <option value="">--Pilih Fakses--</option>
                                            <option value="1">Fakes 1</option>
                                            <option value="2">Fakes 2</option>
                                        </select>
                                    </div>
                                    <div class="from-group poli gut col-sm-1">
                                        <!-- <button id="inputdiagnosa" class=" btn btn-primary">Add</button> -->
                                        <span onclick="carippkrujukan()" class="btn btn-primary">Cari PPK Rujukan</span>
                                    </div>
                                </div>
                                <div class="from-group kodefakes gut">
                                    <label for="tglrujukan" class="col-sm-2 control-label">TGL Rujukan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="date" name="tglrujukan" id="tglrujukan" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="form-group jnsPelayanan gut">
                                    <!-- <label for="jnsPelayanan" class="col-sm-4 control-label"> Primer <sup class="color-danger">*</sup></label> -->

                                    <div class="from-group poli gut col-sm-1">
                                        <!-- <button id="inputdiagnosa" class=" btn btn-primary">Add</button> -->
                                        <span onclick="Carispesialistik()" class="btn btn-primary">Cari</span>
                                    </div>
                                </div>
                                <!-- <div class="form-group jnsPelayanan gut">
                                    <label for="tglrujukan" class="col-sm-2 control-label">Level Diagnosa <sup class="color-danger">*</sup></label>
                                    <div class="from-group poli gut col-sm-2 mt-5">
                                        <select id="level" name="level" class="form-control input-sm">
                                            <option value="1">Primary</option>
                                            <option value="2">Sekunder</option>
                                        </select>
                                    </div>
                                    <div class="from-group poli gut col-sm-2">
                                        <button id="inputdiagnosa" class="btn btn-primary">Add</button>
                                    </div>
                                </div> -->
                                <div class="from-group kodefakes gut">
                                    <label for="tglrujukan" class="col-sm-2 control-label">Procedure <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3 rujukan">
                                        <select id="prosedurRujukanKhusus" name="prosedurRujukanKhusus" class="form-control input-sm" required>
                                            <option value="">Pilih Poli rujukan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group Catatan gut">
                                </div>
                                <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                    <table id="tbl_aktif" width="100%" class="table table-striped table-hover cell-border">
                                        <thead>
                                            <tr>
                                                <th style="display:none;">Visit Date</th>
                                                <th align='center'>
                                                    <font size="1">Kode Diagnosa
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Diagnosa
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Level
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id='leveldiagnosa'>
                                        </tbody>
                                    </table>
                                </div>
                                <ul id="myUL" class="list-group">
                                </ul>
                                <div class="form-group keterangan gut">
                                    <div class="col-sm-6 mt-30">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> </label>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-success  " id="btnsimpan">
                                                <span class="glyphicon glyphicon-ok"></span> Simpan</button>
                                            <!-- <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'> Simpan</button> -->
                                            <a href="#modal_alert_batal" data-toggle="modal" class="btn btn-danger  btn-rounded" onclick="getNobokingalasan()"><span class="glyphicon glyphicon-remove"></span> Batal</a>
                                            <!-- <a class="btn btn-danger  btn-rounded " id="batal" name="batal" data-target="#modal_alert_batals" data-toggle='modal'>
                                                    Batal</a> -->
                                            <!-- <button class="btn btn-secondary  btn-rounded " id="close" name="close" >
                                                        Close</button> -->
                                            <a class="btn btn-dark " href=" <?= BASEURL ?>/aReservasiPasienWalkin">Close</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    let iduser = ` <?= $data['session']->username ?>`
    let namauser = ` <?= $data['session']->name ?>`
</script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/sweet-alert/sweetalert.min.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/APP/Rujukan/inputrujukan.js"></script> -->
<script src="<?= BASEURL; ?>/js/APP/Rujukanlistrujukankhusus/listrujukankhusus.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>