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
                                <h5 class="underline"><?= $data['judul'] ?><small>( Penjualan Bebas )</small>
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmDataPasien">
                                <!-- Update -->
                                <div class="col-md-12">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Data Pasien<small>Data pasien berisikan informasi tentang
                                                        pasien</small></h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> No Transaksi
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="NoRegistrasi" id="NoRegistrasi" readonly
                                                        value="<?= $data['id'] ?>"
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label">
                                                    Nama Pembeli</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="NamaPembeli" id="NamaPembeli" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                    <!-- <input type="hidden" class="form-control" id="IDUnit" name="IDUnit"
                                                        readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;"> -->
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label">Jenis Kelamin
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="JenisKelamin" id="JenisKelamin" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Status Pasien
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="StatusPasien" id="StatusPasien" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="date" name="TglLahir" id="TglLahir" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal
                                                    Pembelian
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="date" name="TglPembelian" id="TglPembelian" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;width: 300px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Lokasi
                                                    Pembelian
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="LokasiPembelian" id="LokasiPembelian"
                                                        readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Penjamin
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Penjamin" id="Penjamin" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                    <input type="hidden" class="form-control" id="GroupJaminan"
                                                        name="GroupJaminan" readonly>
                                                    <input type="hidden" class="form-control" id="penjamin_kode"
                                                        name="penjamin_kode" readonly>
                                                    <input type="hidden" class="form-control" id="TypePatientID"
                                                        name="TypePatientID" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat
                                                </label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control input-sm " id="Alamat" name="Alamat"
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;"></textarea>
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Status Billing
                                                </label>
                                                <div class="col-sm-4">
                                                    <label id="statusreg" style="margin-top:10px"></label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Update -->

                                <div class="form-group gut">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-1">
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                </div>

                                <hr>
                            </form>
                            <div class="col-md-12">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Detail Billing<small>Detail billing pasien berisikan informasi tentang
                                                    detail order dan biaya
                                                    pasien </small></h5>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body">

                                        <button type="button" class="btn btn-success btn-xs" id="btn_approvefrm"
                                            name="btn_approvefrm">
                                            <span class="glyphicon glyphicon-check"></span> Approve Penjualan
                                            Bebas</button>

                                        <button class="btn btn-info  btn-xs " id="btn_payment" name="btn_payment">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            Pembayaran</button>
                                        <!-- <button class="btn btn-info  btn-xs" onclick="showIDbyNoRegx()">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            Pembayaran</button> -->

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs border-bottom border-danger" role="tablist">
                                            <li role="presentation" class="active"><a class="" href="#breakdown"
                                                    aria-controls="breakdown" role="tab" data-toggle="tab">Total
                                                    Pembayaran</a></li>
                                            <li role="presentation"><a class="" href="#rincianbiaya"
                                                    aria-controls="rincianbiaya" role="tab" data-toggle="tab">Rincian
                                                    Biaya</a></li>
                                            <li role="presentation"><a class="" href="#riwayatpayment"
                                                    aria-controls="riwayatpayment" role="tab" data-toggle="tab">Riwayat
                                                    Pembayaran</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content bg-white p-15">
                                            <div role="tabpanel" class="tab-pane active" id="breakdown">
                                                <div class="demo-table" style="margin-top: 10px;" width="100%"
                                                    id="tbl_breakdown">
                                                    <table id="tbl_breakdown" width="100%"
                                                        class="table table-striped table-hover cell-border">
                                                        <thead>
                                                            <tr>
                                                                <th align='center' width='70px'>
                                                                    <font size="1">No
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Keterangan
                                                                </th>
                                                                <th align='center' colspan="2">
                                                                    <font size="1">Nilai
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- no1 -->
                                                            <tr>
                                                                <td align='left'>
                                                                    <font size="1">1
                                                                </td>
                                                                <td align='left'>
                                                                    <font size="1">Hutang
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="grandTotalHutang"
                                                                            value="grandTotalHutang"></div>
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                </td>
                                                            </tr>
                                                            <!-- no2 -->
                                                            <tr>
                                                                <td align='left'>
                                                                    <font size="1">2
                                                                </td>
                                                                <td align='left'>
                                                                    <font size="1">Bill Dalam Perawatan
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="grandTotalBillPerawatan"
                                                                            value="grandTotalBillPerawatan"></div>
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                </td>
                                                            </tr>
                                                            <!-- SUBTOTAL -->
                                                            <tr>
                                                                <td align='center' colspan="3"
                                                                    style="background-color:#D26D6D;color:white;">
                                                                    <font size="2">SUBTOTAL
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="subTotal1" value="subTotal1"></div>
                                                                </td>
                                                            </tr>
                                                            <!-- SUBTOTAL -->

                                                            <!-- no3 -->
                                                            <tr>
                                                                <td align='left'>
                                                                    <font size="1">3
                                                                </td>
                                                                <td align='left'>
                                                                    <font size="1">Biaya Administrasi
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="administrasi" value="administrasi">
                                                                        </div>
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                </td>
                                                            </tr>
                                                            <!-- no4 -->
                                                            <tr>
                                                                <td align='left'>
                                                                    <font size="1">4
                                                                </td>
                                                                <td align='left'>
                                                                    <font size="1">Biaya Materai
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="biayamaterai" value="biayamaterai">
                                                                        </div>
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                </td>
                                                            </tr>
                                                            <!-- GRANDTOTAL -->
                                                            <tr>
                                                                <td align='center' colspan="3"
                                                                    style="background-color:#D26D6D;color:white;">
                                                                    <font size="2">GRANDTOTAL
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="grandTotal1" value="grandTotal1"></div>
                                                                </td>
                                                            </tr>
                                                            <!-- GRANDTOTAL -->

                                                            <!-- no5 -->
                                                            <tr>
                                                                <td align='left'>
                                                                    <font size="1">5
                                                                </td>
                                                                <td align='left'>
                                                                    <font size="1">Biaya Terbayar
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="totalpembayaran1"
                                                                            value="totalpembayaran1"></div>
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                </td>
                                                            </tr>
                                                            <!-- no6 -->
                                                            <tr>
                                                                <td align='left'>
                                                                    <font size="1">6
                                                                </td>
                                                                <td align='left'>
                                                                    <font size="1">Biaya Deposit
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="totaldeposit" value="totaldeposit">
                                                                        </div>
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                </td>
                                                            </tr>
                                                            <!-- TOTAL PEMBAYARAN -->
                                                            <tr>
                                                                <td align='center' colspan="3"
                                                                    style="background-color:#D26D6D;color:white;">
                                                                    <font size="2">TOTAL PEMBAYARAN
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="grandTotalpembayaran1"
                                                                            value="grandTotalpembayaran1"></div>
                                                                </td>
                                                            </tr>
                                                            <!-- TOTAL PEMBAYARAN -->
                                                            <!-- TOTAL PEMBAYARAN -->
                                                            <tr>
                                                                <td align='center' colspan="3"
                                                                    style="background-color:#D26D6D;color:white;">
                                                                    <font size="2">YANG HARUS DIBAYAR
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="yangharusdibayarkan1"
                                                                            value="yangharusdibayarkan1"></div>
                                                                </td>
                                                            </tr>
                                                            <!-- TOTAL PEMBAYARAN -->
                                                            <!-- TOTAL PEMBAYARAN -->
                                                            <tr>
                                                                <td align='center' colspan="3"
                                                                    style="background-color:#D26D6D;color:white;">
                                                                    <font size="2">PENGEMBALIAN
                                                                </td>
                                                                <td align='right'>
                                                                    <font size="1">
                                                                        <div id="pengembalian1" value="pengembalian1">
                                                                        </div>
                                                                </td>
                                                            </tr>
                                                            <!-- TOTAL PEMBAYARAN -->

                                                        </tbody>
                                                        <tfoot>

                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <!--Tab 2 asassassas-->
                                            <div role="tabpanel" class="tab-pane" id="rincianbiaya">
                                                <div class="demo-table" width="100%" id="tbl_rekap"
                                                    style="margin-top: 10px;overflow-x:auto; ">
                                                    <table id="tbl_rincianbiaya" width="100%"
                                                        class="table table-striped table-hover cell-border">
                                                        <thead>
                                                            <tr>
                                                                <th align='center'>
                                                                    <font size="1">NO TRS
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">ID FO1
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Tanggal
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Nama Tindakan
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Unit
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Kelas
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Qty
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Harga
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Diskon
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Total
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Klaim
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Kekurangan
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Bayar
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Action&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
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
                                                                <th align="center"></th>
                                                                <th align="center"></th>
                                                                <th align="center"></th>
                                                                <th align="center"></th>
                                                                <th align="center"></th>
                                                                <th align="center"></th>
                                                                <th align="center">

                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <input type="hidden" name="tblRincian_TotalBill"
                                                    id="tblRincian_TotalBill" readonly
                                                    style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;">
                                                <input type="hidden" name="tblRincian_klaim" id="tblRincian_klaim"
                                                    readonly
                                                    style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;">
                                                <input type="hidden" name="tblRincian_bayar" id="tblRincian_bayar"
                                                    readonly
                                                    style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;">
                                            </div>
                                            <!--Tab 3-->
                                            <div role="tabpanel" class="tab-pane" id="riwayatpayment">
                                                <!-- <div class="demo-table" width="100%" id="tbl_rekap" style="margin-top: 10px;"> -->
                                                <button class="btn btn-primary  btn-xs" data-toggle='modal'
                                                    title="Print This Payment" onclick="printrincianAll()">
                                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    Print All Rekap Nota</button>
                                                <button class="btn btn-primary  btn-xs" data-toggle='modal'
                                                    title="Print This Payment" onclick="printkuitansiAll()">
                                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                                    Print All Rekap Kuintansi</button>

                                                <div class="demo-table" width="100%" id="tbl_rekap"
                                                    style="margin-top: 10px;overflow-x:auto; ">
                                                    <table id="tbl_riwayatpayment" width="100%"
                                                        class="table table-striped table-hover cell-border">
                                                        <thead>
                                                            <tr>
                                                                <th align='center'>
                                                                    <font size="1">No
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">NO Transaksi
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">No Kuitansi
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Tanngal
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Tipe Pembayaran
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Jumlah
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Kasir
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Keterangan
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Nama Test
                                                                </th>
                                                                <th align='center'>
                                                                    <font size="1">Action
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group gut">
                                                <div class="col-sm-1">
                                                    <label>Periode</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="date" class="form-control" id="tglawal" name="tglawal">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="date" class="form-control" id="tglakhir"
                                                        name="tglakhir">
                                                </div>
                                                <div class="col-sm-6">
                                                    <button class="btn btn-warning  btn-rounded " id="btn_periode"
                                                        name="btn_periode">
                                                        <span class="glyphicon glyphicon-calendar"
                                                            aria-hidden="true"></span></button>
                                                </div>
                                                <div class="col-sm-1">
                                                    <!-- 20/08/2024 -->
                                                    <button class="btn btn-warning  btn-rounded" data-toggle='modal'
                                                        title="Print This Payment" id="btn_openorclose_bill"
                                                        type="button" onclick="btnCloseOrOpenBill()">
                                                        <span class="glyphicon glyphicon-printx" aria-hidden="true">
                                                        </span>
                                                    </button>
                                                    <input type="hidden" name="Ket_btn_closeoropenbill"
                                                        id="Ket_btn_closeoropenbill">
                                                    <!-- 20/08/2024 -->
                                                </div>

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
</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->
<!--#START Modal closing  ------------------------>

