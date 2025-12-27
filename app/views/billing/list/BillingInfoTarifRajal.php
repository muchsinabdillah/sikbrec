<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css"
    rel="stylesheet" />
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

/* .border-ranap {
    border-left-color: #1E90FF;
    border-left-style: groove;
    border-left-width: 7px;
}

.border-rajal {
    border-left-color: #B22222;
    border-left-style: groove;
    border-left-width: 7px;
}

.border-walkin {
    border-left-color: #808080;
    border-left-style: groove;
    border-left-width: 7px;
}

.border-bebas {
    border-left-color: teal;
    border-left-style: groove;
    border-left-width: 7px;
}

.cover {
    transform: translateY(-100%);
} */


/* input transparant */
input {
    /* width: 300px; */
    padding: 10px 20px;
    border-color: transparent;
    border-bottom: 5px solid darkgrey;
    font-size: 15px;
    background: transparent;
}

input:focus {
    outline: none;
}

input::-webkit-input-placeholder {
    padding-left: 5px;
    font-size: 15px;
    color: #3c3c3c;
}

input:-moz-placeholder {
    /* Firefox 18- */
    padding-left: 5px;
    font-size: 15px;
    color: #3c3c3c;
}

input::-moz-placeholder {
    /* Firefox 19+ */
    padding-left: 5px;
    font-size: 15px;
    color: #3c3c3c;
}

input:-ms-input-placeholder {
    padding-left: 5px;
    font-size: 15px;
    color: #3c3c3c;
}
</style>
<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline"><?= $data['judul'] ?>
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- Update -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Silahkan Masukan Data</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <form class="form-horizontal" id="frmInfoKasir">

                                            <div class="form-group gut">
                                                <label for=" inputEmail3" class="col-sm-12 control-label">
                                                </label>
                                                <label for=" inputEmail3" class="col-sm-12 control-label">
                                                </label>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Group
                                                    Tarif
                                                </label>
                                                <div class="col-sm-2">
                                                    <select class="form-control js-example-basic-single" id="gruptarif"
                                                        name="gruptarif"
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                       
                                                        <option VALUE="UM">UMUM</option>
                                                        <option VALUE="BS">BPJS</option>
                                                        <option VALUE="TE">TELKOM</option>
                                                        <option VALUE="KM">KMK</option>
                                                        <option VALUE="IH">MANDIRI INHEALTH MANAGED CARE</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Unit
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <select class="form-control js-example-basic-single"
                                                            id="unitlayanan" name="unitlayanan"
                                                            style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for=" inputEmail3" class="col-sm-12 control-label">
                                                </label>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Pasien
                                                </label>
                                                <div class="col-sm-2">
                                                    <select class="form-control js-example-basic-single"
                                                        id="jenispasien" name="jenispasien"
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px">
                                                        <option VALUE="RJ">Rawat Jalan</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-10 control-label"> </label>
                                                <div class="col-sm-2">
                                                    <a type="button" class="btn btn-success btn-animated btn-wide"
                                                        id="btn_infokasir" name="btn_infokasir"><span
                                                            class="visible-content">Load</span><span
                                                            class="hidden-content"><i class="fa fa-gear"></i></span></a>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>List Data Tarif</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">

                                        <div class="panel-body">
                                            <div class="demo-table" width="100%" id="tbl_rekap"
                                                style="margin-top: 10px;overflow-x:auto;">
                                                <form id="form_approve">
                                                    <table id="tbl_aktif" width="100%"
                                                        class="table table-striped table-hover cell-border">
                                                        <thead>
                                                            <tr>
                                                                <th align='center'>
                                                                    <font size="1">No
                                                                </th> 
                                                                <th align='center'>
                                                                    <font size="1">Nama Tarif
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Nilai Tarif
                                                                </th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody id='tabledatareservasi'>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>




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
<script src="<?= BASEURL; ?>/js/App/billing/list/BillingInfoTarifRajal.js?v=<?php echo time(); ?>"></script>