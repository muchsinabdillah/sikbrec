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
                                <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi
                                    </small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <h5 class="underline mt-30">DATA REKAM MEDIK</h5>
                                <div class="form-group  ">
                                    <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>">
                                    <input class="form-control input-sm " id="iswalkin" readonly name="iswalkin" type="hidden" value="<?= $data['jenispasien'] ?>">
                                    <input class="form-control input-sm " id="idodc" readonly name="idodc" type="hidden" value="<?= $data['idodc'] ?>">
                                    <input class="form-control input-sm " id="noregistrasi_odc" readonly name="noregistrasi_odc" type="hidden" >
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No.RM <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="hidden" id="TglNowTemp" value="<?= $datetimenow2222 ?>" readonly autocomplete="off" name="TglNowTemp">
                                        <input class="form-control input-sm" type="hidden" id="IsVerifBPJSPesertax" readonly autocomplete="off" name="IsVerifBPJSPesertax" placeholder="Scan barcode Here">
                                        <input class="form-control input-sm" type="text" id="PasienNoMR" autocomplete="off" name="PasienNoMR" placeholder="Scan barcode Here" onchange="showIDMxR();" autocomplete="off">
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group" role="group">
                                            <a href="#myModal" data-toggle="modal" class="btn btn-primary btn-sm btn-rounded " id="btn_caridatamr">
                                                <span class="glyphicon glyphicon glyphicon-search"></span></a>
                                            <a href="#ModalInputMRBAru" id="btnCreateNewMR" name="btnCreateNewMR" data-toggle="modal" class="btn btn-success btn-sm btn-rounded">
                                                <span class="glyphicon glyphicon glyphicon glyphicon-plus"></span></a>
                                        </div>

                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" type="text" autocomplete="off" id="PasienIdJKel" readonly name="PasienIdJKel">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="PasienNamaJKel" readonly name="PasienNamaJKel">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. IHS Satu Sehat <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" readonly type="text" id="idMrkemkes" name="idMrkemkes" placeholder="idMrkemkes">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pasien <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" readonly type="text" id="PasienJenisDaftar" name="PasienJenisDaftar" placeholder="Jenis Pasien">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> TTL Pasien <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="PasienTptLahir" readonly name="PasienTptLahir" type="text" placeholder="Ketik Tpt Lahir Pasien">
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="PasienTglLahir" readonly name="PasienTglLahir" type="text" placeholder="Ketik Tgl Lahir Pasien">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="PasienNama" readonly name="PasienNama" type="text" placeholder="Ketik Nama Pasien">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Usia <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="PasienUsia" readonly name="PasienUsia" type="text" placeholder="Ketik Usia Pasien">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Alamat </label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control input-sm" id="PasienAlamat" readonly name="PasienAlamat" rows="4" style="resize: none"></textarea>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Pekerjaan </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="PasienPekerjaan" readonly name="PasienPekerjaan" type="text" placeholder="Ketik Pekerjaan Pasien">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> NIK </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="PasienNIK" readonly name="PasienNIK" type="text" placeholder="Ketik NIK Pasien">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;">
                                        NIK Karyawan </label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="PasienNIK_Karyawan" readonly name="PasienNIK_Karyawan" type="text" placeholder="Ketik NIK Karyawan">
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="PasienNIK_StatusPeserta" readonly name="PasienNIK_StatusPeserta" type="text" placeholder="Ketik Status Peserta">
                                    </div>
                                </div>
                                <div id="admiedika">
                                    <h5 class="underline mt-30">DATA VALIDASI ADMEDIKA</h5>
                                    <div class="form-group  ">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Coverage Type<sup class="color-danger">*</sup></label>
                                        <div class="col-sm-4">
                                            <select class="form-control input-sm" name="admcoveragetype" id="admcoveragetype">
                                                <option value="">-PILIH-</option>
                                                <option value="01">RAWAT INAP</option>
                                                <option value="02">RAWAT JALAN</option>
                                                <option value="03">PRE & POST</option>
                                                <option value="04">KACAMATA</option>
                                                <option value="05">RAWAT GIGI</option>
                                                <option value="06">PERSALINAN</option>
                                                <option value="07">LABORATORY</option>
                                                <option value="08">PHARMACY/APOTEK</option>
                                            </select>
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-2 control-label"> Payor ID <sup class="color-danger">*</sup></label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" type="text" autocomplete="off" id="admpayorMemberID" name="admpayorMemberID">
                                        </div>
                                    </div>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Cek ELIGIBILITY <sup class="color-danger">*</sup></label>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" type="text" id="admcardNo" name="admcardNo" placeholder="Masukan No. Kartu">
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="btn btn-primary btn-sm" type="button" id="btninquiry" name="btninquiry">INQUIRY</button>
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-2 control-label"> Policy Date <sup class="color-danger">*</sup></label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm " id="admpolicyDate" readonly name="admpolicyDate" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Peserta <sup class="color-danger">*</sup></label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm " id="admpatientName" readonly name="admpatientName" type="text">
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-2 control-label"> Plan Code <sup class="color-danger">*</sup></label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm " id="admplanCode" readonly name="admplanCode" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Admedika Claim ID
                                        </label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm " id="admclID" readonly name="admclID" type="text" placeholder="Admedika Claim ID">
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-2 control-label"> Status Peserta
                                        </label>
                                        <div class="col-sm-1">
                                            <input class="form-control input-sm " id="admclStatus" readonly name="admclStatus" type="text" placeholder="Status">
                                        </div>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm " id="admclDesc" readonly name="admclDesc" type="text" placeholder="Status">
                                        </div>
                                    </div>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Payor Name </label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm " id="admPayorName" readonly name="admPayorName" type="text" placeholder="Payor Name">
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Payor ID </label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm " id="admpayorMemberID" readonly name="admpayorMemberID" type="text" placeholder="Payor ID">
                                        </div>
                                    </div>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Policy No </label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm " id="admpolicyNo" readonly name="admpolicyNo" type="text" placeholder="Policy No">
                                        </div>
                                        <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Keterangan </label>
                                        <div class="col-sm-4">
                                            <textarea class="form-control" id="admketstatus" readonly name="admketstatus" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="underline mt-30">DATA REGISTRASI POLIKLINIK</h5>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Cari Poliklinik</label>
                                    <div class="col-sm-4">
                                        <select class="col-sm-10 js-example-basic-single" name="poliklinik" id="poliklinik" onchange="getDokter();resetsession();">
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID Poli Kemenkes</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="idUnitKemkes" readonly name="idUnitKemkes">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Poliklinik <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" type="text" id="poliklinikid" readonly name="poliklinikid">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="shownamapolifix" readonly name="shownamapolifix">
                                        <input class="form-control input-sm" type="text" id="RefPoliBPjs" readonly name="RefPoliBPjs">
                                        <input class="form-control input-sm" type="hidden" id="RefPoliSimrs" readonly name="RefPoliSimrs">
                                        <input class="form-control input-sm" type="hidden" id="RefKodePoliSimrs" readonly name="RefKodePoliSimrs">
                                        <div id="show_notif_poliklinik"></div>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Reservasi </label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="pxNoReservasi" readonly name="pxNoReservasi" placeholder="Ketik No. Reservasi">
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="#modalcariDataReservasi" data-toggle="modal" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span></a>

                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Cari Dokter</label>
                                    <div class="col-sm-4">
                                        <select class="col-sm-10 js-example-basic-single" name="dokter" id="dokter" onchange="getDoktername();resetsession();">
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID Dokter Kemenkes</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="idDoktertKemkes" readonly name="idDoktertKemkes">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Dokter <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" type="text" id="dokterid" readonly name="dokterid">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="shownamdokterfix" readonly name="shownamdokterfix">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Episode</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="pxnoEpisode" readonly name="pxnoEpisode" placeholder="Ketik No. Episode">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Jaminan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="hidden" id="grupJaminanid" readonly name="grupJaminanid">
                                        <select class="col-sm-10" name="grupJaminan" id="grupJaminan" onchange="getjaminannama();getidjenisjaminan(this)">
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Registrasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="pxNoRegistrasi" readonly name="pxNoRegistrasi" type="text" placeholder="Ketik No. Registrasi">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Cari Jaminan</label>
                                    <div class="col-sm-4">
                                        <select class="col-sm-10" name="namajaminan" id="namajaminan" onchange="loadkartujaminan();getidnamajaminan(this);getJamPraktek(this.value);resetsession();">
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Id Reg Kemnkes</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="idRegKemenkes" readonly name="idRegKemenkes" type="text" placeholder="Ketik No. Registrasi Kemenkes">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Jaminan <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" type="text" id="namajaminanid" readonly name="namajaminanid">
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="shownamaperusahaanfix" readonly name="shownamaperusahaanfix">
                                        <div id="show_notif_pilih_jaminan"></div>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. SEP <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="pxNoSep" name="pxNoSep" type="text" placeholder="Ketik No. SEP" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Registrasi </label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="datetime-local" id="tglregistrasi" name="tglregistrasi" value="<?= $datetimenow2222 ?>" step="1">
                                    </div>

                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Antrian</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="pxNoAntrian" readonly name="pxNoAntrian" type="text" placeholder="No. Antrian Pasien">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jam Praktek</label>
                                    <div class="col-sm-2">
                                        <select class="form-control input-sm " name="Jampraktek" id="Jampraktek" class="form-control" onchange="GetSession(this)">
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" id="refreshjadwal" name="refreshjadwal" class="btn btn-primary btn-sm">
                                            <i class="fa fa-refresh"></i>Refresh Jam Praktek</button>

                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Note Registrasi</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="pxNoteRegistrasi" name="pxNoteRegistrasi" type="text" placeholder="Masukan Note Registrasi">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama COB </label>
                                    <div class="col-sm-4">
                                        <select class="form-control input-sm " name="COB" id="COB">
                                        </select>
                                    </div>

                                </div>


                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Session Poli/Tgl </label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="NamaSesionPraktek" readonly name="NamaSesionPraktek" type="text" placeholder="Sesion Praktek">
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="text" id="tglnow" readonly name="tglnow" value="<?= $datenowcreate ?>">
                                    </div>

                                </div>


                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Cara Masuk <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="hidden" id="caramasukid" readonly name="caramasukid">
                                        <select class="col-sm-9" name="caramasuk" id="caramasuk" onchange="getreferal();getdatacaramasuk(this)">
                                        </select>
                                        <input class="form-control input-sm" type="hidden" id="showcaramasukfix" readonly name="showcaramasukfix">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tipe Registrasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select class="col-sm-9" name="tiperegistrasi" id="tiperegistrasi">
                                            <option value=""></option>
                                            <option value="1">WALKIN</option>
                                            <option value="2">DRIVE THRU</option>
                                            <option value="3">MEDIVAC</option>
                                            <option value="4">ONSITE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Cari Referral</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="referral" id="referral" onchange="getreferalname();getadministrasinilai()">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Referral <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm" type="text" id="referralid" readonly name="referralid">
                                    </div>
                                    <div class="col-sm-3">

                                        <input class="form-control input-sm" type="text" id="showrefferalfix" readonly name="showrefferalfix">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Administrasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="hidden" id="jenisadministrasiid" readonly name="jenisadministrasiid">

                                        <select class="col-sm-9 js-example-basic-single" name="jenisadministrasi" id="jenisadministrasi" onchange="getadministrasinilai()">
                                        </select>
                                        <input class="form-control input-sm" type="hidden" id="showadministrasifix" readonly name="showadministrasifix">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nilai Administrasi <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="jenisadminnilai" readonly name="jenisadminnilai">
                                    </div>
                                </div>
                            </form>
                            <div class="btn-group" role="group">
                                <button class="btn btn-primary  btn-rounded " id="btnsendantrian" name="btnsendantrian" href="#modal_AntrolJenisKunungan" data-toggle='modal'>
                                    <i class="fa fa-save"></i>Send Antrian BPJS</button>
                                <button class="btn btn-success  btn-rounded " id="btnprint" name="btnprint">
                                    <i class="fa fa-print"></i> PRINT/ORDER PENUNJANG</button>
                                <button class="btn btn-warning  btn-rounded " id="btnSepCeki" name="btnSepCeki" href="#modal_BPJSCekPesertaa" data-toggle='modal'>
                                    <i class="fa fa-edit"></i> SEP</button>
                                <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'>
                                    <i class="fa fa-save"></i>Simpan</button>
                                <button class="btn btn-danger  btn-rounded " onclick="Passingbatal()" id="batal" name="batal" href="#modal_alert_batal" data-toggle='modal'>
                                    <i class="fa fa-close"></i> Batal</button>
                                <button class="btn btn-secondary  btn-rounded " id="close" name="close" onclick="MyBack()">
                                    <i class="fa fa-mail-reply-all"></i> Close</button>
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
<!-- /.main-page -->
<div class="right-sidebar bg-white fixed-sidebar">
    <div class="sidebar-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Useful Sidebar <i class="fa fa-times close-icon"></i></h4>
                    <p>Code for help is added within the main page. Check for code below the example.</p>
                    <p>You can use this sidebar to help your end-users. You can enter any HTML in this sidebar.</p>
                    <p>This sidebar can be a 'fixed to top' or you can unpin it to scroll with main page.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <!-- /.col-md-12 -->

                <div class="text-center mt-20">
                    <button type="button" class="btn btn-success btn-labeled">Purchase Now<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                </div>
                <!-- /.text-center -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.sidebar-content -->
