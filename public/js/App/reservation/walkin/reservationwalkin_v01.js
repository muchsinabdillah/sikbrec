$(document).ready(function () {   
    onLoadFunctionAll();
   $('#Medical_Provinsi').change(function () {
       //Some code
       $("#Medrec_kabupaten").empty();
       var newRow = '<option value="">-- Pilih Kabupaten --</option';
       $("#Medrec_kabupaten").append(newRow);
    $("#Medrec_kabupaten").select2();

       $("#Medrec_Kecamatan").empty();
       var newRow = '<option value="">-- Pilih Kecamatan --</option';
       $("#Medrec_Kecamatan").append(newRow);
    $("#Medrec_Kecamatan").select2();

       $("#Medrec_Kelurahan").empty();
       var newRow = '<option value="">-- Pilih Kelurahan --</option';
       $("#Medrec_Kelurahan").append(newRow);
       $("#Medrec_Kelurahan").select2();
       var Medrec_NoMR = $("#Medrec_NoMR").val();
       //console.log("datamr",Medrec_NoMR)
       //  if (Medrec_NoMR == ""){ 
           //showGetKabupaten();
       // }else{
           var xdi = document.getElementById("Medical_Provinsi").value;
           showGetKabupaten(xdi);
       //}
   });

   $('#Medrec_kabupaten').change(function () {
    var xdi = document.getElementById("Medrec_kabupaten").value;
    showGetKecamatan(xdi);
});
$('#Medrec_Kecamatan').change(function () {
    var xdi = document.getElementById("Medrec_Kecamatan").value;
    showGetKelurahan(xdi);
});
$('#Medrec_Kelurahan').change(function () {
    var xdi = document.getElementById("Medrec_Kelurahan").value;
    showGetKodePos(xdi);
});

});

// hide  button search
var base_url = window.location.origin;
let MrExist = document.getElementById('nomormr')
var namapasien = document.getElementById('PasienNama');
let nomormr = document.getElementById('Normpasien')
let jeniskelamin = document.getElementById('jeniskelamin');
// var namapasien = document.getElementByid(PasienNama)
let umur=document.getElementById('umur')
let alamatpasien=document.getElementById('PasienAlamat')
let pekerjaanpasien=document.getElementById('PasienPekerjaan')
let homephonepasien=document.getElementById('homephone')
let nik = document.getElementById('nik')
let monbilephonepasien =document.getElementById('mobilephone')
let emailpasien = document.getElementById('email')
let tgllahirpasien = document.getElementById('PasienUsia')
let reservasi = document.getElementById('tglreservasi')
let poliklinik = document.getElementById('poliklinik')
let tglawal_Search = document.getElementById('tglawal_Search')
let tglakhir_Search = document.getElementById('tglakhir_Search')
let pembayaran = document.getElementById('pembayaran')
let dokter = document.getElementById('dokter')
let antrian = document.getElementById('antrian')
// let poliklinik = document.getElementById('poliklinik')
// let tglreservasi = document.getElementById('tglreservasi')
let Keterangan = document.getElementById('Keterangan')
let PasienNoBooking = document.getElementById('PasienNoBooking')
let jampraktek = document.getElementById('jampraktek')
let shiftpraktek = document.getElementById('shiftpraktek')
let noregbatal = document.getElementById('noregbatal')
let regexalphanumeric = /^[A-Za-z]+$/
console.log(idpasien)
console.log(iduser)
console.log(namauser)
reservasi.disabled = true
if(idpasien!=''){
    getDatapasienbyID(idpasien)
}
 $('#btn_caridatamr').hide()
var carimedicalrecordpasien = document.getElementById('txSearchData')

$('#nomormr').on('change', function() {
//   alert( this.value );
if(this.value == 0){
    // document.getElementByID('btn_caridatamr').style.visibility = 'hidden';
    // document.getElementByID('btn_caridatamr')style.display = 'none';
    // console.log(this.value)
    $('#btn_caridatamr').hide()
}else{
     $('#btn_caridatamr').show()
}
});
// membuat validasi untuk nama
function namePatient(){
    if(namapasien.value.match(regexalphanumeric)){
    document.getElementById('errorPatienname').innerHTML=""      

    }else{
    document.getElementById('errorPatienname').innerHTML="hanya boleh menggunakan huruf"      

    }
} 

$("#txSearchData").keyup(function (e) { // Ketika user menekan tombol di keyboard
    if (e.keyCode == 13) { // Jika user menekan tombol ENTER
        cariRekamMedikPasien();
    }
});

