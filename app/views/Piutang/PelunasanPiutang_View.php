<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Menampilkan Data <?= $data['judul'] ?>.</p>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <div class="row breadcrumb-div">
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="<?= BASEURL; ?>"><i class="fa fa-home"></i> Home</a></li>
                    <li class="active"><?= $data['judul'] ?></li>
                    <li class="active"><?= $data['judul_child'] ?></li>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30">Transaksi <?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Pelunasan</label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="NoPelunasan" id="NoPelunasan">
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group" role="group" id="btnSadas">
                                            <button id="btnCariHL" type="button"
                                                class="btn btn-danger btn-sm btn-rounded"><span
                                                    class="glyphicon glyphicon glyphicon-search"
                                                    id="btnCariHL"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Order</label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="NoOrder" id="NoOrder">
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group" role="group" id="btnSadas">
                                            <button id="btnCariOrderHL" type="button"
                                                class="btn btn-danger btn-sm btn-rounded"><span
                                                    class="glyphicon glyphicon glyphicon-search"
                                                    id="btnCariOrderHL"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Transaksi</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="TglTransaksi" id="TglTransaksi">
                                    </div>
                                </div>


                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Pasien</label>
                                    <div class="col-sm-2">
                                        <select class="form-control js-example-basic-single" id="jenispasien"
                                            name="jenispasien">
                                            <option value=''></option>
                                            <option value='RJ'>Rawat Jalan</option>
                                            <option value='RI'>Rawat Inap</option>
                                            <option value='SA'>SALDO AWAL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Jaminan</label>
                                    <div class="col-sm-2">
                                        <select class="form-control js-example-basic-single" id="jaminan"
                                            name="jaminan">
                                            <option value=''></option>
                                            <option value='Asuransi'>Jaminan Asuransi</option>
                                            <option value='Perusahaan'>Jaminan Perusahaan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Penjamin</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="NamaPenjamin" name="NamaPenjamin"
                                            type="text">
                                        <input class="form-control input-sm " id="kdrekanan" name="kdrekanan"
                                            type="hidden">
                                    </div>
                                </div>
                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Status Transaksi</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="status" id="status">
                                        <input class="form-control input-sm " id="Rekeningx" readonly name="Rekeningx"
                                            type="hidden">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Rekening Pelunasan</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="RekeningPelunasan"
                                            name="RekeningPelunasan" onclick="grupjaminanselect2active(this)">
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h5 class="underline mt-30">Penerima Berkas Tagihan</h5>
                                    </div>
                                </div>
                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Tgl Berkas Diterima</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="tglberkas" id="tglberkas">
                                    </div>
                                </div>
                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Penerima Berkas</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="namapenerimaberkas"
                                            id="namapenerimaberkas">
                                    </div>
                                </div>
                                <div class="btn-group" role="group" id="btnSadas">
                                    <a type="button" class="btn btn-primary btn-rounded " id="btnNewOrder"
                                        name="btnNewOrder"><span class="visible-content">New Transaksi</span></a>
                                </div>
                                <label for="inputEmail3" class="col-sm-8 control-label">
                                </label>
                                <a type="button" class="btn btn-success btn-rounded " id="btnSimpanOrder"
                                    name="btnSimpanOrder">
                                    <span class="glyphicon glyphicon-save">Simpan</span>
                                </a>
                                <a type="button" class="btn btn-danger btn-rounded " id="btnbatal" name="btnbatal"><span
                                        class="glyphicon glyphicon-remove">Batal</span></a>
                                <a type="button" class="btn btn-warning btn-rounded " id="btnLoadInformation"
                                    name="btnLoadInformation"><span class="glyphicon glyphicon-repeat">Close</span></a>
                                <hr>
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5><i class="glyphicon glyphicon-tasks" aria-hidden="true"></i> List Data
                                                Pelunasan
                                                Piutang</h5>
                                            </span>
                                        </div>
                                    </div>
                                    <br>
                                    <a type="button" class="btn btn-success btn-rounded " id="btnNewLunasAll"
                                        name="btnNewLunasAll">
                                        <span class="visible-content">Lunas All</span>
                                    </a>
                                    <div class="panel-body p-20">
                                        <div class="demo-table" style="overflow-x:auto;">
                                            <table id="table-load-data" class="display" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size="1">Kode Order
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kode hutang
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Keterangan
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Nilai Sisa
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Nilai Pelunasan
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>TOTAL :</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>

                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-4 col-form-label">SubTotal
                                                Pelunasan</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" id="PL_Subtotal" name="PL_Subtotal"
                                                    type="text" readonly class="containerX" value="0"
                                                    placeholder="No. Pelunasan">
                                                <div id="error_NoMR"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-4 col-form-label">Discount</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" id="PL_Discount" name="PL_Discount"
                                                    type="number" class="containerX" placeholder="Discount" value="0"
                                                    onkeyup="calculatedisct();">
                                                <div id="error_NoMR"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-4 col-form-label">Biaya
                                                Transfer</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" id="PL_BiayaLain"
                                                    name="PL_BiayaLain" type="number" class="containerX"
                                                    placeholder="Biaya Transfer" value="0"
                                                    onkeyup="calculatebiayatransfer();">
                                                <div id="error_NoMR"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-4 col-form-label">Materai</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" id="PL_Materai" name="PL_Materai"
                                                    type="number" class="containerX" placeholder="Materai" value="0"
                                                    onkeyup="calculatematerai();">
                                                <div id="error_NoMR"></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:3px;">
                                            <label for="namapasien" class="col-sm-4 col-form-label">Grandtotal
                                                Pelunasan</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm" id="PL_Grandtotal"
                                                    name="PL_Grandtotal" type="number" value="0" class="containerX"
                                                    readonly placeholder="Grandtotal Pelunasan">
                                                <div id="error_NoMR" value="0"></div>
                                            </div>
                                        </div>


                                    </div>



                            </form>

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
<div class="modal fade" id="Modal_verifikasi" tabindex="-1" role="dialog" style="overflow-y: auto">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Masukan Nilai Pelunasan </h4>
            </div>
            <form id="frmKartuRSYarsi">
                <div class="modal-body">
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. ID</label>

                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="JM_ID" readonly name="JM_ID">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Keterangan </label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="JM_Keterangan" readonly name="JM_Keterangan"
                                type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">Nilai Sisa</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="JM_NIlaiSisa" readonly
                                name="JM_NIlaiSisa">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">Nilai Bayar</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="number" id="JM_NilaiVerif" name="JM_NilaiVerif">
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">
                    <button class="btn btn-primary" id="btnSavePoli2" name="btnSavePoli2"> Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Order Pelunasan Piutang<button type="button"
                        class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-3">
                            <input type="month" class="form-control" name="PeriodePencarian" id="PeriodePencarian">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="caridatapoliPL" class="btn btn-danger btn-wide btn-rounded"><i
                                    class="fa fa-search"></i>Load Data</button>
                        </div>
                    </div>
                </div>

                <div class="panel-body p-20">
                    <div class="demo-table" style="overflow-x:auto;">
                        <table id="table-data-piutang" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Nama User</th>
                                    <th>Jenis Reg</th>
                                    <th>Status Transaksi</th>
                                    <th>Nilai Bayar</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                        data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Order Pelunasan Piutang<button type="button"
                        class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-3">
                            <input type="month" class="form-control" name="PeriodePencarian" id="PeriodePencarian">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="caridatapoli" class="btn btn-danger btn-wide btn-rounded"><i
                                    class="fa fa-search"></i>Load Data</button>
                        </div>
                    </div>
                </div>

                <div class="panel-body p-20">
                    <div class="demo-table" style="overflow-x:auto;">
                        <table id="table-data-piutang-1" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Nama Asuransi</th>
                                    <th>No. Surat</th>
                                    <th>Nilai Tagihan</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                        data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="modal_alert_batalhdr" tabindex="-1" role="dialog" style="overflow-y: auto"
    data-backdrop="static">

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
                            <input class="form-control input-sm " id="noregbatalHdr" readonly name="noregbatalHdr"
                                type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-2 col-form-label">Alasan : </label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="alasanbatalHdr" name="alasanbatalHdr"
                                rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">

                    <button class="btn btn-primary" id="btnVoidTrsRegHdr" name="btnVoidTrsRegHdr"> YA </button>
                    <button class="btn btn-danger" data-dismiss="modal">
                        TIDAK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->

</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/finance/pelunasanPiutang.js"></script>