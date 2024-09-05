<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Form Entri Maintenance Aset.</p>
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
                                <!-- <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5> -->
                                <h5>Data Asset (<small><sup class="color-danger">*</sup> Harus diisi</small>)</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="IdAuto" id="IdAuto"
                                            value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-4 control-label"> Nama Asset <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NamaAsset"
                                            placeholder="Masukan Nama Asset" id="NamaAsset">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Kode Asset <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm" type="text" id="KodeAsset"
                                            placeholder="Kode Asset" name="KodeAsset">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-3 control-label"> Merk Asset <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" autocomplete="off" name="MerkAsset"
                                            placeholder="Merk Asset" id="MerkAsset">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Pembelian <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm" type="date" id="TglTransaksi"
                                            name="TglTransaksi">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-4 control-label"> Jenis Asset <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="JenisAsset" id="JenisAsset" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Serial Number <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="SerialNumberAsset"
                                            placeholder="Serial Number" name="SerialNumberAsset">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Anydesk <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" autocomplete="off" name="AnydeskAsset"
                                            placeholder="Anydesk" id="AnydeskAsset">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Unit Induk Asset <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="UnitIndukAsset" id="UnitIndukAsset" class="form-control">
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Ip Address <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" autocomplete="off" name="IpAddressAsset"
                                            placeholder="IP Address" id="IpAddressAsset">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Mac Address <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="MacAdressAsset"
                                            placeholder="Mac Address" name="MacAdressAsset">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Status Asset <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="StatusAsset" id="StatusAsset" class="form-control">
                                            <option value="1"> BAIK </option>
                                            <option value="2"> DALAM PERBAIKAN </option>
                                            <option value="3"> RUSAK </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">

                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tempat <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <!-- <input class="form-control input-sm" type="text" id="LantaiAsset" placeholder="Tempat Asset" name="LantaiAsset"> -->

                                        <select name="LantaiAsset" id="LantaiAsset" class="form-control">
                                            <option value=""> -- PILIH -- </option>
                                            <option value="0"> BASEMENT </option>
                                            <option value="1"> LT.1 </option>
                                            <option value="2"> LT.2 </option>
                                            <option value="3"> LT.3 </option>
                                            <option value="4"> LT.4 </option>
                                            <option value="5"> LT.5 </option>
                                            <option value="6"> LT.6 </option>
                                            <option value="7"> LT.7 </option>
                                            <option value="8"> LT.8 </option>
                                            <option value="9"> LT.9 </option>
                                            <option value="10"> LT.10 </option>
                                            <option value="11"> LT.11 </option>
                                            <option value="12"> LT.12 </option>
                                            <option value="13"> LT.13 </option>
                                            <option value="14"> LT.14 </option>
                                            <option value="15"> LT.15 </option>
                                            <option value="16"> LT.16 </option>
                                        </select>
                                    </div>
                                </div>

                            </form>

                            <div class="row col-sm-8">
                                <a class="btn btn-primary waves-effect" id="btnSave" name="btnSave"><span
                                        class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</a>
                                <a class="btn btn-warning" id="btn_batal" name="btn_batal" onclick="MyBack()"><i
                                        class="fa fa-home" aria-hidden="true"></i>Kembali</a>
                            </div>
                            <br>
                            <h3> HISTORY MAINTENANCE</h3>
                            <div class="panel-body p-20">
                                <div class="demo-table" style="overflow-x:auto;">
                                    <table id="examplex" class="display" width="100%">
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1">Tanggal
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Petugas
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Ram
                                                </th>
                                                <th align='center'>
                                                    <font size="1">cleaning
                                                </th>
                                                <th align='center'>
                                                    <font size="1">repair windows
                                                </th>
                                                <th align='center'>
                                                    <font size="1">instal aplikasi
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
<script src="<?= BASEURL; ?>/js/App/inventory/asset/assetentriy.js"></script>