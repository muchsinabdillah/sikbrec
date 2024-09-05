<div class="main-page">
    <div class="container-fluid">
        <div class="row page-title-div">
            <div class="col-md-6">
                <h2 class="title"><?= $data['judul'] ?></h2>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <!-- <div class="row breadcrumb-div"> 
            <div class="col-sm-6"> 
                <ul class="breadcrumb"> 
                    <li><a href="<?= BASEURL; ?>"><i class="fa fa-home"></i> Home</a></li> 
                    <li class="active"><?= $data['judul'] ?></li> 
                    <li class="active"><?= $data['judul_child'] ?></li> 
                </ul> 
            </div> 
        </div> -->
        <!-- /.row -->
    </div>
    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30"><?= $data['judul_child'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form action="<?= BASEURL ?>/signatureDigital/SprtoPDF" method="POST" class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">No MR :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="no_MR" name="no_MR" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Pasien :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="nama_Pasien" name="nama_Pasien" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">No Eps :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="no_Eps" name="no_Eps" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Jaminan :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="nama_Jaminan" name="nama_Jaminan" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">No Reg :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="no_Reg" name="no_Reg" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Dokter DPJP :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="dokter_DPJP" name="dokter_DPJP" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">user order :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="user_Order" name="user_Order" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Golongan Darah :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="GolonganDarah" name="GolonganDarah" type="text" readonly>
                                    </div>
                                </div>
                                <!-- <button type="button" style="margin-left:2em" name="btn_new" id="btn_new" class="btn btn-primary">
                                    <i class="fa-solid fa-plus"></i>
                                    New</button> -->

                                <hr>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">ID
                                        Order :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="id_Order" name="id_Order" type="text" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Order :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="tgl_Order" name="tgl_Order" type="text" readonly>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Pakai :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="tgl_Pakai" name="tgl_Pakai" type="datetime-local">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="ket_order" name="ket_order" type="text">
                                    </div>
                                </div> -->
                                <hr>

                                <br><br>

                            </form>

                            <form id="form_payment_closing">
                                <div class="form-group">
                                    <div class="panel-title">
                                        <span class="glyphicon glyphicon-list"></span> List
                                    </div>

                                    <div class="demo-table" style="overflow-x:auto;">
                                        <table id="list_orderdarahdetail" class="display" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size="1">ID
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">ID Tarif
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Nama Tarif Darah
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Qty Order (bag)
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Qty Pakai
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Qty Sisa
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Qty Order (cc/ml)
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <!-- <tfoot>
                                                <th>Total</th>
                                                <th></th>
                                                <th></th>
                                            </tfoot> -->
                                        </table>
                                    </div>

                                </div>

                        </div>


                        </form>

                        <br>
                        <div class="form-group">
                            <br>
                            <div class="col-sm-3">
                            </div>
                            <label for="nama pasien" class="col-sm-5 control-label">
                            </label>
                            <button type="submit" name="btn_simpan" id="btn_simpan" class="btn btn-info"><i class="fa fa-save"></i>
                                Retur
                            </button>
                            <!-- <button type="button" name="btn_batal" id="btn_batal" class="btn btn-danger"><i class="fa fa-trash-o"></i>
                                Hapus
                            </button> -->
                            <a onclick="MyBack()" class="btn btn-warning waves-effect" id="btnBack" name="btnBack"><span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
                                Close</a>
                        </div>
                        <br>

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

<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/odc/ViewReturDarah.js"></script>