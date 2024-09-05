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

                            <!-- Tab panes -->
                            <div class="panel-body">
                                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data"
                                    id="formUploadManual">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> ID </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="iddata" name="iddata"
                                                value="<?= $data['idmrx'] ?>" readonly>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> NIK</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="nikPegawai" name="nikPegawai"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pegawai </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="NamaPegawai" name="NamaPegawai"
                                                readonly>
                                        </div>

                                        <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pegawai</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="JenisPegawai"
                                                name="JenisPegawai" readonly>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5>Data Pendidikan</h5>

                                    <div class="form-group">

                                        <label for="inputEmail3" class="col-sm-2 control-label"> ID </label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="iddatax" name="iddatax"
                                                value="<?= $data['idfile'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pendidikan
                                        </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="jenisPendidikan" name="jenisPendidikan">
                                                    <option value="">-- PILIH --</option>
                                                    <option value="2">  SD </option>
                                                    <option value="3">  SMP </option>
                                                    <option value="4">  SMA </option>
                                                    <option value="5">  SPK </option>
                                                    <option value="6">  SMU </option>
                                                    <option value="7">  SMA Kes </option>
                                                    <option value="8">  SMAK </option>
                                                    <option value="9">  D1 </option>
                                                    <option value="10"> D2 </option>
                                                    <option value="11"> D3 Kes </option>
                                                    <option value="12"> S1+NRS </option>
                                                    <option value="13"> D4 </option>
                                                    <option value="14"> S2 </option>
                                                    <option value="15"> S3 </option>
                                                    <option value="16"> D3 Non Kes </option>
                                                    <!-- <option value="17"> S1 Non Kes </option> -->
                                                    <option value="18"> S1 + Apoteker </option>
                                                    <option value="19"> S1 + Dokter </option>
                                                    <option value="20"> S1 </option>
                                                </select>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Inst. Pendidikan
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="tptInst" name="tptInst">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Tahun Lulus</label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" id="tglLulus" name="tglLulus">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Jurusan </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="jurusan" name="jurusan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Doc </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="jenisdoc" name="jenisdoc">
                                                <option value="">-- PILIH --</option>
                                                <option value="IJAZAH">IJAZAH</option>
                                            </select>
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> File </label>
                                        <div class="col-sm-4">
                                            <input type="file" name="file" id="file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row" style="margin-right:1em;float:right;">
                                            <button type="submit" name="btnUploads" id="btnUploads"
                                                class="btn btn-success  btn-rounded"><i class="fa fa-save"></i> Upload
                                                Document</button>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="panel-body">
                                        <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                            <table id="example" class="display" width="100%">
                                                <thead>
                                                    <tr>
                                                        <!-- <th align='center'> No </th> -->
                                                        <th align='center'> No. </th>
                                                        <th align='center'> Nama Pendidikan</th>
                                                        <th align='center'> Tgl Lulus</th>
                                                        <th align='center'> Jenis Pendidikan </th>
                                                        <th align='center'> Jurusan</th>
                                                        <th align='center'> Jenis File</th>
                                                        <th align='center'> Ext</th>
                                                        <th align='center'> Date Update</th>
                                                        <th align='center'> User Update</th>
                                                        <th align='center'>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>



                                </form>



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
<script src="<?= BASEURL; ?>/js/App/hrd/upload/uploadDataPendidikan.js"></script>