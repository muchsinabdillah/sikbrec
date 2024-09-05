<?php
date_default_timezone_set('Asia/Jakarta');
$id = "";
$datenowcreate = date("Y-m-d");
$datetimenow2222 = date("Y-m-d\TH:i:s");
// var_dump($data);
?>
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
                            <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <h5 class="underline mt-30">Data Pasien Berobat (SIMRS)</h5>

                                <h5 class="underline mt-30">Input Lembar Pengajuan Klaim</h5>

                                <div class="form-group jenispembayaran gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nomor SEP <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <div class="col-sm-6">
                                            <input class="form-control input-sm" type="text" id="noseppasien"
                                                name="noseppasien" placeholder="Masukkan nomor SEP disini">
                                            <input class="form-control input-sm" type="hidden" id="PasienJenisDaftar"
                                                name="PasienJenisDaftar">
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="#modalcariDataReservasi" data-toggle="modal"
                                                class="btn btn-primary btn-sm"><span
                                                    class="glyphicon glyphicon glyphicon-search"></span></a>

                                        </div>
                                    </div>
                                </div>
                                <div class="from-group tglmasuk gut">
                                    <label for="tglmasuk" class="col-sm-2 control-label">Tanggal Masuk <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="date" id="tglmasuk" name="tglmasuk" class="form-control input-sm"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group tglkeluar gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Keluar <sup
                                            class="color-danger">*</sup></label>

                                    <div class="col-sm-4">
                                        <input type="date" id="tglkeluar" name="tglkeluar" class="form-control input-sm"
                                            required>
                                    </div>
                                </div>
                                <div class="from-group jaminan gut">
                                    <label for="tglmasuk" class="col-sm-2 control-label">Jaminan <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select id="jaminan" name="jaminan" class="form-control input-sm">
                                            <option value="1">JKN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="from-group poli gut">
                                    <label for="tglmasuk" class="col-sm-2 control-label">Poli <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select id="poli" name="poli" class="form-control input-sm">
                                            <option value="1">JKN</option>
                                            <option value="ICU">Intensive Care Unit</option>
                                            <option value="INT">Poli Penyakit Dalam</option>
                                            <option value="IVP">Intravena Pydografi</option>

                                        </select>
                                    </div>
                                </div>
                                <h5 class="underline mt-30">Perawatan</h5>
                                <div class="from-group ruangrawat gut">
                                    <label for="tglmasuk" class="col-sm-2 control-label">Ruang Rawat <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select id="ruangrawat" name="ruangrawat" class="form-control input-sm">
                                            <!-- <select id="kelasrawat" name="kelasrawat" class="form-control input-sm"> -->
                                            <option value="1">JKN</option>
                                            <option value="3">Ruang Melati I</option>
                                            <option value="4">Ruang Melati II</option>
                                            <option value="5">Ruang Kamboja I</option>
                                            <option value="6">Ruang Kamboja I</option>
                                            <option value="9">Ruang Bougenvile</option>
                                            <!-- </select> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="from-group poli gut">
                                    <label for="tglmasuk" class="col-sm-2 control-label">Kelas Rawat <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="kelasrawat" name="kelasrawat" class="form-control input-sm">
                                            <option value="1">JKN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="from-group  gut">
                                    <label for="tglmasuk" class="col-sm-8 control-label">Spesialistik <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="Spesialistik" name="Spesialistik" class="form-control input-sm">
                                            <option value="1">JKN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="from-group  gut">
                                    <label for="tglmasuk" class="col-sm-8 control-label">Cara Keluar <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="carakeluar" name="carakeluar" class="form-control input-sm">
                                            <option value="1">JKN</option>
                                        </select>
                                    </div>
                                </div>

                                <label for="tglmasuk" class="col-sm-8    control-label">Kondisi pulang <sup
                                        class="color-danger">*</sup></label>
                                <div class="col-sm-3">
                                    <select id="kondisipulang" name="kondisipulang" class="form-control input-sm">
                                        <option value="1">JKN</option>
                                    </select>
                                </div>
                                <h5 class="underline mt-30">Prosedur</h5>
                                <div class="from-group poli gut">
                                    <!-- <label for="tglmasuk" class="col-sm-2 control-label">Prosedur <sup class="color-danger">*</sup></label> -->
                                    <select id="prosedur" name="prosedur[]" multiple="multiple"
                                        class="form-control input-sm">
                                        <option value="1">JKN</option>
                                    </select>
                                </div>
                                <h5 class="underline mt-30">Diagnosa</h5>
                                <div class="from-group poli gut col-sm-4">
                                    <!-- <label for="tglmasuk" class="col-sm-2 control-label">Kondisi pulang <sup class="color-danger">*</sup></label> -->
                                    <select id="diagnosa" name="diagnosa" class="form-control input-sm">
                                        <option value="1">JKN</option>
                                    </select>

                                </div>

                                <label for="tglmasuk" class="col-sm-2 control-label">Level <sup
                                        class="color-danger">*</sup></label>
                                <div class="from-group poli gut col-sm-2">
                                    <select id="level" name="level" class="form-control input-sm">
                                        <option value="1">Primary</option>
                                        <option value="2">Sekunder</option>
                                    </select>
                                </div>
                                <div class="from-group poli gut col-sm-2">
                                    <button id="inputdiagnosa" class="btn btn-primary">Add</button>
                                </div>
                                <h5 class="underline mt-30">Level</h5>
                                <!-- <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                    <table id="tbl_aktif" width="100%" class="table table-striped table-hover cell-border"> -->
                                <div class="panel-body">
                                    <div class="demo-table" style="overflow-x:auto;margin-top: 10px;" id="tbl_rekap">
                                        <table id="tbl_aktif" class="display" width="100%"
                                            class="table table-striped table-hover cell-border">
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
                                </div>
                                <h5 class="underline mt-30">Rencana</h5>
                                <div class="from-group poli gut">
                                    <label for="tglmasuk" class="col-sm-2 control-label">Rencana tl <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select id='rencanatl' style="width: 100%;" name='rencanatl'
                                            class="form-control ">
                                            <option value='0'>- Search Dokter -</option>
                                            <option value='1'>Diperbolehkan Pulang</option>
                                            <option value='2'>Pemeriksaan Penunjang</option>
                                            <option value='3'>Dirujuk Ke</option>
                                            <option value='4'>Kontrol Kembal</option>
                                        </select>
                                        <select id='dirujukke' style="width: 100%;" name='dirujukke'
                                            class="form-control ">
                                            <option value='00161001'>PUSKESMAS SANGIRAN - KAB. SIMEULUE</option>
                                            <option value='00161002'>PUSKESMAS SIMEULUE - KAB. SIMEULUE</option>
                                        </select>
                                        <div id="kontrolKembali">
                                            <input type="date" id="tglrujuk" class="form-control">
                                            <select id='polirujuk' style="width: 100%;" name='dirujukke'
                                                class="form-control ">
                                                <option value="1">JKN</option>
                                                <option value="ICU">Intensive Care Unit</option>
                                                <option value="INT">Poli Penyakit Dalam</option>
                                                <option value="IVP">Intravena Pydografi</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <h5 class="underline mt-30">Dokter</h5>
                                <div class="from-group poli gut">
                                    <label for="tglmasuk" class="col-sm-2 control-label">Dokter <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <!-- sementara -->
                                        <select id='cariDokterBPJS' style="width: 100%;" name='cariDokterBPJS'
                                            class="form-control ">
                                            <option value='0'>- Search Dokter -</option>
                                            <option value='31486'>Satro Jadhit, dr</option>
                                            <option value='31492'>Satroni Lawa, dr</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group keterangan gut">
                                    <div class="col-sm-6 mt-30">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> </label>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-success  btn-rounded " id="btnsimpan">
                                                Simpan</button>
                                            <!-- <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'> Simpan</button> -->
                                            <a href="#modal_alert_batal" data-toggle="modal"
                                                class="btn btn-danger  btn-rounded"
                                                onclick="getNobokingalasan()">Batal</a>
                                            <!-- <a class="btn btn-danger  btn-rounded " id="batal" name="batal" data-target="#modal_alert_batals" data-toggle='modal'>
                                                    Batal</a> -->
                                            <!-- <button class="btn btn-secondary  btn-rounded " id="close" name="close" >
                                                        Close</button> -->
                                            <a class="btn btn-secondary  btn-rounded"
                                                href=" <?= BASEURL ?>/aReservasiPasienWalkin">Close</a>
                                        </div>
                            </form>


                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- /.col-md-12 -->
</div>
<script>
let iduser = ` <?= $data['session']->username ?>`
let namauser = ` <?= $data['session']->name ?>`
var datareverence = <?= json_encode($data['reverence_lpk']) ?>
</script>

<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/App/LPK/stoploading.js"></script>
<script src="<?= BASEURL; ?>/js/App/LPK/input/inputlpk.js"></script>