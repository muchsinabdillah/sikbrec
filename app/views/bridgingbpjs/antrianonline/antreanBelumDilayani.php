<?php
    date_default_timezone_set('Asia/Jakarta');
    $id = "";
    $datenowcreate = date("Y-m-d");
    $datetimenow = date("Y-m-d\TH:i:s");
    ?>
<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30"><?= $data['judul'] ?><small></small>
                                    <div class="btn-group" role="group">
                                    </div>
                                </h5>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-success" role="alert">
                                    <strong>Informasi !</strong> Waktu server adalah data waktu (task 1-6) yang dicatat
                                    oleh server BPJS Kesehatan setelah RS mengimkan data, sedangkan waktu rs adalah data
                                    waktu (task 1-6) yang dikirimkan oleh RS
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">

                            <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <div class="form-group  ">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Tanggal <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="month" id="MTglKunjunganBPJS"
                                            autocomplete="off" name="MTglKunjunganBPJS"
                                            placeholder="ketik Kata Kunci disini">
                                    </div>
                                </div>
                                <div class="form-group gut ">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Waktu<sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <select id="waktu" nama="waktu" class="form-control input-sm">
                                            <option value="">-- PILIH --</option>
                                            <option value="rs">Rumah Sakit</option>
                                            <option value="server">Server</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group  ">
                                    <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <button type="button" onclick="GoMonitoringBPJSbelumdilayani();" id="caridatapasienarsip"
                                            class="btn btn-success btn-wide btn-rounded"><i
                                                class="fa fa-search"></i>Search</button>
                                    </div>
                                </div>
                                <!-- <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                    <table id="tbl_kunjungan_monitoring" width="100%"
                                        class="table table-striped table-hover cell-border"> -->
                                <div class="panel-body">
                                    <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                        <table id="tbl_kunjungan_monitoring_belum" class="display" width="100%"
                                            class="table table-striped table-hover cell-border">
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size="1">Kode Transaksi
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Tanggal
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Kode Poli
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Kode Dokter
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Jam Praktek
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">NIK
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">No. Kartu BPJS
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">No. Hp
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">No. MR
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Jenis Kunjungan
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">No Reff
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Sumber Data
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">No. Antrean
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Status Dilayani
                                                    </th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
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

<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/bridgingbpjs/antrianonline/dashboardper_bulan.js"></script>