function cariRekamMedikPasien(){
    // var awal = tglawal.value
    var userInput =  document.getElementById('txSearchData').value
    if(userInput.length<=5){
        swal({
            title: "waring",
            text: "Pencarian harus lebih dari 5 karakter",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
    }else if($('#txSearchData').val()==''){
    swal({
        title: "waring",
        text: "Masukkan Value Terlebihdahulu",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
}else{


    // console.log(awal)
$.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/carirekamedikberdasarkannama',
        data: {
                namapasien:carimedicalrecordpasien.value,
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {
            console.log(data) 
            $("#datamedicalrecord").empty();
            data.forEach(datamedicalrecord);
            function datamedicalrecord(medicalrecord,index){
                $('#datamedicalrecord').append(`
                <tr>
                    <td>${medicalrecord.NoMR}</td>
                    <td>${medicalrecord.PatientName}</td>
                    <td>${medicalrecord.Date_of_birth}</td>
                    <td>${medicalrecord.Address}</td>
                    <td>${medicalrecord["Mobile Phone"]}</td>
                    <td><buton class="btn btn-primary" onclick="getpasiensudahpunyamr(${medicalrecord.ID})">Input</buton></td>
                </tr>
                `);
            }
 
        });
    }
}
function getpasiensudahpunyamr(id){
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/getDataWalkinsudahpunyamr',
        data: {
                idpasien:id,
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {
            console.log(data) 
            nomormr.value = data.NoMR
            namapasien.value = data.PatientName
            alamatpasien.value = data.Address
            tgllahirpasien.value = data.Date_of_birthx
            jeniskelamin.value = data.Gander
            umur.value = getAge(tgllahirpasien.value)
            pekerjaanpasien.value = data.Ocupation
            nik.value = data.ID_Card_number
            homephonepasien.value = data.homephone
            monbilephonepasien.value = data.mobilephone
            emailpasien.value = data["E-mail Address"]

            $("#Medrec_NoIdPengenal").val(data.ID_Card_number);
            $("#Medrec_Tpt_lahir").val(data.BirthPlace);
            $("#Medrec_Pekerjaan").val(data.Ocupation);
            $('#Medical_Provinsi').val(data.provinsi).trigger('change');
            $("#Medrec_Warganegara").val(data.warganegaara);
            $("#Medical_Agama").val(data.Religion);
            $("#Medrec_statusNikah").val(data.Marital_status);
            $("#Medrec_Pendidikan").val(data.Education);
            $("#Medrec_NamaIbuKandung").val(data.Mother);
            $("#Medrec_Kodepos").val(data.kodepos);

            $("#Medrec_Bahasa").val(data.Bahasa);
            $("#Medrec_IdPengenal").val(data.Tipe_Idcard);
            $("#Medrec_Etnis").val(data.Etnis);
            showAlamat(data.provinsi,data.City,data.Kecamatan,data.Kelurahan);

            document.getElementById('btnModalSrcPasienClose').click();
            disablefrom()
        });
}
function getDatapasienbyID(id){
$.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/getDataWalkinPatient',
        data: {
                idpasien:id,
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {
            console.log(data) 
            MrExist.value = data.MrExist
            nomormr.value = data.NoMR
            namapasien.value = data.NamaPasien
            alamatpasien.value = data.Alamat
            tgllahirpasien.value = data.TglLahir
            jeniskelamin.value = data.JenisKelamin
            umur.value = getAge(tgllahirpasien.value)
            if(data.Ocupation==null){
                pekerjaanpasien.value='-'
            }else{
                pekerjaanpasien.value = data.Ocupation
            }
            // pekerjaanpasien.value = data.Ocupation
            if(data.ID_Card_number==null){
                nik.value = data.NoKTP
            }else{
                nik.value = data.ID_Card_number
            }
            homephonepasien.value = data.Telephone
            monbilephonepasien.value = data.HP
            emailpasien.value = data.Email
            PasienNoBooking.value=data.NoBooking
            pembayaran.value = data.JenisPembayaran
            poliklinik.value = data.IdPoli
            reservasi.value = data.ApmDate
            antrian.value = data.NoAntrianAll
            Keterangan.value = data.Description
            document.getElementById('btnModalSrcPasienClose').click();
            disablefrom()
            disableformreservasipasien()
            $("#dokter").empty();
            $('#dokter').append(`<option value=${data.DoctorID}>${data.First_Name}</option>`);
            var tanggallengkap = new String();
            var namahari = ("Minggu Senin Selasa Rabu Kamis Jumat Sabtu");
            namahari = namahari.split(" ");
            var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
            namabulan = namabulan.split(" ");
            var tgl = new Date(reservasi.value);
            var hari = tgl.getDay();
            var tanggal = tgl.getDate();
            var bulan = tgl.getMonth();
            var tahun = tgl.getFullYear();
            tanggallengkap = namahari[hari];
            var jamdokter = tanggallengkap+'_Waktu';
            console.log(tanggallengkap+'_Waktu')
                            $('#jampraktek').empty()
                            // $('#jampraktek').append('<option value=>-Pilih Jam Praktek-</option>');
                            $.ajax({
                                url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/jamdokterpraktek',
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    idlayanan: poliklinik.value,
                                    iddokter: dokter.value,
                                    hari:tanggallengkap
                                },
                                success: function(hasil) {
                                    // console.log(hasil)
                                    // $('#jampraktek').append(`<option value="${item.jampraktek}">${item.jampraktek}</option>`);
                                    hasil.forEach(jampraktek);
                                    function jampraktek(praktek,index){
                                        console.log(jamdokter)
                                        console.log(praktek[jamdokter]);
                                        if(praktek[jamdokter]!='-'){
                                         $('#jampraktek').append(`<option value=${praktek[jamdokter]}>${praktek[jamdokter]}</option>`);
                                        }  
                                    }
                                    $.ajax({
                                        url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/shiftDokter',
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            jam:$('#jampraktek').val()
                                        },
                                        success: function(hasil) {
                                            console.log(hasil)
                                        $('#shiftpraktek').empty()
                                            $('#shiftpraktek').append(`<option value="${hasil.NamaSesion}">${hasil.NamaSesion}</option>`);
                                            $('#new').val('New')
                                            // hasil.forEach(shift);
                                            // function shift(praktek,index){
                                            // }
                                        }
                                    });
                                }
                            });
                            if(pekerjaanpasien.value==''||nik.value==''||pekerjaanpasien.value=='-'){
                                pekerjaanpasien.disabled=false
                                nik.disabled=false
                            }
                            pembayaran.disabled=false
                            Keterangan.disabled=false
                            pekerjaanpasien.disabled=false
        });
        
}

function disablefrom(){
    MrExist.disabled=true
    namapasien.disabled=true
    alamatpasien.disabled=true
    pekerjaanpasien.disabled=true
    nik.disabled = true
    jeniskelamin.disabled=true
    homephonepasien.disabled=true
    monbilephonepasien.disabled=true
    if(emailpasien.value =="-" || emailpasien.value =="" ){
        
        emailpasien.disabled = false
    }else{

        emailpasien.disabled = true
    }
    tgllahirpasien.disabled = true
    umur.disabled = true
}

function disableformreservasipasien(){
    PasienNoBooking.disabled = true
    pembayaran.disabled = true
    dokter.disabled = true
    poliklinik.disabled = true
    jampraktek.disabled = true
    shiftpraktek.disabled= true
    Keterangan.disabled = true
    reservasi.disabled = true
}
function clearform(){
 document.getElementById("frmSimpanTrsRegistrasi").reset();
    $('#jampraktek').empty()
    $('#dokter').empty()
    $('#shiftpraktek').empty()
    $('#shiftpraktek').append(`<option value="">--pilih--</option>`)
    $('#jampraktek').append(`<option value="">--pilih--</option>`)
    $('#dokter').append(`<option value="">--pilih--</option>`)
    reservasi.disabled = true
}
function getAge(birthdaypasien) {
	var date =birthdaypasien ;
 
	if(date === ""){
		// alert("Please complete the required field!");
    }else{
		var today = new Date();
		var birthday = new Date(date);
		var year = 0;
		if (today.getMonth() < birthday.getMonth()) {
			year = 1;
		} else if ((today.getMonth() == birthday.getMonth()) && today.getDate() < birthday.getDate()) {
			year = 1;
		}
		var age = today.getFullYear() - birthday.getFullYear() - year;
 
		if(age < 0){
			age = 0;
		}
		return age;
	}
}
function umurpasien(e){
    umur.value=getAge(e.target.value)
}
function hari(e){
//   var tglharini = e.target.value;
var tanggallengkap = new String();
var namahari = ("Minggu Senin Selasa Rabu Kamis Jumat Sabtu");
namahari = namahari.split(" ");
var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
namabulan = namabulan.split(" ");
var tgl = new Date(e.target.value);
var hari = tgl.getDay();
var tanggal = tgl.getDate();
var bulan = tgl.getMonth();
var tahun = tgl.getFullYear();
tanggallengkap = namahari[hari];

// console.log(tanggallengkap)
$.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/getDokterBydate',
        data: {
                hari:tanggallengkap,
                idlayanan:poliklinik.value
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {
            console.log(data) 
            $("#dokter").empty();
            $('#dokter').append(`<option value="">--Pilih--</option>`);
            data.forEach(datadoker);
            function datadoker(dokter,index){
                 $('#dokter').append(`<option value=${dokter.ID}>${dokter.First_Name}</option>`);
            }
            dokter.disabled=false
           
        });
}
$(poliklinik).on('change',function(){
    reservasi.disabled = false
})
$('#dokter').on('change', function() {
    var tanggallengkap = new String();
var namahari = ("Minggu Senin Selasa Rabu Kamis Jumat Sabtu");
namahari = namahari.split(" ");
var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
namabulan = namabulan.split(" ");
var tgl = new Date(reservasi.value);
var hari = tgl.getDay();
var tanggal = tgl.getDate();
var bulan = tgl.getMonth();
var tahun = tgl.getFullYear();
tanggallengkap = namahari[hari];
var jamdokter = tanggallengkap+'_Waktu';
console.log(tanggallengkap+'_Waktu')
				$('#jampraktek').empty()
				// $('#jampraktek').append('<option value=>-Pilih Jam Praktek-</option>');
				$.ajax({
					url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/jamdokterpraktek',
					type: 'post',
					dataType: 'json',
					data: {
						idlayanan: poliklinik.value,
						iddokter: $(this).val(),
                        hari:tanggallengkap
					},
					success: function(hasil) {
                        // console.log(hasil)
                        // $('#jampraktek').append(`<option value="${item.jampraktek}">${item.jampraktek}</option>`);
                        hasil.forEach(jampraktek);
                        function jampraktek(praktek,index){
                            console.log(jamdokter)
                            console.log(praktek[jamdokter]);
                             $('#jampraktek').append(`<option value=${praktek[jamdokter]}>${praktek[jamdokter]}</option>`);
                        }
                        $.ajax({
                            url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/shiftDokter',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                jam:$('#jampraktek').val()
                            },
                            success: function(hasil) {
                                console.log(hasil)
                            $('#shiftpraktek').empty()
                                $('#shiftpraktek').append(`<option value="${hasil.NamaSesion}">${hasil.NamaSesion}</option>`);
                                $('#new').val('New')
                                // hasil.forEach(shift);
                                // function shift(praktek,index){
                                // }
                            }
                        });
					}
                    
                    
				});
                if(jampraktek.value=='-'&&shiftpraktek.value=='undefined'){
                    document.getElementById('btnsimpan').disabled=true
               }  
			})

            $('#jampraktek').on('change', function() {
                            $('#shiftpraktek').empty()
                            // $('#jampraktek').append('<option value=>-Pilih Jam Praktek-</option>');
                            $.ajax({
                                url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/shiftDokter',
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    jam:$('#jampraktek').val()
                                },
                                success: function(hasil) {
                                    console.log(hasil)
                                    $('#shiftpraktek').append(`<option value="${hasil.NamaSesion}">${hasil.NamaSesion}</option>`);
                                    $('#new').val('New')
                                    // hasil.forEach(shift);
                                    // function shift(praktek,index){
                                    // }
                                }
                            });
                        })
