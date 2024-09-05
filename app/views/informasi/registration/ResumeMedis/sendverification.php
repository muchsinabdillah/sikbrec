<?php
date_default_timezone_set('Asia/Jakarta');
$id = "";
$datenowcreate = date("Y-m-d");
$datetimenow2222 = date("Y-m-d\TH:i:s");

?>
<div class="main-page">
    <section class="section" style="margin-top: -20px;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5><?= $data['judul'] ?></h5> 
                            </div> 
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmSimpanTrsRegistrasi"> 
                            <input type="hidden" class="form-control" name="kodeResumeMEdis" id="kodeResumeMEdis" value="<?= $data['id'] ?>" >
                                <div class="alert alert-success alert-dismissible">
                                    <p> <strong>Info !</strong> Ini adalah halaman send Verifikasi Whatsapp Resume Medis.</p> 
                                </div>
                            </form> 
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

</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/informasi/registration/ResumeMedis/verification.js"></script> 