<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
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

  .border-ranap {
    border-left-color: #1E90FF;
    border-left-style:groove;
    border-left-width: 7px;
  }

  .border-rajal {
    border-left-color: #B22222;
    border-left-style: groove;
    border-left-width: 7px;
  }

  .border-walkin {
    border-left-color: #808080;
    border-left-style: groove;
    border-left-width: 7px;
  }

  .border-bebas {
    border-left-color: teal;
    border-left-style: groove;
    border-left-width: 7px;
  }

  .cover {
  transform: translateY(-100%);
}

  /* .headerr{
    padding: 10px;
    width:20%;
  }
  

  .fixed {
    position: fixed;
    width: 15%;
    top:10px;
    margin-left:120px;
    z-index: 10;
    opacity: 100%; 
    padding: 10px;
    font-weight: bold;
  } */
  
</style>
<div class="main-page">

<div class="container-fluid">
         <div class="row page-title-div">
             <div class="col-md-6">
                 <h2 class="title"><?= $data['judul'] ?> </h2>
             </div>
             <!-- /.col-md-6 -->
         </div>
         <!-- /.row -->
         <div class="row breadcrumb-div">
             <div class="col-sm-6">
                 <ul class="breadcrumb">
                     <li><a href="<?= BASEURL; ?>"><i class="fa fa-home"></i> Home</a></li>
                     <li class="active"><?= $data['judul'] ?></li>
                 </ul>
             </div>
         </div>
         <!-- /.row -->
     </div>
     <!-- /.container-fluid -->


  <section class="section">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">

          <div class="panel" >
            
            <div class="panel-heading">
              <div class="panel-title">
                <h5 class="underline">Data Pasien</h5>
              </div>
            </div>
            <div class="panel-body">
              <form class="form-horizontal" id="frmDataPasien">
                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="NamaPasien" id="NamaPasien" readonly>
                  </div>
                  <label for=" inputEmail3" class="col-sm-2 control-label"> Dokter</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="Dokter" id="Dokter" readonly>
                  </div>
                </div>
                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-2 control-label"> No Registrasi </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="NoRegistrasi" name="NoRegistrasi" value="<?= $data['id'] ?>" readonly>
                  </div>
                  <label for=" inputEmail3" class="col-sm-2 control-label"> Unit </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="Unit" name="Unit" readonly>
                    <input type="hidden" class="form-control" id="IDUnit" name="IDUnit" readonly>
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
                    <input type="hidden" class="form-control" id="IDKelas" name="IDKelas" readonly>
                  </div>
                </div>

                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-2 control-label"> No MR </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="NoMR" name="NoMR" readonly>
                  </div>
                  <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Masuk - Keluar</label>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="TglMasuk" name="TglMasuk" readonly>
                  </div>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="TglKeluar" name="TglKeluar" readonly>
                  </div>
                </div>

                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir (Usia)</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="TanggalLahir" name="TanggalLahir" readonly>
                  </div>

                  <label for=" inputEmail3" class="col-sm-2 control-label"> Hak Kelas</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="HakKelas" name="HakKelas" readonly="">
                  </div>

                </div>

                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Penjamin </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="Penjamin" name="Penjamin" readonly>
                    <input type="hidden" class="form-control" id="GroupJaminan" name="GroupJaminan" readonly>
                    <input type="hidden" class="form-control" id="penjamin_kode" name="penjamin_kode" readonly>
                    <input type="hidden" class="form-control" id="TypePatientID" name="TypePatientID" readonly>
                  </div>

                  <label for=" inputEmail3" class="col-sm-2 control-label"> Diagnosa</label>
                  <div class="col-sm-4">
                    <textarea rows="1" class="form-control" id="Diagnosa" name="Diagnosa" style=" resize: vertical;" readonly></textarea>
                  </div>
                </div>

                <hr>
              </form>

              <div class="form-group gut">
                    <button title="Tambah Tindakan" data-toggle="modal" type="button" class="btn btn" id="btn_tambah_tindakan" name="btn_tambah_tindakan" style="background-color:#74cf9e"><span class="glyphicon glyphicon-plus"></span> Add</button>
               </div>
                <!--Tab 2 asassassas-->
               
                <div role="tabpanel" class="tab-pane" id="rincianbiaya">
                  <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                    <table id="tbl_rincianbiaya" width="100%" class="table table-striped table-hover cell-border">
                      <thead>
                        <tr>
                          <th align='center'>
                            <font size="1">
                          </th>
                          <th align='center'>
                            <font size="1">No
                          </th>
                          <th align='center'>
                            <font size="1">Tanggal
                          </th>
                          <th align='center'>
                            <font size="1">Nama Pemeriksaan
                          </th>
                          <th align='center'>
                            <font size="1">Tarif
                          </th>
                          <!-- <th align='center'>
                            <font size="1">Action&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                          </th> -->
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <!-- <th align="center" colspan="5"></th>
                          <th align="center"><button title="Tambah Tindakan" data-toggle="modal" type="button" class="btn btn-xs" id="btn_tambah_tindakan" name="btn_tambah_tindakan" style="background-color:#74cf9e"><span class="glyphicon glyphicon-plus"></span>Add</button></th> -->
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                </div>

              <br>

              <hr>


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



