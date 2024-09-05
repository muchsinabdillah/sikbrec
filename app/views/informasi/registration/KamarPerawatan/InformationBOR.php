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
                                <h5><?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                            <div class="alert alert-info" role="alert">
                                                <strong>Info !</strong> Disarankan untuk melakukan generate/load data pada info <a type="button" class="btn btn-default btn-sm" href="<?= BASEURL; ?>/bInfoHariPerawatan"><span class="glyphicon glyphicon-new-window"></span> Hari Perawatan</a> terlebih dahulu untuk keakurasian data.
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="month" class="form-control" name="Periode" id="Periode">
                                    </div>

                                </div>

                                <!-- <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Rekap</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="JenisRekap" name="JenisRekap" onchange="clearVal()">
                                            <option VALUE="">-- Pilih --</option>
                                            <option VALUE="1">Rekap Dokter</option>
                                            <option VALUE="2">Rekap Dokter & Unit</option>
                                            <option VALUE="3">Rekap Rujukan</option>
                                            <option VALUE="4">Rekap Unit ( Untuk Rajal / IGD / HD )</option>
                                            <option VALUE="6">Rekap Penjamin Perusahaan</option>
                                            <option VALUE="7">Rekap Penjamin Asuransi</option>
                                        </select>
                                    </div>
                                </div> -->

                                <a type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadInformation" name="btnLoadInformation"><span class="visible-content">Load</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>

                                <!-- <button type="button" class="btn btn-success btn-animated btn-wide" id="excelLanscape" name="excelLanscape"><span class="visible-content" class="btn btn-primary">Excel</button> -->
                            </form>

                            <hr>
                            <div class="panel-body">
                                <div class="demo-table" style="overflow-x:auto;">
                                <table id="datatable" class="display" width="100%" >
                                        <thead>
                                            <tr>
                                            <th align='center'>periode</th>
                                            <th align='center'>TotalPasienPulang</th>
                                            <th align='center'>ResumeTotalSEMBUH</th>
                                            <th align='center'>ResumeTotalMeninggal2</th>
                                            <th align='center'>ResumeTotalLainlain</th>
                                            <th align='center'>ResumeTotalPulangPaksa</th>
                                            <th align='center'>BOR</th>
                                            <th align='center'>LOS</th>
                                            <th align='center'>BTO</th>
                                            <th align='center'>TOI</th>
                                            <th align='center'>GDR</th>
                                            <th align='center'>NDR</th>
                                            <th align='center'>HariPerawatan</th>
                                            <th align='center'>JumlahBed</th>
                                            <th align='center'>LamaPerawatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

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

</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/informasi/registration/KamarPerawatan/Information_BOR.js"></script>