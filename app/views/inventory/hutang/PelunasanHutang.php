<div class="main-page">

    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Menampilkan Data <?= $data['judul'] ?>.</p>
            </div>
            <!-- /.col-md-6 -->
        </div>
    </div>


    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5> Data <?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Pelunasan <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NoPelunasan" id="NoPelunasan"
                                            value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="btn-group" role="group" id="btnSadas">
                                            <button type="button" class="btn btn-danger btn-sm btn-rounded "
                                                id="btnSearching" name="btnSearching">
                                                <span class="glyphicon glyphicon glyphicon-search"></span>
                                                Search</button>
                                        </div>
                                    </div><label for="inputEmail3" class="col-sm-2 control-label"> No Order <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="NoOrder" id="NoOrder"
                                            value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="btn-group" role="group" id="btnSadas">
                                            <button type="button" class="btn btn-danger btn-sm btn-rounded "
                                                id="btnSearching" name="btnSearching">
                                                <span class="glyphicon glyphicon glyphicon-search"></span>
                                                Search</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Transaksi
                                        :</label>
                                    <div class="col-sm-4">
                                        <input type="datetime-local" class="form-control" name="Tgl_Transaksi"
                                            id="Tgl_Transaksi" placeholder="Masukkan Tanggal Transaksi">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Supplier :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="Supplier2" id="Supplier2"
                                            readonly>
                                        <input type="text" class="form-control" name="Supplier2" id="Supplier2"
                                            readonly>
                                    </div>
                                </div>
                                <!-- <button type="button" class="btn btn-info  waves-effect" id="btnNewTransaksi"
                                    name="btnNewTransaksi" disabled><span class="glyphicon glyphicon-plus"
                                        aria-hidden="true"></span> New Transaction</button> -->
                                <div class="row col-sm-8">
                                    <button type="button" class="btn btn-primary waves-effect" id="btnSimpan"
                                        name="btnSimpan" disabled><span class="glyphicon glyphicon-plus"
                                            aria-hidden="true"></span> New Transaksi</button>
                                    <button type="button" class="btn btn-success waves-effect" id="btnSimpan"
                                        name="btnSimpan" disabled><span class="glyphicon glyphicon-floppy-disk"
                                            aria-hidden="true"></span> Simpan</button>
                                    <button type="button" class="btn btn-danger" id="btn_batal" name="btn_batal"
                                        disabled><i class="fa fa-trash" aria-hidden="true"></i>Hapus</button>
                                    <button type="button" class="btn btn-warning" id="btn_kembali" name="btn_kembali"
                                        onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</button>
                                </div>
                            </form>

                            <hr>

                            <form id="user_form">
                                <div class="table-responsive" style="margin-top: 70px;">
                                    <table id="datatable_prdetail" class="display" width="100%">
                                        <div class="panel-title">
                                            <h5> Data Barang</h5>
                                        </div>
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size='1'>Kode Order</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Kode Hutang</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Keterangan</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Nilai Sisa</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Nilai Pelunasan</font>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tbody id="user_data">
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <th colspan="5">
                                                    <font size="1">GRANDTOTAL :</font>
                                                </th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                            </form>
                        </div>
                        <!-- Modal Approve ------------------------------------------------>
                        <div class="modal fade" id="btnSearching_modal" tabindex="-1" role="dialog">

                            <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> Cari Data Order Pelunasan Hutang</h4>
                                    </div>

                                    <div class="panel-body">
                                        <form class="form-horizontal" id="form_cuti">
                                            <div class="alert alert-success alert-dismissible">
                                                <strong>Info !</strong> Silahkan Cari Data Order Pelunasan Hutang
                                                disini.
                                            </div>
                                            <div class="form-group gut">

                                                <label for="inputEmail3" class="col-sm-1 control-label">Periode:</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" name="tglawal_pr"
                                                        id="tglawal_pr" placeholder="Tanggal dari"
                                                        value="<?= Utils::datenowcreateNotFull() ?>">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-1 control-label">s / d</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" name="tglakhir_pr"
                                                        id="tglakhir_pr" placeholder="Tanggal Sampai"
                                                        value="<?= Utils::datenowcreateNotFull() ?>">
                                                </div>
                                                <a class="btn btn-danger btn-sm btn-rounded " id="btnSearching"
                                                    name="btnSearching" onclick="ShowApprovedPRbyDate()">
                                                    <span class="glyphicon glyphicon glyphicon-search"></span> Cari</a>
                                                </thead>
                                        </form>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="datatable_pr" class="display" width="100%">
                                            <div class="panel-title">
                                                <h5> List Data</h5>
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size='1'>Kode Transaksi</font>
                                                    </th>
                                                    <th align='center'>
                                                        <font size='1'>Tgl Transaksi</font>
                                                    </th>
                                                    <th align='center'>
                                                        <font size='1'>Nama Rekanan</font>
                                                    </th>
                                                    <th align='center'>
                                                        <font size='1'>User</font>
                                                    </th>
                                                    <!-- <th align='center'>
                                                        <font size='1'>Jenis Request</font>
                                                    </th> -->
                                                    <th align='center'>
                                                        <font size='1'>Action</font>
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe"
                                            name="CloseMe">Close</a>
                                    </div>

                                    <!--#END Modal Approve--------------------------------------------->
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.section -->
                </div>

                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->
        <!-- ========== COMMON JS FILES ========== -->
        <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
        <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
        <script src="<?= BASEURL; ?>/js/App/inventory/purchaseorder/input/purchaseOrderInput_V06.js"></script>