</div>
<!-- /.right-sidebar -->

</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Rekam Medik Pasien <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong> Untuk Pencarian bisa Dilakukan Pencarian dengan Nama, No. MR, Tgl Lahir,
                        Alamat, dll.</p>
                    <p> <strong>Info !</strong> Untuk Pencarian dengan Tanggal Lahir silahhkan ketik dengan cara
                        dd/mm/yyyy.</p>
                    <p> <strong>Info !</strong> Contoh : 01/01/1991.</p>
                    <p> <strong>Info !</strong> Untuk Pencarian dengan No. MR Contoh :00-00-01.</p>
                </div>
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">

                        <label for="inputEmail3" class="col-sm-3 control-label"> Masukan Kata Kunci <sup class="color-danger">*</sup></label>
                        <div class="col-sm-3">
                            <select id="cmbxcrimr" name="cmbxcrimr" style="width: 100%;" class="form-control ">
                                <option value="1">NAMA PASIEN</option>
                                <option value="2">TGL LAHIR</option>
                                <option value="3">NO. MR</option>
                                <option value="4">ALAMAT</option>
                                <option value="5">NO. IDENTITAS</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="txSearchData" autocomplete="off" name="txSearchData" placeholder="ketik Kata Kunci disini">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="btnSearchMrAktif" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-load-data" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>No MR</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Lahir</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="myModalFinger" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Verifikasi Fingerprint Peserta<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong> Untuk Pembuatan SEP ke Poli Mata, Jantung, IRM, Hemodialisa harus
                        verifikasi Fingerprint.</p>
                </div>
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No. Kartu <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="FingerNoKartu" autocomplete="off" name="FingerNoKartu" placeholder="ketik No. Kartu disini">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> Tgl SEP <sup class="color-danger">*</sup></label>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" type="date" id="FingerTgl" autocomplete="off" name="FingerTgl" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group form-horizontal gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Status Finger <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <span style="margin-left: 10px;" class="label label-success" id="FingerStatus"></span>

                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="btnFingerSearch" class="btn btn-primary btn-wide btn-rounded"><i class="fa fa-refresh"></i>Refresh</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-finger" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>No Kartu</th>
                                <th>No. SEP</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-warning btn-wide btn-rounded" id="btnModalSrcfingerClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Modal Batal Registrasi -->
