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
                                <h5 class="underline mt-30">Judul <?= $data['judul'] ?> </h5>
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <form class="" id="mcutarif">
                                <div class="form-group">
                                    <label for="namapaket" class="col-sm-4 control-label"> Nama Paket <sup class="color-danger"></sup>
                                        <input type="text" class="form-control input-sm" id="namapaket" name="namapaket">
                                        <div id="warning"></div>

                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-4 control-label"> Masa Berlaku <sup class="color-danger"></sup>
                                            <input type="date" class="form-control input-sm header" name="tglberlaku" id="tglberlaku">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-4 control-label"> Sampai dengan <sup class="color-danger"></sup>
                                            <input type="date" class="form-control input-sm" name="akhirberlaku" id="akhirberlaku">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namapaket" class="col-sm-12 control-label"> Tarif <sup class="color-danger"></sup>
                                        <input type="text" class="form-control input-sm" name="tarif" id="tarif">
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Header <sup class="color-danger"></sup>
                                            <input type="checkbox" name="header" id="header" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> EKG <sup class="color-danger"></sup>
                                            <input type="checkbox" name="ekg" id="ekg" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Treadmil <sup class="color-danger"></sup>
                                            <input type="checkbox" name="treadmil" id="treadmil" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Discontinue <sup class="color-danger"></sup>
                                            <input type="checkbox" name="discontinue" id="discontinue" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-2 control-label"> Spirometri <sup class="color-danger"></sup>
                                            <input type="checkbox" name="spirometri" id="spirometri" value="1">
                                    </div>

                                </div>
                                <h5 class="underline mt-30">Item Pemeriksaan</h5>
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
                                        <label for="namapaket" class="col-sm-4 control-label"> Show Cetakan <sup class="color-danger"></sup>
                                            <select name="showcetakan" id="showcetakan" class="form-control input-sm">
                                                <option value="">-- Pilih --</option>
                                                <option value="1">YA</option> 
                                                <option value="0">TIDAK</option> 
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="namapaket" class="col-sm-4 control-label"> Nama Spesialisasi <sup class="color-danger"></sup>
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
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <!-- <label for="namapaket" class="col-sm-3 control-label"> Pemeriksaan Penunjang <sup class="color-danger"></sup> -->
                                        <button id="additempaketmcu" class="col-sm-3 form-control btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel-body p-20">
                            <div class="table-responsive">
                                <table id="tableinput" class="table table-striped table-hover cell-border">
                                    <thead>
                                        <tr>
                                            <td>Pemeriksaan</td>
                                            <td>Lokasi Pemeriksaan</td>
                                            <td>Pemeriksaan Penunjang</td>
                                            <td>Id Test</td>
                                            <td>Tarif Item</td>
                                            <td>Show Kode Jasa</td>
                                            <td>Kode Jasa</td>
                                            <td>Kode Pendapatan</td>
                                            <td>Hapus</td>
                                        </tr>
                                    </thead>
                                    <tbody id="listitempaketmcu">

                                    </tbody>
                                </table>
                            </div>
                            <button id="simpantarifmcu" class="btn btn-success">Simpan</button>
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
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/DataTables/datatables.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/sweet-alert/sweetalert.min.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>
<script src="<?= BASEURL ?>/js/App/mcu/datatabletarifmcu.js"></script>