<!-- Modal Add Visit ------------------------------------------------>
<div class="modal fade" id="addtindakan_modal" role="dialog">

  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Tambah Tindakan</h4>
        <form id="form_addvisitdetails">
      </div>
      <div class="modal-body">

        <div class="form-group gut">
          <label for="inputsm">Nama Tindakan</label>
          <select class="form-control js-example-basic-single" name="namatindakan" id="namatindakan" style="width:100%" onchange="getTarifTindakan(this)">
          </select>
        </div>

        <div class="form-group gut">
          <label for="inputsm">Tanggal Tindakan</label>
          <input type="date" name="date_tindakan_tambahan" id="date_tindakan_tambahan" style="width:100%">
        </div>

        <div class="form-group gut">
          <label for="inputsm">Dokter Pemeriksa</label>
          <select class="form-control js-example-basic-single" id="dokterpemeriksa" name="dokterpemeriksa" style="width: 100%">
          </select>
        </div>

        <div class="from-group row">
          <div class="col-sm-3">
            <label for="qty_addvisit">Qty</label>
            <input class="form-control input-sm" id="qty_addvisit" name="qty_addvisit" type="text" readonly value="1">
          </div>
          <div id="error_qty_addvisit"></div>
          <div class="col-sm-3">
            <label for="tarif_satuan_addvisit">Tarif Satuan</label>
            <input class="form-control input-sm" id="total_tarif_addvisit_temp" name="total_tarif_addvisit_temp" type="hidden" readonly>
            <input class="form-control input-sm" id="tarif_satuan_addvisit" name="tarif_satuan_addvisit" type="text" readonly>
          </div>
          <div id="error_tarif_satuan_addvisit"></div>
          <div class="col-sm-3">
            <label for="diskon_addvisit">Diskon (%)</label>
            <input type="text" class="form-control input-sm" id="diskon_addvisit" name="diskon_addvisit" type="number" placeholder="%" min="1" max="100" size="1" maxlength="3" value="0" readonly/>
          </div>
          <div id="error_diskon_addvisit"></div>
          <div class="col-sm-3">
            <label for="total_tarif_addvisit">Total Tarif</label>
            <input class="form-control input-sm" id="total_tarif_addvisit" name="total_tarif_addvisit" type="text" readonly>
          </div>
          <div id="error_total_tarif_addvisit"></div>
        </div>
        <input type="hidden" class="form-control" id="kode_dokterpemeriksa" name="kode_dokterpemeriksa" readonly hidden />
        <input type="hidden" class="form-control" id="namaproduct_addvisit" name="namaproduct_addvisit" readonly hidden />
        <input type="hidden" class="form-control" id="categoryproduct_addvisit" name="categoryproduct_addvisit" readonly hidden />
        <input type="hidden" class="form-control" id="namadokter_addvisit" name="namadokter_addvisit" readonly hidden />

        </form>
      </div>
      <div class="modal-footer">
        <button data-dismiss="" class="btn btn-primary" id="btn_saveaddvisit" name="btn_saveaddvisit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
        <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
      </div>
    </div>
  </div>
</div>
<!--#END Modal Visit--------------------------------------------->


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
<script src="<?= BASEURL; ?>/js/App/odc/viewAddPemeriksaan.js"></script>