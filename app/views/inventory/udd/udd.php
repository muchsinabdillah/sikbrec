  <?php
    date_default_timezone_set('Asia/Jakarta');
    $id = "";
    $datenowcreate = date("Y-m-d");
    $datetimenow2222 = date("Y-m-d\TH:i:s");

    ?>
  <div class="main-page">
      <section class="section" style="margin-top: -20px;">
          <div class="container-fluid">

              <div class="row">
                  <div class="col-md-12">
                      <div class="panel">
                          <div class="panel-heading">
                              <div class="panel-title">
                                  <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi </small></h5>
                              </div>
                          </div>
                          <div class="panel-body">
                              <form class="form-horizontal" id="frmSimpanTrsUddHeader">
                                  <h5 class="underline mt-30">DATA PASIEN</h5>
                                  <div class="form-group  ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Trs Udd <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="IdTransaksi" readonly name="IdTransaksi" type="text" readonly value="<?= $data['id'] ?>">
                                      </div>
                                  </div>
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Resep <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" type="text" readonly id="Udd_No_Resep" autocomplete="off" name="Udd_No_Resep" placeholder="No. Resep Here" onchange="showIDMxR();" autocomplete="off">
                                      </div>
                                      <div class="col-sm-2">
                                          <div class="btn-group" role="group" id="btnSadas">
                                              <a href="#myModal" data-toggle="modal" class="btn btn-primary btn-sm btn-rounded " id="btn_caridatamr">
                                                  <span class="glyphicon glyphicon glyphicon-search"></span></a>
                                          </div>
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-1">
                                          <input class="form-control input-sm" type="text" autocomplete="off" id="Udd_PasienIdJKel" readonly name="Udd_PasienIdJKel" placeholder="ID Jkel">
                                      </div>
                                      <div class="col-sm-3">
                                          <input class="form-control input-sm" type="text" id="Udd_PasienNamaJKel" readonly name="Udd_PasienNamaJKel" placeholder="Nama Jenis Kelamin">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Episode <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" readonly type="text" id="Udd_NoEpisode" name="Udd_NoEpisode" placeholder="No. Episode">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> No. Reg/MR <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Udd_No_Registrasi" readonly name="Udd_No_Registrasi" type="text" placeholder="No. Registrasi">
                                      </div>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Udd_NOMR" readonly name="Udd_NOMR" type="text" placeholder="No. MR">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Resep <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" readonly type="text" id="Udd_JenisResep" name="Udd_JenisResep" placeholder="Jenis Resep">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> TTL Pasien <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Udd_PasienTglLahir" readonly name="Udd_PasienTglLahir" type="text" placeholder="Tpt Lahir Pasien">
                                      </div>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Udd_PasienUsia" readonly name="Udd_PasienUsia" type="text" placeholder="Tgl Lahir Pasien">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Udd_PasienNama" readonly name="Udd_PasienNama" type="text" placeholder="Ketik Nama Pasien">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Room Name <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Udd_RoomName" readonly name="Udd_RoomName" type="text" placeholder="Room Name">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Class/Bed </label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Udd_Class" readonly name="Udd_Class" type="text" placeholder="Class">
                                      </div>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Udd_Bed" readonly name="Udd_Bed" type="text" placeholder="Bed">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Dokter </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Udd_Dokter" readonly name="Udd_Dokter" type="text" placeholder="Dokter">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Waktu </label>
                                      <div class="col-sm-4">
                                          <select id="slcWaktu" name="slcWaktu" style="width: 100%;" class="form-control ">
                                              <option value="">-- PILIH --</option>
                                              <option value="PAGI">PAGI</option>
                                              <option value="SIANG">SIANG</option>
                                              <option value="SORE">SORE</option>
                                              <option value="MALAM">MALAM</option>
                                          </select>
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Tgl/Jam </label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="slcWaktuTgl" name="slcWaktuTgl" type="date">
                                      </div>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="slcWaktuJam" name="slcWaktuJam" type="time">
                                      </div>
                                  </div>
                              </form>
                              <button class="btn btn-warning  btn-rounded " id="BtnCreateHdrUdd" name="BtnCreateHdrUdd">
                                  <i class="fa fa-plus"></i>New Transaction</button>
                              <h5 class="underline mt-30">DATA OBAT</h5>
                              <div class="form-group gut mt-20">

                                  <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Qty </label>
                                  <div class="col-sm-1">
                                      <input class="form-control input-sm " id="Udd_Qty" name="Udd_Qty" type="numeric" style="margin-left:-150px;">
                                  </div>
                                  <label for="inputEmail3" class="col-sm-2 control-label"> Pilih </label>
                                  <div class="col-sm-4" style="margin-left:-150px;">
                                      <select id="slcDataObat" name="slcDataObat" style="width: 100%;" class="form-control" onchange="goCreateDetilUdd();">
                                      </select>
                                  </div>
                              </div>
                              <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 90px;">
                                  <table id="tbl_aktif_detil" width="100%" class="table table-striped table-hover cell-border">
                                      <thead>
                                          <tr>
                                              <th align='center'>
                                                  <font size="1">Kode Obat
                                              </th>
                                              <th align='center'>
                                                  <font size="1">Nama Obat
                                              </th>
                                              <th align='center'>
                                                  <font size="1">Qty
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


                              <div class="btn-group" role="group">
                                  <button class="btn btn-success  btn-rounded " id="btnprint" name="btnprint">
                                      <i class="fa fa-print"></i> PRINT LABEL</button>
                                  <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'>
                                      <i class="fa fa-save"></i>Selesai</button>
                                  <button class="btn btn-danger  btn-rounded " onclick="Passingbatal()" id="batal" name="batal" href="#modal_alert_batal" data-toggle='modal'>
                                      <i class="fa fa-close"></i> Batal</button>
                                  <button class="btn btn-secondary  btn-rounded " id="close" name="close" onclick="MyBack()">
                                      <i class="fa fa-mail-reply-all"></i> Close</button>
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

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Cari Data Resep Pasien <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
              </div>
              <div class="modal-body">
                  <div class="alert alert-success alert-dismissible">
                      <p> <strong>Info !</strong> Untuk Pencarian bisa Dilakukan Pencarian dengan Nama Pasien, No. Resep.</p>
                  </div>
                  <div class="form-horizontal">
                      <div class="form-group form-horizontal">
                          <label for="inputEmail3" class="col-sm-3 control-label"> Masukan Kata Kunci <sup class="color-danger">*</sup></label>
                          <div class="col-sm-3">
                              <select id="slcResep" name="slcResep" style="width: 100%;" class="form-control ">
                                  <option value="1">Nama Pasien</option>
                                  <option value="2">No. Resep</option>
                              </select>
                          </div>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="txSearchData" autocomplete="off" name="txSearchData" placeholder="ketik Kata Kunci disini">
                          </div>

                          <div class="col-sm-2">
                              <button type="button" id="btnSearchMrAktif" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                          </div>
                      </div>
                  </div>
                  <div class="table-responsive">
                      <table id="table-load-data" class="display table table-striped table-bordered" width="100%">
                          <thead>
                              <tr>
                                  <th>No. Resep</th>
                                  <th>Nama Pasien</th>
                                  <th>Tgl Resep</th>
                                  <th>Dokter</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- Modal -->
  <!-- Modal Batal Registrasi -->
  <div class="modal fade" id="modal_alert_batal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Batal Transaksi UDD</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="frmBatalReg">
                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-4 control-label">No. Transaksi</label>
                          <div class="col-sm-6">
                              <input class="form-control input-sm" type="text" id="noregbatal" readonly autocomplete="off" name="noregbatal" placeholder="ketik Kata Kunci disini">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                          <div class="col-sm-6">
                              <textarea class="form-control" id="alasanbatal" name="alasanbatal" rows="3"></textarea>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnVoidTrsReg" name="btnVoidTrsReg"><i class="fa fa-plus"></i> Batal </button>
                      <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- Modal Batal Registrasi -->
  <!-- Modal Batal Registrasi -->
  <div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Form Cetak UDD</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-sm-4">
                          <p class="text-center"><strong>Cetak Label UDD</strong></p><br>
                          <form id="TheForm" method="post" action="halaman/Print/print_bukti_reg.php" target="TheWindow">
                              <input type="hidden" name="cetaknoregis" id="cetaknoregis" />
                          </form>
                          <img src="<?= BASEURL; ?>/images/jenis_reg/LogoPasienUmum.Png" id="logocetakbuktireg" class="img-circle person" alt="Random Name" width="150" height="150">
                      </div>
                       
                  </div>
                   
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnclosemodalcetak" name="btnclosemodalcetak"><i class="fa fa-times"></i>CLOSE</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/inventory/udd/udd_input.js"></script>