<div class="modal fade" id="notif_ShowTTD_Digital" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Entri Alasan Cetak Anda disini</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmDigitalSign">
                    <br>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Bahasa</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="pkuitansi_lang" readonly
                                autocomplete="off" name="pkuitansi_lang" value="<?= $data['pkuitansi_lang'] ?>">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Jenis Cetakan</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="pkuitansi_jeniscetakan" readonly
                                autocomplete="off" name="pkuitansi_jeniscetakan"
                                value="<?= $data['pkuitansi_jeniscetakan'] ?>">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. Transaksi</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="pkuitansi_notrs" readonly
                                autocomplete="off" name="pkuitansi_notrs" value="<?= $data['pkuitansi_notrs'] ?>">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label"><i class="fa fa-whatsapp"
                                style="font-size:18px"></i> No. HP</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="pnohp_pasien" autocomplete="off"
                                name="pnohp_pasien">
                        </div>
                    </div>
                    <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label"><i class="fa fa-envelope"
                                style="font-size:18px"></i> Email</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="pemail_pasien" autocomplete="off"
                                name="pemail_pasien">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-wide" id="btnSaveSend" name="btnSaveSend"><i
                        class="fa fa-save" aria-hidden="true"></i> SIMPAN DAN KIRIM </button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="mAlasanBtlPayment" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Masukkan Alasan Untuk Pembatalan Payment</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmAlasanBtlPayment">
                    <br>
                    <div class="form-group gut ">
                        <div class="col-sm-12">
                            <input class="form-control input-sm" type="hidden" id="tNoTrs" name="tNoTrs">
                            <textarea class="form-control input-sm " id="alasanBtlPayment" name="alasanBtlPayment"
                                placeholder="Ketik alasan disini, untuk pembatalan payment"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
                <button type="button" class="btn btn-danger btn-wide" onclick="btnbatalriwayatpembayaranbymodal()"><i
                        class="fa fa-trash" aria-hidden="true"></i> Batal </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Approve Penjualan Bebas------------------------------------------------>
