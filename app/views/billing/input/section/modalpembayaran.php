<div class="modal fade" id="modal_payment" role="dialog">
    <div class="modal-dialog modal-lg" style="width:80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Pembayaran</h4>
            </div>
            <div class="modal-body">

                <div class="from-group row">
                    <div class="col-sm-6">
                        <label for="tipepembayaran">Metode Pembayaran</label>
                        <select name="tipepembayaran" id="tipepembayaran" class="form-control" style="width:100%"
                            onchange="getBillto(this.value);getEDC(this.value);getKDREKENING(this.value);">
                        </select>
                    </div>
                </div>
                <br>

                <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                    <form id="form_sumtarif_all">
                        <table id="tbl_rincianbiaya_payment" name="tbl_rincianbiaya_payment" width="100%"
                            class="table table-striped table-hover cell-border">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        <font size="1">
                                    </th>
                                    <th align='center'>
                                        <font size="1">No
                                    </th>
                                    <th align='center'>
                                        <font size="1">NO TRS
                                    </th>
                                    <th align='center'>
                                        <font size="1">TGL BILL
                                    </th>
                                    <th align='center'>
                                        <font size="1">Nama Tarif
                                    </th>
                                    <th align='center'>
                                        <font size="1">Total Tarif
                                    </th>
                                    <th align='center'>
                                        <font size="1">Sub Total
                                    </th>
                                    <!-- <th align='center'>
                                    <font size="1">Group
                                </th> -->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <thead>
                                <tr>
                                    <th colspan="6"></th>
                                    <th align="center"><button type="button" class="btn btn-success btn-xs"
                                            id="cb_tarifall" name="cb_tarifall" onclick="btnSumTarif(this)"><span
                                                class="glyphicon glyphicon-check"></span>
                                            All </button></th>
                                </tr>
                            </thead>
                        </table>
                    </form>
                </div>
                <!-- <button type="button" title="Edit Tanggal Yang Dipilih" class="btn btn-default btn-xs" id="cb_editdtl" name="cb_editdtl" onclick="BtnSubmitBayar(this)"><span class="glyphicon glyphicon-check"></span> Bayar</button> -->
                <hr>

                <div class="panel-title small">
                    <span class="glyphicon glyphicon-save"></span> Input Pembayaran
                </div>
                <div class="panel-body">
                    <div class="from-group row">
                        <div class="col-sm-2">
                            <label for="tipepembayaran">Tanggal Payment</label>
                            <input class="form-control input-sm" id="tglpayment" name="tglpayment" type="date">
                        </div>
                    </div>

                    <div class="from-group row">

                        <div id="cash_ui" style="display: none">
                            <div class="col-sm-3" id="telahterima_ui">
                                <label for="rj_disc_lab">Telah Terima Dari</label>
                                <input class="form-control input-sm" id="billto" name="billto" type="text">
                                <input class="form-control input-sm" id="kodejaminan" name="kodejaminan" type="hidden">
                            </div>
                            <div class="col-sm-3" id="telahterima_ui2">
                                <label for="perusahaanjpk">Nama Perusahaan</label>
                                <select name="perusahaanjpk" id="perusahaanjpk" class="form-control" style="width:100%"
                                    onchange="passingVal(this)">
                                </select>
                            </div>
                            <div class="col-sm-3" id="telahterima_ui3">
                                <label for="perusahaanasuransi">Nama Asuransi</label>
                                <select name="perusahaanasuransi" id="perusahaanasuransi" class="form-control"
                                    style="width:100%" onchange="passingVal(this)">
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="rj_disc_radiologi">Amount</label>
                                <input class="form-control input-sm" id="totalinput" name="totalinput" type="number">
                            </div>
                        </div>

                    </div>

                    <div class="from-group row" id="card_ui" style="display: none">

                        <div class="col-sm-3">
                            <label for="rj_disc_radiologi">EDC</label>
                            <select name="namabank" id="namabank" class="form-control" style="width:100%">
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label for="rj_disc_radiologi">Tipe Kartu</label>
                            <select name="tipekartu" id="tipekartu" class="form-control input-sm">
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
                            <input class="form-control input-sm" id="nokartu" name="nokartu" type="text">
                        </div>
                        <div class="col-sm-3">
                            <label for="rj_disc_radiologi">Total Gesek</label>
                            <input class="form-control input-sm" id="gesek" name="gesek" type="number">
                        </div>
                        <input class="form-control input-sm" id="kd_rekening" name="kd_rekening" type="hidden">

                    </div>

                    <a class="btn btn-primary" title="Tambah Baris" id="add_row" name="add_row"
                        style="margin-top: 30px;">
                        <i class="fa fa-plus-square"></i> Add</a>

                    <hr>

                    <form id="form_payment">
                        <div class="form-group">
                            <div class="panel-title">
                                <span class="glyphicon glyphicon-list"></span> List Pembayaran
                            </div>
                            <!-- tabel------------>
                            <!-- <div class="table-responsive"> -->
                            <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                                <table class="table" id="list_payment">
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
                                    <tbody id="user_data">
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th colspan="8">
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

                        </div>

                </div>


                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="" class="btn btn-primary" id="savetrs_payment" name="savetrs_payment"><i
                        class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>