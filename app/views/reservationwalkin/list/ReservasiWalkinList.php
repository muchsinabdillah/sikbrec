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
                                            <span class="glyphicon glyphicon glyphicon-plus"></span>Reservasi Baru</a>
                                    </div>
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- <form class="form-horizontal" id="form_reservationlist"> -->

                            <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                <li role="presentation" class="active"><a class="" href="#reservasi_aktif" aria-controls="reservasi_aktif" role="tab" data-toggle="tab">Reservasi Aktif</a>
                                </li>
                                <li role="presentation"><a class="" href="#reservasi_arsip" aria-controls="reservasi_arsip" role="tab" data-toggle="tab">Arsip Reservasi</a>
                                </li>

                            </ul>

                            <br>
                            <!-- </form> -->
                            <div class="tab-content bg-white p-15">

                                <div role="tabpanel" class="tab-pane active" id="reservasi_aktif">

                                    <div class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                        <div class="form-group ml-20">
                                            <h3>Cari Data Reservasi</h3>

                                            <div class="col-sm-2">
                                                <!-- <label for="form-control input-sm">Input Awal</label> -->
                                                <input class="form-control input-sm" type="date" id="tglAwalReservasi" autocomplete="off" name="tglAwalReservasi" placeholder="ketik Kata Kunci disini">
                                            </div>
                                            <div class="col-sm-2">
                                                <!-- <label for="form-control input-sm">Input Akhir</label> -->
                                                <input class="form-control input-sm" type="date" id="tglAkhirReservasi" autocomplete="off" name="tglAkhirReservasi" placeholder="ketik Kata Kunci disini">
                                            </div>
                                            <div class="col-sm-4">
                                                <select name="jenisdata" id="jenisdata" class="form-control input-sm" required>
                                                    <option value="1">Tanggal Booking</option>
                                                    <option value="2">Tanggal Entri</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="form-control input-sm" onclick="caridatareservasi();">Cari</button>
                                            </div>
                                        </div>
                                        <div class="demo-table" width="100%" id="tbl_rekap" style="margin-top: 10px;overflow-x:auto;">
                                            <form id="form_approve">
                                                <table id="tbl_aktif" width="100%" class="table table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">ID
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No MR
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Pasien
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tanggal Booking
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Poliklinik
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Dokter
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Handphone
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Jenis Pembayaran
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Keterangan
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No Booking
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Antrian
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Action
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id='tabledatareservasi'>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="11"></th>
                                                            <th align="center"><button type="button" title="Kirim Yang Dipilih" class="btn btn-success btn-xs" id="cb_approvefarmasiall" name="cb_approvefarmasiall" onclick="BtnApprove(this)"><i class="fa fa-whatsapp" aria-hidden="true"></i> Kirim Reminder </button>
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </form>
                                        </div>



                                    </div>



                                </div>
                                <div role="tabpanel" class="tab-pane" id="reservasi_arsip">
                                    <div class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                        <div class="form-group ml-20">
                                            <h3>Cari Data Arsip Reservasi (Yang Sudah Datang)</h3>

                                            <div class="col-sm-2">
                                                <!-- <label for="form-control input-sm">Input Awal</label> -->
                                                <input class="form-control input-sm" type="date" id="tglAwalReservasi_arsip" autocomplete="off" name="tglAwalReservasi_arsip" placeholder="ketik Kata Kunci disini">
                                            </div>
                                            <div class="col-sm-2">
                                                <!-- <label for="form-control input-sm">Input Akhir</label> -->
                                                <input class="form-control input-sm" type="date" id="tglAkhirReservasi_arsip" autocomplete="off" name="tglAkhirReservasi_arsip" placeholder="ketik Kata Kunci disini">
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="form-control input-sm" onclick="caridatareservasi_arsip();">Cari</button>
                                            </div>
                                        </div>
                                        <div class="demo-table" width="100%" id="tbl_rekap" style="margin-top: 10px;overflow-x:auto;">
                                            <form id="form_approve">
                                                <table id="tbl_arsip" width="100%" class="table table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">No
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No MR
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Pasien
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tanggal Booking
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Poliklinik
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Dokter
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Handphone
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Jenis Pembayaran
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Keterangan
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No Booking
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Antrian
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No Registrasi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </form>
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
<script>
    $(document).ready(function() {
        $(".preloader").fadeOut();
    })
</script>
<script src="<?= BASEURL; ?>/js/App/reservation/walkin/listreservasiwalkin.js"></script>