function getDokter(){

}
$("#btnsimpan").click(function (e) {
    e.preventDefault()

    // if(namapasien.value!=''&&alamatpasien.value!=''&&jeniskelamin.value!=''&&tgllahirpasien.value!=''&&pekerjaanpasien.value!=''&&nik.value!=''&&monbilephonepasien.value!=''&&homephonepasien.value!=''&&emailpasien.value!=''&&pembayaran.value!=''&&poliklinik.value!=''&&$('#tglreservasi').val()!=''&&Keterangan.value!=''&&dokter.value!=''&&dokter.value!='-'&&jampraktek.value!='-'){
    //     e.preventDefault()
    //     swal({
    //         title: "Simpan",
    //         text: "Apakah Anda ingin Simpan Registrasi ?",
    //         icon: "warning",
    //         buttons: true,
    //         dangerMode: true,
    //     })
    //     .then((willDelete) => {
    //         if (willDelete) {
    //             createReservasiWalkin()
    //         } else {
    //             swal("Transaction Rollback !");
    //         }
    //     });
    // }else{
    //     e.preventDefault()
    //     swal({
    //         title: "Error Form",
    //         text: "Periksa kembalopengisian anda",
    //         icon: "warning",
    //     })
    //     jampraktek.onfocus
    // }
    if(MrExist.value==''){
        swal({
            title: "Error Form Sudah punya no Mr Belum di pilih",
            text: "Periksa kembali pengisian from anda",
            icon: "warning",
        })

    }
     else if(namapasien.value==''){
        swal({
            title: "Error Form",
            text: "Nama pasien kosong",
            icon: "warning",
        })

      }else if(alamatpasien.value==''){
        swal({
            title: "Error Form",
            text: "alamat pasien tidak boleh kosong",
            icon: "warning",
        })

      }else if(jeniskelamin.value==''){
        swal({
            title: "Error Form",
            text: "Jenis kelamin belum di pilih",
            icon: "warning",
        })
      }else if(tgllahirpasien.value==''){
        swal({
            title: "Error Form",
            text: "tanggal lahir pasien tidak boleh kosong",
            icon: "warning",
        })
      }else if(pekerjaanpasien.value==''){
        swal({
            title: "Error Form",
            text: "Pekerjaan Pasien tidak boleh kosong",
            icon: "warning",
        })
      }else if(nik.value==''){
        swal({
            title: "Error Form",
            text: "Nik tidak boleh kosong",
            icon: "warning",
        })
      }else if(monbilephonepasien.value==''){
        swal({
            title: "Error Form",
            text: "Mobile phone tidak boleh kosong",
            icon: "warning",
        })
      }else if(homephonepasien.value==''){
        swal({
            title: "Error Form",
            text: "nomor telepon todak boleh kosong",
            icon: "warning",
        })
      }else if(!validateEmail(emailpasien.value)){
        swal({
            title: "Error Form",
            text: "Email tidak valid",
            icon: "warning",
        })
      }else if(pembayaran.value==''){
        swal({
            title: "Error Form",
            text: "Pembayaran belum di pilih",
            icon: "warning",
        })
      }else if(poliklinik.value==''){
        swal({
            title: "Error Form",
            text: "Poli klinik belum di pilih",
            icon: "warning",
        })
      }else if($('#tglreservasi').val()==''){
        swal({
            title: "Error Form",
            text: "Tangal Reservasi Tidak Boleh kosong",
            icon: "warning",
        })
      }else if(Keterangan.value==''){
        swal({
            title: "Error Form",
            text: "Keterangan harus di isi",
            icon: "warning",
        })
      }else if(dokter.value==''||dokter.value=='-'){
        swal({
            title: "Error Form",
            text: "dokter belum di pilih",
            icon: "warning",
        })
      }else if(jampraktek.value=='-'){
        swal({
            title: "Error Form",
            text: "Periksa jam praktek dokter",
            icon: "warning",
        })
      }else{
        swal({
            title: "Simpan",
            text: "Apakah Anda ingin Simpan Registrasi ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                createReservasiWalkin()
            } else {
                swal("Transaction Rollback !");
            }
        });
      }
       
 
    
  });
