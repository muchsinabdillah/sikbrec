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
    font-size: 13px;
  }

  th,
  td {
    border: 1px solid #bbb;
    padding: 2px 8px 0;
    font-size: 12px;
    font-weight: bold;
  }

  thead>tr>th {
    background-color: #dedede;
    border-bottom: 2px solid #999;
    font-size: 12px;
    font-weight: bold;
    color:#E36C09;
  }

  .alignRight {
  text-align: right;
}

  .border-ranap {
    border-left-color: #1E90FF;
    border-left-style: groove;
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
</style>
<div class="main-page">


  <section class="section">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">

          <div class="panel">
            <div id="border" class="panel-heading">
              <div class="panel-title">
                <h4><?= $data['judul'] ?> <span id="judul"></span></h4>
              </div>
            </div>
            <div class="panel-heading">
              <div class="panel-title">
                <h5 class="underline mt-30">Data Pasien</h5>
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
                    <input type="text" class="form-control" id="NoRegistrasi" name="NoRegistrasi" readonly>
                  </div>
                  <label for=" inputEmail3" class="col-sm-2 control-label"> Unit </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="Unit" name="Unit" readonly>
                  </div>
                </div>

                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-2 control-label"> No Order </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="NoOrder" name="NoOrder"  value="<?= $data['id'] ?>"  readonly>
                  </div>
                  <label for=" inputEmail3" class="col-sm-2 control-label"> Apoteker </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="Apoteker" name="Apoteker" readonly>
                  </div>
                </div>

                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-2 control-label"> No MR </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="NoMR" name="NoMR" readonly>
                  </div>
                  <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Resep</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="JenisResep" name="JenisResep" readonly="">
                  </div>
                </div>

                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal Lahir</label>
                  <div class="col-sm-4">
                    <input type="date" class="form-control" id="TanggalLahir" name="TanggalLahir" readonly>
                  </div>

                  <label for=" inputEmail3" class="col-sm-2 control-label"> Tanggal Resep</label>
                  <div class="col-sm-4">
                    <input type="datetime-local" class="form-control" id="TglResep" name="TglResep" readonly="">
                  </div>

                </div>

                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Iter </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="Iter" name="Iter" readonly>
                  </div>

                  <label for=" inputEmail3" class="col-sm-2 control-label"> Iter Realisasi</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="Iter_Realisasi" name="Iter_Realisasi" readonly="">
                  </div>

                </div>

                <div class="form-group gut">

                  <label for=" inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                  </div>


                </div>

                <hr>
              </form>

              <div class="panel-title">
                <h5 class="underline mt-30">Detail Order</h5>
              </div>
              <br>

              <table id="datadetail" class="table table-striped table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th align='center'>Jenis Resep
                                            </th>
                                            <th align='center'>Nama Obat
                                            </th>
                                            <th align='center'>Dosis
                                            </th>
                                            <th align='center'>Kekuatan Dosis
                                            </th>
                                            <th align='center'>Signa
                                            </th>
                                            <th align='center'>ED
                                            </th>
                                            <th align='center'>Note 1
                                            </th>
                                            <th align='center'>Note 2
                                            </th>
                                            <th align='center'>Qty
                                            </th>
                                            <th align='center'>Qty Rls
                                            </th>

                                            <!-- <th align='center'>Unit Price
                                            </th>
                                            <th align='center'>Discount
                                            </th> -->

                                            <th align='center'>TotalTarif
                                            </th>
                                            <th align='center'>Reviewed
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>


                 <div class="form-group gut">

                    <label for=" inputEmail3" class="col-sm-2 control-label">Order Free Text</label>
                    <div class="col-sm-12">
                    <textarea rows="2" class="form-control" id="FreeText" name="FreeText" style=" resize: vertical;" readonly></textarea>
                    </div>

                    <label for=" inputEmail3" class="col-sm-2 control-label">Review Resep (Free Text)</label>
                    <div class="col-sm-12">
                    <textarea rows="2" class="form-control" id="HasilReviewFreeText" name="HasilReviewFreeText" style=" resize: vertical;" readonly></textarea>
                    </div>

                </div>

                

                    <hr>

                    <div class="btn-group" role="group" >

                    <button class="btn btn-info  btn-rounded" id="btn_copyresep">
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Copy Resep</button>
                <button class="btn btn-primary  btn-rounded" id="btn_cetakresep">
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Resep</button>
                  <button class="btn btn-warning  btn-rounded" id="btn_cetaklabelall">
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Label All</button>
                  
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


<!-- Modal Approve ------------------------------------------------>
<div class="modal fade" id="modal_editsigna" tabindex="-1" role="dialog">

  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Edit Signa</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <form id="form_editsigna">
            <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-8 control-label"> ID</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="id_detail" name="id_detail" readonly>
                  </div>
                </div>
                <div class="form-group gut">
                  <label for="inputEmail3" class="col-sm-8 control-label"> Nama Obat</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="namaobat_signa" name="namaobat_signa" readonly>
                  </div>
                </div>

                <div class="form-group gut">
                <label for=" inputEmail3" class="col-sm-8 control-label"> Signa</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="Signa_edit" name="Signa_edit" >
                  </div>
                </div>

          </form>
        </div>
      </div>
      <div class="modal-footer">
        <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
        <button type="button" class="btn btn-primary"  id="Save_Signa" name="Save_Signa">Save</button>
      </div>
    </div>
  </div>
</div>
<!--#END Modal Approve--------------------------------------------->


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
<script src="<?= BASEURL; ?>/js/App/inventory/RiwayatTransaksi/RiwayatTransaksi_View_V01.js"></script>