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
                            <div class="panel-title">
                                <h5 class="underline mt-30"><?= $data['judul'] ?>

                                </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Info</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="jenisinfo" name="jenisinfo">
                                            <option value="">-- Pilih Periode Tanggal --</option>
                                            <option value="1">Tanggal Jatuh Tempo</option>
                                            <option value="2">Tanggal Hutang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" onfocusout="TrigerTgl()" name="PeriodeAwal" id="PeriodeAwal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">S/d</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" onfocusout="TrigerTgl()" name="PeriodeAkhir" id="PeriodeAkhir">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-8 control-label"></label>
                                    <a type="button" class="btn btn-danger btn-animated btn-wide " id="btnLoadInformation" name="btnLoadInformation"><span class="visible-content"><i class="fa fa-search"></i>Search</span><span class="hidden-content"><i class="fa fa-gear"></i></span></a>
                                </div>


                            </form>

                            <div class="panel-body p-20">

                                <div class="demo-table" style="overflow-x:auto;">
                                    <!-- <table id="tabelhutang" class="display" width="100%"> -->
                                    <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th align='center'>
                                                    <font size="1"> Kode Hutang
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> Supplier
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> Nama Bank
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> No Rekening
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> Keterangan
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> No. Faktur
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> Nilai Hutang
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> Nilai Sisa
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> Tgl Hutang
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> Tgl Tempo
                                                </th>
                                                <th align='center'>
                                                    <font size="1"> keterangan
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6">TOTAL :</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
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
<!-- <script src="<?= BASEURL; ?>/js/App/finance/informasidetailhutang.js"></script> -->
<script src="<?= BASEURL; ?>/js/App/Informasi/Hutang/InfoHutang.js"></script>