function createReservasiWalkin(){
    var formData = {
        MrExist:$('#nomormr').val(),
        nomr:$('#Normpasien').val(),
        iduser:iduser,
        PasienNama:$('#PasienNama').val(),
        PasienAlamat:$('#PasienAlamat').val(),
        jeniskelamin:$('#jeniskelamin').val(),
        ttlpasien:$('#PasienUsia').val(),
        PasienPekerjaan:$('#PasienPekerjaan').val(),
        nik:$('#nik').val(),
        homephone:$('#homephone').val(),
        mobilephone:$('#mobilephone').val(),
        email:$('#email').val(),
        idpembayaran:$('#pembayaran').val(),
        idpoliklinik:$('#poliklinik').val(),
        namapoliklinik:$('#poliklinik option:selected').text(),
        tglreservasi:$('#tglreservasi').val(),
        Keterangan:$('#Keterangan').val(),
        iddokter:$('#dokter').val(),
        namadokter:$('#dokter option:selected').text(),
        jampraktek:$('#jampraktek').val(),
        shiftpraktek:$('#shiftpraktek option:selected').text(),
        PasienNoBooking:$('#PasienNoBooking').val(),
        PasienUsia:$('#umur').val(),
        petugasbatal:namauser,

        //--------------------------new
        Medical_Provinsi:$('#Medical_Provinsi').val(),
        Medrec_IdPengenal:$('#Medrec_IdPengenal').val(),
        Medrec_kabupaten:$('#Medrec_kabupaten').val(),
        Medrec_Kecamatan:$('#Medrec_Kecamatan').val(),
        Medrec_Tpt_lahir:$('#Medrec_Tpt_lahir').val(),
        Medrec_Kelurahan:$('#Medrec_Kelurahan').val(),
        Medrec_statusNikah:$('#Medrec_statusNikah').val(),
        Medical_Agama:$('#Medical_Agama').val(),
        Medrec_Bahasa:$('#Medrec_Bahasa').val(),
        Medrec_Warganegara:$('#Medrec_Warganegara').val(),
        Medrec_Kodepos:$('#Medrec_Kodepos').val(),
        Medrec_Pendidikan:$('#Medrec_Pendidikan').val(),
        Medrec_Etnis:$('#Medrec_Etnis').val(),
        Medrec_NamaIbuKandung:$('#Medrec_NamaIbuKandung').val()

        // shiftpraktek:$('#shiftpraktek').val,
    };

    $.ajax({
      type: "POST",
      url:  base_url + '/SIKBREC/public/aReservasiPasienWalkin/createReservasiWalkin',
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      console.log(data);
      if(data.status == 'success'){
        swal({
            title: "Data Berhasil Di Simpan",
            text: "NoBoking "+ data.NoBoking +", NoAntrian "+data.NoAntrianPoli+",Dokter "+data.IdDokter.First_Name,
        })
        clearform()
        enabledfrom()
        setTimeout(function() { window.location.replace(base_url+"/SIKBREC/public/aReservasiPasienWalkin"); }, 3000);
        
        
      }else if(data.status =='warning'){
        swal({
            title: "Warning",
            text: data.errorname+' '+data.errormessage,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
      }else if(data.status =='updated'){
        swal({
            title: "Data Berhasil Di Update",
            text: data.message,
        })
      }
    });

    // event.preventDefault();
}

  function getDataReservasiWalkin(){
    $.ajax({
            type: "POST",
            url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/getDataReservasiWalkin',
            data: {
                    tglawal_Search:tglawal_Search.value,
                    tglakhir_Search:tglakhir_Search.value
                    },
            dataType: "json",
                            // encode: true,
            }).done(function(data) {
                // console.log(data) 
                $('#datareservasi').empty()
                data.forEach(reservasi);
                    function reservasi(datareservasi,index){
                            $('#datareservasi').append(`
                    <tr>
                    <td>${index+1}</td>
                    <td>${datareservasi.NoMR}</td>
                    <td>${datareservasi.NamaPasien}</td>
                    <td>${datareservasi.ApmDate}</td>
                    <td>${datareservasi.NamaUnit}</td>
                    <td>${datareservasi.First_Name}</td>
                    <td>${datareservasi.NoUrut}</td>
                    <td>${datareservasi.JenisPembayaran}</td>
                    <td>${datareservasi.JamPraktek}</td>
                    <td>${datareservasi.Alamat}</td>
                    <td>${datareservasi.TglLahir}</td>
                    <td><buton class="btn btn-primary" onclick="getDataReservasiWalkinbyid(${datareservasi.ID})">Input</buton></td>
                    </tr>
                `);
                }
               
            });
    }

function getDataReservasiWalkinbyid(id){
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/getDatareservasi',
        data: {
                ID:id
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {
            console.log(data)
            MrExist.value = data.MrExist
            nomormr.value = data.NoMR
            namapasien.value = data.NamaPasien
            alamatpasien.value = data.Alamat
            tgllahirpasien.value = data.TglLahir
            jeniskelamin.value = data.JenisKelamin
            umur.value = getAge(tgllahirpasien.value)
            // pekerjaanpasien.value = data.Ocupation
            if(data.Ocupation==null){
                pekerjaanpasien.value='-'
            }else{
                pekerjaanpasien.value = data.Ocupation
            }
            nik.value = data.NoKTP
            homephonepasien.value = data.Telephone
            monbilephonepasien.value = data.HP
            emailpasien.value = data.Email
            PasienNoBooking.value = data.NoBooking
            pembayaran.value = data.JenisPembayaran
            poliklinik.value =  data.IdPoli
            reservasi.value = data.ApmDate
            Keterangan.value = data.Description
            dokter.value = data.DoctorID

            $("#Medrec_NoIdPengenal").val(data.ID_Card_number);
            $("#Medrec_Tpt_lahir").val(data.BirthPlace);
            $("#Medrec_Pekerjaan").val(data.Ocupation);
            $('#Medical_Provinsi').val(data.provinsi).trigger('change');
            $("#Medrec_Warganegara").val(data.Medrec_Warganegara);
            $("#Medical_Agama").val(data.Religion);
            $("#Medrec_statusNikah").val(data.StatusMenikah);
            $("#Medrec_Pendidikan").val(data.Education);
            $("#Medrec_NamaIbuKandung").val(data.Mother);
            $("#Medrec_Kodepos").val(data.kodepos);

            $("#Medrec_Bahasa").val(data.Bahasa);
            $("#Medrec_IdPengenal").val(data.Tipe_Idcard);
            $("#Medrec_Etnis").val(data.Etnis);
            showAlamat(data.provinsi,data.City,data.Kecamatan,data.Kelurahan);


            // jampraktek = data.JamPraktek
            // shiftpraktek = 
            $('#dokter').empty()
            $('#shiftpraktek').empty()
            $('#dokter').append(`<option value="${data.DoctorID}">${data.First_Name}</option>`);
            $('#shiftpraktek').append(`<option value="${data.JamPraktek}">${data.JamPraktek}</option>`);
            $('#new').val('New')
            document.getElementById('btnModalSrcReservasi').click();
            disablefrom()
            disableformreservasipasien()
            pembayaran.disabled = false
            Keterangan.disabled = false
            email.disabled = false
            tgllahirpasien.disabled = false
            var tanggallengkap = new String();
            var namahari = ("Minggu Senin Selasa Rabu Kamis Jumat Sabtu");
            namahari = namahari.split(" ");
            var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
            namabulan = namabulan.split(" ");
            var tgl = new Date(reservasi.value);
            var hari = tgl.getDay();
            var tanggal = tgl.getDate();
            var bulan = tgl.getMonth();
            var tahun = tgl.getFullYear();
            tanggallengkap = namahari[hari];
            var jamdokter = tanggallengkap+'_Waktu';
            console.log(tanggallengkap+'_Waktu')
                            $('#jampraktek').empty()
                            // $('#jampraktek').append('<option value=>-Pilih Jam Praktek-</option>');
                            $.ajax({
                                url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/jamdokterpraktek',
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    idlayanan: poliklinik.value,
                                    iddokter: dokter.value,
                                    hari:tanggallengkap
                                },
                                success: function(hasil) {
                                    // console.log(hasil)
                                    // $('#jampraktek').append(`<option value="${item.jampraktek}">${item.jampraktek}</option>`);
                                    hasil.forEach(jampraktek);
                                    function jampraktek(praktek,index){
                                        console.log(jamdokter)
                                        console.log(praktek[jamdokter]);
                                        if(praktek[jamdokter]!='-'){
                                         $('#jampraktek').append(`<option value=${praktek[jamdokter]}>${praktek[jamdokter]}</option>`);
                                        }  
                                    }
                                    $.ajax({
                                        url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/shiftDokter',
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            jam:$('#jampraktek').val()
                                        },
                                        success: function(hasil) {
                                            console.log(hasil)
                                        $('#shiftpraktek').empty()
                                            $('#shiftpraktek').append(`<option value="${hasil.NamaSesion}">${hasil.NamaSesion}</option>`);
                                            $('#new').val('New')
                                            // hasil.forEach(shift);
                                            // function shift(praktek,index){
                                            // }
                                        }
                                    });
                                }
                            });
        });
}
function getNobokingalasan(){
    let pasienbooking = $('#PasienNoBooking').val()
    let alasanbatal = $('#alasanbatal').val()
    noregbatal.value = $('#PasienNoBooking').val()
}
function batalreservasi(){
    console.log('dilkik');
    let pasienbooking = $('#PasienNoBooking').val()
 let alasanbatal = $('#alasanbatal').val()
 noregbatal.value = $('#PasienNoBooking').val()
 console.log(pasienbooking)
 
    if(pasienbooking==""){
       alertswall("Nomor Booking Kosong")
    }else if(alasanbatal==""){
        alertswall("Alasan Tidak Boleh Kosong")
    }else if(pasienbooking!="" && alasanbatal!=""){
        var formData = {
            nomorbooking:noregbatal.value,
            petugasbatal:namauser,
            alasanbatal:$('#alasanbatal').val()
            };
        
            $.ajax({
              type: "POST",
              url:  base_url + '/SIKBREC/public/aReservasiPasienWalkin/batalReservasiWalkin',
              data: formData,
              dataType: "json",
              encode: true,
            }).done(function (data) {
              console.log(data);
              if(data.status == 'success'){
                swal({
                    title: "Data Berhasil Di dibatalkan",
                    // text: "NoBoking "+ data.NoBoking +", NoAntrian "+data.NoAntrianPoli+",Dokter "+data.IdDokter.First_Name,
                })
                clearform()
                enabledfrom()
                reservasi.disabled=true

              }
              if(data.status =="warning"){
                swal({
                    title: "Data tidak bisa Di batalkan",
                    text: data.errorname,
                })
                closemodalbatal()
              }
            });
    }else{
        alertswall("Alasan dan kode booking Tidak Boleh Kosong")
    }
}
function enabledfrom(){
    MrExist.disabled = false
    namapasien.disabled=false
    alamatpasien.disabled=false
    jeniskelamin.disabled=false
    pekerjaanpasien.disabled=false
    nik.disabled=false
    homephonepasien.disabled=false
    monbilephonepasien.disabled=false
    poliklinik.disabled=false
    reservasi.disabled=true
    tgllahirpasien.disabled=false
    $('#dokter').empty()
    $('#dokter').append(`<option>--Pilih--</option>`)
}
// $("#btnVoidTrsReg").onclick(function (event) {

