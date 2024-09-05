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
                                <h5><?= $data['judul'] ?> List
                                    <div class="btn-group" role="group">
                                        <!-- <a class="btn btn-link btn-sm " id="btncreateSensusHarianRanap"
                                            onclick="gocreatesensusranap();">
                                            <spa></span>View
                                        </a> -->
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
                                            <option value="KEPERAWATAN UMUM DEWASA LT.5">KEPERAWATAN UMUM DEWASA LT.5
                                            </option>
                                            <option value="KEPERAWATAN UMUM DEWASA LT.8">KEPERAWATAN UMUM DEWASA LT.8
                                            </option>
                                            <option value="KEPERAWATAN UMUM DEWASA LT.9">KEPERAWATAN UMUM DEWASA LT.9
                                            </option>
                                            <option value="KEPERAWATAN UMUM DEWASA LT.11">KEPERAWATAN UMUM DEWASA LT.11
                                            </option>
                                            <option value="KEPERAWATAN ICU LT.6">KEPERAWATAN ICU LT.6</option>
                                            <option value="KEPERAWATAN ICU LT.10">KEPERAWATAN ICU LT.10</option>
                                            <option value="KEPERAWATAN PICU/NICU">KEPERAWATAN PICU/NICU LT.9</option>

                                            <option value="POLIKLINIK">POLIKLINIK
                                            </option>
                                            <option value="INSTALASI GAWAT DARURAT">INSTALASI GAWAT DARURAT
                                            </option>
                                            <option value="HEMODALISA">HEMODALISA
                                            </option>
                                            <option value="KAMAR OPERASI">KAMAR OPERASI
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

                            <div class="demo-table" style="overflow-x:auto;">
                                <h5>Darah</h5>
                                <br>
                                <table id="exampleDarah" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1"> Tanggal
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM01
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM02
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM03
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM04
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM05
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM06
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM07
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM08
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM09
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM10
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM11
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM12
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM13
                                            </th>
                                            <th align='center'>
                                                <font size="1">KM14
                                            </th>
                                            <th align='center'>
                                                <font size="1">KM15
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">Resume
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
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                            </div>
                            <br>
                            <hr>
                            <div class="demo-table" style="overflow-x:auto;">
                                <h5>Sputum</h5>
                                <br>
                                <table id="exampleSputum" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1"> Tanggal
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM01
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM02
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM03
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM04
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM05
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM06
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM07
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM08
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM09
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM10
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM11
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM12
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM13
                                            </th>
                                            <th align='center'>
                                                <font size="1">KM14
                                            </th>
                                            <th align='center'>
                                                <font size="1">KM15
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">Resume
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
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                            </div>
                            <br>
                            <hr>
                            <div class="demo-table" style="overflow-x:auto;">
                                <h5>Urine</h5>
                                <br>
                                <table id="exampleUrine" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1"> Tanggal
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM01
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM02
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM03
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM04
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM05
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM06
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM07
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM08
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM09
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM10
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM11
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM12
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM13
                                            </th>
                                            <th align='center'>
                                                <font size="1">KM14
                                            </th>
                                            <th align='center'>
                                                <font size="1">KM15
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">Resume
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
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                            </div>
                            <br>
                            <hr>
                            <div class="demo-table" style="overflow-x:auto;">
                                <h5>Swab</h5>
                                <br>
                                <table id="exampleSwab" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1"> Tanggal
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM01
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM02
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM03
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM04
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM05
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM06
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM07
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM08
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM09
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM10
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM11
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM12
                                            </th>
                                            <th align='center'>
                                                <font size="1"> KM13
                                            </th>
                                            <th align='center'>
                                                <font size="1">KM14
                                            </th>
                                            <th align='center'>
                                                <font size="1">KM15
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">Resume
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
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                            </div>
                            <br>
                            <hr>
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
<script src="<?= BASEURL; ?>/js/App/PPI/PPIListKuman.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script> -->