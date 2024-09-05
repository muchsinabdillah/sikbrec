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
                            <p class="sub-title text-muted">Silahkan Masukan OTP Anda. Check Whatsaap Anda.</p>
                        </div>

                        <form class="form-horizontal">
                            <div class="form-group left-icon">
                                <label for="exampleInputEmail1" class="col-sm-3 control-label">OTP</label>
                                <div class="col-sm-9">
                                    <span class="glyphicon glyphicon-tags form-left-icon"></span>
                                    <input type="text" autocomplete="off" class="form-control" id="NoOTP" name="NoOTP" placeholder="Masukan OTP Anda">
                                    <input type="hidden" autocomplete="off" class="form-control" id="UserId" name="UserId" value="<?= $data['id'] ?>">
                                </div>
                            </div>
                        </form>
                        <div class="form-group mt-20">
                            <div class="">
                                <button id="btnOTPVerify" class="btn btn-success btn-labeled pull-right">OTP<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
<script src="<?= BASEURL; ?>/js/App/Login/OTP_v01.js"></script>