//  let pasienbooking = $('#PasienNoBooking').val()
//  let alasanbatal = $('#alasanbatal').val()
//  noregbatal.value = $('#PasienNoBooking').val()
//  console.log(pasienbooking)
 
//     if(pasienbooking==""){
//        alertswall("Nomor Booking Kosong")
//     }else if(alasanbatal==""){
//         alertswall("Alasan Tidak Boleh Kosong")
//     }else if(pasienbooking!="" && alasanbatal!=""){
//         var formData = {
//             nomorbooking:regbatal.value,
//             perugasbatal:namauser
//             };
        
//             $.ajax({
//               type: "POST",
//               url:  base_url + '/SIKBREC/public/aReservasiPasienWalkin/createReservasiWalkin',
//               data: formData,
//               dataType: "json",
//               encode: true,
//             }).done(function (data) {
//               console.log(data);
//               if(data.status == 'success'){
//                 swal({
//                     title: "Data Berhasil Di dibatalkan",
//                     // text: "NoBoking "+ data.NoBoking +", NoAntrian "+data.NoAntrianPoli+",Dokter "+data.IdDokter.First_Name,
//                 })
//               }
//             });
//             event.preventDefault();
//     }else{
//         alertswall("Alasan dan kode booking Tidak Boleh Kosong")
//     }
//     // console.log()
    
