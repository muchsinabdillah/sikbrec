<!-- Modal Approve Farmasi------------------------------------------------>
<div class="modal fade" id="approvemodal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Approve Farmasi</h4>
            </div>
            <div class="modal-body">
                <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                    <form id="form_approve">
                        <table class="table table-bordered table-striped table-hover dataTable" id="tbl_approvefarmasi" style="width:100%">
                            <thead>
                                <tr>
                                    <th align="center"></th>
                                    <th align="center">Order ID</th>
                                    <th align="center">Tgl Resep</th>
                                    <th align="center">Jenis Resep</th>
                                    <th align="center">No Resep</th>
                                    <th align="center">Total Order</th>
                                    <th align="center">Status</th>
                                    <th align="center">Action</th>
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
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal" onclick="btnrRefershTable()"><i class="fa fa-times"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Approve--------------------------------------------->