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
                                <h5><?= $data['judul'] ?></h5>

                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <h5 class="underline mt-30">Data Lembar Pengajuan Klaim (BPJS)</h5>
                                <h5 class="underline mt-30">Cari Data</h5>
                                <div class="form-group  asdas">
                                    <div class="card">
                                        <div class="card-body">
                                            <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal masuk <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-2">
                                                <input type="date" name="tglmasuk" id="tglmasuk" class="form-control" required>
                                                <!-- <input class="form-control input-sm" type="hidden" id="TglNowTemp" value="<?= $datetimenow2222 ?>" readonly autocomplete="off" name="TglNowTemp"> -->
                                                <!-- <input class="form-control input-sm" type="text" id="PasienNoMR" autocomplete="off" name="PasienNoMR" placeholder="Scan barcode Here" onchange="showIDMxR();" autocomplete="off"> -->
                                            </div>
                                            <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Pelayanan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-2">
                                                <select name="jnspelayanan" id="jnspelayanan" class="form-control input-sm" required>
                                                    <option value="">--Pilih--</option>
                                                    <option value="Inap">Rawat Inap</option>
                                                    <option value="Jalan">Rawat Jalan</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-primary">Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <h5 class="underline mt-30">Result</h5>
                            <div class="form-group">

                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>
<script>
    let iduser = ` <?= $data['session']->username ?>`
    let namauser = ` <?= $data['session']->name ?>`
</script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/LPK/stoploading.js"></script>