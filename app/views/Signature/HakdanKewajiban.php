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
                                <h5 class="underline mt-30">e-HAK DAN KEWAJIBAN PASIEN &nbsp&nbsp&nbsp
                                <!-- <button type="button"
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
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> Nama Wali / Pasien</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="namawali"  name="namawali" >
                                    </div>
                                </div>
                                <div class="form-group gut">
                                    <label for="inputEmail3" class="col-sm-2 control-label"> NIK</label>
                                    <div class="col-sm-4">
                                        <input class="form-control input-sm" type="text" id="nik"  name="nik" >
                                    </div>
                                </div>
                                    <div class="col-md-12">
                                        <h5 class="underline mt-30">HAK & KEWAJIBAN PASIEN <small> </small></h5>
                                        <div class="panel-group acc-panels" id="accordion5" role="tablist" aria-multiselectable="true">
                                        	<div class="panel panel-primary no-border">
                                        		<div class="panel-heading" role="tab" id="heading9One">
                                        			<h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion5" href="#collapse9One" aria-expanded="false" aria-controls="collapse9One" onclick="passData();">
                                                          <i class="fa fa-plus icon-plus"></i> Dengan ini saya menyatakan / I Declare (Review Document)
                                                        </a>
                                                    </h4>
                                        		</div>
                                        		<div id="collapse9One" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9One">
                                        			<div class="doc_preview">
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;"><b>HAK & KEWAJIBAN PASIEN</b></h6>
                                                            <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;"><b>HAK PASIEN ( UU Hak & Tanggung Jawab Pasal 32 UU No.44 / 2009 )</b></h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">1. &nbsp;Hak memperoleh informasi mengenai tata tertib dan peraturan yang berlaku di Rumah sakit.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">2. &nbsp;Hak memperoleh informasi tentang hak dan kewajiban pasien.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">3. &nbsp;Hak memperoleh layanan yang manusiawi, adill, jujur, dan tanpa diskriminasi.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">4. &nbsp;Hak memperoleh layanan kesehatan yang bermutu sesuai dengan standar profesi dan standar prosedur operasional.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">5. &nbsp;Hak memperoleh layanan yang efektif dan efisien sehingga pasien terhindar dari kerugian fisik dan materi.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">6. &nbsp;Hak mengajukan pengaduan atas kualitas pelayanan yang didapatkan.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">7. &nbsp;Hak memilih dokter dan kelas perawatan sesuai dengan keinginanannya dan peraturan yang berlaku di Rumah sakit</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">8. &nbsp;Hak meminta konsultasi tentang penyakit yang dideritanya kepada dokter lain yang mempunyai Surat Izin Praktik ( SIP ) baik di dalam maupun di luar Rumah Sakit.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">9. &nbsp;Hak mendapatkan privacy dan kerahasiaan penyakit yang diderita termasuk data-data medisnya.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">10. &nbsp;Hak mendapatkan informasi yang meliputi diagnosis dan tata cara tindakan medis, tujuan tindakan medis, alternative tindakan, resiko dan komplikasi yang mungkin terjadi dan prognosis terhadap tindakan yang dilakukan serta perkiran biaya pengobatan.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">11. &nbsp;Hak memberikan persetujuan atau menolak atas tindakan yang akan dilakukan oleh tenaga kesehatan terhadap penyakit yang dideritanya.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">12. &nbsp;Hak didampingi keluarganya dalam keadaan kritis.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">13. &nbsp;Hak beribadah menurut agama dan kepercayaannya selama tidak menggangu ketertiban, ketenangan umum / pasien lainnya.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">14. &nbsp;Hak atas keamanan dan keselamatan selama dalam perwatan di Rumah.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">15. &nbsp;Hak untuk mengajukan usul, saran, perbaikan atas pelayanan Rumah Sakit terhadap dirinya.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">16. &nbsp;Hak menolak pelayanan bimbingan rohani yang tidak sesuai dengan agama dan kepercayaan yang dianutnya.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">17. &nbsp;Hak menggugat dan/atau menuntut Rumah Sakit apabila Rumah Sakit diduga memberikan pelayanan yang tidak sesuai dengan standar baik secara perdata ataupun pidana.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">18. &nbsp;Hak mengeluhkan pelayanan Rumah Sakit yang tidak sesuai dengan standar pelayanan melalui media cetak dan elektronik sesuai dengan ketentuan peraturan perundang-undangan.</h6>
                                                    <BR>

                                                    <h6 style="margin-top:0px;margin-left:1em; margin-right:1em;"><b>KEWAJIBAN PASIEN ( Pasal 26 Kebijakan Pemenkes 4 Tahun 2018 )</b></h6>

                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">1. &nbsp;Mematuhi peraturan yang berlaku di Rumah Sakit.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">2. &nbsp;Menggunakan fasilitas Rumah Sakit secara bertanggung jawab.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">3. &nbsp;Menghormati hak Pasien lain, pengunjung dan hak Tenaga Kesehatan serta petugaslainnya yang bekerja di Rumah sakit.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">4. &nbsp;Memberikan informasi yang jujur, lengkap dan akurat sesuai dengan kemampuan dan pengetahuannya tentang masalah kesehatannya.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">5. &nbsp;Memberikan informasi mengenai kemampuan finansial dan jaminan kesehatan yang dimilikinya.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">6. &nbsp;Mematuhi rencana terapi yang direkomendasikan oleh Tenaga Kesehatan di Rumah Sakit dan disetujui oleh pasien yang bersangkutan setelah mendapatkan penjelasan sesuai dengan ketentuan peratur perundangan-undangan.</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">7. &nbsp;Menerima segala konsekuensi atas keputusan pribadinya untuk menolak rencana terapi yang direkomendasikan oleh Tenaga Kesehatan dan/atau tidak mematuhi petunjuk yang diberikan oleh Tenaga Kesehatan untuk penyembuhan penyakt atau masalah kkesehatannya</h6>
                                                    <h6 style="margin-top:0px;margin-left:2em; margin-right:1em;">8. &nbsp;Memberikan imbalan jasa atas pelayanan yang diterima.</h6>
                                                    
                                                    
                                                    <br>
                                        			</div>
                                        		</div>
                                        	</div> 
                                        </div>
                                    </div>
                                    <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkboxSyarat" onclick="checkTrue()">
                                                Saya Menyetujui Syarat & Ketentuan yang Berlaku di Rumah Sakit YARSI.
                                            </div>
                                    <h5 class="underline mt-40">Tanda Tangan Digital</h5>
                                    <div class="col-md-6">
                                        
                                        <div class="panel panel-primary no-border">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Petugas</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="rumahsakit">
                                                <div class="sig">
                                                    <div class="typed"></div>
                                                    <!-- <canvas class="" id="ttdrumahsakit" width="300" height="100"></canvas> -->
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
                                                    <h5>Wali / Nama Pasien</h5>
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
                                                <label for="inputPassword4" id="namajelas">Nama Jelas</label>
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
                                    <div class="col-md-12 mt-10"> 
                                    <button type="button"
                                                        name="tandatangan" id="tandatangan" class="btn btn-primary" disabled><i
                                                            class="fa fa-save"></i>
                                                        SIMPAN DAN KIRIM
                                                    </button>  
                                        <!-- <a onclick="MyBack()" class="btn btn-warning waves-effect"
                                            id="btnBack" name="btnBack"><span class="glyphicon glyphicon glyphicon-home"
                                                aria-hidden="true"></span>
                                            Kembali</a> -->
                                    </div> 
                            </form>
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
<div class="modal fade" id="saksipasien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Wali / Nama Pasien</h5>
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
                <h5 class="modal-title" id="exampleModalLabel">Petugas</h5>
            </div>
            <div class="modal-body">
                Silahkan tanda tangan di dalam kotak
                <div class="signature-area"> 
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
<script src="<?= BASEURL; ?>/js/App/SPR/HakdanKewajiban.js"></script>