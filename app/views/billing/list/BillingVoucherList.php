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

.border {
    border-left-color: teal;
    border-left-style: groove;
    border-left-width: 7px;
}
</style>
<div class="main-page">


    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading border">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs border-bottom border-danger" role="tablist">
                                <li role="presentation" class="active"><a class="" href="#pasienaktif"
                                        aria-controls="pasienaktif" role="tab" data-toggle="tab">Voucher Aktif</a></li>
                                <li role="presentation"><a class="" href="#pasienarsip" aria-controls="pasienarsip"
                                        role="tab" data-toggle="tab">Arsip Voucher</a></li>

                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content bg-white p-15">

                                <div role="tabpanel" class="tab-pane active" id="pasienaktif">

                                    <div class="form-group">
                                        <form class="form-horizontal" id="form_periode">

                                            <label for="inputEmail3" class="col-sm-1 control-label">Periode</label>
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

                                    <!-- <div class="table-responsive" style="margin-top: 70px;">
                                        <table id="listbillingbebas" class="display" width="100%"> -->
                                    <div class="panel-body p-20">
                                        <div class="demo-table" width="100%" id="tbl_rincian">
                                            <form id="form_sumtarif_all">
                                                <table id="tbl_pelunasan_voucher_aktif" width="100%"
                                                    class="table table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No. Voucher
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Pasien
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No Registrasi
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Jaminan
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nilai
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <br><br>
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-1 control-label"> Total
                                                        Pembayaran:
                                                    </label><button type="button" class="btn btn-success btn-xs"
                                                        id="cb_tarifall" name="cb_tarifall"
                                                        onclick="btnSumTarifVoucher(this)"><span
                                                            class="glyphicon glyphicon-check"></span>
                                                        Generate Total </button>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="TotalPembayaran" id="TotalPembayaran"
                                                            readonly
                                                            style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 200px;">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- transaksi bayar -->
                                    <div class="col-md-12" id="trs_pelunasan_ui">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Masukkan Jenis
                                                        Pembayaran</h5>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <h5></h5>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-1 control-label"> Nilai Bayar
                                                        :
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="NilaiBayar"
                                                            name="NilaiBayar">
                                                    </div>
                                                    <label for="inputEmail3" class="col-sm-1 control-label"> Tipe Bayar
                                                        :
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <!-- <input type="text" class="form-control" id="TipeBayar" name="TipeBayar"> -->
                                                        <select name="tipepembayaran" id="tipepembayaran"
                                                            class="form-control"
                                                            onchange="getBillto(this.value);getEDC(this.value);getKDREKENING(this.value);getnamatipe(this);">
                                                        </select>
                                                    </div>
                                                    <h1></h1>
                                                </div>

                                                <div class="form-group gut" id="card_ui" style="display: none">
                                                    <label for="inputEmail3" class="col-sm-1 control-label"> Nama Kartu
                                                        :
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" id="namabank" name="namabank"
                                                            onchange="getnamabank(this.value)"> </select>
                                                    </div>
                                                    <label for=" inputEmail3" class="col-sm-1 control-label"> No Kartu :
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="nokartu"
                                                            name="nokartu">
                                                    </div>
                                                    <label for="inputEmail3" class="col-sm-1 control-label"> Tgl Expired
                                                        :
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input type="date" class="form-control" id="TglExpired"
                                                            name="TglExpired">
                                                        <input class="form-control input-sm" id="kd_rekening"
                                                            name="kd_rekening" type="hidden">
                                                        <input class="form-control input-sm" id="tipekartu"
                                                            name="tipekartu" type="hidden">
                                                    </div>
                                                    <label for="inputEmail3" class="col-sm-1 control-label">
                                                    </label>
                                                    <h1></h1>
                                                </div>

                                                <div class="form-group gut" id="telahterima_ui2" style="display: none">

                                                    <label for="perusahaanjpk" class="col-sm-1 control-label"> Nama
                                                        Perusahaan :
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <select name="perusahaanjpk" id="perusahaanjpk"
                                                            class="form-control" style="width:100%"
                                                            onchange="passingVal(this);getnamaperusahaan(this.value);">
                                                        </select>
                                                    </div>
                                                    <h1></h1>
                                                </div>

                                                <div class="form-group gut" id="telahterima_ui3" style="display: none">
                                                    <label for="perusahaanasuransi" class="col-sm-1 control-label"> Nama
                                                        Asuransi :
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <select name="perusahaanasuransi" id="perusahaanasuransi"
                                                            class="form-control" style="width:100%"
                                                            onchange="passingVal(this)">
                                                        </select>
                                                    </div>
                                                    <h1></h1>
                                                </div>

                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-1 control-label"> Nama
                                                        Kwitansi :
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="NamaKuitansi"
                                                            name="NamaKuitansi">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="hidden" class="form-control" id="billto"
                                                            name="billto">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="hidden" class="form-control" id="kodejaminan"
                                                            name="kodejaminan">
                                                    </div>
                                                    <h1></h1>
                                                </div>
                                                <div class="form-group gut">
                                                    <label for="inputEmail3" class="col-sm-1 control-label"> <a
                                                            class="btn btn-primary btn-xs" title="Tambah Baris"
                                                            id="add_row" name="add_row">
                                                            <i class="fa fa-plus-square"></i> Add</a>
                                                    </label>
                                                    <h1></h1>
                                                </div>
                                                <form id="form_pelunasan_payment">
                                                    <div class="form-group">
                                                        <div class="demo-table" width="100%" id="tbl_rincian">
                                                            <table id="tbl_rincianbillingx" width="100%"
                                                                class="table table-striped table-hover cell-border">
                                                                <thead>
                                                                    <tr>
                                                                        <th align='center'>
                                                                            <font size="1">No.
                                                                        </th>
                                                                        <th align='center'>
                                                                            <font size="1">Telah Diterima
                                                                        </th>
                                                                        <th align='center'>
                                                                            <font size="1">Ammount
                                                                        </th>
                                                                        <th align='center'>
                                                                            <font size="1">Jenis Bayar
                                                                        </th>
                                                                        <th align='center'>
                                                                            <font size="1">Tipe Kartu
                                                                        </th>
                                                                        <th align='center'>
                                                                            <font size="1">No. Kartu
                                                                        </th>
                                                                        <th align='center'>
                                                                            <font size="1">Expired
                                                                        </th>
                                                                        <th align='center'>
                                                                            <font size="1">Action
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <!-- <tbody>
                                                    </tbody> -->
                                                                <tbody id="user_data">
                                                                </tbody>
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="2">
                                                                            <font size="1"></font>
                                                                        </th>

                                                                        <th>
                                                                            <font size="1">
                                                                                <div id="grantotalharga"></div>
                                                                            </font>
                                                                            <input type="hidden" name="totalharga"
                                                                                id="totalharga"
                                                                                class="form-control totalharga" />

                                                                        </th>

                                                                        <th colspan="4">
                                                                            <font size="1"></font>
                                                                        </th>

                                                                        <th>
                                                                            <font size="1">
                                                                                <div id="grantotalOrder"></div>
                                                                            </font>
                                                                            <input type="hidden" name="totalrow"
                                                                                id="totalrow"
                                                                                class="form-control totalrow" />
                                                                        </th>

                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-1 control-label"> Sisa
                                                            Bayar
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="sisabayar"
                                                                name="sisabayar" readonly>
                                                        </div>
                                                        <!-- <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="GrandTotalFix" name="GrandTotalFix">
                                                </div> -->
                                                        <h1></h1>
                                                    </div>
                                                </form>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-9 control-label">
                                                    </label>
                                                    <button data-dismiss="" class="btn btn-primary"
                                                        id="savetrs_payment_Pelunasan_Voucher"
                                                        name="savetrs_payment_Pelunasan_Voucher">Save</button>
                                                    <a data-dismiss="modal" class="btn btn-default" href="#"
                                                        id="CloseMe" name="CloseMe">Close</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- END transaksi bayar -->


                                </div>

                                <div role="tabpanel" class="tab-pane" id="pasienarsip">

                                    <div class="form-group">
                                        <form class="form-horizontal" id="form_periode_arsip">

                                            <label for="inputEmail3" class="col-sm-1 control-label">Periode</label>
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
                                    <div class="panel-body p-20">
                                        <div class="demo-table" width="100%" id="tbl_rincian">
                                            <form id="form_sumtarif_all">
                                                <table id="tbl_pelunasan_voucher_arsip" width="100%"
                                                    class="table table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center' width='15px'>
                                                                <font size="1">No
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No. Voucher
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Pasien
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No Registrasi
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Jaminan
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nilai
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                            <th align="center"></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <br><br>
                                                <!-- <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-1 control-label"> Total
                                                        Pembayaran:
                                                    </label><button type="button" class="btn btn-success btn-xs" id="cb_tarifall" name="cb_tarifall" onclick="btnSumTarif(this)"><span class="glyphicon glyphicon-check"></span>
                                                        Generate Total </button>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="TotalPembayaran" id="TotalPembayaran" readonly style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 200px;">
                                                    </div>
                                                </div> -->
                                            </form>
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
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/billing/List/listbillingpelunasan.js"></script>