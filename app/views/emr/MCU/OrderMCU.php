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
                          <div class="panel-body">
                              <form class="form-horizontal" id="frmSimpanTrs">
                                  <h5 class="underline mt-30"><?= $data['judul'] ?></h5>
                                  <div class="form-group">
                                      <div class="col-sm-12">
                                          <div class="alert alert-success" role="alert">
                                              <strong>Informasi !</strong> Mohon pilih paket MCU dengan benar dan dicek terlebih dahulu, karena jika sudah diorder tidak bisa dibatalkan atau status order sudah LOCK! <br>
                                              <strong>Informasi !</strong> Silahkan tekan F5 untuk Refresh halaman.<br>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. MR </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" id="nomr" name="nomr" type="text" readonly>
                                          <div id="error_nomr"></div>
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> No. Registrasi </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="NoRegistrasi" readonly name="NoRegistrasi" type="text" placeholder="No. Registrasi" value="<?= $data['noregistrasi'] ?>">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="NamaPasien" readonly name="NamaPasien" type="text" placeholder="Ketik Nama Pasien">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" id="poliklinikname" name="poliklinikname" type="text" readonly>
                                          <div id="error_nobooking"></div>
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> No. Episode </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm " id="NoEpisode" readonly name="NoEpisode" type="text" placeholder="Ketik No. Episode">
                                      </div>
                                      <label for="inputEmail3" class="col-sm-2 control-label">Tgl Registrasi </label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm "type="text" id="TglRegistrasi" name="TglRegistrasi" readonly step="1">
                                      </div>
                                  </div>
                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label">Dokter</label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" id="dokternamxe" name="dokternamxe" type="text" readonly>
                                          <div id="error_nobooking"></div>
                                      </div>
                                      <label for="inputEmail3" class="col-sm-2 control-label">Penjamin</label>
                                      <div class="col-sm-4">
                                          <input class="form-control input-sm" id="NamaPenjamin" name="NamaPenjamin" type="text" readonly>
                                          <div id="error_nobooking"></div>
                                      </div>
                                  </div>
                                  
                                  <input class="form-control input-sm" id="IDDokter" name="IDDokter" type="hidden" readonly>
                                  <input class="form-control input-sm" id="JenisKelamin" name="JenisKelamin" type="hidden" readonly>
                                  <input class="form-control input-sm" id="DOB" name="DOB" type="hidden" readonly>
                                  <input class="form-control input-sm" id="Alamat" name="Alamat" type="hidden" readonly>
                                  <input class="form-control input-sm" id="PatientType" name="PatientType" type="hidden" readonly>
                                  <input class="form-control input-sm" id="IDUnit" name="IDUnit" type="hidden" readonly>

                                  <br> <br>

                                  <div class="form-group gut">
                                      <label for="inputEmail3" class="col-sm-2 control-label"> Nama Paket <sup class="color-danger">*</sup></label>
                                      <div class="col-sm-4">
                                          <select class="form-control input-sm" name="IDPemeriksaan" id="IDPemeriksaan" onchange="getTarifPaketMCU(this.value);">
                                          </select>
                                          <input class="form-control input-sm" type="hidden" id="namapaket" readonly name="namapaket">
                                          <input class="form-control input-sm" type="hidden" id="Lab_kodeTes_kelompok" readonly name="Lab_kodeTes_kelompok">
                                      </div>
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Nilai Tarif Paket<sup class="color-danger">*</sup> </label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm " id="HargaPaket" name="HargaPaket" type="text" readonly>
                                      </div>
                                      <div class="col-sm-2">
                                          <button type="button" id="btnOrder" name="btnOrder" class="btn btn-primary btn-sm"> 
                                              Pilih dan Order Paket
                                          </button>
                                      </div>
                                  </div>

                                  <div class="form-group gut">
                                      <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Status </label>
                                      <div class="col-sm-4">
                                      <span id="StatusOrder" name="StatusOrder" class="badge"></span>
                                      </div>

                              </form>

                                      <div class="form-group gut">
                                      </div>
                                      <hr>
                                      <h5 class="underline mt-30">DATA DETAILS ORDER MCU</h5>
                                      <div class="table-responsive">
                                      <table id="table-load-data-mcu" class="table table-striped table-hover cell-border"  width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Pemeriksaan</th>
                                                        <th>Lokasi Pemeriksaan</th>
                                                        <th>Pemeriksaan Penunjang</th>
                                                        <th>ID Tes</th>
                                                        <th>Tarif</th>
                                                    </tr>
                                                </thead> 
                                            </table>  
                                      </div>
                                      
                                      <div class="col-sm-2">
                                          <button type="button" id="btnPrintLabel" name="btnPrintLabel" class="btn btn-maroon btn-sm" onclick="PrintLabelLab()"> 
                                              Print Label Lab
                                          </button>
                                  </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  </div>



  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/emr/MCU/OrderMCU_v01.js"></script>