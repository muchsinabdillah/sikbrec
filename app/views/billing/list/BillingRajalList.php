<audio id="notification-sound" autoplay-policy=no-user-gesture-required hidden  controls>
        <source src="<?= BASEURL; ?>/notofication.wav" type="audio/wav" autoplay="true">
    </audio>
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

.bg {
    height: 100vh;
    margin: 0;
    background-image:
        radial-gradient(90% 10% at top left, transparent 85%, #fff 92.5%),
        linear-gradient(135deg, #ADD8E6 0%, #ADD8E6 100%);
}

.border {
    border-left-color: #B22222;
    border-left-style: groove;
    border-left-width: 7px;
}

table#listbillingrajal.dataTable tbody tr.HighlightPerawat > .sorting_1 {
    background-color: #0486ed;
}

table#listbillingrajal.dataTable tbody tr.HighlightPerawat {
    background-color: #0486ed;
}

table#listbillingrajal.dataTable tbody tr.HighlightDokter > .sorting_1 {
    background-color: #f2f605;
}

table#listbillingrajal.dataTable tbody tr.HighlightDokter {
    background-color: #f2f605;
}

table#listbillingrajal.dataTable tbody tr.HighlightFarmasi > .sorting_1 {
    background-color: #0bf300;
}

table#listbillingrajal.dataTable tbody tr.HighlightFarmasi {
    background-color: #0bf300;
}


table#listbillingrajal_arsip.dataTable tbody tr.HighlightPerawat > .sorting_1 {
    background-color: #0486ed;
}

table#listbillingrajal_arsip.dataTable tbody tr.HighlightPerawat {
    background-color: #0486ed;
}

table#listbillingrajal_arsip.dataTable tbody tr.HighlightDokter > .sorting_1 {
    background-color: #f2f605;
}

table#listbillingrajal_arsip.dataTable tbody tr.HighlightDokter {
    background-color: #f2f605;
}

table#listbillingrajal_arsip.dataTable tbody tr.HighlightFarmasi > .sorting_1 {
    background-color: #0bf300;
}

table#listbillingrajal_arsip.dataTable tbody tr.HighlightFarmasi {
    background-color: #0bf300;
}
</style>
<div class="main-page">

    <section class="section">
        <div class="container-fluid ">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading border">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">

                            <hr>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                <li role="presentation" class="active"><a class="" href="#pasienaktif"
                                        aria-controls="pasienaktif" role="tab" data-toggle="tab">Pasien Aktif</a></li>
                                <li role="presentation"><a class="" href="#pasienarsip" aria-controls="pasienarsip"
                                        role="tab" data-toggle="tab">Arsip Pasien</a></li>

                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content bg-white p-15">

                                <div role="tabpanel" class="tab-pane active" id="pasienaktif">
                                    <div class="alert alert-info alert-dismissible">
                                                <p> <strong>Info !</strong> KETERANGAN WARNA :</p> 
                                                <p> <strong>Info !</strong> BIRU - SELESAI PERAWAT</p> 
                                                <p> <strong>Info !</strong> KUNING - SELESAI DOKTER</p> 
                                                <p> <strong>Info !</strong> HIJAU - SELESAI FARMASI</p> 
                                    </div>
                                    <div class="form-group">
                                        <form class="form-horizontal" id="form_periode">

                                            <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                            <div class="col-sm-2">
                                                <input type="date" class="form-control" name="tglawal" id="tglawal">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="date" class="form-control" name="tglakhir" id="tglakhir">
                                            </div>
                                            <button type="button" class="btn-sm btn-default" id="btn_periode"
                                                name="btn_periode"><span class="glyphicon glyphicon-search"
                                                    aria-hidden="true"></span> Search</button>
                                            &nbsp&nbsp&nbsp&nbsp
                                            <button type="button" class="btn-sm btn-primary" id="btn_today"
                                                name="btn_today"><span class="glyphicon glyphicon-filter"
                                                    aria-hidden="true"></span> Hari Ini</span></button>
                                            &nbsp&nbsp&nbsp&nbsp

                                        </form>
                                    </div>

                                    <div class="panel-body p-20">
                                        <div class="demo-table" style="overflow-x:auto;">
                                            <table id="listbillingrajal" class="display" width="100%">
                                                <!-- <div class="table-responsive" style="margin-top: 70px;">
                                <table id="listbillingrajal" class="display" width="100%"> -->
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <font size="1">No.</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">No MR</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">No. Registrasi</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Nama Pasien</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Tanggal Kunjungan</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Unit</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Dokter</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Penjamin</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Nama Penjamin</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">P</font> 
                                                        </th>
                                                        <th> 
                                                            <font size="1">D</font> 
                                                        </th>
                                                        <th> 
                                                            <font size="1">O</font> 
                                                        </th>
                                                        <th> 
                                                            <font size="1">F</font> 
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

                                <div role="tabpanel" class="tab-pane" id="pasienarsip">

                                    <div class="form-group">
                                        <form class="form-horizontal" id="form_periode_arsip">

                                            <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                            <div class="col-sm-2">
                                                <input type="date" class="form-control" name="tglawal_arsip"
                                                    id="tglawal_arsip">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="date" class="form-control" name="tglakhir_arsip"
                                                    id="tglakhir_arsip">
                                            </div>
                                            <button type="button" class="btn-sm btn-default" id="btn_periode_arsip"
                                                name="btn_periode_arsip"><span class="glyphicon glyphicon-search"
                                                    aria-hidden="true"></span> Search</button>

                                        </form>
                                    </div>
                                    <!-- 
                                    <div class="table-responsive" style="margin-top: 70px;">
                                        <table id="listbillingrajal_arsip" class="display" width="100%"> -->
                                    <div class="panel-body p-20">
                                        <div class="demo-table" style="overflow-x:auto;">
                                            <table id="listbillingrajal_arsip" class="display" width="100%">
                                                <thead>
                                                    <tr>
                                                    <th>
                                                            <font size="1">No.</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">No MR</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">No. Registrasi</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Nama Pasien</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Tanggal Kunjungan</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Unit</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Dokter</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Penjamin</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Nama Penjamin</font>
                                                        </th>
                                                        <th>
                                                            <font size="1">Status</font>
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
<div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Izin Notifikasi</h4>
                </div>
                    <div class="text">Izinkan SIMRS memberikan Notifikasi Suara Saat Order Baru Masuk ?</div>
                <div class="modal-footer">
                    <div class="btn-group" role="group"> 
                        <button type="button" onclick="play()" class="btn btn-success btn-wide btn-rounded" 
                        id="btnclosemodalcetak" name="btnclosemodalcetak">ALLOW</button>
                    </div>
                </div>
            </div>
    </div>               
</div>
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/billing/List/listbillingrajal.js"></script>