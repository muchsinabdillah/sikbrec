<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>

<div class="main-page">

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul_child'] ?>
                                    <!-- <div class="btn-group" role="group">
                                        <a class="btn btn-link btn-sm " id="btncreateSensusHarianRanap"
                                            onclick="gocreatesensusranap();">
                                            <span class="glyphicon glyphicon glyphicon-plus"></span> Tambah Sensus
                                            Harian Rawat Inap</a>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-link btn-sm " id="btncreateSensusHarianRajal"
                                            onclick="gocreatesensusrajal();">
                                            <span class="glyphicon glyphicon glyphicon-plus"></span> Tambah Sensus
                                            Harian Rawat Jalan</a>
                                    </div> -->
                                </h5>
                            </div>

                        </div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                <li role="presentation" class="active"><a class="" href="#tab_input" aria-controls="tab_input" role="tab" data-toggle="tab">Input Eklaim</a></li>
                                <!-- <li role="presentation"><a class="" href="#tab_import" aria-controls="tab_import" role="tab" data-toggle="tab">Import Klaim</a></li> -->
                            </ul>
                        <div class="panel-body">
                            <!-- <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">NO. MR</label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="NOSEP_CEK"
                                            onfocusout="TrigerSEP()" id="NOSEP_CEK">
                                    </div>
                                    <div class="col-sm-1">
                                        <a type="button" class="btn btn-success btn-animated btn-wide"
                                            id="btnLoadInformation" name="btnLoadInformation"><span
                                                class="visible-content">Load</span><span class="hidden-content"><i
                                                    class="fa fa-gear"></i></span></a>
                                    </div>
                                </div>
                            </form> -->
                            
                            <div class="tab-content bg-white p-15">

                                <div role="tabpanel" class="tab-pane active" id="tab_input">
                            <div class="form-horizontal">
                                <div class="form-group form-horizontal">

                                    <label for="inputEmail3" class="col-sm-3 control-label"> Masukan Kata Kunci <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <select id="cmbxcrimr" name="cmbxcrimr" style="width: 100%;" class="form-control ">
                                            <option value="1">NAMA PASIEN</option>
                                            <option value="2">TGL LAHIR</option>
                                            <option value="3">NO. MR</option>
                                            <option value="4">No. SEP</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="txSearchData" autocomplete="off"
                                            name="txSearchData" placeholder="ketik Kata Kunci disini">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" id="btnSearchMrAktif" class="btn btn-success btn-wide btn-rounded"><i
                                                class="fa fa-search"></i>Search</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                <li role="presentation" class="active"><a class="" href="#list_registrasi" aria-controls="list_registrasi" role="tab" data-toggle="tab">List Registrasi</a></li>
                                <li role="presentation"><a class="" href="#riwayat_klaim" aria-controls="riwayat_klaim" role="tab" data-toggle="tab">Riwayat Klaim</a></li>
                            </ul>

                            <div class="tab-content bg-white p-15">

                                <div role="tabpanel" class="tab-pane active" id="list_registrasi">
                                  <!-- <div class="table-responsive" style="margin-top: 70px;"> -->
                            <div class="demo-table" style="overflow-x:auto;">
                                <table id="example" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">No.SEP
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl Lahir
                                            </th>
                                            <th align='center'>
                                                <font size="1">No MR
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tanggal Kunjungan
                                            </th>
                                            <th align='center'>
                                                <font size="1">No Registrasi
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jenis Pasien
                                            </th>
                                            <!-- <th align='center'>
                                                <font size="1">Tanggal SEP
                                            </th> -->
                                            <th align='center'>
                                                <font size="1"><div type="teks" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="Jika 'TIDAK' bridging registrasi BPJS, mohon dicek kembali hak kelas, nomor sep,nomor peserta, dan naik/tidak naik kelas."> ? </div> Bridging Registrasi BPJS
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

                                </div>

                     <div role="tabpanel" class="tab-pane" id="riwayat_klaim">
                          <div class="demo-table" style="overflow-x:auto;">
                                <table id="riwayat_klaim_table" class="display" width="100%">
                                    <thead>
                                    <tr>
                                    <th align='center'>
                                                <font size="1">Nama Pasien
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tanggal Lahir
                                            </th>
                                            <th align='center'>
                                                <font size="1">No MR
                                            </th>
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
                                            <th align='center'>
                                                <font size="1">Action
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

                                
                                <div role="tabpanel" class="tab-pane" id="tab_import">

                                <div class="form-horizontal">
                                <div class="form-group form-horizontal">


                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-1 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAwal"
                                            onfocusout="TrigerTgl()" id="PeriodeAwal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">S/d</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="PeriodeAkhir"
                                            onfocusout="TrigerTgl()" id="PeriodeAkhir">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Pasien</label>
                                    <div class="col-sm-2">
                                    <select id="JenisPasien" name="JenisPasien" style="width: 100%;" class="form-control ">
                                            <option value="">-- PILIH --</option>
                                            <option value="1">Rawat Inap</option>
                                            <option value="2">Rawat Jalan</option>
                                        </select>
                                    </div>
                                    <!-- <label for="inputEmail3" class="col-sm-10 control-label"></label> -->
                                    <div class="col-sm-1">
                                        <a type=" button" class="btn btn-danger btn-animated btn-wide"
                                            id="btnLoadInformation" name="btnLoadInformation"><span
                                                class="visible-content">View Data</span><span class="hidden-content"><i
                                                    class="fa fa-gear"></i></span></a>
                                    </div>
                                </div>
                                </div>
                                </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <form id="form_approve">
                                <div class="demo-table" style="overflow-x:auto;">
                                <table id="import_klaim_table" class="display" width="100%">
                                    <thead>
                                    <tr>
                                    <th align='center'>
                                                <font size="1">ID
                                            </th>
                                            <th align='center'>
                                                <font size="1">No SEP
                                            </th>
                                            <th align='center'>
                                                <font size="1">No Kartu
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Pasien
                                            </th>
                                            <th align='center'>
                                                <font size="1">No MR
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl Lahir
                                            </th>
                                            <th align='center'>
                                                <font size="1">No Registrasi
                                            </th>
                                            <th align='center'>
                                                <font size="1">Poli
                                            </th>
                                            <th align='center'>
                                                <font size="1">Dokter
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kelas
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl Sep
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <th colspan="10"></th>
                                        <th align="center"><button type="button" title="Approve Yang Dipilih" class="btn btn-success btn-xs" id="cb_approvefarmasiall" name="cb_approvefarmasiall" onclick="BtnKlaim(this)"><span class="glyphicon glyphicon-check"></span> KLAIM </button></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            </form>
                            </div>
                        </div>

                                </div>


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
<script src="<?= BASEURL; ?>/js/App/Eklaim/Eklaim_List.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script> -->
<!-- <script src="<?= BASEURL; ?>/js/App/PPI/PPIListView_v2.js"></script> -->
<!-- <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script> -->