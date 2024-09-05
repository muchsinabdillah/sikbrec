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
                                <h5><?= $data['judul'] ?><small> - <sup class="color-danger">*</sup>) Harus diisi
                                    </small></h5>
                            </div>
                            <br>

                            <div class="alert alert-success alert-dismissible">
                                <p> <strong>Info !</strong> Jika ada perubahan data Rekam Medik Seperti Alamat, tgl
                                    lahir, dan lain-lain silahkan rubah dari menu Medical record dan refresh kembali
                                    halaman ini</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="frmSimpanTrsRegistrasi">
                                <h5 class="underline mt-15">Data Transaksi Booking Tempat Tidur</h5>
                                    
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. Transaksi<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="transactioncode"  readonly name="transactioncode" type="text" value="<?= $data['id'] ?>">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pasien<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <select name="jenispasien" id="jenispasien" class="form-control input-sm" onchange="getjenispasien()">
                                            <option value="">--Pilih--</option>
                                            <option value="Lama">Pasien Lama</option>
                                            <option value="Baru">Pasien Baru</option>
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Transaksi<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="transactiondate"  name="transactiondate" type="datetime-local" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> No. MR<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-3">
                                        <input class="form-control input-sm " id="medicalrecordnumber"  name="medicalrecordnumber" type="text" readonly>
                                    </div>
                                    <div class="col-sm-1">
                                    <button type="button" class="btn btn-maroon btn-rounded waves-effect" id="btnSearchMR" name="btnSearchMR"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> </btuuon>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Tgl Booking<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="bookingbeddate"  name="bookingbeddate" type="date" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Pasien<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm " id="patientname"  name="patientname" type="text" readonly>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Kelas<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1" >
                                        <input class="form-control input-sm " id="classname"  name="classname" type="text" readonly>
                                        <input class="form-control input-sm " id="classid"  name="classid" type="hidden" readonly >
                                    </div>
                                    <div class="col-sm-3">
                                    <select class="form-control js-example-basic-single" id="classid_temp" name="classid_temp" >
                                         </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Alamat<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <textarea class="form-control input-sm" id="patientaddress" name="patientaddress" rows="2" style="resize: none" readonly></textarea>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Ruangan<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1" >
                                        <input class="form-control input-sm " id="roomname"  name="roomname" type="text" readonly>
                                        <input class="form-control input-sm " id="roomid"  name="roomid" type="hidden" readonly >
                                    </div>
                                    <div class="col-sm-3">
                                    <select class="form-control js-example-basic-single" id="roomid_temp" name="roomid_temp" >
                                         </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Kelamin<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <select name="patientsex" id="patientsex" class="form-control input-sm" >
                                            <option value="">--Pilih--</option>
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Bed<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-1" >
                                        <input class="form-control input-sm " id="bedname"  name="bedname" type="text" readonly>
                                        <input class="form-control input-sm " id="bedid"  name="bedid" type="hidden" readonly >
                                    </div>
                                    <div class="col-sm-3">
                                    <select class="form-control js-example-basic-single" id="bedid_temp" name="bedid_temp" >
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

                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Keterangan<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <textarea class="form-control input-sm" id="notes" name="notes" rows="2" style="resize: none" required></textarea>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Booking<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <select name="jenisbooking" id="jenisbooking" class="form-control input-sm" >
                                            <option value="">--Pilih--</option>
                                            <option value="REGULER">REGULER</option>
                                            <option value="CITO">CITO</option>
                                        </select>
                                    </div>
                                </div>

                                <br><br><br><br>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Status Booking<sup class="color-danger">*</sup></label>
                                    <div class="col-sm-4">
                                    <input class="form-control input-sm " id="bookingstatus" readonly name="bookingstatus" type="text" >
                                    </div>
                                </div>
                                

                            </form>

                    <div class="btn-group" role="group">
                                <button class="btn btn-maroon  btn-rounded " id="savetrs" name="savetrs"> Simpan</button>
                                <button class="btn btn-gold  btn-rounded " id="batal" name="batal" >
                                    Batal</button>
                                <button class="btn btn-black  btn-rounded " id="close" name="close" onclick="MyBack()">
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Rekam Medik Pasien <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong> Untuk Pencarian bisa Dilakukan Pencarian dengan Nama, No. MR, Tgl Lahir,
                        Alamat, dll.</p>
                    <p> <strong>Info !</strong> Untuk Pencarian dengan Tanggal Lahir silahhkan ketik dengan cara
                        dd/mm/yyyy.</p>
                    <p> <strong>Info !</strong> Contoh : 01/01/1991.</p>
                </div>
                <div class="form-horizontal" id="form_cuti">
                    <label for="inputEmail3" class="col-sm-3 control-label"> Masukan Kata Kunci <sup class="color-danger">*</sup></label>

                    <div class="form-group  ">
                        <div class="col-sm-3">
                            <select id="cmbxcrimr" name="cmbxcrimr" style="width: 100%;" class="form-control ">
                                <option value="1">NAMA PASIEN</option>
                                <option value="2">TGL LAHIR</option>
                                <option value="3">NO. MR</option>
                                <option value="4">ALAMAT</option>
                                <option value="5">NO. IDENTITAS</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" type="text" id="txSearchData" autocomplete="off" name="txSearchData" placeholder="ketik Kata Kunci disini">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="btnSearchMrAktif" class="btn btn-success btn-wide btn-rounded" onclick="loaddatamr()"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table-load-data" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>No MR</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Lahir</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="datamedicalrecord">

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
<!-- Modal Batal Registrasi -->
<div class="modal fade" id="modal_alert_batal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Batal Registrasi</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmBatalReg">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-4 control-label">No. Registrasi</label>
                        <div class="col-sm-6">
                            <input class="form-control input-sm" type="text" id="noregbatal" readonly name="noregbatal" placeholder="ketik Kata Kunci disini">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-4 control-label">Alasan Batal </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="alasanbatal" name="alasanbatal" rows="3"></textarea>
                        </div>
                    </div>
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-wide btn-rounded" id="btnVoidTrsReg" name="btnVoidTrsReg" onclick="batalreservasi()"><i class="fa fa-plus"></i> Batal </button>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcPasienClose" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalcariDataReservasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data Reservasi <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong> Data Reservasi yang Muncul adalah data reservasi pada hari ini.</p>
                    <p> <strong>Info !</strong> Silahkan klik tombol search untuk menampilkan data reservasi hari ini.
                    </p>
                </div>
                <form class="form-horizontal" id="form_cuti">
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-3 control-label"> Periode <sup class="color-danger">*</sup></label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="tglawal_Search" id="tglawal_Search">
                        </div>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="tglakhir_Search" id="tglakhir_Search">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-default btn-rounded" id="btnCariReservasi" name="btnCariReservasi" onclick="getDataReservasiWalkin()">
                                <span class="glyphicon glyphicon-search"></span> Search
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="table-load-data-reservasi" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th align='center'>
                                    No
                                </th>
                                <th align='center'>
                                    No. MR
                                </th>
                                <th align='center'>
                                    Nama Pasien
                                </th>
                                <th align='center'>
                                    Tgl Booking
                                </th>
                                <th align='center'>
                                    Poliklinik
                                </th>
                                <th align='center'>
                                    Dokter
                                </th>
                                <th align='center'>
                                    No. Antrian
                                </th>
                                <th align='center'>
                                    Jenis Pembayaran
                                </th>
                                <th align='center'>
                                    Jam Praktek
                                </th>
                                <th align='center'>
                                    Alamat
                                </th>
                                <th align='center'>
                                    Tgl Lahir
                                </th>
                            </tr>
                        </thead>
                        <tbody id="datareservasi"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcReservasi" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk PASIEN BPJS ------------------------------------------------>
