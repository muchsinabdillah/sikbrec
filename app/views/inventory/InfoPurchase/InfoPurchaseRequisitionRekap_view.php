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
                                <h5> Data <?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">

                                    <label for="inputEmail3" class="col-sm-1 control-label">Periode</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" onfocusout="TrigerTgl()"
                                            name="PeriodeAwal" id="PeriodeAwal">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">S/d</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" onfocusout="TrigerTgl()"
                                            name="PeriodeAkhir" id="PeriodeAkhir">
                                    </div>
                                </div>
                                <a type="button" class="btn btn-success btn-animated btn-wide " id="btnLoadInformation"
                                    name="btnLoadInformation"><span class="visible-content">Load</span><span
                                        class="hidden-content"><i class="fa fa-gear"></i></span></a>

                                        <button type="button" class="btn btn-success btn-animated btn-wide" id="excelLanscape" name="excelLanscape"><span class="visible-content" class="btn btn-primary">Excel<span class="hidden-content"></span></button>

                            </form>

                            <hr>

                            <div class="panel-body p-20">
                                <div class="table-responsive demo-table">
                                    <table id="example" class="table table-striped table-bordered table-sm"
                                        cellspacing="0" width="100%">
                                        <div class="panel-title">
                                        </div>
                                </div>
                                <thead>
                                    <tr>
                                        <th align='center'>
                                            <font size='1'>Transaction Code</font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>Transaction Date</font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>User create</font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>Total Qty</font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>Total Row</font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>Type </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'> Unit </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>Approved </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'> User Approved </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'> Date Approved </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'> Void </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>Date Void</font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>User Void </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>Date Create Real </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>User Create Real </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>Reff Date Trs </font>
                                        </th>
                                        <th align='center'>
                                            <font size='1'>Notes</font>
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
<script src="<?= BASEURL; ?>/js/App/infopurchasing/InfoPurchaseRequisitionRekap.js"></script>