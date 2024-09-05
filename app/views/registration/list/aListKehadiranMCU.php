<?php
    date_default_timezone_set('Asia/Jakarta');
    $id = "";
    $datenowcreate = date("Y-m-d");
    $datetimenow = date("Y-m-d\TH:i:s");
    ?>
  <div class="main-page">
      <section class="section" style="margin-top: -20px;">
          <div class="container-fluid">

              <div class="row">
                  <div class="col-md-12">
                      <div class="panel">
                          <div class="panel-heading">
                              <div class="panel-title">
                                  <h5 class="underline mt-30"><?= $data['judul'] ?><small></small>
                                      <div class="btn-group" role="group">
                                          <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="goScan();">
                                              <span class="glyphicon glyphicon glyphicon-plus"></span> Scan QR Code</a>
                                            <form id="form_approve">
                                            </form>
                                      </div>
                                  </h5>
                              </div>
                          </div>
                          <div class="panel-body">
                              <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                  <!-- Nav tabs -->
                                  <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                      <li role="presentation" class="active"><a class="" href="#datadetil" aria-controls="datadetil" role="tab" data-toggle="tab">Pasien Aktif</a>
                                      </li>
                                      <!-- <li role="presentation"><a class="" href="#pendidikan" aria-controls="pendidikan" role="tab" data-toggle="tab">Arsip Pasien</a></li> -->

                                  </ul>
                                  <!-- Tab panes -->
                                  <div class="tab-content bg-white p-15">

                                      <div role="tabpanel" class="tab-pane active" id="datadetil">

                                          <div class="demo-table"   id="tbl_rekap" style="margin-top: 10px;overflow-x:auto; ">
                                              <table id="tbl_aktif" width="100%" class="table table-striped table-hover cell-border">
                                                  <thead>
                                                      <tr>
                                                          <th >ID</th>
                                                          <th align='center' width="10%">
                                                              <font size="1">No MR
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Nama Pasien
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Tanggal
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">No. Episode
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">No. Registrasi
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Poliklinik
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Dokter
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Jaminan
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">User
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Status Kehadiran
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Action
                                                          </th>
                                                      </tr>
                                                  </thead>
                                                    <tbody id='tabledatareservasi'>

                                                    </tbody>
                                                  <tfoot>
                                                        <tr>
                                                            <th colspan="11"></th>
                                                            <th align="center"><button type="button"
                                                                    title="Kirim Yang Dipilih"
                                                                    class="btn btn-success btn-xs"
                                                                    id="cb_approvefarmasiall"
                                                                    name="cb_approvefarmasiall"
                                                                    onclick="BtnApprove(this)"><i class="fa fa-whatsapp"
                                                                        aria-hidden="true"></i> Kirim Reminder </button>
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                              </table>
                                          </div>


                                      </div>
                                      <div role="tabpanel" class="tab-pane" id="pendidikan">
                                          <form class="form-horizontal" id="form_resign">
                                              <div class="form-group  ">
                                                  <label for="inputEmail3" class="col-sm-3 control-label"> Masukan
                                                      Periode Pencarian <sup class="color-danger">*</sup></label>
                                                  <div class="col-sm-2">
                                                      <input class="form-control input-sm" type="date" id="tglAwalarsip" autocomplete="off" name="tglAwalarsip" placeholder="ketik Kata Kunci disini">
                                                  </div>
                                                  <div class="col-sm-2">
                                                      <input class="form-control input-sm" type="date" id="tglAkhirArsip" autocomplete="off" name="tglAkhirArsip" placeholder="ketik Kata Kunci disini">
                                                  </div>
                                              </div>
                                          </form>
                                          <div class="form-group  ">
                                              <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                              <div class="col-sm-2">
                                                  <button type="button" onclick="showDataPasienRajalArsip();" id="caridatapasienarsip" class="btn btn-success btn-wide btn-rounded"><i class="fa fa-search"></i>Search</button>
                                              </div>
                                          </div>
                                          <div class="demo-table" width="100%" id="tbl_rekap" style="margin-top: 10px;overflow-x:auto;">
                                              <table id="tbl_arsip" width="100%" class="table table-striped table-hover cell-border">
                                                  <thead>
                                                      <tr>
                                                          <th style="display:none;">Visit Date</th>
                                                          <th align='center'>
                                                              <font size="1">No MR
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Nama Pasien
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Tanggal
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">No. Episode
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">No. Registrasi
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Poliklinik
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Dokter
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">Jaminan
                                                          </th>
                                                          <th align='center'>
                                                              <font size="1">User
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
                                      </div>
                                  </div>
                              </form>
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

  <!-- Modal Konfirmasi Pesan SIMPAN -->
  <div class="modal fade " id="modal_edit_sep" data-bs-focus="false" role="dialog">
      <div class="modal-dialog  modal-md">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header"> 
                  <h4 class="modal-title"> Update No. SEP Pasien </h4>
              </div>
              <div class="modal-body">
                  <form id="frmUpdateSEP">
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">ID :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="NOID_Reg" name="NOID_Reg" maxlength="19" readonly>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">No.Registrasi :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="Noreg" name="Noreg" maxlength="19" readonly>
                              <input class="form-control input-sm" type="hidden" id="No_MR" name="No_MR" maxlength="19" readonly>
                              <input class="form-control input-sm" type="text" id="NoPesertaBPJS" name="NoPesertaBPJS" maxlength="19" readonly>
                              <input class="form-control input-sm" type="hidden" id="NO_RUJUKAN" name="NO_RUJUKAN" maxlength="19" readonly>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">No SEP Lama :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="NoSEPLama" name="NoSEPLama" maxlength="19" readonly>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">No SEP Baru :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" autocomplete="off" id="NoSEPBaru" name="NoSEPBaru" maxlength="19">
                          </div>
                          <div class="col-sm-1" style="margin-left: -25px;">
                              <a href="#" data-toggle='modal' class="btn btn-primary btn-sm" onclick="verifySEp()"><span class="glyphicon glyphicon glyphicon-search"></span>Verify</a>
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">Hak Kelas BPJS :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" autocomplete="off" id="hakKelasBPJS" name="hakKelasBPJS" maxlength="19">
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">PRB / Prolanis :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" autocomplete="off" id="keteranganprbBPJS" name="keteranganprbBPJS" maxlength="19">
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">diagnosa Ina cbg :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" autocomplete="off" id="diagnosaInacbg" name="diagnosaInacbg" maxlength="19">
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">Nilai Gruper :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" autocomplete="off" id="nilai_Gruper" name="nilai_Gruper" maxlength="19">
                          </div>
                      </div>
                      <div class="row" style="margin-bottom:3px;">
                          <label for="namapasien" class="col-sm-4 col-form-label">lama di rawat :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" autocomplete="off" id="lama_dirawat" name="lama_dirawat" maxlength="19">
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                    <button data-toggle='modal' class="btn btn-warning btn-sm" type="button" id="btnUpdateSEP_Manual" name="btnUpdateSEP_Manual">
                            PASIEN MASUK RANAP
                        </button>
                  <button data-toggle='modal' class="btn btn-danger btn-sm" type="button" id="btnUpdateSEP" name="btnUpdateSEP">
                      UPDATE NO SEP
                  </button>
              </div>
          </div>
      </div>
  </div>
  <!-- Modal Konfirmasi Pesan SIMPAN end -->
  <!-- Modal Batal Registrasi -->
  <div class="modal fade" id="modal_AntrolJenisKunungan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog  modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Send Antrian BPJS Kesehatan</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="frmBatalReg">
                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-4 control-label">Jenis Kunjungan</label>
                          <div class="col-sm-6">
                              <select id="AntrolJenisKunungan" name="AntrolJenisKunungan" style="width: 100%;" class="form-control ">
                                  <option value="">-- PILIH JENIS KUNJUNGAN --</option>
                                  <option value="1">Rujukan FKTP</option>
                                  <option value="2">Rujukan Internal</option>
                                  <option value="3">Kontrol</option>
                                  <option value="4">Rujukan Antar RS</option>
                              </select>
                          </div>
                      </div>

                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnSendAntrol" name="btnSendAntrol"><i class="fa fa-plus"></i> Send </button>
                      <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnSendAntrolClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                  </div>
                  <!-- /.btn-group -->
              </div>
          </div>
      </div>
  </div>
  <!-- Modal Batal Registrasi -->

  <div class="right-sidebar bg-white fixed-sidebar">
      <div class="sidebar-content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <h4>Useful Sidebar <i class="fa fa-times close-icon"></i></h4>
                      <p>Code for help is added within the main page. Check for code below the example.</p>
                      <p>You can use this sidebar to help your end-users. You can enter any HTML in this sidebar.</p>
                      <p>This sidebar can be a 'fixed to top' or you can unpin it to scroll with main page.</p>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                          labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                          laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                          voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                          non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/registration/list/listkehadiranmcu.js"></script>