<div class="modal fade" id="modal_VerifBPJS" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Input SEP BPJS Kesehatan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_kepesertaan_Bpjs">
                    <h5 class="underline mt-30">Verifikasi Kepesertaan BPJS Kesehatan</h5>
                    <div class="form-group  ">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Rujukan Dari <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisRujukanFaskesBPJS" nama="JenisRujukanFaskesBPJS" class="form-control input-sm">
                                <option value="1">Faskes 1</option>
                                <option value="2">Faskes 2</option>
                            </select>
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> No. Kartu/KTP/RJ <sup class="color-danger">*</sup></label>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" type="text" id="idPesertaBPJS" name="idPesertaBPJS">
                        </div>
                        <div class="col-sm-1" style="margin-left: -25px;">
                            <button class="btn btn-primary btn-sm" type="button" id="btnCekKepesertaan" name="btnCekKepesertaan">INQUIRY</button>
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Cari Berdasarkan <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id="JenisPencarianBPJS" nama="JenisPencarianBPJS" class="form-control input-sm">
                                <option value="1">NIK</option>
                                <option value="2">KARTU PESERTA</option>
                                <option value="3">RUJUKAN ONLINE</option>
                            </select>
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> PPK Rujukan <sup class="color-danger">*</sup></label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="idppkrujukanBPJS" name="idppkrujukanBPJS" type="text">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="namappkrujukanBPJS" readonly name="namappkrujukanBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No. Kartu BPJS <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="nokartubpjs" readonly name="nokartubpjs" type="text">
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> Diagnosa <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="norujukanBPJS" readonly name="norujukanBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No. NIK </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="nonikktpBPJS" readonly name="nonikktpBPJS" type="text">
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label"> Status Peserta </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="statuspesertaBPJS" readonly name="statuspesertaBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Peserta </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="admpatientName" readonly name="admpatientName" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <label for=" inputEmail3" class="col-sm-2 control-label" style="margin-bottom:3px;"> Keterangan
                            PRB </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="keteranganprbBPJS" readonly name="keteranganprbBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Hak Kelas </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="idhakKelas" readonly name="idhakKelas" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="hakKelas" readonly name="hakKelas" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> COB - No. Asuransi </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="cobnosuratBPJS" readonly name="cobnosuratBPJS" type="text">
                        </div>
                    </div>


                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Nama Faskes </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="idfaskes" readonly name="idfaskes" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="namafaskes" readonly name="namafaskes" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> COB - Nama Asuransi </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="cobNamaAsuransiBPJS" readonly name="cobNamaAsuransiBPJS" type="text">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> No. Rujukan </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="norujukan" readonly name="norujukan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Jenis Pelayanan </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="kdjenispelayananbpjsBPJS" readonly name="kdjenispelayananbpjsBPJS" type="text">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="nmjenispelayananbpjsBPJS" readonly name="nmjenispelayananbpjsBPJS" type="text">
                        </div>

                        <label for="inputEmail3" class="col-sm-2 control-label"> kelas Perawatan </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm " id="kdkelasperawatanBPJS" readonly name="kdkelasperawatanBPJS" type="text">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm " id="nmkelasperawatanBPJS" readonly name="nmkelasperawatanBPJS" type="text">
                        </div>
                    </div>
                    <h5 class="underline mt-30">DATA KLINIS SEP PASIEN</h5>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa Awal <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <select id='isDiagnosaawalBPJS' class="form-control" onchange="good();">
                                <option value='0'>- Search WBS ID -</option>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label"> Diagnosa Terpilih </label>
                        <div class="col-sm-1">
                            <input class="form-control input-sm" type="text" id="kdDiagnosaawalBPJSChoose" readonly name="kdDiagnosaawalBPJSChoose">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control input-sm" type="text" id="nmDiagnosaawalBPJSChoose" readonly name="nmDiagnosaawalBPJSChoose">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> COB </label>
                        <div class="col-sm-4">
                            <select id="isDiagnosaawalBPJSx" name="isDiagnosaawalBPJSx" class="col-sm-9">
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
                        <label for="inputEmail3" class="col-sm-2 control-label"> No. Surat Kontrol <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="NoSuratKontrolBPJS" name="NoSuratKontrolBPJS" placeholder="Ketik No. Surat Kontrol">
                        </div>
                    </div>
                    <div class="form-group gut">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Catatan <sup class="color-danger">*</sup></label>
                        <div class="col-sm-4">
                            <textarea class="form-control input-sm" id="iscatatanBPJS" name="iscatatanBPJS" rows="4"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn bg-success  btn-wide" id="btnFinishPayroll" name="btnFinishPayroll" onclick="AddTempLBByIDByLuar()"><i class="fa fa-check"> </i> SIMPAN SEP</button>
            </div>
        </div>
    </div>
