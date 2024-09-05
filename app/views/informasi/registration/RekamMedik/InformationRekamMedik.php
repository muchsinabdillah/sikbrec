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
                                <div class="alert alert-info" role="alert">
                                                <strong>Perhatian !</strong> Jenis rekap [Rekap Penjamin] hanya bisa jika memilih jenis pasien [Rawat Jalan], [IGD], atau [Rawat Inap].<br>
                                                <strong>Perhatian !</strong> Jenis rekap dari [Rekap Kecamatan] sampai dengan [Rekap Etnis], hanya bisa jika memilih jenis pasien [ALL]. <br>
                                                <strong>Perhatian !</strong> Jenis pasien [KAMAR OPERASI] bisa dilakukan jika Jenis Rekap dan Jenis Tipe [Kosong]. <br>
                                </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAwal" onfocusout="TrigerTgl()" id="PeriodeAwal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">S/d</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAkhir" onfocusout="TrigerTgl()" id="PeriodeAkhir">
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pasien</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="JenisInfo" name="JenisInfo" onchange="JenisInfoTrigger(this.value)">
                                            <option VALUE=""></option>
                                            <option VALUE="1">Rawat Jalan</option>
                                            <option VALUE="7">Penunjang</option>
                                            <option VALUE="8">Hemodialisa</option>
                                            <option VALUE="2">IGD</option>
                                            <option VALUE="3">Rawat Inap</option>
                                            <option VALUE="5">MCU</option>
                                            <option VALUE="6">KAMAR OPERASI</option>
                                            <option VALUE="4">All</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Rekap</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="JenisRekap" name="JenisRekap" onchange="clearVal(this.value)">
                                            <option VALUE=""></option>
                                            <option VALUE="1">Rekap Pivot Per Dokter</option>
                                            <option VALUE="2">Rekap Pivot Per Poliklinik</option>
                                            <option VALUE="4">Rekap Kecamatan</option>
                                            <option VALUE="5">Rekap Kelurahan</option>
                                            <option VALUE="6">Rekap Provinsi</option>
                                            <option VALUE="7">Rekap Usia</option>
                                            <option VALUE="8">Rekap Pekerjaan</option>
                                            <option VALUE="9">Rekap Agama</option>
                                            <option VALUE="10">Rekap Bahasa</option>
                                            <option VALUE="11">Rekap Etnis</option>
                                            <option VALUE="12">Rekap Jenis Pemeriksaan MCU</option>
                                            <option VALUE="13">Rekap Penjamin</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Tipe</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="JenisTipe" name="JenisTipe" onchange="chageV(this)">
                                            <option VALUE=""></option>
                                            <option VALUE="1">Informasi Detil Pasien</option>
                                            <option VALUE="2">Informasi Rekap Pasien</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="GrupPerawatan" name="GrupPerawatan">
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Dokter</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="NamaDokter" name="NamaDokter">
                                        </select>
                                    </div>
                                </div>

                                <a type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadInformation" name="btnLoadInformation"><span class="visible-content">Load</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>

                                <button type="button" class="btn btn-success btn-animated btn-wide" id="excelLanscape" name="excelLanscape"><span class="visible-content" class="btn btn-primary">Excel</button>
                            </form>

                            <hr>
                            <!-- Data table 1-->
                            <!-- <div class="table-responsive" style="margin-top: 70px;">
                                <table id="datatable1" class="display" width="100%" style="display: none"> -->
                            <div class="panel-body">
                                <div class="demo-table" style="overflow-x:auto;">
                                    <table id="datatable1" class="display" width="100%" style="display: none">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>Tgl </th>
                                                <th align='center'>No MR</th>
                                                <th align='center'>Baru/Lama</th>
                                                <th align='center'>Status Regis</th>
                                                <th align='center'>No. Reg</th>
                                                <th align='center'>Nama Pasien</th>
                                                <th align='center'>Gender</th>
                                                <th align='center'>Lokasi Pasien</th>
                                                <th align='center'>Diagnosa</th>
                                                <th align='center'>Nama Dokter</th>
                                                <th align='center'>Asuransi</th>
                                                <th align='center'>Alamat</th>
                                                <th align='center'>Kelurahan</th>
                                                <th align='center'>Kecamatan</th>
                                                <th align='center'>Kabupaten</th>
                                                <th align='center'>Provinsi</th>
                                                <th align='center'>Cara Masuk</th>
                                                <th align='center'>Referal</th>
                                                <th align='center'>Nama Administrasi</th>
                                                <th align='center'>NIlai Administrasi</th>
                                                <th align='center'>TOTAL BILL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <!-- Data table 2-->
                                    <table id="datatable2" class="display" width="100%" style="display: none">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>POLIKLINIK</th>
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
                                                <th align='center'>13</th>
                                                <th align='center'>14</th>
                                                <th align='center'>15</th>
                                                <th align='center'>16</th>
                                                <th align='center'>17</th>
                                                <th align='center'>18</th>
                                                <th align='center'>19</th>
                                                <th align='center'>20</th>
                                                <th align='center'>21</th>
                                                <th align='center'>22</th>
                                                <th align='center'>23</th>
                                                <th align='center'>24</th>
                                                <th align='center'>25</th>
                                                <th align='center'>26</th>
                                                <th align='center'>27</th>
                                                <th align='center'>28</th>
                                                <th align='center'>29</th>
                                                <th align='center'>30</th>
                                                <th align='center'>31</th>
                                                <th align='center'>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <!-- Data table 3-->
                                    <table id="datatable3" class="display" width="100%" style="display: none">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>KETERANGAN</th>
                                                <th align='center'>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <!-- Data table 4-->
                                    <table id="datatable4" class="display" width="100%" style="display: none">
                                        <thead>
                                            <tr>
                                                <th align='center'>No</th>
                                                <th align='center'>Tgl Order</th>
                                                <th align='center'>Tgl Operasi</th>
                                                <th align='center'>No MR</th>
                                                <th align='center'>No. Reg</th>
                                                <th align='center'>Nama Pasien</th>
                                                <th align='center'>Diagnosa Pre OP</th>
                                                <th align='center'>Diagnosa Post OP</th>
                                                <th align='center'>Nama Tindakan</th>
                                                <th align='center'>Nama Dokter Operator</th>
                                                <th align='center'>Nama Dokter Anestesi</th>
                                                <th align='center'>Lama Operasi</th>
                                                <th align='center'>Jaminan</th>
                                                <th align='center'>Group Spesialis</th>
                                                <th align='center'>Klasifikasi Operasi</th>
                                                <th align='center'>Laporan Operasi</th>
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
<script src="<?= BASEURL; ?>/js/App/informasi/registration/RekamMedik/Information_RekamMedik_V01.js"></script>