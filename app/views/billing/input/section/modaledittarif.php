
<!-- Modal Klaim ------------------------------------------------>
<div class="modal fade" id="edittarif_modal" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="m odal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Edit Tarif </h4>
                <form id="form_klaim">
            </div>
            <div class="modal-body">
                <input type="hidden" id="me" />

                <div class="row" style="margin-bottom:3px;">
                    <label class="col-sm-2 col-form-label">ID</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" id="id_details" name="id_details" type="text" readonly />
                    </div>

                    <label class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" id="tarif" name="tarif" type="text" />
                    </div>
                </div>

                <div class="row" style="margin-bottom:3px;">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" id="nama" name="nama" type="text" readonly />
                    </div>

                    <label class="col-sm-2 col-form-label">Subtotal</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" id="total_tarif" name="total_tarif" type="text" readonly />
                    </div>
                </div>

                <hr style="border-color:#dbdbdb;">
                <div class="row" style="margin-bottom:3px;">
                    <label class="col-sm-2 col-form-label">Dokter Pemeriksa</label>
                    <div class="col-sm-4">
                        <select class="form-control input-sm" id="dokterpemeriksa_edit" name="dokterpemeriksa_edit"
                            style="width:100%">

                        </select>
                    </div>

                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" id="tgledit" name="tgledit" type="date" />
                    </div>

                    <!--<a style="background-color:#849c2d;" class="btn" id="btn_dokteroperasi" name="btn_dokteroperasi" hidden>Submit Dokter</a>-->
                </div>

                <div class="row" style="margin-bottom:3px;">
                    <label class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-4">
                        <select class="form-control input-sm" id="kelasedit" name="kelasedit">
                        </select>
                    </div>

                    <label class="col-sm-2 col-form-label">Qty</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" id="qtyedit" name="qtyedit" type="text" />
                    </div>
                </div>

                <hr style="border-color:#dbdbdb;">

                <div class="row" style="margin-bottom:3px;">
                    <label class="col-sm-2 col-form-label">Bayar</label>
                    <div class="col-sm-10">
                        <input class="form-control input-sm" id="bayar" name="bayar" type="number" readonly />
                    </div>
                </div>

                <div class="row" style="margin-bottom:3px;">
                    <label class="col-sm-2 col-form-label">Input Klaim (%)</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control input-sm" id="input_klaim" name="input_klaim"
                            type="number" placeholder="Percentage (%)" min="1" max="100" size="1" maxlength="2" />
                    </div>

                    <label class="col-sm-2 col-form-label">Input Klaim Value</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" id="total_klaim" name="total_klaim" type="number" />
                    </div>
                </div>
                <div style="float:left;margin:6px">
                    <a style="background-color:#e6be3e;" class="btn btn-sm" id="btn_fullklaim" name="btn_fullklaim"
                        disabled>Full Klaim</a>
                    <a style="background-color:#36b5a6;" class="btn btn-sm" id="btn_fullbayar" name="btn_fullbayar"
                        disabled>Full Bayar</a>
                </div>
                <a data-dismiss="" class="btn btn-primary btn-sm" id="btn_klaim" name="btn_klaim"
                    style="float:right">Partial Klaim</a>
                <br>
                <hr style="border-color:#bdbdbd;">
                <span class="label label-success">Diskon</span><br>
                <div class="row" style="margin-bottom:3px;">
                    <label class="col-sm-2 col-form-label">Input Diskon (%)</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control input-sm" id="input_diskon" name="input_diskon"
                            type="number" placeholder="Percentage (%)" min="1" max="100" size="1" maxlength="2" />
                    </div>

                    <label class="col-sm-2 col-form-label">Input Diskon Value</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" id="input_diskon_value" name="input_diskon_value"
                            type="number" />
                    </div>
                </div>
                <a class="btn btn-success btn-sm" id="btn_add_discount_details" name="btn_add_discount_details"
                    style="float: right">Submit Diskon</a>
                <br>


                </form>
            </div>
            <div class="modal-footer">
                <a data-dismiss="" class="btn btn-primary" id="btn_saveeditbill" name="btn_saveeditbill"><span
                        class="glyphicon glyphicon-floppy-disk"></span> Save</a>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Klaim---------------------------->
