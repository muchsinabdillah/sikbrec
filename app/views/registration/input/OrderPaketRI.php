<?php
date_default_timezone_set('Asia/Jakarta');
$id = "";
$datenowcreate = date("Y-m-d");
$datetimenow2222 = date("Y-m-d\TH:i:s");

?>
<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmSimpanTrs">
                                <h5 class="underline mt-30"><?= $data['judul'] ?></h5>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Informasi !</strong> Mohon pilih paket rawat inap dengan benar dan
                                            dicek
                                            terlebih dahulu, karena jika sudah diorder tidak bisa dibatalkan atau status
                                            order sudah LOCK! <br>
                                            <strong>Informasi !</strong> Silahkan tekan F5 untuk Refresh halaman.<br>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" id="NamaPasien" name="NamaPasien"
                                            type="text" readonly>
                                        <!-- <div id="error_nomr"></div> -->
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No. Registrasi
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="NoRegistrasi" readonly
                                            name="NoRegistrasi" type="text" placeholder="No. Registrasi"
                                            value="<?= $data['noregri'] ?>">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. MR </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" id="NoMR" name="NoMR" type="text" readonly>
                                        <div id="error_nomr"></div>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No. Episode
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="NoEpisode" readonly name="NoEpisode"
                                            type="text">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Kunjungan </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" id="DateStart" name="DateStart" type="text"
                                            readonly>
                                        <div id="error_nomr"></div>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Dokter</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="IdDokter" readonly name="IdDokter"
                                            type="hidden">
                                        <input class="form-control input-sm " id="NamaDokter" readonly name="NamaDokter"
                                            type="text">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" id="TglLahir" name="TglLahir" type="text"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Hak kelas </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" id="NamaKelas" name="NamaKelas" type="text"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> kelas ID </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" id="HakKelas" name="HakKelas" type="text"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID Paket</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="IdPaket1" readonly name="IdPaket1"
                                            type="text">
                                    </div>
                                    <!-- <div class="col-sm-4">
                                        <input class="form-control input-sm " id="IdPaket1" readonly name="IdPaket1" type="text">
                                    </div> -->
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" id="JenisKelamin" name="JenisKelamin"
                                            type="text" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" id="Alamat" name="Alamat" type="hidden"
                                            readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" id="TipePasien" name="TipePasien"
                                            type="hidden" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" id="KodeLokasi" name="KodeLokasi"
                                            type="hidden" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" id="NamaRuangan" name="NamaRuangan"
                                            type="hidden" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" id="NamaPerusahaan" name="NamaPerusahaan"
                                            type="hidden" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut mt-50">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Paket <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select class="form-control input-sm" name="IDPemeriksaan" id="IDPemeriksaan"
                                            onchange="getTarifPaketRI(this.value);">
                                        </select>
                                        <input class="form-control input-sm" type="hidden" id="namapaket" readonly
                                            name="namapaket">
                                        <input class="form-control input-sm" type="hidden" id="Lab_kodeTes_kelompok"
                                            readonly name="Lab_kodeTes_kelompok">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;">
                                        Nilai Tarif Paket<sup class="color-danger">*</sup> </label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="HargaPaket" name="HargaPaket"
                                            type="text" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" id="btnOrder" name="btnOrder"
                                            class="btn btn-primary btn-sm">
                                            Pilih dan Order Paket
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;">
                                        Status </label>
                                    <div class="col-sm-4">
                                        <span id="StatusOrder" name="StatusOrder" class="badge"></span>
                                    </div>
                                </div>
                        </div>
                        </form>

                        <div class="form-group m-20">

                            <hr>
                            <h5 class="underline mt-30">DATA DETAILS ORDER PAKET RAWAT INAP</h5>
                            <div class="table-responsive">
                                <table id="table-load-data-paket-ri" class="table table-striped table-hover cell-border"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <th>Deskripsi</th>
                                            <th>Kelompok Item(s)</th>
                                            <th>QTY</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>



<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/registration/input/OrderPaketRI.js"></script>