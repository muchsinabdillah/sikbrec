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
                            <form action="<?= BASEURL ?>/signatureDigital/SprtoPDF" method="POST"
                                class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">ID Order / No. MR :</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="id_Order" name="id_Order" type="text"
                                            value="<?= $data['id'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="no_MR" name="no_MR" type="text"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Pasien / Jenis Kelamin
                                        :</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="nama_Pasien" name="nama_Pasien"
                                            type="text" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="Gender" name="Gender" type="text"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">No. Episode / No. Reg
                                        :</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="no_Eps" name="no_Eps" type="text"
                                            readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="no_Reg" name="no_Reg" type="text"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Domisili / Tgl Lahir
                                        :</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="Domisili" name="Domisili" type="text"
                                            readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="Tgl_Lahir" name="Tgl_Lahir"
                                            type="date" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tgl Order / User Entry
                                        :</label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="tgl_Order" name="tgl_Order"
                                            type="text" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="user_Entry" name="user_Entry"
                                            type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jaminan :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="nama_Jaminan" name="nama_Jaminan"
                                            type="text" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Instalasi / Ruang :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="Ruang" name="Ruang" type="text"
                                            readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">DPJP :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="dokter_DPJP" name="dokter_DPJP"
                                            type="text" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">User Order :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="user_Order" name="user_Order"
                                            type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Diagnosis :</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="dokter_DPJP" name="dokter_DPJP"
                                            type="text" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Order :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="JenisOrder" name="JenisOrder"
                                            type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Berat Badan (kg) :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="BeratBadan" name="BeratBadan"
                                            type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Hb Saat Ini (gr/dl)
                                        :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="HbSaatIni" name="HbSaatIni"
                                            type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Hb Target (gr/dl) :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="HbTarget" name="HbTarget" type="text"
                                            readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Gol Darah :</label>
                                    <div class="col-sm-1">
                                        <select class="form-control input-sm " name="GolonganDarah" id="GolonganDarah">
                                            <option value="">--Pilih--</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Rhesus :</label>
                                    <div class="col-sm-1">
                                        <select class="form-control input-sm " name="Rhesus" id="Rhesus">
                                            <option value="">--Pilih--</option>
                                            <option value="+">+</option>
                                            <option value="-">-</option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Trombosit Saat Ini :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="TrombositSaatIni"
                                            name="TrombositSaatIni" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Trombosit Target :</label>
                                    <div class="col-sm-1">
                                        <input class="form-control input-sm " id="TrombositTarget"
                                            name="TrombositTarget" type="text" readonly>
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
                                <ul class="nav nav-tabs border-bottom border-primary">
                                    <li class="active"><a data-toggle="tab" href="#transaksi_order">Pemakaian</a></li>
                                    <li><a data-toggle="tab" href="#transaksi_arsip" id="btntabhistorylab">History
                                            Pemeriksaan Lab</a></li>
                                    <li><a data-toggle="tab" href="#tranfusi_arsip" id="btntranfusi_arsip">List Riwayat
                                            Tranfusi</a></li>
                                    <li><a data-toggle="tab" href="#UploadDocument" id="btntranfusi_arsip">Upload
                                            Document</a></li>

                                </ul>
                                <div class="tab-content bg-white p-15">
                                    <div id="transaksi_order" class="tab-pane fade in active">
                                        <br>
                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Pakai
                                                :</label>
                                            <div class="col-sm-3">
                                                <input class="form-control input-sm " id="tgl_Pakai" name="tgl_Pakai"
                                                    type="datetime-local">
                                            </div>
                                            <div class="col-sm-1">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="ket_order" name="ket_order"
                                                    type="text">
                                            </div>
                                        </div>

                                        <div class="form-group gut">
                                            <label for="inputEmail3" class="col-sm-2 control-label">History
                                                Incompatibility :</label>
                                            <div class="col-sm-3">
                                                <!-- <input class="form-control input-sm " id="incompatibility" name="incompatibility" type="text" placeholder="Mayor / Minor"> -->
                                                <!-- badrul -->
                                                <select class="form-control input-sm " name="incompatibility"
                                                    id="incompatibility">
                                                    <option value="">--Pilih--</option>
                                                    <option value="Compatible">Compatible</option>
                                                    <option value="Incompatible ">Incompatible </option>
                                                </select>
                                                <!-- badrul -->
                                            </div>
                                            <div class="col-sm-1">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2 control-label">Auto Control
                                                :</label>
                                            <div class="col-sm-4">
                                                <input class="form-control input-sm " id="autocontrol"
                                                    name="autocontrol" type="text">
                                            </div>

                                            <label for="inputEmail3" class="col-sm-2 control-label">Screening Anti Body
                                                :</label>
                                            <div class="col-sm-3">
                                                <select class="form-control input-sm " name="ScreeningAntiBody"
                                                    id="ScreeningAntiBody">
                                                    <option value="">--Pilih--</option>
                                                    <option value="Tidak Dilakukan">Tidak dilakukan Screning AB</option>
                                                    <option value="Negatif ">Negatif ( Tidak ditemukan adanya Irreguler
                                                        AB)</option>
                                                    <option value="Positif ">Positif ( Ditemukan adanya Irreguler AB)
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <br>
                                        <button type="button" class="btn btn-info  waves-effect" id="btnNewTransaksi"
                                            name="btnNewTransaksi"><span class="glyphicon glyphicon-plus"
                                                aria-hidden="true"></span> New Transaction</button>
                                        &nbsp&nbsp&nbsp&nbsp
                                        <button type="button" class="btn btn-default  waves-effect" id="btnOrderLab"
                                            name="btnOrderLab"> Tambahan Pemeriksaan</button>
                                        <br><br>
                                        <div class="form-group" style="margin-left:-2em">
                                            <label for="inputEmail3" class="col-sm-1 control-label">No Transaksi</label>
                                            <div class="col-sm-2">
                                                <!-- <input class="form-control input-sm " id="NoOrderTransaksi" name="NoOrderTransaksi" value="<?= $data['id'] ?>" type="text" readonly> -->
                                                <input class="form-control" id="NoOrderTransaksi"
                                                    name="NoOrderTransaksi" type="text"
                                                    value="<?= $data['iduseblood'] ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputEmail3">Jenis Darah :</label>
                                            <select name="ListOrderDarah" id="ListOrderDarah"
                                                style="width: 100%; margin-left:1em"
                                                onchange="getDataDetail(this.value)" class="form-control">
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3" style="margin-left:1em">
                                            <label for="inputEmail3">QTY
                                                Order :</label>
                                            <input class="form-control input-sm " id="Id_dtl" name="Id_dtl"
                                                type="hidden">
                                            <input class="form-control input-sm " id="IdTarifDarah" name="IdTarifDarah"
                                                type="hidden">
                                            <input class="form-control input-sm " id="NamaTarifDarah"
                                                name="NamaTarifDarah" type="hidden">
                                            <input class="form-control input-sm " id="Harga" name="Harga" type="hidden">
                                            <input class="form-control input-sm " id="Total" name="TotalTarif"
                                                type="hidden">
                                            <input class="form-control input-sm " id="QtyOrder" name="QtyOrder"
                                                type="text" readonly>
                                        </div>
                                        <div class="form-group col-md-2" style="margin-left:1em">
                                            <label for="inputEmail3">QTY
                                                Sisa :</label>
                                            <input class="form-control input-sm " id="QtySisa" name="QtySisa"
                                                type="text" readonly>
                                        </div>
                                        <div class="form-group col-md-2" style="margin-left:1em">
                                            <label for="inputEmail3">QTY
                                                Pakai :</label>
                                            <input class="form-control input-sm " id="QtyPakai" name="QtyPakai"
                                                type="number" value="1" readonly>
                                        </div>
                                        <div class="form-group col-md-2" style="margin-left:-1em">
                                            <label for="inputEmail3">Kantong Ke (No Urut)</label>
                                            <input class="form-control input-sm " id="KantongKe" name="KantongKe"
                                                type="number">
                                        </div>
                                        <div class="form-group col-md-2" style="margin-left:1em">
                                            <label for="inputEmail3">Expired Date</label>
                                            <input class="form-control input-sm " id="ExpiredDate" name="ExpiredDate"
                                                type="datetime-local">
                                        </div>
                                        <div class="form-group col-md-2" style="margin-left:1em">
                                            <label for="inputEmail3">Keterangan</label>
                                            <input class="form-control input-sm " id="KeteranganDtl"
                                                name="KeteranganDtl" type="text">
                                            <input class="form-control input-sm " id="QtyCC" name="QtyCC" type="hidden">
                                        </div>
                                        <div class="form-group col-md-2" style="margin-left:1em">
                                            <label for="inputEmail3">Barcode</label>
                                            <input class="form-control input-sm " id="Barcode" name="Barcode"
                                                type="text">
                                        </div>

                                        <div class="form-group col-md-1" style="margin-left:1em; margin-top:-8px">
                                            <a class="btn btn-primary" title="Tambah Baris" id="btnAdd" name="btnAdd"
                                                style="margin-top: 30px;">
                                                <i class="fa fa-plus-square"></i> Add</a>
                                        </div>

                                        <div class="form-group">
                                        </div>
                                        <hr>
                                        <br>
                                        <div class="panel-title">
                                            <span class="glyphicon glyphicon-list"></span> List
                                        </div>
                                        <div class="demo-table" style="overflow-x:auto;">
                                            <table id="list_useblooddetail" class="display" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th align='center' style="width:5%">
                                                            <font size="1">Kantong Ke
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Jenis Darah
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Qty
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Expired Date PMI
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Barcode
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Keterangan
                                                        </th>
                                                        <th align='center'>
                                                            <font size="1">Status
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
                                        <br>
                                        <div class="form-group">
                                            <!-- <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['id'] ?>"> -->
                                            <label for="inputEmail3" style="margin-left:-11em"
                                                class="col-sm-2 control-label">QTY
                                                Total :</label>
                                        </div>
                                        <div class="form-group" style="margin-top:-1em;">
                                            <div class="col-sm-3" style="margin-left:0em;">
                                                <input class="form-control input-sm " id="qtytotal" name="qtytotal"
                                                    type="text" readonly>
                                            </div>
                                            <label for="nama pasien" class="col-sm-6 control-label">
                                            </label>
                                            <button type="button" name="btn_simpan" id="btn_simpan"
                                                class="btn btn-success"><i class="fa fa-save"></i>
                                                Simpan
                                            </button>
                                            <button type="button" name="btn_batal" id="btn_batal"
                                                class="btn btn-danger"><i class="fa fa-trash-o"></i>
                                                Hapus
                                            </button>
                                            <a onclick="MyBack()" class="btn btn-warning waves-effect" id="btnBack"
                                                name="btnBack"><span class="glyphicon glyphicon glyphicon-home"
                                                    aria-hidden="true"></span>
                                                Close</a>
                                        </div>
                                    </div>
                                    <div id="transaksi_arsip" class="tab-pane fade">
                                        <br>
                                        <div class="form-group">
                                            <div class="panel-title">
                                                <span class="glyphicon glyphicon-list"></span> List History
                                            </div>

                                            <div class="demo-table" style="overflow-x:auto;">
                                                <table id="list_useblooddetail_arsip" class="display" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th align='center'>
                                                                <font size="1">No MR
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Pasien
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tanggal Lahir
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tanggal Order
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No. Lab
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No. Registrasi
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Jaminan
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Email / NoHP
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Tes
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Status Hasil
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

                                    <div id="tranfusi_arsip" class="tab-pane fade">
                                        <br>
                                        <div class="form-group">
                                            <div class="panel-title">
                                                <span class="glyphicon glyphicon-list"></span> List Riwayat Tranfusi
                                            </div>

                                            <div class="demo-table" style="overflow-x:auto;">
                                                <table id="list_tranfusi_arsip" class="display" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No Registrasi</th>
                                                            <th>No Episode</th>
                                                            <th>Jenis Darah</th>
                                                            <th>Tgl Pakai</th>
                                                            <th>User Pakai</th>
                                                            <th>Barcode</th>
                                                            <th>History Incompatibility</th>
                                                            <th>Auto Control</th>
                                                            <th>Screening Anti Body</th>
                                                            <th>Tranfusi Selesai</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="UploadDocument" class="tab-pane fade">
                                        <br>
                                        <div class="form-group">
                                            <div class="panel-title">
                                                <span class="glyphicon glyphicon-list"></span> Upload Document Pasien
                                            </div>
                                        </div>
                                        <button type="button" name="btn_upload" id="btn_upload"
                                            class="btn btn-success"><i class="fa fa-save"></i>
                                            Upload Document
                                        </button>
                                        <!-- <a onclick="frmUploadDocuments()" class="btn btn-warning waves-effect" id="btn_upload" name="btn_upload"><span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
                                        Close</a> -->

                                    </div>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Hand Over Petugas BDRS Dengan Perawat</h4>
            </div>
            <form class="form-horizontal" id="formhandover">
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group form-horizontal">
                            <input class="form-control input-sm " id="IDDetail" name="IDDetail" type="hidden" readonly>
                            <label for="inputEmail3" class="col-sm-2 control-label">Kantong Ke :</label>
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="KantongKeHO" name="KantongKeHO" type="text"
                                    readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Jenis Darah :</label>
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="JenisDarahHO" name="JenisDarahHO" type="text"
                                    readonly>
                            </div>

                        </div>
                        <div class="form-group form-horizontal">
                            <label for="inputEmail3" class="col-sm-2 control-label">Qty :</label>
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="QtyPakaiHO" name="QtyPakaiHO" type="text"
                                    readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                            <div class="col-sm-4">
                                <input class="form-control input-sm " id="KetHO" name="KetHO" type="text" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group form-horizontal">
                            <label for="inputEmail3" class="col-sm-2 control-label">Barcode</label>
                            <div class="col-sm-8">
                                <input class="form-control input-sm" id="BarcodeHO" name="BarcodeHO" type="text">
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-primary" id="add_row">Add</button>
                            </div>
                        </div>
                        <!-- tabel------------>
                        <div class="table-responsive">
                            <table class="table" id="list_usebarcode">
                                <thead>
                                    <tr>
                                        <th>
                                            <font size="1">Jenis Darah</font>
                                        </th>
                                        <th>
                                            <font size="1">Qty</font>
                                        </th>
                                        <th>
                                            <font size="1">Expired</font>
                                        </th>
                                        <th>
                                            <font size="1">Barcode</font>
                                        </th>
                                        <th>
                                            <font size="1">Terpakai</font>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="user_data">
                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="4">
                                            <font size="1"></font>
                                        </th>

                                        <th>
                                            <font size="1">
                                                <div id="grantotalOrder"></div>
                                            </font>
                                            <input type="hidden" name="totalrow" id="totalrow"
                                                class="form-control totalrow" />

                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <hr>
                        <div class="form-group form-horizontal">
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-info" id="btnPetugasBDRS"
                                    onclick="showModalNoPIN('BDRS')"> Input Petugas BDRS</button>
                            </div>
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-info" id="btnPetugasPerawat"
                                    onclick="showModalNoPIN('Perawat')"> Input Petugas Perawat</button>
                            </div>
                        </div>
                        <div class="form-group form-horizontal">
                            <div class="col-sm-3">
                                <input class="form-control input-sm" id="PetugasBDRS" name="PetugasBDRS" type="text"
                                    readonly>
                            </div>
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control input-sm" id="PetugasPerawat" name="PetugasPerawat"
                                    type="text" readonly>
                            </div>
                        </div>

                    </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="form-group form-horizontal">
                <label for="inputEmail3" class="col-sm-2 control-label">Tgl Hand Over</label>
                <div class="col-sm-3">
                    <input class="form-control input-sm" id="dateHO" name="dateHO" type="text" readonly>
                </div>
            </div>
            <!-- <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                        data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div> -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnModalSrcPasienClose"
                    onclick="SaveHandOver()"><i class="fa fa-save"></i>Save</button>
            </div>
            <!-- /.btn-group -->
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="modalNoPIN" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Input No PIN</h4>
            </div>
            <form class="form-horizontal" id="formInputNoPIN">
                <div class="modal-body">
                    <div class="form-horizontal">

                        <div class="form-group form-horizontal">
                            <input class="form-control input-sm " id="attribute" name="attribute" type="hidden">
                            <label for="inputEmail3" class="col-sm-4 control-label">No PIN :</label>
                            <div class="col-sm-6">
                                <input class="form-control input-sm " id="NoPIN_HO" name="NoPIN_HO" type="text">
                            </div>
                        </div>
                        <div class="form-group form-horizontal">
                            <label for="inputEmail3" class="col-sm-4 control-label">Password :</label>
                            <div class="col-sm-6">
                                <input class="form-control input-sm " id="Password_HO" name="Password_HO"
                                    type="password">
                            </div>
                        </div>

                    </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose"
                    data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnModalSrcPasienClose"
                    onclick="SaveTTDNoPIN()"><i class="fa fa-save"></i>Save</button>
            </div>
            <!-- /.btn-group -->
        </div>
    </div>
</div>
</div>

<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/odc/ViewOrderDarah.js"></script>