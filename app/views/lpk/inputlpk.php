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
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi </small></h5>

                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <h5 class="underline mt-30">Data Pasien Berobat (SIMRS)</h5>
                                <div class="form-group  asdas">
                                    <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Sudah Punya No MR <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="nomormr" id="nomormr" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                        <!-- <input class="form-control input-sm" type="hidden" id="TglNowTemp" value="<?= $datetimenow2222 ?>" readonly autocomplete="off" name="TglNowTemp"> -->
                                        <!-- <input class="form-control input-sm" type="text" id="PasienNoMR" autocomplete="off" name="PasienNoMR" placeholder="Scan barcode Here" onchange="showIDMxR();" autocomplete="off"> -->
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="jeniskelamin" id="jeniskelamin" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group nomrdanttl gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> NO. RM <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="Normpasien" readonly name="Normpasien" type="text" placeholder="Normpasien">

                                    </div>
                                    <div class="col-sm-2">
                                        <a href="#myModal" data-toggle="modal" class="btn btn-primary btn-sm btn-rounded " id="btn_caridatamr">
                                            <span class="glyphicon glyphicon glyphicon-search"></span></a>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> TTL Pasien <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="PasienUsia" name="PasienUsia" type="date" onchange="umurpasien(event)" placeholder="Ketik Usia Pasien">
                                    </div>
                                </div>
                                <div class="form-group namapasienusia gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="PasienNama" name="PasienNama" type="text" placeholder="Ketik Nama Pasien" onkeyup="namePatient()" required>
                                        <span id='errorPatienname'></span>

                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Usia <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="umur" name="umur" type="text" placeholder="Ketik Usia Pasien">
                                    </div>
                                </div>
                                <div class="form-group alamat gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat <sup class="color-danger">*</sup></label>
                                    <!-- <label for="inputEmail3" class="col-sm-2 control-label"> Alamat </label> -->
                                    <div class="col-sm-4">
                                        <textarea class="form-control input-sm" id="PasienAlamat" name="PasienAlamat" rows="4" style="resize: none" required></textarea>
                                        *) Jika ada perubahan data Rekam Medik Seperti Alamat, tgl lahir, dan lain-lain silahkan rubah dari menu Medical record dan refresh kembali halaman ini.
                                    </div>
                                    <div class="col-sm-6">
                                        <label for=" inputEmail3" class="col-sm-4 control-label"> Pekerjaan </label>
                                        <div class="col-sm-8">
                                            <input class="form-control input-sm " id="PasienPekerjaan" name="PasienPekerjaan" type="text" placeholder="Jika tidak punya isi dengan (-)" required>
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-4 control-label"> Nik </label>
                                        <div class="col-sm-8">
                                            <input class="form-control input-sm " id="nik" name="nik" type="text" placeholder="Jika tidak punya isi dengan (-)" required>
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-4 control-label"> Home Phone </label>
                                        <div class="col-sm-8">
                                            <input class="form-control input-sm " id="homephone" name="homephone" type="text" placeholder="Ketik Nomor TLP" required>
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-4 control-label"> Mobile Phone </label>
                                        <div class="col-sm-8">
                                            <input class="form-control input-sm " id="mobilephone" name="mobilephone" type="text" placeholder="Ketik Mobile Phone Pasien" required>
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-4 control-label"> Email </label>
                                        <div class="col-sm-8">
                                            <input class="form-control input-sm " id="email" name="email" type="email" placeholder="Ketik Email Pasien" required>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="underline mt-30">RESERVASI PASIEN RS YARSI</h5>
                                <div class="form-group jenispembayaran gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nomor Booking <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <div class="col-sm-6">
                                            <input class="form-control input-sm" type="text" id="PasienNoBooking" name="PasienNoBooking" placeholder="Scan barcode Here">
                                            <input class="form-control input-sm" type="hidden" id="PasienJenisDaftar" name="PasienJenisDaftar">
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="#modalcariDataReservasi" data-toggle="modal" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span></a>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group jenispembayaran gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Pembayaran <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="pembayaran" id="pembayaran" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                            <option value="1">Pribadi</option>
                                            <option value="2">Asuransi</option>
                                            <option value="5">Jaminan Perusahaan</option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Dokter <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="dokter" id="dokter" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group poliklinik gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Poliklinik <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="poliklinik" id="poliklinik" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                            <option value="9">Laboratorium</option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jam Praktek <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="jampraktek" id="jampraktek" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group shiftpraktek gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Reservasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="tglreservasi" name="tglreservasi" type="date" placeholder="Ketik Usia Pasien" onchange="hari(event);" required>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Shift Praktek <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="shiftpraktek" id="shiftpraktek" class="form-control input-sm" required>
                                            <option value="">--Pilih--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group antrian gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Antrian </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="antrian" readonly name="antrian" type="text" placeholder="No. Antrian Pasien">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="new" readonly name="new" type="text">
                                    </div>
                                </div>
                                <div class="form-group keterangan gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Keterangan </label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control input-sm" id="Keterangan" name="Keterangan" rows="4" style="resize: none" required></textarea>
                                    </div>
                                    <div class="col-sm-6 mt-30">

                                        <label for="inputEmail3" class="col-sm-4 control-label"> </label>


                                        <div class="btn-group" role="group">
                                            <button class="btn btn-success  btn-rounded " id="btnsimpan">
                                                Simpan</button>
                                            <!-- <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'> Simpan</button> -->
                                            <a href="#modal_alert_batal" data-toggle="modal" class="btn btn-danger  btn-rounded" onclick="getNobokingalasan()">Batal</a>
                                            <!-- <a class="btn btn-danger  btn-rounded " id="batal" name="batal" data-target="#modal_alert_batals" data-toggle='modal'>
                                                Batal</a> -->
                                            <!-- <button class="btn btn-secondary  btn-rounded " id="close" name="close" >
                                                Close</button> -->
                                            <a class="btn btn-secondary  btn-rounded" href=" <?= BASEURL ?>/aReservasiPasienWalkin">Close</a>
                                        </div>
                            </form>


                        </div>
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







<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script>
    let iduser = ` <?= $data['session']->username ?>`
    let namauser = ` <?= $data['session']->name ?>`
    let idpasien = `<?= $data['id'] != null ? $data['id'] : '' ?>`
</script>
<script src="<?= BASEURL; ?>/js/App/LPK/stoploading.js"></script>