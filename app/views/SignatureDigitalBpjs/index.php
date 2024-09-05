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
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                <div class="box-part text-center">

                                    <a href="<?= BASEURL ?>/signatureDigital/SignatureSep"><i class="fa fa-instagram fa-3x" aria-hidden="true"></i></a>

                                    <div class="title">
                                        <h4>SEP</h4>
                                    </div>

                                    <div class="text">
                                        <span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
                                    </div>

                                    <a href="#">Learn More</a>

                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                <div class="box-part text-center">

                                    <a href="<?= BASEURL ?>/signatureDigital/GeneralConsern"><i class="fa fa-twitter fa-3x" aria-hidden="true"></i></a>

                                    <div class="title">
                                        <h4>GENERALCONSEN</h4>
                                    </div>

                                    <div class="text">
                                        <span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
                                    </div>

                                    <a href="#">Learn More</a>

                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                <div class="box-part text-center">

                                    <a href="<?= BASEURL ?>/signatureDigital/Akadijaroh"><i class="fa fa-facebook fa-3x" aria-hidden="true"></i></a>

                                    <div class="title">
                                        <h4>AKADIJAROH</h4>
                                    </div>

                                    <div class="text">
                                        <span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
                                    </div>

                                    <a href="#">Learn More</a>

                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
    let iduser = ` <?= $data['session']->username ?>`
    let namauser = ` <?= $data['session']->name ?>`
</script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/select2/select2.js"></script>
<script src="<?= BASEURL; ?>/js/sweet-alert/sweetalert.min.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>
<script src="<?= BASEURL; ?>/js/App/Signature/signature.js"></script>