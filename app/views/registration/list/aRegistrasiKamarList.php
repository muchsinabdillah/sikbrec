<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>
<style>
    table {
        border: 2px solid #6C6A61;
        border-collapse: collapse;
        font-size: 10px;
    }

    th,
    td {
        border: 1px solid #bbb;
        padding: 2px 8px 0;
        font-size: 10px;
    }

    thead>tr>th {
        background-color: #C0C0C0;
        border-bottom: 2px solid #999;
        font-size: 10px;
    }
</style>
<div class="main-page">
     

     <section class="section">
         <div class="container-fluid">

             <div class="row">
                 <div class="col-md-12">
                     <div class="panel">
                         <div class="panel-heading">
                             <div class="panel-title">
                                 <h5 class="underline mt-30"><?= $data['judul'] ?></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                                 <form class="form-horizontal" id="frmDataPasien">
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="NamaPasien" id="NamaPasien"  readonly>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Dokter</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="Dokter" id="Dokter" readonly>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                 <label for="inputEmail3" class="col-sm-2 control-label"> No Registrasi </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NoRegistrasi" name="NoRegistrasi" value="<?= $data['id'] ?>"  readonly> 
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Unit </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Unit" name="Unit" readonly>
                                     </div>
                                 </div>

                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> No Episode </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NoEpisode" name="NoEpisode" readonly> 
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Kelas </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Kelas" name="Kelas" readonly> 
                                     </div>
                                 </div>

                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> No MR </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="NoMR" name="NoMR"  readonly> 
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Masuk - Keluar</label>
                                     <div class="col-sm-2">
                                     <input type="date" class="form-control" id="TglMasuk" name="TglMasuk" readonly> 
                                     </div>
                                     <div class="col-sm-2">
                                     <input type="date" class="form-control" id="TglKeluar" name="TglKeluar" readonly> 
                                     </div>
                                 </div>

                                 <div class="form-group gut" >
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir (Usia)</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="TanggalLahir" name="TanggalLahir" readonly> 
                                     </div>
                                     
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Hak Kelas</label>
                                     <div class="col-sm-4">
                                     <input type="text" class="form-control" id="HakKelas" name="HakKelas" readonly=""> 
                                     </div>
                                    
                                 </div>

                                 <div class="form-group gut" >
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Penjamin </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="Penjamin" name="Penjamin" readonly> 
                                     </div>

                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Diagnosa</label>
                                     <div class="col-sm-4">
                                     <textarea rows="1" class="form-control" id="Diagnosa" name="Diagnosa" style=" resize: vertical;" readonly></textarea>
                                     </div>
                                 </div>

                                 <div class="form-group gut" style="display:none">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Alih Status Dari </label>
                                     <div class="col-sm-3">
                                         <input type="text" class="form-control" id="AlihStatusDari" name="AlihStatusDari" readonly> 
                                     </div>
                                     <div class="col-sm-1">
                                     <button type="button" class="btn btn-primary  btn-rounded " id="btn_showrajal" name="btn_showrajal">
                                     <i class="fa fa-eye"></i> Lihat</button>
                                     </div>

                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Keterangan</label>
                                     <div class="col-sm-4">
                                     <input type="text" class="form-control" id="Keterangan_Ext" name="Keterangan_Ext" readonly=""> 
                                     </div>
                                    
                                 </div>

                                 <hr>
                             </form>

                             <button type="button" class="btn btn-primary btn-animated btn-wide" onclick="CreateNew();"><span class="visible-content">Input Baru</span><span class="hidden-content"><i class="fa fa-send-o"></i></span></button>
                             <div class="table-responsive" style="margin-top: 10px;">
                                <table id="pemakaiankamar" class="display" width="100%">
                                    <thead>
                                        <tr>
                                        <th align="center">ID</th>
                                        <th align="center">Kelas</th>
                                        <th align="center">Room</th>
                                        <th align="center">Bed</th>
                                        <th align="center">Jenis Rawat</th>
                                        <th align="center">Start Date</th>
                                        <th align="center">Time Start</th>
                                        <th align="center">Tarif</th>
                                        <th align="center">Lama Rawat</th>
                                        <th align="center">End Date</th>
                                        <th align="center">Time End</th>
                                        <th align="center">Disc</th>
                                        <th align="center">Jumlah</th>
                                        <th align="center">Status</th>
                                        <th align="center" width="120px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                         </div>
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
 <!-- Modal Checkout ------------------------------------------------>
 <div class="modal fade" id="modal_checkout" tabindex="-1" role="dialog">
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"> Check Out</h4>
      <form id="form_checkout">
    </div>
    <div class="modal-body">
          <input class="form-control input-sm" type="hidden" id="idtrs" name="idtrs" readonly>
          <input class="form-control input-sm" type="hidden" id="tgl_masuk_modal" name="tgl_masuk_modal" hidden readonly>
      <div class="row" style="margin-bottom:3px;">
          <label for="noreg" class="col-sm-4 col-form-label">Tanggal Keluar</label>
        <div class="col-sm-8">
           <input class="form-control input-sm" type="datetime-local" id="tgl_keluar" name="tgl_keluar" value = "<?php  echo date('Y-m-d\TH:i:s')?>">
        </div>
      </div>
          </form>
    </div>
    <div class="modal-footer">
      <button data-dismiss="" class="btn btn-primary" id="submit_checkout" name="submit_checkout"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
      <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
    </div>
  </div>
</div>
</div>
<!--#END Modal Checkout ------------------------>
 <!-- /.main-page -->
 <div class="right-sidebar bg-white fixed-sidebar">
     <div class="sidebar-content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-12">
                     <h4>Useful Sidebar <i class="fa fa-times close-icon"></i></h4>
                     <p>Code for help is added within the main page. Check for code below the example.</p>
                     <p>You can use this sidebar to help your end-users. You can enter any HTML in this sidebar.</p>
                     <p>This sidebar can be a 'fixed to top' or you can unpin it to scroll with main page.</p>
                     <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                 </div>
                 <!-- /.col-md-12 -->

                 <div class="text-center mt-20">
                     <button type="button" class="btn btn-success btn-labeled">Purchase Now<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                 </div>
                 <!-- /.text-center -->
             </div>
             <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
     </div>
     <!-- /.sidebar-content -->
 </div>
 <!-- /.right-sidebar -->

 </div>
 <!-- /.content-container -->
 </div>
 <!-- /.content-wrapper -->

 </div>
 <!-- /.main-wrapper -->
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/registration/list/listregistratrationkamar_V01.js"></script>