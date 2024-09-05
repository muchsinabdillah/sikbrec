<!-- Modal Payment ------------------------------------------------>
<div class="modal fade" id="modal_payment_closing" role="dialog">
    <div class="modal-dialog modal-lg" style="width:80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Closing Pembayaran</h4>
            </div>
            <div class="modal-body">

                <br>
                <form class="form-horizontal" id="frmDataSummaryTotal">
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-1 control-label"> Administrasi</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="T_Administrasi" id="T_Administrasi" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label"> Konsultasi </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="T_Konsultasi" name="T_Konsultasi" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label"> Tindakan </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="T_Tindakan" name="T_Tindakan" readonly>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-1 control-label"> Radiologi </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="T_Radiologi" name="T_Radiologi" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label"> Farmasi </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="T_Farmasi" name="T_Farmasi" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label"> Laboratorium </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="T_Laboratorium" name="T_Laboratorium" readonly>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-1 control-label"> Total Tagihan </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="T_Tagihan" name="T_Tagihan" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label"> Total Klaim</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="T_Klaim" id="T_Klaim" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label"> Total Bayar </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="T_Bayar" name="T_Bayar" readonly>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-1 control-label"> Sisa Bayar</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="T_SisaBayar" id="T_SisaBayar" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label"> Diskon Global </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="T_DiskonGlobal" name="T_DiskonGlobal" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label"> Keterangan Diskon </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="T_KetDiskon" name="T_KetDiskon" readonly>
                        </div>
                    </div>

                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-1 control-label"> Grand Total</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="T_GrandTotal" id="T_GrandTotal" readonly>
                        </div>
                    </div>

                </form>

                <div class="panel-title small">
                    <span class="glyphicon glyphicon-save"></span> Input Pembayaran
                </div>
                <div class="panel-body">
                    <div class="from-group row">
                        <div class="col-sm-2">
                            <label for="tipepembayaran">Tanggal Payment</label>
                            <input class="form-control input-sm" id="tglpayment_closing" name="tglpayment_closing"
                                type="date">
                        </div>
                    </div>

                    <div class="from-group row">


                        <div class="col-sm-6">
                            <label for="tipepembayaran">Metode Pembayaran</label>
                            <select name="tipepembayaran_closing" id="tipepembayaran_closing" class="form-control"
                                style="width:100%"
                                onchange="getBillto_closing(this.value);getEDC(this.value);getKDREKENING(this.value);">
                            </select>
                        </div>

                        <div id="cash_ui_closing" style="display: none">
                            <div class="col-sm-3" id="telahterima_ui_closing">
                                <label for="rj_disc_lab">Telah Terima Dari</label>
                                <input class="form-control input-sm" id="billto_closing" name="billto_closing"
                                    type="text">
                                <input class="form-control input-sm" id="kodejaminan_closing" name="kodejaminan_closing"
                                    type="hidden">
                            </div>
                            <div class="col-sm-3" id="telahterima_ui2_closing">
                                <label for="perusahaanjpk">Nama Perusahaan</label>
                                <select name="perusahaanjpk_closing" id="perusahaanjpk_closing" class="form-control"
                                    style="width:100%" onchange="passingVal_closing(this)">
                                </select>
                            </div>
                            <div class="col-sm-3" id="telahterima_ui3_closing">
                                <label for="perusahaanasuransi">Nama Asuransi</label>
                                <select name="perusahaanasuransi_closing" id="perusahaanasuransi_closing"
                                    class="form-control" style="width:100%" onchange="passingVal_closing(this)">
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="rj_disc_radiologi">Amount</label>
                                <input class="form-control input-sm" id="totalinput_closing" name="totalinput_closing"
                                    type="number">
                            </div>
                        </div>

                    </div>

                    <div class="from-group row" id="card_ui_closing" style="display: none">

                        <div class="col-sm-3">
                            <label for="rj_disc_radiologi">EDC</label>
                            <select name="namabank_closing" id="namabank_closing" class="form-control"
                                style="width:100%">
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label for="rj_disc_radiologi">Tipe Kartu</label>
                            <select name="tipekartu_closing" id="tipekartu_closing" class="form-control input-sm">
                                <option value="">-- Pilih --</option>
                                <option value="VISA">VISA</option>
                                <option value="MASTERCARD">MASTERCARD</option>
                                <option value="BCA CARD">BCA CARD</option>
                                <option value="VISA ELEKTRON">VISA ELEKTRON</option>
                                <option value="GPN">GPN</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="rj_disc_radiologi">No Kartu</label>
                            <input class="form-control input-sm" id="nokartu_closing" name="nokartu_closing"
                                type="text">
                        </div>
                        <div class="col-sm-3">
                            <label for="rj_disc_radiologi">Total Gesek</label>
                            <input class="form-control input-sm" id="gesek_closing" name="gesek_closing" type="number">
                        </div>
                        <input class="form-control input-sm" id="kd_rekening_closing" name="kd_rekening_closing"
                            type="hidden">

                    </div>

                    <a class="btn btn-primary" title="Tambah Baris" id="add_row_closing" name="add_row_closing"
                        style="margin-top: 30px;">
                        <i class="fa fa-plus-square"></i> Add</a>

                    <hr>

                    <form id="form_payment_closing">
                        <div class="form-group">
                            <div class="panel-title">
                                <span class="glyphicon glyphicon-list"></span> List Pembayaran
                            </div>
                            <!-- tabel------------>
                            <div class="table-responsive">
                                <table class="table" id="list_payment_closing">
                                    <thead>
                                        <tr>
                                            <th>
                                                <font size="1">Tipe Pembayaran</font>
                                            </th>
                                            <th>
                                                <font size="1">Telah Terima Dari</font>
                                            </th>
                                            <th>
                                                <font size="1">Ammount</font>
                                            </th>
                                            <th>
                                                <font size="1">EDC</font>
                                            </th>
                                            <th>
                                                <font size="1">Tipe Kartu</font>
                                            </th>
                                            <th>
                                                <font size="1">No Card</font>
                                            </th>
                                            <th>
                                                <font size="1">Total Gesek</font>
                                            </th>
                                            <th>
                                                <font size="1">Kode Rekening</font>
                                            </th>
                                            <th>
                                                <font size="1">Action</font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="user_data_closing">
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th colspan="8">
                                                <font size="1"></font>
                                            </th>

                                            <th>
                                                <font size="1">
                                                    <div id="grantotalOrder_closing"></div>
                                                </font>
                                                <input type="hidden" name="totalrow_closing" id="totalrow_closing"
                                                    class="form-control totalrow" />

                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                </div>


                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="" class="btn btn-primary" id="savetrs_payment_closing"
                    name="savetrs_payment_closing"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Payment ------------------------>