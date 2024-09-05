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
                                <h5 class="underline mt-30">Transaksi <?= $data['judul'] ?>
                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_order">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Tagihan</label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="NoTagihan" id="NoTagihan"
                                            readonly>
                                        <input class="form-control input-sm" id="TempNoTrsTagihan"
                                            name="TempNoTrsTagihan" type="hidden" readonly
                                            placeholder="Ketik No. MR disini" class="containerX"
                                            placeholder="Ketik No. Trs">
                                    </div>
                                    <div class="col-sm-1">
                                        <button id="btnCariMrx" type="button" class="btn btn-primary btn-sm"><span
                                                class="glyphicon glyphicon glyphicon-search"
                                                id="btnCariMr"></span></button>
                                        <!-- <div class="btn-group" role="group" id="btnSadas">
                                            <a href="#myModal" data-toggle="modal"
                                                class="btn btn-danger btn-sm btn-rounded " id="btn_caridatamr">
                                                <span class="glyphicon glyphicon glyphicon-search"></span></a>
                                        </div> -->
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Surat Tagihan</label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="NoSuratTagihan"
                                            id="NoSuratTagihan">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Tagih</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="tgltagih" id="tgltagih">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Nominal Tagihan</label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="NominalTagihan"
                                            id="NominalTagihan" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="Periode" id="Periode">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">To</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" name="Periode2" id="Periode2">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Alamat</label>
                                    <div class="col-sm-3">
                                        <textarea class="form-control input-sm" id="alamattagih" name="alamattagih"
                                            rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Penjamin</label>
                                    <div class="col-sm-3">
                                        <select class="form-control js-example-basic-single" id="JenisPenjamin"
                                            name="JenisPenjamin">
                                            <option value=''></option>
                                            <option value='Asuransi'>Jaminan Asuransi</option>
                                            <option value='Perusahaan'>Jaminan Perusahaan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Pasien</label>
                                    <div class="col-sm-3">
                                        <select class="form-control js-example-basic-single" id="Fs_Code_Jenis_Reg"
                                            name="Fs_Code_Jenis_Reg">
                                            <option value=''></option>
                                            <option value='RJ'>Rawat Jalan</option>
                                            <option value='RI'>Rawat Inap</option>
                                            <option value='SA'>SALDO AWAL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Jaminan</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="kodejaminan"
                                            name="kodejaminan">
                                        </select>
                                        <input class="form-control input-sm " id="kodejaminantemp"
                                            name="kodejaminantemp" type="hidden">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control input-sm" id="ket" name="ket" rows="4"
                                            style="resize: none"></textarea>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-8 control-label"></label>
                                    <button type="button" class="btn btn-primary btn-rounded" id="btngen" name="btngen"
                                        onclick="BtnGennow()"><span aria-hidden="true"></span> Gen No</button>
                                    <button type="button" class="btn btn-success btn-rounded" id="btnnew" name="btnnew"
                                        onclick="BtnNewInput()"><span aria-hidden="true"></span> New</button>
                                    <button type="button" class="btn btn-primary btn-rounded" id="btnSimpan"
                                        name="btnSimpan"><span class="glyphicon glyphicon-floppy-disk"
                                            aria-hidden="true"></span> Simpan</button>
                                    <button type="button" class="btn btn-danger btn-rounded" id="btnbatal"
                                        name="btnbatal" href="#modal_alert_batalhdr" data-toggle='modal'>
                                        Batal</button>
                                    <button type="button" class="btn btn-warning btn-rounded" id="btn_kembali"
                                        name="btn_kembali" onclick="MyBack()"><i class="fa fa-home"
                                            aria-hidden="true"></i>Kembali</button>
                                </div>
                                <hr>
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5><i class="glyphicon glyphicon-tasks" aria-hidden="true"></i> List</h5>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="panel-body p-20">

                                        <div class="table-responsive demo-table" style="overflow-x:auto;">
                                            <table id="table-id2" class="display" width="100%">
                                                <!-- <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%"> -->
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size="1">Kode Piutang
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tanggal Piutang
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">No. Registrasi
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Nama Pasien
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Nilai
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Ket Reff
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tagihan
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Owlexa
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>

                                            </table>
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


</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->