//   });
function validateEmail(mail) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(mail);
  }
function closemodalbatal(){
    document.getElementsByClassName('swal-button--confirm').onclick = function(){
        clearform();
        document.getElementById('btnModalSrcPasienClose').click();
    }
}
  function alertswall(message){
    swal({
        title: "Cek",
        text: message,
        icon: "warning",
    })
  }

//   cek validation form

async function onLoadFunctionAll() {
    try{
        const datagetProvinsi =  await getProvinsi();
        updateUIgetProvinsi(datagetProvinsi);
    } catch (err) {
        toast(err, "error")
    }
}

function getProvinsi() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/getProvinsi';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $("#Medical_Provinsi").select2();
        })
}

function updateUIgetProvinsi(datagetProvinsi) {
    let responseApi = datagetProvinsi;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Medical_Provinsi").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].PovinsiID + '">' + responseApi.data[i].ProvinsiNama + '</option>';
            $("#Medical_Provinsi").append(newRow);
            
        }
    }
    
}

async function showGetKabupaten(xdi) {
    try{
    //  var xdi = document.getElementById("Medical_Provinsi").value;
        const dataGetKabupaten = await GetKabupaten(xdi);
        console.log("datakabupaten",dataGetKabupaten)
        updateUIGetKabupaten(dataGetKabupaten);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetKabupaten(dataGetKabupaten) {
    let responseApi = dataGetKabupaten;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data); 
        $("#Medrec_kabupaten").empty();
        var newRow = '<option value="">-- Pilih Kabupaten --</option';
        $("#Medrec_kabupaten").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].kabupatenId + '">' + responseApi.data[i].kabupatenNama + '</option';
            $("#Medrec_kabupaten").append(newRow);

        }
    }
}

