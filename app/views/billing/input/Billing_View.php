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
                                <h5 class="underline"><?= $data['judul'] ?><small>( Pasca Rawat Inap )</small>
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
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="NamaPasien" id="NamaPasien" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label">
                                                    Dokter DPJP</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Dokter" id="Dokter" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> No
                                                    Registrasi
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="NoRegistrasi" id="NoRegistrasi" readonly
                                                        value="<?= $data['id'] ?>"
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label">
                                                    Unit</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Unit" id="Unit" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                    <input type="hidden" class="form-control" id="IDUnit" name="IDUnit"
                                                        readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> No Episodess
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="NoEpisode" id="NoEpisode" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Kelas
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="IDKelas" id="IDKelas" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> No MR
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="NoMR" id="NoMR" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal
                                                    Masuk / Pulang
                                                </label>
                                                <div class="col-sm-2">
                                                    <input type="date" name="TglMasuk" id="TglMasuk" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px;width: 300px;">
                                                </div>

                                                <div class="col-sm-2">
                                                    <input type="date" name="TglKeluar" id="TglKeluar"
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal
                                                    Lahir
                                                    (Usia)
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="TanggalLahir" id="TanggalLahir" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Hak Kelas
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="HakKelas" id="HakKelas" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
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
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Diagnosa
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Diagnosa" id="Diagnosa" readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Alih Status
                                                    Dari
                                                </label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="AlihStatusDari" id="AlihStatusDari"
                                                        readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-primary  btn-rounded "
                                                        id="btn_showrajal" name="btn_showrajal">
                                                        <i class="fa fa-eye"></i> Lihat</button>
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Keterangan
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="Keterangan_Ext" id="Keterangan_Ext"
                                                        readonly
                                                        style="background-color: transparent;border-color: transparent; border-bottom: 1px solid darkgrey; border-radius: 0px; width: 300px;">
                                                </div>
                                            </div>

                                            <div class="form-group gut">
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
                                        <button type="button" class="btn btn-xs" style="background-color:#74cf9e"
                                            onclick="BtnTindakanByUnit()"><span class="glyphicon glyphicon-plus"></span>
                                            Tindakan</button>

                                        <button type="button" class="btn btn-success btn-xs" id="btn_approvefrm"
                                            name="btn_approvefrm">
                                            <span class="glyphicon glyphicon-check"></span> Approve Farmasi</button>

                                        <button type="button" class="btn btn-success btn-xs" id="btn_approvefrmlabo"
                                            name="btn_approvefrmlabo">
                                            <span class="glyphicon glyphicon-check"></span> Approve
                                            Laboratorium</button>

                                        <button type="button" class="btn btn-success btn-xs" id="btn_approvefrmRad"
                                            name="btn_approvefrmRad">
                                            <span class="glyphicon glyphicon-check"></span> Approve Radiologi</button>

                                        <button type="button" class="btn btn-success btn-xs" id="btn_approvefrmBDRS"
                                            name="btn_approvefrmBDRS">
                                            <span class="glyphicon glyphicon-check"></span> Approve Bank Darah</button>

                                        <button class="btn btn-info  btn-xs " id="btn_payment" name="btn_payment">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            Pembayaran</button>
                                        <!-- <button class="btn btn-info  btn-xs " id="btn_Voucher" name="btn_Voucher">
                                            <span class="glyphicon glyphicon-plus"></span><i class="fa fa-money" aria-hidden="true"></i>
                                            Voucher Pengembalian</button> -->
                                        <!-- <button class="btn btn-secondary  btn-xs " id="btn_lock" name="btn_lock">
                                        <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                                        Lock</button> -->

                                        <!-- <button class="btn btn-primary  btn-xs" data-toggle='modal' title="Print This Payment" id="btn_rincian_biaya">
                                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                            Print Nota Rekap</button>
                                        <button class="btn btn-primary  btn-xs" data-toggle='modal' title="Print This Payment" id="btn_rekap_kuintansi">
                                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                            Print Kuintansi Rekap</button> -->

                                        <!-- 20/08/2024 -->
                                        <button class="btn btn-warning  btn-xs" data-toggle='modal'
                                            title="Print This Payment" id="btn_openorclose_bill" type="button"
                                            onclick="btnCloseOrOpenBill()">
                                            <span class="glyphicon glyphicon-printx" aria-hidden="true">
                                            </span>
                                        </button>

                                        <input type="hidden" name="Ket_btn_closeoropenbill"
                                            id="Ket_btn_closeoropenbill">
                                        <!-- 20/08/2024 -->

                                        <!-- <button class="btn btn-warning  btn-xs" data-toggle='modal'
                                            title="Print This Payment" id="btn_close_bill" type="button">
                                            <span class="glyphicon glyphicon-printx" aria-hidden="true"></span>
                                            Close Bill</button> -->

                                        <!-- <button type="button" class="btn btn-xs" style="background-color:#74cf9e"
                                            onclick="btn_Pasien_kabur()"><span class="glyphicon glyphicon-plus"></span>
                                            notif pasien kabur</button> -->
                                        <!-- <button type="button" class="btn btn-success btn-xs" id="btn_Pasien_kabur">
                                            <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                                            notif pasien kabur</button> -->

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs border-bottom border-danger" role="tablist">
                                            <li role="presentation" class="active"><a class="" href="#breakdown"
                                                    aria-controls="breakdown" role="tab" data-toggle="tab">Total
                                                    Pembayaran</a></li>
                                            <li role="presentation" class=""><a class="" href="#rekapbiaya"
                                                    aria-controls="rekapbiaya" role="tab" data-toggle="tab">Rekap
                                                    Biaya</a></li>
                                            <li role="presentation"><a class="" href="#rincianbiaya"
                                                    aria-controls="rincianbiaya" role="tab" data-toggle="tab">Rincian
                                                    Biaya</a></li>
                                            <li role="presentation"><a class="" href="#riwayatpayment"
                                                    aria-controls="riwayatpayment" role="tab" data-toggle="tab">Riwayat
                                                    Pembayaran</a></li>
                                            <li role="presentation"><a class="" href="#riwayathutang"
                                                    aria-controls="riwayathutang" role="tab" data-toggle="tab">Detail
                                                    Hutang</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content bg-white p-15">
                                            <div role="tabpanel" class="tab-pane active" id="breakdown">
                                                <?php include("section/table/totalpembayaran.php"); ?>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="rekapbiaya">
                                                <?php include("section/table/rekapbiaya.php"); ?>
                                            </div>
                                            <!--Tab 2 asassassas-->
                                            <div role="tabpanel" class="tab-pane" id="rincianbiaya">
                                                <?php include("section/table/rincianbiaya.php"); ?>
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
                                                <?php include("section/table/riwayatpembayaran.php"); ?>
                                            </div>
                                            <!--Tab 4-->
                                            <div role="tabpanel" class="tab-pane" id="riwayathutang">
                                                <?php include("section/table/riwayathutang.php"); ?>
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
                                                <div class="col-sm-2">
                                                    <button class="btn btn-warning  btn-rounded " id="btn_periode"
                                                        name="btn_periode">
                                                        <span class="glyphicon glyphicon-calendar"
                                                            aria-hidden="true"></span></button>
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
                <!-- <button type="button" class="btn btn-primary btn-wide" data-toggle=' modal'
                                            id="btn_rincian_biaya">
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

<?php include("section/modalall.php"); ?>
<?php include("section/modalclosing.php"); ?>
<?php include("section/modalpembayaran.php"); ?>
<?php include("section/modaltariftindakan.php"); ?>
<?php include("section/modalpilihjenistindakan.php"); ?>
<?php include("section/modalprint_rincian_modal.php"); ?>
<?php include("section/modalaprovefarmasi.php"); ?>
<?php include("section/modalapprovelabo.php"); ?>
<?php include("section/modalapproveRad.php"); ?>
<?php include("section/modalapproveBDRS.php"); ?>
<?php include("section/modalpasienKabur.php"); ?>
<?php include("section/modaldetailkomponen.php"); ?>
<?php include("section/modaledittarif.php"); ?>


<!--#END Modal closing ------------------------>
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/billing/input/Billing_View.js"></script>