 <div class="main-page">
     <div class="container-fluid">
         <div class="row page-title-div">
             <div class="col-md-6">
                 <h2 class="title"><?= $data['judul'] ?></h2>
                 <p class="sub-title">Silahkan Input Transaksi Disini.</p>
             </div>
             <!-- /.col-md-6 -->
         </div>
         <!-- /.row -->
         <div class="row breadcrumb-div">
             <div class="col-sm-6">
                 <ul class="breadcrumb">
                     <li><a href="<?= BASEURL; ?>"><i class="fa fa-home"></i> Home</a></li>
                     <li class="active"><?= $data['judul'] ?></li>
                     <li class="active"><?= $data['judul_child'] ?></li>
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
                     <div class="panel">
                         <div class="panel-heading">
                             <div class="panel-title">
                                 <h5>Input Master <?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi</small></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                             <!-- Nav tabs -->
                             <ul class="nav nav-tabs border-bottom border-primary">
                                 <li class="active"><a data-toggle="tab" href="#generalinfo">General Info</a></li>
                                 <li><a data-toggle="tab" href="#generalbenefit">General Benefit</a></li>
                                 <li><a data-toggle="tab" href="#specialbenefit">Special Benefit</a></li>
                             </ul>
                             <!-- Tab panes -->
                             <div class="tab-content bg-white p-15">
                                 <div id="generalinfo" class="tab-pane fade in active">
                                     <div class="panel-body">
                                         <form class="form-horizontal" id="form_cuti">
                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Payer (Perusahaan) <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" name="NamaPerusahaan" id="NamaPerusahaan" maxlength="50">
                                                 </div>
                                             </div>
                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Alamat </label>
                                                 <div class="col-sm-4">
                                                     <textarea rows="4" class="form-control" id="AlamatPerusahaan" name="AlamatPerusahaan" style="resize: none"></textarea>
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Alamat Penagihan </label>
                                                 <div class="col-sm-4">
                                                     <textarea rows="4" class="form-control" id="AlamatPenagihan" name="AlamatPenagihan" style="resize: none"></textarea>
                                                 </div>
                                             </div>
                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Kota </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" id="KotaPerusahaan" name="KotaPerusahaan">
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Telpon</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" id="TelponPerusahaan" name="TelponPerusahaan">
                                                 </div>
                                             </div>
                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Fax </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" id="FaxPerusahaan" name="FaxPerusahaan">
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Contact Person </label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" id="CPPerusahaan" name="CPPerusahaan">
                                                 </div>
                                             </div>
                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Tlp Contact Person</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" id="TelpCPPerusahaan" name="TelpCPPerusahaan">
                                                 </div>
                                                 <!--
                                      <label for=" inputEmail3" class="col-sm-2 control-label"> Masa Berlaku <sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                         <input type="date" class="form-control" id="MasaBerlakuPerusahaan" name="MasaBerlakuPerusahaan">
                                     -->
                                             </div>

                                             <div class="form-group">
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Masa Berlaku</label>
                                                 <div class="col-sm-4">
                                                     <input type="date" class="form-control" id="MasaBerlakuAwal" name="MasaBerlakuAwal">
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Sampai Dengan</label>
                                                 <div class="col-sm-4">
                                                     <input type="date" class="form-control" id="MasaBerlakuAkhir" name="MasaBerlakuAkhir">
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Benefit</label>
                                                 <div class="col-sm-4">
                                                     <input type="text" class="form-control" id="BenefitPerusahaan" name="BenefitPerusahaan">
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Status <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <select class="form-control js-example-basic-single" id="StatusPerusahaan" name="StatusPerusahaan">
                                                         <option value="">-- PILIH --</option>
                                                         <option value="1">Aktif</option>
                                                         <option value="0">TIdak AKtif</option>
                                                     </select>
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Grup Tarif <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <select class="form-control" id="GruptarifPerusahaan" name="GruptarifPerusahaan">
                                                         <option value="">-- PILIH --</option>
                                                         <option value="UM">UMUM</option>
                                                         <option value="TE">TELKOM</option>
                                                         <option value="KM">KMK</option>
                                                         <option value="BS">BPJS</option>
                                                     </select>
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> Kode Rekening <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <select class="form-control" id="KodeRekening" name="KodeRekening">
                                                     </select>
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label for="inputEmail3" class="col-sm-2 control-label"> Gen BP <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <select class="form-control" id="GenBP" name="GenBP">
                                                         <option value="">-- PILIH --</option>
                                                         <option value="1">Ya</option>
                                                         <option value="0">TIdak</option>
                                                     </select>
                                                 </div>
                                                 <label for=" inputEmail3" class="col-sm-2 control-label"> ID Formularium <sup class="color-danger">*</sup></label>
                                                 <div class="col-sm-4">
                                                     <select class="form-control js-example-basic-single" id="IDFormularium" name="IDFormularium">
                                                         <option value="">-- PILIH --</option>
                                                         <option value="1">UMUM</option>
                                                         <option value="4">BPJS</option>
                                                     </select>
                                                 </div>
                                             </div>
                                     </div>
                                 </div>

                                 <div id="generalbenefit" class="tab-pane fade">

                                     <div class="panel-body">
                                         <br>
                                         <b>Rawat Jalan</b>
                                         <hr>
                                         <b><u>
                                                 <font size="4">Diskon Global</font>
                                             </u></b>
                                         <div class="form-group row">
                                             <div class="col-sm-4">
                                                 <label for="rj_disc_global">Diskon Total Bill (%)</label>
                                                 <input class="form-control input-sm" id="rj_disc_global" name="rj_disc_global" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_rj_disc_global"></div>
                                         </div><br>

                                         <b><u>
                                                 <font size="4">Diskon Partial</font>
                                             </u></b>
                                         <div class="from-group row">
                                             <div class="col-sm-4">
                                                 <label for="rj_disc_administrasi">Administrasi (%)</label>
                                                 <input class="form-control input-sm" id="rj_disc_administrasi" name="rj_disc_administrasi" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_rj_disc_administrasi"></div>
                                             <div class="col-sm-4">
                                                 <label for="rj_disc_lab">Laboratorium (%)</label>
                                                 <input class="form-control input-sm" id="rj_disc_lab" name="rj_disc_lab" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_rj_disc_lab"></div>
                                             <div class="col-sm-4">
                                                 <label for="rj_disc_radiologi">Radiologi (%)</label>
                                                 <input class="form-control input-sm" id="rj_disc_radiologi" name="rj_disc_radiologi" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_rj_disc_radiologi"></div>
                                         </div>

                                         <div class="form-group row">
                                             <div class="col-sm-4">
                                                 <label for="rj_disc_resep">Resep Dokter (%)</label>
                                                 <input class="form-control input-sm" id="rj_disc_resep" name="rj_disc_resep" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_rj_disc_resep"></div>
                                             <div class="col-sm-4">
                                                 <label for="rj_disc_jasadokter">Jasa Dokter (%)</label>
                                                 <input class="form-control input-sm" id="rj_disc_jasadokter" name="rj_disc_jasadokter" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_rj_disc_jasadokter"></div>
                                             <div class="col-sm-4">
                                                 <label for="rj_disc_sewaalat">Sewa Alat (%)</label>
                                                 <input class="form-control input-sm" id="rj_disc_sewaalat" name="rj_disc_sewaalat" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_rj_disc_sewaalat"></div>
                                         </div>

                                         <hr><b>Rawat Inap</b>
                                         <hr>
                                         <b><u>
                                                 <font size="4">Diskon Global</font>
                                             </u></b>
                                         <div class="form-group row">
                                             <div class="col-sm-4">
                                                 <label for="ri_disc_global">Diskon Total Bill (%)</label>
                                                 <input class="form-control input-sm" id="ri_disc_global" name="ri_disc_global" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_ri_disc_global"></div>
                                         </div><br>

                                         <b><u>
                                                 <font size="4">Diskon Partial</font>
                                             </u></b>
                                         <div class="form-group row">
                                             <div class="col-sm-4">
                                                 <label for="administrasi">Administrasi (%)</label>
                                                 <input class="form-control input-sm" id="ri_disc_administrasi" name="ri_disc_administrasi" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_ri_disc_administrasi"></div>
                                             <div class="col-sm-4">
                                                 <label for="rj_disc_lab">Laboratorium (%)</label>
                                                 <input class="form-control input-sm" id="ri_disc_lab" name="ri_disc_lab" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_ri_disc_lab"></div>
                                             <div class="col-sm-4">
                                                 <label for="rj_disc_radiologi">Radiologi (%)</label>
                                                 <input class="form-control input-sm" id="ri_disc_radiologi" name="ri_disc_radiologi" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_ri_disc_radiologi"></div>
                                         </div>

                                         <div class="form-group row">
                                             <div class="col-sm-4">
                                                 <label for="ri_disc_resep">Resep Dokter (%)</label>
                                                 <input class="form-control input-sm" id="ri_disc_resep" name="ri_disc_resep" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_ri_disc_resep"></div>
                                             <div class="col-sm-4">
                                                 <label for="ri_disc_jasadokter">Jasa Dokter (%)</label>
                                                 <input class="form-control input-sm" id="ri_disc_jasadokter" name="ri_disc_jasadokter" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_ri_disc_jasadokter"></div>
                                             <div class="col-sm-4">
                                                 <label for="ri_disc_sewaalat">Sewa Alat (%)</label>
                                                 <input class="form-control input-sm" id="ri_disc_sewaalat" name="ri_disc_sewaalat" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_ri_disc_sewaalat"></div>
                                         </div>

                                         <div class="form-group row">
                                             <div class="col-sm-4">
                                                 <label for="ri_disc_kamarperawatan">Kamar Perawatan (%)</label>
                                                 <input class="form-control input-sm" id="ri_disc_kamarperawatan" name="ri_disc_kamarperawatan" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_ri_disc_kamarperawatan"></div>
                                             <div class="col-sm-4">
                                                 <label for="ri_disc_tindakanoperasi">Tindakan Operasi (%)</label>
                                                 <input class="form-control input-sm" id="ri_disc_tindakanoperasi" name="ri_disc_tindakanoperasi" type="text" placeholder="Exp : 0,5">
                                             </div>
                                             <div id="error_ri_disc_tindakanoperasi"></div>
                                         </div>
                                     </div>
                                 </div>


                                 <div id="specialbenefit" class="tab-pane fade">
                                     <div class="panel-body">
                                         <div class="form-group">
                                             <label for="inputsm">Silver</label>
                                             <textarea class="form-control input-sm" id="special_benefit_silver" name="special_benefit_silver" rows="8" style="resize: none"></textarea>
                                             <div id="error_special_benefit_silver"></div>
                                         </div>
                                         <div class="form-group">
                                             <label for="inputsm">Gold</label>
                                             <textarea class="form-control input-sm" id="special_benefit_gold" name="special_benefit_gold" rows="8" style="resize: none"></textarea>
                                             <div id="error_special_benefit_gold"></div>
                                         </div>
                                         <div class="form-group">
                                             <label for="inputsm">Platinum</label>
                                             <textarea class="form-control input-sm" id="special_benefit_platinum" name="special_benefit_platinum" rows="8" style="resize: none"></textarea>
                                             <div id="error_special_benefit_platinum"></div>
                                         </div>
                                         <div class="form-group">
                                             <label for="inputsm">Diamond</label>
                                             <textarea class="form-control input-sm" id="special_benefit_diamond" name="special_benefit_diamond" rows="8" style="resize: none"></textarea>
                                             <div id="error_special_benefit_diamond"></div>
                                         </div>
                                     </div>
                                 </div>


                             </div>
                             </form>
                             <div class="panel-body">
                                 <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                                 <button class="btn bg-black btn-wide" id="btnreservasi" name="btnreservasi"><i class="fa fa-check"></i>Submit</button>
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
 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterDataAsuransi/MasterDataAsuransi_V01.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>