function GetKabupaten(data) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetKabupaten';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
           // $("#Medrec_kabupaten").select2();
        })
}
async function showGetKecamatan(data) {
    try{
        const dataGetKecamatan = await GetKecamatan(data);
        console.log("datakecamatan", dataGetKecamatan)
        updateUIGetKecamatan(dataGetKecamatan);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetKecamatan(dataGetKecamatan) {
    let responseApi = dataGetKecamatan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        $("#Medrec_Kecamatan").empty();
        var newRow = '<option value="">-- Pilih Kecamatan --</option';
        $("#Medrec_Kecamatan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].kecamatanId + '">' + responseApi.data[i].Kecamatan + '</option';
            $("#Medrec_Kecamatan").append(newRow);

        }
    }
}
function GetKecamatan(data) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetKecamatan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            //$("#Medrec_kabupaten").select2();
        })
}

async function showGetKelurahan(data) {
    try{
        const dataGetKelurahan = await GetKelurahan(data);
        console.log("datakecamatan", dataGetKelurahan)
        updateUIGetKelurahan(dataGetKelurahan);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIGetKelurahan(dataGetKelurahan) {
    let responseApi = dataGetKelurahan;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        $("#Medrec_Kelurahan").empty();
        var newRow = '<option value="">-- Pilih Kelurahan --</option';
        $("#Medrec_Kelurahan").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].desaId + '">' + responseApi.data[i].Kelurahan + '</option';
            $("#Medrec_Kelurahan").append(newRow);

        }
    }
}
function GetKelurahan(data) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetKelurahan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $("#Medical_Provinsi").select2();
        })
}