<div class="modal fade" id="modal_alert_batal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Batal Registrasi</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmBatalReg">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. Registrasi</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="noregbatal" readonly autocomplete="off" name="noregbatal" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. SEP</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="nosepbatal" readonly autocomplete="off" name="nosepbatal" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Tanpa Batal SEP</label>
                        <div class="col-sm-6">
                            <select id="tanapsepBatal" name="tanapsepBatal" style="width: 100%;" class="form-control ">
                                <option value="0">TIDAK</option>
                                <option value="1">YA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="alasanbatal" minlength="20" name="alasanbatal" rows="3"></textarea>
                            <span><b>AGAR MUDAH DI VERIFIKASI DI KEMUDIAN HARI, MOHON MASUKAN ALASAN BATAL DENGAN JELAS !. Contoh :</b></span>
                            <span><b>Dibatalkan karena pasien tidak jadi berobat. Sudah konfirmasi perawat xx</b></span>
                        </div>
                       
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnVoidTrsReg" name="btnVoidTrsReg"><i class="fa fa-plus"></i> Batal </button>
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Batal Registrasi -->
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_BPJSCekPesertaa" role="dialog" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Verifikasi Kepesertaan BPJS Kesehatan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjsx">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pasien <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisxPasienBPJS" nama="JenisxPasienBPJS" class="form-control input-sm">
                                <option value="2">Rawat Jalan</option>
                                <option value="1">IGD/Ranap</option>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> Rujukan Dari <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisRujukanFaskesBPJSx" nama="JenisRujukanFaskesBPJSx" class="form-control input-sm">
                                <option value="1">Faskes 1</option>
                                <option value="2">Faskes 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Cari Berdasarkan <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisPencarianBPJS" nama="JenisPencarianBPJS" class="form-control input-sm">
                                <option value="3">No. RUJUKAN</option>
                                <option value="1">NIK</option>
                                <option value="2">KARTU PESERTA</option>
                            </select>
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> No. Kartu/KTP/RJ <sup class="color-danger">*</sup></label>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" autocomplete="off" type="text" id="idPesertaBPJS" name="idPesertaBPJS">
                        </div>
                        <div class="col-sm-1" style="margin-left: -25px;">
                            <button class="btn btn-danger btn-sm" type="button" id="btnCekRujukanMulti" name="btnCekRujukanMulti">Kartu</button>
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Asal <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id='cariPPKRujukanBPJS2' style="width: 100%;" class="form-control " name='cariPPKRujukanBPJS2'>
                                <option value='0'>- Search PPK Rujukan -</option>
                            </select>
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> </label>
                        <div class="col-sm-4">
                            <button class="btn btn-primary btn-sm" type="button" id="btnCekKepesertaan" name="btnCekKepesertaan"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default btn-sm" type="button" id="btnCloseVerifikasi" name="btnCloseVerifikasi"><i class="fa fa-mail-reply-all"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_BPJSCekRujukanMulti" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Verifikasi Kepesertaan BPJS Kesehatan Multi</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjsx">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-3 control-label"> No. Kartu <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="MultiNoKartu" autocomplete="off" name="MultiNoKartu" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-3 control-label"></label>
                        <div class="col-sm-2">
                            <button type="button" id="btnCariRujukanMulti" name="btnCariRujukanMulti" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                    <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                        <table id="tbl_kunjungan_monitoring" width="100%" class="table table-striped table-hover cell-border">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        <font size="1">No Rujukan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Keluhan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Tgl Kunjungan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Diagnosa
                                    </th>
                                    <th align='center'>
                                        <font size="1">Jenis Pelayanan
                                    </th>
                                    <th align='center'>
                                        <font size="1">Poli Rujukan
                                    </th>
                                    <th align='center'>
                                        <font size="1">PPK Perujuk
                                    </th>
                                    <th align='center'>
                                        <font size="1">Nama Pasien
                                    </th>
                                    <th align='center'>
                                        <font size="1">Kode Peserta
                                    </th>
                                    <th align='center'>
                                        <font size="1">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseVerifKartu" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Batal Registrasi -->
<div class="modal fade" id="modal_AntrolJenisKunungan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Send Antrian BPJS Kesehatan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmBatalReg">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Jenis Kunjungan</label>
                        <div class="col-sm-6">
                            <select id="AntrolJenisKunungan" name="AntrolJenisKunungan" style="width: 100%;" class="form-control ">
                                <option value="">-- PILIH JENIS KUNJUNGAN --</option>
                                <option value="1">Rujukan FKTP</option>
                                <option value="2">Rujukan Internal</option>
                                <option value="3">Kontrol</option>
                                <option value="4">Rujukan Antar RS</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnSendAntrol" name="btnSendAntrol"><i class="fa fa-plus"></i> Send </button>
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnSendAntrolClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Batal Registrasi -->
<div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cetak Registrasi Pasien dan Order Penunjang</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak Bukti Registrasi</strong></p><br>
                        <form id="TheForm" method="post" action="halaman/Print/print_bukti_reg.php" target="TheWindow">
                            <input type="hidden" name="cetaknoregis" id="cetaknoregis" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoPasienUmum.Png" id="logocetakbuktireg" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak LOA </strong></p><br>
                        <form id="TheForm2" method="post" action="halaman/Print/print_bukti_loa_admedika.php" target="TheWindow2">
                            <input type="hidden" name="cetaknoregis2" id="cetaknoregis2" />
                            <input type="hidden" name="namajaminanlab" id="namajaminanlab" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/ADMEDIKA.png" id="logocetakbuktiloa" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak Label Pasien</strong></p><br>
                        <form id="TheForm3" method="post" action="halaman/Print/print_label_pasien.php" target="TheWindow3">
                            <input type="hidden" name="cetaklabel" id="cetaklabel" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenisPrint/kartu-identitas.Png" id="logocetaklabelpasien" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak SEP</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoBPJS.Png" id="logocetakbuktiSEP" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak Gelang Anak</strong></p><br>
                        <form id="TheForm4" method="post" action="halaman/Print/print_gelang_anak.php" target="TheWindow4">
                            <input type="hidden" name="cetakgelanganak" id="cetakgelanganak" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenisPrint/baby.jpg" id="logocetakgelanganak" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak Gelang Dewasa</strong></p><br>
                        <form id="TheForm5" method="post" action="halaman/Print/print_gelang_dewasa.php" target="TheWindow5">
                            <input type="hidden" name="cetakgelangdewasa" id="cetakgelangdewasa" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/jenisPrint/wristband.png" id="logocetakgelangdewasa" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnInputTrsOrderRad" name="btnInputTrsOrderRad"><i class="fa fa-plus"></i> RADIOLOGI </button>
                    <button type="button" class="btn btn-danger btn-wide btn-rounded" id="btnInputTrsOrderLab" name="btnInputTrsOrderLab"><i class="fa fa-times"></i>LABORATORIUM</button>
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnInputTrsOrderMCU" name="btnInputTrsOrderMCU"><i class="fa fa-times"></i>MCU</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnInputFormEdukasi" name="btnInputFormEdukasi"><i class="fa fa-times"></i>Form Edukasi Pasien</button>
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnclosemodalcetak" name="btnclosemodalcetak"><i class="fa fa-times"></i>CLOSE</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Batal Registrasi -->
<div class="modal fade" id="notif_ShowTTD_Digital" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Show Sign Digital </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmDigitalSign">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. Registrasi</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signNoRegistrasi" readonly autocomplete="off" name="signNoRegistrasi">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. SEP</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signNoSep" readonly autocomplete="off" name="signNoSep">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Nama Pasien/Keluarga</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signNama" autocomplete="off" name="signNama" readonly placeholder="ketik Nama Pasien/Keluarga disini">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Cetak Tanpa Digital Sign</label>
                        <div class="col-sm-6">
                            <select id="tanpaDigitalSign" name="tanpaDigitalSign" style="width: 100%;" class="form-control" onchange="gotanpaDigitalSign();">
                                <option value="0">TIDAK</option>
                                <option value="1">YA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Cetak</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signAlasanCetak" autocomplete="off" name="signAlasanCetak" placeholder="ketik Alasan Cetak disini">
                            <small>Silahkan Masukan Alasan cetak selengkap mungkin, untuk memudahkan Tracing
                                Data.</small>
                        </div>

                    </div>
                    <div class="form-group gut ">
                        <div class="col-sm-4" style="margin-left: 30px;">
                            <div id="ImagesDigitalSEP"></div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-warning btn-wide btn-rounded" id="btnRefreshSign" name="btnRefreshSign"><i class="fa fa-refresh"></i> REFRESH </button>
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btncetakSep" name="btncetakSep"><i class="fa fa-print"></i> PRINT </button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalcariDataReservasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Reservasi <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong> Data Reservasi yang Muncul adalah data reservasi pada hari ini.</p>
                    <p> <strong>Info !</strong> Silahkan klik tombol search untuk menampilkan data reservasi hari ini.
                    </p>
                </div>
                <form class="form-horizontal" id="form_cuti">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-3 control-label"> Periode <sup class="color-danger">*</sup></label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="tglawal_Search" id="tglawal_Search">
                        </div>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="tglakhir_Search" id="tglakhir_Search">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-default btn-rounded" id="btnCariReservasi" name="btnCariReservasi">
                                <span class="glyphicon glyphicon-search"></span> Search
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="table-load-data-reservasi" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th align='center'>
                                    No
                                </th>
                                <th align='center'>
                                    No. MR
                                </th>
                                <th align='center'>
                                    Nama Pasien
                                </th>
                                <th align='center'>
                                    Tgl Booking
                                </th>
                                <th align='center'>
                                    Poliklinik
                                </th>
                                <th align='center'>
                                    Dokter
                                </th>
                                <th align='center'>
                                    No. Antrian
                                </th>
                                <th align='center'>
                                    Jenis Pembayaran
                                </th>
                                <th align='center'>
                                    Jam Praktek
                                </th>
                                <th align='center'>
                                    Alamat
                                </th>
                                <th align='center'>
                                    Tgl Lahir
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcReservasi" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>


