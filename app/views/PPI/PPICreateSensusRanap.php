<?php
date_default_timezone_set('Asia/Jakarta');
$id = "";
$datenowcreate = date("Y-m-d");
$datetimenow2222 = date("Y-m-d\TH:i:s");
?>

<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Silahkan Input Transaksi Disini.</p>
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
                                <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>)
                                        Harus diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_PPI">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">ID <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tipe Rawat <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="SensusTipeRawat" id="SensusTipeRawat" value="Rawat Inap" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="SensusTanggal" id="SensusTanggal">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Ruang Rawat <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="SensusRuangRawat" name="SensusRuangRawat">
                                            <option value="">Pilih</option>
                                            <option value="RAWAT INAP LT.5">RAWAT INAP LT.5</option>
                                            <option value="RAWAT INAP DEWASA LT.11">RAWAT INAP DEWASA LT.11</option>
                                            <option value="ICU LT.6">ICU LT.6</option>
                                            <option value="KEPERAWATAN UMUM DEWASA LT.9">KEPERAWATAN UMUM DEWASA LT.9
                                            </option>
                                            <option value="PICU LT.9">PICU LT.9</option>
                                            <option value="KEPERAWATAN ICU LT.10">KEPERAWATAN ICU LT.10</option>
                                            <option value="RAWAT INAP ANAK LT.9">RAWAT INAP ANAK LT.9</option>
                                            <option value="PERINATOLOGI LT.10">PERINATOLOGI LT.10</option>
                                            <option value="RAWAT INAP KEBIDANAN LT.10">RAWAT INAP KEBIDANAN LT.10
                                            </option>
                                            <option value="RAWAT INAP ISOLASI LT.8">RAWAT INAP ISOLASI LT.8</option>
                                            <option value="HCU LT.6">HCU LT.6</option>
                                            <option value="SCU LT.7">SCU LT.7</option>
                                            <option value="STROKE STROKE LT.7">STROKE STROKE LT.7</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jumlah Pasien<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" name="Sensusjumlah" id="Sensusjumlah">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jumlah Operasi<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" name="SensusOpr" id="SensusOpr" readonly>
                                        <small style="color:red">Jumlah Operasi = B+BC+C+K</small>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <H6>Jenis OP/Luka</H6>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">B : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusB" id="SensusB" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">IDO B : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusIDOB" id="SensusIDOB">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">BC : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusBC" id="SensusBC" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">IDO BC : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusIDOBC" id="SensusIDOBC">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">C : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusC" id="SensusC" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">IDO C : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusIDOC" id="SensusIDOC">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">K : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusK" id="SensusK" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">IDO K : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusIDOK" id="SensusIDOK">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">WSD : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusWSD" id="SensusWSD">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">IDO WSD : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusIDOWSD" id="SensusIDOWSD">
                                    </div>
                                </div>
                                <hr>
                                <h6>Infus</h6>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">CVL : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusCVL" id="SensusCVL">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">IAD : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusIAD" id="SensusIAD">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">IVL : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusIVL" id="SensusIVL">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">UC : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUC" id="SensusUC">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">ISK : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusISK" id="SensusISK">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">ETT VENT : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusETTVENT" id="SensusETTVENT">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">VAP : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusVAP" id="SensusVAP">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">TB : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusTB" id="SensusTB">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">HAP : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusHAP" id="SensusHAP">
                                    </div>
                                </div>
                                <hr>
                                <h6>DEK</h6>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">G1 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDEKG1" id="SensusDEKG1">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">G2 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDEKG2" id="SensusDEKG2">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">G3 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDEKG3" id="SensusDEKG3">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">G4 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDEKG4" id="SensusDEKG4">
                                    </div>
                                </div>
                                <hr>
                                <h6>PLEB</h6>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">G1 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusPLEBG1" id="SensusPLEBG1">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">G2 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusPLEBG2" id="SensusPLEBG2">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">G3 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusPLEBG3" id="SensusPLEBG3">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">G4 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusPLEBG4" id="SensusPLEBG4">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">G5 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusPLEBG5" id="SensusPLEBG5">
                                    </div>
                                </div>
                                <hr>
                                <h6>Jumlah Antibiotik</h6>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">1 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusJA1" id="SensusJA1">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">2 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusJA2" id="SensusJA2">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">3 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusJA3" id="SensusJA3">
                                    </div>
                                </div>
                                <hr>
                                <h6>Jumlah Kuman</h6>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Darah : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusJKD" id="SensusJKD" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Swab : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusJKS" id="SensusJKS" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Sputum : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusJKSPT" id="SensusJKSPT" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Urine : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusJKUR" id="SensusJKUR" readonly>
                                    </div>
                                </div>
                                <br>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM01 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM01" id="SensusDarahKM01" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM01 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM01" id="SensusSwabKM01" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM01 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM01" id="SensusSputumKM01" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM01 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM01" id="SensusUrineKM01" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM02 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM02" id="SensusDarahKM02" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM02 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM02" id="SensusSwabKM02" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM02 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM02" id="SensusSputumKM02" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM02 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM02" id="SensusUrineKM02" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM03 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM03" id="SensusDarahKM03" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM03 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM03" id="SensusSwabKM03" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM03 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM03" id="SensusSputumKM03" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM03 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM03" id="SensusUrineKM03" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM04 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM04" id="SensusDarahKM04" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM04 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM04" id="SensusSwabKM04" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM04 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM04" id="SensusSputumKM04" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM04 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM04" id="SensusUrineKM04" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM05 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM05" id="SensusDarahKM05" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM05 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM05" id="SensusSwabKM05" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM05 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM05" id="SensusSputumKM05" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM05 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM05" id="SensusUrineKM05" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM06 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM06" id="SensusDarahKM06" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM06 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM06" id="SensusSwabKM06" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM06 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM06" id="SensusSputumKM06" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM06 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM06" id="SensusUrineKM06" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM07 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM07" id="SensusDarahKM07" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM07 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM07" id="SensusSwabKM07" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM07 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM07" id="SensusSputumKM07" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM07 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM07" id="SensusUrineKM07" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM08 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM08" id="SensusDarahKM08" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM08 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM08" id="SensusSwabKM08" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM08 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM08" id="SensusSputumKM08" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM08 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM08" id="SensusUrineKM08" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM09 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM09" id="SensusDarahKM09" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM09 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM09" id="SensusSwabKM09" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM09 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM09" id="SensusSputumKM09" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM09 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM09" id="SensusUrineKM09" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM10 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM10" id="SensusDarahKM10" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM10 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM10" id="SensusSwabKM10" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM10 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM10" id="SensusSputumKM10" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM10 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM10" id="SensusUrineKM10" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM11 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM11" id="SensusDarahKM11" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM11 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM11" id="SensusSwabKM11" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM11 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM11" id="SensusSputumKM11" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM11 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM11" id="SensusUrineKM11" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM12 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM12" id="SensusDarahKM12" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM12 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM12" id="SensusSwabKM12" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM12 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM12" id="SensusSputumKM12" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM12 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM12" id="SensusUrineKM12" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM13 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM13" id="SensusDarahKM13" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM13 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM13" id="SensusSwabKM13" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM13 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM13" id="SensusSputumKM13" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM13 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM13" id="SensusUrineKM13" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM14 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM14" id="SensusDarahKM14" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM14 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM14" id="SensusSwabKM14" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM14 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM14" id="SensusSputumKM14" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM14 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM14" id="SensusUrineKM14" onkeyup="CalculateALL()">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">KM15 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusDarahKM15" id="SensusDarahKM15" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM15 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSwabKM15" id="SensusSwabKM15" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM15 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusSputumKM15" id="SensusSputumKM15" onkeyup="CalculateALL()">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">KM15 : </label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="SensusUrineKM15" id="SensusUrineKM15" onkeyup="CalculateALL()">
                                    </div>
                                </div>
                                <br>
                                <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                                <button class="btn bg-black btn-wide" id="btnsubmit" name="btnsubmit"><i class="fa fa-check"></i>Submit</button>
                                <hr>

                                <div class="demo-table" style="overflow-x:auto;">
                                    <h6> Keterangan </h6>
                                    <table id="example" class="display" width="100%">
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">Kode
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama Kuman
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM01
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Klebsiella Pneumoniae
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM02
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Acinetobacter Baumannii
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM03
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Pseudomonas Aeroginosa
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM04
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Escherichia Coli
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM05
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Staphylococcus Haemolyticus
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM06
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Staphylococcus Hominis
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM07
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Staphylococcus Aerus
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM08
                                                </th>
                                                <th align='center'>
                                                    <font size="1">MRSA(+)
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM09
                                                </th>
                                                <th align='center'>
                                                    <font size="1">ESBL(+)
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM10
                                                </th>
                                                <th align='center'>
                                                    <font size="1">VRSA(+)
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM11
                                                </th>
                                                <th align='center'>
                                                    <font size="1">KPC(+)
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM12
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Candida Anbicans
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM13
                                                </th>
                                                <th align='center'>
                                                    <font size="1">M.Tuberculosis
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM14
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Enterobacter Cloacae
                                                </th>
                                            </tr>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">KM15
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Lain Lain
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>

                            </form>

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
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/PPI/PPICreateSensusRanap.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script> -->