<div class="modal fade" id="approvemodalfarmasibebas" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Approve Penjualan Bebas</h4>
            </div>
            <div class="modal-body">
                <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                    <form id="form_approve">
                        <table class="table table-bordered table-striped table-hover dataTable" id="tbl_approvefarmasi"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <!-- <th align="center"></th> -->
                                    <th align="center">No Transaksi</th>
                                    <th align="center">Tgl Pembelian</th>
                                    <th align="center">Satuan Pembelian</th>
                                    <th align="center">No Product</th>
                                    <th align="center">Nama Product</th>
                                    <th align="center">Qty Order</th>
                                    <th align="center">Harga</th>
                                    <th align="center">Status</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="5"></th>
                                    <th align="right" colspan="3"><button type="button" title="Approve Yang Dipilih"
                                            class="btn btn-success btn-xs" id="cb_approvefarmasiall"
                                            name="cb_approvefarmasiall" onclick="BtnApprovePenjualanBebas(this)"><span
                                                class="glyphicon glyphicon-check"></span> Appprove </button>&nbsp<button
                                            type="button" title="Batal Approve Yang Dipilih"
                                            class="btn btn-danger btn-xs" id="cb_btlapprovefarmasiall"
                                            name="cb_btlapprovefarmasiall" onclick="BtnApprovePenjualanBebas(this)"><i
                                                class="fa fa-ban"></i>Batal Approve</button></th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a> -->
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal"
                    onclick="btnrRefershTable()"><i class="fa fa-times"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Approve Penjualan Bebas--------------------------------------------->