<!-- Modal Data Pasien Ranap Aktif ------------------------------------------------>
<div class="modal fade" id="modal_caripasien" tabindex="-1" role="dialog" style="overflow-y: auto">

<div class="modal-dialog" style="width:80%">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"> List Order Operasi</h4>
      <form id="transfer_pasien">
    </div>
    <div class="modal-body">
        <hr>
     <div class="table-responsive">
      <table id="examplex" class="table table-bordered table-striped table-hover js-basic-example dataTable" style="width:100%">
 <thead>
    <tr>
        <th>ID Operasi</th>
        <th>No MR</th>
        <th>No Registrasi</th>
        <th>No Episode</th>
        <th>Tgl Operasi</th>
        <th>Nama Pasien</th>
        <th>Dokter Operator</th>
        <th>Petugas Order</th>
        <th>Action</th>
    </tr>
</thead>
   <tbody>
</tbody>
</table>
</div>

          </form>
    </div>
    <div class="modal-footer">
      <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
    </div>
  </div>
</div>
</div>
<!--#END Data Pasien Ranap Aktif ---------------------------->

<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="Notif_awal_registrasi" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Silahkan Pilih Jenis Pasien </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien Umum</strong></p><br>

                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoPasienUmum.Png" id="logopasienumum" class="img-circle person" alt="Random Name" width="150" height="150">


                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien BPJS</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoBPJS.png" id="logopasienbpjs" data-toggle="modal" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien ADMEDIKA</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/ADMEDIKA.png" id="logopasienadmedika" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien Karyawan</strong></p><br>

                        <img src="<?= BASEURL; ?>/images/jenis_reg/employes.png" id="pasienkaryawan" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="Notif_awal_registrasi" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Silahkan Pilih Jenis Pasien </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien Umum</strong></p><br>

                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoPasienUmum.Png" id="logopasienumum" class="img-circle person" alt="Random Name" width="150" height="150">


                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien BPJS</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoBPJS.png" id="logopasienbpjs" data-toggle="modal" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien ADMEDIKA</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/ADMEDIKA.png" id="logopasienadmedika" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Pasien Karyawan</strong></p><br>

                        <img src="<?= BASEURL; ?>/images/jenis_reg/employes.png" id="pasienkaryawan" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_VerifBPJS" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Input SEP BPJS Kesehatan</h4>
            </div>
            <div class="modal-body">
                <!--  awal untuk tab-->
                <!-- Nav tabs -->
                <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                    <li role="presentation" class="active"><a class="" href="#datadetil" aria-controls="datadetil" role="tab" data-toggle="tab">Data SEP</a></li>
                    <li role="presentation"><a class="" href="#pendidikan" aria-controls="pendidikan" role="tab" data-toggle="tab">Data History Kunjungan</a></li>
                    <li role="presentation"><a class="" href="#documenscan" aria-controls="documenscan" role="tab" data-toggle="tab">Data Document Scan</a></li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content bg-white p-15">
                    <div role="tabpanel" class="tab-pane active" id="datadetil">
                        <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                            <h5 class="underline mt-30">Data Pasien / Rujukan </h5>
                            <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Asal Rujukan<sup class="color-danger">*</sup></label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="JenisFaskesKodeBPJS" readonly name="JenisFaskesKodeBPJS" type="text">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="JenisFaskesNamaBPJS" readonly name="JenisFaskesNamaBPJS" type="text">
                                </div>
                                <label for=" inputEmail3" class="col-sm-2 control-label"> No. Registrasi <sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="NoRegistrasiSIMRSBPJS" readonly name="NoRegistrasiSIMRSBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Rujukan Kode<sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="idppkrujukanBPJS" readonly name="idppkrujukanBPJS" type="text">
                                </div>
                                <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Rujukan Nama<sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="namappkrujukanBPJS" readonly name="namappkrujukanBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. Rujukan </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="norujukan" name="norujukan" autocomplete="off" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. Surat Kontrol <sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" type="text" id="NoSuratKontrolBPJS" autocomplete="off" name="NoSuratKontrolBPJS" placeholder="Ketik No. Surat Kontrol">
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Tgl. Rujukan </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="TglRujukan" readonly name="TglRujukan" type="date" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. NIK </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="nonikktpBPJS" readonly name="nonikktpBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. Kartu BPJS <sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="nokartubpjs" readonly name="nokartubpjs" type="text">
                                </div>
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Status Peserta </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="statuspesertaBPJS" readonly name="statuspesertaBPJS" type="text">
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Peserta </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="namapesertaBPJS" readonly name="namapesertaBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;">
                                    Keterangan PRB </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="keteranganprbBPJS" readonly name="keteranganprbBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Hak Kelas </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="idhakKelasBPJS" readonly name="idhakKelasBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="hakKelasBPJS" readonly name="hakKelasBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> COB - No. Asuransi </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="cobnosuratBPJS" readonly name="cobnosuratBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Faskes </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="idfaskesBPJS" readonly name="idfaskesBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="namafaskesBPJS" readonly name="namafaskesBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> COB - Nama Asuransi </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="cobNamaAsuransiBPJS" readonly name="cobNamaAsuransiBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Peserta </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="jenisPesertaKodeBPJS" readonly name="jenisPesertaKodeBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="jenisPesertaNamaBPJS" readonly name="jenisPesertaNamaBPJS" type="text" placeholder="Ketik Nama Pasien">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin </label>
                                <div class="col-sm-1">
                                    <input class="form-control input-sm " id="jenisKelaminKodeBPJS" readonly name="jenisKelaminKodeBPJS" type="text">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control input-sm " id="jenisKelaminNamaBPJS" readonly name="jenisKelaminNamaBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pelayanan </label>
                                <div class="col-sm-4">
                                    <select id="isJenisPelayananBPJS" name="isJenisPelayananBPJS" style="width: 100%;" class="form-control ">
                                        <option value="2">RAWAT JALAN</option>
                                        <option value="1">RAWAT INAP</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Tgl SEP </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="TglSEP" name="TglSEP" type="date" onchange="setdata();">
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Naik Kelas </label>
                                <div class="col-sm-4">
                                    <select id="isNaikKelasBPJS" name="isNaikKelasBPJS" style="width: 100%;" class="form-control ">
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Kelas Perawatan </label>
                                <div class="col-sm-4">
                                    <select id="kdkelasperawatanBPJS" name="kdkelasperawatanBPJS" class="form-control ">
                                        <option value="">-- PILIH --</option>
                                        <option value="1">VVIP</option>
                                        <option value="2">VIP</option>
                                        <option value="3">Kelas 1</option>
                                        <option value="4">Kelas 2</option>
                                        <option value="5">Kelas 3</option>
                                        <option value="6">ICCU</option>
                                        <option value="7">ICU</option>
                                    </select>
                                    <small>Diisi Jika Naik Kelas.</small>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Pembiayaan </label>
                                <div class="col-sm-4">
                                    <select id="PembiayaanNiakKelasBPJS" name="PembiayaanNiakKelasBPJS" style="width: 100%;" class="form-control ">
                                        <option value="">-- PILIH --</option>
                                        <option value="1">PRIBADI</option>
                                        <option value="2">PEMBERI KERJA</option>
                                        <option value="3">ASURANSI KESEHATAN TAMBAHAN</option>
                                    </select>
                                    <small>Diisi Jika Naik Kelas.</small>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Penanggung Jawab </label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="PenanggungJawabBiaya" autocomplete="off" name="PenanggungJawabBiaya" type="text">
                                    <small>Diisi Jika Naik Kelas.</small>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. MR</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="NoMRBPJS" autocomplete="off" name="NoMRBPJS" type="text">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> No. Hp</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " id="NoHpBPJS" autocomplete="off" name="NoHpBPJS" type="text">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Lahir</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm " readonly id="TglLahirBPJS" autocomplete="off" name="TglLahirBPJS" type="text">
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> COB </label>
                                <div class="col-sm-4">
                                    <select id="isCobBPJS" name="isCobBPJS" style="width: 100%;" class="form-control ">
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Katarak</label>
                                <div class="col-sm-4">
                                    <select id="iscatarakBPJS" name="iscatarakBPJS" style="width: 100%;" class="form-control ">
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Eksekutif </label>
                                <div class="col-sm-4">
                                    <select id="isEksekutifBPJS" name="isEksekutifBPJS" style="width: 100%;" class="form-control ">
                                        <option value="0">TIDAK</option>
                                        <option value="1">YA</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal TMT <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input readonly class="form-control input-sm" type="text" id="TglTMTBPJS" name="TglTMTBPJS">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Diagnosa : </label>
                                <div class="col-sm-10">
                                    <select id='caridiagnosaBPJS2' style="width: 100%;" class="form-control " name='caridiagnosaBPJS2'>
                                        <option value='0'>- Search Diagnosa -</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa Dipilih <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input readonly class="form-control input-sm" type="text" id="KodeDiagnosaBPJS" name="KodeDiagnosaBPJS">
                                </div>
                                <div class="col-sm-8" style="margin-left: -20px;">
                                    <input readonly class="form-control input-sm" type="text" id="NamaDiagnosaBPJS" name="NamaDiagnosaBPJS">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Jumlah Kunjungan Sep : </label>
                                <div class="col-sm-8">
                                    <input readonly class="form-control input-sm" type="text" id="JumlahKunjunganSepBPJS" name="JumlahKunjunganSepBPJS">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Poliklinik : </label>
                                <div class="col-sm-10">
                                    <select id='cariPoliklinikBPJS' style="width: 100%;" name='cariPoliklinikBPJS' onchange="VerificationFinger();" class="form-control ">
                                        <option value='0'>- Search Poliklinik -</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik Dipilih <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input readonly class="form-control input-sm" type="text" id="KodePoliklinikBPJS" name="KodePoliklinikBPJS">
                                </div>
                                <div class="col-sm-8" style="margin-left: -20px;">
                                    <input readonly class="form-control input-sm" type="text" id="NamaPoliklinikBPJS" name="NamaPoliklinikBPJS">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Dokter : </label>
                                <div class="col-sm-10">
                                    <select id='cariDokterBPJS' style="width: 100%;" name='cariDokterBPJS' class="form-control ">
                                        <option value='0'>- Search Dokter -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Dipilih <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input readonly class="form-control input-sm" type="text" id="KodeDokterBPJS" name="KodeDokterBPJS">
                                </div>
                                <div class="col-sm-8" style="margin-left: -20px;">
                                    <input readonly class="form-control input-sm" type="text" id="NamaDokterBPJS" name="NamaDokterBPJS">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Tujuan Kunjungan :</label>
                                <div class="col-sm-4">
                                    <select id='TujuanKunjunganBPJS' style="width: 100%;" name='TujuanKunjunganBPJS' class="form-control ">
                                        <option value=''>- PILIH -</option>
                                        <option value='0'>NORMAL</option>
                                        <option value='1'>PROSEDUR</option>
                                        <option value='2'>KONSUL DOKTER</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Flag Procedure :</label>
                                <div class="col-sm-4">
                                    <select id='FlagProcedureBPJS' style="width: 100%;" name='FlagProcedureBPJS' class="form-control ">
                                        <option value=''>- PILIH -</option>
                                        <option value='0'>Prosedur Tidak Berkelanjutan</option>
                                        <option value='1'>Prosedur dan Terapi Berkelanjutan</option>
                                    </select>
                                    <small>Dikosongkan, Jika Tujuan Kunjungan Normal</small>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Penunjang :</label>
                                <div class="col-sm-4">
                                    <select id='PenujangBPJS' style="width: 100%;" name='PenujangBPJS' class="form-control ">
                                        <option value=''>- PILIH -</option>
                                        <option value='0'>NORMAL</option>
                                        <option value='1'>Radioterapi</option>
                                        <option value='2'>Kemoterapi</option>
                                        <option value='3'>Rehabilitasi Medik</option>
                                        <option value='4'>Rehabilitasi Psikososial</option>
                                        <option value='5'>Transfusi Darah</option>
                                        <option value='6'>Pelayanan Gigi</option>
                                        <option value='7'>Laboratorium</option>
                                        <option value='8'>USG</option>
                                        <option value='9'>Farmasi</option>
                                        <option value='10'>Lain-Lain</option>
                                        <option value='11'>MRI</option>
                                        <option value='12'>HEMODIALISA</option>
                                    </select>
                                    <small>Dikosongkan, Jika Tujuan Kunjungan Normal</small>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Asesment Pelayanan :</label>
                                <div class="col-sm-4">
                                    <select id='AsesmentPelayananBPJS' style="width: 100%;" name='AsesmentPelayananBPJS' class="form-control ">
                                        <option value=''>- PILIH -</option>
                                        <option value='1'>Poli spesialis tidak tersedia pada hari sebelumnya</option>
                                        <option value='2'>Jam Poli telah berakhir pada hari sebelumnya</option>
                                        <option value='3'>Dokter Spesialis yang dimaksud tidak praktek pada hari
                                            sebelumnya</option>
                                        <option value='4'>Atas Instruksi RS</option>
                                    </select>
                                    <small>Dikosongkan, Jika Poli tujuan berbeda dengan poli rujukan dan hari beda.
                                        Diisi, Jika Tujuan Adlah konsul Dokter.</small>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label"> Catatan <sup class="color-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <textarea class="form-control input-sm" id="iscatatanBPJS" name="iscatatanBPJS" rows="4"></textarea>
                                </div>
                            </div>
                            <h5 class="underline mt-30">DATA KECELAKAAN <small> Jika Pasien Kecelakaan</small> <button class="btn btn-danger btn-sm" type="button" id="btnRefreshKecamatan" name="btnRefreshKecamatan">Refresh Kecamatan</button></h5>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Laka Lantas :</label>
                                <div class="col-sm-4">
                                    <select id='LakaLantasBPJS' style="width: 100%;" name='LakaLantasBPJS' class="form-control ">
                                        <option value='0'>Bukan Kecelakaan lalu lintas [BKLL]</option>
                                        <option value='1'>KLL dan bukan kecelakaan Kerja [BKK]</option>
                                        <option value='2'>KLL dan KK</option>
                                        <option value='3'>KK</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Tgl Kejadian :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" type="date" id="TglKejadianBPJS" name="TglKejadianBPJS" placeholder="Ketik No. Surat Kontrol">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control input-sm" id="LakaLantasKetBPJS" name="LakaLantasKetBPJS" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Suplesi :</label>
                                <div class="col-sm-4">
                                    <select id='SuplesiBPJS' style="width: 100%;" name='SuplesiBPJS' class="form-control ">
                                        <option value='0'>TIDAK</option>
                                        <option value='1'>YA</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">No. Suplesi :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" type="text" id="NoSuplesiBPJS" name="NoSuplesiBPJS" placeholder="Ketik No. Surat Kontrol">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Provinsi :</label>
                                <div class="col-sm-4">
                                    <select id='cariProvinsi' style="width: 100%;" name='cariProvinsi' class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Provinsi Kode:</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSProvinsi" name="SuplesiBPJSProvinsi" placeholder="Ketik No. Surat Kontrol">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Provinsi Nama :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSProvinsiName" name="SuplesiBPJSProvinsiName" placeholder="Ketik No. Surat Kontrol">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Kabupaten :</label>
                                <div class="col-sm-4">
                                    <select id='cariKabupaten' style="width: 100%;" name='cariKabupaten' class="form-control ">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Kabupaten Kode:</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKabupaten" name="SuplesiBPJSKabupaten" placeholder="Ketik No. Surat Kontrol">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Kabupaten Nama :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKabupatenName" name="SuplesiBPJSKabupatenName" placeholder="Ketik No. Surat Kontrol">
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan :</label>
                                <div class="col-sm-4">
                                    <select id='cariKecamatan' style="width: 100%;" name='cariKecamatan' class="form-control ">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group gut">
                                <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan Kode:</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKecamatan" name="SuplesiBPJSKecamatan" placeholder="Ketik No. Surat Kontrol">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan Nama :</label>
                                <div class="col-sm-4">
                                    <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKecamatanName" name="SuplesiBPJSKecamatanName" placeholder="Ketik No. Surat Kontrol">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pendidikan">
                        <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                            <div class="form-group  ">
                                <label for="inputEmail3" class="col-sm-3 control-label"> Periode <sup class="color-danger">*</sup></label>
                                <div class="col-sm-2">
                                    <input class="form-control input-sm" type="date" id="MTglKunjunganBPJS" autocomplete="off" name="MTglKunjunganBPJS" placeholder="ketik Kata Kunci disini">
                                </div>
                                <div class="col-sm-1">
                                    S.D
                                </div>
                                <div class="col-sm-2" style="margin-left: -40px;">
                                    <input class="form-control input-sm" type="date" id="MTglKunjunganBPJS_akhir" autocomplete="off" name="MTglKunjunganBPJS_akhir" placeholder="ketik Kata Kunci disini">
                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                <div class="col-sm-2">
                                    <button type="button" onclick="GoMonitoringBPJS();" id="caridatapasienarsip" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                                </div>
                            </div>
                            <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                <table id="tbl_history_Kunjungan" width="100%" class="table table-striped table-hover cell-border">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">No SEP
                                            </th>
                                            <th align='center'>
                                                <font size="1">No Kartu
                                            </th>
                                            <th align='center'>
                                                <font size="1">No Rujukan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl SEP
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Pasien
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jenis Pelayanan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Diagnosa
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kelas Rawat
                                            </th>
                                            <th align='center'>
                                                <font size="1">Layanan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl Pulang
                                            </th>
                                            <th align='center'>
                                                <font size="1">PPK Pelayanan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="documenscan">
                        <button class="btn bg-success  btn-wide" id="btnRefresh" name="btnRefresh" onclick="LoadDataDocumentUploads();"><i class="fa fa-save"> </i> REFRESH</button>

                        <div class="table-responsive" style="margin-top: 10px;">
                            <table id="table-load-data-document" class="display table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Jenis File</th>
                                        <th>Keterangan</th>
                                        <th>Gambar</th>
                                        <th>Date Create</th>
                                        <th>User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!--  akhir untuk tab-->
                </div>
                <div class="modal-footer">
                    <button class="btn bg-success  btn-wide" id="btnCreateSEP" name="btnCreateSEP"><i class="fa fa-save"> </i> SIMPAN SEP</button>
                    <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->



