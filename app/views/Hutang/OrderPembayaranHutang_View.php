<div class="main-page">
    <!-- <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Menampilkan Data <?= $data['judul'] ?>.</p>
            </div>
        </div>
        <div class="row breadcrumb-div">
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="<?= BASEURL; ?>"><i class="fa fa-home"></i> Home</a></li>
                    <li class="active"><?= $data['judul'] ?></li>
                    <li class="active"><?= $data['judul_child'] ?></li>
                </ul>
            </div>
        </div>
    </div> -->

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
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Transaksi</label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="NoTransaksi" id="NoTransaksi"
                                            readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group" role="group" id="btnSadas">
                                            <button 
                                                class="btn btn-danger btn-sm btn-rounded" type="button" id="btn_caridatamr">
                                                <span class="glyphicon glyphicon glyphicon-search"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group gut"> 
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Trs</label>
                                    <div class="col-sm-3">
                                        <input type="datetime-local" class="form-control" 
                                            name="TglTransaksi" id="TglTransaksi">
                                    </div> 
                                </div>
                                <div class="form-group gut"> 
                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode Jatuh Tempo</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control"  name="Periode1" id="Periode1">
                                        <input type="text" readonly class="form-control"  name="TotalHutang" id="TotalHutang">
                                    </div> 
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control"  name="Periode2" id="Periode2"> 
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Supplier</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="NamaSupplier"
                                            name="NamaSupplier" onchange="DataHutangJatuhTempo()">
                                        </select>
                                    </div>
                                </div> 
                            </form>
                            <div class="panel-body p-20">
                            <form class="form-horizontal" id="form_table">
                                <div class="table-responsive demo-table" style="overflow-x:auto;">
                                    <table id="table-load-data" class="display" width="100%">
                                        <!-- <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%"> -->
                                        <thead>
                                            <tr>
                                             <th align="center"></th>
                                                <th align='center'>
                                                    <font size="1">Kode Hutang
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Tanggal Hutang
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Keterangan
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
                                            <!-- <th>
                                                <button type="button" title="Approve Yang Dipilih"
                                            class="btn btn-maroon btn-xs" id="cb_approveLaboall"
                                            name="cb_approveLaboall" onclick="btnCheckedBox(this)"><span
                                                class="glyphicon glyphicon-check"></span> All </button>
                                            </th>    -->
                                            <th colspan="4">TOTAL :</th> 
                                            <th><font size="2"><div id="grandtotalTxt">0</div></font></th> 
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-8 control-label"></label>
                                    <button type="button" class="btn btn-primary waves-effect" id="btnSimpan" name="btnSimpan" onclick="btnCheckedBox()" ><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                    <button type="button" class="btn btn-danger" id="btn_batal" name="btn_batal" ><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                    <button type="button" class="btn btn-warning" id="btn_kembali" name="btn_kembali" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Order Pelunasan Hutang<button type="button"
                        class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-3">
                            <input type="month" class="form-control"  name="PeriodePencarian"
                                id="PeriodeAwal">
                        </div>
                        
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
                                    <th>Kode Transaksi</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Nama Rekanan</th>
                                    <th>User</th>
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

</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/finance/orderhutang.js"></script>