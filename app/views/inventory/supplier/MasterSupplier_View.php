<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <p class="sub-title">Silahkan Input Transaksi Supplier.</p>
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
                                <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Supplier <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="Nama" placeholder="Masukan Nama Supplier" autocomplete="off" id="Nama" maxlength="25">
                                    </div>
                                </div>
                                <div class="form-group gut">

                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nama CP Awal <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="Masukan Nama Awal Contact Person" name="NamaCPAwal" autocomplete="off" id="NamaCPAwal" maxlength="25">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nama CP Akir<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NamaCPAkhir" placeholder="Masukan Nama Akhir Contact Person" autocomplete="off" id="NamaCPAkhir" maxlength="25">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Email<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="Email" placeholder="Masukan E-mail" autocomplete="off" id="Email">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID Pabrik<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="IdPabrik" id="IdPabrik" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label">Tlp Kantor<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="TlpnKantor" placeholder="Masukan Tlp Kantor" autocomplete="off" id="TlpnKantor" maxlength="25">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No HP<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NoHP" placeholder="Masukan No. Hp" autocomplete="off" id="NoHP" maxlength="25">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No Fax<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="FaxTlp" placeholder="Masukan No. Fax" autocomplete="off" id="FaxTlp" maxlength="25">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Kota<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="Kota" placeholder="Masukan Kota" autocomplete="off" id="Kota" maxlength="25">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Status<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select name="Status" id="Status" class="form-control">
                                            <option value="">-- PILIH STATUS --</option>
                                            <option value="1">AKTIF</option>
                                            <option value="0">NON AKTIF</option>
                                        </select>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Provinsi<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="Provinsi" placeholder="Masukan Provinsi" autocomplete="off" id="Provinsi" maxlength="25">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <textarea rows="2" class="form-control" id="Alamat" autocomplete="off" name="Alamat" style="resize: none"></textarea>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Kode Pos<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="KodePos" placeholder="Masukan Kodepos" autocomplete="off" id="KodePos" maxlength="25">
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Bank<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <input type="text" class="form-control" name="NamaBank" placeholder="Masukan Nama Bank" autocomplete="off" id="NamaBank">
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No. Rekening<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" name="NoRekening" placeholder="Masukan No. Rekening" autocomplete="off" id="NoRekening">
                                    </div>
                                </div>

                                <div class="form-group gut">
                                <label for=" inputEmail3" class="col-sm-2 control-label"> Lead Time<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="LeadTime" autocomplete="off" id="LeadTime" >
                                    </div>
                                    <div class="col-sm-1">
                                    <label for=" inputEmail3" class="col-sm-1 control-label"> Hari</label>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Lama Jatuh Tempo<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" name="JatuhTempo" autocomplete="off" id="JatuhTempo" >
                                    </div>
                                    <div class="col-sm-1">
                                    <label for=" inputEmail3" class="col-sm-1 control-label"> Hari</label>
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-left:1em;float:left;">
                                    <a class="btn btn-primary waves-effect" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</a>
                                    <a class="btn btn-warning" id="btn_batal" name="btn_batal" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</a>
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
<script src="<?= BASEURL; ?>/js/App/Inventory/supplier/MasterSupplierEntri.js"></script>
<script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>