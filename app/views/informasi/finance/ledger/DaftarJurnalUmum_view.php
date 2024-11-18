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
        font-size: 12px;
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
                            <form class="form-horizontal" id="form_hdr">
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">No. Jurnal</label>
                                    <div class="col-sm-3">
                                        <input type="text" value="<?= $data['id'] ?>" class="form-control" readonly name="Nojurnal" id="Nojurnal" placeholder="Masukkan No.Jurnal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Rekening</label>
                                    <div class="col-sm-3">
                                        <select name="REKENING" id="REKENING" class="form-control" onchange="PassData(this.value)">
                                        </select>
                                        <input class="form-control input-sm containerX" id="koderekening" name="koderekening" type="hidden" placeholder="Ketik Nama Akun">
                                        <input class="form-control input-sm containerX" id="FB_LEDGER_H" name="FB_LEDGER_H" type="hidden" placeholder="Ketik Nama Akun">
                                        <input class="form-control input-sm containerX" id="FB_LEDGER_P" name="FB_LEDGER_P" type="hidden" placeholder="Ketik Nama Akun">

                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Jurnal</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="tgljurnal" id="tgljurnal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">D/K</label>
                                    <div class="col-sm-3">
                                        <select name="DebetK" id="DebetK" class="form-control">
                                            <option value=''> </option>
                                            <option value='DEBET'> Debet </option>
                                            <option value='KREDIT'> Kredit </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan Jurnal</label>
                                    <div class="col-sm-3">
                                        <textarea type="text" class="form-control" name="Keterangan" id="Keterangan" placeholder="Isi Keterangan Jurnal"></textarea>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Unit</label>
                                    <div class="col-sm-3">
                                        <select name="NamaUnit" id="NamaUnit" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-3"> 
                                        <button type="button" class="btn btn-success btn-animated btn-wide " id="btnNewjurnal" name="btnNewjurnal"><span class="visible-content">New Jurnal</span><span class="hidden-content"></span></button>
                                    </div> 
                                </div>
                                <hr>    <br>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Masukan Nominal Jurnal</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NominalJurnal" id="NominalJurnal" placeholder="Ketik Nominal Jurnal">
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="dokter" class="col-sm-1 col-form-label"></label>
                                            <div class="col-sm-12">
                                                <input class="form-control input-sm " id="PassLedgerTgl" name="PassLedgerTgl" type="hidden" placeholder="Ketik  Tgl ">
                                                <input class="form-control input-sm " id="PassLedgerKode" name="PassLedgerKode" type="hidden" placeholder="Ketik Kode">
                                                <input class="form-control input-sm " id="PassTipePasien" name="PassTipePasien" type="hidden" placeholder="Ketik Kode">
                                                <input class="form-control input-sm " id="PassLedgerKet" name="PassLedgerKet" type="hidden" placeholder="Ketik Ket Ledger">
                                                <input class="form-control input-sm " id="PassjenisAsuransi" name="PassjenisAsuransi" type="hidden" placeholder="Ketik Ket Ledger">
                                                <input class="form-control input-sm " id="PassKodeFaktur" name="PassKodeFaktur" type="hidden" placeholder="Ketik Ket Ledger">
                                                <input class="form-control input-sm " id="PassLedgerPNoPO" name="PassLedgerPNoPO" type="hidden" placeholder="Ketik Ket Ledger">
                                                <input class="form-control input-sm " id="PassLedgerPNoRekening" name="PassLedgerPNoRekening" type="hidden" placeholder="Ketik Ket Ledger">
                                                <input class="form-control input-sm " id="PassLedgerPNanamBank" name="PassLedgerPNanamBank" type="hidden" placeholder="Ketik Ket Ledger">
                                            </div>
                                        </div>
                                    </div> 
                                </div>

                           
                                <div class="table-responsive" style="margin-top: 70px;">
                                    <table id="examplex" class="display" width="100%">
                                        <thead>
                                            <tr>
                                                <th align='center'>NO </th>
                                                <th align='center'>Kode Rekening</th>
                                                <th align='center'>Nama Rekening</th>
                                                <th align='center'>Debet</th>
                                                <th align='center'>Kredit</th>
                                                <th align='center'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>
                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th>Total Qty :</th>
                                                <th></th>
                                                <th></th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                            <button type="button" class="btn btn-primary waves-effect" id="savetrs" name="savetrs">Simpan</button>
                                <button type="button" class="btn btn-danger" id="btnbatal" name="btnbatal">
                                    Batal</button>
                        </div>
                        
                    </div>
                </div>
                <!-- /.col-md-12 -->
                <div class="modal fade" id="modal_alert_batalhdr" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static">

                    <div class="modal-dialog modal-md">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Pesan Konfirmasi </h4>
                            </div>
                            <div class="modal-body">
                                <form id="frmBatalReg2">
                                    <p>Apakah Anda Yakin Ingin Batalkan Jurnal ini ?</p>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="doktexr" class="col-sm-2 col-form-label">ID: </label>
                                        <div class="col-sm-8">
                                            <input class="form-control input-sm " id="noregbatalHdr" readonly name="noregbatalHdr" type="text">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">Alasan : </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="alasanbatalHdr" name="alasanbatalHdr" rows="3"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group row" style="margin-right:1em;float:right;">

                                    <button class="btn btn-primary" id="btnVoidTrsRegHdr" name="btnVoidTrsRegHdr"> YA </button>
                                    <button class="btn btn-danger" id="btnVoidTrsRegBatalHdr" name="btnVoidTrsRegBatalHdr">
                                        TIDAK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--#END Modal Untuk Notif Resep---------------------------->
                <!-- Modal Untuk Notif Resep ------------------------------------------------>
                <div class="modal fade" id="modal_alert_piutangh" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static">

                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h4 class="modal-title"> Detail Data Piutang </h4>
                            </div>
                            <div class="modal-body ">
                                <form id="frmBatalReg4">
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="doktexr" class="col-sm-2 col-form-label">Tipe Piutang : </label>
                                        <div class="col-sm-8">
                                            <select name="tipePasien" id="tipePasien" class="form-control js-example-basic-single" onchange="getNamaJaminan();">
                                                <option value=''></option>
                                                <option value='RAJAL'>Rawat Jalan</option>
                                                <option value='RANAP'>Rawat Inap</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="doktexr" class="col-sm-2 col-form-label">Group Jaminan : </label>
                                        <div class="col-sm-8">
                                            <select name="tipepembayaran" id="tipepembayaran" class="form-control js-example-basic-single" onchange="getjaminannama();">
                                                <option value=''></option>
                                                <option value='2'>Piutang Asuransi</option>
                                                <option value='5'>Piutang Non Asuransi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="doktexr" class="col-sm-2 col-form-label">Nama Rekanan : </label>
                                        <div class="col-sm-8">
                                            <select name="LedgerPRekanan" id="LedgerPRekanan" class="form-control js-example-basic-single"></select>

                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">Tgl Tempo : </label>
                                        <div class="col-sm-8">
                                            <input class="form-control input-sm " id="LedgerPTgl" name="LedgerPTgl" type="date" placeholder="Ketik Nama Pasien">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">Keterangan : </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="LedgerPKet" name="LedgerPKet" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">Nominal : </label>
                                        <div class="col-sm-2">
                                            <input class="form-control input-sm " id="LedgerPNominal" name="LedgerPNominal" type="number" placeholder="Ketik Nama Pasien">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group row" style="margin-right:1em;float:right;">

                                    <button class="btn btn-primary" id="btnpiutanghS" name="btnpiutanghS"> Add </button>
                                    <button class="btn btn-danger" id="btnpiutanghN" name="btnpiutanghN" data-dismiss="modal">
                                        Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--#END Modal Untuk Notif Resep---------------------------->
                <!-- Modal Untuk Notif Resep ------------------------------------------------>
                <div class="modal fade" id="modal_alert_hutang" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static">

                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h4 class="modal-title"> Detail Data Hutang </h4>
                            </div>
                            <div class="modal-body ">
                                <form id="frmBatalReg5">
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="doktexr" class="col-sm-2 col-form-label">Nama Rekanan : </label>
                                        <div class="col-sm-10">
                                            <select name="LedgerPRekanan2" id="LedgerPRekanan2" class="form-control js-example-basic-single"></select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">Tgl Tempo : </label>
                                        <div class="col-sm-8">
                                            <input class="form-control input-sm " id="LedgerPTgl2" name="LedgerPTgl2" type="date" placeholder="Ketik Nama Pasien">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">Keterangan : </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="LedgerPKet2" name="LedgerPKet2" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">No. Faktur : </label>
                                        <div class="col-sm-6">
                                            <input class="form-control input-sm " id="LedgerPNoFaktur2" name="LedgerPNoFaktur2" type="text" placeholder="Ketik No. Faktur">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">No. PO : </label>
                                        <div class="col-sm-6">
                                            <input class="form-control input-sm " id="LedgerPNoPO" name="LedgerPNoPO" type="text" placeholder="Ketik No. PO">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">No. Rekening : </label>
                                        <div class="col-sm-6">
                                            <input class="form-control input-sm " id="LedgerPNoRekening" name="LedgerPNoRekening" type="text" placeholder="Ketik >No. Rekening">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">Nama Bank : </label>
                                        <div class="col-sm-6">
                                            <input class="form-control input-sm " id="LedgerPNanamBank" name="LedgerPNanamBank" type="text" placeholder="Ketik Nama Bank">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:3px;">
                                        <label for="dokter" class="col-sm-2 col-form-label">Nominal : </label>
                                        <div class="col-sm-6">
                                            <input class="form-control input-sm " id="LedgerPNominal2" name="LedgerPNominal2" type="number" placeholder="Ketik Nominal">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group row" style="margin-right:1em;float:right;">

                                    <button class="btn btn-primary" id="btnpiutanghH" name="btnpiutanghH"> Add </button>
                                    <button class="btn btn-danger" id="btnpiutanghN" name="btnpiutanghN" data-dismiss="modal">
                                        Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--#END Modal Untuk Notif Resep---------------------------->
                <!-- Modal Untuk Notif Resep ------------------------------------------------>
                <div class="modal fade" id="modal_alert_selesai" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static">

                    <div class="modal-dialog modal-md">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Pesan Konfirmasi </h4>
                            </div>
                            <div class="modal-body">
                                <form id="frmBatalReg">
                                    <p>Apakah Anda Yakin Ingin Simpan ini ?</p>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group row" style="margin-right:1em;float:right;">

                                    <button class="btn btn-primary" id="btnSelesai" name="btnSelesai"> YA </button>
                                    <button class="btn btn-danger" id="btnSelesaix" name="btnSelesaix" data-dismiss="modal">
                                        TIDAK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--#END Modal Untuk Notif Resep---------------------------->
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
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/informasi/finance/ledger/JurnalUmum_view.js"></script>