<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="Notif_awal_registrasi2" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Data Polis Asuransi </h4>
            </div>
            <form id="FrmDataPolisKartu">
                <div class="modal-body">
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. ID</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="Kartu_ID" readonly name="Kartu_ID">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. Rekam Medik</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="kartu_NoRM" readonly name="kartu_NoRM">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pasien </label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="Kartu_NamaPasien" readonly name="Kartu_NamaPasien" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Group Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="Kartu_GroupJaminan" readonly name="Kartu_GroupJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamagroupJaminan_Asr" readonly name="Kartu_NamagroupJaminan_Asr" type="text" placeholder="Ketik Nama Group Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="Kartu_NamaJaminan" readonly name="Kartu_NamaJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamaJaminanx_Asr" readonly name="Kartu_NamaJaminanx_Asr" type="text" placeholder="Ketik Nama Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">No. Kartu Polis </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="Kartu_NoPeserta" name="Kartu_NoPeserta" type="number" placeholder="No. Kartu Polis">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Hak Kelas</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="Kartu_HakKelas" id="Kartu_HakKelas">
                                <option value=""></option>
                                <option value="KELAS 1">KELAS 1</option>
                                <option value="KELAS 2">KELAS 2</option>
                                <option value="KELAS 3">KELAS 3</option>
                                <option value="KELAS VIP">KELAS VIP</option>
                                <option value="KELAS VVIP">KELAS VVIP</option>
                            </select>

                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Status Peserta</label>
                        <div class="col-sm-8">
                            <select id="Kartu_StatusPeserta" name="Kartu_StatusPeserta" class="form-control input-sm ">
                                <option value=""></option>
                                <option value="PESERTA">PESERTA</option>
                                <option value="SUAMI">SUAMI</option>
                                <option value="ISTRI">ISTRI</option>
                                <option value="AYAH">AYAH</option>
                                <option value="IBU">IBU</option>
                                <option value="ANAK 1">ANAK 1</option>
                                <option value="ANAK 2">ANAK 2</option>
                                <option value="ANAK 3">ANAK 3</option>
                                <option value="ANAK 4">ANAK 4</option>
                                <option value="ANAK 5">ANAK 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pemegang Kartu</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="Kartu_NamaPemegangKartu" name="Kartu_NamaPemegangKartu" type="text" placeholder="Ketik Nama Pemegang Kartu">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="Kartu_Keterangan" name="Kartu_Keterangan" type="text" placeholder="Ketik Keterangan">
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">
                    <button class="btn btn-primary" id="btnSavePoli" name="btnSavePoli"> Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="Modal_Karyawn_Polis" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Data Polis Karyawan </h4>
            </div>
            <form id="frmKartuRSYarsi">
                <div class="modal-body">
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. ID</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="Kartu_ID2" readonly name="Kartu_ID2">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Group Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="RSY_Kartu_GroupJaminan" readonly name="RSY_Kartu_GroupJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamagroupJaminan" readonly name="Kartu_NamagroupJaminan" type="text" placeholder="Ketik Nama Group Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="RSY_Kartu_NamaJaminan" readonly name="RSY_Kartu_NamaJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamaJaminanx" readonly name="Kartu_NamaJaminanx" type="text" placeholder="Ketik Nama Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. Rekam Medik</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="RSY_kartu_NoRM" readonly name="RSY_kartu_NoRM">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pasien </label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_Kartu_NamaPasien" readonly name="RSY_Kartu_NamaPasien" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">NIK Karyawan</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="RSY_Kartu_NoPeserta" name="RSY_Kartu_NoPeserta" type="number" placeholder="Ketik NIK Karyawan">
                            <a href="#" class="btn btn-success" id="btnValidateNIK" name="btnValidateNIK"> Validate</a>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Karyawan</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_Kartu_NamaPemegangKartu" name="RSY_Kartu_NamaPemegangKartu" type="text" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Hak Kelas</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_Kartu_HakKelas" name="RSY_Kartu_HakKelas" type="text" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Plafon RJ</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_Kartu_PlafonRJ" name="RSY_Kartu_PlafonRJ" type="text" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Plafon RI</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_PlafonRI" name="RSY_PlafonRI" type="text" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Status Peserta</label>
                        <div class="col-sm-8">
                            <select id="RSY_Kartu_StatusPeserta" name="RSY_Kartu_StatusPeserta" class="form-control input-sm ">
                                <option value=""></option>
                                <option value="PESERTA">PESERTA</option>
                                <option value="SUAMI">SUAMI</option>
                                <option value="ISTRI">ISTRI</option>
                                <option value="AYAH">AYAH</option>
                                <option value="IBU">IBU</option>
                                <option value="ANAK 1">ANAK 1</option>
                                <option value="ANAK 2">ANAK 2</option>
                                <option value="ANAK 3">ANAK 3</option>
                                <option value="ANAK 4">ANAK 4</option>
                                <option value="ANAK 5">ANAK 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Status Kepegawaian</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="RSY_stsPeg" name="RSY_stsPeg" type="text" readonly>
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">
                    <button class="btn btn-primary" id="btnSavePoli2" name="btnSavePoli2"> Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal DATA SOSIAL PASIEN-->
