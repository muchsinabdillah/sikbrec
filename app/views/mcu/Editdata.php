<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <!-- <p class="sub-title">Silahkan Input Transaksi Disini.</p>   -->

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
                                <h5 class="underline mt-30">Edit <?= $data['judul'] ?></h5>
                            </div>
                            <?php
                            // var_dump($data['kodejasa']);
                            ?>
                        </div>
                        <div class="panel-body p-20">
                            <form class="" id="mcutarif">
                                <input type="hidden" name="idheader" id="idheader" value="<?= $data['detailmcu']['IDMCU'] ?>">
                                <div class="form-group">
                                    <label for="namapaket" class="col-sm-4 control-label"> Nama Paket <sup class="color-danger"></sup>
                                        <input type="text" class="form-control input-sm" readonly id="namapaket" name="namapaket" value="<?= $data['detailmcu']['NamaPaket'] ?>">
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-4 control-label"> Masa Berlaku <sup class="color-danger"></sup>
                                            <input type="date" class="form-control input-sm header" name="tglberlaku" id="tglberlaku" value="<?= $data['detailmcu']['AwalMasaBerlaku1'] ?>">
                                    </div>
                                    <div class=" form-group">
                                        <label for="namapaket" class="col-sm-4 control-label"> Sampai dengan <sup class="color-danger"></sup>
                                            <input type="date" class="form-control input-sm" name="akhirberlaku" id="akhirberlaku" value="<?= $data['detailmcu']['AkhirMasaBerlaku1'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namapaket" class="col-sm-12 control-label"> Tarif <sup class="color-danger"></sup>
                                        <input type="text" class="form-control input-sm" name="tarif" id="tarif" value="<?= $data['detailmcu']['Tarif'] ?>">
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Header <sup class="color-danger"></sup>
                                            <input type="checkbox" disabled name="header" id="header" <?php if ($data['detailmcu']['Header'] == 1) {
                                                                                                        ?>checked<?php
                                                                                                                } ?> value="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> EKG <sup class="color-danger"></sup>
                                            <input type="checkbox" name="ekg" id="ekg" <?php if ($data['detailmcu']['EKG'] == 1) {
                                                                                        ?>checked<?php
                                                                                                } ?> value="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Treadmil <sup class="color-danger"></sup>
                                            <input type="checkbox" name="treadmil" id="treadmil" <?php if ($data['detailmcu']['Treadmill'] == 1) {
                                                                                                    ?>checked<?php
                                                                                                            } ?> value="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Discontinue <sup class="color-danger"></sup>
                                            <input type="checkbox" name="discontinue" id="discontinue" <?php if ($data['detailmcu']['Discontinue'] == 1) {
                                                                                                        ?>checked<?php
                                                                                                                } ?> value="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Spirometri <sup class="color-danger"></sup>
                                            <input type="checkbox" name="spirometri" id="spirometri" <?php if ($data['detailmcu']['Spirometri'] == 1) {
                                                                                                        ?>checked<?php
                                                                                                                } ?> value="1">
                                    </div>

                                </div>
                                <div class="panel-title">
                                    <h5 class="underline mt-30">Tambah Item</h5>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-3 control-label"> Pemeriksaan <sup class="color-danger"></sup>
                                            <input type="text" class="form-control input-sm" id="pemeriksaan" name="pemeriksaan">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Lokasi Pemeriksaan <sup class="color-danger"></sup>
                                            <select name="lokasipemeriksaan" id="lokasipemeriksaan" class="form-control input-sm">
                                                <option value="">--Pilih Lokasi--</option>
                                                <option value="UNIT MCU">UNIT MCU</option>
                                                <option value="RADIOLOGI">RADIOLOGI</option>
                                                <option value="LABORATORIUM">LABORATORIUM</option>
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-4 control-label"> Pemeriksaan Penunjang <sup class="color-danger"></sup>
                                            <select name="pemeriksaanpenunjang" class="form-control input-sm" id="pemeriksaanpenunjang">
                                                <option value="">--Pilih--</option>
                                            </select>
                                            <input type="text" name="pemeriksaanpenunjang" id="pemeriksaanpenunjang" class="form-control input-sm lokasi">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Id Tes <sup class="color-danger"></sup>
                                            <input type="text" class="form-control input-sm" id="idtest" name="idtest">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-1 control-label"> Group Spes <sup class="color-danger"></sup>
                                            <input type="text" class="form-control input-sm" id="Group_Spesialis" name="Group_Spesialis">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Tarif Item <sup class="color-danger"></sup>
                                            <input type="text" class="form-control input-sm" id="tarifitem" name="tarifitem">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Show Jasa <sup class="color-danger"></sup>
                                            <select class="form-control input-sm" id="showjasa" name="showjasa">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-4 control-label"> Kode Jasa <sup class="color-danger"></sup>
                                            <select name="kodejasa" id="kodejasa" class="form-control input-sm">
                                                <option value="">--Pilih Kode Jasa--</option>
                                                <?php
                                                foreach ($data['kodejasa'] as $kodejasa) :
                                                ?>
                                                    <option value="<?= $kodejasa['KD_JASA'] ?>"><?= $kodejasa['KD_JASA'] ?>-<?= $kodejasa['NM_JASA'] ?></option>
                                                <?php
                                                endforeach;
                                                ?>

                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-4 control-label"> Kode Pendapatan <sup class="color-danger"></sup>
                                            <select name="kodependapatan" id="kodependapatan" class="form-control input-sm">
                                                <option value="">--Pilih Kode Jasa--</option>
                                                <?php
                                                foreach ($data['kodependapatan'] as $kodejasa) :
                                                ?>
                                                    <option value="<?= $kodejasa['KD_PDP'] ?>"><?= $kodejasa['KD_PDP'] ?>-<?= $kodejasa['NM_PDP'] ?></option>
                                                <?php
                                                endforeach;
                                                ?>

                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <!-- <label for="namapaket" class="col-sm-3 control-label"> Pemeriksaan Penunjang <sup class="color-danger"></sup> -->
                                        <button id="additempaketmcu" class="col-sm-3 form-control btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group">
                                <label for="namapaket" class="col-sm-4 control-label"> Cari Data<sup class="color-danger"></sup>
                                    <input type="text" class="form-control input-sm" name="caridata" id="caridata">
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <div class="table-responsive">
                                <table id="tableitempemeriksaan" class="table table-striped table-hover cell-border">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>Pemeriksaan</td>
                                            <td>Lokasi Pemeriksaan</td>
                                            <td>Pemeriksaan Penunjang</td>
                                            <td>Id Test</td>
                                            <td>Tarif Item</td>
                                            <td>Show Kode Jasa</td>
                                            <td>Kode Jasa</td>
                                            <td>Kode Pendapatan</td>
                                        </tr>
                                    </thead>
                                    <tbody id="listitempaketmcu">

                                    </tbody>
                                </table>
                            </div>
                            <button id="updatetarifmcu" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- modal -->
            <div class="modal fade" id="itemtarifmcumodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Udah data item MCU <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-horizontal" id="form_cuti">
                                <div class="form-group  ">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Pemeriksaan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="pemeriksaanmodal" autocomplete="off" name="pemeriksaanmodal" placeholder="ketik Kata Kunci disini">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Lokasi Pemeriksaan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <!-- <input class="form-control input-sm" type="text" id="lokasipemeriksaanmodal" autocomplete="off" name="lokasipemeriksaanmodal" placeholder="ketik Kata Kunci disini"> -->
                                        <select name="lokasipemeriksaanmodal" id="lokasipemeriksaanmodal" class="form-control input-sm">
                                            <!-- <option value="">--Pilih Lokasi--</option> -->
                                            <option value="UNIT MCU">UNIT MCU</option>
                                            <option value="RADIOLOGI">RADIOLOGI</option>
                                            <option value="LABORATORIUM">LABORATORIUM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Pemeriksaan Penunjang <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select class="form-control input-sm" id="peperiksaanpenunjangmodal" name="pemeriksaanpenunjangmodal">

                                        </select>
                                        <!-- <input class="form-control input-sm" type="text" id="peperiksaanpenunjangmodal" autocomplete="off" name="pemeriksaanpenunjangmodal" placeholder="ketik Kata Kunci disini"> -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> ID Test <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="idtestmodal" autocomplete="off" readonly name="idtestmodal" placeholder="ketik Kata Kunci disini">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Tarif Item <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="tarifitemmodal" autocomplete="off" name="tarifitemmodal" placeholder="ketik Kata Kunci disini">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Show kode Jasa <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select id="showkodejasamodal" class="form-control input-sm">
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                        <!-- <input class="form-control input-sm" type="text" id="showkodejasamodal" autocomplete="off" name="showkodejasamodal"> -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Kode Jasa <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="kodejasamodal" id="kodejasamodal" class="form-control input-sm">
                                            <?php
                                            foreach ($data['kodejasa'] as $kodejasa) :
                                            ?>
                                                <option value="<?= $kodejasa['KD_JASA'] ?>"><?= $kodejasa['KD_JASA'] ?>-<?= $kodejasa['NM_JASA'] ?></option>
                                            <?php
                                            endforeach;
                                            ?>

                                        </select>
                                        <!-- <input class="form-control input-sm" type="text" id="kodejasamodal" name="kodejasamodal"> -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Kode Pendapatan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="kodependapatanmodal" id="kodependapatanmodal" class="form-control input-sm">
                                            <?php
                                            foreach ($data['kodependapatan'] as $kodejasa) :
                                            ?>
                                                <option value="<?= $kodejasa['KD_PDP'] ?>"><?= $kodejasa['KD_PDP'] ?>-<?= $kodejasa['NM_PDP'] ?></option>
                                            <?php
                                            endforeach;
                                            ?>

                                        </select>
                                        <!-- <input class="form-control input-sm" type="text" id="kodejasamodal" name="kodejasamodal"> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group" role="group">
                                <button id="hapusitemmcumodal" class="btn btn-danger">Hapus Item </button>
                                <button type="button" class="btn btn-primary btn-wide btn-rounded" id="ubahitemmodal">Ubah Item</button>
                                <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>
<script>
    var PAKET = `<?= $data['namapaket'] ?>`
</script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/DataTables/datatables.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/sweet-alert/sweetalert.min.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>
<script src="<?= BASEURL ?>/js/App/mcu/edittarifmcu.js"></script>
<script src="<?= BASEURL ?>/js/App/mcu/caridata.js"></script>