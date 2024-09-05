<?php
date_default_timezone_set('Asia/Jakarta');
$id = "";
$datenowcreate = date("Y-m-d");
$datetimenow2222 = date("Y-m-d\TH:i:s");

?>
<style type="text/css">
.signature-area {
    width: 304px;
    margin: 50px auto;
    border: 1px solid black;
}

.signature-container {
    width: 60%;
    margin: auto;
}

.signature-list {
    width: 150px;
    height: 50px;
    border: solid 1px #cfcfcf;
    margin: 10px 5px;
}

.title-area {
    font-family: cursive;
    font-style: oblique;
    font-size: 12px;
    text-align: left;
}

.btn-save {
    color: #fff;
    background: #1c84c6;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
    border: 1px solid transparent;
}

.btn-clear {
    color: #fff;
    background: #f7a54a;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
    border: 1px solid transparent;
}

</style>

<div class="main-page">
     
    <!-- /.container-fluid -->
    <section class="section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>Input <?= $data['judul'] ?> Baru/Edit</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                        <div class="alert alert-info" role="alert">
                                              <p><strong>Perhatian !</strong> Pilih Jaminan / Cara Bayar Terlebih Dahulu, Setelah Itu Klik Klaim Baru. Karena Untuk Men-generate Nomor Klaim (No SEP) Jika Jaminan Covid-19.</p>
                                          </div>
                            
                            
                            <form class="form-horizontal" id="formdata">
                            <!-- <form class="form-horizontal" method="post" action="" enctype="multipart/form-data"
                                id="formdata"> -->
                                
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> No. RM
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="nomor_rm" id="nomor_rm"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="nama_pasien" id="nama_pasien"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Jenis Kelamin
                                    </label>
                                    <div class="col-sm-2">
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="1"> Laki-Laki </option>
                                            <option value="2"> Perempuan </option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" readonly
                                            >
                                    </div>
                        
                                </div>
                                <hr style="border: 1px solid black;">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> ID
                                    </label>
                                    <div class="col-sm-2">
                                    <input type="text" class="form-control" name="ID_EKLAIM" id="ID_EKLAIM"
                                            readonly  value="<?= $data['id'] ?>"/>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Penjamin
                                    </label>
                                    <div class="col-sm-2">
                                    <input type="text" class="form-control" name="penjamin"     id="penjamin" readonly>
                                    </div>
                                    <div class="form-group" style="float: right;margin-right:50px">
                                            <button type="button" class="btn btn-primary btn-animated btn-wide"
                                                id="btnNewClaim" name="btnNewClaim"><i class="fa fa-plus" aria-hidden="true"></i> Klaim Baru</button>
                                </div>
                                </div>
                             
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Jaminan / Cara Bayar
                                    </label>
                                    <div class="col-sm-2">
                                        <select name="payor_id" id="payor_id" class="form-control" onchange="getJaminanCovid()">
                                            <option value="3"> JKN </option>
                                            <option value="71"> JAMINAN COVID-19 </option>
                                            <option value="72"> JAMINAN KIPI </option>
                                            <option value="73"> JAMINAN BAYI BARU LAHIR </option>
                                            <option value="74"> JAMINAN PERPANJANGAN MASA RAWAT </option>
                                            <option value="75"> JAMINAN CO-INSINDENSE </option>
                                            <option value="76"> JAMPERSAL </option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> COB
                                    </label>
                                    <div class="col-sm-2">
                                        <select name="cob_cd" id="cob_cd" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> No. Peserta
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="nomor_kartu" id="nomor_kartu"
                                            readonly>
                                    </div>

                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. SEP
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="nomor_sep" id="nomor_sep"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                <div id="covid_kartu" style="display:none">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Identitas Pasien
                                        </label>
                                            <div class="col-sm-2">
                                                <select name="nomor_kartu_t" id="nomor_kartu_t" class="form-control">
                                                        <option value="nik"> NIK </option>
                                                        <option value="kitas"> KITAS </option>
                                                        <option value="paspor"> PASPOR </option>
                                                        <option value="kartu_jkn"> KARTU JKN </option>
                                                        <option value="kk"> KARTU KELUARGA </option>
                                                        <option value="unhcr"> KARTU UNHCR </option>
                                                        <option value="kelurahan"> SURAT KELURAHAN </option>
                                                        <option value="dinsos"> SURAT DINAS SOSIAL </option>
                                                        <option value="dinkes"> SURAT DINAS KESEHATAN </option>
                                                        <option value="sjp"> SURAT JAMINAN PELAYANAN </option>
                                                        <!-- <option value="klaim_ibu"> KLAIM IBU </option> -->
                                                        <option value="lainnya"> LAINNYA </option>
                                                    </select>
                                            </div>
                                   </div>

                                   <div id="margin_covid" style="display:none">
                                   <label class="col-sm-5 control-label">
                                        </label>
                                </div> 
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Registrasi
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="nomor_registrasi" id="nomor_registrasi"  value="<?= $data['noreg'] ?>"
                                            readonly>
                                    </div>
                                  </div>
                                <hr>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Rawat</label>
                                    <!-- <label for="inputEmail3" class="col-sm-1 control-label">Jalan</label> -->
                                    <div class="col-sm-2">
                                        <select name="jenis_rawat" id="jenis_rawat" class="form-control" onchange="getJaminanCovid()">
                                            <option value="2" > Rawat Jalan</option>
                                            <option value="1" > Rawat Inap </option>
                                            <option value="3" > Rawat IGD </option>
                                        </select>
                                        <!-- <input type="radio" class="form-check-input" id="jenis_rawat" name="jenis_rawat"
                                            value="2" onclick="myFunctionJenisRawat()" checked>
                                        Jalan -->
                                    </div>
                                    <!-- <div class="col-sm-1">
                                        <label for="inputEmail3" class="control-label">Inap</label>
                                    </div> -->
                                    <!-- <div class="col-sm-1">
                                        <input type="radio" class="form-check-input" id="jenis_rawat" name="jenis_rawat"
                                            value="1" onclick="myFunctionJenisRawat2()">
                                        Inap
                                    </div> -->

                                    <!-- <label for="inputEmail3" class="col-sm-2 control-label">Kelas Eksekutif</label> -->
                                   
                                    <div class="col-sm-4" id="myDIV_KelasEksekutif">
                                    <div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Check jika mendapatkan pelayanan eksekutif."> ? </div>
                                        <input type="checkbox" id="kelas_eksekutif" name="kelas_eksekutif" value="1" onclick="myFunctionKelasEksekutif()"> Kelas Eksekutif
                                    </div>
                                    <div class="col-sm-2" id="myDIV_NaikTurunKelas" style="display: none;">
                                        <div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Check jika pelayanan berbeda dengan hak kelasnya."> ? </div>
                                        <input type="checkbox" id="upgrade_class_ind" name="upgrade_class_ind" value="1"
                                            onclick="myFunctionNaikTurunKelas()"> Naik / Turun Kelas
                                    </div>
                                    <div class="col-sm-2" id="myDIV_RawatIntensif" style="display: none;">
                                        <div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Untuk perbaikan tarif :
                                             Check jika selama periode perawatan ada episode rawat intensif (ICU / ICCU / NICU / PICU / HCU/Dll). "> ? </div>
                                        <input type="checkbox" id="icu_indikator" name="icu_indikator" value="1"
                                            onclick="myFunctionRawatIntensif()">  Ada Rawat Intensif
                                        
                                    </div>

                                    <div class="col-sm-2" id="MyDIV_ranap_covid" style="display: none">
                                    </div>

                                    <label for="inputEmail3" class="col-sm-1 control-label">Kelas Hak</label>
                                    <div class="col-sm-2" id="myDIV_KelasHakRajal">
                                        <input type="teks" class="form-control" name="kelas_rawat2" id="kelas_rawat2"
                                            readonly>
                                    </div>
                                    <div class="col-sm-2" id="myDIV_KelasHakRanap" style="display: none;">
                                        <!-- <input type=" rdio" class="form-check-input" id="radio1" name="optradio"
                                            value="option1" checked>
                                        Jalan -->
                                        <!-- <input type="radio" class="form-check-input" id="kelas_rawat" name="kelas_rawat"
                                            value="3" checked> Kelas 3
                                        <input type="radio" class="form-check-input" id="kelas_rawat" name="kelas_rawat"
                                            value="2">
                                        Kelas 2
                                        <input type="radio" class="form-check-input" id="kelas_rawat" name="kelas_rawat"
                                            value="1">
                                        Kelas 1 -->
                                        <select name="kelas_rawat" id="kelas_rawat" class="form-control" onchange="getUpgradeClass()">
                                            <option value="3" >Kelas 3</option>
                                            <option value="2" >Kelas 2</option>
                                            <option value="1" >Kelas 1</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Rawat Masuk</label>
                                    <div class="col-sm-2">
                                        <input type="datetime-local" class="form-control" name="tgl_masuk" id="tgl_masuk" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Pulang</label>
                                    <div class="col-sm-2">
                                        <input type="datetime-local" class="form-control" name="tgl_pulang" id="tgl_pulang" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Umur</label>
                                    <div class="col-sm-2">
                                        <input type="teks" class="form-control" name="umur" id="umur"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group" id="myDIV_KelasPelayanan" style="display: none;">
                                    <label for=" inputEmail3" class="col-sm-2 control-label">Kelas Pelayanan</label>
                                    <!-- <div class="col-sm-1">
                                        <input type="radio" class="form-check-input" id="upgrade_class_class" name="upgrade_class_class"
                                            value="kelas_3" checked> Kelas 3
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="radio" class="form-check-input" id="upgrade_class_class" name="upgrade_class_class"
                                            value="kelas_2">
                                        Kelas 2
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="radio" class="form-check-input" id="upgrade_class_class" name="upgrade_class_class"
                                            value="kelas_1">
                                        Kelas 1
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="radio" class="form-check-input" id="upgrade_class_class" name="upgrade_class_class"
                                            value="vip">
                                        Kelas VIP
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="radio" class="form-check-input" id="upgrade_class_class" name="upgrade_class_class"
                                            value="vvip">
                                        Kelas VVIP
                                    </div> -->
                                    <div class="col-sm-2">
                                    <select name="upgrade_class_class" id="upgrade_class_class" class="form-control" >
                                            <option value="kelas_3" >Kelas 3</option>
                                            <option value="kelas_2" >Kelas 2</option>
                                            <option value="kelas_1" >Kelas 1</option>
                                            <option value="vip" >Kelas VIP</option>
                                            <option value="vvip" >Kelas VVIP</option>
                                        </select>
                                    </div>
                                    <div id="naik_kelas_vip">
                                        <label for=" inputEmail3" class="col-sm-2 control-label">Koefesien Tambahan Biaya</label>
                                        <div class="col-sm-1">
                                                <input type="number" class="form-control" name="add_payment_pct"
                                                id="add_payment_pct" value="0">
                                            </div>
                                        <div class="col-sm-1">
                                            %
                                        </div>
                                    </div>
                                    <div id="naik_kelas_vip2" class="col-sm-4" style="display:none">
                                    </div>

                                    <label for="inputEmail3" class="col-sm-1 control-label">Lama(Hari)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" name="upgrade_class_los"
                                            id="upgrade_class_los">
                                    </div>
                                </div>

                                <div class="form-group" id="myDIV_CovidRanap" style="display:none" >
                                    <label for=" inputEmail3" class="col-sm-2 control-label">RS Darurat / Lapangan</label>
                                    <div class="col-sm-2">
                                    <select name="covid19_rs_darurat_ind" id="covid19_rs_darurat_ind" class="form-control" onchange="Is_isoman_ind(this)">
                                            <option value="0" >Tidak</option>
                                            <option value="1" >Ya</option>
                                        </select>
                                    </div>

                                    <label for="inputEmail3" class="col-sm-5 control-label">Isolasi di RS</label>
                                    <div class="col-sm-2">
                                    <select name="isoman_ind" id="isoman_ind" class="form-control" onchange="Is_isoman_ind(this)">
                                            <option value="0" >Tidak</option>
                                            <option value="1" >Ya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="myDIV_RawatIntensifInput" style="display : none;">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Ventilator (Jam)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" name="ventilator_hour"
                                            id="ventilator_hour">
                                    </div>
                                    <!-- <label for="inputEmail3" class="col-sm-2 control-label">Jam</label>
                                    <div class="col-sm-1">
                                        <input type="teks" class="form-control" name="SensusTanggal" id="SensusTanggal"
                                            readonly>
                                    </div> -->
                                    <label for="inputEmail3" class="col-sm-5 control-label">Rawat Intensif
                                        (Hari)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" name="icu_los"
                                            id="icu_los">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">LOS</label>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Hari</label>
                                    <div class="col-sm-1">
                                        <input type="teks" class="form-control" name="los" id="los"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jam</label>
                                    <div class="col-sm-1">
                                        <input type="teks" class="form-control" name="los_jam" id="los_jam"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Berat Lahir(Gram)</label>
                                    <div class="col-sm-2">
                                        <input type="teks" class="form-control" name="birth_weight" id="birth_weight"
                                            readonly>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">ADL Score</label>
                                    <label for="inputEmail3" class="col-sm-1 control-label">SUB Acute</label>
                                    <div class="col-sm-1">
                                        <input type="teks" class="form-control" name="adl_sub_acute" id="adl_sub_acute" value="-"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Chronic</label>
                                    <div class="col-sm-1">
                                        <input type="teks" class="form-control" name="adl_chronic" id="adl_chronic" value="-"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Cara Pulang</label>
                                    <div class="col-sm-2">
                                        <select name="discharge_status" id="discharge_status" class="form-control" onchange="getJaminanCovid()">
                                            <option value="1">Atas persetujuan dokter</option>
                                            <option value="2">Dirujuk</option>
                                            <option value="3">Atas permintaan sendiri</option>
                                            <option value="4">Meninggal</option>
                                            <option value="5">Lain-lain</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">DPJP</label>
                                    <div class="col-sm-3">
                                        <!-- <select name="cob_cd" id="cob_cd" class="form-control">
                                            <option value=""> Pilih </option>
                                            <option value="1"> -</option>
                                        </select> -->
                                        <input type="teks" class="form-control" name="nama_dokter" id="nama_dokter"
                                            readonly>

                                    </div>
                                    <label for="inputEmail3" class="col-sm-4 control-label">Jenis Tarif</label>
                                    <div class="col-sm-2">
                                        <select name="kode_tarif" id="kode_tarif" class="form-control">
                                            <option value="BS">TARIF RS KELAS B SWASTA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="myDIV_TarifPoli" style="display: none;">
                                    <label for="inputEmail3" class="col-sm-9 control-label">Tarif Poli Eks. </label>
                                    <div class="col-sm-2">
                                        <input type="teks" class="form-control" name="tarif_poli_eks" id="tarif_poli_eks">
                                    </div>
                                </div>
                                <div class="form-group" id="myDIV_Co" style="display: none;">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Co-Insidense
                                        COVID-19</label>
                                    <div class="col-sm-1">
                                        <input type="checkbox" id="covid19_co_insidense_ind" name="covid19_co_insidense_ind" value="1"
                                            onclick="myFunctionCoYa()"> Ya
                                    </div>
                                    <div class="col-sm-2" id="myDIV_NoKlaim" style="display: none;">
                                        <input type="teks" placeholder="Nomor klaim COVID-19" class="form-control"
                                            name="covid19_no_sep" id="covid19_no_sep">
                                    </div>
                                    <!-- <div class="col-sm-1" id="myDIV_Validasi" style="display: none;"><a type="button"
                                            class="btn btn-primary btn-animated btn-wide" id="btnLoadInformation"
                                            name="btnLoadInformation"><span class="visible-content">Validasi</span><span
                                                class="hidden-content"><i class="fa fa-gear"></i></span></a></div> -->
                                </div>
                                <div class="form-group"  >
                                    <label for="inputEmail3" class="col-sm-2 control-label">Pasien TB</label>
                                    <!-- <div class="col-sm-1">
                                        <input type="checkbox" id="sitp_ind" name="sitp_ind" value="1"
                                            onclick="myFunctionCoYa()"> Ya
                                    </div> -->
                                    <div class="col-sm-2"  >
                                        <input type="teks" placeholder="Nomor Register SITB" class="form-control"
                                            name="nomor_register_sitb" id="nomor_register_sitb">
                                    </div>
                                    <div class="col-sm-2"  >
                                    <button type="button" class="btn-sm btn-default"
                                                id="btnValidasiSITB" name="btnValidasiSITB"> Validasi</button>
                                                <button type="button" class="btn-sm btn-default"
                                                id="btnValidasiSITBUbah" name="btnValidasiSITBUbah"> Ubah</button>
                                    </div>
                                </div>
                                <hr>
                                <!-- <div class="form-group" id>
                                    <label for="inputEmail3" class="col-sm-9 control-label">Tarif Poli Eks.
                                        COVID-19</label>
                                    <div class="col-sm-2">
                                        <input type="teks" class="form-control" name="SensusTanggal" id="SensusTanggal">
                                    </div>
                                </div> -->
                                <div class="form-group">  
                                    
                                    
                                    <label for="inputEmail3" class="col-sm-5 control-label" style="font-style: italic;"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total nilai tertagih pada perawatan dalam satu episode, tidak termasuk item tagihan pada Tarif Non INA-CBG yang tersebut dibawah."> ? </div>Tarif Rumah Sakit : RP.
                                    </label>
                                    
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="tarif_rs" id="tarif_rs" value="0"
                                            readonly>
                                    </div>
                                    <button type="button" class="btn btn-s btn-default" id="btnShowAutoGenerate" name="btnShowAutoGenerate">Generate</button>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung."> ? </div> Prosedur Non Bedah
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="prosedur_non_bedah"
                                            id="prosedur_non_bedah" value="0" ">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> <div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik operatif maupun invasif yang dilakukan di kamar operasi."> ? </div> Prosedur Bedah
                                    </label>
                                    
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="prosedur_bedah"
                                            id="prosedur_bedah" value="0"  >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif untuk konsul, visite atau pun pemeriksaan oleh dokter umum/spesialis/sub-spesialis dalam satu episode."> ? </div> Konsultasi
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="konsultasi"
                                            id="konsultasi" value="0"  >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif untuk konsul atau visite tenaga ahli dalam satu episode, seperti contoh: konsul nutrisionis atau fisioterapis."> ? </div> Tenaga Ahli
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="tenaga_ahli"
                                            id="tenaga_ahli" value="0"  >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan keperawatan seperti buka jahitan, perawatan luka, dan lainnya dalam satu episode."> ? </div> Keperawatan
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="keperawatan"
                                            id="keperawatan" value="0"  >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan penunjang di luar laboratorium maupun radiologi dalam satu episode, seperti contoh Echo, EKG, Holter, dll."> ? </div> Penunjang
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="penunjang"
                                            id="penunjang" value="0"  >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif untuk pemeriksaan radiologi dalam satu episode, meliputi diantaranya X-Ray, USG, MRI, CT-Scan, Angiogram, dll."> ? </div> Radiologi
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="radiologi"
                                            id="radiologi" value="0"  >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif untuk pemeriksaan laboratorium dalam satu episode, meliputi diantaranya Mikrobiologi, Patologi Anatomi, Patologi Klinik, Hematologi, Hemostasis, dll."> ? </div> Laboratorium
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="laboratorium"
                                            id="laboratorium" value="0"  >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif pemakaian darah dalam satu episode."> ? </div> Pelayanan Darah
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="pelayanan_darah"
                                            id="pelayanan_darah" value="0"  >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan rehabilitasi, meliputi Fisioterapi, Terapi Okupasi, Rehabilitasi Psikososial, dll."> ? </div> Rehabilitasi
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="rehabilitasi"
                                            id="rehabilitasi" value="0"  >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif kamar/akomodasi pasien dalam satu episode, termasuk recovery room, tarif administrasi pasien baik rawat jalan maupun rawat inap."> ? </div> Kamar / Akomodasi
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="kamar"
                                            id="kamar" value="0"  >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif kamar/akomodasi pasien di ruang intensif dalam satu episode. Misal: ICU, ICCU, NICU, PICU, HCU, dll."> ? </div> Rawat Intensif
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="rawat_intensif"
                                            id="rawat_intensif" value="0"  >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif obat-obatan yg diberikan selama episode pelayanan rawat inap atau rawat jalan (untuk 7 hari) diluar obat kemoterapi dan diluar obat kronis untuk 23 hari."> ? </div> Obat
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="obat"
                                            id="obat" value="0" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif obat-obatan yg diberikan kepada pasien rawat jalan untuk 23 hari."> ? </div> Obat Kronis
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="obat_kronis"
                                            id="obat_kronis" value="0" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif obat-obatan kemoterapi rawat jalan maupun rawat inap dalam satu episode pelayanan."> ? </div> Obat Kemoterapi
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="obat_kemoterapi"
                                            id="obat_kemoterapi" value="0" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif alat kesehatan yang diberikan kepada pasien dalam satu episode. Misalkan: Stent, Implan, dll."> ? </div> Alkes
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="alkes"
                                            id="alkes" value="0" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="BMHP = Bahan Medis Habis Pakai. Yaitu total tarif bahan medis habis pakai, di luar paket perawatan yang diberikan kepada pasien selama satu episode perawatan, seperti contoh : pemakaian oksigen, jelly, alkohol, dsb."> ? </div> BMHP
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="bmhp"
                                            id="bmhp" value="0" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Total tarif sewa alat medis yang digunakan dalam tindakan tertentu, seperti contoh: Ventilator, Nebulizer, Syringe Pump, dll."> ? </div> Sewat Alat
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="sewa_alat"
                                            id="sewa_alat" value="0" >
                                    </div>
                                </div>
                                <div id="covid_meninggal" style="display: none;">
                                <div class="form-group">
                                <hr>
                                    <h5 style="text-align:center"><small style="font-style: italic;"> Khusus pasien COVID-19 yang meninggal dunia:</small></h5>
                                </div>
                                <hr>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">
                                    </label>
                                    <div class="col-sm-2" id="myDIV_null">
                                        <input type="checkbox" id="pemulasaraan_jenazah" name="pemulasaraan_jenazah" value="5"> Pemulasaraan Jenazah
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">
                                    </label>
                                    <div class="col-sm-2" id="myDIV_null">
                                        <input type="checkbox" id="kantong_jenazah" name="kantong_jenazah" value="1"> Kantong Jenazah
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">
                                    </label>
                                    <div class="col-sm-2" id="myDIV_null">
                                        <input type="checkbox" id="peti_jenazah" name="peti_jenazah" value="1" > Peti Jenazah
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">
                                    </label>
                                    <div class="col-sm-2" id="myDIV_null">
                                        <input type="checkbox" id="plastik_erat" name="plastik_erat" value="1"> Plastik Erat
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">
                                    </label>
                                    <div class="col-sm-2" id="myDIV_null">
                                        <input type="checkbox" id="desinfektan_jenazah" name="desinfektan_jenazah" value="1"> Desinfektan Jenazah
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">
                                    </label>
                                    <div class="col-sm-2" id="myDIV_null">
                                        <input type="checkbox" id="mobil_jenazah" name="mobil_jenazah" value="1" > Transport Mobil
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">
                                    </label>
                                    <div class="col-sm-2" id="myDIV_null">
                                        <input type="checkbox" id="desinfektan_mobil_jenazah" name="desinfektan_mobil_jenazah" value="1"> Desinfektan Mobil
                                    </div>
                                </div>
                                </div>
                                <div id="kantong_plasma" style="display: none">
                                <div class="form-group">
                                <hr>
                                    <h5 style="text-align:center"><small style="font-style: italic;"> Tambahan Terapi Plasma Konvalesen @ Rp 2.250.000,- / kantong: </small></h5>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Jumlah Kantong Plasma:
                                    </label>
                                    
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" name="terapi_konvalesen" id="terapi_konvalesen" value="0"
                                            >
                                    </div>
                                </div>
                                </div>

                                <hr>
                                <h5 style="text-align:center"><small style="font-style: italic;"> &#128505; Menyatakan
                                        benar
                                        bahwa data
                                        tarif yang tersebut di atas adalah benar sesuai dengan kondisi yang
                                        sesungguhnya.</small></h5>
                                <hr style="border: 1px solid black;">

                                    <div id="upload_file_covid">
                                <div class="form-group">  
                                    
                                    <label for="inputEmail3" class="col-sm-7 control-label"> <font size="3"> Unggah Berkas Pendukung Klaim </font>
                                    </label>

                                </div>
                                <div class="form-group">  
                                    <br>
                                    
                                    <label type="hide" for="inputEmail3" class="col-sm-2 control-label"><font size="2"> Resume Medis</font>
                                    </label>
                                    <label for="inputEmail3" class="col-sm-1 control-label"> 
                                    </label>
                                    <div class="col-sm-7">
                                        <input class="form-control form-control-sm" id="file_ResumeMedis" name="file_ResumeMedis"
                                            type="file" accept="application/pdf"/>
                                    </div>
                                    <div class="col-sm-2">
                                            <button type="button" name="btn_Upload_Resume" id="btn_Upload_Resume" class="btn btn-default"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload</button></div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="list_data_resume">
                                            <table id="table_file_resume_medis" class="table table-striped table-bordered table-sm" cellspacing="1"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            No
                                                        </td>
                                                        <td>
                                                            Nama File
                                                        </td>
                                                        <td>
                                                            Tanggal Upload
                                                        </td>
                                                        <td>
                                                            User Upload
                                                        </td>
                                                        <td>
                                                            Action
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                    </div>
                                <div class="form-group">  
                                    <br>
                                    
                                    <label type="hide" for="inputEmail3" class="col-sm-2 control-label"><font size="2"> Kartu Identitas </font>
                                    </label>
                                    <label for="inputEmail3" class="col-sm-1 control-label"> 
                                    </label>
                                    <div class="col-sm-7">
                                        <input class="form-control form-control-sm" id="file_KartuIdentitas" name="file_KartuIdentitas"
                                            type="file" accept="application/pdf"/>
                                    </div>
                                    <div class="col-sm-2">
                                            <button type="button" name="btn_Upload_KartuIdentitas" id="btn_Upload_KartuIdentitas" class="btn btn-default"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload</button></div>
                                            
                                </div>

                                    <div role="tabpanel" class="tab-pane" id="list_data_kartuidentitas">
                                            <table id="table_file_kartuidentitas" class="table table-striped table-bordered table-sm" cellspacing="1"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            No
                                                        </td>
                                                        <td>
                                                            Nama File
                                                        </td>
                                                        <td>
                                                            Tanggal Upload
                                                        </td>
                                                        <td>
                                                            User Upload
                                                        </td>
                                                        <td>
                                                            Action
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                    </div>

                                <div class="form-group">  
                                    <br>
                                    <label type="hide" for="inputEmail3" class="col-sm-2 control-label"><font size="2"> Surat Bebas Biaya </font>
                                    </label>
                                    <label for="inputEmail3" class="col-sm-1 control-label"> 
                                    </label>
                                    <div class="col-sm-7">
                                        <input class="form-control form-control-sm" id="file_BebasBiaya" name="file_BebasBiaya"
                                            type="file" accept="application/pdf"/>
                                    </div>
                                    <div class="col-sm-2">
                                            <button type="button" name="btn_Upload_BebasBiaya" id="btn_Upload_BebasBiaya" class="btn btn-default"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload</button></div>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="list_data_bebasbiaya">
                                            <table id="table_file_bebasbiaya" class="table table-striped table-bordered table-sm" cellspacing="1"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            No
                                                        </td>
                                                        <td>
                                                            Nama File
                                                        </td>
                                                        <td>
                                                            Tanggal Upload
                                                        </td>
                                                        <td>
                                                            User Upload
                                                        </td>
                                                        <td>
                                                            Action
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                    </div>

                                <div class="form-group">  
                                    <br>
                                    <label type="hide" for="inputEmail3" class="col-sm-2 control-label"><font size="2"> Surat Kematian </font>
                                    </label>
                                    <label for="inputEmail3" class="col-sm-1 control-label"> 
                                    </label>
                                    <div class="col-sm-7">
                                        <input class="form-control form-control-sm" id="file_SuratKematian" name="file_SuratKematian"
                                            type="file" accept="application/pdf"/>
                                    </div>
                                    <div class="col-sm-2">
                                            <button type="button" name="btn_Upload_SuratKematian" id="btn_Upload_SuratKematian" class="btn btn-default"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload</button></div>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="list_data_suratkematian">
                                            <table id="table_file_suratkematian" class="table table-striped table-bordered table-sm" cellspacing="1"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            No
                                                        </td>
                                                        <td>
                                                            Nama File
                                                        </td>
                                                        <td>
                                                            Tanggal Upload
                                                        </td>
                                                        <td>
                                                            User Upload
                                                        </td>
                                                        <td>
                                                            Action
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                    </div>

                                <hr style="border: 1px solid black;">
                                    </div>
                            </form>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs border-bottom border-dark" role="tablist">
                                     <li role="presentation"><a class="" href="#resume_medis_emr2"
                                            aria-controls="codingv5" role="tab" data-toggle="tab" id="resume_medis_emr" onclick="myFunctionCodingResume()">Resume Medis EMR</a>
                                    </li>
                                    <li role="presentation" class="active"><a class="" href="#codingv5"
                                            aria-controls="codingv5" role="tab" data-toggle="tab" id="myLi_Coding5"
                                            onclick="myFunctionCodingv5()">Coding Eklaim V5</a>
                                    </li>
                                    <li role="presentation"><a class="" href="#codingv6" aria-controls="codingv6"
                                            role="tab" data-toggle="tab" id="myLi_Coding6" style="display:none;"
                                            onclick="myFunctionCodingv6()">Coding
                                            Eklaim V6</a>
                                    </li>

                                </ul>
                                <!-- Tab panes -->

                                <div class="tab-content bg-white p-15">
                                    
                                <div role="tabpanel" class="tab-pane" id="resume_medis_emr2">
                                            <table id="table_resume_medis" class="table table-striped table-bordered table-sm" cellspacing="1"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            ID
                                                        </td>
                                                        <td>
                                                            Diagnosa Awal
                                                        </td>
                                                        <td>
                                                            Diagnosa Akhir
                                                        </td>
                                                        <td>
                                                            Komordibitas
                                                        </td>
                                                        <td>
                                                            Indikasi Masuk Rawat Inap
                                                        </td>
                                                        <td>
                                                            Temuan Fisik Lainnya
                                                        </td>
                                                        <td>
                                                            Riwayat Penyakit
                                                        </td>
                                                        <td>
                                                            Obat-Obatan
                                                        </td>
                                                        <td>
                                                            Obat-Obatan Pulang
                                                        </td>
                                                        <td>
                                                            Dokter
                                                        </td>
                                                        <td>
                                                            Tindak Lanjut
                                                        </td>
                                                        <td>
                                                            Discharge Condition
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                    </div>

                                <div role="tabpanel" class="tab-pane active" id="myDiv_Coding5">
                                        <!--isi-->
                                        <br>
                                        <div class="form-group gut">
                                                <button type="button" id="btnCopyDiagnosaEMR" name="btnCopyDiagnosaEMR" class="btn btn-sm btn-maroon">Import Diagnosa EMR</button>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label"> <font size="3">Diagnosa (ICD-10):</font>
                                            </label>
                                            <label type="hide" for="inputEmail3" class="col-sm-3 control-label">
                                            <input type="hidden" class="form-control" name="nama_diagnosa"
                                            id="nama_diagnosa" >
                                            <input type="hidden" class="form-control" name="kode_diagnosa"
                                            id="kode_diagnosa">
                                            </label>
                                            <div class="col-sm-5">
                                                <select name="search_diagnosis" id="search_diagnosis" class="form-control" style="width: 100%">
                                                </select>
                                                <!-- <input class="form-control containerX" id="search_diagnosis" name="search_diagnosis" type="text" placeholder="Ketik kata kunci"> -->
                                            </div>
                                            <div class="col-sm-1">
                                            <button type="button" id="addDiagnosa" name="addDiagnosa" class="btn btn-sm btn-default">Add</button>
                                            </div>
                                        </div>

                                        <div class="demo-table">
                                            <table id="table_diagnosa_v5" class="table table-striped table-bordered table-sm" cellspacing="1"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            No
                                                        </td>
                                                        <td>
                                                            Diagnosa
                                                        </td>
                                                        <td>
                                                            Kode Diagnosa
                                                        </td>
                                                        <td>
                                                            Status
                                                        </td>
                                                        <td>
                                                            Action
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>


                                        <hr>
                                        
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">
                                            <font size="3">Prosedur (ICD-9-CM):</font>
                                            </label>
                                            <label type="hide" for="inputEmail3" class="col-sm-3 control-label">
                                            <input type="hidden" class="form-control" name="nama_prosedur"
                                            id="nama_prosedur" >
                                            <input type="hidden" class="form-control" name="kode_prosedur"
                                            id="kode_prosedur">
                                            </label>
                                            <div class="col-sm-5">
                                            <select name="search_procedures" id="search_procedures" class="form-control" style="width: 100%">
                                            <!-- <input class="form-control containerX" id="search_procedures" name="search_procedures" type="text" placeholder="Ketik kata kunci"> -->
                                        </select>
                                            </div>
                                            <div class="col-sm-1">
                                            <button type="button" id="addProsedur" name="addProsedur" class="btn btn-sm btn-default">Add</button>
                                            </div>
                                        </div>

                                        <div class="demo-table">
                                            <table id="table_prosedur_v5" class="table table-striped table-bordered table-sm" cellspacing="1"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            No
                                                        </td>
                                                        <td>
                                                            Prosedur
                                                        </td>
                                                        <td>
                                                            Kode Prosedur
                                                        </td>
                                                        <td>
                                                            Action
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>
                                        

                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="myDiv_Coding6" style="display:none;">
                                    <a href="javascript:void(0);" type="button" id="import_coding" name="import_coding" style="float: right;margin-right:50px"><u>[ Import Coding ]</u></a><br><br>
                                        <!--isi-->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label"> <font size="3">Diagnosa (ICD-10):</font>
                                            </label>
                                            <label type="hide" for="inputEmail3" class="col-sm-3 control-label">
                                            <input type="hidden" class="form-control" name="nama_diagnosav6"
                                            id="nama_diagnosav6" >
                                            <input type="hidden" class="form-control" name="kode_diagnosav6"
                                            id="kode_diagnosav6">
                                            </label>
                                            <div class="col-sm-5">
                                                <select name="search_diagnosis" id="search_diagnosisv6" class="form-control" style="width: 100%">
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                            <button type="button" id="addDiagnosav6" name="addDiagnosav6" class="btn btn-sm btn-default">Add</button>
                                            </div>
                                        </div>

                                        <div class="demo-table">
                                            <table id="table_diagnosa_v6" class="table table-striped table-bordered table-sm" cellspacing="1"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            No
                                                        </td>
                                                        <td>
                                                            Diagnosa
                                                        </td>
                                                        <td>
                                                            Kode Diagnosa
                                                        </td>
                                                        <td>
                                                            Status
                                                        </td>
                                                        <td>
                                                            Action
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>
                                        
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">
                                            <font size="3">Prosedur (ICD-9-CM):</font>
                                            </label>
                                            <label type="hide" for="inputEmail3" class="col-sm-3 control-label">
                                            <input type="hidden" class="form-control" name="nama_prosedurv6"
                                            id="nama_prosedurv6" >
                                            <input type="hidden" class="form-control" name="kode_prosedurv6"
                                            id="kode_prosedurv6">
                                            </label>
                                            <div class="col-sm-5">
                                            <select name="search_proceduresv6" id="search_proceduresv6" class="form-control" style="width: 100%">
                                        </select>
                                            </div>
                                            <div class="col-sm-1">
                                            <button type="button" id="addProsedurv6" name="addProsedurv6" class="btn btn-sm btn-default">Add</button>
                                            </div>
                                        </div>

                                        <div class="demo-table">
                                            <table id="table_prosedur_v6" class="table table-striped table-bordered table-sm" cellspacing="1"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            No
                                                        </td>
                                                        <td>
                                                            Prosedur
                                                        </td>
                                                        <td>
                                                            Kode Prosedur
                                                        </td>
                                                        <td>
                                                            Status
                                                        </td>
                                                        <td>
                                                        <div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Jumlah tindakan dilakukan dalam satu setting"> ? </div>Jumlah 
                                                        </td>
                                                        <td>
                                                            Action
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <!-- <div class="col-sm-9">
                                            <button type="button" class="btn btn-danger btn-animated btn-wide"
                                                id="btnLoadInformation" name="btnLoadInformation"><span
                                                    class="visible-content">Hapus Klaim</span><span
                                                    class="hidden-content"><i class="fa fa-gear"></i></span></button>
                                        </div>

                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-success btn-animated btn-wide"
                                                id="btnLoadInformation" name="btnLoadInformation"><span
                                                    class="visible-content">Simpan</span><span class="hidden-content"><i
                                                        class="fa fa-gear"></i></span></button>
                                        </div>

                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-warning btn-animated btn-wide"
                                                id="btnLoadInformation" name="btnLoadInformation"><span
                                                    class="visible-content">Grouper</span><span
                                                    class="hidden-content"><i class="fa fa-gear"></i></span></button>
                                        </div> -->
                                    </div>
                                    

                                    <!-- <div role="tabpanel" class="tab-pane" id="pendidikan">
                                        
                                    </div> -->

                                </div>
                                <div class="col-sm-3">
                                            <a type="button" class="btn btn-danger btn-animated btn-wide"
                                                id="btnHapusKlaim" name="btnHapusKlaim"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus Klaim</a>
                                        </div>

                                        <div class="form-group" style="float: right;margin-right:50px">
                                        <button type="button" class="btn btn-success btn-animated btn-wide"
                                                id="btnSave" name="btnSave"><i class="fa fa-save"></i> Simpan & Grouper</button>
                                                <!-- <a type="button" class="btn btn-warning btn-animated btn-wide"
                                                id="btnGrouper" name="btnGrouper"><i class="fa fa-object-group" aria-hidden="true"></i> Grouper</a> -->
                                                </div>

                                        <div class="col-sm-1">
                                          
                                        </div>

                                        <div class="col-sm-1">
                                           
                                        </div>
                                                <br><br>
                                                <div class="alert alert-info" role="alert">
                                              <strong>Perhatian !</strong> Pastikan Klik Simpan & Grouper Sebelum Final Klaim.
                                          </div>
                            <div class="panel-body p-20" id="hasil_grouper_v5" style="display: none">
                                <table id="hasilgrouperv5" class="table table-striped table-bordered table-sm" cellspacing="0"
                                    width="100%">
                                    <tr>
                                            <th colspan="5" style="text-align: center;" id="header_v5">
                                            <font size="3"> Hasil Grouper E-Klaim v5
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Info
                                            </th>
                                            <th colspan="4" id="info">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Jenis Rawat
                                            </th>
                                            <th colspan="4" id="jenis_rawat_grouper">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Group
                                            </th>
                                            <td id="cbg_description">

                                            </td>
                                            <td id="cbg_code">

                                            </td>
                                            <th>
                                                Rp
                                            </th>
                                            <td id="cbg_tarif" style="text-align:right">
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Sub Acute
                                            </th>
                                            <th>
                                                -
                                            </th>
                                            <th>
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Chronic
                                            </th>
                                            <th>
                                                -
                                            </th>
                                            <th>
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Special Procedure
                                            </th>
                                            <th>
                                            <select name="sp_procedure" id="sp_procedure" class="form-control" style="width: 100%" onchange="goGrouper_stage2()">
                                            <option value="">None</option>
                                        </select>
                                            </th>
                                            <th id="sp_procedure_code">
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="sp_procedure_tarif" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Special Prosthesis
                                            </th>
                                            <th>
                                            <select name="sp_prosthesis" id="sp_prosthesis" class="form-control" style="width: 100%" onchange="goGrouper_stage2()">
                                            <option value="">None</option>
                                        </select>
                                            </th>
                                            <th id="sp_prosthesis_code">
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="sp_prosthesis_tarif" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Special Investigation
                                            </th>
                                            <th>
                                            <select name="sp_investigation" id="sp_investigation" class="form-control" style="width: 100%" onchange="goGrouper_stage2()">
                                            <option value="">None</option>
                                        </select>
                                            </th>
                                            <th id="sp_investigation_code">
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="sp_investigation_tarif" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Special Drug
                                            </th>
                                            <th>
                                            <select name="sp_drug" id="sp_drug" class="form-control" style="width: 100%" onchange="goGrouper_stage2()">
                                            <option value="">None</option>
                                        </select>
                                            </th>
                                            <th id="sp_drug_code">
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="sp_drug_tarif" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Status DC Kemkes
                                            </th>
                                            <th id="status_dc_kemkes" colspan="4">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Status Klaim
                                            </th>
                                            <th id="status_klaim" colspan="4">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" style="text-align:center">
                                                Total
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="total_grouper" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                      
                                        <input type="hidden" id="total_grouper_input" name="total_grouper_input" readonly >
                                    <tbody>
                                    </tbody>
                                </table>
                        </div>

                        <div class="panel-body p-20" id="hasil_grouper_v6" style="display : none">
                                <table id="hasilgrouperv6" class="table table-striped table-bordered table-sm" cellspacing="0"
                                    width="100%">
                                    <tr>
                                            <th colspan="5" style="text-align: center;" id="header_v6">
                                            <font size="3"> Hasil Grouper E-Klaim v6
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Info
                                            </th>
                                            <th colspan="4" id="info_v6">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Jenis Rawat
                                            </th>
                                            <th colspan="4" id="jenis_rawat_grouper_v6">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                MDC
                                            </th>
                                            <th id="mdc_description" colspan="2">
                                            </th>
                                            <th id="mdc_number">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                DRG
                                            </th>
                                            <th id="drg_description" colspan="2">
                                            </th>
                                            <th id="drg_code">
                                            </th>
                                        </tr>
                                    <tbody>
                                    </tbody>
                                </table>
                        </div>

                        <div class="form-group" id="final_button" style="display: none;">
                                        <button type="button" class="btn btn-default btn-animated btn-wide"
                                                id="btnCetakKlaim" name="btnCetakKlaim" disabled><span class="glyphicon glyphicon-print"></span> Cetak Klaim</button>
                                            <button type="button" class="btn btn-default btn-animated btn-wide"
                                                id="btnKirimKlaimOnline" name="btnKirimKlaimOnline" disabled><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Kirim Klaim Online</button>

                                                <div class="form-group" style="float: right;margin-right:50px">
                                                <!-- <button type="button" class="btn btn-default btn-animated btn-wide"
                                                id="btnCoInsidenseCovid" name="btnCoInsidenseCovid"><i class="fa fa-external-link" aria-hidden="true"></i> Co-Insidense Covid</button> -->
                                            <button type="button" class="btn btn-primary btn-animated btn-wide"
                                                id="btnFinalClaim" name="btnFinalClaim"><i class="fa fa-check" aria-hidden="true"></i> Final Klaim</button>
                                                <button type="button" class="btn btn-info btn-animated btn-wide"
                                                id="btnReeditClaim" name="btnReeditClaim" disabled><i class="fa fa-pencil" aria-hidden="true"></i> Edit Ulang Klaim</button>
                                                </div>
                        </div>

                        <!-- <div class="panel-body p-20" id="hasil_grouper_v5" style="display: none">
                                <table id="hasilgrouperv5" class="table table-striped table-bordered table-sm" cellspacing="0"
                                    width="100%">
                                    <tr>
                                            <th colspan="5" style="text-align: center;">
                                            <font size="3"> Hasil Grouper E-Klaim v5
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Info
                                            </th>
                                            <th colspan="4" id="info">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Jenis Rawat
                                            </th>
                                            <th colspan="4" id="jenis_rawat_grouper">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Group
                                            </th>
                                            <td id="cbg_description">

                                            </td>
                                            <td id="cbg_code">

                                            </td>
                                            <th>
                                                Rp
                                            </th>
                                            <td id="cbg_tarif" style="text-align:right">
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Sub Acute
                                            </th>
                                            <th>
                                                -
                                            </th>
                                            <th>
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Chronic
                                            </th>
                                            <th>
                                                -
                                            </th>
                                            <th>
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Special Procedure
                                            </th>
                                            <th>
                                            <select name="sp_procedure" id="sp_procedure" class="form-control" style="width: 100%" onchange="goGrouper_stage2()">
                                            <option value="">None</option>
                                        </select>
                                            </th>
                                            <th id="sp_procedure_code">
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="sp_procedure_tarif" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Special Prosthesis
                                            </th>
                                            <th>
                                            <select name="sp_prosthesis" id="sp_prosthesis" class="form-control" style="width: 100%" onchange="goGrouper_stage2()">
                                            <option value="">None</option>
                                        </select>
                                            </th>
                                            <th id="sp_prosthesis_code">
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="sp_prosthesis_tarif" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Special Investigation
                                            </th>
                                            <th>
                                            <select name="sp_investigation" id="sp_investigation" class="form-control" style="width: 100%" onchange="goGrouper_stage2()">
                                            <option value="">None</option>
                                        </select>
                                            </th>
                                            <th id="sp_investigation_code">
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="sp_investigation_tarif" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Special Drug
                                            </th>
                                            <th>
                                            <select name="sp_drug" id="sp_drug" class="form-control" style="width: 100%" onchange="goGrouper_stage2()">
                                            <option value="">None</option>
                                        </select>
                                            </th>
                                            <th id="sp_drug_code">
                                                -
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="sp_drug_tarif" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" style="text-align:center">
                                                Total
                                            </th>
                                            <th>
                                                Rp
                                            </th>
                                            <th id="total_grouper" style="text-align:right">
                                                0
                                            </th>
                                        </tr>
                                    <tbody>
                                    </tbody>
                                </table>
                        </div> -->

                       
