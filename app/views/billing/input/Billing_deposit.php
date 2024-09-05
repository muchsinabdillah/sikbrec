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
                                <h5><u><b><?= $data['judul'] ?></b></u>
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
                                                <h5>RINCIAN DATA PASIEN</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <h1></h1>
                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> No Transaksi
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="newTRS" id="newTRS" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 220px;">
                                                    <!-- <button type="button" class="btn btn-primary btn-xs"
                                                        onclick="SearchDepoModal()">
                                                        Search Deposit </button> -->

                                                    <div class="btn-group" role="group">
                                                        <a class="btn btn-primary btn-sm btn-rounded "
                                                            id="btn_caridatamr" onclick="SearchDepoModal()">
                                                            <span
                                                                class="glyphicon glyphicon glyphicon-search"></span></a>
                                                        <a id="btnCreateNewMR" name="btnCreateNewMR"
                                                            class="btn btn-success btn-sm btn-rounded"
                                                            onclick="generateIDTRSNew()"><span
                                                                class="glyphicon glyphicon glyphicon glyphicon-plus"></span></a>
                                                    </div>
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label">
                                                    Nama Pasien </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="NamaPasien" id="NamaPasien" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                    <input type="hidden" name="NoMR" id="NoMR" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">

                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="date" name="TglMasuk" id="TglMasuk" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label">
                                                    No Episode </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="NoEpisode" id="NoEpisode" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                    <input type="hidden" class="form-control" id="IDUnit" name="IDUnit"
                                                        readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> No Registrasi
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="NoRegistrasi" id="NoRegistrasi" readonly
                                                        value="<?= $data['id'] ?>"
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Jaminan
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

                                    <div class="panel-heading" id="addnewdeposit" style="display: none">
                                        <div class="panel-title">
                                            <h5>DATA DEPOSIT</h5>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body" id="addnewdepositx1" style="display: none">
                                        <h5></h5>
                                        <div class="form-group">
                                            <!-- <label for="inputEmail3" class="col-sm-1 control-label"> Total
                                                        Riwayat Deposit:
                                                    </label>
                                            <div class="col-sm-2">
                                            <input type="hidden" name="TotalPembayaran" id="TotalPembayaran" readonly style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 200px;">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-1 control-label"> Tambah Deposit >
                                            </label>
                                            <div class="col-sm-3">
                                                <input type="hidden" name="newTRSx" id="newTRSx" readonly style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 200px;">
                                                <button type="button" class="btn btn-success btn-xs" id="cb_tarifall"
                                                    name="cb_tarifall" onclick="generateIDTRSNew()">
                                                    New Deposit </button>
                                            </div> -->
                                            <label for="inputEmail3" class="col-sm-1 control-label"
                                                id="addnewdepositx1b1"> Id
                                                Transaksi Detail :
                                            </label>
                                            <div class="col-sm-2" id="addnewdepositx1b2">
                                                <input type="text" name="newTRSdetail" id="newTRSdetail" readonly
                                                    style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 200px;">
                                            </div>
                                            <h1></h1>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 control-label" id="card_uix"> Nilai
                                                Bayar :
                                            </label>
                                            <div class="col-sm-3" id="card_uix">
                                                <input type="text" class="form-control" id="NilaiBayar"
                                                    name="NilaiBayar">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-1 control-label"> Tipe Bayar :
                                            </label>
                                            <div class="col-sm-3">
                                                <!-- <input type="text" class="form-control" id="TipeBayar" name="TipeBayar"> -->
                                                <select name="tipepembayaran" id="tipepembayaran" class="form-control"
                                                    onchange="getBillto(this.value);getEDC(this.value);getKDREKENING(this.value);">
                                                </select>
                                            </div>
                                            <h1></h1>
                                        </div>

                                        <div class="form-group gut" id="card_ui" style="display: none">
                                            <label for="inputEmail3" class="col-sm-1 control-label"> Nama Kartu :
                                            </label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="namabank" name="namabank"
                                                    onchange="getnamabank(this.value)"> </select>
                                            </div>
                                            <label for="inputEmail3" class="col-sm-1 control-label"> No Kartu :
                                            </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="nokartu" name="nokartu">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-1 control-label"> Tgl Expired :
                                            </label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="TglExpired"
                                                    name="TglExpired">
                                                <input class="form-control input-sm" id="kd_rekening" name="kd_rekening"
                                                    type="hidden">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-1 control-label">
                                            </label>
                                            <h1></h1>
                                        </div>

                                        <div class="form-group gut" id="telahterima_ui2" style="display: none">

                                            <label for="perusahaanjpk" class="col-sm-1 control-label"> Nama Perusahaan :
                                            </label>
                                            <div class="col-sm-3">
                                                <select name="perusahaanjpk" id="perusahaanjpk" class="form-control"
                                                    style="width:100%" onchange="passingVal(this)">
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
                                                    class="form-control" style="width:100%" onchange="passingVal(this)">
                                                </select>
                                            </div>
                                            <h1></h1>
                                        </div>

                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-1 control-label"> Nama Kuitansi :
                                            </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="NamaKuitansi"
                                                    name="NamaKuitansi">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-1 control-label"> Keterangan :
                                            </label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="KeteranganDeposit"
                                                    name="KeteranganDeposit">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="hidden" class="form-control" id="billto" name="billto">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="hidden" class="form-control" id="kodejaminan"
                                                    name="kodejaminan">
                                            </div>
                                            <h1></h1>
                                        </div>


                                    </div>

                                    <div class="panel-body" id="addnewdepositx2">
                                        <div class="form-group" id="addnewdepositx3aa" style="display: none">
                                            <label for="inputEmail3" class="col-sm-1 control-label"> <a
                                                    class="btn btn-danger btn-xs" title="Tambah Baris" id="add_row"
                                                    name="add_row">
                                                    <i class="fa fa-plus-square"></i> Tambah Janis Pembayaran</a>
                                            </label>
                                            <h1></h1>
                                        </div>
                                        <form id="form_deposit">
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
                                                        <tfoot>
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
                                                                    <input type="hidden" name="totalrow" id="totalrow"
                                                                        class="form-control totalrow" />
                                                                </th>

                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-1 control-label"> Grand Total
                                                </label>
                                                <div class="col-sm-2">
                                                    <input type="text" name="GrandTotalPembayaran"
                                                        id="GrandTotalPembayaran" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 200px;">
                                                </div>
                                                <h1></h1>
                                            </div>


                                        </form>

                                        <div class="form-group" id="addnewdepositx3a" style="display: none">
                                            <label for="inputEmail3" class="col-sm-9 control-label">
                                            </label>
                                            <button data-dismiss="" class="btn btn-primary" id="savetrs_payment_deposit"
                                                name="savetrs_payment_deposit">Save</button>&nbsp
                                            <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe"
                                                name="CloseMe">Close</a>
                                        </div>
                                    </div>

                                    <div class="panel-body" id="addnewdepositx3b" style="display: none">
                                        <label for="inputEmail3" class="col-sm-9 control-label">
                                        </label>
                                        <button data-dismiss="" class="btn btn-primary"
                                            onclick="updateDataDepo2bdetail()">Update</button>&nbsp<button
                                            class="btn btn-warning" onclick="deleteDepo2()">Delete</button>
                                        <a data-dismiss=" modal" class="btn btn-default" href="#" id="CloseMe"
                                            name="CloseMe">Close</a>
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

