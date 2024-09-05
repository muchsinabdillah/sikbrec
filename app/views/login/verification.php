<div class="main-wrapper">

    <div class="login-bg-color bg-gray">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel login-box">
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            <img src="<?= BASEURL; ?>/images/yarsi.png" alt="PMS System - GUT" class="logo" height="70px" width="170px">
                        </div>
                    </div>
                    <div class="panel-body p-20">

                        <div class="section-title">
                            <p class="sub-title text-muted">Untuk menjaga Keamanan akun anda, Silahkan Masukan Nomor Handphone Anda Untuk Verifikasi Data dengan Format : 0898763xxxx.</p>
                        </div>

                        <form class="form-horizontal">
                            <div class="form-group left-icon">
                                <label for="exampleInputEmail1" class="col-sm-3 control-label">No. HP</label>
                                <div class="col-sm-9">
                                    <span class="glyphicon glyphicon-phone form-left-icon"></span>
                                    <input type="number" autocomplete="off" class="form-control" id="NoHandphone" name="NoHandphone" placeholder="Ex : 0877xxxxxxxx">
                                    <input type="hidden" autocomplete="off" class="form-control" id="UserId" name="UserId" value="<?= $data['id'] ?>">
                                </div>
                            </div>
                        </form>
                        <div class="form-group mt-20">
                            <div class="">
                                <button id="btnVerify" class="btn btn-success btn-labeled pull-right">Verify<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.panel -->
                <p class="text-muted text-center"><small>Copyright © IDS Developer 2021</small></p>
            </div>
            <!-- /.col-md-6 col-md-offset-3 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /. -->

</div>
<!-- /.main-wrapper -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/Login/Verification_v01.js"></script>