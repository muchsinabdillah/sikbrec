   <!-- Modal -->
   <div class="modal fade" id="modaltindakanbyorderOperasi" style="overflow-y: auto" data-backdrop="static" data-keyboard="false" aria-labelledby="modal4Label" data-backdrop-color="gray">

       <div class="modal-dialog-lg">
           <!-- Modal content-->
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title"> Input Billing Tindakan</h4>
               </div>
               <div class="modal-body">
                   <!--  awal untuk tab-->
                   <!-- Nav tabs -->
                   <form class="form-horizontal" id="form_tindakan_new">
                       <div class="col-sm-9">
                           <div class="form-group ">
                               <label for=" inputEmail3" class="col-sm-2 control-label"> ID Billing<sup class="color-danger">*</sup></label>
                               <div class="col-sm-4">
                                   <input type="text" class="form-control" name="Idbilling" id="Idbilling" readonly>
                               </div>
                               <label for=" inputEmail3" class="col-sm-2 control-label"> No. MR <sup class="color-danger">*</sup></label>
                               <div class="col-sm-4">
                                   <input type="text" class="form-control" name="bilNoMr" readonly id="bilNoMr">
                                   <input type="hidden" class="form-control" name="xgrupjaminan" readonly id="xgrupjaminan">
                               </div>
                           </div>
                           <div class="form-group gut">
                               <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal/Jam <sup class="color-danger">*</sup></label>
                               <div class="col-sm-2">
                                   <input type="date" class="form-control" name="dateabilling" id="dateabilling">
                               </div>
                               <div class="col-sm-2">
                                   <input type="time" class="form-control" name="timeabilling" id="timeabilling">
                               </div>
                               <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Pasien <sup class="color-danger">*</sup></label>
                               <div class="col-sm-4">
                                   <input type="text" class="form-control" name="bilNamaPasien" readonly id="bilNamaPasien">
                               </div>
                           </div>
                           <div class="form-group gut">
                               <label for=" inputEmail3" class="col-sm-2 control-label"> No. Episode/Reg <sup class="color-danger">*</sup></label>
                               <div class="col-sm-2">
                                   <input type="text" class="form-control" name="bilNoEpisode" readonly id="bilNoEpisode">
                               </div>
                               <div class="col-sm-2">
                                   <input type="text" class="form-control" name="bilNOreg" readonly id="bilNOreg">
                               </div>
                               <label for=" inputEmail3" class="col-sm-2 control-label"> Jaminan <sup class="color-danger">*</sup></label>
                               <div class="col-sm-4">
                                   <input type="text" class="form-control" readonly name="bilNamaJaminan" id="bilNamaJaminan">
                               </div>
                           </div>
                           <div class="form-group ">
                               <label for=" inputEmail3" class="col-sm-2 control-label"> <sup class="color-danger">*</sup></label>
                               <div class="col-sm-4">
                                   <button type="button" class="btn btn-warning btn-rounded btn-wide" id="tbtnhdradd" onclick="BtnNewInput()">new
                                       input
                                       tindakan</button>
                               </div>
                           </div>
                       </div>
                       <hr>
                       <div class="form-group">
                           <div class="col-md-4">
                               <div class="panel border-danger no-border border-3-right" style="border-radius: 0px;">
                                   <div class="panel-heading">
                                       <div class="panel-title">
                                           <h5> Pilih Tindakan</h5>
                                       </div>
                                   </div>
                                   <div class="panel-body" style="min-height: 18em; max-height: 18em;">
                                       <div class="col-sm-12" style="min-height: 18em; max-height: 18em;">
                                           <select name="namatindakannew" id="namatindakannew" class="form-control" onchange="getTarifDetail(this)" style="min-width: 300px;">
                                           </select>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="panel border-danger no-border border-3-right" style="border-radius: 0px;">
                                   <div class="panel-heading">
                                       <div class="panel-title">
                                           <h5>Pilih Dokter</h5>
                                       </div>
                                   </div>
                                   <div class="panel-body" style="min-height: 18em; max-height: 18em;">
                                       <div class="col-sm-12" style="min-height: 18em; max-height: 18em;">
                                           <select name="dokterpemeriksanew" id="dokterpemeriksanew" class="form-control" onchange="getDokterdetail(this)" aria-hidden="true" style="min-width: 300px;">
                                           </select>
                                       </div>
                                   </div>

                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="panel border-danger no-border border-3-right" style="border-radius: 0px;">
                                   <div class="panel-heading">
                                       <div class="panel-title">
                                           <h5>Detail Data</h5>
                                       </div>
                                   </div>
                                   <div class="panel-body" style="min-height: 18em; max-height: 18em;">
                                       <label for="inputEmail3" class="col-sm-2 control-label"> Dokter </label>
                                       <div class="col-sm-10">
                                           <input type="text" class="form-control" id="dokternew" name="dokternew" readonly>
                                       </div>
                                       <br>
                                       <label for="inputEmail3" class="col-sm-2 control-label"> Tindakan </label>
                                       <div class="col-sm-10">
                                           <input type="text" class="form-control" id="tindakannew" name="tindakannew" readonly>
                                       </div>
                                       <br>
                                       <label for="inputEmail3" class="col-sm-2 control-label"> Tarif </label>
                                       <div class="col-sm-10">
                                           <input class="form-control input-sm" id="hargatarifnew" name="hargatarifnew" type="text" readonly>
                                       </div>
                                       <label for="inputEmail3" class="col-sm-2 control-label"> Kategori </label>
                                       <div class="col-sm-10">
                                           <input class="form-control input-sm" id="kategorinewproduct" name="kategorinewproduct" type="text" readonly>
                                       </div>
                                       <br>
                                       <label for="inputEmail3" class="col-sm-2 control-label"> QTY </label>
                                       <span><button type="button" class="btn btn-warning btn-rounded btn-wide" id="btnaddtindakanx" onclick="BtnNewInputBill()">Add
                                               tindakan</button></span>
                                       <div class="col-sm-6">
                                           <input class="form-control input-sm" id="qty_addvisitnew" name="qty_addvisitnew" type="text">
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <form id="detail_fo_bill">
                           <div class="demo-table" style="margin-top: 10px;overflow-x:auto; ">
                               <table id="tbl_fo_bill" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                   <thead>
                                       <tr>
                                           <th align='center'>
                                               <font size="1">NO
                                           </th>
                                           <th align='center'>
                                               <font size="1">ID
                                           </th>
                                           <th align='center'>
                                               <font size="1">Nama Tarif
                                           </th>
                                           <th align='center'>
                                               <font size="1">Nama Dokter
                                           </th>
                                           <th align='center'>
                                               <font size="1">Tgl Transaksi
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
                                               <font size="1">Group
                                           </th>
                                           <th align='center'>
                                               <font size="1">Action
                                           </th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                   <tbody id="user_datas">
                                   </tbody>
                               </table>
                           </div>
                       </form>
                       <div class="demo-table" id="tbl_Tarif_ganti" nama="tbl_Tarif_ganti" style="margin-top: 10px;overflow-x:auto; display : none;">
                           <div class="panel-title">
                               <h5>GENERATE TARIF GANTI JAMINAN</h5>
                           </div>
                           <table id="tbl_update_tarif" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                               <thead>
                                   <tr>
                                       <th align='center'>
                                           <font size="1">ID
                                       </th>
                                       <th align='center'>
                                           <font size="1">Nama Tarif
                                       </th>
                                       <th align='center'>
                                           <font size="1">Nilai
                                       </th>
                                   </tr>
                               </thead>
                               <tbody>
                               </tbody>
                           </table>
                       </div>
                   </form>
               </div>
               <div class="modal-footer">
                   <button class="btn bg-warning  btn-wide" id="btnGantiTarif" name="btnGantiTarif" onclick="btnGantiTarif()"><i class="fa fa-save">
                       </i>Ganti Tarif</button>
                   <!-- <button class="btn bg-success  btn-wide" id="btnSaveAll" name="btnSaveAll"><i class="fa fa-save">
                       </i>Simpan</button> -->
                   <button type="button" class="btn bg-gray btn-wide" id="btnCloseSEP" data-dismiss="modal" onclick="btnrRefershTable()"><i class="fa fa-times"></i>Close</button>
               </div>

           </div>
       </div>
   </div>
   <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
   <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>