<!-- Modal Tarif Tindakan -->
<div class="modal fade" id="modaltindakanbyorderOperasi" style="overflow-y: auto" data-backdrop="static"
    data-keyboard="false" aria-labelledby="modal4Label" data-backdrop-color="gray">

    <div class="modal-dialog-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> DATA TARIF PEMBELIAN</h4>
            </div>
            <div class="modal-body">
                <!--  awal untuk tab-->
                <!-- Nav tabs -->
                <form class="form-horizontal" id="form_tindakan_new">
                    <div class="col-sm-12">
                        <div class="form-group ">
                            <label for=" inputEmail3" class="col-sm-2 control-label"> ID Billing<sup
                                    class="color-danger">*</sup></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="Idbilling" id="Idbilling" readonly>
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Pasien <sup
                                    class="color-danger">*</sup></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="bilNamaPasien" readonly
                                    id="bilNamaPasien">
                                <input type="hidden" class="form-control" name="xgrupjaminan" readonly
                                    id="xgrupjaminan">
                            </div>
                        </div>
                        <div class="form-group gut">
                            <label for=" inputEmail3" class="col-sm-2 control-label"> No. Trasaksi <sup
                                    class="color-danger">*</sup></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="bilNOreg" readonly id="bilNOreg">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal/Jam <sup
                                    class="color-danger">*</sup></label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" name="dateabilling" id="dateabilling">
                            </div>
                            <div class="col-sm-2">
                                <input type="time" class="form-control" name="timeabilling" id="timeabilling">
                            </div>
                        </div>
                        <div class="form-group gut">
                            <label for=" inputEmail3" class="col-sm-2 control-label"> Jaminan <sup
                                    class="color-danger">*</sup></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" readonly name="bilNamaJaminan"
                                    id="bilNamaJaminan">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="panel border" style="border-radius: 0px;">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h5> DETAIL TARIF</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="detail_fo_bill">
                        <div class="demo-table" style="margin-top: 10px;overflow-x:auto; ">
                            <table id="tbl_fo_bill" class="display table table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th align='center'>
                                            <font size="1">NO
                                        </th>
                                        <th align='center'>
                                            <font size="1">ID
                                        </th>
                                        <th align='center'>
                                            <font size="1">Nama Tarif
                                        </th>
                                        <th align='center'>
                                            <font size="1">Nama Dokter
                                        </th>
                                        <th align='center'>
                                            <font size="1">Tgl Transaksi
                                        </th>
                                        <th align='center'>
                                            <font size="1">Qty
                                        </th>
                                        <th align='center'>
                                            <font size="1">Nilai
                                        </th>
                                        <th align='center'>
                                            <font size="1">Subtotal
                                        </th>
                                        <th align='center'>
                                            <font size="1">Diskon
                                        </th>
                                        <th align='center'>
                                            <font size="1">Total
                                        </th>
                                        <th align='center'>
                                            <font size="1">Group
                                        </th>
                                        <th align='center'>
                                            <font size="1">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tbody id="user_datas">
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="demo-table" id="tbl_Tarif_ganti" nama="tbl_Tarif_ganti"
                        style="margin-top: 10px;overflow-x:auto; display : none;">
                        <div class="panel-title">
                            <h5>GENERATE TARIF GANTI JAMINAN</h5>
                        </div>
                        <table id="tbl_update_tarif" class="display table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        <font size="1">ID
                                    </th>
                                    <th align='center'>
                                        <font size="1">Nama Tarif
                                    </th>
                                    <th align='center'>
                                        <font size="1">Nilai
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal"
                    onclick="btnrRefershTable()"><i class="fa fa-times"></i>Close</button>
            </div>

        </div>
    </div>
