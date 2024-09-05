<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>

<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Menampilkan Data <?= $data['judul'] ?>.</p>
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div>

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-link btn-sm " id="btncreateSensusHarianRanap"
                                            onclick="gocreatesensusranap();">
                                            <span class="glyphicon glyphicon glyphicon-plus"></span> Tambah Surveilans
                                            Harian Rawat Inap</a>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-link btn-sm " id="btncreateSensusHarianRajal"
                                            onclick="gocreatesensusrajal();">
                                            <span class="glyphicon glyphicon glyphicon-plus"></span> Tambah Surveilans
                                            Harian Rawat Jalan</a>
                                    </div>
                                </h5>
                            </div>

                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tipe Rawat</label>
                                    <div class="col-sm-3">
                                        <select class="form-control js-example-basic-single" id="TipeRawat"
                                            name="TipeRawat">
                                            <option value="ALL">Semua</option>
                                            <option value="Rawat Inap">Rawat Inap</option>
                                            <option value="Rawat Jalan">Rawat Jalan</option>
                                        </select>
                                    </div>

                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Ruang Rawat <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select class="form-control js-example-basic-single" id="RuangRawat"
                                            name="RuangRawat">
                                            <option value="ALL">Semua</option>
                                            <!-- rawat inap -->
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
                                            <!-- rawat jalan -->
                                            <option value="INSTALASI GAWAT DARURAT">INSTALASI GAWAT DARURAT
                                            </option>
                                            <option value="POLIKLINIK">POLIKLINIK
                                            </option>
                                            <option value="KAMAR OPERASI">KAMAR OPERASI
                                            </option>
                                            <option value="HEMODALISA">HEMODALISA
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="PeriodeAwal"
                                            onfocusout="TrigerTgl()" id="PeriodeAwal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">S/d</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="PeriodeAkhir"
                                            onfocusout="TrigerTgl()" id="PeriodeAkhir">
                                    </div>
                                    <div class="col-sm-1">
                                        <a type="button" class="btn btn-success btn-animated btn-wide"
                                            id="btnLoadInformation" name="btnLoadInformation"><span
                                                class="visible-content">Load</span><span class="hidden-content"><i
                                                    class="fa fa-gear"></i></span></a>
                                    </div>
                                </div>
                            </form>

                            <!-- <div class="table-responsive" style="margin-top: 70px;"> -->
                            <div class="demo-table" style="overflow-x:auto;">
                                <table id="example" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center' rowspan="2">
                                                <font size="1">Tanggal
                                            </th>
                                            <th align='center' rowspan="2">
                                                <font size="1">Jumlah
                                            </th>
                                            <th align='center' rowspan="2">
                                                <font size="1">Opr
                                            </th>
                                            <th align='center' colspan="10">
                                                <font size="1">Jenis OP / Luka
                                            </th>
                                            <th align='center' colspan="5">
                                                <font size="1">Infus
                                            </th>
                                            <th align='center' rowspan="2">
                                                <font size="1">ETT Vent
                                            </th>
                                            <th align='center' rowspan="2">
                                                <font size="1"> VAP
                                            </th>
                                            <th align='center' rowspan="2">
                                                <font size="1">TB
                                            </th>
                                            <th align='center' rowspan="2">
                                                <font size="1">HAP
                                            </th>
                                            <th align='center' colspan="4">
                                                <font size="1">DEK
                                            </th>
                                            <th align='center' colspan="5">
                                                <font size="1"> PLEB
                                            </th>
                                            <th align='center' colspan="3">
                                                <font size="1">Jumlah Antibiotik
                                            </th>
                                            <th align='center' colspan="4">
                                                <font size="1">Jumlah Kuman
                                            </th>
                                            <th align='center' rowspan="2">
                                                <font size="1">Action
                                            </th>
                                        </tr>
                                        <tr>
                                            <td align='center'>
                                                <font size="1">B
                                            </td>
                                            <td align='center'>
                                                <font size="1">IDO B
                                            </td>
                                            <td align='center'>
                                                <font size="1">BC
                                            </td>
                                            <td align='center'>
                                                <font size="1">IDO BC
                                            </td>
                                            <td align='center'>
                                                <font size="1"> C
                                            </td>
                                            <td align='center'>
                                                <font size="1">IDO C
                                            </td>
                                            <td align='center'>
                                                <font size="1">K
                                            </td>
                                            <td align='center'>
                                                <font size="1">IDO K
                                            </td>
                                            <td align='center'>
                                                <font size="1"> WSD
                                            </td>
                                            <td align='center'>
                                                <font size="1">IDO WSD
                                            </td>
                                            <td align='center'>
                                                <font size="1">CVL
                                            </td>
                                            <td align='center'>
                                                <font size="1">IAD
                                            </td>
                                            <td align='center'>
                                                <font size="1">IVL
                                            </td>
                                            <td align='center'>
                                                <font size="1">UC
                                            </td>
                                            <td align='center'>
                                                <font size="1">ISK
                                            </td>
                                            <td align='center'>
                                                <font size="1">G1
                                            </td>
                                            <td align='center'>
                                                <font size="1">G2
                                            </td>
                                            <td align='center'>
                                                <font size="1">G3
                                            </td>
                                            <td align='center'>
                                                <font size="1">G4
                                            </td>
                                            <td align='center'>
                                                <font size="1">G1
                                            </td>
                                            <td align='center'>
                                                <font size="1">G2
                                            </td>
                                            <td align='center'>
                                                <font size="1">G3
                                            </td>
                                            <td align='center'>
                                                <font size="1">G4
                                            </td>
                                            <td align='center'>
                                                <font size="1">G5
                                            </td>
                                            <td align='center'>
                                                <font size="1">1
                                            </td>
                                            <td align='center'>
                                                <font size="1">2
                                            </td>
                                            <td align='center'>
                                                <font size="1">3
                                            </td>
                                            <td align='center'>
                                                <font size="1">D
                                            </td>
                                            <td align='center'>
                                                <font size="1">S
                                            </td>
                                            <td align='center'>
                                                <font size="1">Spt
                                            </td>
                                            <td align='center'>
                                                <font size="1">Ur
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th align='center'>
                                                <font size="1"> Resume
                                            </th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <br>
                            </div>
                            <br>
                            <!-- <a onclick="ExportFile()" class="btn btn-success btn-animated btn-wide"><span
                                    class="visible-content">Excel</span><span class="hidden-content"><i
                                        class="fa fa-gear"></i></span></a> -->
                            <!-- <p><a href="TestFile/ExcelFile.xlsx" download> Click to Download </a></p> -->
                            <!-- <a onclick="MyBack()" class="btn btn-warning waves-effect" id="btnBack"
                                            name="btnBack"><span class="glyphicon glyphicon glyphicon-home"
                                                aria-hidden="true"></span>
                                            Back To Registrasi RAJAL</a> -->

                            <div class="form-group">
                                <!-- <br>
                                <h5 class="col-sm-2">Tanggal Yang Belum Diinput :</h5>
                                <br>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="tglBelum" id="tglBelum" readonly>
                                </div> -->

                                <div class="demo-table" style="overflow-x:auto;">
                                    <h6>Keterangan :</h6>
                                    <table id="exampleKeterangan1" class="display" width="100%">
                                        <tbody>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">IVL
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Intra Vena Line/Vena
                                                </th>
                                                <th align='center'>
                                                    <font size="1">UC
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Urine Cateter
                                                </th>
                                                <th align='center'>
                                                    <font size="1">ETT/V
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Endatracheal Tube/Ventilator
                                                </th>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">IADP
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Infeksi Aliran Darah Primer
                                                </th>
                                                <th align='center'>
                                                    <font size="1">ISK
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Infeksi Saluran Kemih
                                                </th>
                                                <th align='center'>
                                                    <font size="1">VAP
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Ventilator Assosiated Pneumonia
                                                </th>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">HAP
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Hospital Acquired Pneumonia
                                                </th>
                                                <th align='center'>
                                                    <font size="1">AB
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Antibiotik
                                                </th>
                                                <th align='center'>
                                                    <font size="1">
                                                </th>
                                                <th align='center'>
                                                    <font size="1">
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="demo-table" style="overflow-x:auto;">
                                    <h6>Keterangan Tambahan : </h6>
                                    <table id="exampleKeterangan2" class="display" width="100%">
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">D
                                                </th>
                                                <th align='center'>
                                                    <font size="1">S
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Spt
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Ur
                                                </th>
                                                <th align='center'>
                                                    <font size="1">IDO B
                                                </th>
                                                <th align='center'>
                                                    <font size="1">IDO BC
                                                </th>
                                                <th align='center'>
                                                    <font size="1">IDO C
                                                </th>
                                                <th align='center'>
                                                    <font size="1">IDO K
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">Darah
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Swab
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Sputum
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Urin
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Bersih
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Bersih Contaminasi
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Contraminasi
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Kotor
                                                </th>
                                            </tr>
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
                    <button type="button" class="btn btn-success btn-labeled">Purchase Now<span
                            class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
<script src="<?= BASEURL; ?>/js/App/PPI/PPIListView_v2.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script> -->
<!-- <script src="<?= BASEURL; ?>/js/App/PPI/PPIListView_v2.js"></script> -->
<!-- <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script> -->