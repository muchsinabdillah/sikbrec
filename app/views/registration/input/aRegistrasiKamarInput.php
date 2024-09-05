<?php
date_default_timezone_set('Asia/Jakarta');
//include "halaman/header.php";
$datenowcreate = date("Y-m-d");
$datetimenow = date("Y-m-d\TH:i:s");
?>
<style>
    table {
        border: 2px solid #6C6A61;
        border-collapse: collapse;
        font-size: 10px;
    }

    th,
    td {
        border: 1px solid #bbb;
        padding: 2px 8px 0;
        font-size: 10px;
    }

    thead>tr>th {
        background-color: #C0C0C0;
        border-bottom: 2px solid #999;
        font-size: 10px;
    }
</style>
<div class="main-page">
     

     <section class="section">
         <div class="container-fluid">

             <div class="row">
                 <div class="col-md-12">
                     <div class="panel">
                         <div class="panel-heading">
                             <div class="panel-title">
                                 <h5 class="underline mt-30"><?= $data['judul'] ?></h5>
                             </div>
                         </div>
                         <div class="panel-body">
                                 <form class="form-horizontal" id="frmTrsKamar">
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> ID </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>"  readonly>
                                     </div>
                                     <!-- <label for=" inputEmail3" class="col-sm-2 control-label"> Kelas</label>
                                     <div class="col-sm-4">
                                     <select class="form-control js-example-basic-single" id="ClassID" name="ClassID" >
                                         </select>
                                     </div> -->
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Kelas<sup class="color-danger">*</sup></label>
                                        <div class="col-sm-1" >
                                            <input class="form-control input-sm " id="classname"  name="classname" type="text" readonly>
                                            <input class="form-control input-sm " id="classid"  name="classid" type="text" readonly >
                                        </div>
                                        <div class="col-sm-3">
                                        <select class="form-control js-example-basic-single" id="classid_temp" name="classid_temp" >
                                            </select>
                                        </div>
                                 </div>
                                 <div class="form-group gut">
                                 <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Masuk </label>
                                     <div class="col-sm-4">
                                         <input type="date" class="form-control" id="TglMasuk" name="TglMasuk"   readonly> 
                                     </div>
                                     <!-- <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Kamar </label>
                                     <div class="col-sm-4">
                                     <select class="form-control js-example-basic-single" id="NamaKamar" name="NamaKamar" >
                                         </select>
                                     </div> -->
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Ruangan<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1" >
                                        <input class="form-control input-sm " id="roomname"  name="roomname" type="text" readonly>
                                        <input class="form-control input-sm " id="roomid"  name="roomid" type="text" readonly >
                                    </div>
                                    <div class="col-sm-3">
                                    <select class="form-control js-example-basic-single" id="roomid_temp" name="roomid_temp" >
                                         </select>
                                    </div>
                                 </div>

                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Jam Masuk </label>
                                     <div class="col-sm-4">
                                         <input type="time" class="form-control" id="JamMasuk" name="JamMasuk" step="1" readonly> 
                                     </div>
                                     <!-- <label for=" inputEmail3" class="col-sm-2 control-label"> Bed </label>
                                     <div class="col-sm-4">
                                     <select class="form-control js-example-basic-single" id="BedKamar" name="BedKamar" >
                                         </select>
                                     </div> -->
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Bed<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1" >
                                        <input class="form-control input-sm " id="bedname"  name="bedname" type="text" readonly>
                                        <input class="form-control input-sm " id="bedid"  name="bedid" type="text" readonly >
                                    </div>
                                    <div class="col-sm-3">
                                    <select class="form-control js-example-basic-single" id="bedid_temp" name="bedid_temp" >
                                         </select>
                                    </div>
                                 </div>

                                 <div class="form-group gut">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Tgl Keluar </label>
                                     <div class="col-sm-4">
                                     <input type="date" class="form-control" id="TglKeluar" name="TglKeluar" readonly> 
                                     </div>

                                     <label for="inputEmail3" class="col-sm-2 control-label"> Tarif </label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="TarifKamar" name="TarifKamar"  readonly> 
                                     </div>
                                 </div>

                                 <div class="form-group gut">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Jam Keluar </label>
                                     <div class="col-sm-4">
                                     <input type="time" class="form-control" id="JamKeluar" name="JamKeluar" step="1" readonly> 
                                     </div>

                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Lama Rawat </label>
                                     <div class="col-sm-4">
                                     <input type="text" class="form-control" id="LamaRawat" name="LamaRawat" readonly> 
                                     </div>
                                 </div>

                                 <div class="form-group gut">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Group Jaminan </label>
                                     <div class="col-sm-4">
                                     <input type="text" class="form-control" id="TipePasien" name="TipePasien" readonly> 
                                     </div>

                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Jaminan </label>
                                     <div class="col-sm-4">
                                     <input type="text" class="form-control" id="Jaminan" name="Jaminan" readonly> 
                                     </div>
                                 </div>

                                 
                                 <hr>
                                 <div class="form-group gut">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Titipan </label>
                                     <div class="col-sm-4">
                                     <select class="form-control js-example-basic-single" id="Titipan" name="Titipan" style="width:100%">
                                         <option value="0">Tidak</option>
                                         <option value="1">Ya</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Kode Booking </label>
                                     <div class="col-sm-3">
                                     <input type="text" class="form-control" id="kodebooking" name="kodebooking" readonly> 
                                     </div>
                                     <div class="col-sm-1">
                                     <button type="button" class="btn btn-maroon btn-rounded waves-effect" id="btnSearchBooking" name="btnSearchBooking"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>
                                     </div>
                                 </div>

                                
                             <div id="istitipan" style="display:none">
                                 <div class="form-group gut">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Kelas</label>
                                     <div class="col-sm-4">
                                     <select class="form-control js-example-basic-single" id="ClassID_Titipan" name="ClassID_Titipan" style="width:100%">
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Kamar </label>
                                     <div class="col-sm-4">
                                     <select class="form-control js-example-basic-single" id="NamaKamar_Titipan" name="NamaKamar_Titipan" style="width:100%">
                                         </select>
                                     </div>
                                 </div>

                                 <div class="form-group gut">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Bed </label>
                                     <div class="col-sm-4">
                                     <select class="form-control js-example-basic-single" id="BedKamar_Titipan" name="BedKamar_Titipan" style="width:100%">
                                         </select>
                                     </div>
                                 </div>

                                 <div class="form-group gut">
                                 <label for="inputEmail3" class="col-sm-2 control-label"> Tarif Titipan</label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" id="TarifKamar_Titipan" name="TarifKamar_Titipan"  readonly> 
                                     </div>
                                 </div>

                                
                               </div>

                                 <div class="form-group gut" style="display:none">
                                     <label for=" inputEmail3" class="col-sm-2 control-label"> No Registrasi </label>
                                     <div class="col-sm-4">
                                     <input type="text" class="form-control" id="NoRegistrasi" name="NoRegistrasi" value="<?= $data['noreg'] ?>" readonly > 
                                     </div>

                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Room ID </label>
                                     <div class="col-sm-4">
                                     <input type="text" class="form-control" id="RoomID" name="RoomID"  readonly > 
                                     <input type="hidden" class="form-control" id="RoomID_Titipan" name="RoomID_Titipan"  readonly > 
                                     </div>

                                     <label for=" inputEmail3" class="col-sm-2 control-label"> ID Transfer </label>
                                     <div class="col-sm-4">
                                     <input type="text" class="form-control" id="idtrf" name="idtrf"  readonly > 
                                     </div>

                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Group Jaminan </label>
                                     <div class="col-sm-4">
                                     <input type="text" class="form-control" id="GroupJaminan" name="GroupJaminan" readonly> 
                                     </div>
                                     
                                 <div class="col-sm-4">
                                        <input class="form-control input-sm " id="nomr_pass"  name="nomr_pass" type="text" readonly>
                                    </div>
                                 </div>
                                 <hr>
                             </form>

                             <div class="btn-group" role="group">
                                  <button class="btn btn-primary  btn-rounded " id="savetrs" name="savetrs" href="#modal_alert_simpan" data-toggle='modal'> 
                                  <a id="labelnew"> Simpan dan Check in</a>
                                  <a id="labeledit"> Simpan</label></a>
                                  <button class="btn btn-secondary  btn-rounded  " id="close" name="close" onclick="myBack()">
                                      Close</button>
                              </div>

                                <!--
                              <div class="btn-group" role="group" >
                                  <button class="btn btn-danger  btn-rounded " id="btnBatal" name="btnBatal" >
                                      Batal</button>
                              </div>
                                -->
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Reservasi Booking Kamar Pasien <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" id="form_cuti">

                    <div class="form-group  ">
                    <div class="col-sm-3">
                    <label for="form-control input-sm">Periode Tanggal Reservasi : </label>
                        </div>
                    <div class="col-sm-2">
                            <!-- <label for="form-control input-sm">Input Awal</label> -->
                            <input class="form-control input-sm" type="date" id="tglAwalReservasi"
                                autocomplete="off" name="tglAwalReservasi"
                                placeholder="ketik Kata Kunci disini">
                        </div>
                        <div class="col-sm-2">
                            <!-- <label for="form-control input-sm">Input Akhir</label> -->
                            <input class="form-control input-sm" type="date" id="tglAkhirReservasi"
                                autocomplete="off" name="tglAkhirReservasi"
                                placeholder="ketik Kata Kunci disini">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="btnSearchMrAktif" class="btn btn-success btn-wide btn-rounded"  onclick="caridatareservasi()"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datalistbooking" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                                            <th align='center'>
                                                                <font size="1">Kode Booking
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">No MR
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Nama Pasien
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Tanggal Booking
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Kelas
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Ruangan
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Bed
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Keterangan
                                                            </th>
                                                            <th align='center'>
                                                                <font size="1">Action
                                                            </th>
                            </tr>
                        </thead>
                        <tbody id="datalistbooking_dtl">

                        </tbody>
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
<div class="modal fade" id="validateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Validasi Data Pasien<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                                <p> <strong>Info !</strong> Data reservasi ini belum mempunyai nomor MR</p>
                                <p> <strong>Info !</strong> Pastikan data reservasi dan data pasien yang ingin checkin benar!</p>
                            </div>
                <br>
                <div class="alert alert-info alert-dismissible">
                                <p> <strong>Data Pasien RESERVASI</strong>
                            </div>
                <div class="form-horizontal" id="form_validasi">
                        <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="patientname"  name="patientname" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Alamat<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <textarea class="form-control input-sm" id="patientaddress" name="patientaddress" rows="2" style="resize: none" readonly></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <select name="patientsex" id="patientsex" class="form-control input-sm" >
                                            <option value="">--Pilih--</option>
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tempat Tanggal Lahir<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="patientbirthplace"  name="patientbirthplace" type="text" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="patientbirthdate"  name="patientbirthdate" type="date" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No Booking<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="kodebooking_validasi"  name="kodebooking_validasi" type="text" readonly>
                                    </div>
                                </div>


                        <div class="alert alert-warning alert-dismissible">
                                <p> <strong>Data Pasien CHECKIN</strong>
                            </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="patientname_validasi"  name="patientname_validasi" type="text" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Alamat<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <textarea class="form-control input-sm" id="patientaddress_validasi" name="patientaddress_validasi" rows="2" style="resize: none" readonly></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <select name="patientsex_validasi" id="patientsex_validasi" class="form-control input-sm" >
                                            <option value="">--Pilih--</option>
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tempat Tanggal Lahir<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="patientbirthplace_validasi"  name="patientbirthplace_validasi" type="text" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control input-sm " id="patientbirthdate_validasi"  name="patientbirthdate_validasi" type="date" readonly>
                                    </div>
                                </div>

                                
                            <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No MR<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="nomr_validasi"  name="nomr_validasi" type="text" readonly>
                                    </div>
                                </div>

            </div>

</div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-maroon btn-wide btn-rounded" id="btnSaveValidate" >Simpan</button>
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>



 <!-- ========== COMMON JS FILES ========== -->
 <script src="<?= BASEURL; ?>/js/DataTables/datatables.min.js"></script>
 <script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
 <script src="<?= BASEURL; ?>/js/App/registration/input/inputregistratrationkamar_V01.js"></script>