</div>
<!--#END Modal Tarif Tindkaan ------------------------>

<!-- MODAL TARIF TINDAKAN KE 2 -->
<!-- <div class="modal fade" id="modaltablefo2" style="overflow-y: auto" data-backdrop="static" data-keyboard="false" aria-labelledby="modal4Label" data-backdrop-color="gray"> -->
<div class="modal fade" id="modaltablefo2" tabindex="-1" role="dialog">
    <div class="modal-dialog-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> EDIT TARIF</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Id FO1 </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="Idbillingfo1" id="Idbillingfo1"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> No Transaksi </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NoTRSBill1" id="NoTRSBill1"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Tgl Transaksi </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="tgltransaksi" id="tgltransaksi"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-12 control-label"></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-8">
                            <h5 class="underline mt-30">DETAIL KOMPONEN BILLING</h5>
                            <div class="demo-table" style="overflow-x:auto; ">
                                <table id="tbl_fo_bill_2" width="100%"
                                    class="table table-striped table-hover cell-border">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">ID
                                            </th>
                                            <th align='center'>
                                                <font size="1">Kode Tarif
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama Tarif
                                            </th>
                                            <th align='center'>
                                                <font size="1">Qty
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nilai
                                            </th>
                                            <th align='center'>
                                                <font size="1">Subtotal
                                            </th>
                                            <th align='center'>
                                                <font size="1">Diskon
                                            </th>
                                            <th align='center'>
                                                <font size="1">Total
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
                        <div class="col-md-4">
                            <h5 class="underline mt-30">Revisi Detail Komponen Billing</h5>
                            <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Nama Tarif </label>
                                    <div class="col-sm-8">
                                        <input type="hidden" class="form-control" name="id_fo2" id="id_fo2" readonly>
                                        <input type="hidden" class="form-control" name="kodetarif_fo2"
                                            id="kodetarif_fo2" readonly>
                                        <input type="text" class="form-control" name="namatarif_fo2" id="namatarif_fo2"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Qty </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="qty_fo2" id="qty_fo2">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Diskon </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="diskon_fo2" id="diskon_fo2">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Nilai Tarif </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nilai_fo2" id="nilai_fo2"
                                            readonly>
                                        <input type="hidden" class="form-control" name="nilaipdp_fo2" id="nilaipdp_fo2"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-9 control-label"> </label>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-warning btn-rounded btn-wide"
                                            id="btnupfo2update" onclick="BtnUpdateBillfo2()">Update</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="col-md-12">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"
                            onclick="BtnCLoseClear()"><i class="fa fa-times"></i>Close</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- END MODAL TARIF TINDAKAN KE 2 -->
        <!-- ========== COMMON JS FILES ========== -->
        <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
        <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
        <script src="<?= BASEURL; ?>/js/App/billing/input/Billing_Bebas.js"></script>