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
                            <div class="form-group">
                                <form class="form-horizontal" id="form_cuti">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" onfocusout="TrigerTgl()"
                                            name="PeriodeAwal" id="PeriodeAwal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">S/d</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" onfocusout="TrigerTgl()"
                                            name="PeriodeAkhir" id="PeriodeAkhir">
                                    </div>
                                </form>
                                <button type="button" class="btn btn-success btn-animated btn-wide"
                                    id="btnLoadInformation" name="btnLoadInformation"><span
                                        class="visible-content">Load</span><span class="hidden-content"><i
                                            class="fa fa-gear"></i></span></button>
                                            <button type="button" class="btn btn-primary btn-animated btn-wide"
                                    id="btnAddNewOrder" name="btnAddNewOrder"><span
                                        class="visible-content">Add New Order</span><span class="hidden-content"><i
                                            class="fa fa-plus"></i></span></button>
                            </div>
                            <hr>
                            <!-- <table id="table-load-data" class="display" width="100%"> -->
                            <div class="panel-body">
                                <div class="demo-table" style="overflow-x:auto;">
                                    <table id="table-load-data" class="display" width="100%">
                                        <thead>
                                            <tr>

                                                <th align='center'>
                                                    <font size="1">No MR
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama Pasien
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Tanggal Lahir
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Tanggal Order
                                                </th>
                                                <th align='center'>
                                                    <font size="1">No. Lab
                                                </th>
                                                <th align='center'>
                                                    <font size="1">No. Registrasi
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Jaminan
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Email / NoHP
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama Tes
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Status Hasil
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Action
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Send Hasil Kritis
                                                </th>
                                            </tr>
                                        </thead>
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

<div class="modal fade" id="modalSend" tabindex="-1" role="dialog" aria-labelledby="modalrumahsakit"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kirim Document</h5>
            </div>
            <div class="modal-body">
            <div class="row">
                    <div class="col-sm-6">
                        <input type="hidden" id="param_id" name="param_id"></>
                        <input type="hidden" id="param_noreg" name="param_noreg"></>
                        <input type="hidden" id="param_email" name="param_email"></>
                        <input type="hidden" id="param_nolab" name="param_nolab"></>
                        <p class="text-center"><strong>Send WhatsApp</strong></p><br>
                        <form id="TheForm" method="post" action="halaman/Print/print_bukti_reg.php" target="TheWindow">
                            <input type="hidden" name="cetaknoregis" id="cetaknoregis" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/sosmed/whatsapp.Png" id="whatsapp" class="img-circle" alt="Random Name" width="150" height="150">
                    </div>
                    <div class="col-sm-6">
                        <p class="text-center"><strong>Send Email </strong></p><br>
                        <img src="<?= BASEURL; ?>/images/sosmed/email.png" id="sendmail" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button class="ttdsaksirumahsakit btn-save">Save</button> -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.main-wrapper -->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/informasi/laboratorium/Information_HasilLab_V01.js"></script>