<!-- Modal Approve Bank Darah------------------------------------------------>
<div class="modal fade" id="approvemodalBDRS" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Approve Bank Darah</h4>
            </div>
            <div class="modal-body">
                <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                    <form id="form_approveBDRS">
                        <table class="table table-bordered table-striped table-hover dataTable" id="tbl_approveBDRS" style="width:100%">
                            <thead>
                                <tr>
                                    <th align="center">ID</th>
                                    <th align="center">Tgl Order</th>
                                    <th align="center">User Order</th>
                                    <th align="center">Nama Item</th>
                                    <th align="center">Keterangan</th>
                                    <!-- <th align="center">Total</th> -->
                                    <th align="center">Status</th>
                                    <th align="center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <!-- <tr>
                                    <th colspan="8"></th>
                                    <th align="center"><button type="button" title="Approve Yang Dipilih"
                                            class="btn btn-success btn-xs" id="cb_approveBDRSall"
                                            name="cb_approveBankDarahall" onclick="BtnApproveBDRS(this)"><span
                                                class="glyphicon glyphicon-check"></span> All </button>&nbsp<button
                                            type="button" itle="Batal Approve Yang Dipilih"
                                            class="btn btn-danger btn-xs" id="cb_btlapproveBankDarahall"
                                            name="cb_btlapproveBDRSall" onclick="BtnApproveBDRS(this)"><i
                                                class="fa fa-ban"></i>All</button></th>
                                </tr> -->
                            </tfoot>
                        </table>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a> -->
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal" onclick="btnrRefershTable()"><i class="fa fa-times"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Approve--------------------------------------------->

<!-- Modal Approve Detail------------------------------------------------>
<div class="modal fade" id="approvemodalBDRSdetail" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Approve Bank Darah Detail</h4>
                <input type="hidden" id="bdrsidxx" name="bdrsidxx">
            </div>
            <div class="modal-body">
                <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                    <form id="form_approvebdrs_detail">
                        <table class="table table-bordered table-striped table-hover dataTable" id="tbl_approvebdrs_detail" style="width:100%">
                            <thead>
                                <tr>
                                    <th align="center"></th>
                                    <th align="center">ID</th>
                                    <th align="center">Nama Item</th>
                                    <th align="center">Harga</th>
                                    <th align="center">Aktif/Batal</th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th colspan="4"></th>
                                    <th align="center"><button type="button" title="Approve Yang Dipilih" class="btn btn-success btn-xs" id="cb_approveBDRSall" name="cb_approveBankDarahall" onclick="BtnApproveBDRS(this)"><span class="glyphicon glyphicon-check"></span> All </button>&nbsp<button type="button" itle="Batal Approve Yang Dipilih" class="btn btn-danger btn-xs" id="cb_btlapproveBankDarahall" name="cb_btlapproveBDRSall" onclick="BtnApproveBDRS(this)"><i class="fa fa-ban"></i>All</button></th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe"
                    onclick="btnrRefershTable()">Close</a> -->
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal" onclick="btnrRefershTable()"><i class="fa fa-times"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Approve--------------------------------------------->