async function showGetKodePos(data) {
    try{
        const dataGetKodePos = await GetKodePos(data); 
        updateUIGetKodePos(dataGetKodePos);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIGetKodePos(dataGetKodePos) {
    let responseApi = dataGetKodePos;
    $("#Medrec_Kodepos").val(responseApi.kodepos);
}
function GetKodePos(data) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aMedicalRecord/GetKodepos';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + data
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();
        })
        .then(response => {
            if (response.status === "error") {
                throw new Error(response.message.errorInfo[2]);
                // console.log("ok " + response.message.errorInfo[2])
            } else if (response.status === "warning") {
                throw new Error(response.errorname);
                // console.log("ok " + response.message.errorInfo[2])
            }
            return response
        })
        .finally(() => {
            $("#Medical_Provinsi").select2();
        })
}

async function showAlamat(provinsi,kabupaten,kecamatan,kelurahan){

    await showGetKabupaten(provinsi);
            await showGetKecamatan(kabupaten);
            await showGetKelurahan(kecamatan);
            $('#Medrec_Kecamatan').val(kecamatan)//.trigger('change');
            $('#Medrec_kabupaten').val(kabupaten)//.trigger('change');
            $('#Medrec_Kelurahan').val(kelurahan)//.trigger('change');

            $("#Medrec_kabupaten").select2();
            $('#Medrec_Kecamatan').select2();
            $('#Medrec_Kelurahan').select2();
}