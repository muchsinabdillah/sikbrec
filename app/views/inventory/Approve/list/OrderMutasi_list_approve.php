<div class="main-page">
    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30">Load <?= $data['judul'] ?> </h5>
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal" id="form_cuti">
                                    <div class="form-group gut">

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
                                        <a class="btn btn-maroon btn-sm btn-rounded " id="btnSearching"
                                            name="btnSearching">
                                            <span class="glyphicon glyphicon glyphicon-search"></span> Cari</a>
                                        </thead>
                                    </div>
                                </form>

                            </div>

                        </div>
                        <div class="panel-body p-20">
                            <!-- <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                            <div class="panel-body"> -->
                            <div class="demo-table" style="overflow-x:auto;margin-top: 10px;" id="tbl_rekap">
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size='1'>No. Transaksi</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>Tgl Transaksi</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>Petugas Input</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>Keterangan</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>Jenis Request</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>Status</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>User Approved</font>
                                            </th>
                                            <th align='center'>
                                                <font size='1'>Action</font>
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
<script src="<?= BASEURL; ?>/js/App/inventory/Approve/list/ApproveOM_List.js"></script>