<div class="main-page">


    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5> Data <?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_hdr">
                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">No.Transaksi :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="No_Transaksi" id="No_Transaksi" value="<?= $data['id'] ?>" placeholder="Ketik No. Transaksi" readonly>
                                        <input type="hidden" class="form-control" name="action" id="action" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">No.Request :</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="No_Request" id="No_Request" placeholder="Masukkan No.Request" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Transaksi :</label>
                                    <div class="col-sm-4">
                                        <input type="datetime-local" class="form-control" name="Tgl_Transaksi" id="Tgl_Transaksi" placeholder="Masukkan Tanggal Transaksi" disabled>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Request :</label>
                                    <div class="col-sm-4">
                                        <input type="datetime-local" class="form-control" name="Tgl_Request" id="Tgl_Request" placeholder="Masukkan Tanggal Request" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">User Entri :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="User_Entri" id="User_Entri" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">User Request :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="User_Request" id="User_Request" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="PO_Keterangan" id="PO_Keterangan" placeholder="Ketik Keterangan Disini" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Unit Request :</label>
                                    <div class="col-sm-4">
                                    <input type="hidden" class="form-control" name="Unit_Request" id="Unit_Request">
                                        <select name="Unit_Requestx" id="Unit_Requestx" class="form-control" readonly>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Status :</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="Status" id="Status" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jenis Request :</label>
                                    <div class="col-sm-4">
                                    <input type="hidden" class="form-control" name="Jenis_Request" id="Jenis_Request">
                                        <select name="Jenis_Requestx" id="Jenis_Requestx" class="form-control" readonly>
                                            <option value="">-- PILIH --</option>
                                            <option value="1">FARMASI</option>
                                            <option value="2">LOGISTIK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Supplier :</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js-example-basic-single" id="PO_KodeSupplier" name="PO_KodeSupplier" style="width:100%" disabled>
                                        </select>
                                        <input type="hidden" class="form-control" autocomplete="off" name="approve_ke" id="approve_ke" value="<?= $data['approve_ke'] ?>" readonly>
                                    </div>
                                </div>
                            </form>

                            <hr>

                            <form id="user_form">
                                <div class="table-responsive demo-table" style="margin-top: 70px;">

                                <table id="example" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th align='center'>
                                                    <font size='1'>No</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Kode Barang</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Nama Barang</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Satuan</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Qty MR</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Qty Order</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Harga</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Disc (%) </font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Disc Rp</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Subtotal</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Tax (%)</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Tax (Rp)</font>
                                                </th>
                                                <th align='center'>
                                                    <font size='1'>Grand Total</font>
                                                </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>GRANDTOTAL
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </th>
                                    </tfoot>
                                </table>
                                </div>
                            </form>
                            <br>
                            <div class="btn-group" role="group">
                                <a class="btn btn-maroon waves-effect btn-rounded" id="btnSave" name="btnSave"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Approve</a>

                                <!-- <a class="btn btn-danger" id="pr_btn_batal" name="pr_btn_batal"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</a> -->

                                <a class="btn btn-gold btn-rounded" id="pr_btn_kembali" name="pr_btn_kembali" onclick="MyBack()"><i class="fa fa-home" aria-hidden="true"></i>Kembali</a>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.section -->
                </div>

                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Modal Approve ------------------------------------------------>
<div class="modal fade" id="Modal_Approve" tabindex="-1" role="dialog">

<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Data Approved</h4>
        </div>
    <br>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-2 control-label">No PIN:</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="nopin" id="nopin" placeholder="Isi No Pin Anda">
                    </div>
                </div>

                <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-2 control-label">Nama:</label>   <div class="col-sm-2">
                        <input type="text" class="form-control" name="nopin_ext" id="nopin_ext" readonly>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="nama_ext" id="nama_ext" readonly>
                    </div>
                </div>

                <div class="form-group gut">  
                <label for="inputEmail3" class="col-sm-3 control-label">Digital Sign:</label>
                <div class="col-sm-7">
                <embed src="" width="100px" height="100px" id="file" />

                </div>
                </div>
                    
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-maroon btn-sm " id="btnSearching" name="btnSearching" onclick="goSaveApprove()"> Approve</button>
            <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
        </div>

        <!--#END Modal Approve--------------------------------------------->
    </div>
</div>
<!-- /.col-md-12 -->
</div>

        </div>
        <!-- /.main-wrapper -->
        <!-- ========== COMMON JS FILES ========== -->
        <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
        <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
        <script src="<?= BASEURL; ?>/js/App/inventory/approve/view/ApprovePO_View.js"></script>