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
                                        <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="inputreservasi();">
                                            <span class="glyphicon glyphicon glyphicon-plus"></span>Transaksi Baru</a>
                                    </div>
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- <form class="form-horizontal" id="form_reservationlist"> -->

                            <br>
                            <!-- </form> -->
                            <div class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <div class="form-group ml-20">

                                    <div class="col-sm-2">
                                        <!-- <label for="form-control input-sm">Input Awal</label> -->
                                        <input class="form-control input-sm" type="date" id="tglAwalReservasi" value="<?= $datenowcreate ?>" autocomplete="off" name="tglAwalReservasi" placeholder="ketik Kata Kunci disini">
                                    </div>
                                    <div class="col-sm-2">
                                        <!-- <label for="form-control input-sm">Input Akhir</label> -->
                                        <input class="form-control input-sm" type="date" id="tglAkhirReservasi" value="<?= $datenowcreate ?>" autocomplete="off" name="tglAkhirReservasi" placeholder="ketik Kata Kunci disini">
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="form-control input-sm" onclick="loaddataListUDD();">Cari</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tbl_aktif_listudd2" class="display table table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">No. Trs
                                                </th>
                                                <th align='center'>
                                                    <font size="1">No. Resep
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nama Pasien
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Tgl Transaksi
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Waktu Pemberian
                                                </th>
                                                <th align='center'>
                                                    <font size="1">User Entri
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Action
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
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/inventory/udd/list/uddlist.js"></script>