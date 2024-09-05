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
                                <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus
                                        diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs border-bottom border-primary">
                                <li class="active"><a data-toggle="tab" href="#generalinfo">General Info</a></li>
                                <li><a data-toggle="tab" href="#layanan">Layanan</a></li>
                                <li><a data-toggle="tab" href="#histori">Histori</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content bg-white p-15">
                                <div id="generalinfo" class="tab-pane fade in active">
                                    <div class="panel-body">
                                        <form class="form-horizontal" id="form_cuti">
                                            <input type="hidden" class="form-control" name="kd_instalasi"
                                                id="kd_instalasi" value="<?= $data['kd_instalasi'] ?>" readonly>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup
                                                        class="color-danger">*</sup></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="IdAuto" id="IdAuto"
                                                        value="<?= $data['id'] ?>" readonly>
                                                </div>
                                                <label for=" inputEmail3" class="col-sm-2 control-label"> COGS <sup
                                                        class="color-danger">*</sup></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="COGS" id="COGS">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> PACS </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="PACS" name="PACS">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> BHP </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="BHP" name="BHP">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Kontras
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Kontras" name="Kontras">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> DVD </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="DVD" name="DVD">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Proc_Code
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Proc_Code"
                                                        name="Proc_Code">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Modality_Code
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Modality_Code"
                                                        name="Modality_Code">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label">
                                                    Proc_Description <sup class="color-danger">* </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Proc_Description"
                                                        name="Proc_Description">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Modality_Code
                                                    <sup class="color-danger">* </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Modality_Code"
                                                        name="Modality_Code">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Proc_ActionCode
                                                    <sup class="color-danger">* </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Proc_ActionCode"
                                                        name="Proc_ActionCode">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Proc_Instance
                                                    <tr>_UID
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Proc_Instance_UID"
                                                        name="Proc_Instance_UID">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> TempReport1
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="TempReport1"
                                                        name="TempReport1">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> TempReport2
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="TempReport2"
                                                        name="TempReport2">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> TempReport3
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="TempReport3"
                                                        name="TempReport3">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> ShareDokter
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="ShareDokter"
                                                        name="ShareDokter">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> ShareRS
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="ShareRS" name="ShareRS">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Position
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="Position"
                                                        name="Position">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> customer_type
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="customer_type"
                                                        name="customer_type">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Status <sup
                                                        class="color-danger">*</sup></label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" id="discontinue" name="discontinue">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="0">Aktif</option>
                                                        <option value="1">Tidak Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <label for=" inputEmail3" class="col-sm-2 control-label"> Pacs Order <sup class="color-danger">*</sup></label>
                                                <div class="col-sm-4">
                                                    <select class="form-control js-example-basic-single" id="PacsOrder" name="PacsOrder">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="1">Ya</option>
                                                        <option value="0">Tidak</option>
                                                    </select>
                                                </div> -->

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-2 control-label"> Kode PDP <sup
                                                        class="color-danger">*</sup></label>
                                                <div class="col-sm-4">
                                                    <select name="KodePDP" id="KodePDP" class="form-control"
                                                        style="width:100%">
                                                    </select>
                                                </div>

                                                <label for=" inputEmail3" class="col-sm-2 control-label"> Kode Jasa <sup
                                                        class="color-danger">*</sup></label>
                                                <div class="col-sm-4">
                                                    <select name="KodeJasa" id="KodeJasa" class="form-control"
                                                        style="width:100%">
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label"> Paket <sup class="color-danger">*</sup></label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="Paket" name="Paket">
                                                            <option value="">-- PILIH --</option>
                                                            <option value="1">Ya</option>
                                                            <option value="0">Tidak</option>
                                                        </select>
                                                    </div>
                                            </div> -->
                                    </div>
                                </div>

                                <div id="layanan" class="tab-pane fade">

                                    <div class="panel-body">

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Cari
                                                Layanan</label>
                                            <div class="col-sm-4">
                                                <select name="GrupPerawatan" id="GrupPerawatan" class="form-control"
                                                    style="width:100%">
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <button class="btn bg-black btn-animated btn-wide" id="btnSave"
                                                    name="btnSave"><span class="visible-content">Add</span><span
                                                        class="hidden-content"><i
                                                            class="fa fa-plus"></i></span></button>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="panel-body p-20">
                                            <div class="demo-table" style="overflow-x:auto;">
                                                <table id="datalayanan" class="display" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">ID
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Tarif
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Layanan
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

                                <div id="histori" class="tab-pane fade">

                                    <div class="panel-body">

                                        <table id="datahistori" class="display table table-striped table-bordered"
                                            cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size="1">ID TR Tarif
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Tgl Entry
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Tgl Berlaku
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Tgl Expired
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Group Tarif
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Nilai
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Kls ID
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Group Tarif 2
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">ID TR Tarif Paket
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                            </form>
                            <div class="panel-body">
                                <button id="btnCancel" name="btnCancel" onclick="MyBack()"
                                    class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                                <button class="btn bg-black btn-wide" id="btnreservasi" name="btnreservasi"><i
                                        class="fa fa-check"></i>Submit</button>
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
<script src="<?= BASEURL; ?>/js/App/Tarif/TarifRadiologi/MasterTarif_Radiologi_View.js"></script>