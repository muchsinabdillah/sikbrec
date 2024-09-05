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
                                  <h5 class="underline mt-30">DATA ORDER RADIOLOGI</h5>
                                  <div class="form-group  ">
                                      <input class="form-control input-sm " id="IdRegistrasi" readonly name="IdRegistrasi" type="hidden" value="<?= $data['woid'] ?>">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> WOID <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" type="text" id="Rad_WOID" autocomplete="off" name="Rad_WOID" placeholder="Scan barcode Here" value="<?= $data['woid'] ?>" autocomplete="off">
                                      </div>
                                      <div class="col-sm-2">
                                          <div class="btn-group" role="group">
                                              <a href="#modalCariDataListOrderRad" data-toggle="modal" class="btn btn-primary btn-sm btn-rounded " id="btn_caridatamr">
                                                  <span class="glyphicon glyphicon glyphicon-search"></span></a>
                                          </div>

                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Accession Number <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" type="text" autocomplete="off" id="Rad_Acc_Number" readonly name="Rad_Acc_Number">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Pemeriksaan <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" readonly type="date" id="Rad_TglPeriksa" name="Rad_TglPeriksa" placeholder="Jenis Pasien">
                                      </div>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Rad_TglKunjungan" readonly name="Rad_TglKunjungan" type="text">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Department Request <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Rad_Department_req" readonly name="Rad_Department_req" type="text" value="YARSI" placeholder="Ketik Tpt Lahir Pasien">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. MR <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Rad_NoMR" readonly name="Rad_NoMR" type="text" placeholder="Ketik No. MR">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Pemeriksaan <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-1">
                                          <input class="form-control input-sm " id="Rad_Kode_Tarif" readonly name="Rad_Kode_Tarif" type="text" placeholder="ID">
                                      </div>
                                      <div id="ShowTarif">
                                          <div class="col-sm-3">
                                              <select class="form-control input-sm" name="Rad_Select" id="Rad_Select" onchange="getTarifRad()" style="width:100%">
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-sm-3">
                                          <input class="form-control input-sm " id="Rad_Nama_Tarif" readonly name="Rad_Nama_Tarif" type="text" placeholder="Ketik Nama Pemeriksaan">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Episode </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Rad_NoEpisode" readonly name="Rad_NoEpisode" type="text" placeholder="Ketik No. Episode">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Modality/Action </label>
                                      <div class="col-sm-1">
                                          <input class="form-control input-sm " id="Rad_ModalityCodes" name="Rad_ModalityCodes" type="text" placeholder="Ketik Modality Codes" readonly>
                                      </div>
                                      <div class="col-sm-3">
                                          <input class="form-control input-sm " id="Rad_ActionCodes" name="Rad_ActionCodes" type="text" placeholder="Ketik Action Codes" readonly>
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Registrasi </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Rad_NORegistrasi" readonly name="Rad_NORegistrasi" type="text" placeholder="Ketik No. Registrasi" value="<?= $data['noregistrasi'] ?>">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Position/Side </label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Rad_Position" readonly name="Rad_Position" type="text" placeholder="Ketik Position">
                                      </div>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="Rad_Side" readonly name="Rad_Side" type="text" placeholder="Ketik Side">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Rad_NamaPasien" readonly name="Rad_NamaPasien" type="text" placeholder="Ketik Nama Pasien">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Nilai Tarif </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Rad_Nilai" readonly name="Rad_Nilai" type="text" placeholder="Ketik Nilai Tarif">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Dokter </label>
                                      <div class="col-sm-1">
                                          <input class="form-control input-sm " id="Rad_IdDokter" readonly name="Rad_IdDokter" type="text" placeholder="Ketik ID Dokter">
                                      </div>
                                      <div class="col-sm-3">
                                          <input class="form-control input-sm " id="Rad_NamaDokter" readonly name="Rad_NamaDokter" type="text" placeholder="Ketik Nama Dokter">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Diagnosa </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Rad_Daignosa" name="Rad_Daignosa" type="text" placeholder="Ketik Diagnosa">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik </label>
                                      <div class="col-sm-1">
                                          <input class="form-control input-sm " id="Rad_IdPoli" readonly name="Rad_IdPoli" type="text" placeholder="Ketik ID Poli">
                                      </div>
                                      <div class="col-sm-3">
                                          <input class="form-control input-sm " id="Rad_Nama_Poli" readonly name="Rad_Nama_Poli" type="text" placeholder="Ketik Nama Poli">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Ket Klinis </label>
                                      <div class="col-sm-4">
                                          <textarea class="form-control input-sm" id="Rad_Keterangan_Klinik" name="Rad_Keterangan_Klinik" rows="4" style="resize: none"></textarea>

                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Patient Location </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="Rad_Patient_Loc" readonly name="Rad_Patient_Loc" type="text" placeholder="Ketik Nama Pasien" value="RWJ">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Urgensi </label>
                                      <div class="col-sm-4">
                                      <select name="Rad_iscito" id="Rad_iscito" class="form-control">
                                            <option value=""> -- PILIH -- </option>
                                            <option value="BIASA"> BIASA </option>
                                            <option value="CITO"> CITO </option>
                                        </select>

                                      </div>
                                  </div>
                                  <h5 class="underline mt-30">DATA VERIFIKASI ORDER RADIOLOGI</h5>
                                  <div class="form-group">
                                      <div class="col-sm-8">
                                          <div class="alert alert-danger" role="alert"> <strong>Informasi !</strong> Verifikasi dokter di bawah ini diisi oleh Petugas Radiologi! </div>
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Radiologi </label>
                                      <div class="col-sm-1">
                                          <input class="form-control input-sm" type="text" id="dokterid" readonly name="dokterid">
                                      </div>
                                      <div class="col-sm-3">
                                          <div id="hide_dokter">
                                              <select class="col-sm-10 js-example-basic-single" name="dokter" id="dokter" onchange="getDoktername()" onmouseover="dokterselect2active(this)">
                                              </select>
                                          </div>
                                          <input class="form-control input-sm" type="text" id="shownamdokterfix" readonly name="shownamdokterfix">

                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Ket Hasil Diambil</label>
                                      <div class="col-sm-4">

                                          <textarea class="form-control input-sm" id="Rad_Keterangan_Klinik" name="Rad_Keterangan_Klinik" rows="4" style="resize: none"></textarea>

                                      </div>
                                  </div>

                              </form>
                              <div class="btn-group" role="group">

                                  <button class="btn btn-success  btn-rounded " id="btnprint" name="btnprint">
                                      <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                                      Verifikasi Dokter
                                  </button>
                                  <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs">
                                      <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                                      Batal Verifikasi</button>
                                  <button class="btn btn-danger  btn-rounded " id="btnSelesai" name="btnSelesai">
                                      <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
                                  <button class="btn btn-secondary  btn-rounded " id="close" name="close" onclick="showModalDel()">
                                      <i class="fa fa-trash" aria-hidden="true"></i> Batal</button>
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

  <!-- Modal Untuk Notif Resep ------------------------------------------------>
  <div class="modal fade" id="modal_alert_batalhdr" tabindex="-1" role="dialog" style="overflow-y: auto">

