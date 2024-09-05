   <!-- Modal -->
   <!-- <div class="modal fade" id="modaltablefo2" style="overflow-y: auto" data-backdrop="static" data-keyboard="false" aria-labelledby="modal4Label" data-backdrop-color="gray"> -->
   <div class="modal fade" id="modaltablefo2" tabindex="-1" role="dialog">
       <div class="modal-dialog-lg">
           <!-- Modal content-->
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title"> Input Billing Tindakan</h4>
               </div>
               <div class="modal-body">
                   <div class="row">
                       <div class="col-md-12">
                           <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                               <div class="col-md-5">
                                   <div class="form-group">
                                       <label for="inputEmail3" class="col-sm-3 control-label"> Id FO1 </label>
                                       <div class="col-sm-4">
                                           <input type="text" class="form-control" name="Idbillingfo1" id="Idbillingfo1"
                                               readonly>
                                       </div>
                                   </div>
                                   <div class="form-group gut">
                                       <label for="inputEmail3" class="col-sm-3 control-label"> No Transaksi </label>
                                       <div class="col-sm-4">
                                           <input type="text" class="form-control" name="NoTRSBill1" id="NoTRSBill1"
                                               readonly>
                                       </div>
                                   </div>
                                   <div class="form-group gut">
                                       <label for="inputEmail3" class="col-sm-3 control-label"> Tgl Transaksi </label>
                                       <div class="col-sm-4">
                                           <input type="text" class="form-control" name="tgltransaksi" id="tgltransaksi"
                                               readonly>
                                       </div>
                                       <label for="inputEmail3" class="col-sm-12 control-label"></label>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-12">
                           <div class="col-md-8">
                               <h5 class="underline mt-30">Detail Komponen Billing</h5>
                               <div class="demo-table" style="overflow-x:auto; ">
                                   <table id="tbl_fo_bill_2" width="100%"
                                       class="table table-striped table-hover cell-border">
                                       <thead>
                                           <tr>
                                               <th align='center'>
                                                   <font size="1">ID
                                               </th>
                                               <th align='center'>
                                                   <font size="1">Kode Tarif
                                               </th>
                                               <th align='center'>
                                                   <font size="1">Nama Tarif
                                               </th>
                                               <th align='center'>
                                                   <font size="1">Qty
                                               </th>
                                               <th align='center'>
                                                   <font size="1">Nilai
                                               </th>
                                               <th align='center'>
                                                   <font size="1">Subtotal
                                               </th>
                                               <th align='center'>
                                                   <font size="1">Diskon
                                               </th>
                                               <th align='center'>
                                                   <font size="1">Total
                                               </th>
                                               <th align='center'>
                                                   <font size="1">Action
                                               </th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                       </tbody>
                                   </table>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <h5 class="underline mt-30">Revisi Detail Komponen Billing</h5>
                               <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                                   <div class="form-group">
                                       <label for="inputEmail3" class="col-sm-3 control-label"> Nama Tarif </label>
                                       <div class="col-sm-8">
                                           <input type="hidden" class="form-control" name="id_fo2" id="id_fo2" readonly>
                                           <input type="hidden" class="form-control" name="kodetarif_fo2"
                                               id="kodetarif_fo2" readonly>
                                           <input type="text" class="form-control" name="namatarif_fo2"
                                               id="namatarif_fo2" readonly>
                                       </div>
                                   </div>
                                   <div class="form-group gut">
                                       <label for="inputEmail3" class="col-sm-3 control-label"> Qty </label>
                                       <div class="col-sm-8">
                                           <input type="text" class="form-control" name="qty_fo2" id="qty_fo2">
                                       </div>
                                   </div>
                                   <div class="form-group gut">
                                       <label for="inputEmail3" class="col-sm-3 control-label"> Diskon </label>
                                       <div class="col-sm-8">
                                           <input type="text" class="form-control" name="diskon_fo2" id="diskon_fo2">
                                       </div>
                                   </div>
                                   <div class="form-group gut">
                                       <label for="inputEmail3" class="col-sm-3 control-label"> Nilai Tarif </label>
                                       <div class="col-sm-8">
                                           <input type="text" class="form-control" name="nilai_fo2" id="nilai_fo2"
                                               readonly>
                                           <input type="hidden" class="form-control" name="nilaipdp_fo2"
                                               id="nilaipdp_fo2" readonly>
                                       </div>
                                   </div>
                                   <div class="form-group gut">
                                       <label for="inputEmail3" class="col-sm-9 control-label"> </label>
                                       <div class="col-sm-1">
                                           <button type="button" class="btn btn-warning btn-rounded btn-wide"
                                               id="btnupfo2update" onclick="BtnUpdateBillfo2()">Update</button>
                                       </div>
                                   </div>

                               </form>
                           </div>
                           <div class="col-md-12">
                           </div>
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-gray btn-wide btn-rounded" data-dismiss="modal"
                               onclick="BtnCLoseClear()"><i class="fa fa-times"></i>Close</button>
                       </div>

                   </div>
               </div>
           </div>