<div class="modal fade" id="ModalInputMRBAru" role="dialog" style="overflow-y: auto" data-backdrop="static">
    <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Medical Record Pasien</h4>
            </div>
            <form id="FRMcreatemr">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home" style="background-color:#ffc7c7;">Data Sosial </a></li>
                                    <li><a data-toggle="tab" href="#pekerjaan" style="background-color:#2fcee9;">Data
                                            Pekerjaan</a></li>
                                    <li><a data-toggle="tab" href="#menu1" style="background-color:#c7ffcd;">Data
                                            Keluarga</a></li>
                                    <li><a data-toggle="tab" href="#arsip_rajal" style="background-color:#e6fffd;">Arsip
                                            Rawat Jalan</a></li>
                                    <li><a data-toggle="tab" href="#arsip_ranap" style="background-color:#e9e6ff;">Arsip
                                            Rawat Inap</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <br>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">No. MR <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-2">
                                                <input class="form-control input-sm" id="Medrec_NoMR" required name="Medrec_NoMR" type="text" readonly placeholder="Ketik No. MR disini" class="containerX">
                                            </div>
                                            <div class="col-sm-2">
                                                <select name="Medrec_Status" id="Medrec_Status" class="form-control">
                                                    <option value='1'>AKTIF</option>
                                                    <option value='0'>NON AKTIF</option>
                                                </select>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Td Pengenal : <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <select name="Medrec_IdPengenal" id="Medrec_IdPengenal" class="form-control">
                                                    <option value='KTP'>KTP</option>
                                                    <option value='SIM'>SIM</option>
                                                    <option value='KTA'>KTA</option>
                                                    <option value='KTM'>KTM</option>
                                                    <option value='PASPORT'>PASPORT</option>
                                                    <option value='KT PELAJAR'>KT PELAJAR</option>
                                                    <option value='KIA'>KIA</option>

                                                </select>
                                                <div id="error_Medrec_IdPengenal"></div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Nama Pasien <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" id="Medrec_NamaPasien" autocomplete="off" name="Medrec_NamaPasien" type="text">
                                                <div id="error_Medrec_NamaPasien"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Nomor Identitas <sup class="color-danger">*</sup></label>

                                            <div class="col-sm-3">

                                                <input class="form-control input-sm" autocomplete="off" id="Medrec_NoIdPengenal" name="Medrec_NoIdPengenal" type="text" placeholder="Ketik NomorID disini" class="containerX">
                                                <div id="error_Medrec_NoIdPengenal"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="IhsNumber" class="col-sm-2 col-form-label">No. IHS Satu Sehat <sup
                                                    class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" id="Medrec_IhsNumber"
                                                    autocomplete="off" name="Medrec_IhsNumber" readonly type="text">
                                                <div id="error_Medrec_IhsNumber"></div>
                                            </div>
 
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Alamat <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <textarea id="Medrec_Alamat" name="Medrec_Alamat"></textarea>
                                                <div id="error_Medrec_Alamat"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Bin/Bt </label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm" id="Medrec_Bin" autocomplete="off" name="Medrec_Bin" type="text" placeholder="Ketik NomorID disini" class="containerX">
                                                <div id="error_Medrec_Bin"></div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Jenis Kelamin <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select name="Medical_JKel" id="Medical_JKel" class="form-control">
                                                    <option value=''></option>
                                                    <option value='P'>Perempuan</option>
                                                    <option value='L'>laki-Laki</option>
                                                </select>
                                                <div id="error_Medical_JKel"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Agama <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <select name="Medical_Agama" id="Medical_Agama" class="form-control">
                                                    <option value='Islam'>Islam</option>
                                                    <option value='Katholik'>Katholik</option>
                                                    <option value='Kristen Protestan'>Kristen Protestan</option>
                                                    <option value='Budha'>Budha</option>
                                                    <option value='Hindu'>Hindu</option>
                                                    <option value='Konghucu'>Konghucu</option>
                                                </select>
                                                <div id="error_Medical_Agama"></div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Provinsi <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select class="col-sm-10" name="Medical_Provinsi" id="Medical_Provinsi" style="width:100%">
                                                </select>


                                                <div id="error_Medical_Provinsi"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Warganegara <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <select name="Medrec_Warganegara" id="Medrec_Warganegara" class="form-control">

                                                    <option value='WNI'>WNI</option>
                                                    <option value='WNA'>WNA</option>
                                                </select>
                                                <div id="error_Medrec_Warganegara"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Kab/Kodya <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="Medrec_kabupaten" id="Medrec_kabupaten" style="width:100%">
                                                </select>
                                                <div id="error_Medrec_kabupaten"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Tpt Lahir <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm" autocomplete="off" id="Medrec_Tpt_lahir" name="Medrec_Tpt_lahir" type="text" placeholder="Ketik Tpt Lahir disini" class="containerX">
                                                <div id="error_Medrec_Tpt_lahir"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Kecamatan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="Medrec_Kecamatan" id="Medrec_Kecamatan" style="width:100%">
                                                </select>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Tgl Lahir <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm " id="Medrec_Tgl_Lahir" name="Medrec_Tgl_Lahir" type="date">
                                                <div id="error_Medrec_Tgl_Lahir"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Kelurahan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="Medrec_Kelurahan" id="Medrec_Kelurahan" style="width:100%">
                                                </select>
                                                <div id="error_Medrec_Kelurahan"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Status Nikah <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <select name="Medrec_statusNikah" id="Medrec_statusNikah" class="form-control">
                                                    <option value='BELUM MENIKAH'>BELUM MENIKAH</option>
                                                    <option value='NIKAH'>NIKAH</option>
                                                    <option value='DUDA'>DUDA</option>
                                                    <option value='JANDA'>JANDA</option>
                                                    <option value='CERAI'>CERAI</option>
                                                </select>
                                                <div id="error_Medrec_statusNikah"></div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Home Phone <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="Medrec_HomePhone" autocomplete="off" name="Medrec_HomePhone" type="text">
                                                <div id="error_Medrec_HomePhone"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Handphone <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm " id="Medrec_handphone" autocomplete="off" name="Medrec_handphone" type="text">
                                                <div id="error_Medrec_handphone"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Pendidikan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select name="Medrec_Pendidikan" id="Medrec_Pendidikan" class="form-control">
                                                    <option value='Belum Sekolah'>Belum Sekolah</option>
                                                    <option value='TK'>TK</option>
                                                    <option value='SD'>SD</option>
                                                    <option value='SMP'>SMP</option>
                                                    <option value='SMU'>SMU</option>
                                                    <option value='D1'>D1</option>
                                                    <option value='D3'>D3</option>
                                                    <option value='S1'>S1</option>
                                                    <option value='S2'>S2</option>
                                                    <option value='S3'>S3</option>
                                                    <option value='Aktif TK'>Aktif TK</option>
                                                    <option value='Aktif Aktif SD'>SD</option>
                                                    <option value='Aktif SMP'>Aktif SMP</option>
                                                    <option value='Aktif SMU'>Aktif SMU</option>
                                                    <option value='Aktif D1'>Aktif D1</option>
                                                    <option value='Aktif D2'>Aktif D2</option>
                                                    <option value='Aktif D3'>Aktif D3</option>
                                                    <option value='Aktif S1'>Aktif S1</option>
                                                    <option value='Aktif S2'>Aktif S2</option>
                                                    <option value='Aktif S3'>Aktif S3</option>
                                                    <option value='Pesantren'>Pesantren</option>
                                                    <option value='Tidak Sekolah'>Tidak Sekolah</option>
                                                </select>
                                                <div id="Medrec_Pendidikan"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Pekerjaan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <select name="Medrec_Pekerjaan" id="Medrec_Pekerjaan" class="form-control">
                                                    <option value='P N S'>P N S</option>
                                                    <option value='I R T'>I R T</option>
                                                    <option value='BURUH'>BURUH</option>
                                                    <option value='PELAJAR'>PELAJAR</option>
                                                    <option value='MAHASISWA'>MAHASISWA</option>
                                                    <option value='WIRASWASTA'>WIRASWASTA</option>
                                                    <option value='TIDAK BEKERJA'>TIDAK BEKERJA</option>
                                                    <option value='PEDAGANG'>PEDAGANG</option>
                                                    <option value='KARYAWAN/TI'>KARYAWAN/TI</option>
                                                    <option value='SWASTA'>SWASTA</option>
                                                    <option value='KARYAWAN RS'>KARYAWAN RS</option>
                                                    <option value='PETANI'>PETANI</option>
                                                    <option value='ZUSTER'>ZUSTER</option>
                                                    <option value='BIDAN'>BIDAN</option>
                                                    <option value='DOKTER'>DOKTER</option>
                                                    <option value='TUKANG'>TUKANG</option>
                                                    <option value='SOPIR'>SOPIR</option>
                                                    <option value='DOSEN'>DOSEN</option>
                                                    <option value='GURU'>GURU</option>
                                                    <option value='BUMN'>BUMN</option>
                                                    <option value='PENSIUNAN'>PENSIUNAN</option>
                                                    <option value='ABRI'>ABRI</option>
                                                    <option value='POLRI'>POLRI</option>
                                                    <option value='NOTARIS'>NOTARIS</option>
                                                    <option value='ADVOKAT'>ADVOKAT</option>
                                                </select>
                                                <div id="Medrec_Pekerjaan"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Email <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="Medrec_Email" autocomplete="off" name="Medrec_Email" type="Email" placeholder="Contoh: noname@email.com">
                                                <div id="Medrec_Medrec_Email"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Nama Ibu Kandung
                                                <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm " autocomplete="off" id="Medrec_NamaIbuKandung" name="Medrec_NamaIbuKandung" type="text" placeholder="Ketik Ibu Kandung disini">
                                            </div>
                                            <div id="error_Medrec_Ibu_Kandung"></div>

                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Bahasa <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select name="Medrec_Bahasa" id="Medrec_Bahasa" class="form-control">
                                                    <option value='BAHASA INDONESIA'>BAHASA INDONESIA</option>
                                                    <option value='BAHASA DAERAH'>BAHASA DAERAH</option>
                                                    <option value='BAHASA ASING'>BAHASA ASING</option>
                                                </select>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Etnis <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <select name="Medrec_Etnis" id="Medrec_Etnis" class="form-control">
                                                    <option value='JAWA'>JAWA</option>
                                                    <option value='SUNDA'>SUNDA</option>
                                                    <option value='MADURA'>MADURA</option>
                                                    <option value='ASING'>ASING</option>
                                                    <option value='BATAK'>BATAK</option>
                                                    <option value='ARAB'>ARAB</option>
                                                    <option value='LAIN-LAIN'>LAIN-LAIN</option>
                                                </select>
                                            </div>
                                            <div id="error_Medrec_Ibu_Kandung"></div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Kodepos <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " autocomplete="off" id="Medrec_Kodepos" name="Medrec_Kodepos" type="text" placeholder="Ketik Kodepos disini" readonly>

                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">MR Ibu </label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm " autocomplete="off" id="Medrec_Ibu_Kandung" name="Medrec_Ibu_Kandung" type="text" placeholder="Ketik MR Ibu Kandung disini">
                                            </div>
                                            <div id="error_Medrec_Ibu_Kandung"></div>
                                        </div>
                                        <input class="form-control input-sm" id="statusmr" name="statusmr" type="hidden" readonly>
                                    </div>
                                    <div id="pekerjaan" class="tab-pane fade"><br>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Nama Perusahaan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " autocomplete="off" id="Medrec_PerusahaanNama" name="Medrec_PerusahaanNama" type="text" placeholder="Ketik Nama Perusahaan disini">
                                                <div id="error_Medrec_PerusahaanNama"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Alamat Perusahaan
                                                <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <textarea id="Medrec_PerusahaanAlamat" autocomplete="off" name="Medrec_PerusahaanAlamat"></textarea>
                                                <div id="error_Medrec_PerusahaanAlamat"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Telepon <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " autocomplete="off" id="Medrec_PerusahaanTlp" name="Medrec_PerusahaanTlp" type="text" placeholder="Ketik Nama No Tlp disini">
                                                <div id="error_Medrec_NamaPerusahaan"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Fax Perusahaan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm " autocomplete="off" id="Medrec_PerusahaanFax" name="Medrec_PerusahaanFax" type="text" placeholder="Ketik Nama No Fax disini">
                                                <div id="error_Medrec_PerusahaanFax"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="menu1" class="tab-pane fade">
                                        <h3>Dalam Keadaan Darurat</h3> <br>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">Nama <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " autocomplete="off" id="Medrec_DaruratNama" name="Medrec_DaruratNama" type="text" placeholder="Ketik Nama Darurat disini">
                                                <div id="error_Medrec_DaruratNama"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Alamat Perusahaan
                                                <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <textarea id="Medrec_DaruratAlamat" autocomplete="off" name="Medrec_DaruratAlamat"></textarea>
                                                <div id="error_Medrec_DaruratAlamat"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-2 col-form-label">No. Tlp <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " autocomplete="off" id="Medrec_DaruratTlp" name="Medrec_DaruratTlp" type="text" placeholder="Ketik Nama No Tlp disini">
                                                <div id="error_Medrec_DaruratTlp"></div>
                                            </div>
                                            <label for="namapasien" class="col-sm-3 col-form-label">Hubungan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-3">
                                                <select name="Medrec_DaruratHub" id="Medrec_DaruratHub" class="form-control">
                                                    <option value=''></option>
                                                    <option value='BELUM MENIKAH'>BELUM MENIKAH</option>
                                                    <option value='NIKAH'>NIKAH</option>
                                                    <option value='DUDA'>DUDA</option>
                                                    <option value='JANDA'>JANDA</option>
                                                    <option value='CERAI'>CERAI</option>
                                                </select>
                                                <div id="error_Medrec_DaruratHub"></div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div id="arsip_rajal" class="tab-pane fade">
                                        <div class="table-responsive">
                                            <table id="tbl_arsip_rajal" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size='2'>No Registrasi</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>No. MR</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Tgl Kunjungan</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Unit Instalasi</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Dokter</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Tipe Pasien</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Status</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Diagnosa</font>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>


                                        </div>
                                    </div>

                                    <div id="arsip_ranap" class="tab-pane fade">
                                        <div class="table-responsive">
                                            <table id="tbl_arsip_ranap" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size='2'>No. MR</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Nama Pasien</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>No Registrasi</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Tgl Masuk</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Tgl Pulang</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Nama Dokter</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Jenis Pasien</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Nama Kelas</font>
                                                        </th>
                                                        <th align='center'>
                                                            <font size='2'>Penjamin</font>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="Load_ArsipRanap"> </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </form>
            <div class="modal-footer">
                <p style="margin-left:1em;float:left;"><b>Petugas Input : </b></p>
                <div id="petugasinput" style="margin-left:1em;float:left;"></div>
                <div id="jaminput" style="margin-left:1em;float:left;"></div> <br>
                <p style="margin-left:-7em;float:left;"><b>Last Update : </b></p>
                <div id="petugasupdate" style="margin-left:1em;float:left;"> </div>
                <div id="jamupdate" style="margin-left:1em;float:left;"></div>
                </p>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-info btn-rounded" id="print_kartumr" name="print_kartumr">
                        <span class="glyphicon glyphicon-print"></span> Print Kartu MR
                    </button>
                    <button type="button" class="btn btn-primary btn-rounded" id="simapnMR" name="simapnMR">
                        <span class="glyphicon glyphicon-save"></span> SIMPAN
                    </button>
                    <a data-dismiss="modal" class="btn btn-success btn-rounded" href="#" id="CloseMeMR" name="CloseMeMR">Keluar</a>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal DATA SOSIAL PASIEN -->