<!-- Modal -->
<div class="modal fade" id="modalcariDatapasien" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Order Pelunasan Piutang
                    <!-- <button type="button"
                        class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> -->
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <!-- <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-3">
                            <input type="month" class="form-control" name="PeriodePencarian" id="PeriodeAwal">
                        </div> -->

                        <div class="col-sm-2">
                            <button type="button" id="btnSearchMrAktif" class="btn btn-danger btn-wide btn-rounded"><i
                                    class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                </div>

                <div class="panel-body p-20">
                    <div class="demo-table" style="overflow-x:auto;">
                        <table id="table-load-data-detilxx" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>No. Tagihan</th>
                                    <th>Tgl Tagihan</th>
                                    <th>Nama Jaminan</th>
                                    <th>No. Surat</th>
                                    <th>Nilai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i
                                class="fa fa-times"></i>Close</button>
                    </div>

                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="modal_alert_batalhdr" tabindex="-1" role="dialog" style="overflow-y: auto">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Pesan Konfirmasi </h4>
            </div>
            <div class="modal-body">
                <form id="frmBatalReg">
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
                    <button class="btn btn-danger" id="btnVoidTrsRegBatalHdr" name="btnVoidTrsRegBatalHdr">
                        TIDAK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Print ------------------------------------------------>
<div class="modal fade" id="modal_upload_document_owlexa" tabindex="-1" role="dialog" style="overflow-y: auto">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Upload Berkas ( Invoice ) </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data" id="formId">
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. Registrasi </label>
                        <div class="col-sm-5">
                            <input class="form-control input-sm" id="upldproviderTransactionNumber"
                                name="upldproviderTransactionNumber" type="text" placeholder="Ketik No. Registrasi"
                                class="containerX" readonly>
                        </div>

                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Berkas tagihan ? </label>
                        <div class="col-sm-5">
                            <select id="includeInvoice" name="includeInvoice" class="form-control input-sm">
                                <option value="true">YA</option>
                                <option value="false">TIDAK</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Pilih File </label>
                        <div class="col-sm-5">
                            <input type="file" name="file" id="file" class="pull-left">
                        </div>
                    </div>

            </div>

            <div class="card" style="width:45%;float:left;margin-left:1em;margin:10px">
                <button type="submit" name="btnUploads" id="btnUploads" class="btn btn-success btn-sm"> Upload File
                    to Owlexa System </button>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCheckStatusDocument" class="btn btn-primary">Check Status Document</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Print---------------------------->
<!-- Modal Print ------------------------------------------------>
<div class="modal fade" id="modal_sync_transaction_owlexa" tabindex="-1" role="dialog" style="overflow-y: auto">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Sync Transaction </h4>
            </div>
            <div class="modal-body">
                <form id="get_periode_arsip" method="post">
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Piutang Number </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="owlexa_kode_piutang" id="owlexa_kode_piutang"
                                placeholder="Please Entry Card Number" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">Provider Transaction Number </label>
                        <div class="col-sm-5">
                            <input class="form-control input-sm" id="owlexa_provider_transasction_number"
                                name="owlexa_provider_transasction_number" type="text"
                                placeholder="Ketik No. Registrasi" class="containerX" readonly>
                            <div id="error_NoMR"></div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Card Number </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="owlexa_cardnumber" id="owlexa_cardnumber"
                                placeholder="Please Entry Card Number">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Claim Number </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="owlexa_claimnumber" id="owlexa_claimnumber"
                                placeholder="Please Entry Claim Number">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Provider Amount </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="owlexa_provideramount"
                                id="owlexa_provideramount" readonly placeholder="Please Entry Provider Amount">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Owlexa Transaction Number </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="owlexa_owlexaTransactionNumber"
                                id="owlexa_owlexaTransactionNumber" readonly
                                placeholder="Please Entry Owlexa Transaction Number ">
                        </div>
                    </div>
            </div>

            <div class="card" style="width:45%;float:left;margin-left:1em;margin:10px">
                </form>


            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-warning" name="synctransaction" id="synctransaction"
                    value="Sync Transaction">
                <button id="btnFinalGenerate" class="btn btn-success">Final Transaction</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Print---------------------------->

<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/finance/orderpiutang.js"></script>