</div>
<!--#END Modal Untuk Notif Resep---------------------------->
<!-- Modal Untuk Notif Resep ------------------------------------------------>
<div class="modal fade" id="Notif_awal_registrasi2" tabindex="-1" role="dialog" style="overflow-y: auto" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Data Polis Asuransi </h4>
            </div>
            <form id="FrmDataPolisKartu">
                <div class="modal-body">
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. ID</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="Kartu_ID" readonly name="Kartu_ID">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="namapasien" class="col-sm-4 col-form-label">No. Rekam Medik</label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm" type="text" id="kartu_NoRM" readonly name="kartu_NoRM">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pasien </label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="Kartu_NamaPasien" readonly name="Kartu_NamaPasien" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Group Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="Kartu_GroupJaminan" readonly name="Kartu_GroupJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamagroupJaminan_Asr" readonly name="Kartu_NamagroupJaminan_Asr" type="text" placeholder="Ketik Nama Group Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Jaminan </label>
                        <div class="col-sm-2">
                            <input class="form-control input-sm " id="Kartu_NamaJaminan" readonly name="Kartu_NamaJaminan" type="text" placeholder="Ketik Nama Pasien">
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control input-sm " id="Kartu_NamaJaminanx_Asr" readonly name="Kartu_NamaJaminanx_Asr" type="text" placeholder="Ketik Nama Jaminan">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">No. Kartu Polis </label>
                        <div class="col-sm-4">
                            <input class="form-control input-sm " id="Kartu_NoPeserta" name="Kartu_NoPeserta" type="number" placeholder="No. Kartu Polis">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Hak Kelas</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="Kartu_HakKelas" id="Kartu_HakKelas">
                                <option value=""></option>
                                <option value="KELAS 1">KELAS 1</option>
                                <option value="KELAS 2">KELAS 2</option>
                                <option value="KELAS 3">KELAS 3</option>
                                <option value="KELAS VIP">KELAS VIP</option>
                                <option value="KELAS VVIP">KELAS VVIP</option>
                            </select>

                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Status Peserta</label>
                        <div class="col-sm-8">
                            <select id="Kartu_StatusPeserta" name="Kartu_StatusPeserta" class="form-control input-sm ">
                                <option value=""></option>
                                <option value="PESERTA">PESERTA</option>
                                <option value="SUAMI">SUAMI</option>
                                <option value="ISTRI">ISTRI</option>
                                <option value="AYAH">AYAH</option>
                                <option value="IBU">IBU</option>
                                <option value="ANAK 1">ANAK 1</option>
                                <option value="ANAK 2">ANAK 2</option>
                                <option value="ANAK 3">ANAK 3</option>
                                <option value="ANAK 4">ANAK 4</option>
                                <option value="ANAK 5">ANAK 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Nama Pemegang Kartu</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="Kartu_NamaPemegangKartu" name="Kartu_NamaPemegangKartu" type="text" placeholder="Ketik Nama Pemegang Kartu">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:3px;">
                        <label for="dokter" class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <input class="form-control input-sm " id="Kartu_Keterangan" name="Kartu_Keterangan" type="text" placeholder="Ketik Keterangan">
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <div class="form-group row" style="margin-right:1em;float:right;">
                    <button class="btn btn-primary" id="btnSavePoli" name="btnSavePoli"> Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="notif_Cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cetak</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong>
                        Pada Kunungan ke 2 berdasarkan No. Rujukan ini. Tidak di buatkan No. Reservasi Otomatis dari
                        SIMRS, hanya di buatkan
                        saja Surat Kontrol dan kemudian di cetak dan diberikan ke Pasien Sebagai Bukti Kontrol
                        Selanjutnya.
                    </p>
                    <p> <strong>Info !</strong> Mulai 1 Januari 2023 - Khusus untuk Pasien BPJS Kesehatan Kunjungan ke 2
                        Poliklinik berdasarkan No. Rujukan. Diharuskan melakukan Reservasi via Mobile JKN.
                        Silahkan informasikan ke Pasien untuk Melakukan Reservasi via Mobile JKN untuk menghindari
                        Antrian Saat Mendaftar di Hari H.</p>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <p class="text-center"><strong>Cetak SPRI</strong></p><br>
                        <img src="<?= BASEURL; ?>/images/jenis_reg/LogoBPJS.Png" id="logocetakbuktiSEP" class="img-circle person" alt="Random Name" width="150" height="150">
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
<div class="modal fade" id="notif_Cetak_peringatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Syarat dan Kebijakan ( Entri Kontrol Ulang Pasien )</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p>
                        Entri Surat Kontrol / Reservasi via SIMRS pada modul ini berlaku baik itu Pasien BPJS Kesehatan
                        maupun Non BPJS Kesehatan.
                        <b>Proses ini merupakan proses Mandatory yang harus di lakukan ketika Pasien Pasca Rawat Inap
                            atau Kontrol
                            Ulang pada Poli.</b>
                        Adapun beberapa ketentuan yang Harus Di Pahami adalah sebagai berikut :
                    </p>
                    <br>
                    <p>
                        1. Untuk Pasien <b>Post Rawat Inap</b>, Jika Pasien BPJS Kesehatan maka dibuatkan Reservasi
                        Online langsung dari SIMRS dan juga Bukti Surat Kontrol
                        BPJS Kesehatan sebagai Bukti Kontrol berikutnya.
                    </p>
                    <br>
                    <p>
                        2. Untuk Pasien <b>Kunjungan ke 2 dengan Rujukan baik Faskes 1 atau 2 </b>,
                        Jika Pasien BPJS Kesehatan dengan <b>Poli yang sama dengan Poli yang tertera di surat
                            Kontrol</b>
                        maka hanya di buatkan Surat
                        Kontrol BPJS Kesehatan sebagai Bukti Kontrol berikutnya.
                    </p>
                    <br>
                    <p>
                        3. Untuk Pasien BPJS Kesehatan sebagaimana sudah di sebutkan pada Point No. 2 di atas
                        <b>DI WAJIBKAN MELAKUKAN RESERVASI VIA MOBILE JKN</b>
                        untuk mengambil antrian ke Poliklinik. Untuk menghindari Antrian saat pasien Mendaftar pada Hari
                        H.
                        <b>ketentuan ini berlaku per 1 Januari 2023</b>
                    </p>
                    <br>
                    <p>
                        4. Untuk Pasien Non BPJS Kesehatan tidak ada Perubahan / tetap di buatkan Reservasi Online dan
                        akan di kirim
                        info langsung Via Whatsapp ke Nomor Pasien.
                    </p>
                    <br>
                    <p>
                        Kebijakan ini dibuat sebagai bentuk dukungan RS YARSI sebagai Rumah Sakit Percontohan untuk
                        Implementasi Mobile JKN
                        BPJS Kesehatan.
                    </p>
                </div>
                <div class="form-check">

                    <input class="form-check-input" type="checkbox" id="checkboxSyarat" onclick="checkTrue()">
                    Saya Sudah mengerti Syarat dan Kebijakan yang di buat di atas.
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-wide btn-rounded" onclick="closemodalSyarat()" id="btnCloseModalSyarat" name="btnCloseModalSyarat"><i class="fa fa-times"></i>CLOSE</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>

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
                            <small>Silahkan Masukan Alasan cetak selengkap mungkin, untuk memudahkan Tracing
                                Data.</small>
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

