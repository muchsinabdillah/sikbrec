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
                                <div class="form-group">


                                    <hr>
                                    <div class="panel-body">
                                        <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                            <table id="example" class="display" width="100%">
                                                <thead>
                                                    <tr>
                                                        <!-- <th align='center'> No </th> -->
                                                        <th align='center'> NIK </th>
                                                        <th align='center'> NAMA </th>
                                                        <th align='center'> Jenis POG</th>
                                                        <th align='center'>Action</th>

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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-SM" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Silahkan Pilih Form Yang mau di Upload Filenya.</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <input class="form-control input-sm" type="hidden" autocomplete="off" id="IDMedrec" readonly
                            name="IDMedrec">
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataSKPegawai" id="btnDataSKPegawai"
                                    onclick="goFormDataPribadi()" class="btn btn-success btn-wide btn-rounded"><i
                                        class="fa fa-search"></i>Data Pribadi</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataKeluarga" id="btnDataKeluarga"
                                    onclick="goFormKeluarga()" class="btn btn-success btn-wide btn-rounded"><i
                                        class="fa fa-search"></i>Data Keluarga</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataPendidikan" id="btnDataPendidikan"
                                    onclick="goFormPendidikan()" class="btn btn-success btn-wide btn-rounded"><i
                                        class="fa fa-search"></i>Data Pendidikan</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataPelatihan" id="btnDataPelatihan"
                                    onclick="goFormPelatihan()" class="btn btn-success btn-wide btn-rounded"><i
                                        class="fa fa-search"></i>Data Pelatihan</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataSIP" id="btnDataSIP" onclick="goFormSIP()"
                                    class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Data
                                    SIP</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataSTR" id="btnDataSTR" onclick="goFormSTR()"
                                    class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Data
                                    STR</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataMCU" id="btnDataMCU" onclick="goFormMCU()"
                                    class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Data
                                    MCU</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataMOU" id="btnDataMOU" onclick="goFormMOU()"
                                    class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Data
                                    MOU</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataSKPegawai" id="btnDataSKPegawai"
                                    onclick="goFormSKPegawai()" class="btn btn-success btn-wide btn-rounded"><i
                                        class="fa fa-search"></i>Data SK Pegawai</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataSKPegawai" id="btnDataSKPegawai"
                                    onclick="goFormRKK()" class="btn btn-success btn-wide btn-rounded"><i
                                        class="fa fa-search"></i>Data RKK</button>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                            <div class="col-sm-2">
                                <button type="button" name="btnDataSKPegawai" id="btnDataSKPegawai"
                                    onclick="goFormSPK()" class="btn btn-success btn-wide btn-rounded"><i
                                        class="fa fa-search"></i>Data SPK</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                        data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
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
<!-- <script src="<?= BASEURL; ?>/js/App/informasi/finance/ledger/infoledgerdetil.js"></script> -->
<script src="<?= BASEURL; ?>/js/App/Formulir/Formdatapegawai.js"></script>