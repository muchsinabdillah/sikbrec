<div class="modal fade" id="TransferBill_Kabur" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> MODAL DETAIL HUTANG / REG IGD</h4>
            </div>
            <div class="modal-body">
                <div class="demo-table" width="100%" style="margin-top: 10px;overflow-x:auto; ">
                    <form id="form_PasienKabur">
                        <table class="table table-bordered table-striped table-hover dataTable" id="tbl_PasienKabur" style="width:100%">
                            <thead>
                                <tr>
                                    <th align="center">No</th>
                                    <th align="center">No. Reg</th>
                                    <th align="center">Tgl Bill</th>
                                    <th align="center">Total Kekurangan</th>
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
            <!-- onclick="BtnTindakanByUnit()" -->
            <div class="modal-footer">
                <button data-dismiss="" class="btn btn-primary" onclick="BtnTransferBill()"><i class="fa fa-money" aria-hidden="true"></i> TRANSFER KE
                    REGISTRASI SAAT INI</button>
                <!-- <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Tidak</a> -->
                <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal" onclick="btnrRefershTable()"><i class="fa fa-times"></i>Tidak</button>
            </div>
        </div>
    </div>
</div>