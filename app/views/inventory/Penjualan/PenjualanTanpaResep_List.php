<div class="main-page">

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>Load Data <button type="button" class="btn-rounded btn btn-maroon btn-animated btn-wide" onclick="goGroupShiftPages();"><span class="visible-content"> + Add New
                                            Data</span><span class="hidden-content"><i class="fa fa-send-o"></i></span></button></h5>
                            </div>
                        </div>
                        <div class="panel-body p-20">
                        <div class="form-group">
                                            <!-- <h3>Cari Data Reservasi</h3> -->
                                            <!-- <div class="alert alert-info alert-dismissible">
                                                <p> <strong>Info !</strong> Textbox NOTE di gunakan untuk mengisi jika
                                                    ada Keterangan Tambahan. Contoh : Ada Perubahan Jam Praktek menjadi
                                                    jam 10:00.</p>
                                                <p> <strong>Info !</strong> Jika tidak ada Tambahan Note, maka Textbox
                                                    NOTE diisikan saja -.</p>
                                            </div> -->
                                            <label for="inputEmail3" class="col-sm-1 control-label">Periode:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" name="tglawal" id="tglawal"
                                                placeholder="Tanggal dari" value="<?= Utils::datenowcreateNotFull() ?>">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-1 control-label">s / d</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" name="tglakhir" id="tglakhir"
                                                placeholder="Tanggal Sampai"
                                                value="<?= Utils::datenowcreateNotFull() ?>">
                                        </div>
                                        <a class="btn btn-danger btn-sm btn-rounded " id="btnSearching"
                                            name="btnSearching">
                                            <span class="glyphicon glyphicon glyphicon-search"></span> Cari</a>
                                        </thead>
                                        </div>
                                        <br><br>
                            <div class="demo-table" style="overflow-x:auto;">
                                <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center' style="width: 3em;">
                                                <font size="1">No
                                            </th>
                                            <!-- <th align='center'>
                                                <font size="1">No. Resep
                                            </th> -->
                                            <th align='center'>
                                                <font size="1">Tgl Resep
                                            </th>
                                            <th align='center'>
                                                <font size="1">Nama
                                            </th>
                                            <th align='center'>
                                                <font size="1">Notes
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jenis Pasien
                                            </th>
                                            <th align='center'>
                                                <font size="1">User
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
    <div class=" modal-dialog modal-SM" role="document">
        <div class="modal-content" style="width: 150%; margin-right:150%; margin-top : 10%">
            <div class="modal-header" style="background-color:#660f0f;">
                <h4 class="modal-title" id="myModalLabel" style="text-align: center; color:#ffffff;">Silahkan Isi
                    Data Pada Kolom Yang
                    disediakan</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <input class="form-control input-sm" type="hidden" autocomplete="off" id="IDMedrec" readonly name="IDMedrec">

                        <div class="form-group gut" style="margin-left: 5%;">
                            <h5>Detail Pasien</h5>
                        </div>

                        <div class="form-group" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> No. MR <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="No_MR" id="No_MR">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label"> No. BPJS <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="No_BPJS" id="No_BPJS">
                            </div>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Nama" id="Nama">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label"> Bin/Bt <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Bin" id="Bin">
                            </div>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Tanda Pengenal <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="TandaPengenal" id="TandaPengenal">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label">NIK <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="NIK" id="NIK">
                            </div>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="J_Kel" id="J_Kel">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label">Agama <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Agama" id="Agama">
                            </div>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Warga Negara <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Warga_Negara" id="Warga_Negara">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label">Tempat Lahir <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Tempat_Lahir" id="Tempat_Lahir">
                            </div>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Tanggal_Lahir" id="Tanggal_Lahir">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label">Umur <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Umur" id="Umur">
                            </div>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> No. HP <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="No_HP" id="No_HP">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label">Email <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Email" id="Email">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group gut" style="margin-left: 5%;">
                            <h5>ALamat Pasien</h5>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Alamat <sup class="color-danger">*</sup></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Alamat" id="Alamat">
                            </div>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Provinsi <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Provinsi" id="Provinsi">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label">Kabupaten <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Provinsi" id="Provinsi">
                            </div>
                        </div>
                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Kecamatan <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Kecamatan" id="Kecamatan">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label">Kelurahan <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Kelurahan" id="Kelurahan">
                            </div>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Kode Pos <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Kode_Pos" id="Kode_Pos">
                            </div>
                        </div>
                        <hr>

                        <div class="form-group gut" style="margin-left: 5%;">
                            <h5>Pekerjaan Pasien</h5>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Pekerjaan <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Pekerjaan" id="Pekerjaan">
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label">Nama Perusahaan <sup class="color-danger">*</sup></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="Perushaan" id="Perushaan">
                            </div>
                        </div>

                        <div class="form-group gut" style="margin-left: 10%;">
                            <label for="inputEmail3" class="col-sm-2 control-label"> Alamat Perusahaan <sup class="color-danger">*</sup></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Pekerjaan" id="Pekerjaan">
                            </div>
                        </div>


                        <!-- <div class="form-group" style="margin-left: 10%;">
                            <button type="button" class="btn btn-danger btn-animated btn-wide"
                                onclick="goGroupShiftPages();"><span class="visible-content"> + Pasien Non Regist
                                </span><span class="hidden-content"><i class="fa fa-send-o"></i></span></button>
                        </div>
                        <div class="form-group" style="margin-left: 10%;">
                            <button type="button" class="btn btn-danger btn-animated btn-wide"
                                onclick="goGroupShiftPages();"><span class="visible-content"> + Pasien Regist
                                </span><span class="hidden-content"><i class="fa fa-send-o"></i></span></button>
                        </div> -->

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger btn-wide" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"> Next</i></button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- end Modal -->

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
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/inventory/Penjualan/PenjualanTanpaResep_List.js"></script>