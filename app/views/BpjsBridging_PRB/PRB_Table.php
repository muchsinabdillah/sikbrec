<?php
    date_default_timezone_set('Asia/Jakarta');
    $id = "";
    $datenowcreate = date("Y-m-d");
    $datetimenow = date("Y-m-d\TH:i:s");
    ?>
<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30"><?= $data['judul'] ?><small></small> </h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <div class="tab-content bg-white p-15">

                                    <form class="form-horizontal" id="form_resign">
                                        <div class="form-group  ">
                                            <label for="inputEmail3" class="col-sm-3 control-label"> Masukan Periode
                                                Pencarian <sup class="color-danger">*</sup></label>
                                            
                                            <div class="col-sm-2">
                                                <input class="form-control input-sm" type="date" id="tglAwalarsip"
                                                    autocomplete="off" name="tglAwalarsip"
                                                    placeholder="ketik Kata Kunci disini">
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control input-sm" type="date" id="tglAkhirArsip"
                                                    autocomplete="off" name="tglAkhirArsip"
                                                    placeholder="ketik Kata Kunci disini">
                                            </div>
                                        </div>
                                    </form>
                                    <div class="form-group  ">
                                        <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-2">
                                            <button type="button" onclick="showDataPasienRajalArsip();"
                                                id="caridatapasienarsip" class="btn btn-success btn-wide btn-rounded"><i
                                                    class="fa fa-search"></i>Search</button>
                                        </div>
                                    </div>
                                    <!-- <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                              <table id="example" width="100%" class="table table-striped table-hover cell-border"> -->
                                    <div class="panel-body">
                                        <div class="demo-table" id="tbl_rekap" style="margin-top: 10px;">
                                            <table id="example" class="display" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center'>
                                                            <font size="1">ID
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">No. Episode
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">No. Registrasi
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">No. MR
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Nama Pasien
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Lokasi Pasien
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Dokter
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">SEP
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Pasien PRB
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Input PRB
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

<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/BpjsBridging_PRB/BpjsPRB_Table.js"></script>