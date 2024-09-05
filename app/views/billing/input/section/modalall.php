
    <!-- Modal -->
    <div class="modal fade modal-full-screen" id="modaltindakanbyorderLab" tabindex="-1" role="dialog"
        aria-labelledby="modal9Label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal9Label"> Unit Laboratorium Order <button type="button"
                            class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button></h4>
                </div>
                <div class="modal-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i
                                class="fa fa-times"></i>Close</button>
                        <button type="button" class="btn bg-success btn-wide btn-rounded"><i
                                class="fa fa-check"></i>Save</button>
                    </div>
                    <!-- /.btn-group -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-full-screen" id="modaltindakanbyorderRad" tabindex="-1" role="dialog"
        aria-labelledby="modal9Label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal9Label"> Unit Radiologi Order <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
                </div>
                <div class="modal-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"><i
                                class="fa fa-times"></i>Close</button>
                        <button type="button" class="btn bg-success btn-wide btn-rounded"><i
                                class="fa fa-check"></i>Save</button>
                    </div>
                    <!-- /.btn-group -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
   


<!-- Modal Chekcbox Edit Tanggal ------------------------------------------------>
<div class="modal fade" id="modal_cbedittanggal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Edit Tanggal Yang Dipilih</h4>
                <form id="form_cbeditbill_tgl">
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom:3px;">
                    <label for="noreg" class="col-sm-4 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <input class="form-control input-sm" type="date" id="cb_edittanggal" name="cb_edittanggal"
                            value="<?php echo date('Y-m-d') ?>">
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="" class="btn btn-primary" id="submit_cbeditbill_tgl"
                    name="submit_cbeditbill_tgl"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Chekcbox Edit Tanggal ------------------------>

<!-- Modal Chekcbox Edit Kelas ------------------------------------------------>
<div class="modal fade" id="modal_cbeditkelas" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Edit Kelas Yang Dipilih</h4>
                <form id="form_cbeditbill_kls">
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom:3px;">
                    <label for="noreg" class="col-sm-4 col-form-label">Kelas</label>
                    <div class="col-sm-8">
                        <select class="form-control js-example-basic-single" id="cb_editkelas" name="cb_editkelas"
                            style="width:100%">
                        </select>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="" class="btn btn-primary" id="cbeditbill_kls" name="cbeditbill_kls"><i
                        class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Chekcbox Edit Kelas ------------------------>

<!-- Modal Chekcbox Edit Qty ------------------------------------------------>
<div class="modal fade" id="modal_cbeditqty" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Edit Quantity Yang Dipilih</h4>
                <form id="form_cbeditbill_qty">
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom:3px;">
                    <label for="noreg" class="col-sm-4 col-form-label">Quantity</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="cb_editqty" name="cb_editqty">
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="" class="btn btn-primary" id="submit_cbeditbill_qty"
                    name="submit_cbeditbill_qty"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Chekcbox Edit Qty ------------------------>

<!-- Modal Chekcbox Edit Harga ------------------------------------------------>
<div class="modal fade" id="modal_cbeditharga" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Edit Harga Yang Dipilih</h4>
                <form id="form_cbeditbill_hrg">
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom:3px;">
                    <label for="noreg" class="col-sm-4 col-form-label">Harga</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="cb_editharga" name="cb_editharga">
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="" class="btn btn-primary" id="submit_cbeditbill_hrg"
                    name="submit_cbeditbill_hrg"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Chekcbox Edit Harga ------------------------>

<!-- Modal Chekcbox Edit Diskon ------------------------------------------------>
<div class="modal fade" id="modal_cbeditdiskon" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Edit Diskon Yang Dipilih</h4>
                <form id="form_cbeditbill_disc">
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom:3px;">
                    <label for="noreg" class="col-sm-4 col-form-label">Diskon</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="cb_editdiskon" name="cb_editdiskon">
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="" class="btn btn-primary" id="submit_cbeditbill_disc"
                    name="submit_cbeditbill_disc"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Chekcbox Edit Diskon ------------------------>

<!-- Modal Add Visit ------------------------------------------------>
<div class="modal fade" id="addtindakan_modal" role="dialog" width="100%">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Tambah Tindakan</h4>
                <form id="form_addvisitdetails">
            </div>
            <div class="modal-body">

                <div class="form-group gut">
                    <label for="inputsm">Nama Tindakan</label>
                    <select class="form-control js-example-basic-single" name="namatindakan" id="namatindakan"
                        style="width:100%" onchange="getTarifTindakan(this)">
                    </select>
                </div>

                <div class="form-group gut">
                    <label for="inputsm">Tanggal Tindakan</label>
                    <input type="date" name="date_tindakan_tambahan" id="date_tindakan_tambahan" style="width:100%">
                </div>

                <div class="form-group gut">
                    <label for="inputsm">Dokter Pemeriksa</label>
                    <select class="form-control js-example-basic-single" id="dokterpemeriksa" name="dokterpemeriksa"
                        style="width: 100%">
                    </select>
                </div>

                <div class="from-group row">
                    <div class="col-sm-3">
                        <label for="qty_addvisit">Qty</label>
                        <input class="form-control input-sm" id="qty_addvisit" name="qty_addvisit" type="text">
                    </div>
                    <div id="error_qty_addvisit"></div>
                    <div class="col-sm-3">
                        <label for="tarif_satuan_addvisit">Tarif Satuan</label>
                        <input class="form-control input-sm" id="total_tarif_addvisit_temp"
                            name="total_tarif_addvisit_temp" type="hidden" readonly>
                        <input class="form-control input-sm" id="tarif_satuan_addvisit" name="tarif_satuan_addvisit"
                            type="text" readonly>
                    </div>
                    <div id="error_tarif_satuan_addvisit"></div>
                    <div class="col-sm-3">
                        <label for="diskon_addvisit">Diskon (%)</label>
                        <input type="text" class="form-control input-sm" id="diskon_addvisit" name="diskon_addvisit"
                            type="number" placeholder="%" min="1" max="100" size="1" maxlength="3" />
                    </div>
                    <div id="error_diskon_addvisit"></div>
                    <div class="col-sm-3">
                        <label for="total_tarif_addvisit">Total Tarif</label>
                        <input class="form-control input-sm" id="total_tarif_addvisit" name="total_tarif_addvisit"
                            type="text" readonly>
                    </div>
                    <div id="error_total_tarif_addvisit"></div>
                </div>
                <input type="hidden" class="form-control" id="kode_dokterpemeriksa" name="kode_dokterpemeriksa" readonly
                    hidden />
                <input type="hidden" class="form-control" id="namaproduct_addvisit" name="namaproduct_addvisit" readonly
                    hidden />
                <input type="hidden" class="form-control" id="categoryproduct_addvisit" name="categoryproduct_addvisit"
                    readonly hidden />
                <input type="hidden" class="form-control" id="namadokter_addvisit" name="namadokter_addvisit" readonly
                    hidden />

                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="" class="btn btn-primary" id="btn_saveaddvisit" name="btn_saveaddvisit"><span
                        class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Visit--------------------------------------------->