<div class="modal-dialog modal-md">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"> Pesan Konfirmasi </h4> 
    </div>
    <div class="modal-body">
      <form id="frmBatalReg">
             <p><b>Setelah Anda Hapus Order Ini, Silahkan konfirmasi ke Petugas Radiologi dengan cara Menyebutkan Accesion Number.</b></br></br>

Apakah Anda ingin menambahkan Pemeriksaan ini ?</p>   </br>
             <div class="row" style="margin-bottom:3px;">
                  <label for="doktexr" class="col-sm-2 col-form-label">ID: </label>
                    <div class="col-sm-8">
                      <input class="form-control input-sm " id="noregbatalHdr" readonly name="noregbatalHdr" type="text">
                    </div>
            </div>
            <div class="row" style="margin-bottom:3px;">
                  <label for="dokter" class="col-sm-2 col-form-label">Alasan : </label>
                    <div class="col-sm-8">
                      <textarea class="form-control" id="alasanbatalHdr"  name="alasanbatalHdr" rows="3"></textarea>
                    </div>
            </div>
      </form>
    </div>
    <div class="modal-footer">
                 <div class="btn-group" role="group" style="margin-right:1em;float:right;">

                    <button class="btn btn-primary btn-rounded"  id="btnVoidTrsRegHdr" name="btnVoidTrsRegHdr" > YA </button>
                    <button class="btn btn-danger btn-rounded" id="btnVoidTrsRegBatalHdr" name="btnVoidTrsRegBatalHdr" data-dismiss="modal">
                    TIDAK</button>  
                </div>
    </div>
  </div>
</div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
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
  <div class="modal fade" id="modalCariDataListOrderRad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Cari Data Order Radiologi <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_cuti">
                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-3 control-label"> Masukan Kata Kunci <sup class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="txSearchData" autocomplete="off" name="txSearchData" placeholder="ketik Kata Kunci disini">
                          </div>
                          <div class="col-sm-2">
                              <button type="button" id="caridatapoli" onclick="loadDataOrderRadiologi();" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
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
                                  <th>Poliklinik</th>
                                  <th>Accession Number</th>
                                  <th>Nama Dokter</th>
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
  <!-- Modal -->
  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/emr/radiologi/OrderRadiologi_v01.js"></script>