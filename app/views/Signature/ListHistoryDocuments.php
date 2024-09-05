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
                                      
                                  </h5>
                              </div>
                          </div>
                          <div class="panel-body">
                              <form class="form-horizontal" id="frmSimpanTrsRegistrasi">

                              <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> No. Episode/Registrasi</label>
                                        <div class="col-sm-2">
                                            <input class="form-control input-sm" type="text" id="NoEpisode" readonly name="NoEpisode"  value="<?= $data['register']['NoEpisode'] ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control input-sm" type="text" id="Noregis" readonly name="Noregis" value="<?= $data['register']['NoRegistrasi'] ?>">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Layanan/Ruangan</label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" type="text" id="layanan" value="<?= $data['register']['LokasiPasien'] ?>" readonly name="layanan">
                                        </div>
                                    </div>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> No. MR</label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" type="text" id="xnoMedrec" readonly name="xnoMedrec" value="<?= $data['register']['NoMR'] ?>">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> DPJP</label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" type="text" id="dpjp" readonly name="dpjp" value="<?= $data['register']['namadokter'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien</label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" type="text" id="xNamaPasien" readonly name="xNamaPasien" value="<?= $data['register']['PatientName'] ?>">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 control-label"> Jaminan</label>
                                        <div class="col-sm-4">
                                            <input class="form-control input-sm" type="text" id="xjaminan" readonly name="xjaminan" value="<?= $data['register']['Perusahaan'] ?>">
                                        </div>
                                    </div>
                                    <br>


                                  <!-- Nav tabs -->
                                  <ul class="nav nav-tabs border-bottom border-primary" role="tablist">
                                      <li role="presentation" class="active"><a class="" href="#generalconsent" aria-controls="generalconsent" role="tab" data-toggle="tab">General Consent</a>
                                      </li>
                                      <li role="presentation"><a class="" href="#akadijaroh" aria-controls="akadijaroh" role="tab" data-toggle="tab">Akad Ijaroh</a></li>
                                      <li role="presentation"><a class="" href="#hakdankewajiban" aria-controls="hakdankewajiban" role="tab" data-toggle="tab">Hak dan Kewajiban</a></li>
                                      <li role="presentation"><a class="" href="#tatatertib" aria-controls="tatatertib" role="tab" data-toggle="tab">Tata Tertib</a></li>
                                      <li role="presentation"><a class="" href="#biayanonop" aria-controls="biayanonop" role="tab" data-toggle="tab">Perkiraan Biaya Non Operasi</a></li>
                                      <li role="presentation"><a class="" href="#biayaop" aria-controls="biayaop" role="tab" data-toggle="tab">Perkiraan Biaya Operasi</a></li>
                                      <li role="presentation"><a class="" href="#persetujuanbiaya" aria-controls="persetujuanbiaya" role="tab" data-toggle="tab">Informasi Persetujuan Biaya Tindakan</a></li>
                                      <li role="presentation"><a class="" href="#persetujuanselisih" aria-controls="persetujuanselisih" role="tab" data-toggle="tab">Persetujuan Membayar Selisih Biaya</a></li>

                                  </ul>
                                  <!-- Tab panes -->
                                  <div class="tab-content bg-white p-15">

                                      <div role="tabpanel" class="tab-pane active" id="generalconsent">
                                      <div class="btn-group" role="group">
                                          <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="gocreate('GC');">
                                              <span class="glyphicon glyphicon glyphicon-plus"></span> New General Consent</a>
                                      </div>
                                      <br>
                                      <br>

                                          <div class="demo-table"   id="tbl_rekap" style="margin-top: 10px;overflow-x:auto; ">
                                          <table id="edoc_gc" class="table table-striped table-hover cell-border">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                           <th align='center'> Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>

                                      <div role="tabpanel" class="tab-pane" id="akadijaroh">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="gocreate('AI');">
                                                <span class="glyphicon glyphicon glyphicon-plus"></span> New Akad Ijaroh</a>
                                        </div>
                                        <br>
                                        <br>

                                          <div class="demo-table"   id="tbl_rekap">
                                          <table id="edoc_akadijaroh" class="table table-striped table-hover cell-border" style="width:100%">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                           <th align='center'> Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>

                                      <div role="tabpanel" class="tab-pane" id="hakdankewajiban">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="gocreate('HK');">
                                                <span class="glyphicon glyphicon glyphicon-plus"></span> New Hak dan Kewajiban</a>
                                        </div>
                                        <br>
                                        <br>

                                          <div class="demo-table"   id="tbl_rekap" style="margin-top: 10px;overflow-x:auto; ">
                                          <table id="edoc_hakdankewajiban" class="table table-striped table-hover cell-border" style="width:100%">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                           <th align='center'> Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>

                                      <div role="tabpanel" class="tab-pane" id="tatatertib">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="gocreate('TT');">
                                                <span class="glyphicon glyphicon glyphicon-plus"></span> New Tata Tertib</a>
                                        </div>
                                        <br>
                                        <br>

                                          <div class="demo-table"   id="tbl_rekap" style="margin-top: 10px;overflow-x:auto; ">
                                          <table id="edoc_tatatertib" class="table table-striped table-hover cell-border" style="width:100%">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                           <th align='center'> Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>

                                      <div role="tabpanel" class="tab-pane" id="biayanonop">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="gocreate('BNOP');">
                                                <span class="glyphicon glyphicon glyphicon-plus"></span> New Perkiraan Biaya Non Operasi</a>
                                        </div>
                                        <br>
                                        <br>

                                          <div class="demo-table"   id="tbl_rekap" style="margin-top: 10px;overflow-x:auto; ">
                                          <table id="edoc_biayanonop" class="table table-striped table-hover cell-border" style="width:100%">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                           <th align='center'> Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>

                                      <div role="tabpanel" class="tab-pane" id="biayaop">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="gocreate('BOP');">
                                                <span class="glyphicon glyphicon glyphicon-plus"></span> New Perkiraan Biaya Operasi</a>
                                        </div>
                                        <br>
                                        <br>

                                          <div class="demo-table"   id="tbl_rekap" style="margin-top: 10px;overflow-x:auto; ">
                                          <table id="edoc_biayaop" class="table table-striped table-hover cell-border" style="width:100%">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                           <th align='center'> Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>

                                      <div role="tabpanel" class="tab-pane" id="persetujuanbiaya">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="gocreate('IPBT');">
                                                <span class="glyphicon glyphicon glyphicon-plus"></span> New Informasi Persetujuan Biaya Tindakan</a>
                                        </div>
                                        <br>
                                        <br>

                                          <div class="demo-table"   id="tbl_rekap" style="margin-top: 10px;overflow-x:auto; ">
                                          <table id="edoc_persetujuanbiaya" class="table table-striped table-hover cell-border" style="width:100%">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                           <th align='center'> Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>

                                      <div role="tabpanel" class="tab-pane" id="persetujuanselisih">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary btn-sm btn-rounded " id="btncreateMR" onclick="gocreate('PSB');">
                                                <span class="glyphicon glyphicon glyphicon-plus"></span> New Informasi Persetujuan Biaya Tindakan</a>
                                        </div>
                                        <br>
                                        <br>

                                          <div class="demo-table"   id="tbl_rekap" style="margin-top: 10px;overflow-x:auto; ">
                                          <table id="edoc_persetujuanselisih" class="table table-striped table-hover cell-border" style="width:100%">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                           <th align='center'> Action</th>
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

  <div class="modal fade" id="modalHistory" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Preview Dokumen</h5>
            </div>
            <div class="modal-body">
                <h2 id="subjudul"></h2>
            <!-- <embed width="800" height="800" id="awsurl"> -->
            <iframe src="" width="100%" height="800" id="awsurl"></iframe>
            </div>

            <div class="modal-footer">
                    <button type="button" class="btn btn-gray" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
            </div>
        </div>
    </div>
</div>

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
  <script src="<?= BASEURL; ?>/js/App/SPR/ListEdocuments.js"></script>