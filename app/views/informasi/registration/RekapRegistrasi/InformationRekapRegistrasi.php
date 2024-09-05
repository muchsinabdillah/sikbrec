<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>
<style>
    table {
        border: 2px solid #6C6A61;
        border-collapse: collapse;
        font-size: 10px;
    }

    th,
    td {
        border: 1px solid #bbb;
        padding: 2px 8px 0;
        font-size: 10px;
    }

    thead>tr>th {
        background-color: #C0C0C0;
        border-bottom: 2px solid #999;
        font-size: 12px;
    }
</style>
<div class="main-page">


    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>Montly Report</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <select class="form-control js-example-basic-single" id="Periode" name="Periode">
                                            <option VALUE="">-- Pilih --</option>
                                            <option VALUE="2018">2018</option>
                                            <option VALUE="2019">2019</option>
                                            <option VALUE="2020">2020</option>
                                            <option VALUE="2021">2021</option>
                                            <option VALUE="2022">2022</option>
                                            <option VALUE="2023">2023</option>
                                            <option VALUE="2024">2024</option>
                                            <option VALUE="2025">2025</option>
                                            <option VALUE="2026">2026</option>
                                            <option VALUE="2027">2027</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Rekap</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="JenisRekap" name="JenisRekap" onchange="clearVal()">
                                            <option VALUE="">-- Pilih --</option>
                                            <option VALUE="1">Rekap Dokter</option>
                                            <option VALUE="2">Rekap Dokter & Unit</option>
                                            <option VALUE="3">Rekap Rujukan</option>
                                            <option VALUE="4">Rekap Unit ( Untuk Rajal / IGD / HD / RANAP OT )</option>
                                            <option VALUE="6">Rekap Penjamin Perusahaan</option>
                                            <option VALUE="7">Rekap Penjamin Asuransi</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pasien</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="JenisPasien" name="JenisPasien">
                                            <option VALUE="">-- Pilih --</option>
                                            <option VALUE="1">Rawat Jalan</option>
                                            <option VALUE="2">IGD</option>
                                            <option VALUE="3">MCU</option>
                                            <option VALUE="4">Rawat Inap</option>
                                            <option VALUE="5">Rawat Inap OT</option>
                                            <option VALUE="6">Hemodialisa (Rawat Jalan )</option>
                                            <option VALUE="7">Penunjang (Lab.Rad/Fisio)</option>
                                        </select>
                                    </div>
                                </div>
                                <a type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadInformation" name="btnLoadInformation"><span class="visible-content">Load</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>

                                <button type="button" class="btn btn-success btn-animated btn-wide" id="excelLanscape" name="excelLanscape"><span class="visible-content" class="btn btn-primary">Excel</button>
                            </form>

                            <hr>
                            <!-- Data table 1-->



                            <!-- Data table 2-->
                            <!-- <div class="table-responsive" style="margin-top: 70px;">
                                <table id="datatable" class="display" width="100%" style="display: none;"> -->
                            <div class="panel-body">
                                <div class="demo-table" style="overflow-x:auto;">
                                    <table id="datatable" class="display" width="100%" style="display: none;">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>

                                                <th align='center'>NAMA DOKTER</th>
                                                <th align='center'>01</th>
                                                <th align='center'>02</th>
                                                <th align='center'>03</th>
                                                <th align='center'>04</th>
                                                <th align='center'>05</th>
                                                <th align='center'>06</th>
                                                <th align='center'>07</th>
                                                <th align='center'>08</th>
                                                <th align='center'>09</th>
                                                <th align='center'>10</th>
                                                <th align='center'>11</th>
                                                <th align='center'>12</th>
                                                <th align='center'>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <table id="datatable_Rujukan" class="display" width="100%" style="display: none;">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>NAMA Rujukan</th>
                                                <th align='center'>NAMA UNIT</th>
                                                <th align='center'>NAMA Dokter</th>
                                                <th align='center'>01</th>
                                                <th align='center'>02</th>
                                                <th align='center'>03</th>
                                                <th align='center'>04</th>
                                                <th align='center'>05</th>
                                                <th align='center'>06</th>
                                                <th align='center'>07</th>
                                                <th align='center'>08</th>
                                                <th align='center'>09</th>
                                                <th align='center'>10</th>
                                                <th align='center'>11</th>
                                                <th align='center'>12</th>
                                                <th align='center'>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <table id="datatable_unit" class="display" width="100%" style="display: none;">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>NAMA UNIT</th>
                                                <th align='center'>NAMA DOKTER</th>
                                                <th align='center'>01</th>
                                                <th align='center'>02</th>
                                                <th align='center'>03</th>
                                                <th align='center'>04</th>
                                                <th align='center'>05</th>
                                                <th align='center'>06</th>
                                                <th align='center'>07</th>
                                                <th align='center'>08</th>
                                                <th align='center'>09</th>
                                                <th align='center'>10</th>
                                                <th align='center'>11</th>
                                                <th align='center'>12</th>
                                                <th align='center'>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <table id="datatable_unit_only" class="display" width="100%" style="display: none;">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>NAMA UNIT</th>
                                                <th align='center'>01</th>
                                                <th align='center'>02</th>
                                                <th align='center'>03</th>
                                                <th align='center'>04</th>
                                                <th align='center'>05</th>
                                                <th align='center'>06</th>
                                                <th align='center'>07</th>
                                                <th align='center'>08</th>
                                                <th align='center'>09</th>
                                                <th align='center'>10</th>
                                                <th align='center'>11</th>
                                                <th align='center'>12</th>
                                                <th align='center'>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <table id="datatable_perusaahn_only" class="display" width="100%" style="display: none;">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>NAMA PENJAMIN</th>
                                                <th align='center'>01</th>
                                                <th align='center'>02</th>
                                                <th align='center'>03</th>
                                                <th align='center'>04</th>
                                                <th align='center'>05</th>
                                                <th align='center'>06</th>
                                                <th align='center'>07</th>
                                                <th align='center'>08</th>
                                                <th align='center'>09</th>
                                                <th align='center'>10</th>
                                                <th align='center'>11</th>
                                                <th align='center'>12</th>
                                                <th align='center'>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>


                                    <!-- Data table 3-->

                                    <!-- Data table 4-->



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
<script src="<?= BASEURL; ?>/js/App/informasi/registration/RekapRegistrasi/Information_RekapRegistrasi.js"></script>