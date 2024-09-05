<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>
<style>
    table {
        border: 0px solid #6C6A61;
        border-collapse: collapse;
        font-size: 12px;
    }

    th,
    td {
         border: 0px solid #6C6A61; 
        padding: 2px 8px 0;
        font-size: 12px;
        color:black;
        padding: 3px;
    }

    thead>tr>th {
        background-color: #D6DFEC;
        border-bottom: 2px solid #999;
        font-size: 11px;
        padding: 3px;
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
                                 <h5><?= $data['judul'] ?></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <form class="form-horizontal" id="form_cuti"> 
                                 <div class="form-group">
                                     
                                     <label for="inputEmail3" class="col-sm-2 control-label">Periode</label>
                                     <div class="col-sm-2">
                                         <input type="date" class="form-control" name="PeriodeAwal" id="PeriodeAwal">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 control-label">S/d</label>
                                     <div class="col-sm-2">
                                         <input type="date" class="form-control" name="PeriodeAkhir" id="PeriodeAkhir">
                                     </div>
                                 </div> 

                                 <div class="form-group">
                                     
                                 <label for="inputEmail3" class="col-sm-2 control-label"> Status Order</label>
                                     <div class="col-sm-5">
                                     <select class="form-control js-example-basic-single" id="StatusOrder" name="StatusOrder" >
                                         <option value="99">Semua</option>
                                         <option value="0" style="color: green;font-weight: bold;">New</option>
                                         <option value="1" style="color: #FFBF00;font-weight: bold;">Review</option>
                                         <option value="2" style="color: red;font-weight: bold;">Lunas</option>
                                         <option value="3" style="color: indigo;font-weight: bold;">Printed</option>
                                         <option value="4" style="color: default;font-weight: bold;">Closed</option>
                                         </select>
                                     </div>
                                     
                                 </div> 

                                 <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pasien</label>
                                     <div class="col-sm-5">
                                     <select class="form-control js-example-basic-single" id="JenisPasien" name="JenisPasien" >
                                         <option value="99">Semua</option>
                                         <option value="RJ" style="color: bg-info;font-weight: bold;">Rawat Jalan</option>
                                         <option value="RI" style="color: bg-warning;font-weight: bold;">Rawat Inap</option>
                                         <option value="OB" style="color: bg-danger;font-weight: bold;">Obat Bebas</option>
                                         </select>
                                     </div>
                                     
                                 </div> 

                                 <div class="form-group">
                                 <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Resep</label>
                                     <div class="col-sm-5">
                                     <select class="form-control js-example-basic-single" id="JenisResep" name="JenisResep" >
                                         <option value="99">Semua</option>
                                         <option value="RESEP">Resep</option>
                                         <option value="BHP">BHP</option>
                                         </select>
                                     </div>
                                     
                                 </div> 

                                 <button type="button" class="btn btn-success btn-animated btn-wide" id="btnLoadInformation" name="btnLoadInformation" ><span class="visible-content">Load</span><span class="hidden-content"><i class="fa fa-gear"></i></span></button>

                                    </form>
                                
                                 <hr>
                             <div class="table-responsive" style="margin-top: 70px;">
                             <form id="form_approve" >
                                <table id="permintaanrawat_all" class="table table-striped table-hover" width="100%">
                                    <thead>
                                        <tr>
                                        <th align='center'>
                                            </th>
                                        <th align='center'>Order ID
                                            </th>
                                            <th align='center'>No. MR
                                            </th>
                                            <th align='center'>Nama Pasien
                                            </th>
                                            <th align='center'>No. Registrasi
                                            </th>
                                            <th align='center'>Jenis Pasien
                                            </th>
                                            <th align='center'>Lokasi Pasien
                                            </th>
                                            <th align='center'>Dokter
                                            </th>
                                            <th align='center'>Tanggal
                                            </th>
                                            <th align='center'>Status
                                            </th>
                                            <th align='center'>Jenis Resep
                                            </th>
                                            <th align='center'>Penjamin
                                            </th>
                                            <th align='center'>Action
                                            </th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tr>
                                            <th colspan="12"></th>
                                            <th align="center"><button type="button" title="Kirim Yang Dipilih" class="btn btn-success btn-xs"  id="cb_approvefarmasiall" name="cb_approvefarmasiall" onclick="BtnApprove(this)"> Selesai </button></th>
                                        </tr>
                                </table>
                            </form>
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
 <script src="<?= BASEURL; ?>/js/App/inventory/RiwayatTransaksi/RiwayatTransaksi_List_V01.js"></script>