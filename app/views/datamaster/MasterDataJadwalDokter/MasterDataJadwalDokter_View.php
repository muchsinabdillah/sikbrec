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
                             <form class="form-horizontal" id="form_cuti">
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> ID <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <input type="text" class="form-control" name="IdAuto" id="IdAuto" value="<?= $data['id'] ?>" readonly>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Group Jadwal <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select name="GroupJadwal" id="GroupJadwal" class="form-control">
                                             <option value="1">BPJS</option>
                                             <option value="2">NON BPJS</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Poliklinik <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select name="GrupPerawatan" id="GrupPerawatan" class="form-control" onchange="getIDDokter()">
                                         </select>
                                     </div>

                                     <label for=" inputEmail3" class="col-sm-2 control-label"> Nama Dokter <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select name="NamaDokter" id="NamaDokter" class="form-control">
                                         </select>
                                     </div>
                                 </div>

                                 <div class="form-group gut">
                                     <label for="inputEmail3" class="col-sm-2 control-label"> Status Jadwal <sup class="color-danger">*</sup></label>
                                     <div class="col-sm-4">
                                         <select name="StatusJadwal" id="StatusJadwal" class="form-control">
                                             <option value="">-- PILIH --</option>
                                             <option value="0">NON Aktif</option>
                                             <option value="1">Aktif</option>

                                         </select>
                                     </div>
                                 </div>
                                 <hr>
                                 <div class="alert alert-danger alert-dismissible">
                                     <p> <strong>Info !</strong> Silahkan Masukan Data Jadwal Dokter ( Jam Awal, Jam Akhir, dan Kuota).</p>
                                     <p> <strong>Info !</strong> Silahkan Perhatikan Reservasi Pasien Yang Sudah Ada, Karena Akan Terhapus Jika Tidak Sesuai Di Data Jadwal Dokter.</p>
                                     <p> <strong>Info !</strong> Isikan Data Jadwal Dokter pada hari Dokter Praktek saja. dengan cara Pilih Status Aktif. </p>
                                     <p> <strong>Info !</strong> Jika Data Sudah Terisi, silahkan Klik SUBMIT.</p>
                                     <p> <strong>Info !</strong> Sebelum anda Kirim Ke HFIS, Pastikan Data yang mau dikirim sudah di SUBMIT ke sistem SIMRS ( KLIK TOMBOL SUBMIT ), kemudian Klik tombol SEND HFIS.</p>
                                 </div>
                                 <table id="example" class="display" cellspacing="0" width="100%">
                                     <thead>
                                         <tr>
                                             <th align='center'>Hari
                                             </th>
                                             <th align='center'>Status
                                             </th>
                                             <th align='center'>Waku Awal
                                             </th>
                                             <th align='center'>Waktu Akhir
                                             </th>
                                             <th align='center'>Session
                                             </th>
                                             <th align='center'>Kuota Max
                                             </th>
                                             <th align='center'>Kuota BPJS
                                             </th>
                                             <th align='center'>Kuota Non BPJS
                                             </th>
                                             <!-- <th align='center'>Send HFIS
                                             </th> -->
                                         </tr>
                                         <tr>
                                             <th align='center'>Senin
                                             </th>
                                             <th align='center'>
                                                 <select class="form-control js-example-basic-single" id="SeninStatus" name="SeninStatus">
                                                     <option value="">-- PILIH STATUS --</option>
                                                     <option value="0">Tidak Aktif</option>
                                                     <option value="1">Aktif</option>
                                                 </select>
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="SeninWaktuAwal" name="SeninWaktuAwal">
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="SeninWaktuAkhir" name="SeninWaktuAkhir">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="SessionSenin" name="SessionSenin" readonly="">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="MaxSenin" name="MaxSenin">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaBpjsSenin" name="KuotaBpjsSenin">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaNonBpjsSenin" name="KuotaNonBpjsSenin">
                                             </th>
                                             <!-- <th>
                                                 <button type="button" class="btn btn-default border-danger btn-animated btn-xs" onclick="sendHFIS('Senin')"><span class="visible-content">Send HFIS</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>
                                             </th> -->
                                         </tr>
                                         <tr>
                                             <th align='center'>Selasa
                                             </th>
                                             <th align='center'>
                                                 <select class="form-control js-example-basic-single" id="SelasaStatus" name="SelasaStatus">
                                                     <option value="">-- PILIH STATUS --</option>
                                                     <option value="0">Tidak Aktif</option>
                                                     <option value="1">Aktif</option>
                                                 </select>
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="SelasaWaktuAwal" name="SelasaWaktuAwal">
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="SelasaWaktuAkhir" name="SelasaWaktuAkhir">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="SessionSelasa" name="SessionSelasa" readonly="">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="MaxSelasa" name="MaxSelasa">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaBpjsSelasa" name="KuotaBpjsSelasa">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaNonBpjsSelasa" name="KuotaNonBpjsSelasa">
                                             </th>
                                             <!-- <th>
                                                 <button type="button" class="btn btn-default border-danger btn-animated btn-xs" onclick="sendHFIS('Selasa')"><span class="visible-content">Send HFIS</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>
                                             </th> -->
                                         </tr>
                                         <tr>
                                             <th align='center'>Rabu
                                             </th>
                                             <th align='center'>
                                                 <select class="form-control js-example-basic-single" id="RabuStatus" name="RabuStatus">
                                                     <option value="">-- PILIH STATUS --</option>
                                                     <option value="0">Tidak Aktif</option>
                                                     <option value="1">Aktif</option>
                                                 </select>
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="RabuWaktuAwal" name="RabuWaktuAwal">
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="RabuWaktuAkhir" name="RabuWaktuAkhir">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="SessionRabu" name="SessionRabu" readonly="">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="MaxRabu" name="MaxRabu">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaBpjsRabu" name="KuotaBpjsRabu">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaNonBpjsRabu" name="KuotaNonBpjsRabu">
                                             </th>
                                             <!-- <th>
                                                 <button type="button" class="btn btn-default border-danger btn-animated btn-xs" onclick="sendHFIS('Rabu')"><span class="visible-content">Send HFIS</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>
                                             </th> -->
                                         </tr>
                                         <tr>
                                             <th align='center'>Kamis
                                             </th>
                                             <th align='center'>
                                                 <select class="form-control js-example-basic-single" id="KamisStatus" name="KamisStatus">
                                                     <option value="">-- PILIH STATUS --</option>
                                                     <option value="0">Tidak Aktif</option>
                                                     <option value="1">Aktif</option>
                                                 </select>
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="KamisWaktuAwal" name="KamisWaktuAwal">
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="KamisWaktuAkhir" name="KamisWaktuAkhir">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="SessionKamis" name="SessionKamis" readonly="">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="MaxKamis" name="MaxKamis">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaBpjsKamis" name="KuotaBpjsKamis">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaNonBpjsKamis" name="KuotaNonBpjsKamis">
                                             </th>
                                             <!-- <th>
                                                 <button type="button" class="btn btn-default border-danger btn-animated btn-xs" onclick="sendHFIS('Kamis')"><span class="visible-content">Send HFIS</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>
                                             </th> -->
                                         </tr>
                                         <tr>
                                             <th align='center'>Jumat
                                             </th>
                                             <th align='center'>
                                                 <select class="form-control js-example-basic-single" id="JumatStatus" name="JumatStatus">
                                                     <option value="">-- PILIH STATUS --</option>
                                                     <option value="0">Tidak Aktif</option>
                                                     <option value="1">Aktif</option>
                                                 </select>
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="JumatWaktuAwal" name="JumatWaktuAwal">
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="JumatWaktuAkhir" name="JumatWaktuAkhir">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="SessionJumat" name="SessionJumat" readonly="">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="MaxJumat" name="MaxJumat">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaBpjsJumat" name="KuotaBpjsJumat">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaNonBpjsJumat" name="KuotaNonBpjsJumat">
                                             </th>
                                             <!-- <th>
                                                 <button type="button" class="btn btn-default border-danger btn-animated btn-xs" onclick="sendHFIS('Jumat')"><span class="visible-content">Send HFIS</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>
                                             </th> -->
                                         </tr>
                                         <tr>
                                             <th align='center'>Sabtu
                                             </th>
                                             <th align='center'>
                                                 <select class="form-control js-example-basic-single" id="SabtuStatus" name="SabtuStatus">
                                                     <option value="">-- PILIH STATUS --</option>
                                                     <option value="0">Tidak Aktif</option>
                                                     <option value="1">Aktif</option>
                                                 </select>
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="SabtuWaktuAwal" name="SabtuWaktuAwal">
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="SabtuWaktuAkhir" name="SabtuWaktuAkhir">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="SessionSabtu" name="SessionSabtu" readonly="">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="MaxSabtu" name="MaxSabtu">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaBpjsSabtu" name="KuotaBpjsSabtu">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaNonBpjsSabtu" name="KuotaNonBpjsSabtu">
                                             </th>
                                             <!-- <th>
                                                 <button type="button" class="btn btn-default border-danger btn-animated btn-xs" onclick="sendHFIS('Sabtu')"><span class="visible-content">Send HFIS</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>
                                             </th> -->
                                         </tr>
                                         <tr>
                                             <th align='center'>Minggu
                                             </th>
                                             <th align='center'>
                                                 <select class="form-control js-example-basic-single" id="MingguStatus" name="MingguStatus">
                                                     <option value="">-- PILIH STATUS --</option>
                                                     <option value="0">Tidak Aktif</option>
                                                     <option value="1">Aktif</option>
                                                 </select>
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="MingguWaktuAwal" name="MingguWaktuAwal">
                                             </th>
                                             <th>
                                                 <input type="time" class="form-control" id="MingguWaktuAkhir" name="MingguWaktuAkhir">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="SessionMinggu" name="SessionMinggu" readonly="">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="MaxMinggu" name="MaxMinggu">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaBpjsMinggu" name="KuotaBpjsMinggu">
                                             </th>
                                             <th>
                                                 <input type="text" class="form-control" id="KuotaNonBpjsMinggu" name="KuotaNonBpjsMinggu">
                                             </th>
                                             <!-- <th>
                                                 <button type="button" class="btn btn-default border-danger btn-animated btn-xs" onclick="sendHFIS('Minggu')"><span class="visible-content">Send HFIS</span><span class="hidden-content"><i class="fa fa-hand-pointer-o"></i></span></button>
                                             </th> -->
                                         </tr>
                                     </thead>
                                     <tbody>
                                     </tbody>
                                 </table>

                                 <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 control-label"> Note </label>
                                     <div class="col-sm-11">
                                         <textarea rows="2" class="form-control" id="Note" name="Note" style="resize: none"></textarea>
                                     </div>
                                 </div>
                                 <!-- MODEL PERTAMA
                                 <div class="form-group">
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Senin</label>
                                      <div class="col-sm-2">
                                        <select class="form-control js-example-basic-single" id="SeninStatus" name="SeninStatus">
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Waktu</label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="SeninWaktuAwal" name="SeninWaktuAwal" >
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> S/d </label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="SeninWaktuAkhir" name="SeninWaktuAkhir" >
                                     </div>
                                       <div class="col-sm-2">
                                          <input type="text" class="form-control" id="SessionSenin" name="SessionSenin" readonly="">
                                     </div>
                                     <div class="col-sm-1">
                                          <input type="text" class="form-control" id="MaxSenin" name="MaxSenin" >
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Selasa </label>
                                      <div class="col-sm-2">
                                         <select class="form-control js-example-basic-single" id="SelasaStatus" name="SeninStatus">
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Waktu</label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="SelasaWaktuAwal" name="SelasaWaktuAwal" >
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> S/d </label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="SelasaWaktuAkhir" name="SelasaWaktuAkhir" >
                                     </div>
                                       <div class="col-sm-2">
                                          <input type="text" class="form-control" id="SessionSelasa" name="SessionSelasa" readonly="">
                                     </div>
                                     <div class="col-sm-1">
                                          <input type="text" class="form-control" id="MaxSelasa" name="MaxSelasa" >
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Rabu </label>
                                      <div class="col-sm-2">
                                         <select class="form-control js-example-basic-single" id="RabuStatus" name="SeninStatus">
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Waktu</label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="RabuWaktuAwal" name="RabuWaktuAwal" >
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> S/d </label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="RabuWaktuAkhir" name="RabuWaktuAkhir" >
                                     </div>
                                       <div class="col-sm-2">
                                          <input type="text" class="form-control" id="SessionRabu" name="SessionRabu" readonly="">
                                     </div>
                                     <div class="col-sm-1">
                                          <input type="text" class="form-control" id="MaxRabu" name="MaxRabu" >
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Kamis </label>
                                      <div class="col-sm-2">
                                         <select class="form-control js-example-basic-single" id="KamisStatus" name="SeninStatus">
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Waktu</label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="KamisWaktuAwal" name="KamisWaktuAwal" >
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> S/d </label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="KamisWaktuAkhir" name="KamisWaktuAkhir" >
                                     </div>
                                       <div class="col-sm-2">
                                          <input type="text" class="form-control" id="SessionKamis" name="SessionKamis" readonly="">
                                     </div>
                                     <div class="col-sm-1">
                                          <input type="text" class="form-control" id="MaxKamis" name="MaxKamis" >
                                     </div>
                                 </div>
                                   <div class="form-group">
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Jumat </label>
                                      <div class="col-sm-2">
                                         <select class="form-control js-example-basic-single" id="JumatStatus" name="SeninStatus">
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Waktu</label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="JumatWaktuAwal" name="JumatWaktuAwal" >
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> S/d </label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="JumatWaktuAkhir" name="JumatWaktuAkhir" >
                                     </div>
                                       <div class="col-sm-2">
                                          <input type="text" class="form-control" id="SessionJumat" name="SessionJumat" readonly="">
                                     </div>
                                     <div class="col-sm-1">
                                          <input type="text" class="form-control" id="MaxJumat" name="MaxJumat" >
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Sabtu </label>
                                      <div class="col-sm-2">
                                         <select class="form-control js-example-basic-single" id="SabtuStatus" name="SeninStatus">
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Waktu</label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="SabtuWaktuAwal" name="SabtuWaktuAwal" >
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> S/d </label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="SabtuWaktuAkhir" name="SabtuWaktuAkhir" >
                                     </div>
                                       <div class="col-sm-2">
                                          <input type="text" class="form-control" id="SessionSabtu" name="SessionSabtu" readonly="">
                                     </div>
                                     <div class="col-sm-1">
                                          <input type="text" class="form-control" id="MaxSabtu" name="MaxSabtu" >
                                     </div>
                                 </div>
                                   <div class="form-group">
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Minggu </label>
                                      <div class="col-sm-2">
                                         <select class="form-control js-example-basic-single" id="MingguStatus" name="SeninStatus">
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                         </select>
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> Waktu</label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="MingguWaktuAwal" name="MingguWaktuAwal" >
                                     </div>
                                     <label for=" inputEmail3" class="col-sm-1 control-label"> S/d </label>
                                      <div class="col-sm-2">
                                          <input type="time" class="form-control" id="MingguWaktuAkhir" name="MingguWaktuAkhir" >
                                     </div>
                                       <div class="col-sm-2">
                                          <input type="text" class="form-control" id="SessionMinggu" name="SessionMinggu" readonly="">
                                     </div>
                                     <div class="col-sm-1">
                                          <input type="text" class="form-control" id="MaxMinggu" name="MaxMinggu" >
                                     </div>
                                 </div>
                             -->

                             </form>
                             <button id="btnCancel" name="btnCancel" onclick="MyBack()" class="btn bg-gray btn-wide"><i class="fa fa-times"></i>Cancel</button>
                             <button class="btn bg-black btn-wide" id="btnSave" name="btnSave"><i class="fa fa-check"></i>Submit</button>
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
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterLoginUser/A_Hak_Akses_V02.js"></script>
 <script src="<?= BASEURL; ?>/js/App/MasterData/MasterDataJadwalDokter/MasterDataJadwalDokter_View_02.js"></script>