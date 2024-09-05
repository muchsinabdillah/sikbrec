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
                                      </div>
                                  </h5>
                              </div>
                          </div>
                          <div class="panel-body">

                              <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                  <div class="form-group  ">
                                      <label for="inputEmail3" class="col-sm-3 control-label"> Tanggal <sup
                                              class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <input class="form-control input-sm" type="date" id="MTglKunjunganBPJS"
                                              autocomplete="off" name="MTglKunjunganBPJS"
                                              placeholder="ketik Kata Kunci disini">
                                      </div>
                                  </div>
                                  <div class="form-group gut ">
                                      <label for="inputEmail3" class="col-sm-3 control-label"> Jenis Pelayanan <sup
                                              class="color-danger">*</sup></label>
                                      <div class="col-sm-2">
                                          <select id="MJenisPelayananBPJS" nama="MJenisPelayananBPJS"
                                              class="form-control input-sm">
                                              <option value="">-- PILIH --</option>
                                              <option value="1">Rawat Inap</option>
                                              <option value="2">Rawat Jalan</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group  ">
                                      <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                      <div class="col-sm-2">
                                          <button type="button" onclick="GoMonitoringBPJS();" id="caridatapasienarsip"
                                              class="btn btn-success btn-wide btn-rounded"><i
                                                  class="fa fa-search"></i>Search</button>
                                      </div>
                                  </div>
                                  <!-- <div class="table-responsive" width="100%" id="tbl_rekap" style="margin-top: 10px;">
                                      <table id="tbl_kunjungan_monitoring" width="100%"
                                          class="table table-striped table-hover cell-border"> -->

                                  <div class="panel-body">
                                      <div class="demo-table" style="overflow-x:auto;margin-top: 10px;">
                                          <table id="tbl_kunjungan_monitoring" class="display" width="100%"
                                              class="table table-striped table-hover cell-border">
                                              <thead>
                                                  <tr>
                                                      <th align='center'>
                                                          <font size="1">No SEP
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">No Kartu
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">No Rujukan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Tgl SEP
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Nama Pasien
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Jenis Pelayanan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Diagnosa
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Kelas Rawat
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Layanan
                                                      </th>
                                                      <th align='center'>
                                                          <font size="1">Tgl Pulang
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
                      <button type="button" class="btn btn-success btn-labeled">Purchase Now<span
                              class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
  <div class="modal fade" id="modal_VerifBPJS" role="dialog" style="overflow-y: auto" data-backdrop="static"
      data-keyboard="false">

      <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> Input SEP BPJS Kesehatan</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                      <h5 class="underline mt-30">Data Pasien / Rujukan </h5>
                      <div class="form-group gut">
                          <label for=" inputEmail3" class="col-sm-2 control-label"> No. SEP<sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="xSEPNO" readonly name="xSEPNO" type="text">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Asal Rujukan<sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-1">
                              <input class="form-control input-sm " id="JenisFaskesKodeBPJS" value="1" readonly
                                  name="JenisFaskesKodeBPJS" type="text">
                          </div>
                          <div class="col-sm-3">
                              <input class="form-control input-sm " id="JenisFaskesNamaBPJS" readonly
                                  name="JenisFaskesNamaBPJS" type="text">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> No. Registrasi <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="NoRegistrasiSIMRSBPJS" readonly
                                  name="NoRegistrasiSIMRSBPJS" type="text">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Rujukan Kode<sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="idppkrujukanBPJS" readonly
                                  name="idppkrujukanBPJS" type="text">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Rujukan Nama<sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="namappkrujukanBPJS" readonly
                                  name="namappkrujukanBPJS" type="text">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. Rujukan </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="norujukan" name="norujukan" type="text"
                                  placeholder="Ketik Nama Pasien">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. Surat Kontrol <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="NoSuratKontrolBPJS"
                                  name="NoSuratKontrolBPJS" placeholder="Ketik No. Surat Kontrol">
                          </div>

                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Tgl. Rujukan </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="TglRujukan" readonly name="TglRujukan"
                                  type="date" placeholder="Ketik Nama Pasien">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. NIK </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="nonikktpBPJS" readonly name="nonikktpBPJS"
                                  type="text">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. Kartu BPJS <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="nokartubpjs" readonly name="nokartubpjs"
                                  type="text">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Status Peserta </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="statuspesertaBPJS" readonly
                                  name="statuspesertaBPJS" type="text">
                          </div>

                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Nama Peserta </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="namapesertaBPJS" readonly name="namapesertaBPJS"
                                  type="text" placeholder="Ketik Nama Pasien">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;">
                              Keterangan PRB </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="keteranganprbBPJS" readonly
                                  name="keteranganprbBPJS" type="text">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Hak Kelas </label>
                          <div class="col-sm-1">
                              <input class="form-control input-sm " id="idhakKelasBPJS" readonly name="idhakKelasBPJS"
                                  type="text" placeholder="Ketik Nama Pasien">
                          </div>
                          <div class="col-sm-3">
                              <input class="form-control input-sm " id="hakKelasBPJS" readonly name="hakKelasBPJS"
                                  type="text" placeholder="Ketik Nama Pasien">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> COB - No. Asuransi </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="cobnosuratBPJS" readonly name="cobnosuratBPJS"
                                  type="text">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Nama Faskes </label>
                          <div class="col-sm-1">
                              <input class="form-control input-sm " id="idfaskesBPJS" readonly name="idfaskesBPJS"
                                  type="text" placeholder="Ketik Nama Pasien">
                          </div>
                          <div class="col-sm-3">
                              <input class="form-control input-sm " id="namafaskesBPJS" readonly name="namafaskesBPJS"
                                  type="text" placeholder="Ketik Nama Pasien">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> COB - Nama Asuransi </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="cobNamaAsuransiBPJS" readonly
                                  name="cobNamaAsuransiBPJS" type="text">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Peserta </label>
                          <div class="col-sm-1">
                              <input class="form-control input-sm " id="jenisPesertaKodeBPJS" readonly
                                  name="jenisPesertaKodeBPJS" type="text" placeholder="Ketik Nama Pasien">
                          </div>
                          <div class="col-sm-3">
                              <input class="form-control input-sm " id="jenisPesertaNamaBPJS" readonly
                                  name="jenisPesertaNamaBPJS" type="text" placeholder="Ketik Nama Pasien">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin </label>
                          <div class="col-sm-1">
                              <input class="form-control input-sm " id="jenisKelaminKodeBPJS" readonly
                                  name="jenisKelaminKodeBPJS" type="text">
                          </div>
                          <div class="col-sm-3">
                              <input class="form-control input-sm " id="jenisKelaminNamaBPJS" readonly
                                  name="jenisKelaminNamaBPJS" type="text">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pelayanan </label>
                          <div class="col-sm-4">
                              <select id="isJenisPelayananBPJS" name="isJenisPelayananBPJS" style="width: 100%;"
                                  class="form-control ">
                                  <option value="2">RAWAT JALAN</option>
                                  <option value="1">RAWAT INAP</option>
                              </select>
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> Tgl SEP </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="TglSEP" name="TglSEP" type="date">
                          </div>

                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Naik Kelas </label>
                          <div class="col-sm-4">
                              <select id="isNaikKelasBPJS" name="isNaikKelasBPJS" style="width: 100%;"
                                  class="form-control ">
                                  <option value="0">TIDAK</option>
                                  <option value="1">YA</option>
                              </select>
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> Kelas Perawatan </label>
                          <div class="col-sm-4">
                              <select id="kdkelasperawatanBPJS" name="kdkelasperawatanBPJS" class="form-control ">
                                  <option value="">-- PILIH --</option>
                                  <option value="1">VVIP</option>
                                  <option value="2">VIP</option>
                                  <option value="3">Kelas 1</option>
                                  <option value="4">Kelas 2</option>
                                  <option value="5">Kelas 3</option>
                                  <option value="6">ICCU</option>
                                  <option value="7">ICU</option>
                              </select>
                              <small>Diisi Jika Naik Kelas.</small>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Pembiayaan </label>
                          <div class="col-sm-4">
                              <select id="PembiayaanNiakKelasBPJS" name="PembiayaanNiakKelasBPJS" style="width: 100%;"
                                  class="form-control ">
                                  <option value="">-- PILIH --</option>
                                  <option value="1">PRIBADI</option>
                                  <option value="2">PEMBERI KERJA</option>
                                  <option value="3">ASURANSI KESEHATAN TAMBAHAN</option>
                              </select>
                              <small>Diisi Jika Naik Kelas.</small>
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> Penanggung Jawab </label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="PenanggungJawabBiaya"
                                  name="PenanggungJawabBiaya" type="text">
                              <small>Diisi Jika Naik Kelas.</small>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. MR</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="NoMRBPJS" autocomplete="off" name="NoMRBPJS"
                                  type="text">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. Hp</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="NoHpBPJS" autocomplete="off" name="NoHpBPJS"
                                  type="text">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Lahir</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " readonly id="TglLahirBPJS" autocomplete="off"
                                  name="TglLahirBPJS" type="text">
                          </div>

                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> COB </label>
                          <div class="col-sm-4">
                              <select id="isCobBPJS" name="isCobBPJS" style="width: 100%;" class="form-control ">
                                  <option value="0">TIDAK</option>
                                  <option value="1">YA</option>
                              </select>
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> Katarak</label>
                          <div class="col-sm-4">
                              <select id="iscatarakBPJS" name="iscatarakBPJS" class="col-sm-9">
                                  <option value="0">TIDAK</option>
                                  <option value="1">YA</option>
                              </select>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Eksekutif </label>
                          <div class="col-sm-4">
                              <select id="isEksekutifBPJS" name="isEksekutifBPJS" style="width: 100%;"
                                  class="form-control ">
                                  <option value="0">TIDAK</option>
                                  <option value="1">YA</option>
                              </select>
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label"> Tanggal TMT <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-2">
                              <input readonly class="form-control input-sm" type="text" id="TglTMTBPJS"
                                  name="TglTMTBPJS">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Diagnosa : </label>
                          <div class="col-sm-10">
                              <select id='caridiagnosaBPJS2' style="width: 100%;" class="form-control "
                                  name='caridiagnosaBPJS2'>
                                  <option value='0'>- Search Diagnosa -</option>
                              </select>
                          </div>

                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa Dipilih <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-2">
                              <input readonly class="form-control input-sm" type="text" id="KodeDiagnosaBPJS"
                                  name="KodeDiagnosaBPJS">
                          </div>
                          <div class="col-sm-8" style="margin-left: -20px;">
                              <input readonly class="form-control input-sm" type="text" id="NamaDiagnosaBPJS"
                                  name="NamaDiagnosaBPJS">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Poliklinik : </label>
                          <div class="col-sm-10">
                              <select id='cariPoliklinikBPJS' style="width: 100%;" name='cariPoliklinikBPJS'
                                  class="form-control ">
                                  <option value='0'>- Search Poliklinik -</option>
                              </select>
                          </div>

                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik Dipilih <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-2">
                              <input readonly class="form-control input-sm" type="text" id="KodePoliklinikBPJS"
                                  name="KodePoliklinikBPJS">
                          </div>
                          <div class="col-sm-8" style="margin-left: -20px;">
                              <input readonly class="form-control input-sm" type="text" id="NamaPoliklinikBPJS"
                                  name="NamaPoliklinikBPJS">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Pilih Dokter : </label>
                          <div class="col-sm-10">
                              <select id='cariDokterBPJS' style="width: 100%;" name='cariDokterBPJS'
                                  class="form-control ">
                                  <option value='0'>- Search Dokter -</option>
                              </select>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Dokter Dipilih <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-2">
                              <input readonly class="form-control input-sm" type="text" value="34908"
                                  id="KodeDokterBPJS" name="KodeDokterBPJS">
                          </div>
                          <div class="col-sm-8" style="margin-left: -20px;">
                              <input readonly class="form-control input-sm" type="text" value="dr. Heru Dento, SpPD"
                                  id="NamaDokterBPJS" name="NamaDokterBPJS">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Tujuan Kunjungan :</label>
                          <div class="col-sm-4">
                              <select id='TujuanKunjunganBPJS' style="width: 100%;" name='TujuanKunjunganBPJS'
                                  class="form-control ">
                                  <option value=''>- PILIH -</option>
                                  <option value='0'>NORMAL</option>
                                  <option value='1'>PROSEDUR</option>
                                  <option value='2'>KONSUL DOKTER</option>
                              </select>
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">Flag Procedure :</label>
                          <div class="col-sm-4">
                              <select id='FlagProcedureBPJS' style="width: 100%;" name='FlagProcedureBPJS'
                                  class="form-control ">
                                  <option value=''>- PILIH -</option>
                                  <option value='0'>Prosedur Tidak Berkelanjutan</option>
                                  <option value='1'>Prosedur dan Terapi Berkelanjutan</option>
                              </select>
                              <small>Dikosongkan, Jika Tujuan Kunjungan Normal</small>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Penunjang :</label>
                          <div class="col-sm-4">
                              <select id='PenujangBPJS' style="width: 100%;" name='PenujangBPJS' class="form-control ">
                                  <option value=''>- PILIH -</option>
                                  <option value='0'>NORMAL</option>
                                  <option value='1'>Radioterapi</option>
                                  <option value='2'>Kemoterapi</option>
                                  <option value='3'>Rehabilitasi Medik</option>
                                  <option value='4'>Rehabilitasi Psikososial</option>
                                  <option value='5'>Transfusi Darah</option>
                                  <option value='6'>Pelayanan Gigi</option>
                                  <option value='7'>Laboratorium</option>
                                  <option value='8'>USG</option>
                                  <option value='9'>Farmasi</option>
                                  <option value='10'>Lain-Lain</option>
                                  <option value='11'>MRI</option>
                                  <option value='12'>HEMODIALISA</option>
                              </select>
                              <small>Dikosongkan, Jika Tujuan Kunjungan Normal</small>
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">Asesment Pelayanan :</label>
                          <div class="col-sm-4">
                              <select id='AsesmentPelayananBPJS' style="width: 100%;" name='AsesmentPelayananBPJS'
                                  class="form-control ">
                                  <option value=''>- PILIH -</option>
                                  <option value='1'>Poli spesialis tidak tersedia pada hari sebelumnya</option>
                                  <option value='2'>Jam Poli telah berakhir pada hari sebelumnya</option>
                                  <option value='3'>Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya
                                  </option>
                                  <option value='4'>Atas Instruksi RS</option>
                              </select>
                              <small>Dikosongkan, Jika Poli tujuan berbeda dengan poli rujukan dan hari beda. Diisi,
                                  Jika Tujuan Adlah konsul Dokter.</small>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Catatan <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <textarea class="form-control input-sm" id="iscatatanBPJS" name="iscatatanBPJS"
                                  rows="4"></textarea>
                          </div>
                      </div>
                      <h5 class="underline mt-30">DATA KECELAKAAN <small> Jika Pasien Kecelakaan</small></h5>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Laka Lantas :</label>
                          <div class="col-sm-4">
                              <select id='LakaLantasBPJS' style="width: 100%;" name='LakaLantasBPJS'
                                  class="form-control ">
                                  <option value='0'>Bukan Kecelakaan lalu lintas [BKLL]</option>
                                  <option value='1'>KLL dan bukan kecelakaan Kerja [BKK]</option>
                                  <option value='2'>KLL dan KK</option>
                                  <option value='3'>KK</option>
                              </select>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Tgl Kejadian :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="date" id="TglKejadianBPJS"
                                  name="TglKejadianBPJS" placeholder="Ketik No. Surat Kontrol">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">Keterangan :</label>
                          <div class="col-sm-4">
                              <textarea class="form-control input-sm" id="LakaLantasKetBPJS" name="LakaLantasKetBPJS"
                                  rows="4"></textarea>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Suplesi :</label>
                          <div class="col-sm-4">
                              <select id='SuplesiBPJS' style="width: 100%;" name='SuplesiBPJS' class="form-control ">
                                  <option value='0'>TIDAK</option>
                                  <option value='1'>YA</option>
                              </select>
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">No. Suplesi :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="NoSuplesiBPJS" name="NoSuplesiBPJS"
                                  placeholder="Ketik No. Surat Kontrol">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Provinsi :</label>
                          <div class="col-sm-4">
                              <select id='cariProvinsi' style="width: 100%;" name='cariProvinsi' class="form-control ">
                              </select>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Provinsi Kode:</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSProvinsi"
                                  name="SuplesiBPJSProvinsi" placeholder="Ketik No. Surat Kontrol">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">Provinsi Nama :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSProvinsiName"
                                  name="SuplesiBPJSProvinsiName" placeholder="Ketik No. Surat Kontrol">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Kabupaten :</label>
                          <div class="col-sm-4">
                              <select id='cariKabupaten' style="width: 100%;" name='cariKabupaten'
                                  class="form-control ">
                              </select>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Kabupaten Kode:</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKabupaten"
                                  name="SuplesiBPJSKabupaten" placeholder="Ketik No. Surat Kontrol">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">Kabupaten Nama :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKabupatenName"
                                  name="SuplesiBPJSKabupatenName" placeholder="Ketik No. Surat Kontrol">
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan :</label>
                          <div class="col-sm-4">
                              <select id='cariKecamatan' style="width: 100%;" name='cariKecamatan'
                                  class="form-control ">
                              </select>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan Kode:</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKecamatan"
                                  name="SuplesiBPJSKecamatan" placeholder="Ketik No. Surat Kontrol">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan Nama :</label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" id="SuplesiBPJSKecamatanName"
                                  name="SuplesiBPJSKecamatanName" placeholder="Ketik No. Surat Kontrol">
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <div class="btn-group" role="group">
                      <button class="btn btn-success btn-rounded" id="btnCreateSEP" name="btnCreateSEP"><i
                              class="fa fa-save"> </i> SIMPAN SEP</button>
                      <button type="button" class="btn btn-gray btn-rounded" id="btnModalSrcPasienClose"
                          data-dismiss="modal"><i class="fa fa-mail-reply-all"></i>Close</button>
                  </div>

              </div>
          </div>
      </div>
  </div>
  <!--#END Modal Untuk Notif Resep---------------------------->
  <!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
  <div class="modal fade" id="modal_UpdateTglPulang" role="dialog" style="overflow-y: auto" data-backdrop="static"
      data-keyboard="false">

      <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"> Update Tanggal Pulang SEP</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                      <h5 class="underline mt-30">Data Tanggal Pulang</h5>

                      <div class="form-group  ">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. SEP <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" readonly type="text" id="MNoSEPBPJS"
                                  name="MNoSEPBPJS">
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Status Pulang <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <select id="StatusPulangBPJS" nama="StatusPulangBPJS" class="form-control input-sm">
                                  <option value="">-- PILIH --</option>
                                  <option value="1">Atas Persetujuan Dokter</option>
                                  <option value="3">Atas Permintaan Sendiri</option>
                                  <option value="4">Meninggal</option>
                                  <option value="5">Lain-lain</option>
                              </select>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> No. Surat Meninggal <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="text" id="MNoSuratMeninggalBPJS"
                                  name="MNoSuratMeninggalBPJS">
                              <small>*) Diisi Jika Status Pulang Meninggal</small>
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Meninggal <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="TglMeninggalBPJS" name="TglMeninggalBPJS"
                                  type="date">
                              <small>*) Diisi Jika Status Pulang Meninggal</small>
                          </div>
                      </div>
                      <div class="form-group gut">
                          <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Pulang <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm" type="date" id="MTglPulangBPJS"
                                  name="MTglPulangBPJS">
                              <small>*) Diisi Jika Status Pulang Meninggal</small>
                          </div>
                          <label for=" inputEmail3" class="col-sm-2 control-label"> No. PL Manual <sup
                                  class="color-danger">*</sup></label>
                          <div class="col-sm-4">
                              <input class="form-control input-sm " id="MNoPLManualBPJS" name="MNoPLManualBPJS"
                                  type="text">
                              <small>*) Diisi Jika Status Pulang Meninggal</small>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button class="btn bg-success  btn-wide" id="btnsimpan" name="btnsimpan"><i class="fa fa-check"> </i>
                      PROSES</button>
              </div>
          </div>
      </div>
  </div>
  <!--#END Modal Untuk Notif Resep---------------------------->

  <!-- ========== COMMON JS FILES ========== -->
  <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
  <script src="<?= BASEURL; ?>/js/App/bridgingbpjs/monitoring/listMonitoringPelayananBPJS_v024.js"></script>