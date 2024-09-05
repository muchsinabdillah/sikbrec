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
        font-size: 10px;
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
                            <hr>
                            <div class="demo-table" style="margin-top: 10px;overflow-x:auto;">
                                <table id="permintaanrawat_all" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <font size="1">No MR</font>
                                            </th>
                                            <th>
                                                <font size="1">Nama Pasien</font>
                                            </th>
                                            <th>
                                                <font size="1">Tanggal</font>
                                            </th>
                                            <th>
                                                <font size="1">No. Registrasi</font>
                                            </th>
                                            <th>
                                                <font size="1">Status</font>
                                            </th>
                                            <th>
                                                <font size="1">DPJP</font>
                                            </th>
                                            <th>
                                                <font size="1">Kategori Keperawatan</font>
                                            </th>
                                            <th>
                                                <font size="1">Penjamin</font>
                                            </th>
                                            <th>
                                                <font size="1">Action</font>
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

<!-- Modal Konfirmasi Pesan SIMPAN -->
<div class="modal fade " id="modal_edit_sep" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Update No. SEP Pasien </h4>
            </div>
            <div class="modal-body">
                <form id="frmUpdateSEP">
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">ID :</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="NOID_Reg" name="NOID_Reg" maxlength="19" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No SEP Lama :</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="NoSEPLama" name="NoSEPLama" maxlength="19" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No SEP Baru :</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" autocomplete="off" id="NoSEPBaru" name="NoSEPBaru" maxlength="19">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">Hak Kelas BPJS :</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" autocomplete="off" id="hakKelasBPJS" name="hakKelasBPJS">
                        </div>
                    </div>
                    <div class=" row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">PRB / Prolanis :</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" autocomplete="off" id="keteranganprbBPJS" name="keteranganprbBPJS">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">diagnosa Ina cbg :</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" autocomplete="off" id="diagnosaInacbg" name="diagnosaInacbg">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">Nilai Gruper :</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" autocomplete="off" id="nilai_Gruper" name="nilai_Gruper">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">lama di rawat :</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" autocomplete="off" id="lama_dirawat" name="lama_dirawat">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-toggle='modal' class="btn btn-primary btn-sm" type="button" id="btnUpdateSEP" name="btnUpdateSEP">
                    UPDATE
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Konfirmasi Pesan SIMPAN end -->


<!-- ========== COMMON JS FILES ========== -->
<!-- <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script> -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/registration/list/listregistratrationranapreg_V01.js"></script>