<!-- Modal -->
<div class="modal fade" id="modal_Pengajuan2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cari Data SEP Pasien <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible">
                    <p> <strong>Info !</strong> Silahkan Masukan No. Kartu BPJS Kesehatan.</p>

                </div>
                <form class="form-horizontal" id="form_cuti">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"> No. Kartu <sup class="color-danger">*</sup></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="nokartu" id="nokartu">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-default btn-rounded" id="btnCariReservasi" name="btnCariReservasi" onclick="getDataReservasiWalkin()">
                                <span class="glyphicon glyphicon-search"></span> Verify
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="table-load-data-reservasi" class="display table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th align='center'>
                                    No
                                </th>
                                <th align='center'>
                                    No. MR
                                </th>
                                <th align='center'>
                                    Nama Pasien
                                </th>
                                <th align='center'>
                                    Tgl Booking
                                </th>
                                <th align='center'>
                                    Poliklinik
                                </th>
                                <th align='center'>
                                    Dokter
                                </th>
                                <th align='center'>
                                    No. Antrian
                                </th>
                                <th align='center'>
                                    Jenis Pembayaran
                                </th>
                                <th align='center'>
                                    Jam Praktek
                                </th>
                                <th align='center'>
                                    Alamat
                                </th>
                                <th align='center'>
                                    Tgl Lahir
                                </th>
                            </tr>
                        </thead>
                        <tbody id="datareservasi"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-gray btn-wide btn-rounded" id="btnModalSrcReservasi" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
                </div>
                <!-- /.btn-group -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Untuk Notif Resep ------------------------------------------------>