<!-- Modal CARI MR-->
<div class="modal fade" id="modalcariDataMRSave" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static">
    <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> List Data Duplikat</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 form-group">
                        <div class="col-sm-12">
                            <input type="hidden" name="totalrow" id="totalrow" class="form-control totalrow" />
                            <div class="alert alert-success alert-dismissible">
                                <p> <strong>Info !</strong> Ini adalah List Data Kemiripan yang sudah ada di Database.
                                </p>
                                <p> <strong>Info !</strong> Silahkan Periksa Dahulu Datanya apakah benar sudah ada diD
                                    dalam Database atau belum.</p>
                                <p> <strong>Info !</strong> PASTIKAN DATA YANG ANDA INPUT BENAR TIDAK ADA SEBELUM NYA !!
                                    Jika anda yakin belum ada, silahkan anda lanjut dengan cara klik tombol LANJUT
                                    SIMPAN.</p>
                            </div>
                            <!-- tabel------------>


                            <div class="table-responsive">
                                <table class="display table table-striped table-bordered" id="table-id" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <font size="1">No. MR</font>
                                            </th>
                                            <th>
                                                <font size="1">Nama Pasien</font>
                                            </th>
                                            <th>
                                                <font size="1">Alamat Pasien</font>
                                            </th>
                                            <th>
                                                <font size="1">Tgl Lahir</font>
                                            </th>
                                            <th>
                                                <font size="1">Nama Ibu / Phone </font>
                                            </th>
                                            <th>
                                                <font size="1">ID. Card Number </font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="user_data">
                                    </tbody>

                                </table>
                            </div>

                        </div><br>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="simapnMRx" name="simapnMRx">
                    <span class="glyphicon glyphicon-save"></span> LANJUT SIMPAN
                </button>
                <a data-dismiss="modal" class="btn btn-success" href="#" id="CloseMeC" name="CloseMeC">Close</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal CARI MR-->


<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/registration/input/inputregistratrationrajal_V23.js"></script>