<!-- modal depo -->

<div class="modal fade" id="ModalDepoRincian" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> RIWAYAT DEPOSIT </h4>
            </div>
            <div class="modal-body">
                <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                    <form id="form_Riwayat_Depo">
                        <table class="table table-bordered table-striped table-hover dataTable" id="tbl_RiwayatDepo"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th align="center">No</th>
                                    <th align="center">No. Transaksi</th>
                                    <th align="center">Tanggal Transaksi</th>
                                    <th align="center">Total Deposit</th>
                                    <th align="center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th align="center"></th>
                                    <th align="center"></th>
                                    <th align="center"></th>
                                    <th align="center"></th>
                                    <th align="center"></th>
                                </tr>
                                <!-- <tr>
                                    <th colspan="8"></th>
                                    <th align="center"><button type="button" title="Approve Yang Dipilih"
                                            class="btn btn-success btn-xs" id="cb_approveBDRSall"
                                            name="cb_approveBankDarahall" onclick="BtnApproveBDRS(this)"><span
                                                class="glyphicon glyphicon-check"></span> All </button>&nbsp<button
                                            type="button" itle="Batal Approve Yang Dipilih"
                                            class="btn btn-danger btn-xs" id="cb_btlapproveBankDarahall"
                                            name="cb_btlapproveBDRSall" onclick="BtnApproveBDRS(this)"><i
                                                class="fa fa-ban"></i>All</button></th>
                                </tr> -->
                            </tfoot>
                        </table>

                    </form>
                </div>
            </div>
            <!-- onclick="BtnTindakanByUnit()" -->
            <div class="modal-footer">
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal"
                    onclick="btnrRefershTable()"><i class="fa fa-times"></i>Tidak</button>
            </div>
        </div>
    </div>
</div>

<!-- modal depo -->



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
                    <!-- <div class="form-group gut ">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Cetak/Kirim</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="signAlasanCetak" autocomplete="off" name="signAlasanCetak" placeholder="ketik Alasan Cetak disini">
                            <small>Silahkan Masukan Alasan cetak selengkap mungkin, untuk memudahkan Tracing Data.</small>
                        </div>

                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <!-- <div class="btn-group" role="group">
                <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnSendWA" name="btnSendWA"><i class="fa fa-whatsapp"></i> Send WA </button>
                    <button type="button" class="btn btn-warning btn-wide btn-rounded" id="btnSendEmail" name="btnSendEmail"><i class="fa fa-envelope" aria-hidden="true"></i> Send Email </button>
                </div> -->
                <button type="button" class="btn btn-primary btn-wide" id="btnSaveSend" name="btnSaveSend"><i
                        class="fa fa-save" aria-hidden="true"></i> SIMPAN DAN KIRIM </button>
                <!-- <button type="button" class="btn btn-primary btn-wide" data-toggle='modal' id="btn_rincian_biaya">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                    Print</button> -->
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>

                <!-- <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btncetakDigital"
                        name="btncetakDigital"><i class="fa fa-print"></i> PRINT </button>
                </div> -->

                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>

<!--#END Modal closing ------------------------>
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/billing/input/Billing_deposit.js"></script>