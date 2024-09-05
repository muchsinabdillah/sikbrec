<!-- Modal Approve Radiology------------------------------------------------>
<div class="modal fade" id="approvemodalRad" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Approve Radiology</h4>
            </div>
            <div class="modal-body">
                <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                    <form id="form_approveRad">
                        <table class="table table-bordered table-striped table-hover dataTable"
                            id="tbl_approveRadiology" style="width:100%">
                            <thead>
                                <tr>
                                    <th align="center"></th>
                                    <th align="center">ID</th>
                                    <th align="center">Tgl Order</th>
                                    <th align="center">User Order</th>
                                    <th align="center">Nama Item</th>
                                    <th align="center">Accession Number</th>
                                    <th align="center">Total</th>
                                    <th align="center">Status</th>
                                    <th align="center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="8"></th>
                                    <th align="center"><button type="button" title="Approve Yang Dipilih"
                                            class="btn btn-success btn-xs" id="cb_approveRadiologyall"
                                            name="cb_approveRadiologyall" onclick="BtnApproveRad(this)"><span
                                                class="glyphicon glyphicon-check"></span> All </button>&nbsp<button
                                            type="button" itle="Batal Approve Yang Dipilih"
                                            class="btn btn-danger btn-xs" id="cb_btlapproveRadiologyall"
                                            name="cb_btlapproveRadiologyall" onclick="BtnApproveRad(this)"><i
                                                class="fa fa-ban"></i>All</button></th>
                                </tr>
                            </tfoot>
                        </table>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a> -->
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal"
                    onclick="btnrRefershTable()"><i class="fa fa-times"></i>Close</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Approve--------------------------------------------->