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
                            <p class="sub-title text-muted">Silahkan Login Aplikasi untuk melanjutkan transaksi anda, Terima Kasih.</p>
                        </div>

                        <form class="form-horizontal">
                            <div class="form-group left-icon">
                                <label for="exampleInputEmail1" class="col-sm-3 control-label">User Id</label>
                                <div class="col-sm-9">
                                    <span class="glyphicon glyphicon-envelope form-left-icon"></span>
                                    <input type="text" autocomplete="off" class="form-control" id="UserId" name="UserId" placeholder="Enter Your User Id">
                                </div>
                            </div>
                            <div class="form-group left-icon">
                                <label for="exampleInputPassword1" class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <span class="glyphicon glyphicon-tags form-left-icon"></span>
                                    <input type="password" autocomplete="off" class="form-control" id="Password" name="Password" placeholder="Enter Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <div class="checkbox op-check">
                                        <label>
                                            <input type="checkbox" name="remember" class="flat-blue-style" checked> <span class="ml-10">Remember me</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="form-group mt-20">
                            <div class="">
                                <a href="#" class="form-link"><small class="muted-text">Forgot Password?</small></a>
                                <button onclick="go_save()" id="btnLogin" class="btn btn-success btn-labeled pull-right">Sign in<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
<script src="<?= BASEURL; ?>/js/App/Login/Login_06.js"></script>