<!--
                            <table class="xxfrm" style="width:100%;"><colgroup><col width="190"><col><col width="70"><col width="127"></colgroup>
                            <tbody>
                                <tr>
                                    <td colspan="4" style="text-align:center;" class="hdr_grouper_result">Hasil Grouper E-Klaim v5</td></tr><tr><td>Info</td>
                                    <td colspan="3">Ulul mizana @ 27 Okt 2022 17:11 •• Kelas B •• Tarif : TARIF RS KELAS B SWASTA</td>
                                </tr>
                                <tr>
                                    <td>Jenis Rawat</td>
                                    <td>Rawat Jalan Regular</td>
                                    <td style="border-left:0px;">&nbsp;</td>
                                    <td style="border-left:0;text-align:right;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Group</td><td><table class="invisible" style="width:100%;"><colgroup><col><col width="70"></colgroup><tbody><tr><td>PROSEDUR OPERASI KATARAK</td><td>H-2-36-0</td></tr></tbody></table></td><td style="border-left:0px;">&nbsp;Rp</td><td style="border-left:0;text-align:right;">3,969,000</td></tr><tr><td>Sub Acute</td><td><table class="invisible" style="width:100%;"><colgroup><col><col width="70"></colgroup><tbody><tr><td>-</td><td>-</td></tr></tbody></table></td><td style="border-left:0px;">&nbsp;Rp</td><td style="border-left:0;text-align:right;">0</td></tr><tr><td>Chronic</td><td><table class="invisible" style="width:100%;"><colgroup><col><col width="70"></colgroup><tbody><tr><td>-</td><td>-</td></tr></tbody></table></td><td style="border-left:0px;">&nbsp;Rp</td><td style="border-left:0;text-align:right;">0</td></tr><tr><td>Special Procedure</td><td><table class="invisible" style="width:100%;"><colgroup><col><col width="70"></colgroup><tbody><tr><td><select class="selectizeit selectized" id="sp" style="width: 340px; display: none;" name="sp" onchange="redo_special(&quot;6747&quot;,&quot;30&quot;,this,event);" tabindex="-1"><option value="YY10" selected="selected">Phacoemulsification</option></select><div class="selectize-control selectizeit single" style="width: 340px;"><div class="selectize-input items full has-options has-items"><div data-value="YY10" class="item">Phacoemulsification</div><input type="text" autocomplete="off" tabindex="" style="width: 4px;"></div><div class="selectize-dropdown single selectizeit" style="display: none;"><div class="selectize-dropdown-content"></div></div></div></td><td>YY-10-III</td></tr></tbody></table></td><td style="border-left:0px;">&nbsp;Rp</td><td style="border-left:0;text-align:right;">3,969,000</td></tr><tr><td>Special Prosthesis</td><td><table class="invisible" style="width:100%;"><colgroup><col><col width="70"></colgroup><tbody><tr><td><select disabled="" class="selectizeit selectized" id="sr" style="width: 340px; display: none;" name="sr" onchange="redo_special(&quot;6747&quot;,&quot;30&quot;,this,event);" tabindex="-1"><option value="None" selected="selected">None</option></select><div class="selectize-control selectizeit single" style="width: 340px;"><div class="selectize-input items full has-options has-items disabled locked"><div data-value="None" class="item">None</div><input type="text" autocomplete="off" tabindex="-1" disabled="" style="width: 4px; display: none; opacity: 0; position: absolute; left: -10000px;"></div><div class="selectize-dropdown single selectizeit" style="display: none;"><div class="selectize-dropdown-content"></div></div></div></td><td>-</td></tr></tbody></table></td><td style="border-left:0px;">&nbsp;Rp</td><td style="border-left:0;text-align:right;">0</td></tr><tr><td>Special Investigation</td><td><table class="invisible" style="width:100%;"><colgroup><col><col width="70"></colgroup><tbody><tr><td><select disabled="" class="selectizeit selectized" id="si" style="width: 340px; display: none;" name="si" onchange="redo_special(&quot;6747&quot;,&quot;30&quot;,this,event);" tabindex="-1"><option value="None" selected="selected">None</option></select><div class="selectize-control selectizeit single" style="width: 340px;"><div class="selectize-input items full has-options has-items disabled locked"><div data-value="None" class="item">None</div><input type="text" autocomplete="off" tabindex="-1" disabled="" style="width: 4px; display: none; opacity: 0; position: absolute; left: -10000px;"></div><div class="selectize-dropdown single selectizeit" style="display: none;"><div class="selectize-dropdown-content"></div></div></div></td><td>-</td></tr></tbody></table></td><td style="border-left:0px;">&nbsp;Rp</td><td style="border-left:0;text-align:right;">0</td></tr><tr><td>Special Drug</td><td><table class="invisible" style="width:100%;"><colgroup><col><col width="70"></colgroup><tbody><tr><td><select disabled="" class="selectizeit selectized" id="sd" style="width: 340px; display: none;" name="sd" onchange="redo_special(&quot;6747&quot;,&quot;30&quot;,this,event);" tabindex="-1"><option value="None" selected="selected">None</option></select><div class="selectize-control selectizeit single" style="width: 340px;"><div class="selectize-input items full has-options has-items disabled locked"><div data-value="None" class="item">None</div><input type="text" autocomplete="off" tabindex="-1" disabled="" style="width: 4px; display: none; opacity: 0; position: absolute; left: -10000px;"></div><div class="selectize-dropdown single selectizeit" style="display: none;"><div class="selectize-dropdown-content"></div></div></div></td><td>-</td></tr></tbody></table></td><td style="border-left:0px;">&nbsp;Rp</td><td style="border-left:0;text-align:right;">0</td></tr><tr><td style="text-align:left;">[ <span class="xlnk" onclick="$(&quot;#trdebug&quot;).fadeToggle();">debug</span> ]</td><td style="border-left:0;font-weight:bold;text-align:right;" colspan="2">Total Rp</td><td style="border-left:0;font-weight:bold;text-align:right;">7,938,000</td></tr><tr id="trdebug" style="display:none;"><td colspan="4" style="border-top:0;text-align:left;color:#eee;font-family:Courier New;"><div style="background-color:#000;border-radius:0.5em;padding:1em;"><table class="invisible" align="center"><tbody><tr><td style="text-align:left;">input&nbsp;</td><td>: 2 26/10/2022 26/10/2022 30/08/2007 0 1 1 H26.9 13.41 - - YY10 None None None</td></tr><tr><td style="text-align:left;">response&nbsp;</td><td>: H-2-36-0;None;None;YY-10-III;None;None;None</td></tr></tbody></table></div></td></tr></tbody></table>
                                            -->
                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section list-->
    <section class="section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>RIWAYAT KLAIM <button type="button" class="btn btn-xs btn-default" id="btnShowRiwayatKlaim" name="btnShowRiwayatKlaim">Show</button>
                                </h5>
                                
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <div class="demo-table">
                                <table id="riwayat_klaim" class="table table-striped table-bordered table-sm" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">Tanggal Masuk
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tanggal Pulang
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jaminan
                                            </th>
                                            <th align='center'>
                                                <font size="1">No. SEP
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tipe
                                            </th>
                                            <th align='center'>
                                                <font size="1">CBG
                                            </th>
                                            <th align='center'>
                                                <font size="1">Status
                                            </th>
                                            <th align='center'>
                                                <font size="1">Petugas
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
<!-- TTD -->
<div class="modal fade" id="saksipasien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saksi Pasien</h5>
                <button id="ttdsaksirumahsakit" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Silahkan tanda tangan di dalam kotak
                <div class="signature-area" id="ttdsaksipasien">
                    <!-- <h2 class="title-area">Put signature,</h2> -->
                    <!-- <label>nama</label> -->
                    <!-- <input type="text" name="nama" id="nama"> -->
                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-save" id="btn_sakspasiensig">Save</button>
                <button class="btn-clear" id="clearttdrumahsakit">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="saksirumahsakit" tabindex="-1" role="dialog" aria-labelledby="saksirumahsakit"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saksi Rumah sakit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Silahkan tanda tangan di dalam kotak
                <div class="signature-area">
                    <!-- <h2 class="title-area">Put signature,</h2> -->
                    <!-- <label>nama</label> -->
                    <!-- <input type="text" name="nama" id="nama"> -->
                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-save" id="btn_saksirumahsakitsig">Save</button>
                <button class="btn-clear">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<!-- <div id="myDIV" style="display: none;">
    This is my DIV element 1.
</div>

<div id="myDIV2" style="display: none;">
    This is my DIV element 2.
</div> -->


<!-- TTD -->

<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/Eklaim/Eklaim_View.js"></script>