<!-- Modal Lihat Rencana Kontrol--------------------------------------------->
<div class="modal fade" id="myModalLihatRencanaKontrol" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">SURAT KETERANGAN KONTROL JKN
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label"> No. RM </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatid" name="lihatid" type="hidden" readonly>
                        <input class="form-control input-sm" id="lihatNoMR" name="lihatNoMR" readonly>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-3 control-label"> Nama </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatNama" name="lihatNama" readonly>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-3 control-label"> Tanggal Surat Rujukan </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatTglSurat" name="lihatTglSurat" readonly>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-3 control-label"> Diagnosa </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatDiagnosa" name="lihatDiagnosa" readonly>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-3 control-label">Terapi </label>
                    <label for="inputEmail3" class="col-sm-1 control-label" style="margin-left:-5em"> : </label>
                    <div class="col-sm-7" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatTerapi" name="lihatTerapi" readonly>
                    </div>
                    <br><br><br>
                    <label for="inputEmail3" class="col-sm-10 control-label"> Belum Dapat Dikembalikan Ke Fasilitas
                        Perujuk/PPK Dengan Alasan :</label>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> </label>
                    <div class="col-sm-9" style="margin-left:-3em">
                        <textarea class="form-control input-sm" id="lihatAlasan_BelumDapat1" name="lihatAlasan_BelumDapat1" rows="3" style="resize: none" required readonly></textarea>
                    </div>
                    <!-- <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> 2. :</label>
                    <div class="col-sm-8" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatAlasan_BelumDapat2" name="lihatAlasan_BelumDapat2">
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> 3. :</label>
                    <div class="col-sm-8" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatAlasan_BelumDapat3" name="lihatAlasan_BelumDapat3">
                    </div> -->
                    <br><br><br><br>
                    <label for="inputEmail3" class="col-sm-10 control-label"> Rencana Tidak Lanjut Yang Akan Dilakukan
                        Pada Kunjungan Selanjutnya :</label>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> </label>
                    <div class="col-sm-9" style="margin-left:-3em">
                        <textarea class="form-control input-sm" id="lihatAlasan_TidakLanjut1" name="lihatAlasan_TidakLanjut1" rows="3" style="resize: none" required readonly></textarea>
                    </div>
                    <!-- <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> 2. :</label>
                    <div class="col-sm-8" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatAlasan_TidakLanjut2"
                            name="lihatAlasan_TidakLanjut2">
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> 3. :</label>
                    <div class="col-sm-8" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatAlasan_TidakLanjut3"
                            name="lihatAlasan_TidakLanjut3">
                    </div> -->
                    <br><br><br><br>
                    <label for="inputEmail3" class="col-sm-10 control-label"> Surat Keterangan Ini Digunakan untuk 1
                        (Satu) Kali Kunjungan Dengan Diagnosa Diatas Pada Kunjungan :</label>
                    <br><br>
                    <!-- <label for="inputEmail3" class="col-sm-1 control-label"> <input type="checkbox" id="cekTglKontrol"
                            name="cekTglKontrol" readonly>
                    </label> -->

                    <label for="inputEmail3" class="col-sm-4 control-label">Kontrol Kembali Ke
                        RS Tanggal :
                    </label>
                    <!-- <div class="col-sm-3" style="margin-left:-5em">
                        <input class="form-control input-sm" id="lihatTglKembaliKontrol" name="lihatTglKembaliKontrol" readonly>
                    </div> -->
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table id="table-load-data-kontrol" class="display table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th align='center'>
                                        ID
                                    </th>
                                    <th align='center'>
                                        Tgl Kontrol
                                    </th>
                                    <th align='center'>
                                        Polklinik
                                    </th>
                                    <th align='center'>
                                        Keterangan
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-1 control-label"> <input type="checkbox" id="cekKonsulSelesai" name="cekKonsulSelesai" onclick="return false;">
                    </label>
                    <label for="inputEmail3" class="col-sm-4 control-label" style="margin-left:-4em">Konsultasi Selesai
                    </label>
                    <br><br>
                    <label for="inputEmail3" class="col-sm-2 control-label" style="margin-left:20em"> Tanggal : </label>
                    <div class="col-sm-2" style="margin-left:-4em">
                        <input class="form-control input-sm" id="lihatTempatTTD" name="lihatTempatTTD" placeholder="Jakarta," readonly>
                    </div>
                    <div class="col-sm-4" style="margin-left:-3em">
                        <input class="form-control input-sm" id="lihatTglTTD" name="lihatTglTTD" readonly>
                    </div>
                    <br><br>
                    <img for="inputEmail3" class="col-sm-3 control-label" id="dokterSignature" src="" style="width:15%;margin-left:40em">
                    <label for="inputEmail3" class="col-sm-3 control-label" style="margin-left:40em">(............................................)
                    </label>
                    <label for="inputEmail3" class="col-sm-3 control-label" style="margin-left:44em"> Nama & TTD DPJP
                    </label>
                    <br><br><br><br><br>


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
<!-- Modal Lihat Rencana Kontrol-->
<!-- ========== COMMON JS FILES ========== -->
<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script>
    $(document).ready(function() {
        $(".preloader").fadeOut();
    });
</script>
<script src="<?= BASEURL; ?>/js/App/BookingKamar/BookingKamar_View.js"></script>
<!-- <script src="<?= BASEURL; ?>/js/App/registration/input/inputregistratrationrajal_V16.js"></script> -->