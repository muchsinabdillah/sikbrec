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
                              <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                  <h5 class="underline mt-30">DATA ORDER</h5>
                                  <div class="form-group  ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Order <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" maxlength="15" readonly autocomplete="off" type="hidden" id="IDNoTrsOrder" name="IDNoTrsOrder" value="<?= $data['id'] ?>">
                                          <input class="form-control input-sm" readonly autocomplete="off" type="text" id="NoTrsOrder" name="NoTrsOrder">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Order <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" maxlength="8" readonly autocomplete="off" type="date" id="TglOrder" name="TglOrder">
                                      </div>
                                  </div>

                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Keterangan<sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" readonly autocomplete="off" type="text" id="Keterangan" name="Keterangan">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nilai Order<sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" readonly autocomplete="off" type="text" id="NilaiOrder" name="NilaiOrder">
                                      </div>
                                  </div>
                                  <h5 class="underline mt-30">DATA PENCAIRAN</h5>
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Trs Pencairan<sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" readonly autocomplete="off" type="text" id="NoTrsPencairan" name="NoTrsPencairan">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Tipe Kasbon </label>
                                      <div class="col-sm-4">
                                          <select id='TipeKasbon' style="width: 100%;" readonly name='TipeKasbon' class="form-control">
                                              <option value="">-- PILIH --</option>
                                              <option value="REGULER">REGULER</option>
                                              <option value="CITO">CITO</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pegawai<sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <select id='IDPegawaiOrder' style="width: 100%;" readonly name='IDPegawaiOrder' class="form-control">
                                          </select>
                                      </div>

                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Realisasi </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" type="datetime-local" id="TglRealRealisasi" name="TglRealRealisasi" value="2022-06-14T15:37:41" step="1">

                                      </div>

                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Rekening Kas </label>
                                      <div class="col-sm-4">
                                          <select id='RekeningKas' style="width: 100%;" name='RekeningKas' class="form-control">
                                          </select>
                                      </div>

                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nilai Pencairan <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" type="text" id="NilaiPencairan" name="NilaiPencairan">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Keterangan <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" type="text" id="KeteranganPencairan" name="KeteranganPencairan">
                                      </div>
                                  </div>
                              </form>
                              <div class="btn-group" role="group">
                                  <button class="btn btn-success  btn-rounded " id="batal" name="batal" href="#notif_Cetak" data-toggle='modal'>
                                      <span class="glyphicon glyphicon-print"></span> Cetak</button>
                                  <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs"><i class="fa fa-save"></i> Simpan</button>
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
  <!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
  <div class="modal fade" id="modal_BPJSCekPesertaa" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

      <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> Verifikasi Kepesertaan BPJS Kesehatan</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. SPR <sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" maxlength="15" readonly autocomplete="off" type="text" id="SPRI_NoSPR" name="SPRI_NoSPR" value="<?= $data['id'] ?>">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. Rekam Medik <sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" maxlength="8" readonly autocomplete="off" type="text" id="SPRI_NoRM" name="SPRI_NoRM">
                          </div>
                      </div>
                      <div class="form-group gut ">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. Episode<sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly autocomplete="off" type="text" id="SPRI_Noepisode" name="SPRI_Noepisode">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> No. Registrasi <sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" autocomplete="off" readonly type="text" id="SPRI_NoRegistrasi" name="SPRI_NoRegistrasi">
                          </div>
                      </div>
                      <div class="form-group gut ">
                          <label for="inputEmail3" class="col-sm-2 control-label"> DPJP Ranap<sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly autocomplete="off" type="text" id="SPRI_DPJPRanap" name="SPRI_DPJPRanap">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Tujuan Rawat <sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" autocomplete="off" readonly type="text" id="SPRI_Tujuan" name="SPRI_Tujuan">
                          </div>
                      </div>
                      <div class="form-group gut ">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien<sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly autocomplete="off" type="text" id="SPRI_NamaPasien" name="SPRI_NamaPasien">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Reg IGD <sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" autocomplete="off" readonly type="date" id="SPRI_Tglberobat" name="SPRI_Tglberobat">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Masukan No. Kartu <sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" autocomplete="off" maxlength="13" type="text" id="SPRI_NoKartu" name="SPRI_NoKartu">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> </label>
                          <div class="col-sm-4">
                              <button class="btn btn-primary btn-sm" type="button" id="btnCekKepesertaan" name="btnCekKepesertaan">Search</button>
                          </div>
                      </div>

                  </form>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-default btn-sm" type="button" id="btnCloseVerifikasi" name="btnCloseVerifikasi"> <i class="fa fa-mail-reply-all"></i> Close</button>
              </div>
          </div>
      </div>
  </div>
  <!--#END Modal Untuk Notif Resep---------------------------->
  <!-- Modal Batal Registrasi -->
  <div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Cetak Bukti Bon Sementara</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-sm-4">
                          <p class="text-center"><strong>Cetak Bon Sementara</strong></p><br>
                          <img src="<?= BASEURL; ?>/images/jenis_reg/LogoBPJS.Png" id="logocetakbuktiSEP" class="img-circle person" alt="Random Name" width="150" height="150">
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnclosemodalcetak" name="btnclosemodalcetak" onclick="MyBack();"><i class="fa fa-times"></i>CLOSE</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- Modal -->
  <!-- ========== COMMON JS FILES ========== -->
  <!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
  <div class="modal fade" id="modal_UpdateTglPulang" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

      <div class="modal-dialog modal-md">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> Batal/Hapus SPRI</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                      <h5 class="underline mt-30">Data SPRI</h5>

                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-4 control-label"> No. SPRI <sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" id="NOspri" name="NOspri" value="<?= $data['id'] ?>">
                          </div>
                      </div>
                      <div class="form-group ">
                          <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                          <div class="col-sm-8">
                              <textarea class="form-control" id="alasanbatal" name="alasanbatal" rows="3"></textarea>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button class="btn bg-danger  btn-wide" id="btnBatalSIPR" name="btnBatalSIPR"><i class="fa fa-check"> </i> BATAL</button>
              </div>
          </div>
      </div>
  </div>
  <!-- Modal Batal Registrasi -->
  <div class="modal fade" id="notif_ShowTTD_Digital" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Entri Alasan Cetak Anda disini</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="frmDigitalSign">
                      <div class="form-group gut ">
                          <label for="inputEmail3" class="col-sm-4 control-label">No. SPRI</label>
                          <div class="col-sm-6">
                              <input class="form-control input-sm" type="text" id="signNoSep" readonly autocomplete="off" name="signNoSep">
                          </div>
                      </div>
                      <div class="form-group gut ">
                          <label for="inputEmail3" class="col-sm-4 control-label">Alasan Cetak</label>
                          <div class="col-sm-6">
                              <input class="form-control input-sm" type="text" id="signAlasanCetak" autocomplete="off" name="signAlasanCetak" placeholder="ketik Alasan Cetak disini">
                              <small>Silahkan Masukan Alasan cetak selengkap mungkin, untuk memudahkan Tracing Data.</small>
                          </div>

                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btncetakDigital" name="btncetakDigital"><i class="fa fa-print"></i> PRINT </button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
  <div class="modal fade" id="modal_Pengajuan2" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

      <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> Cek Ketersediaan Poliklinik</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                      <br>
                      <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                          <table id="tbl_Ketersediaan_Poli" width="100%" class="table table-striped table-hover cell-border">
                              <thead>
                                  <tr>
                                      <th align='center'>
                                          <font size="1">Kode Poli
                                      </th>
                                      <th align='center'>
                                          <font size="1">Nama Poli
                                      </th>
                                      <th align='center'>
                                          <font size="1">Kapasitas
                                      </th>
                                      <th align='center'>
                                          <font size="1">Jumlah Rujukan
                                      </th>
                                      <th align='center'>
                                          <font size="1">Presentase
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
                  <div class="btn-group" role="group">
                      <button data-dismiss="modal" class="btn btn-secondary btn-rounded " id="close" name="close"> <i class="fa fa-mail-reply-all"></i> Close</button>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--#END Modal Untuk Notif Resep---------------------------->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/finance/pencairankasbonentry.js"></script>