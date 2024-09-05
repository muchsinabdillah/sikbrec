<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Silahkan Input Transaksi Disini.</p>
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
    <!-- /.container-fluid -->

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>Input <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- Tab panes -->
                            <div class="tab-content bg-white p-15">
                                <div id="generalinfo" class="tab-pane fade in active">
                                    <div class="panel-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                            <li role="presentation" class="active"><a class="" href="#datadetil" aria-controls="datadetil" role="tab" data-toggle="tab">Data Barang</a></li>
                                            <li role="presentation"><a class="" href="#databrgdetil" aria-controls="databrgdetil" role="tab" data-toggle="tab">Data Barang Detil</a></li>
                                            <li role="presentation"><a class="" href="#HistoryHarga" aria-controls="HistoryHarga" role="tab" data-toggle="tab">History harga</a></li>
                                            <li role="presentation"><a class="" href="#Margin" aria-controls="Margin" role="tab" data-toggle="tab">Margin</a></li>
                                            <li role="presentation"><a class="" href="#Supplier" aria-controls="Supplier" role="tab" data-toggle="tab">Supplier</a></li>
                                            <li role="presentation"><a class="" href="#Formularium" aria-controls="Formularium" role="tab" data-toggle="tab">Formularium</a></li>
                                            <li role="presentation"><a class="" href="#BarangSatuan" aria-controls="BarangSatuan" role="tab" data-toggle="tab">Konversi Satuan</a></li>

                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content bg-white p-15">
                                            <div role="tabpanel" class="tab-pane active" id="datadetil">
                                                <form class="form-horizontal" id="form_hdr">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> ID </label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="ID" name="ID" value="<?= $data['id'] ?>" readonly>
                                                        </div>

                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Product Code</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="Product_Code" name="Product_Code">
                                                        </div>
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Barcode Code</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="Barcode_Code" name="Barcode_Code">
                                                        </div>

                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Product</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="Nama_Product" name="Nama_Product">
                                                        </div>
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Alias</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="Nama_Alias" name="Nama_Alias">
                                                        </div>

                                                        <label for="inputEmail3" class="col-sm-2 control-label">Aktif</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" style="width: 100%;" id="Discontinue" name="Discontinue">
                                                                <option value="">-- PILIH --</option>
                                                                <option value="0">YA</option>
                                                                <option value="1">TIDAK</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Kelompok Barang</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" style="width: 100%;" id="KelompokBarang" name="KelompokBarang">
                                                            </select>
                                                        </div>

                                                        <label for="inputEmail3" class="col-sm-2 control-label">Jenis Barang</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" style="width: 100%;" id="Jenis_Barang" name="Jenis_Barang">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Golongan Barang</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" style="width: 100%;" id="Golongan_Obat" name="Golongan_Obat">
                                                            </select>
                                                        </div>

                                                        <label for="inputEmail3" class="col-sm-2 control-label">Group Barang</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" style="width: 100%;" id="Group_Barang" name="Group_Barang">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Satuan Beli</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" style="width: 100%;" id="Satuan_Beli" name="Satuan_Beli">
                                                            </select>
                                                        </div>

                                                        <label for="inputEmail3" class="col-sm-2 control-label">Satuan Jual</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" style="width: 100%;" id="Satuan_Jual" name="Satuan_Jual">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Konversi Satuan</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" style="width: 100%;" class="form-control" id="Konversi_Satuan" name="Konversi_Satuan">
                                                        </div>

                                                        <label for="inputEmail3" class="col-sm-2 control-label">Stok Minimum</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="Stok_Minimum" name="Stok_Minimum">
                                                        </div>
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Label Signa</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" style="width: 100%;" id="Label_Signa" name="Label_Signa">
                                                                <option value="">-- PILIH --</option>
                                                                <option value="OBAT DALAM">OBAT DALAM</option>
                                                                <option value="OBAT LUAR">OBAT LUAR</option>
                                                                <option value="INJEKSI">INJEKSI</option>
                                                                <option value="CAIRAN INF">CAIRAN INF</option>
                                                            </select>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label"> Kode PDP <sup class="color-danger">*</sup></label>
                                                        <div class="col-sm-4">
                                                            <select name="KodePDP" id="KodePDP" class="form-control" style="width:100%">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left:1em;float:left;">
                                                        <a class="btn btn-primary waves-effect" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</a>
                                                        <a class="btn btn-warning" id="btnBack" name="btnBack" onclick="MyBack()"><i class="fa fa-trash" aria-hidden="true"></i>
                                                            Kembali</a>
                                                    </div>
                                                </form>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="databrgdetil">
                                                <form class="form-horizontal" id="form_dtl">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control" id="Deskripsi" name="Deskripsi"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Komposisi</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control" id="Komposisi" name="Komposisi"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Indikasi</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control" id="Indikasi" name="Indikasi"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Dosis</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control" id="Dosis" name="Dosis"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Kontra Indikasi</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control" id="KontraIndikasi" name="KontraIndikasi"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Efek Samping</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control" id="EfekSamping" name="EfekSamping"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Peringatan</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control" id="Peringatan" name="Peringatan"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Kemasan</label>
                                                        <div class="col-sm-4">
                                                            <textarea class="form-control" id="Kemasan" name="Kemasan"></textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="HistoryHarga">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-maroon waves-effect" id="btnShowHistory" name="btnShowHistory" onclick="showHistoryHargaBeli();showHistoryHargaJual()"><span class="glyphicon glyphicon-eye" aria-hidden="true"></span> Tampilkan</button>
                                            </div>

                                                <h5 class="underline mt-30">Harga Beli</h5>
                                                <table id="tbl_hargabeli" width="100%" class="table table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">ID.
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No. DO
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tanggal
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nominal Harga Beli
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nominal Diskon
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nominal Hpp
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">User Create
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Status
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">User Batal
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                                <h5 class="underline mt-30">Harga Jual</h5>
                                                <table id="tbl_hargajual" width="100%" class="table table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                        <th align='center'>
                                                                <font size="1">ID.
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No. DO
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tanggal
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nominal Hna
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nominal Hna Min Diskon
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">User Create
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Start Date
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Expired Date
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Status
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">User Batal
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tgl Batal
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="Margin">
                                                <table id="tbl_hargajual" width="100%" class="table table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">No.
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No. DO
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tanggal
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Petugas
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Harga
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tgl Berlaku
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tgl ED
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="Supplier">
                                                <h5 class="underline mt-10">Entri Supplier</h5>
                                                <form class="form-horizontal" id="form_addsupplier">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Cari Supplier</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" style="width: 100%;" id="DataSupplier" name="DataSupplier">
                                                            </select>
                                                        </div>
                                                        <button type="button" class="btn btn-info waves-effect" id="btnAddSupplier" name="btnAddSupplier"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                                    </div>
                                                </form>
                                                <table id="tbl_supplier" width="100%" class="table mt-30 table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">No.
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">ID Supplier
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Supplier
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
                                            <div role="tabpanel" class="tab-pane" id="Formularium">
                                                <h5 class="underline mt-10">Entri Formularium</h5>
                                                <form class="form-horizontal" id="form_addformularium">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Cari Formularium</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control " style="width: 100%;" id="DataFormularium" name="DataFormularium">
                                                            </select>
                                                        </div>
                                                        <button type="button" class="btn btn-info waves-effect" id="btnAddFormularium" name="btnAddFormularium"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                                    </div>
                                                </form>
                                                <table id="tbl_formularium" width="100%" class="table mt-30 table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">No.
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">ID Formularium
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Formularium
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
                                            <div role="tabpanel" class="tab-pane" id="BarangSatuan">
                                                <h5 class="underline mt-10">Entri Satuan Konversi</h5>
                                                <form class="form-horizontal" id="form_addBarangSatuan"> 
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Satuan Beli</label>
                                                        <div class="col-sm-2">
                                                            <select class="form-control " style="width: 100%;" id="Konversi_SatuanBeli" name="Konversi_SatuanBeli">
                                                            </select>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label ml-2">Satuan Jual</label>
                                                        <div class="col-sm-2">
                                                            <select class="form-control " style="width: 100%;" id="Konversi_SatuanJual" name="Konversi_SatuanJual">
                                                            </select>
                                                        </div>
                                                        <label for="inputEmail3" class="col-sm-2 control-label ml-2">Nilai Konversi</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="Konversi_Nilai" name="Konversi_Nilai" >
                                                        </div>
                                                        <button type="button" class="btn btn-info waves-effect" id="btnAddBarangSatuan" name="btnAddBarangSatuan"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add</button>
                                                    </div>
                                                </form>
                                                <table id="tbl_BarangSatuan" width="100%" class="table mt-30 table-striped table-hover cell-border">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">No.
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Satuan Jual
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Satuan Beli
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nilai
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



                                    </div>
                                </div>
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
<script src="<?= BASEURL; ?>/js/App/inventory/Barang/MasterDataBarang_View.js"></script>