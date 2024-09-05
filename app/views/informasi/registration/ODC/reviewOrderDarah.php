<!-- badrul -->
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
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">ID Order / No. MR :</label>
                                    <div class="col-sm-2">
                                    <input class="form-control input-sm " id="id_Order" name="id_Order" type="text" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="no_MR" name="no_MR" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Pasien / Jenis Kelamin :</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="nama_Pasien" name="nama_Pasien" type="text" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="Gender" name="Gender" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">No. Episode / No. Reg :</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="no_Eps" name="no_Eps" type="text" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="no_Reg" name="no_Reg" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Domisili / Tgl Lahir :</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="Domisili" name="Domisili" type="text" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="Tgl_Lahir" name="Tgl_Lahir" type="date" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tgl Order / User Entry :</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="tgl_Order" name="tgl_Order" type="text" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="user_Entry" name="user_Entry" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jaminan :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="nama_Jaminan" name="nama_Jaminan" type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Instalasi / Ruang :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="Ruang" name="Ruang" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">DPJP :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="dokter_DPJP" name="dokter_DPJP" type="text" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">User Order :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="user_Order" name="user_Order" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Diagnosis :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="dokter_DPJP" name="dokter_DPJP" type="text" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Order :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="JenisOrder" name="JenisOrder" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Berat Badan (kg) :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="BeratBadan" name="BeratBadan" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Hb Saat Ini (gr/dl) :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="HbSaatIni" name="HbSaatIni" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Hb Target (gr/dl) :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="HbTarget" name="HbTarget" type="text" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Gol Darah :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="GolonganDarah" name="GolonganDarah" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Rhesus :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="Rhesus" name="Rhesus" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Trombosit Saat Ini :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="TrombositSaatIni" name="TrombositSaatIni" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Trombosit Target :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="TrombositTarget" name="TrombositTarget" type="text" readonly>
                                    </div>
                                </div>
                              
                                <!-- <button type="button" style="margin-left:2em" name="btn_new" id="btn_new" class="btn btn-primary">
                                    <i class="fa-solid fa-plus"></i>
                                    New</button> -->

                                <hr>
                                <!-- <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">ID
                                        Order :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="id_Order" name="id_Order" type="text" value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Order :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="tgl_Order" name="tgl_Order" type="text" readonly>
                                    </div>
                                </div> -->
                                <br>
                                <!-- <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Pakai :</label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="tgl_Pakai" name="tgl_Pakai" type="datetime-local">
                                    </div>
                                    <div class="col-sm-1">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="ket_order" name="ket_order" type="text">
                                    </div>
                                </div> -->
                                <!-- <button type="button" class="btn btn-info  waves-effect" id="btnNewTransaksi" name="btnNewTransaksi"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Transaction</button>
                                <br><br>
                                <div class="form-group" style="margin-left:-2em">
                                    <label for="inputEmail3" class="col-sm-1 control-label">No Transaksi :</label>
                                    <div class="col-sm-2">
                                        
                                        <input class="form-control" id="NoOrderTransaksi" name="NoOrderTransaksi" type="text" value="<?= $data['iduseblood'] ?>" readonly>
                                    </div>
                                </div> -->

                                <!-- <div class="form-group col-md-4">
                                    <label for="inputEmail3">Jenis Darah :</label>
                                    <select name="ListOrderDarah" id="ListOrderDarah" style="width: 100%; margin-left:1em" onchange="getDataDetail(this.value)" class="form-control">
                                    </select>
                                </div>
                                <div class="form-group col-md-3" style="margin-left:1em">
                                    <label for="inputEmail3">QTY
                                        Order :</label>
                                    <input class="form-control input-sm " id="Id_dtl" name="Id_dtl" type="hidden">
                                    <input class="form-control input-sm " id="IdTarifDarah" name="IdTarifDarah" type="hidden">
                                    <input class="form-control input-sm " id="NamaTarifDarah" name="NamaTarifDarah" type="hidden">
                                    <input class="form-control input-sm " id="Harga" name="Harga" type="hidden">
                                    <input class="form-control input-sm " id="Total" name="TotalTarif" type="hidden">
                                    <input class="form-control input-sm " id="QtyOrder" name="QtyOrder" type="text" readonly>
                                </div>
                                <div class="form-group col-md-2" style="margin-left:1em">
                                    <label for="inputEmail3">QTY
                                        Sisa :</label>
                                    <input class="form-control input-sm " id="QtySisa" name="QtySisa" type="text" readonly>
                                </div>
                                <div class="form-group col-md-2" style="margin-left:1em">
                                    <label for="inputEmail3">QTY
                                        Pakai :</label>
                                    <input class="form-control input-sm " id="QtyPakai" name="QtyPakai" type="number" value="1" readonly>
                                </div>
                                
                                <div class="form-group col-md-2" style="margin-left:1em">
                                    <label for="inputEmail3">Expired Date</label>
                                    <input class="form-control input-sm " id="ExpiredDate" name="ExpiredDate" type="datetime-local">
                                </div>
                                <div class="form-group col-md-2" style="margin-left:1em">
                                    <label for="inputEmail3">Barcode</label>
                                    <input class="form-control input-sm " id="Barcode" name="Barcode" type="text">
                                </div>
                                <div class="form-group col-md-1" style="margin-left:1em; margin-top:-8px">
                                    <a class="btn btn-primary" title="Tambah Baris" id="btnAdd" name="btnAdd" style="margin-top: 30px;">
                                        <i class="fa fa-plus-square"></i> Add</a>
                                </div> -->

                                <!-- <div class="form-group"> 
                                    <br> 
                                    <br> 
                                    <label for="nama pasien" class="col-sm-5 control-label" 
                                        style="margin-right:12em;float:right;"><button type="submit" name="tandatangan" 
                                            id="tandatangan" class="btn btn-primary"><i class="fa fa-save"></i> 
                                            Save Data 
                                        </button> <a onclick="MyBack()" class="btn btn-warning waves-effect" 
                                            id="btnBack" name="btnBack"><span class="glyphicon glyphicon glyphicon-home" 
                                                aria-hidden="true"></span> 
                                            Kembali</a></label> 
                                </div> -->
                            </form>

                            <form id="form_payment_closing">
                                <div class="form-group">
                                    <div class="panel-title">
                                        <span class="glyphicon glyphicon-list"></span> List
                                    </div>

                                    <div class="demo-table" style="overflow-x:auto;">
                                        <table id="list_orderbloods" class="display" width="100%">
                                            <thead>
                                                <tr>
                                                    <th align='center'>
                                                        <font size="1">ID
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Nama Tarif Darah
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Qty CC
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Qty Order
                                                    </th>
                                                    <th align='center'>
                                                        <font size="1">Action
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
                            <label for="nama pasien" class="col-sm-10 control-label">
                            </label>
                            <button type="submit" name="btn_simpan" id="btn_simpan" class="btn btn-success"><i class="fa fa-save"></i>
                                Simpan
                            </button>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);">
    <div class="modal-dialog  modal-SM" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Silahkan Isi Kebutuhan Order</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <label for="inputEmail3" class="col-sm-2 control-label">ID Detail :</label>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="IDDetail" name="IDDetail" type="text" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label">Qty Order :</label>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="QTYDetail" name="QTYDetail" type="text">
                        </div>
                    </div>
                    <div class="form-group form-horizontal">
                        <label for="inputEmail3" class="col-sm-2 control-label">Qty CC :</label>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="QTYCC" name="QTYCC" type="text" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                        data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnModalSrcPasienClose" onclick="SubmitQtyOrder()"><i class="fa fa-save"></i>Save</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>

<!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.section -->
</div>

<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/odc/ReviewOrderDarah.js"></script>