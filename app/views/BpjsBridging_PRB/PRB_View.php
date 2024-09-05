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
                                <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus
                                        diisi</small></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_input">
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> ID PRB</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="idhdr_bpjs" id="idhdr_bpjs"
                                            readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> ID Visit/No SRB <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="IdAuto" id="IdAuto"
                                            value="<?= $data['id'] ?>" readonly hidden>
                                    </div>
                                    <div class="col-sm-2">
                                    <input type="text" class="form-control" name="NoSRB" id="NoSRB" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Keterangan PRB <sup
                                            class="color-danger">*</sup></label>
                                    <div class="form-group gut" style="display:none">

                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="KeteranganPRB" id="KeteranganPRB" readonly>
                                    </div>
                                    <!--
                                     <div class="col-sm-2">
                                     <button class="btn btn-primary btn-rounded"id="btnSearchPasien" name="btnSearchPasien" >  <span class="glyphicon glyphicon glyphicon-search"></span> Cari Pasien </button>
                                     </div>
                                        -->
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No Registrasi <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NoRegistrasi" id="NoRegistrasi"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No MR <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NoMR" id="NoMR" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No Episode <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NoEpisode" id="NoEpisode"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No SEP <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NoSEP" id="NoSEP" readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> No Kartu <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NoKartuBPJS" id="NoKartuBPJS"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="NamaPasien" id="NamaPasien"
                                            readonly>
                                    </div>
                                    <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="TglLahir" id="TglLahir" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Alamat <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="Alamat" name="Alamat" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Email <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="Email" name="Email" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                            <input readonly class="form-control input-sm" type="text"
                                                id="KodePoliklinikBPJS" name="KodePoliklinikBPJS">
                                    </div>
                                    <div class="col-sm-3">
                                            <input readonly class="form-control input-sm" type="text"
                                                id="NamaPoliklinikBPJS" name="NamaPoliklinikBPJS">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Dipilih <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-1">
                                            <input readonly class="form-control input-sm" type="text"
                                                id="KodeDokterBPJS" name="KodeDokterBPJS">
                                    </div>
                                    <div class="col-sm-3">
                                        <input readonly class="form-control input-sm" type="text"
                                                id="NamaDokterBPJS" name="NamaDokterBPJS">
                                    </div>
                                </div>
                                
                                <!-- <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Poliklinik </label>
                                    <div class="col-sm-4">
                                        <select id='cariPoliklinikBPJS' style="width: 100%;" name='cariPoliklinikBPJS'
                                            class="form-control ">
                                            <option value='0'>- Search Poliklinik -</option>
                                        </select>
                                    </div> 
                                </div> -->
                                <!-- <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label"> DPJP </label>
                                    <div class="col-sm-4">
                                        <select id='cariDokterBPJS' style="width: 100%;" name='cariDokterBPJS'
                                            class="form-control ">
                                            <option value='0'>- Search Dokter -</option>
                                        </select>
                                    </div>

                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Dipilih <sup
                                                class="color-danger">*</sup></label>
                                        <div class="col-sm-1">
                                            <input readonly class="form-control input-sm" type="text"
                                                id="KodeDokterBPJS" name="KodeDokterBPJS">
                                        </div>
                                        <div class="col-sm-3" style="margin-left: -20px;">
                                            <input readonly class="form-control input-sm" type="text"
                                                id="NamaDokterBPJS" name="NamaDokterBPJS">
                                        </div>
                                    </div> -->


                                <!-- </div> -->
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Program PRB <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <select id='ProgramPRB' style="width: 100%;" name='ProgramPRB'
                                            class="form-control ">
                                            <option value='0'>- Search Program PRB -</option>
                                        </select>
                                    </div>

                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Program PRB Dipilih
                                            <sup class="color-danger">*</sup></label>
                                        <div class="col-sm-1">
                                            <input readonly class="form-control input-sm" type="text"
                                                id="KodeProgramPRB" name="KodeProgramPRB">
                                        </div>
                                        <div class="col-sm-3" style="margin-left: -20px;">
                                            <input readonly class="form-control input-sm" type="text"
                                                id="NamaProgramPRB" name="NamaProgramPRB">
                                        </div>
                                    </div>



                                </div>
                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Keterangan <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <textarea rows="2" class="form-control" id="Keterangan" name="Keterangan"
                                            style="resize: none"></textarea>
                                    </div>

                                    <label for="inputEmail3" class="col-sm-2 control-label"> Saran <sup
                                            class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <textarea rows="2" class="form-control" id="Saran" name="Saran"
                                            style="resize: none"></textarea>
                                    </div>

                                </div>
                                <button type="button" class="btn btn-primary btn-rounded" id="createprb"
                                    name="createprb" data-dismiss="modal">
                                    <i class="fa fa-plus-square"></i> Create New</button>
                                <hr>
                                <div id="inputobat" style="display:none">
                                    <div class="form-group gut">

                                        <label for="inputEmail3" class="col-sm-2 control-label"> Input Obat <sup
                                                class="color-danger">*</sup></label>
                                        <div class="col-sm-4">
                                            <select id='ObatPRB' style="width: 100%;" name='ObatPRB'
                                                class="form-control ">
                                                <option value='0'>- Search Obat PRB -</option>
                                            </select>
                                        </div>

                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Obat PRB Dipilih
                                                <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-1">
                                                <input readonly class="form-control input-sm" type="text"
                                                    id="KodeObatPRB" name="KodeObatPRB">
                                            </div>
                                            <div class="col-sm-3" style="margin-left: -20px;">
                                                <input readonly class="form-control input-sm" type="text"
                                                    id="NamaObatPRB" name="NamaObatPRB">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group gut">

                                        <label for="inputEmail3" class="col-sm-2 control-label"> Qty</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="QtyObat" name="QtyObat">
                                        </div>

                                        <label for="inputEmail3" class="col-sm-2 control-label"> Signa</label>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" id="Signa1" name="Signa1">
                                        </div>
                                        <div class="col-sm-1">
                                           
                                        <label for="inputEmail3" class="col-sm-1 control-label"> X</label>
                                        </div>
                                        <div class="col-sm-1" style="margin-left:-50px">
                                            <input type="number" class="form-control" id="Signa2" name="Signa2">
                                        </div>
                                    </div>

                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-2">
                                            <a class="btn btn-primary" title="Tambah Baris" id="add_row" name="add_row"
                                                style="margin-bottom: 10px;">
                                                Add</a>
                                        </div>
                                    </div>
                            </form>


                            <!--
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Grup Tarif <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select class="form-control js-example-basic-single" id="GruptarifKarcis" name="GruptarifKarcis">
                                             <option value="">-- PILIH --</option>
                                             <option value="UM">UMUM</option>
                                             <option value="TE">TELKOM</option>
                                             <option value="KM">KMK</option>
                                             <option value="BS">BPJS</option>
                                         </select>
                                     </div>
                                 </div>-->

                            <div class="table-wrapper">
                                <table class="table" id="tabelobatdtl">
                                    <thead>
                                        <tr>
                                            <th>
                                                <font size="1">No</font>
                                            </th>
                                            <th>
                                                <font size="1">Kode Obat</font>
                                            </th>
                                            <th>
                                                <font size="1">Nama Obat</font>
                                            </th>
                                            <th>
                                                <font size="1">Qty</font>
                                            </th>
                                            <th>
                                                <font size="1">Signa 1</font>
                                            </th>
                                            <th>
                                                <font size="1">Signa 2</font>
                                            </th>
                                            <th>
                                                <font size="1">Action</font>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>


                            <div class="btn-group" role="group">

                                <button type="button" class="btn btn-danger btn-rounded" id="btnBatal" name="btnBatal">
                                    <i class="fa fa-times" aria-hidden="true"></i> Batal </button>
                                <a class="btn btn-primary btn-rounded" id="savetrs" name="savetrs" data-dismiss="modal">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    Simpan</a>
                                    <button type="button" class="btn btn-gold btn-rounded" id="btnPrint" name="btnPrint" onclick="PrintPRB()">
                                    <i class="fa fa-print" aria-hidden="true"></i> Print </button>
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
<script src="<?= BASEURL; ?>/js/App/BpjsBridging_PRB/BpjsPRB_View.js"></script>