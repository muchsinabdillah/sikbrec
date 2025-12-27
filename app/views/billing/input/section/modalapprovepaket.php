<!-- Modal Approve PAKET MCU------------------------------------------------>
<div class="modal fade" id="approvemodalpaket"  role="dialog">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Approve Paket MCU</h4>
            </div>
            <div class="modal-body">
                <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                    <form id="form_approvePaketMCU">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label" style="margin-top: -1em;"> ID Paket
                                / ID Tarif</label>
                            <div class="col-sm-2" style="margin-top: -1em;">
                                <input class="form-control input-sm" type="input" id="IDPaketMCU" readonly
                                    name="IDPaketMCU">
                            </div>
                            <div class="col-sm-2" style="margin-top: -1em;">
                                <input class="form-control input-sm" type="input" id="IDPaketTarif" readonly
                                    name="IDPaketTarif">
                                <input class="form-control input-sm" type="hidden" id="Lab_kodeTes_kelompok" readonly
                                    name="Lab_kodeTes_kelompok">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label" style="margin-top: -1em;"> Nama
                                Paket</label>
                            <div class="col-sm-4" style="margin-top: -1em;">
                                <input class="form-control input-sm" type="input" id="namapaket" readonly
                                    name="namapaket">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-top: 1em;"> Nilai
                                Tarif Paket</label>
                            <div class="col-sm-4" style="margin-top: 1em;">
                                <input class="form-control input-sm " id="HargaPaket" name="HargaPaket" type="input"
                                    readonly>
                            </div>
                            <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-top: 1em;"> Status
                            </label>
                            <div class="col-sm-4" style="margin-top: 1em;">
                                <span id="StatusOrder" name="StatusOrder" class="badge"></span>
                            </div>
                            <label for=" inputEmail3" class="col-sm-12 control-label" style="margin-top: 1em;"></label>
                        </div>

                        </br>


                        <table class="table table-bordered table-striped table-hover dataTable" id="tbl_approvepaketmcu"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th align="center">No</th>
                                    <th align="center">Pemeriksaan</th>
                                    <th align="center">Lokasi Pemeriksaan</th>
                                    <th align="center">Penunjang</th>
                                    <th align="center">Tarif</th>
                                    <!-- <th align="center">Action</th> -->
                                </tr>
                            </thead>
                            <!-- <tfoot>
                                <tr>
                                    <th colspan="7"></th>
                                    <th align="center"><button type="button" title="Approve Yang Dipilih"
                                            class="btn btn-success btn-xs" id="cb_approvefarmasiall"
                                            name="cb_approvefarmasiall" onclick="BtnApprove(this)"><span
                                                class="glyphicon glyphicon-check"></span> All </button>&nbsp<button
                                            type="button" title="Batal Approve Yang Dipilih"
                                            class="btn btn-danger btn-xs" id="cb_btlapprovefarmasiall"
                                            name="cb_btlapprovefarmasiall" onclick="BtnApprove(this)"><i
                                                class="fa fa-ban"></i>All</button></th>
                                </tr>
                            </tfoot> -->
                        </table>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a> -->
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal"
                    onclick="btnrRefershTable()"><i class="fa fa-times"></i>Close</button>
                <!-- <button type="button" class="btn bg-red btn-wide" id="btnApprovePaketMCU"
                    onclick="btnApprovePaketMCU()"><i class="fa fa-times"></i>APPROVE</button> -->
                <button type="button" title="Approve Yang Dipilih" class="btn btn-warning btn-x"
                    id="cb_btlapprovePaketMC" name="cb_btlapprovePaketMC" onclick="btnBatalApprovePaketMCU()"><span
                        class="glyphicon glyphicon-trash"></span> BATAL APPROVE </button>
                <button type="button" title="Approve Yang Dipilih" class="btn btn-danger btn-x" id="cb_approvePaketMC"
                    name="cb_approvePaketMC" onclick="btnApprovePaketMCU()"><span
                        class="glyphicon glyphicon-check"></span> APPROVE </button>
                <!-- <button class="btn btn-warning  btn-rounded" data-toggle='modal' title="Print This Payment"
                    id="btn_openorclose_bill" type="button" onclick="btnApprovePaketMCU()">
                    <span class="glyphicon glyphicon-printx" aria-hidden="true">
                    </span>
                </button> -->

            </div>
        </div>
    </div>
</div>
<!--#END Modal Approve--------------------------------------------->