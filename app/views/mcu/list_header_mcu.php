<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
                <!-- <p class="sub-title">Silahkan Input Transaksi Disini.</p>   -->

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
    <!-- /.container-fluid -->

    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30">Load <?= $data['judul'] ?> <a
                                        href="<?= BASEURL ?>/TarifMcu/inputTarifMcu"
                                        class="btn btn-primary btn-animated btn-wide"
                                        onclick="goGroupShiftPages();"><span class="visible-content">New
                                            Data</span><span class="hidden-content"><i
                                                class="fa fa-send-o"></i></span></a></h5>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="demo-table" style="overflow-x:auto;">
                                <table id="datahistori" class="display" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center' width="10%">
                                                <font size="1">ID
                                            </th>
                                            <th align='center' width="20%">
                                                <font size="1">Nama Paket
                                            </th>
                                            <th align='center' width="20%">
                                                <font size="1">Pemeriksaan
                                            </th>
                                            <th align='center'>
                                                <font size="1">Tarif
                                            </th>
                                            <th align='center'>
                                                <font size="1">Masa Berlaku
                                            </th>
                                            <th align='center'>
                                                <font size="1">Expired
                                            </th>
                                            <th align='center'>
                                                <font size="1">Discontinue
                                            </th>
                                            <th align='center'>
                                                <font size="1">Action
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($data['tarifmcu'] as $tarif) :
                                        ?>
                                        <tr>
                                            <td><?= $tarif['IDMCU'] ?></td>
                                            <td><?= $tarif['NamaPaket'] ?></td>
                                            <td><?= $tarif['Pemeriksaan'] ?></td>
                                            <td><?= $tarif['Tarif'] ?></td>
                                            <td><?= $tarif['AwalMasaBerlaku'] ?></td>
                                            <td><?= $tarif['AkhirMasaBerlaku'] ?></td>
                                            <td><?= $tarif['Discontinue'] ?></td>
                                            <td><a href="<?= BASEURL ?>/TarifMcu/EditDataMcu/<?= base64_encode($tarif['NamaPaket']) ?>"
                                                    class="btn btn-primary">View</a></td>
                                        </tr>
                                        <?php
                                        endforeach;
                                        ?>
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
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/DataTables/datatables.js"></script>
<script src="<?= BASEURL ?>/js/App/stoploading.js"></script>
<script src="<?= BASEURL ?>/js/App/mcu/datatabletarifmcu.js"></script>