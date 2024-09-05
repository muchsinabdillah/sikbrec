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
                        </div>
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs border-bottom border-primary">
                                <li class="active"><a data-toggle="tab" href="#tarif_rajal" style="background-color:#c4fff2;">Tarif Rawat Jalan</a></li>
                                <li><a data-toggle="tab" href="#tarif_ranap" style="background-color:#b0d5ff;">Tarif Rawat Inap</a></li>
                                <!-- <li><a data-toggle="tab" href="#tarif_paket" style="background-color:#cabdfc;"> Tarif Paket</a></li> -->
                                <li><a data-toggle="tab" href="#tarif_radiologi" style="background-color:#fcbded;"><i class="fa fa-x-ray"></i> Tarif Radiologi</a></li>
                                <li><a data-toggle="tab" href="#tarif_lab" style="background-color:#fcbdbd;"><i class="fa fa-vial"></i> Tarif Laboratorium</a></li>
                                <li><a data-toggle="tab" href="#tarif_mcu" style="background-color:#fcdebd;"><i class="fas fa-file-medical-alt"></i> Tarif MCU</a></li>
                                <li><a data-toggle="tab" href="#tarif_operasi" style="background-color:#f8fcbd;"><i class="fa fa-user-nurse"></i> Tarif Paket Operasi</a></li>
                            </ul>
                            <!-- Tab panes -->

                            <div class="tab-content bg-white p-15">
                                <div id="tarif_rajal" class="tab-pane fade in active">
                                    <div class="panel-body">
                                        <form class="form-horizontal" id="form_cuti">

                                            <div id="select_unit">
                                                <select class="js-example-basic-single" id="GrupPerawatan" name="GrupPerawatan" onchange="load_data_rajal(this)" style="min-width:20em">
                                                    <!-- <option value="">-- Pilih Nama Unit --</option> -->
                                                </select>
                                            </div>
                                            <br>
                                            <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                                <table id="table-load-data" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">Code Tarif
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Category Product
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Product Name
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Group Tarif
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tarif RS
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Kode Jasa
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Kode COA
                                                            </th>

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                </div>
                                <!-- Tab panes -->

                                <div id="tarif_paket" class="tab-pane fade">

                                    <div class="panel-body">

                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Group Spesialis<sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="GroupSpesialis" name="GroupSpesialis" onchange="GroupSpesial(this);ShowKategoriOperasi(this)">
                                                </select>
                                            </div>


                                            <label for="inputEmail3" class="col-sm-2 control-label"> Kategori Operasi <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select name="Show_Kategori_Operasi" id="Show_Kategori_Operasi" class="form-control" onchange="ShowKategoriOperasi(this);ShowTindakanOperasi(this)">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-2 control-label"> Tindakan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-4">
                                                <select name="Show_Tindakan_Operasi" id="Show_Tindakan_Operasi" class="form-control" onchange="ShowTindakanOperasi(this)">
                                                </select>
                                            </div>
                                        </div>


                                        <button class="btn btn-primary" id="btn_carioperasi" name="btn_carioperasi"><span class="glyphicon glyphicon glyphicon-search"></span> Cari</button>
                                        <br>
                                        <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                            <table id="tbl_tarif_paket" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size="1">Nama Tindakan
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Nama Jasa
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kls 3
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kls 2
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Deluxe
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Junior Suite
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Executive
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">President Suite
                                                        </th>

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab panes -->

                                <div id="tarif_radiologi" class="tab-pane fade">

                                    <div class="panel-body">
                                        <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                            <table id="radiologi" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size="1">Modality
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Pemeriksaan
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kode Jasa
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kode Coa
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tipe Tarif
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tarif Rajal / Kls 3
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kelas 2
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Deluxe
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Junior Suite
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Executive
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">President Suite
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <!-- Tab panes -->

                                <div id="tarif_mcu" class="tab-pane fade">
                                    <div class="panel-body">
                                        <div id="select_unit">
                                            <select class="js-example-basic-single" id="mcu" name="mcu" onchange="load_data_mcu(this);getheadermcu(this);" style="width: 20%">

                                            </select>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-1 control-label"> Tarif <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-2">
                                                <b><input class="form-control input-sm" id="tarif_mcu_value" name="tarif_mcu_value" type="text" readonly></b>
                                            </div>

                                            <label for="inputEmail3" class="col-sm-1 control-label"> Masa Berlaku <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-2">
                                                <b><input class="form-control input-sm" id="awalmasaberlaku" name="awalmasaberlaku" type="text" readonly></b>
                                            </div>

                                            <label for="inputEmail3" class="col-sm-2 control-label"> Sampai Dengan <sup class="color-danger">*</sup></label>
                                            <div class="col-sm-2">
                                                <b><input class="form-control input-sm" id="akhirmasaberlaku" name="akhirmasaberlaku" type="text" readonly></b>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                        <table id="table-load-data-mcu" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size="1">Pemeriksaan
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Lokasi Pemeriksaan
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Pemeriksaan Penunjang
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">ID Tes
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Tarif
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab panes -->

                                <div id="tarif_operasi" class="tab-pane fade">

                                    <div class="panel-body">
                                        <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                            <table id="paket_operasi" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size="1">Action
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Nama Paket Operasit
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kelas 3
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kelas 2
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kelas 1
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Junior Suite
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Executive Suite
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">President Suite
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Keterangan Paket
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Status
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tab panes -->

                                <div id="tarif_lab" class="tab-pane fade">

                                    <div class="panel-body">

                                        <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                            <table id="laboratorium" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size="1">Kode Kelompok
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">No Urut
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">ID Tes
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Nama Tes
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kode Jas
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kode COA
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tipe Tarif
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tarif Rajal
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tarif IGD
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kelas 3
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kelas 2
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Deluxe
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Junior Suite
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Executive Suite
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">President Suite
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Isolasi
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">ICU
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tarif Asuransi
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tarif BPJS
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Jamkesda
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab panes -->
                                <div id="tarif_ranap" class="tab-pane fade">
                                    <div class="panel-body p-20">
                                        <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size="1">Product Code
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kategori
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Deksripsi
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kode Jasa
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Kode COA
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tipe Tarif
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tarif
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">T-Kelas 3
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">T-Kelas 2
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">T-Kelas 1
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tarif VIP
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tarif SVIP
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Tarif ICU
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.col-md-12 -->
            </div>
            <!-- Modal Detail Paket-->
            <div class="modal fade" id="modal_pilih_paket" tabindex="-1" role="dialog" style="overflow-y: auto">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" id="CloseMe" name="CloseMe" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Data Detail Paket</h4>
                        </div>
                        <div class="modal-body">
                            <div id="Show_Detail_Paket">
                                <div class="panel-body p-20">
                                    <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                        <table id="Show-Detail-Paket" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size="1">Deskripsi
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Kelompok Item
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">QTY
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Kelas 3
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Kelas 2
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Kelas 1
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Junior Suite
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Executive
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">President Suite
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" href="#" id="CloseMex" name="CloseMex">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END Modal Detail Paket-->
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
<script src="<?= BASEURL; ?>/js/App/Tarif/InfoMasterTarif.js"></script>