<div class="main-page">

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30">Load Data <?= $data['judul'] ?> <button type="button"
                                        class="btn btn-maroon btn-animated btn-wide btn-rounded"
                                        onclick="goGroupShiftPages();"><span class="visible-content">New Data</span><span class="hidden-content"><i
                                                class="fa fa-send-o"></i></span></button></h5>
                            </div>
                        </div>
                        <div class="panel-body p-20">
                            <div class="demo-table" style="overflow-x:auto;margin-top: 10px;" id="tbl_rekap">
                                <table id="tbllistData" class="display" cellspacing="0" width="100%">
                                    <!-- <table id="tbllistData" class="display table table-striped table-bordered"
                                        cellspacing="0" width="100%"> -->

                                    <thead>
                                        <tr>
                                            <th align='center'>
                                                <font size="1">Kode Transaksi
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tgl Transaksi
                                            </th>
                                            <th align='center'>
                                                <font size="1">User Order
                                            </th>
                                            <th align='center'>
                                                <font size="1">Unit Order
                                            </th>
                                            <th align='center'>
                                                <font size="1">Jenis PR
                                            </th>
                                            <th align='center'>
                                                <font size="1">Notes
                                            </th>
                                            <th align='center'>
                                                <font size="1">Total
                                            </th>
                                            <th align='center'>
                                                <font size="1">Status
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
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/inventory/purchase/PurchasingForm_List.js"></script>