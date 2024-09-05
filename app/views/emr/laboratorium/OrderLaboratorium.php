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
                                  <h5 class="underline mt-30">DATA ORDER LABORATORIUM</h5>
                                  <div class="form-group">
                                      <div class="col-sm-12">
                                          <div class="alert alert-success" role="alert">
                                              <strong>Informasi !</strong> Silahkan isikan data dengan baik dan benar.<br>
                                              <strong>Informasi !</strong> Jika Pemeriksaan Sudah Di receive, Silahkan buat Transaksi Pemeriksaan Laboratorium baru dengan Cara refresh Halaman. <br>
                                              <strong>Informasi !</strong> Silahkan tekan F5 untuk Refresh halaman.<br>
                                              <strong>Informasi !</strong> Silahkan tekan F5 untuk Refresh halaman.
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group  ">
                                      <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Rec ID <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" type="text" id="Lab_RecID" autocomplete="off" name="Lab_RecID" placeholder="Ketik No. Rec ID" readonly autocomplete="off">
                                          <input class="form-control input-sm" type="text" id="is_batal" autocomplete="off" name="is_batal" readonly autocomplete="off">
                                      </div>
                                      <div class="col-sm-2">
                                          <div class="btn-group" role="group">
                                              <a href="#modalCariDataListOrderLab" data-toggle="modal" class="btn btn-primary btn-sm btn-rounded " id="btn_caridatamr">
                                                  <span class="glyphicon glyphicon glyphicon-search"></span></a>
                                          </div>

                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> No. Lab <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" readonly type="text" id="Lab_NoLab" name="Lab_NoLab" placeholder="No. Lab Order">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label">Tgl Pemeriksaan <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Lab_TglPeriksa" readonly name="Lab_TglPeriksa" type="date" placeholder="Ketik No. MR">

                                          <input class="form-control input-sm " id="Lab_TglKunjungan" readonly name="Lab_TglKunjungan" type="text">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Kategori Order <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Lab_Kategori" value="BIASA" readonly name="Lab_Kategori" type="text" placeholder="Silahkan Ketik Kategori Order">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Episode <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Lab_NoEpisode" readonly name="Lab_NoEpisode" type="text" placeholder="Ketik No. Episode">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> No. Registrasi <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Lab_NORegistrasi" readonly name="Lab_NORegistrasi" type="text" placeholder="No. Registrasi" value="<?= $data['noregistrasi'] ?>">
                                      </div>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Lab_NoMR" readonly name="Lab_NoMR" type="text" placeholder="Ketik Nama Pemeriksaan">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Lab_NamaPasien" readonly name="Lab_NamaPasien" type="text" placeholder="Ketik Nama Pasien">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Jaminan </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Lab_Namajaminan" name="Lab_Namajaminan" type="text" placeholder="Ketik Nama Jaminan" readonly>
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Ket Booking </label>
                                      <div class="col-sm-4">
                                          <textarea class="form-control input-sm" id="Lab_Description_Booking" name="Lab_Description_Booking" rows="3" readonly></textarea>
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Status</label>
                                      <div class="col-sm-4">
                                          &nbsp&nbsp<span id="status_span"></span>
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Lab_Daignosa" autocomplete="off" name="Lab_Daignosa" type="text" placeholder="Ketik Diagnosa">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Dokter Operator <sup class="color-danger">*</sup> </label>
                                      <div class="col-sm-4">
                                          <select class="form-control input-sm " name="Lab_Dokter_Operator" id="Lab_Dokter_Operator">
                                          </select>
                                      </div>
                                  </div>
                                 
                                  <div class="form-group gut">
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Ket Klinis <sup class="color-danger">*</sup> </label>
                                      <div class="col-sm-4">
                                          <textarea class="form-control input-sm" id="Lab_Keterangan_Klinik" name="Lab_Keterangan_Klinik" rows="4" style="resize: none"></textarea>
                                      </div>
                                      <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                                      <div class="col-sm-4">

                                      </div>
                                  </div>

                                  
                              <div class="form-group gut">
                                  <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                                  <div class="col-sm-4">
                                      <button type="button" class="btn btn-success  btn-rounded " id="btnnewtransaksi" name="btnnewtransaksi">
                                          <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                                          New Order
                                      </button>

                                  </div>

                              </div><hr><br>

                              <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pemeriksaan <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <select class="form-control input-sm" name="Lab_kodeTes" id="Lab_kodeTes" onchange="getTarifLaboratorium()">
                                          </select>
                                          <input class="form-control input-sm" type="text" id="Lab_kodeTes_2" readonly name="Lab_kodeTes_2">
                                          <input class="form-control input-sm" type="hidden" id="Lab_kodeTes_kelompok" readonly name="Lab_kodeTes_kelompok">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Nilai Tarif <sup class="color-danger">*</sup> </label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Lab_Nilai" name="Lab_Nilai" type="text" readonly placeholder="Ketik Nilai Tarif">
                                      </div>
                                      <div class="col-sm-2">
                                      <button type="button" id="btnAddDetail" name="btnAddDetail" class="btn btn-success btn-sm">
                                          TAMBAH PEMERIKSAAN
                                      </button>
                                  </div>

                                  </div>
                              </form><br>

                              <div class="form-group gut">
                                  <label for="inputEmail3" class="col-sm-2 control-label"> </label>
                                  

                              </div>
                              <h5 class="underline mt-30">DATA DETAILS ORDER LABORATORIUM</h5>
                              <div class="table-responsive">
                                  <table id="table-id" class="display table table-striped table-bordered" width="100%">
                                      <thead>
                                          <tr>
                                              <th>
                                                  <font size="1">No.</font>
                                              </th>
                                              <th>
                                                  <font size="1">Kode Test</font>
                                              </th>
                                              <th>
                                                  <font size="1">Nama Pemeriksaan</font>
                                              </th>
                                              <th>
                                                  <font size="1">Tarif</font>
                                              </th>
                                              <th>
                                                  <font size="1">Action</font>
                                              </th>
                                          </tr>
                                      </thead>
                                  </table>

                              </div><br>
                              <div class="btn-group" role="group">

                                  <button class="btn btn-primary  btn-rounded " id="btnSelesai" name="btnSelesai">
                                      <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                  <button class="btn btn-danger  btn-rounded " id="close" name="close" onclick="showModalDel()">
                                      <i class="fa fa-trash" aria-hidden="true"></i> Batal</button>

                                  <button class="btn btn-secondary  btn-rounded " id="btnClose" name="btnClose">
                                      <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                                      Close</button>
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

  <!-- Modal -->
  <div class="modal fade" id="modalCariDataListOrderLab" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Cari Data Order Laboratorium <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_cuti">
                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-3 control-label"> Load Data <sup class="color-danger">*</sup></label>

                          <div class="col-sm-2">
                              <button type="button" id="caridatapoli" onclick="loadDataOrderLaboratorium();" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                          </div>
                      </div>
                  </form>
                  <div class="table-responsive">
                      <table id="table-load-data" class="display table table-striped table-bordered" width="100%">
                          <thead>
                              <tr>
                                  <th>No MR</th>
                                  <th>Nama Pasien</th>
                                  <th>No Episode</th>
                                  <th>No. Registrasi</th>
                                  <th>Poliklinik</th>
                                  <th>No. Lab</th>
                                  <th>User</th>
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
  <!-- Modal -->
  <div class="modal fade" id="modalNotificationOrdeLab" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Informasi Pembaruan <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
              </div>
              <div class="modal-body">
                  UPDATE LOG:
                  <p>Sekarang terdapat status orderan, yang dimana jika status <font style="background-color: grey">NEW</font> maka pengorder bisa membatalkan, menambahkan pemeriksaan, menghapus pemeriksaan transaksi yang sudah <b>diorder sebelumnya</b>, dengan catatan jika penambahan pemeriksaan harus mengklik tombol <button class="btn btn-primary waves-effect" href="#modal_alert_selesai">Simpan</button> untuk pengubahan data di LIS.</p>
                  <p>Jika status <font style="background-color: #00fff2">RECEIVE</font>, <font style="background-color: yellow">PROCESSING</font>, <font style="background-color: green">SUDAH ADA HASIL</font> maka pengorder tidak bisa melakukan penambahan pemeriksaan, ataupun penghapusan transaksi. Silahkan buat Transaksi Pemeriksaan Laboratorium baru. </p>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-danger btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-plus"></i>Saya Mengerti</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- Modal -->
  <!-- Modal -->
  <div class="modal fade" id="modal_alert_verifdetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Pesan Konfirmasi <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
              </div>
              <div class="modal-body">
                  <form id="frmBatalReg">
                      <p><b>Sample Sudah Di receive Oleh Petugas Laboratorium, Jika anda ingin menambah kan Pemeriksaan baru Silahkan Hubungi
                              petugas Lab Setelah Anda Menambahkan Order ini.</b></br></br>

                          Apakah Anda ingin menambahkan Pemeriksaan ini ?</p>
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-danger btn-wide btn-rounded" id="btnVerifdtil"><i class="fa fa-plus"></i>YA</button>
                      <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnModalSrcsPasienClose" data-dismiss="modal"><i class="fa fa-plus"></i>TIDAK</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- Modal -->
  <!-- Modal Batal Registrasi -->
  <div class="modal fade" id="modal_alert_bataldetil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Batal Detail Order Laboratorium</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="frmBatalReg">
                      <p>Apakah Anda Yakin Ingin Batalkan Pemeriksaan ini ?</p>
                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-4 control-label">No. ID</label>
                          <div class="col-sm-6">
                              <input class="form-control input-sm" type="text" id="NoDetilOrder" readonly autocomplete="off" name="NoDetilOrder" placeholder="ketik Kata Kunci disini">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                          <div class="col-sm-6">
                              <textarea class="form-control" id="alasanbatalDetil" name="alasanbatalDetil" rows="3"></textarea>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-danger btn-wide btn-rounded" id="btnVoidTrsDetil" name="btnVoidTrsDetil"><i class="fa fa-plus"></i> Batal </button>
                      <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- Modal Batal Registrasi -->
  <div class="modal fade" id="modal_alert_batalOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Batal Order Laboratorium</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="frmBatalReg">
                      <p>Apakah Anda Yakin Ingin Batalkan Pemeriksaan ini ?</p>
                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-4 control-label">No. ID</label>
                          <div class="col-sm-6">
                              <input class="form-control input-sm" type="text" id="NoLabOrderBatal" readonly autocomplete="off" name="NoLabOrderBatal" placeholder="ketik Kata Kunci disini">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                          <div class="col-sm-6">
                              <textarea class="form-control" id="alasanbatalOrder" name="alasanbatalOrder" rows="3"></textarea>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-danger btn-wide btn-rounded" id="btnVoidTrs" name="btnVoidTrs"><i class="fa fa-plus"></i> Batal </button>
                      <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="modal_alert_konfirmasi_payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Konfirmasi Pembayaran</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="frmBatalReg">
                      <p><b>Apakah Sudah Melakukan Payment ?</b></p>
                      <p>Jika sudah akan tergenerate payment secara otomatis dan bill akan langsung diclose, dan rincian akan dikirimkan lansung ke pasien</p>
                      <!-- <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-4 control-label">No. ID</label>
                          <div class="col-sm-6">
                              <input class="form-control input-sm" type="text" id="NoLabOrderBatal" readonly autocomplete="off" name="NoLabOrderBatal" placeholder="ketik Kata Kunci disini">
                          </div>
                      </div> -->
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnSudahBayar" name="btnVoidTrs"><i class="fa fa-plus"></i> Sudah </button>
                      <button type="button" class="btn btn-danger btn-wide btn-rounded" id="btnBelumBayar" data-dismiss="modal"><i class="fa fa-times"></i>Belum</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="modal_alert_konfirmasi_send"  tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Kirim Rincian Biaya</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="frmBatalRegRincian">
                      <!-- <p><b>Apakah Sudah Melakukan Payment ?</b></p>
                      <p>Jika sudah akan tergenerate payment secara otomatis dan bill akan langsung diclose, dan rincian akan dikirimkan lansung ke pasien</p> -->
                      <div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label">No. HP</label>
                          <div class="col-sm-6">
                              <input class="form-control input-sm" type="text" id="NoHPSend"  autocomplete="off" name="NoHPSend" placeholder="081333242123">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                          <div class="col-sm-6">
                              <input class="form-control input-sm" type="text" id="EmailSend"  autocomplete="off" name="EmailSend" placeholder="contoh@gmail.com">
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
              <div class="btn-group" role="group">
                      <button type="button" class="btn btn-success btn-wide btn-rounded" id="btnPreviewRincian" name="btnPreviewRincian"> Preview </button>
                  </div>
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnKirimRincian" name="btnKirimRincian"> Kirim </button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/emr/laboratorium/OrderLaboratorium_v07.js"></script>