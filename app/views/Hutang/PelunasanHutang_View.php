<div class="main-page">
     
    <section class="section">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5 class="underline mt-30">Transaksi <?= $data['judul'] ?></h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_cuti">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Pelunasan</label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="NoPelunasan" id="NoPelunasan" value="<?= $data['id'] ?>"
                                            readonly>
                                    </div>
                                    <div class="col-sm-2">
                                       
                                    </div>
                                </div>
                                <div class="form-group gut"> 
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Trs</label>
                                    <div class="col-sm-3">
                                        <input type="datetime-local" class="form-control" 
                                            name="TglTransaksi" id="TglTransaksi">
                                    </div> 
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Order</label>
                                    <div class="col-sm-3">
                                        <input type="teks" class="form-control" name="NoOrder" id="NoOrder" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group" role="group" id="btnSadas">
                                            <button type="button"
                                                class="btn btn-danger btn-sm btn-rounded " id="btn_caridatamr">
                                                <span class="glyphicon glyphicon glyphicon-search"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group gut">

                                    <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" 
                                            name="Periode1" id="Periode1" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" 
                                            name="Periode2" id="Periode2" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Supplier</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="NamaSupplier"
                                                name="NamaSupplier"  >
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-5">
                                        <input type="hidden" class="form-control" name="KodeSupplier"
                                            id="KodeSupplier" readonly>
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Rekening Pelunasan</label>
                                    <div class="col-sm-5">
                                        <select class="form-control js-example-basic-single" id="RekeningPelunasan"
                                            name="RekeningPelunasan">
                                        </select>
                                    </div>
                                </div>
                                        <div class="btn-group" role="group" id="btnSadas"> 
                                        <button type="button"  class="btn btn-danger btn-sm btn-rounded " id="btnNewOrder" name="btnNewOrder">
                                            NEW TRANSAKSI  
                                        </button>
                                        </div>
                            </form>
                            <hr> 
                            <div class="panel-body p-20">
                            <form class="form-horizontal" id="form_table">
                                <div class="demo-table" style="overflow-x:auto;">
                                    <table id="table-pelunasan-hutang" class="display" width="100%">
                                        <thead>
                                            <tr>
                                            <th align='center'>
                                                </th>
                                            <th align='center'>
                                                    <font size="1">Kode Order
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Kode hutang
                                                </th> 
                                                <th align='center'>
                                                    <font size="1">Keterangan
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nilai Sisa
                                                </th>
                                                <th align='center'>
                                                    <font size="1">Nilai Pelunasan
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr> 
                                            <th>
                                                <button type="button" title="Approve Yang Dipilih"
                                            class="btn btn-default btn-xs" id="cb_approveLaboall"
                                            name="cb_approveLaboall" onclick="btnCheckedBox(this)"><span
                                                class="glyphicon glyphicon-check"></span> All </button>
                                            </th> 
                                            <th colspan="5">TOTAL :</th>  
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                                
                            </div>
                                    <a type="button" class="btn btn-success btn-animated btn-wide "  id="btnSimpan" name="btnSimpan">
                                        <span  class="visible-content">Simpan</span><span class="hidden-content"><i  class="fa fa-gear"></i></span>
                                    </a>
                                    <a type="button" class="btn btn-danger btn-animated btn-wide "
                                        id="VoidPelunasanHutang" name="VoidPelunasanHutang"><span
                                            class="visible-content">Batal</span><span class="hidden-content"><i
                                                class="fa fa-gear"></i></span></a>
                                    <a type="button" class="btn btn-warning btn-animated btn-wide "
                                        id="btnLoadInformation" name="btnLoadInformation"><span
                                            class="visible-content">Close</span><span class="hidden-content"><i
                                                class="fa fa-gear"></i></span></a>

                        </div>



                    </div>

                    <!-- /.col-md-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>
<div class="modal fade" id="Modal_verifikasi" tabindex="-1" role="dialog" style="overflow-y: auto"   >
        
        <div class="modal-dialog modal-md">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header"> 
              <h4 class="modal-title"> Masukan Nilai Pelunasan </h4> 
            </div>
            <form id="frmKartuRSYarsi">
            <div class="modal-body"> 
              <div class="row" style="margin-bottom:3px;">
                            <label for="namapasien" class="col-sm-4 col-form-label">No. ID</label>

                            <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="JM_ID" readonly name="JM_ID" >
                            </div>  
                        </div>
              <div class="row" style="margin-bottom:3px;">
                          <label for="dokter" class="col-sm-4 col-form-label">Keterangan </label>
                            <div class="col-sm-8">
                              <input class="form-control input-sm " id="JM_Keterangan" readonly name="JM_Keterangan" type="text" placeholder="Ketik Nama Pasien">
                            </div>  
                        </div>
                        <div class="row" style="margin-bottom:3px;">
                            <label for="namapasien" class="col-sm-4 col-form-label">Nilai Sisa</label>
                            <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="JM_NIlaiSisa" readonly name="JM_NIlaiSisa" >
                            </div>  
                        </div>
                        <div class="row" style="margin-bottom:3px;">
                            <label for="namapasien" class="col-sm-4 col-form-label">Nilai Bayar</label>
                            <div class="col-sm-4">
                              <input class="form-control input-sm" type="number" id="JM_NilaiVerif"   name="JM_NilaiVerif" >
                            </div>  
                        </div> 
            </div>  
            </form>
            <div class="modal-footer">
                  <div class="form-group row" style="margin-right:1em;float:right;"> 
                        <button class="btn btn-primary"  id="btnSavePoli2" name="btnSavePoli2"> Simpan</button> 
                  </div>
            </div>  
          </div>
        </div>
      
      </div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" style="overflow-y: auto" >
    <div class="modal-dialog  modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Order Pelunasan Hutang<button type="button"
                        class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group form-horizontal">
                        <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-3">
                            <input type="month" class="form-control" name="PeriodePencarian"
                                id="PeriodePencarian">
                        </div> 
                        <div class="col-sm-2">
                            <button type="button" id="btnSearchMrAktif" class="btn btn-danger btn-wide btn-rounded"><i
                                    class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                </div>

                <div class="panel-body p-20">
                    <div class="demo-table" style="overflow-x:auto;">
                        <table id="table-order-hutang" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Nama Rekanan</th>
                                    <th>Nilai Hutang</th>
                                    <th>Sisa Hutang</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienCloseX" ><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal --> 
<div class="modal fade" id="myModaldetilHutang" tabindex="-1" role="dialog" style="overflow-y: auto" >
    <div class="modal-dialog  modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Detail Order Piutang </h4>
            </div>
            <div class="modal-body">
                <div class="panel-body p-20"> 
                     
                        <table id="table-order-hutang-details" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Tgl Faktur</th>
                                    <th>Tgl Hutang</th>
                                    <th>Tgl Tempo</th>
                                    <th>Nama Rekanan</th>
                                    <th>Nilai Hutang</th>
                                    <th>Sisa Hutang</th> 
                                </tr>
                            </thead>
                        </table>
                    
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" ><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal --> 
</div>
<!-- /.content-container -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.main-wrapper -->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script src="<?= BASEURL; ?>/js/App/finance/pelunasanhutang.js"></script>