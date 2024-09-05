<style type="text/css">
.signature-area {
    width: 304px;
    margin: 50px auto;
    border: 1px solid black;
}

.signature-container {
    width: 60%;
    margin: auto;
}

.signature-list {
    width: 150px;
    height: 50px;
    border: solid 1px #cfcfcf;
    margin: 10px 5px;
}

.title-area {
    font-family: cursive;
    font-style: oblique;
    font-size: 12px;
    text-align: left;
}

.btn-save {
    color: #fff;
    background: #1c84c6;
    /* padding: 0.25rem 0.5rem; */
    /* font-size: 0.875rem; */
    line-height: 1.5;
    border-radius: 0.2rem;
    border: 1px solid transparent;
}

.btn-clear {
    color: #fff;
    background: #f7a54a;
    /* padding: 0.25rem 0.5rem; */
    /* font-size: 0.875rem; */
    line-height: 1.5;
    border-radius: 0.2rem;
    border: 1px solid transparent;
}

.doc_preview {
	color: #777;
	font-size: 25px;
	font-family: "Roboto", Arial;
	line-height: 1.25em;
	padding: 0 0 1em 0;
	text-align: justify;
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
                                    <h5 class="underline mt-30"><?= $data['judul'] ?> 
                                    <!-- &nbsp&nbsp&nbsp<button type="button"
                                                        name="btnHistory" id="btnHistory" class="btn btn-warning">Riwayat Dokumen
                                                    </button> -->
                                </h5>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form action="<?= BASEURL ?>/signatureDigital/SprtoPDF" method="POST" class="form-horizontal" id="frmSimpanTrsRegistrasi">
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
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-2 control-label"> TTL/Jenis Kelamin</label>
                                        <div class="col-sm-2">
                                            <input class="form-control input-sm" type="text" id="xTglLahir" readonly name="xTglLahir" value="<?= $data['register']['Date_of_birth'] ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control input-sm" type="text" id="JenisKelamin" readonly name="JenisKelamin"  value="<?= $data['register']['Gander'] ?>">
                                        </div> 
                                    </div>
                                    <hr>
                                        <!-- /.section -->
                                        <div class="col-md-6 mt-25">
                                            <div class="panel panel-primary no-border">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h5>Saya yang bertanda tangan di bawah ini adalah pasien / wali pasien</h5>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Nama :</label>
                                                        <div class="col-sm-8"> 
                                                            <input class="form-control input-sm " id="nama" name="nama" type="text" required placeholder="Ketik Nama" onkeyup="passData_ttdpasien()">
                                                        </div> 
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Jenis Kelamin :</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control input-sm" name="pnj_kelamin"
                                                                id="pnj_kelamin">
                                                                <option value="Laki-laki">Laki-Laki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            </select>
                                                        </div> 
                                                    </div> 
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Umur :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pnj_umur" name="pnj_umur" type="text" required placeholder="Ketik Umur">
                                                        </div> 
                                                    </div> 
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> No. HP :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pnj_noHP" name="pnj_noHP" type="number" required placeholder="Ketik No. Handphone">
                                                        </div> 
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> NIK :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pnj_noKTP" name="pnj_noKTP" type="number" required placeholder="Ketik No. NIK">
                                                        </div> 
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Pekerjaan :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pnj_pekerjaan" name="pnj_pekerjaan" type="text" required placeholder="Ketik Pekerjaan">
                                                        </div>  
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Alamat :</label>
                                                        <div class="col-sm-8">
                                                        <textarea class="form-control input-sm " id="pnj_alamat" name="pnj_alamat" placeholder="Ketik Alamat"></textarea>
                                                        </div> 
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Hubungan dengan Pasien :</label>
                                                        <div class="col-sm-8">
                                                        <select class="form-control" name="pnj_JenisOrang"
                                                            id="pnj_JenisOrang">
                                                            <option value="Diri Sendiri">Diri Sendiri</option>
                                                            <option value="Istri">Istri</option>
                                                            <option value="Suami">Suami</option>
                                                            <option value="Ayah">Ayah</option>
                                                            <option value="Ibu">Ibu</option>
                                                            <option value="Anak">Anak</option>
                                                            <option value="Kakak">Kakak</option>
                                                            <option value="Adik">Adik</option>
                                                            <option value="Teman">Teman</option>
                                                            <option value="Kerabat">Kerabat</option>
                                                            <option value="Lain-Lain">Lain-Lain</option>
                                                        </select>
                                                        </div> 
                                                    </div>
                                                    <p>Bahwa karena penyakit yang diderita pasien, dengan ini menyatakan sesungguhnya telah memberikan persetujuan untuk dilakukan perawatan di unit perawatan atau pelayanan rawat.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-25">
                                            <div class="panel panel-success no-border">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h5>Data Pasien</h5>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> No RM  :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pasien_nomr" name="pasien_nomr" type="text" readonly required placeholder="Ketik No. MR" value="<?= $data['register']['NoMR'] ?>">
                                                        </div> 
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Nama :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pasien_nama" name="pasien_nama" type="text" readonly required placeholder="Ketik Nama Pasien" value="<?= $data['register']['PatientName'] ?>">
                                                        </div> 
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Jenis Kelamin :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pasien_jeniskelamin" name="pasien_jeniskelamin" type="text" readonly required placeholder="Ketik Jenis Kelamin" value="<?= $data['register']['Gander'] ?>">
                                                        </div> 
                                                    </div>
                                                    <div class="form-group gut">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Tanggal Lahir :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pasien_tgllahir" name="pasien_tgllahir" type="date" required readonly placeholder="Ketik Nama" value="<?= $data['register']['Date_of_birth'] ?>">
                                                        </div> 
                                                    </div>
                                                    <div class="form-group gut ">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Agama :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pasien_agama" name="pasien_agama" type="text" required placeholder="Ketik Ruang Perawatan" readonly value="<?= $data['register']['Religion'] ?>">
                                                        </div> 
                                                    </div> 
                                                    <div class="form-group gut ">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> No HP :</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control input-sm " id="pasien_nohp" name="pasien_nohp" type="text" required placeholder="Ketik Ruang Perawatan" readonly value="<?= $data['register']['NoHP'] ?>">
                                                        </div> 
                                                    </div> 
                                                    <div class="form-group gut ">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Alamat :</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control input-sm " id="pasien_alamat" name="pasien_alamat" placeholder="Ketik Alamat" readonly><?= $data['register']['Address'] ?></textarea>
                                                        </div> 
                                                    </div> 
                                                    <div class="form-group gut ">
                                                        <label for="inputEmail3" class="col-sm-4 control-label"> Tanda Pengenal :</label>
                                                        <div class="col-sm-2">
                                                            <input class="form-control input-sm " id="pasien_jenistandapengenal" name="pasien_jenistandapengenal" type="text" required placeholder="Ketik Ruang Perawatan" readonly value="<?= $data['register']['Tipe_Idcard'] ?>">
                                                        </div> 
                                                        <div class="col-sm-6">
                                                            <input class="form-control input-sm " id="pasien_notandapengenal" name="pasien_notandapengenal" type="text" required placeholder="Ketik Ruang Perawatan" readonly value="<?= $data['register']['ID_Card_number'] ?>">
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div> 
                                </form>
                                        <div class="col-md-12 mt-25">
                                            <div class="panel panel-danger no-border">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h4><b>Pembayaran Tagihan Selama perawatan :</b></h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body">  
                                                    <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="jaminan_pribadi" name="jaminan" value="1" onclick="getIDPenjamin()"><b> Pribadi</b>
                                                            </label> 
                                                    </div>
                                                    <div class="checkbox">
                                                		<label>
                                                			<input type="radio" id="jaminan_bpjs" name="jaminan" value="3" onclick="getIDPenjamin()"> <b>Dijamin Oleh BPJS</b>
                                                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                            <b>COB:</b>
                                                            <select id="jaminan_bpjs_cob" name="jaminan_bpjs_cob" class="" style="width:20%" disabled>
                                                                <option value=""></option>
                                                                <option value="YA">YA</option>
                                                                <option value="TIDAK">TIDAK</option>
                                                            </select>
                                                            &nbsp&nbsp
                                                            <b>Kelas:</b>
                                                            <select id="jaminan_bpjs_kelas" name="jaminan_bpjs_kelas" class="" style="width:20%" disabled>
                                                                <option value=""></option>
                                                                <option value="Kelas 3">Kelas 3</option>
                                                                <option value="Kelas 2">Kelas 2</option>
                                                                <option value="Kelas 1">Kelas 1</option>
                                                            </select>
                                                		</label>
                                                        
                                                	</div>
                                                    <div class="checkbox">
                                                		<label>
                                                			<input type="radio" id="jaminan_perusahaan" name="jaminan" value="5" onclick="getIDPenjamin()"> <b>Dijamin Oleh Perusahaan</b>
                                                		</label>
                                                	</div>
                                                    <div class="checkbox">
                                                		<label>
                                                			<input type="radio" id="jaminan_asuransi" name="jaminan" value="2" onclick="getIDPenjamin()"> <b>Dijamin Oleh Asuransi</b>
                                                		</label>
                                                	</div>
                                                    <div class="form-group mt-12">
                                                        <label for="inputEmail3" class="col-sm-3"> Silahkan Masukan Nama Perusahaan/Asuransi :</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control js-example-basic-single" id="jaminan_namaPerusahaan" name="jaminan_namaPerusahaan">
                                                            </select>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-12 mt-25">
                                            <div class="panel panel-danger no-border">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h4><b>Memberi KUASA kepada Rumah Sakit untuk melepas informasi medis 
                                                            saya/pasien bila diperlukan untuk keperluan pengurusan asuransi atau keperluan lain sesuai aturan yang 
                                                            berlaku</b></h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group"> 
                                                            <!-- <select class="form-control" name="consen_kuasa"
                                                                    id="consen_kuasa">
                                                                    <option value="">-- PILIH --</option>
                                                                    <option value="MENYETUJUI">MENYETUJUI</option>
                                                                    <option value="MENOLAK">MENOLAK</option> 
                                                            </select> -->
                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                                <label for="html">
                                                                <input type="radio" id="html" name="consen_kuasa" value="MENYETUJUI" style="height:20px; width:20px"> <font size="2"><b>MENYETUJUI</b></font></label>
                                                            </div> 
                                                        </div> 
                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                            <label for="html2">
                                                            <input type="radio" id="html2" name="consen_kuasa" value="MENOLAK" style="height:20px; width:20px"> 
                                                            <font size="2"><b>MENOLAK</b></font></label>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-12 mt-25">
                                            <div class="panel panel-danger no-border">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h4><b>Petugas Rumah Sakit menginformasikan segala sesuatu yang berhubungan 
                                                        dengan kondisi kesehatan saya kepada keluarga : suami / istri / anak / saudara kandung / orangtua.</b></h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group"> 
                                                            <!-- <select class="form-control" name="consen_kondisiPasien"
                                                                    id="consen_kondisiPasien">
                                                                    <option value="">-- PILIH --</option>
                                                                    <option value="MENGIZINKAN">MENGIZINKAN</option>
                                                                    <option value="TIDAK MENGIZINKAN">TIDAK MENGIZINKAN</option> 
                                                            </select> -->
                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                                <label for="html3">
                                                                <input type="radio" id="html3" name="consen_kondisiPasien" value="MENGIZINKAN" style="height:20px; width:20px"> <font size="2"><b>MENGIZINKAN</b></font></label>
                                                            </div> 
                                                        </div> 
                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                            <label for="html4">
                                                            <input type="radio" id="html4" name="consen_kondisiPasien" value="TIDAK MENGIZINKAN" style="height:20px; width:20px"> 
                                                            <font size="2"><b>TIDAK MENGIZINKAN</b></font></label>
                                                            </div> 
                                                        </div> 

                                                    </div>  
                                                    <form id="user_formdtl">
                                                    <div class="col-sm-12">
                                                    <div class="form-group gut ">
                                                    <a class="btn btn-primary" title="Tambah Baris" id="add_row" name="add_row" style="margin-top: 30px;">
            <i class="fa fa-plus-square"></i> Add</a></div>
            <div class="table-responsive demo-table">
                                           <table class="table table-striped table-hover cell-border" id="list_payment">
                                           <thead>
                                             <tr>
                                               <th><font size="1">Suami</font></th>
                                               <th><font size="1">Istri</font></th>
                                               <th><font size="1">Anak</font></th>
                                               <th><font size="1">Saudara Kandung</font></th>
                                               <th><font size="1">Orangtua</font></th>
                                               <th><font size="1">Aksi</font></th>
                                             </tr>
                                           </thead>
                                                  <tbody id="user_data">
                                           </tbody>
                                           <input type="hidden" id="grantotalOrder">
                                                  <input type="hidden" name="totalrow" id="totalrow" class="form-control totalrow"   />
                                            <!-- <thead>
                                             <tr>
                                               <th colspan="5"><font size="1"></font></th>
                                              
                                               <th><font size="1"><div id="grantotalOrder"></div></font>
                                                  <input type="hidden" name="totalrow" id="totalrow" class="form-control totalrow"   />
                                                

                                               </th>
                                             </tr>
                                           </thead> -->
                                         </table>
                                       </div>
                  </div>
</form>


                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-12 mt-25">
                                            <div class="panel panel-danger no-border">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h4><b>Rumah Sakit memberikan akses bagi keluarga dan orang lain yang akan 
                                                        mengunjungi / menemui saya. ( sebutkan nama / profesi bila ada permintaan khusus ) :</b></h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group"> 
                                                        <!-- <div class="col-sm-4">
                                                            <select class="form-control" name="consen_aksesKeluarga"
                                                                    id="consen_aksesKeluarga">
                                                                    <option value="">-- PILIH --</option>
                                                                    <option value="MENGIZINKAN">MENGIZINKAN</option>
                                                                    <option value="TIDAK MENGIZINKAN">TIDAK MENGIZINKAN</option> 
                                                            </select>
                                                        </div>  -->
                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                                <label for="html5">
                                                                <input type="radio" id="html5" name="consen_aksesKeluarga" value="MENGIZINKAN" style="height:20px; width:20px"> <font size="2"><b>MENGIZINKAN</b></font></label>
                                                            </div> 
                                                        </div> 
                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                            <label for="html6">
                                                            <input type="radio" id="html6" name="consen_aksesKeluarga" value="TIDAK MENGIZINKAN" style="height:20px; width:20px"> 
                                                            <font size="2"><b>TIDAK MENGIZINKAN</b></font></label>
                                                            </div> 
                                                        </div> 

                                                    </div> 
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-25">
                                            <div class="panel panel-danger no-border">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h4><b>Privasi Khusus. Sebutkan bila ada permintaan Privasi Khusus :</b></h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group"> 
                                                        <!-- <div class="col-sm-4">
                                                            <select class="form-control" name="consen_privasiKhusus"
                                                                    id="consen_privasiKhusus">
                                                                    <option value="">-- PILIH --</option>
                                                                    <option value="MENGINGINKAN">MENGINGINKAN</option>
                                                                    <option value="TIDAK MENGINGINKAN">TIDAK MENGINGINKAN</option> 
                                                            </select>
                                                        </div>  -->
                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                                <label for="html7">
                                                                <input type="radio" id="html7" name="consen_privasiKhusus" value="MENGINGINKAN" style="height:20px; width:20px"> <font size="2"><b>MENGINGINKAN</b></font></label>
                                                            </div> 
                                                        </div> 
                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                            <label for="html8">
                                                            <input type="radio" id="html8" name="consen_privasiKhusus" value="TIDAK MENGINGINKAN" style="height:20px; width:20px"> 
                                                            <font size="2"><b>TIDAK MENGINGINKAN</b></font></label>
                                                            </div> 
                                                        </div> 

                                                        <div class="col-sm-8">
                                                            <textarea class="form-control input-sm " id="consen_privasiKhusus_add" name="consen_privasiKhusus_add" placeholder="Sebutkan Privacy Anda."></textarea>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-md-12 mt-25">
                                            <div class="panel panel-danger no-border">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <h4><b>NILAI-NILAI KEPERCAYAAN, Sebutkan : </b></h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group"> 
                                                        <!-- <div class="col-sm-4">
                                                            <select class="form-control" name="consen_nilaikepercayaan"
                                                                    id="consen_nilaikepercayaan">
                                                                    <option value="">-- PILIH --</option>
                                                                    <option value="ADA">ADA</option>
                                                                    <option value="TIDAK">TIDAK</option> 
                                                            </select>
                                                        </div>  -->

                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                                <label for="html9">
                                                                <input type="radio" id="html9" name="consen_nilaikepercayaan" value="ADA" style="height:20px; width:20px"> <font size="2"><b>ADA</b></font></label>
                                                            </div> 
                                                        </div> 
                                                        <div class="col-sm-2">
                                                            <div class="checkbox">
                                                            <label for="html10">
                                                            <input type="radio" id="html10" name="consen_nilaikepercayaan" value="TIDAK" style="height:20px; width:20px"> 
                                                            <font size="2"><b>TIDAK</b></font></label>
                                                            </div> 
                                                        </div> 


                                                        <div class="col-sm-8">
                                                            <textarea class="form-control input-sm " id="consen_nilaikepercayaan_add" name="consen_nilaikepercayaan_add" placeholder="Ketik Nilai Kepercayaan anda"></textarea>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div> 

                                        
                                        
                                        
                                        <!-- <div class="panel-body">
                                            <embed src= "https://rsuyarsibucket.s3.ap-southeast-1.amazonaws.com/digitalfiles/generalconsent/43e27fd7c02fc7ba2992b1af5520681801c620115a-20230925162105" width= "900" height= "600">
                                                    <div class="form-group"> 
                                                        <div class="col-sm-8">
                                                        <button type="button" class="btn btn-warning" >
                                                            Selanjutnya
                                                        </button>
                                                        </div> 
                                                    </div> 
                                                </div> -->
                                        
                                        <div class="col-md-12">
                                        <h5 class="underline mt-30">Syarat dan Ketentuan <small> </small></h5>
                                        <div class="panel-group acc-panels" id="accordion5" role="tablist" aria-multiselectable="true">
                                        	<div class="panel panel-primary no-border">
                                        		<div class="panel-heading" role="tab" id="heading9One">
                                        			<h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" id="btnCollapse" data-parent="#accordion5" href="#collapse9One" aria-expanded="false" aria-controls="collapse9One" onclick="passData();">
                                                          <i class="fa fa-plus icon-plus"></i><b> Dengan ini saya menyatakan / I Declare (Review Document) :</b>
                                                        </a>
                                                    </h4>
                                        		</div>
                                                
                                        		<div id="collapse9One" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9One">
                                                    <div class="panel-body">
                                                    <u>Saya yang bertanda tangan di bawah ini adalah pasien / wali pasien </u><br><b><i>This is to certify as a patient trusty</b></i>
            <table width="100%" cellspacing="0" cellpadding="2" border="0" >
      <tbody> 

          <tr>
            <td align="left" width="40%"><font size="2"><u>Nama</u><br><b><i>Name</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="NamaPenanggungJawab_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>Gender</u><br><b><i>Sex</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="JenisKelamin_Inisial_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>Umur</u><br><b><i>Age</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="Tahun_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>Alamat</u><br><b><i>Address</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="AlamatPenanggungJawab_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>No. Telp</u><br><b><i>Telephone</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="NoHandphone_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>Hubungan dengan pasien</u><br><b><i>Relationship to the patient</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="NamaJenisPenanngungJawab_tmp"></label></font></td>
          </tr>

      </tbody>
    </table>

    <u>Bahwa karena penyakit yang diderita pasien, dengan ini menyatakan sesungguhnya telah memberikan PERSETUJUAN untuk dilakukan perawatan di Unit Perawatan / Pelayanan rawat jalan **)</u><br><b><i>About the illness that the patient has been suffered, I declare that I give consent for patient’s treatment in the service unit.</b></i>
    <br>
    <u>Terhadap Pasien :</u><br><b><i>For the Patient</b></i>

    <table width="100%" cellspacing="0" cellpadding="2" border="0" >
      <tbody> 

          <tr>
            <td align="left" width="40%"><font size="2"><u>Nama</u><br><b><i>Name</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="NamaPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>Gender</u><br><b><i>Sex</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="JenisKelaminPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>Tgl Lahir</u><br><b><i>Date of Birth</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="TangalLahirPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>No RM</u><br><b><i>MR Number</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="NoRMPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>Agama</u><br><b><i>Religion</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="AgamaPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>Alamat</u><br><b><i>Address</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="AlamatPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>No. Telp</u><br><b><i>Telephone</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="NoHPPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>No. Tanda Pengenal</u><br><b><i>Identity number</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="JenisPengenalPasien_tmp"></label> <label id="NIKPasien_tmp"></label></font></td>
          </tr>

          <tr>
            <td align="left" width="40%"><font size="2"><u>Pembayaran tagihan selama perawatan</u><br><b><i>Bill payment during treatment</b></i></td>
            <td align="left" width="60%"><font size="4"><label id="jaminan_namaPerusahaan_tmp"></label></font></td>
          </tr>

      </tbody>
    </table>

                                                    </div>
                                        			<div class="doc_preview">
                                                            <h6 style="margin-top:0px;margin-left:1em;margin-right:1em;">1. Saya mengetahui bahwa saya memiliki kondisi yang membutuhkan perawatan medis, saya mengizinkan dokter dan profesional kesehatan lainnya untuk melakukan prosedur diagnostik dan untuk memberikan pengobatan medis seperti yang diperlukan dalam penilaian profesional mereka. Prosedur diagnostik dan perawatan medis <u>termasuk terapi tidak terbatas</u> pada electrocardiograms, x-rays, tes darah terapi fisik, dan pemberian obat,pemasangan NGT, Kateterd dll. Tindakan yang berisiko tinggi akan saya berikan persetujuan secara tertulis diluar persetujuan ini. <b><i>( I know that I have conditions that require medical care, I allow doctors and other health professionals to perform diagnostic procedures and to provide medical treatment as required in their professional assessment. medical diagnostic and treatment procedures including, not limited to, electrocardiograms, x-rays, physical therapy therapies, and drug delivery. A high-risk action will grant written consent outside this general agreement ).</i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">2. Sudah mendapat informasi dan membaca peraturan / tata tertib dan persyaratan kelengkapan administrasi pasien yang akan di rawat jalan RS Yarsi, juga hak dan kewajiban sebagai pasien dan sudah memahaminya serta bersedia mematuhi semua peraturan. <b><i>( Have been informed and read the rules / rules and requirements of administrative proficiency of patients who will be hospitalized in Rs Yrasi, as well as the rights and obligations as a patient and have understood it and are willing to comply with all regulations ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">3. <span id="MemberiKuasa_tmp"></span> memberi KUASA kepada Rumah Sakit untuk melepas informasi medis saya/pasien bila diperlukan untuk keperluan pengurusan asuransi atau keperluan lain sesuai aturan yang berlaku. <b><i>( <span id="MemberiKuasa_tmpeng"></span> authorizing the hospital to release my medical / patient information when necessary for insurance or other purposes as required ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">4. <span id="KondisiPasien_tmp"></span> petugas Rumah Sakit menginformasikan segala sesuatu yang berhubungan dengan kondisi kesehatan saya kepada keluarga : suami / istri / anak / saudara kandung / orangtua *). <b><i>( <span id="KondisiPasien_tmpeng"></span> hospital officials inform everything related to my health condition to the family : husband / wife / child / sibling / parent ).</b></i></h6>
                                                            <table class="table table-striped table-hover cell-border" id="list_payment2">
                                           <thead>
                                             <tr>
                                               <th><font size="1">Suami</font></th>
                                               <th><font size="1">Istri</font></th>
                                               <th><font size="1">Anak</font></th>
                                               <th><font size="1">Saudara Kandung</font></th>
                                               <th><font size="1">Orangtua</font></th>
                                               <th><font size="1"></font></th>
                                             </tr>
                                           </thead>
                                                  <tbody id="user_data2">
                                           </tbody>
                                         </table>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">5. Bersedia membayar penuh biaya tindakan yang tidak ditanggung oleh asuransi / perusahaan atau biaya non medis seperti: telephone / fax, supplemen, obat herbal, minyak kayu putih, makanan extra, tissue, underpad dll. ( khusus untuk peserta Asuransi / pasien Perusahaan yang bekerja sama dengan RS Yarsi ). <b><i>( Willing to pay the full cost of the action not covered by the insurance / company or non-medical costs such as telephone, fax, supplement, herbal medicine, eucalyptus oil, extra food, tissue, underpad and others (especially for insurance participants / with Rs Yarsi )</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">6. Bersedia menerima segala sanksi dan konsekuensi yang terjadi apabila tidak mematuhi peraturan yang berlaku di RS Yarsi yang sudah saya setujui dan tanda tangani. <b><i>( Willing to accept any sanctions that occur if not obey the rules that apply in rs yarsi that I have agreed and sign ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">7. Bersedia sebagai contact person terhadap hal-hal yang berhubungan dengan pasien. <b><i>( Willing as a person contact to the things related to the patient ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">8. Dapat memahami tindakan kedokteran pada keadaan gawat darurat dalam rangka menyelamatkan jiwa pasien, tanpa didahului permintaan persetujuan sebelumnya. <b><i>( Can understand the medical action in emergency situations in order to save the soul of the patient, without prior request for prior approval ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">9. Saya bertanggung jawab atas kehilangan, kerusakan dan pencurian terhadap barang berharga yang saya bawa selama menjalankan perawatan. <b><i>( I am responsible for the loss, damage and theft of the valuables I carry during the course of the maintenance ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">10. Telah menerima informasi dan menyetujui tata cara mengajukan dan mengatasi keluhan terkait pelayanan medis yang dilakukan terhadap diri saya. <b><i>( Have received information and approved the procedure for filing and resolving complaints related to medical services performed on self ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">10.1 PELAYANAN KESEHATAN : Pelayanan Kesehatan di rumah sakit atas indikasi medis, meliputi preventif, promotive, Kuratif, dan rehabilitatief ( a.i. pemeriksaan umum, pemeriksaan rontgen / radiologi, pemeriksaan Laboratorium, pengobatan rutin, perawatan, retapi bermain pada anak, prosedur pemasangan infus, Kateter, nasogatric tube / NGT, suntikan dan evaluasi ). <b><i>( Hospital health services are performed on medical indications, including preventive, promotive, curative and rehabilitative ( i.e. general examinations, X-ray / radiology examinations, laboratory test, routine traetment, treatment, playground therapy in children, infusion procedure, catheter, nasogastric tube / NGT, injections and evaluation ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">10.2 <b>PELAYANAN SYARIAH UNTUK PASIEN MUSLIM / MUSLIMAH</b> <br> Dengan ini saya menyetujui pelayanan syariah yang diberikan oleh petugas rumah sakit meliputi :</h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">a. Penjagaan aurat dengan pemakaian hijab, penutup dada ibu menyusui, menutup tirai pada saat tindakan / pemeriksaan.</h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">b. Penjagaan thoharoh dengan pendamping wudhu atau tayamum.</h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">c. Penjagaan ibadah dengan bersedia diingatkan untuk melaksanakan sholat pada waktu sholat dan bersedia didampingi petugas kerohanian bila memerlukan.</h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">d. Penjagaan khalwat dan ihtilat dengan bersedia selama perawatan ditunggu oleh keluarga ( mahramnya )</h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">e. Bersedia mengikuti kebijakan halal gizi dengan tidak menggunakan peralatan makan untuk makanan selain yang disajikan oleh rumah sakit.</h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">g. Pelayanan sakaratul maut, bersedia untuk pendamping sakaratul maut ( talqin )</h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">11. INFORMASI DAN RAHASIA KESEHATAN PASIEN :</h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">11.1 Memberi kuasa kepada setiap tenaga kesehatan yang merawat pasien untuk memeriksa dan atau memberitahukan informasi kesehatan pasien kepada pemberi pelayanan kesehatan lain yang turut merawat selama di Rumah Sakit. <b><i>( Authorize each health worker who treats the patient to check and / or notify the patient’s health information to other health care providers who take care of while in the hospital ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">11.2 Pelepasan informasi kesehatan pasien dan resume medis kepada perusahaan penjamin biaya / perusahaan / asuransi/verifikator asuransi keperluan klaim asuransi hanya dapat dilakukan apabila perusahaan penjamin biaya/perusahaan asuransi / verifikator asuransi telah bekerjasama dengan Rumah Sakit. Dalam hal perusahaan penjamin biaya/perusahaan asuransi / verifikator asuransi tidak bekerjasama dengan Rumah Sakit maka informasi medis dn resume medis dapat diberikan berdasarkan permohonan tertulis / surat kuasa dari pasien / keluarga / wali pasien. <b><i>( Release of patient  health information and medical resume to the guarantor company the cost/insurance company / insurance verifier for insurance claim needs can only be made if the cost guarantee company/insurance company / insurance verifier has cooperated with the hospital. In the event that the guarantor company / insurance company / insurance verifier does not cooperate with the Hospital, medical information and medical resume can be provided based on a written application / power of attoney form the patient / family / guardian of the patient ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">12. <span id="MemberiIzin_tmp"></span> Rumah Sakit memberikan akses bagi keluarga dan orang lain yang akan mengunjungi / menemui saya. ( sebutkan nama / profesi bila ada permintaan khusus : ................................................................................... <br><b><i>( <span id="MemberiIzin_tmpeng"></span>. hospital giving access to families and others who will visit / meet me. Please specify the name / profession if ther is a special request )</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">13. <span id="PrivasiKhusus_tmp"></span> Privasi Khusus. Sebutkan bila ada permintaan Privasi Khusus : <br><b><i>( <span id="PrivasiKhusus_tmpeng"></span> Special Privacy. Please specify if there is a special privacy reguest ) <span id="PrivasiKhususText_tmp"></span></b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">14. KELUHAN : Saran / Keluhan terkait pelayanan Rumah Sakit tetap mengedepankan musyawarah dan mencari solusi. <b><i>( Suggestions / Complaints realted to Hospital services still prioritize deliberation and find solutions )</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">15. RUMAH SAKIT SEBAGAI RUMAH SAKIT PENDIDIKAN : Rumah sakit merupakan rumah sakit pendidikan dan menjadi tempat praktik klinik bagi mahasiswa kedokteran dan profesi lain, oleh karena itu mahasiswa terlibat dalam proses pemberian pelayanan kesehatan kepada pasien. <b><i>( The Hospital is an Education hospital and is aclinical pratice place for medical students and other professions, therefore students are involved in the process of providing health services to patients ).</b></i></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;">16. <b>NILAI-NILAI KEPERCAYAAN <span id="Kepercayaan_tmp"></span>, Sebutkan : <span id="KepercayaanText_tmp"></span></b></h6>
                                                    <br>
                                        			</div>
                                        		</div>
                                        	</div> 
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                    <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkboxSyarat" onclick="checkTrue()">
                                                Saya Menyetujui Syarat & Ketentuan yang Berlaku di Rumah Sakit YARSI.
                                            </div>
                                    </div>
                                    <div class="col-md-12">
                                    <div class="form-check">
                                               
                                        <h5 class="underline mt-40">Tanda Tangan Digital</h5>
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        
                                        <div class="panel panel-primary no-border">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>PIHAK 1 ( Rumah Sakit )</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                    <div class="rumahsakit">
                                                        <div class="sig">
                                                            <div class="typed"></div>
                                                            <!-- <canvas class="" id="ttdrumahsakit" width="300"
                                                                height="100"></canvas> -->
                                                                <embed src="" width="100px" height="100px" id="filettd" />
                                                        </div>
                                                    </div>
                                                    <label for="inputPassword4">Nama Petugas</label>
                                      
                                        <div class="col-md-5"> 
                                                    <input type="hidden" class="form-control" name="idpetugas_ext" id="idpetugas_ext" readonly>
                                                    <input type="text" class="form-control" name="namapetugas_ext" id="namapetugas_ext" readonly>
                                        </div>
                                        <div class="col-md-2"> 
                                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#Modal_Approve" id="btnttd1" disabled>
                                                        Input PIN 
                                                    </button>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="panel panel-success no-border">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>PIHAK 2 ( Pasien / Keluarga Pasien )</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                    <div class="copysignature" id="pasienttd">
                                                        <div class="sig">
                                                            <div class="typed"></div>
                                                            <canvas class="" id="gbrttdsaksipasien" width="300"
                                                                height="100"></canvas>
                                                        </div>
                                                    </div>
                                                    <label for="inputPassword4" id="ttd_namapasien">Nama Pasien</label>
                                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#saksipasien" id="btnttd2" disabled>
                                                        Input Tanda Tangan
                                                    </button>
                                            </div>
                                        </div>   
                                    </div>
                                                <input type="hidden" name="saksi_rumah_sakit" id="saksi_rumah_sakit">
                                                <input type="hidden" name="saksi_pasien" id="saksi_pasien">
                                                <!-- <div class="col-md-12 mt-10"> 
                                                    <P>Saya Menyetujui Syarat & Ketentuan yang Berlaku di Rumah Saki YARSI.</p> 
                                                </div> -->
                                  <div class="panel-body">
                                  <h6>Dokumen ini dinyatakan sah setelah ditandatangani.<br>Dokumen akan dikirmkan ke alamat email dan no whatsapp berikut.</h6>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-1 control-label"><i class="fa fa-whatsapp" style="font-size:18px"></i> No. HP</label>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" type="text" id="nohp_send" name="nohp_send"  value="<?= $data['register']['NoHP'] ?>" placeholder="contoh: 081334233123" inputmode="numeric">
                                        </div>
                                    </div>
                                    <div class="form-group gut">
                                        <label for="inputEmail3" class="col-sm-1 control-label"><i class="fa fa-envelope" style="font-size:18px"></i> Email</label>
                                        <div class="col-sm-3">
                                            <input class="form-control input-sm" type="text" id="email_send" name="email_send"  value="<?= $data['register']['Email'] ?>" placeholder="contoh: namapasien@gmail.com">
                                            <input class="form-control input-sm" type="hidden" id="email_send_backup" name="email_send_backup"  value="<?= $data['register']['Email'] ?>" >
                                        </div>
                                        <div class="form-check">
                                                <label>
                                                <input class="form-check-input" type="checkbox" id="ceklis_noemailx" onclick="ceklis_noemail()">
                                                Ceklis jika tidak punya email</label>
                                            </div>
                                    </div>
                                   
                                    <!-- <h6>jika ada perubahan data untuk kirim e-dokumen ini (No. HP atau Email) akan diperbarui ke data sosial pasien dan semua yang telah diinput akan tersimpan di database Rumah Sakit Yarsi.</h6> -->
                                    <h6>Semua yang telah diinput akan tersimpan di database Rumah Sakit Yarsi.</h6>
                                </div>
                                                    <button type="button"
                                                        name="tandatangan" id="tandatangan" class="btn btn-primary" disabled><i
                                                            class="fa fa-save"></i>
                                                        SIMPAN DAN KIRIM
                                                    </button>  
                                        <!-- /.section -->
                            </div>
                        </div>
                    </div>
            </div>
        </div>
                                        </div> 
    </section>
    <!-- /.section -->
</div>
<div class="modal fade" id="saksipasien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saksi Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="signature-area" id="ttdsaksipasien">
                    <!-- <h2 class="title-area">Put signature,</h2> -->
                    <!-- <label>nama</label> -->
                    <!-- <input type="text" name="nama" id="nama"> -->
                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-save" id="btn-save">Save</button>
                <button class="btn-clear" id="clearttdrumahsakit">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="saksirumahsakit" tabindex="-1" role="dialog" aria-labelledby="saksirumahsakit"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saksi Rumah sakit</h5>
                <button id="ttdsaksirumahsakit" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Silahkan tanda tangan di dalam kotak
                <div class="signature-area">
                    <!-- <h2 class="title-area">Put signature,</h2> -->
                    <!-- <label>nama</label> -->
                    <!-- <input type="text" name="nama" id="nama"> -->
                    <div class="sig sigWrapper" style="height:auto;">
                        <div class="typed"></div>
                        <canvas class="sign-pad" id="canvasttdsaksi" width="300" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="ttdsaksirumahsakit btn-save">Save</button>
                <button class="btn-clear">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSend" tabindex="-1" role="dialog" aria-labelledby="modalrumahsakit"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kirim Document e-Akad Ijaroh</h5>
            </div>
            <div class="modal-body">
            <div class="row">
                    <div class="col-sm-6">
                        <input type="hidden" id="param_id" name="param_id"></>
                        <p class="text-center"><strong>Send WhatsApp</strong></p><br>
                        <form id="TheForm" method="post" action="halaman/Print/print_bukti_reg.php" target="TheWindow">
                            <input type="hidden" name="cetaknoregis" id="cetaknoregis" />
                        </form>
                        <img src="<?= BASEURL; ?>/images/sosmed/whatsapp.Png" id="whatsapp" class="img-circle" alt="Random Name" width="150" height="150">
                    </div>
                    <div class="col-sm-6">
                        <p class="text-center"><strong>Send Email </strong></p><br>
                        <img src="<?= BASEURL; ?>/images/sosmed/email.png" id="sendmail" class="img-circle person" alt="Random Name" width="150" height="150">
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button class="ttdsaksirumahsakit btn-save">Save</button>
                <button class="btn-clear">Clear</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHistory" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Riwayat Dokumen</h5>
            </div>
            <div class="modal-body">
            <div class="demo-table" width="100%" id="tbl_rekap" style="margin-top: 10px;overflow-x:auto;">
            <table id="tbl_arsip" class="table table-striped table-hover cell-border">
                                                  <thead>
                                                      <tr>
                                                           <th align='center'> ID</th>
                                                           <th align='center'> TglCreate</th>
                                                           <th align='center'> NoRegistrasi</th>
                                                           <th align='center'> NoEpisode</th>
                                                           <th align='center'> NoMR</th>
                                                           <th align='center'> NamaPasien</th>
                                                           <th align='center'> AwsUrlDocuments</th>
                                                           <th align='center'> uuid4</th>
                                                           <th align='center'> NamaWaliPasien</th>
                                                           <th align='center'> NIK</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
            </div>
            </div>

            <div class="modal-footer">
                    <button type="button" class="btn btn-gray" data-dismiss="modal"><i class="fa fa-times"></i>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve ------------------------------------------------>
<div class="modal fade" id="Modal_Approve" tabindex="-1" role="dialog">

<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Saksi Rumah sakit</h4>
        </div>
    <br>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-2 control-label">No PIN:</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="nopin" id="nopin" placeholder="Isi No PIN Anda dan Tekan Enter" inputmode="numeric">
                    </div>
                    <div class="col-sm-1">
                    <button type="button" class="btn btn-sm btn-default" id='btnpinttd' onclick="goGetApproveName()">Enter</button>
                    </div>
                   
                </div>

                <div class="form-group gut">

                    <label for="inputEmail3" class="col-sm-2 control-label">Nama:</label>   <div class="col-sm-2">
                        <input type="text" class="form-control" name="nopin_ext" id="nopin_ext" readonly>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="nama_ext" id="nama_ext" readonly>
                    </div>
                </div>

                <div class="form-group gut">  
                <label for="inputEmail3" class="col-sm-3 control-label">Digital Sign:</label>
                <div class="col-sm-7">
                <embed src="" width="100px" height="100px" id="file" />

                </div>
                </div>
                    
            </form>
        </div>
        <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary btn-sm " id="btnSearching" name="btnSearching" onclick="goSaveApprove()"> Simpan</button> -->
            <a data-dismiss="modal" class="btn btn-default" href="#" id="CloseMe" name="CloseMe">Close</a>
        </div>

        <!--#END Modal Approve--------------------------------------------->
    </div>
</div>
<!-- /.col-md-12 -->
</div>


<script src="<?= BASEURL; ?>/js/jquery/jquery-2.2.4.min.js"></script>
<script>
let iduser = ` <?= $data['session']->username ?>`
let namauser = ` <?= $data['session']->name ?>`
</script>
<script>
$(document).ready(function() {
    $(".btn-clear").click(function(e) {
        $(".signature-area").signaturePad().clearCanvas();
    });
    $("#clearttdrumahsakit").click(function(e) {
        $("#ttdsaksipasien").signaturePad().clearCanvas();
        console.log('clear')
    });
    $(".signature-area").signaturePad({
        penColour: '#000000',
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 90,
        lineWidth: 0,
        validateFields: true,
    })

});
</script>
<script src="<?= BASEURL; ?>/js/App/SPR/spr.js"></script>
<script src="<?= BASEURL; ?>/js/App/SPR/GeneralConsen.js"></script>