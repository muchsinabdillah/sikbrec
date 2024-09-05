$(document).ready(function () {  
    onLoadFunctionAll(); 
    $("#poliklinik").select2();
    document.getElementById("btnCloseModalSyarat").disabled = true;
    $('#btncetakDigital').click(function () {
        goCountCetak();
    });

    $('#notif_Cetak_peringatan').modal('show');
    $('#logocetakbuktiSEP').click(function () {
        $('#notif_ShowTTD_Digital').modal('show');
        $('#notif_Cetak').modal('hide');
        var pxNoSep = $("#BPJS_NoRencKontrol").val();
        console.log("pxNoSep", pxNoSep);
        $("#signNoSep").val(pxNoSep);
    }); 

    $('#penjamin').on('change', function() {
        $("#poliklinik").val('');
    })

     

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

    $('#pembayaran').change(function () {
        let typatient = $("#pembayaran").val();
        getIDPenjamin(typatient);
    });

});

var base_url = window.location.origin;
let MrExist =document.getElementById('nomormr')
let NoMR = document.getElementById('Normpasien')
let NamaPasien = document.getElementById('PasienNama')
let PasienAlamat = document.getElementById('PasienAlamat')
let jeniskelamin= document.getElementById('jeniskelamin')
let PasienUsia = document.getElementById('PasienUsia')
let umur = document.getElementById('umur')
let PasienPekerjaan = document.getElementById('PasienPekerjaan')
let nik =document.getElementById('nik')
let Telephone = document.getElementById('homephone')
let mobilephone = document.getElementById('mobilephone')
let email = document.getElementById('email')
let  PasienNoBooking= document.getElementById('PasienNoBooking')
let pembayaran = document.getElementById('pembayaran')
let poliklinik = document.getElementById('poliklinik')
let tglreservasi = document.getElementById('tglreservasi')
let antrian = document.getElementById('antrian')
let Keterangan = document.getElementById('Keterangan')
let dokter = document.getElementById('dokter')
let jampraktek = document.getElementById('jampraktek')
let shiftpraktek = document.getElementById('shiftpraktek')
let penjamin = document.getElementById('penjamin')
let baru = document.getElementById('new')
 
// $("#txSearchData").keyup(function (e) { // Ketika user menekan tombol di keyboard
//     if (e.keyCode == 13) { // Jika user menekan tombol ENTER
//         loaddatamr();
//     }
// });
// function loaddatamr() {
//     var base_url = window.location.origin;
//     var txSearchData = $("#txSearchData").val();
//     var cmbxcrimr = $("#cmbxcrimr").val();
//     if (txSearchData == '' || txSearchData == null) {
//         toast('Silahkan Isi Kata Kunci!', "warning")
//         return false
//     }
//     var iswalkin = $("#iswalkin").val();
//     $('#table-load-data').DataTable().clear().destroy();
//     $('#table-load-data').DataTable({
//         "ordering": true,
//         "searching": false,
//         "ajax": {
//             "url": base_url + "/SIKBREC/public/aMedicalRecord/getListMedicalRecord",
//             "dataSrc": "",
//             "deferRender": true,
//             "type": "POST",
//             data: function (d) {
//                 d.txSearchData = txSearchData;
//                 d.iswalkin = iswalkin;
//                 d.cmbxcrimr = cmbxcrimr;
//                 // d.custom = $('#myInput').val();
//                 // etc
//             }
//         },
//         "columns": [
//             { "data": "NoMR" },
//             { "data": "NamaPasien" },
//             { "data": "TglLahir" },
//             { "data": "Alamat" },
//             { "data": "TlpRumah" },
//             {
//                 "render": function (data, type, row) { // Tampilkan kolom aksi
//                     var html = ""

//                     var html = '<button class="btn btn-info"  id="buttonedit" name="buttonedit" onclick=\'showIDMR("' + row.ID + '")\' value=' + row.ID + '><span class="glyphicon glyphicon-log-in"></span></button> '
//                     return html
//                 }
//             },

//         ]
//     });
// }
async function goCountCetak() {
    try {
        $(".preloader").fadeIn();
        var notrs = $("#BPJS_NoRencKontrol").val();
        var signAlasanCetak = $("#signAlasanCetak").val();
        var jeniscetakan = "RENCANAKONTROL";
        const dataCountCetak = await CountCetak(notrs, signAlasanCetak, jeniscetakan);
        console.log(dataCountCetak);
        updateUiSukseshistory(dataCountCetak, notrs);
        $(".preloader").fadeOut();
    } catch (err) {
        swal("Oops", "Sorry.." + err, "error");
    }
}

function updateUiSukseshistory(params, notrs) {
    if (params.status === 200) {
        var notrs = $("#BPJS_NoRencKontrol").val();
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/aKontrolUlang/PrintRencanaKontrol/" + notrs, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
        MyBack();
    }

}
function CountCetak(notrs, signAlasanCetak, jeniscetakan) {
    var nomortransaksi = $("#SPRI_NoSPR2BPJS").val();
    var is_login = 'nologin';
    var noreg = "";
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/SignatureDigital/CountCetak';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "notrs=" + notrs + "&signAlasanCetak=" + signAlasanCetak + "&jeniscetakan=" + jeniscetakan
            + "&noreg=" + noreg + "&is_login=" + is_login
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
            $(".preloader").fadeOut();
            // document.getElementById("frmKartuRSYarsi").reset();
            //$('#Modal_Karyawn_Polis').modal('hide');
        })
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/";
}
async function onLoadFunctionAll() {
    try{
        const datagetProvinsi =  await getProvinsi();
        updateUIgetProvinsi(datagetProvinsi);
        showIDMR($("#SIMRS_Registrasi").val());
    } catch (err) {
        toast(err, "error")
    }
}

async function showIDMR(params) {
    try {
        const dataShowIdMr = await GetMedicalRecordbyIDTrs(params);
        updateUIGetMedicalRecordbyIDTrs(dataShowIdMr);
        
    } catch (err) {
        toast(err, "error")
    }
}
async function verifySEp(){
    
        $(".preloader").fadeIn(); 
        const datasetDataSEPRujukanByID = await setDataSEPRujukanByID(); 
        updateUIdatasetDataSEPRujukanByID(datasetDataSEPRujukanByID);
        const dataGoBPJSCekKepesertaan = await GoBPJSCekKepesertaan();
        updateUIdataGoBPJSCekKepesertaan(dataGoBPJSCekKepesertaan);
      
   
}
async function updateUIGetMedicalRecordbyIDTrs(dataShowIdMr) {
    let data = dataShowIdMr;
    //jika provinsi kosong redirect ke medical record list untuk diisi
    if (data.Medical_Provinsi == '' || data.Medical_Provinsi == null){
        swal({
            title: 'PERHATIAN! Data Pasien Tidak Lengkap',
            text: "Data Pasien Tidak Lengkap ! Lengkapi Terlebih Dahulu Data Sosial Pasien Dengan Mengklik Tombol OK !",
            icon: 'warning',
        }).then(function() {
            const base_url = window.location.origin;
            var str = btoa(data.NoMR);
            window.open(base_url + '/SIKBREC/public/aMedicalRecord/' + str , "_blank");
            swal({
                title: 'Refresh Halaman',
                text: "Silahkan Refresh Kembali Halaman Ini Jika Sudah Melengkapi Data Pasien !",
                icon: 'warning',
            }).then(function() {
                location.reload()
            });
        });
        return false;
    }
    $("#BPJS_NoSEP").val(data.NoSEP);

    $("#PasienNoMR").val(data.NoMR);
    $("#cobname").val(data.NamaCOB);
    $("#noteregistrasi").val(data.Notes);
    $("#PasienNama").val(data.PatientName);
    $("#PasienIdJKel").val(data.Gander);
    $("#PasienTglLahir").val(data.Date_of_birth);
    $("#PasienAlamat").val(data.Address);
    $("#PasienNamaJKel").val(data.NamaGander);
    //$("#PasienNamaJKel").val(data.NamaGander);
    $("#PasienNIK").val(data.ID_Card_number);
    $("#PasienTptLahir").val(data.BirthPlace);
    $("#PasienPekerjaan").val(data.Ocupation);
    $("#NoHpBPJS").val(data.mobilephone);
    document.getElementById("btnModalSrcPasienClose").click();


    NoMR.value = data.NoMR
    NamaPasien.value = data.PatientName
    PasienAlamat.value = data.Address
    PasienUsia.value = data.Date_of_birth
    jeniskelamin.value = data.Gander
    umur.value = getAge(data.Date_of_birth)
    PasienPekerjaan.value = data.Ocupation
    nik.value = data.ID_Card_number
    Telephone.value = data.homephone
    mobilephone.value = data.mobilephone
    email.value = data.email

    $("#Medrec_NoIdPengenal").val(data.ID_Card_number);
    $("#Medrec_Tpt_lahir").val(data.BirthPlace);
    $("#Medrec_Pekerjaan").val(data.Ocupation);
    $('#Medical_Provinsi').val(data.Medical_Provinsi).trigger('change');
    $("#Medrec_Warganegara").val(data.Medrec_Warganegara);
    //$("#Medrec_HomePhone").val(data.Medrec_HomePhone);
   // $("#Medrec_handphone").val(data.Medrec_handphone);
    $("#Medical_Agama").val(data.Medical_Agama);
    $("#Medrec_statusNikah").val(data.Medrec_statusNikah);
    $("#Medrec_Pendidikan").val(data.Medrec_Pendidikan);
    //$("#Medrec_Email").val(data.Medrec_Email);
    //$("#Medrec_Status").val('1');
    $("#Medrec_NamaIbuKandung").val(data.Mother);
    //$("#Medrec_Ibu_Kandung").val(data.NoMR_IBU);
    $("#Medrec_Kodepos").val(data.kodepos);

    $("#Medrec_Bahasa").val(data.Bahasa);
    $("#Medrec_IdPengenal").val(data.Tipe_Idcard);
    $("#Medrec_Etnis").val(data.Etnis);
    
    await showGetKabupaten(data.Medical_Provinsi);
    await showGetKecamatan(data.Medrec_kabupaten);
    await showGetKelurahan(data.Medrec_Kecamatan);
    $('#Medrec_Kecamatan').val(data.Medrec_Kecamatan)//.trigger('change');
    $('#Medrec_kabupaten').val(data.Medrec_kabupaten)//.trigger('change');
    $('#Medrec_Kelurahan').val(data.Medrec_Kelurahan)//.trigger('change');

    $("#Medrec_kabupaten").select2();
    $('#Medrec_Kecamatan').select2();
    $('#Medrec_Kelurahan').select2();

    document.getElementById('btnModalSrcPasienClose').click();

    if (data.NoSEP != ''){
        $(".preloader").fadeIn(); 
        const datasetDataSEPRujukanByID = await setDataSEPRujukanByID(); 
        updateUIdatasetDataSEPRujukanByID(datasetDataSEPRujukanByID);
        const dataGoBPJSCekKepesertaan = await GoBPJSCekKepesertaan();
        updateUIdataGoBPJSCekKepesertaan(dataGoBPJSCekKepesertaan);
      
    }

}
function updateUIdataGoBPJSCekKepesertaan(data) { 
        $('#BPJS_xKodePoliRujukan').val(data.hasil[1].rujukan.poliRujukan.kode);
        $('#BPJS_xNamaPoliRujukan').val(data.hasil[1].rujukan.poliRujukan.nama);
      

    
}
function GoBPJSCekKepesertaan() { 
    var jenisPencarian = "3";
    var kodePeserta = $("#BPJS_xNorujukan").val();
    var JenisRujukanFaskesBPJSx = $("#JenisRujukanFaskesBPJSx").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/xBPJSBridging/GoBPJSCekKepesertaan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "jenisPencarian=" + jenisPencarian + "&kodePeserta=" + kodePeserta + "&JenisRujukanFaskesBPJSx=" + JenisRujukanFaskesBPJSx
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
            //   $("#Medical_Provinsi").select2();
            $(".preloader").fadeOut(); 
        })
}
function GetMedicalRecordbyIDTrs(params) {
    var x = params;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aReservasipasiennonWalkin/GetMedicalRecordbyNoReg';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + x
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
         //   $("#Medical_Provinsi").select2();

        })
}
$(poliklinik).on('change',function(){
    tglreservasi.disabled = false
})

function harireservasi(e){
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
$.ajax({
    type: "POST",
    url: base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/DaftarJadwalDokter',
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
        data.response.forEach(datadoker);
        function datadoker(dokter,index){
             $('#dokter').append(`<option value=${dokter.ID}>${dokter.First_Name}</option>`);
        }
        dokter.disabled=false
       
    });
}
function jampraktekdokter(){
    var jamdokter = hari(tglreservasi.value)+"_Sesion"
    var waktu = hari(tglreservasi.value)+"_Waktu"
    console.log(waktu)
    console.log(poliklinik.value)
    console.log(dokter.value)
    console.log(jamdokter)
    $.ajax({
        url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/jamdokterpraktek',
        type: 'post',
        dataType: 'json',
        data: {
            idlayanan: poliklinik.value,
            iddokter: dokter.value,
            hari:hari(tglreservasi.value)
        },
        success: function(hasil) {

            console.log('hasil jam praktek')
            console.log(hasil)
                            $('#jampraktek').empty()

            hasil.forEach(jampraktek);
                        function jampraktek(praktek,index){
                            console.log("option"+praktek[waktu]);
                            $('#jampraktek').append(`<option value="${praktek[waktu]}">${praktek[waktu]}</option>`);

                        }
                        $.ajax({
                            url: base_url + '/SIKBREC/public/aReservasiPasienWalkin/shiftDokter',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                jam:$('#jampraktek').val()
                            },
                            success: function(result) {
                                console.log(result)
                            $('#shiftpraktek').empty()
                                $('#shiftpraktek').append(`<option value="${result.NamaSesion}">${result.NamaSesion}</option>`);
                                $('#new').val('New')
                                // hasil.forEach(shift);
                                // function shift(praktek,index){
                                // }
                            }
                        });

        }
    });

}
$('#btn_caridatamr').hide()
// $('#nomormr').on('change', function() {
//     //   alert( this.value );
//     if(this.value == 0 && NoMR.value!=''){
//         $('#nomormr').val(1)
//     }else if(this.value == 0){
//         // document.getElementByID('btn_caridatamr').style.visibility = 'hidden';
//         // document.getElementByID('btn_caridatamr')style.display = 'none';
//         // console.log(this.value)
//         $('#btn_caridatamr').hide()
//     }else{
//          $('#btn_caridatamr').show()
//     }
//     });
var carimedicalrecordpasien = document.getElementById('txSearchData')
function hari(tanggalhariini){
    var tanggallengkap = new String();
    var namahari = ("Minggu Senin Selasa Rabu Kamis Jumat Sabtu");
    namahari = namahari.split(" ");
    var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
    namabulan = namabulan.split(" ");
    var tgl = new Date(tanggalhariini);
    var hari = tgl.getDay();
    var tanggal = tgl.getDate();
    var bulan = tgl.getMonth();
    var tahun = tgl.getFullYear();
    tanggallengkap = namahari[hari];
    return tanggallengkap
}

function DataReservasiPasienbyID(id){  
   return  $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/DetailreservasiPasien',
        data: {
                ID:id,
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {
            // result = data
            console.log(data.response);
            getIDPenjamin(data.response.JenisPembayaran)
            setTimeout(() => {
                $('#penjamin').val(data.response.ID_Penjamin).trigger('change');
                poliklinik.value =  data.response.IdPoli
                
            }, 1000);
            MrExist.value = data.response.MrExist
            NoMR.value = data.response.NoMR
            NamaPasien.value = data.response.NamaPasien
            PasienAlamat.value = data.response.Alamat
            jeniskelamin.value = data.response.JenisKelamin
            PasienUsia.value = data.response.TglLahir
            Telephone.value = data.response.Telephone
            // pekerjaanpasien.value = data.response.ocupation
            

            nik.value = data.response.NoKTP
            Telephone.value = data.response.Telephone

            $("#Medrec_NoIdPengenal").val(data.response.ID_Card_number);
            $("#Medrec_Tpt_lahir").val(data.response.BirthPlace);
            $("#Medrec_Pekerjaan").val(data.response.Ocupation);
            $('#Medical_Provinsi').val(data.response.provinsi).trigger('change');
            $("#Medrec_Warganegara").val(data.response.Medrec_Warganegara);
            $("#Medical_Agama").val(data.response.Religion);
            $("#Medrec_statusNikah").val(data.response.StatusMenikah);
            $("#Medrec_Pendidikan").val(data.response.Education);
            $("#Medrec_NamaIbuKandung").val(data.response.Mother);
            $("#Medrec_Kodepos").val(data.response.kodepos);

            $("#Medrec_Bahasa").val(data.response.Bahasa);
            $("#Medrec_IdPengenal").val(data.response.Tipe_Idcard);
            $("#Medrec_Etnis").val(data.response.Etnis);
            showAlamat(data.response.provinsi,data.response.City,data.response.Kecamatan,data.response.Kelurahan);


            mobilephone.value = data.response.HP
            email.value = data.response.Email
            PasienNoBooking.value = data.response.NoBooking
            tglreservasi.value = data.response.ApmDate
            Keterangan.value = data.response.Description
            antrian.value = data.response.NoAntrianAll
            pembayaran.value = data.response.JenisPembayaran
            //penjamin.value = data.response.ID_Penjamin
            poliklinik.value = data.response.IdPoli
            idpoli = data.response.IdPoli
            reservasi = tglreservasi.value
            $("#dokter").empty();
            $('#dokter').append(`<option value="${data.response.DoctorID}">${data.response.First_Name}</option>`);
                shiftpraktek.value = data.response.JamPraktek
            NoMR.disabled=true
            MrExist.disabled = true
            disabledReservasi()
            //pembayaran.disabled = false;
            Keterangan.disabled = false
            //penjamin.disabled = false
        })
}

function disabledAll(){
MrExist.disabled = true
NoMR.disabled = true
NamaPasien.disabled = true
PasienAlamat.disabled = true
jeniskelamin.disabled = true
PasienUsia.disabled = true
umur.disabled = true
PasienPekerjaan.disabled = true
nik.disabled = true
Telephone.disabled = true
mobilephone.disabled = true
email.disabled = true
// pasienbooking.disabled = true
// pembayaran.disabled = true
// poliklinik.disabled = true
// tglreservasi.disabled = true
// antrian.disabled = true
// Keterangan.disabled = true
// dokter.disabled = true
// jampraktek.disabled = true
// shiftpraktek.disabled = true
// baru.disabled = true
}

function enabledAll(){
MrExist.disabled = false
NoMR.disabled = false
NamaPasien.disabled = false
PasienAlamat.disabled = false
jeniskelamin.disabled = false
PasienUsia.disabled = false
umur.disabled = false
PasienPekerjaan.disabled = false
nik.disabled = false
Telephone.disabled = false
mobilephone.disabled = false
email.disabled = false
PasienNoBooking.disabled = false
pembayaran.disabled = false
poliklinik.disabled = false
tglreservasi.disabled = false
antrian.disabled = false
Keterangan.disabled = false
dokter.disabled = false
jampraktek.disabled = false
shiftpraktek.disabled = false
baru.disabled = false
}
function disabledReservasi(){
    PasienNoBooking.disabled = true
    pembayaran.disabled = true
    dokter.disabled = true
    poliklinik.disabled = true
    jampraktek.disabled = true
    shiftpraktek.disabled= true
    Keterangan.disabled = true
    tglreservasi.disabled = true
    penjamin.disabled = true
    pembayaran.disabled = true
}

// async function jadwaldokter() {
   
//     try {
//       const datarerevasi = await DataReservasiPasienbyID(idpasien)
//       if(datarerevasi=='done'){

//           console.log(document.getElementById('tglreservasi').value)
//       }
//     //   $.ajax({
//     //     type: "POST",
//     //     url: base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/DaftarJadwalDokter',
//     //     data: {
//     //             hari:tglreservasi.value,
//     //             idpoli:poliklinik.value
//     //             },
//     //     dataType: "json",
//     //                     // encode: true,
//     //     }).done(function(data) {
//     //         // result = data
//     //         console.log(data.response);
//     //     })

//     } catch(err) {
//       console.log(err);
//     }
//   }
  
//   jadwaldokter();
function detailpasien(id){
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/pasiensudahpunyamr',
        data: {
                ID:id,
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {
            console.log(data.response.email) 
            NoMR.value = data.response.NoMR
            NamaPasien.value = data.response.PatientName
            PasienAlamat.value = data.response.Address
            PasienUsia.value = data.response.Date_of_birthx
            jeniskelamin.value = data.response.Gander
            umur.value = getAge(PasienUsia.value)
            PasienPekerjaan.value = data.response.Ocupation
            nik.value = data.response.ID_Card_number
            Telephone.value = data.response.homephone
            mobilephone.value = data.response.mobilephone
            email.value = data.response.email
            document.getElementById('btnModalSrcPasienClose').click();
            // disabledAll()
        });
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
function createReservasiWalkin(){
    // event.preventDefault();
    $(".preloader").fadeIn();
    var formData = {
        MrExist:$('#nomormr').val(),
        nomr:$('#Normpasien').val(),
        iduser:'',
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
        //shiftpraktek:$('#shiftpraktek option:selected').text(),
        shiftpraktek:$('#shiftpraktek').val(),
        PasienNoBooking:$('#PasienNoBooking').val(),
        PasienUsia: $('#umur').val(), 
        penjamin: $('#penjamin').val(), 

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
        Medrec_NamaIbuKandung:$('#Medrec_NamaIbuKandung').val(),
        //ID_JadwalDokter:$('#Medrec_NamaIbuKandung').val(),
        
        petugasbatal:'',
        ID_KontrolUlangEMR:$("#ID_KontrolUlangEMR").val(),
        // shiftpraktek:$('#shiftpraktek').val,
        
        BPJS_xNorujukan:$("#BPJS_xNorujukan").val(),
        BPJS_NoKartu:$("#BPJS_NoKartu").val(),
        BPJS_NoSEP:$("#BPJS_NoSEP").val(),
        BPJS_NoRencKontrol:$("#BPJS_NoRencKontrol").val()
    };

    $.ajax({
      type: "POST",
      url:  base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/createReservasinonWalkin',
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      console.log(data);
      if(data.statusmessage == 'success'){
        swal({
            title: "Data Berhasil Di Simpan",
            text: "NoBoking "+ data.response.NoBoking +", NoAntrian "+data.response.NoAntrianPoli+",Dokter "+data.response.First_Name,
        })
          clearform()
          $(".preloader").fadeOut();
         
      }else if(data.statusmessage =='warning'){
        swal({
            title: "Warning",
            //text: data.errorname+' '+data.errormessage,
            text: data.response.errorname,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
          $(".preloader").fadeOut();
      }else if(data.statusmessage =='updated'){
        swal({
            title: "Data Berhasil Di Update",
            text: data.response,
        })
          $(".preloader").fadeOut();
      }
      $(".preloader").fadeOut();
    });

}

$("#btnsimpan").click(function (e) {
    // console.log($("#frmSimpanTrsRegistrasi").serialize());
    // return false;
        e.preventDefault()
        // $('form#frmSimpanTrsRegistrasi').find('input').each(function(){
        //     if(!$(this).prop('required')){
        //         
        //         $('#nik').focus()
                
        //     } 

        // });
   // $(".preloader").fadeIn();
        // if($("#nomormr :selected").val()==""){
        //     $('#nomormr').focus()
        //     swal({
        //         title: "Warning",
        //         text: "Pilih sudah punya no mr atau belum",
        //         icon: "warning",
                
        //         })
        //     $(".preloader").fadeOut();
        // }

        //Cek jika ada data sosial yang kosong
        if ($("#Medical_Provinsi").val() == ''){
            swal({
                title: "Warning",
                text: "Data Pasien Tidak Lengkap ! Isi Terlebih Dahulu Data Sosial Pasien !",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    //$("#ModalInputMRBAru").modal('show');
                    const base_url = window.location.origin;
                    var str = btoa($("#Normpasien").val());
                    window.open(base_url + '/SIKBREC/public/aMedicalRecord/' + str , "_blank");
                } else {
                    //swal("Transaction Rollback !");
                }
            });
            return false;
        }

        if(NamaPasien.value==''){
            $('#PasienNama').focus()
            swal({
                title: "Warning",
                text: "Nama Pasien Tidak Adda",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if(PasienAlamat.value==''){
            $('#PasienAlamat').focus()
            swal({
                title: "Warning",
                text: "Alamat Pasien Tidak Adda",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if(jeniskelamin.value==''){
            $('#jeniskelamin').focus()
            swal({
                title: "Warning",
                text: "pilih Jenis Kelamin Terlebih dahulu",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if(PasienUsia.value==''){
            $('#PasienUsia').focus()
            swal({
                title: "Warning",
                text: "Tanggal Lahir Pasien Tidak Adda",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if(PasienPekerjaan.value==''){
            $('#PasienPekerjaan').focus()
            swal({
                title: "Warning",
                text: "Jika Pekerjaan Tidak Adda isi dengan (-)",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if(nik.value==''){
            $('#nik').focus()
            swal({
                title: "Warning",
                text: "NIK Harus Diisi !",
                icon: "warning",
                })
            $(".preloader").fadeOut();
        }else if(Telephone.value==''){
            $('#homephone').focus()
            swal({
                title: "Warning",
                text: "Jika Telepon Tidak Adda isi dengan (-)",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if(mobilephone.value==''){
            $('#mobilephone').focus()
            swal({
                title: "Warning",
                text: "Jika Ho HP Tidak Adda isi dengan (-)",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if($('#pembayaran').val()==''){
            $('#pembayaran').focus()
            swal({
                title: "Warning",
                text: "Pilih Pembayaran terlebih dahulu",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if($('#penjamin').val()==''){
            $('#penjamin').focus()
            swal({
                title: "Warning",
                text: "Pilih Penjamin terlebih dahulu",
                icon: "warning",
                })
            $(".preloader").fadeOut();
        }
        else if($('#poliklinik').val()==''){
            $('#poliklinik').focus()
            swal({
                title: "Warning",
                text: "Pilih Poliklinik terlebih dahulu",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if($('#tglreservasi').val()==''){
            $('#tglreservasi').focus()
            swal({
                title: "Warning",
                text: "Pilih tgl reservasi terlebih dahulu",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if($('#Keterangan').val()==''){
            $('#Keterangan').focus()
            swal({
                title: "Warning",
                text: "Isi Keterangan telebih dahulu",
                icon: "warning",
                

                })
            $(".preloader").fadeOut();
        }else if($('#dokter').val()==''){
            $('#dokter').focus()
            swal({
                title: "Warning",
                text: "Pilih Dokter terlebih dahulu",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if($('#jampraktek').val()==''){
            $('#jampraktek').focus()
            swal({
                title: "Warning",
                text: "Jam Praktek Dokter Tidak Adda",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }else if($('#shiftpraktek').val()==''){
            $('#shiftpraktek').focus()
            swal({
                title: "Warning",
                text: "Jam Praktek Dokter Tidak Adda",
                icon: "warning",
                

                
                })
            $(".preloader").fadeOut();
        }
        
        else{
            if($('#jampraktek').val()=='-'&& $('#jampraktek').val()==''){
                swal({
                    title: "Warning",
                    text: "Jam Praktek Dokter Tidak Adda",
                    icon: "warning",
                    

                    
                    })
                $(".preloader").fadeOut();
            }else{

                // cek apakah Poli nya sama engga dengan poli dari rujukan
                var akodepoliterpilihSimrs = document.getElementById("kodepoliterpilihSimrs").value;
                var aBPJS_xKodePoliRujukan = document.getElementById("BPJS_xKodePoliRujukan").value;

                if(akodepoliterpilihSimrs == aBPJS_xKodePoliRujukan){
                    // jika sama
                    swal({
                        title: "Simpan",
                        text: "Apakah Anda ingin Simpan Rencana Kontrol ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            goCreateKontrolUlang_EMR();
                            // if ($("#penjamin").val() == '313'){
                            //     goCreateRencanaKontrol()
                            // }else{
                            //     createReservasiWalkin();
                            // }
                        } else {
                            swal("Transaction Rollback !");
                        }
                        });
                }else{
                    // jika beda
                    swal({
                        title: "Simpan",
                        text: "Poli Rujukan berbeda dengan Poli yang Pilih. Lanjutkan Transaksi ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            goCreateKontrolUlang_EMR();
                            // if ($("#penjamin").val() == '313'){
                            //     goCreateRencanaKontrol()
                            // }else{
                            //     createReservasiWalkin();
                            // }
                        } else {
                            swal("Transaction Rollback !");
                        }
                        });
                }
                
            }
        }

       
       
        $(".preloader").fadeOut();
  });
function getDataReservasiWalkin(){
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/datareservasi',
        data: {
            tgl_awal:$('#tglawal_Search').val(),
            tgl_akhir:$('#tglakhir_Search').val(),
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {
            console.log(data) 
            $('#datareservasi').empty()
            data.response.forEach(reservasi);
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

$('#poliklinik').on('change', function() {
    tglreservasi.value=''
})

async function getJamPraktek(param) {
    try{
        const datagetSessionDokter = await getSessionDokter(param);
        updateUIgetSessionDokter(datagetSessionDokter);
    } catch (err) {
        toast(err, "error")
    }
}


            function updateUIgetSessionDokter(datagetSessionDokter) {
                let responseApi = datagetSessionDokter;
                if (responseApi.data !== null && responseApi.data !== undefined) {
                    $("#jampraktek").empty();
                    $("#NamaSesionPraktek").val('');
                    var newRow = '<option value="">-- PILIH --</option';
                    $("#jampraktek").append(newRow);
                    for (i = 0; i < responseApi.data.length; i++) {
                        var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].HariWaktu + '</option';
                        $("#jampraktek").append(newRow);
                    }
                }
            }
            
            function getSessionDokter(IDDokter) {
                var id = $("[name='tglreservasi']").val(); 
                //var IdDokter = $("#dokterid").val();
                var penjamin = $("#penjamin").val();
                var pembayaran = $("#pembayaran").val();

                if (pembayaran == '5' && penjamin == '313'){
                    var groupjadwal = '1';
                }else{
                    var groupjadwal = '2';
                }
                var weekday = new Array(7);
                weekday[0] = "Minggu";
                weekday[1] = "Senin";
                weekday[2] = "Selasa";
                weekday[3] = "Rabu";
                weekday[4] = "Kamis";
                weekday[5] = "Jumat";
                weekday[6] = "Sabtu";
                var dx = new Date(id);
                var n = weekday[dx.getDay()];
                console.log(n,'hariii')
                var Poliklinik = $("[name='poliklinik']").val();
            
                var base_url = window.location.origin;
                let url = base_url + '/SIKBREC/public/MasterDataJadwalDokter/getSessionDokter';
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                    },
                    body: 'hari=' + n + "&idlayanan=" + Poliklinik + "&iddokter=" + IDDokter + "&groupjadwal=" + groupjadwal
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
                       // $("#caramasuk").select2();
                    })
            }

            async function GetSession(param) {
                try{
                   //var idjampraktek = $(param).val();
                    const datagetNamaSessionDokter = await getNamaSessionDokter(param);
                    updateUIgetNamaSessionDokter(datagetNamaSessionDokter);
                } catch (err) {
                    toast(err, "error")
                }
            }
            
            function updateUIgetNamaSessionDokter(datagetNamaSessionDokter) {
                let responseApi = datagetNamaSessionDokter;
                $("#shiftpraktek").val(responseApi.NamaSesion);
                $('#new').val('New');
            }
            
            function getNamaSessionDokter(idjampraktek) {
            
                var id = $("[name='tglreservasi']").val(); 
                var weekday = new Array(7);
                weekday[0] = "Minggu_Sesion";
                weekday[1] = "Senin_Sesion";
                weekday[2] = "Selasa_Sesion";
                weekday[3] = "Rabu_Sesion";
                weekday[4] = "Kamis_Sesion";
                weekday[5] = "Jumat_Sesion";
                weekday[6] = "Sabtu_Sesion";
                var dx = new Date(id);
                var n = weekday[dx.getDay()];
            
                var base_url = window.location.origin;
                let url = base_url + '/SIKBREC/public/MasterDataJadwalDokter/getNamaSessionDokter';
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                    },
                    body: 'hari=' + n + "&idjampraktek=" + idjampraktek
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
                       // $("#caramasuk").select2();
                    })
            }



function clearform(){
    document.getElementById("frmSimpanTrsRegistrasi").reset();
    $('#jampraktek').empty()
    $('#dokter').empty()
    $('#shiftpraktek').empty()
    $('#shiftpraktek').append(`<option value="">--pilih--</option>`)
    $('#jampraktek').append(`<option value="">--pilih--</option>`)
    $('#dokter').append(`<option value="">--pilih--</option>`)
    
    tglreservasi.disabled = true
}
async function getDataReservasiWalkinbyid(id){
    $.ajax({
        type: "POST",
        url: base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/Reservasibyid',
        data: {
                ID:id
                },
        dataType: "json",
                        // encode: true,
        }).done(function(data) {

            getIDPenjamin(data.JenisPembayaran)
            setTimeout(() => {
                $('#penjamin').val(data.ID_Penjamin).trigger('change');
                poliklinik.value =  data.IdPoli
                
            }, 1000);

            console.log(data)
            MrExist.value = data.MrExist
            NoMR.value = data.NoMR
            NamaPasien.value = data.NamaPasien
            PasienAlamat.value = data.Alamat
            PasienUsia.value = data.TglLahir
            jeniskelamin.value = data.JenisKelamin
            umur.value = getAge(PasienUsia.value)
            // pekerjaanpasien.value = data.Ocupation
            if(data.Ocupation==null){
                PasienPekerjaan.value='-'
            }else{
                PasienPekerjaan.value = data.Ocupation
            }
            nik.value = data.NoKTP
            Telephone.value = data.Telephone
            mobilephone.value = data.HP
            email.value = data.Email
            poliklinik.value =  data.IdPoli
            PasienNoBooking.value = data.NoBooking
            pembayaran.value = data.JenisPembayaran
            tglreservasi.value = data.ApmDate
            Keterangan.value = data.Description
            dokter.value = data.DoctorID
            antrian.value = data.NoAntrianAll

            
            //console.log(data.ID_Penjamin,'fffffffffff');
            //loadPenjamin(ID_Penjamin);
            //$("#penjamin").val(data.ID_Penjamin).trigger('change');
            

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
            
            // pasienbooking.disabled = true
            // jampraktek = data.JamPraktek
            // shiftpraktek = 
            $('#dokter').empty()
            $('#shiftpraktek').empty()
            $('#dokter').append(`<option value="${data.DoctorID}">${data.First_Name}</option>`);
            $('#shiftpraktek').append(`<option value="${data.JamPraktek}">${data.JamPraktek}</option>`);
            $('#new').val('New')
            document.getElementById('btnModalSrcReservasi').click();
            disabledReservasi()
            // disableformreservasipasien()
           // pembayaran.disabled = false
            Keterangan.disabled = false
            //penjamin.disabled = false
            email.disabled = false
            PasienUsia.disabled = false
            var tanggallengkap = new String();
            var namahari = ("Minggu Senin Selasa Rabu Kamis Jumat Sabtu");
            namahari = namahari.split(" ");
            var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
            namabulan = namabulan.split(" ");
            var tgl = new Date(tglreservasi.value);
            var hari = tgl.getDay();
            var tanggal = tgl.getDate();
            var bulan = tgl.getMonth();
            var tahun = tgl.getFullYear();
            tanggallengkap = namahari[hari];
            var jamdokter = tanggallengkap+'_Waktu';
            console.log(tanggallengkap+'_Waktu')
                            $('#jampraktek').empty()
                            // $('#jampraktek').append('<option value=>-Pilih Jam Praktek-</option>');

                            if (data.ID_JadwalPraktek == null || data.ID_JadwalPraktek == ''){
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
                                        $('#jampraktek').empty()
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
                                            //$('#shiftpraktek').append(`<option value="${hasil.NamaSesion}">${hasil.NamaSesion}</option>`);
                                            $('#shiftpraktek').val(hasil.NamaSesion);
                                            $('#new').val('New')
                                            // hasil.forEach(shift);
                                            // function shift(praktek,index){
                                            // }
                                        }
                                    });
                                }
                            });
                        }else{
                            loadJamPraktek(data.DoctorID,data.ID_JadwalPraktek)
                        }
        });
}

async function loadJamPraktek(DoctorID,ID_JadwalPraktek) {
    await getJamPraktek(DoctorID);
    await GetSession(ID_JadwalPraktek);
    $("#jampraktek").val(ID_JadwalPraktek);

}

// async function loadPenjamin(ID_Penjamin) {
//     await getIDPenjamin(ID_Penjamin);
//     $("#penjamin").val(data.ID_Penjamin).trigger('change');
// }
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
              url:  base_url + '/SIKBREC/public/aReservasiPasiennonWalkin/batalReservasiWalkin',
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
function getNobokingalasan(){
    let pasienbooking = $('#PasienNoBooking').val()
    let alasanbatal = $('#alasanbatal').val()
    noregbatal.value = $('#PasienNoBooking').val()
}

function umurpasien(e){
    umur.value=getAge(e.target.value)
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

async function getIDPenjamin(x) {
    try {
        const datagetNamaPenjamin = await getNamaPenjamin(x);
        updateUIgetNamaPenjamin(datagetNamaPenjamin);
    } catch (err) {
        toast(err, "error")
    }
    }
    
    function updateUIgetNamaPenjamin(datagetNamaPenjamin) {
    let responseApi = datagetNamaPenjamin; 
    if (responseApi.data !== null && responseApi.data !== undefined) {
        //console.log(responseApi.data);
        $("#penjamin").empty();
        if (responseApi.data[0].ID != '315'){
            var newRow = '<option value="">-- PILIH --</option';
        }
        $("#penjamin").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaPerusahaan + '</option';
            $("#penjamin").append(newRow);
        }
    }
    }
    
    function getNamaPenjamin(x) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aReservasipasiennonWalkin/getNamaPenjamin';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'tp_penjamin=' + x//$("#TipePenjamin").val()
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
            $("#penjamin").select2();
        })
    }
    function searchsep(){
        var base_url = window.location.origin;
        window.open(base_url + "/SIKBREC/public/xBPJSBridging/MonitoringHistoriPelayananBPJS/", "_blank" );
    }
    function updateUIdatasetDataSEPRujukanByID(datasetDataSEPRujukanByID) {
        
        let data = datasetDataSEPRujukanByID.hasil;
        $("#BPJS_NoSEP").val(data.noSep);
        $("#BPJS_NoKartu").val(data.peserta.noKartu);
        $("#BPJS_Diagnosa").val(data.diagnosa);
        $("#SIMRS_JENIS_SEP").val(data.jnsPelayanan);
        $("#BPJS_xNorujukan").val(data.provPerujuk.noRujukan);
        $("#JenisRujukanFaskesBPJSx").val(data.provPerujuk.asalRujukan);
        $("#polisaatini").val(data.poli);

          
        if (data.provPerujuk.asalRujukan == "1") {
            $('#JenisRujukanFaskesBPJSxName').val("Faskes 1");
        } else {
            $('#JenisRujukanFaskesBPJSxName').val("Faskes 2");
        }

        
    }

    function setDataSEPRujukanByID() {
     
        var base_url = window.location.origin;
        var BPJS_NoSEP = $("#BPJS_NoSEP").val();
        let url = base_url + '/SIKBREC/public/aKontrolUlang/setDataSEPRujukanByID/';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'BPJS_NoSEP=' + BPJS_NoSEP
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            })
            .then(response => {
                //console.log(response)
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
                //$("#TipePenjamin").select2();
                //$("#JenisRawat").select2();
                //$("#Paket").select2();
                // $(".preloader").fadeOut(); 
            }).catch((err) => {
                swal("Oops", "Sorry... " + err, "error");
            })
    }
    async function goCreateRencanaKontrol_nonMobileJkn() {
        try {
            $(".preloader").fadeIn();
            console.log("xxx")
            const dataCreateRencanaKontrol = await CreateRencanaKontrolNonJKN();
            updateUICreateRencanaKontrolNonMobileJKN(dataCreateRencanaKontrol);
            $(".preloader").fadeOut();
        } catch (err) {
            swal("Oops", "Sorry... " + err, "error");
            $(".preloader").fadeOut();
        }
    }
    function updateUICreateRencanaKontrolNonMobileJKN(params) {
        $('#BPJS_NoRencKontrol').val(params.hasil); 
        var Noregisrrasi  = $('#SIMRS_Registrasi').val(); 
       
            swal("Success", "Rencana Kontrol BPJS Kesehatan Berhasil Dibuat !. Pasien Akan Dilanjutkan Daftar Reservasi SIMRS. ", "success")
            .then((value) => { 
                createReservasiWalkin(); 
                //MyBack();
            }); 
        
        $('#notif_Cetak').modal('show');
        
    }
    function CreateRencanaKontrolNonJKN() {
        var base_url = window.location.origin;
        var JnsKontrol = $("#BPJS_KodeJenisKontrol").val();
        var nomor = $("#BPJS_NoKartu").val();
        var TglRegIGD = $("#SIMRS_TglBerobat").val();
        var TglRencanaKontrol = $("#tglreservasi").val();
        var KodePoliklinikBPJS = $("#poliklinik").val();
        var KodeDokterBPJS = $("#dokter").val();
        var SPRI_NoSPR2 = '';
        var SPRI_NoSPR2BPJS = '';
        var SPRI_NoSEP = $("#BPJS_NoSEP").val();
        var NamaPoliklinikBPJS = $('#poliklinik option:selected').text();
        var NamaDokterBPJS = $('#dokter option:selected').text();
        var SIMRS_JENIS_SEP = $("#SIMRS_JENIS_SEP").val();
        var SIMRS_Registrasi = $("#SIMRS_Registrasi").val();
        var jenisTrs = "Insert";
        let url = base_url + '/SIKBREC/public/aKontrolUlang/CreateKontrolUlang_2';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'JnsKontrol=' + JnsKontrol + '&nomor=' + nomor + '&TglRencanaKontrol=' + TglRencanaKontrol
                + '&KodePoliklinikBPJS=' + KodePoliklinikBPJS + '&KodeDokterBPJS=' + KodeDokterBPJS
                + '&SPRI_NoSPR2=' + SPRI_NoSPR2
                + '&jenisTrs=' + jenisTrs
                + '&TglRegIGD=' + TglRegIGD 
                + '&NamaPoliklinikBPJS=' + NamaPoliklinikBPJS 
                + '&NamaDokterBPJS=' + NamaDokterBPJS
                + '&SPRI_NoSPR2BPJS=' + SPRI_NoSPR2BPJS
                + '&SPRI_NoSEP=' + SPRI_NoSEP
                + '&SIMRS_JENIS_SEP=' + SIMRS_JENIS_SEP
                + '&SIMRS_Registrasi=' + SIMRS_Registrasi 
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
                //$("#cariDokterBPJS").select2();
            $(".preloader").fadeOut();
            })
    }
    async function goCreateRencanaKontrol() {
        try {
            $(".preloader").fadeIn();
            const dataCreateRencanaKontrol = await CreateRencanaKontrol();
            updateUICreateRencanaKontrol(dataCreateRencanaKontrol);
            $(".preloader").fadeOut();
        } catch (err) {
            swal("Oops", "Sorry... " + err, "error");
            $(".preloader").fadeOut();
        }
    }
    function updateUICreateRencanaKontrol(params) {
        $('#BPJS_NoRencKontrol').val(params.hasil); 
        var Noregisrrasi  = $('#SIMRS_Registrasi').val(); 
        if(Noregisrrasi.substring(0,2) == "RI" ){
            createReservasiWalkin();
        }else{

            swal("Success", "Rencana Kontrol BPJS Kesehatan Berhasil Dibuat !. Gunakan Mobile JKN untuk Melakukan Reservasi Mandiri Pasien. ", "success")
            .then((value) => {
                // di tutup untuk 1 januari 2023
                // createReservasiWalkin(); 
                MyBack();
            });
        }
        $('#notif_Cetak').modal('show');
        
    }
    function CreateRencanaKontrol() {
        var base_url = window.location.origin;
        var JnsKontrol = $("#BPJS_KodeJenisKontrol").val();
        var nomor = $("#BPJS_NoKartu").val();
        var TglRegIGD = $("#SIMRS_TglBerobat").val();
        var TglRencanaKontrol = $("#tglreservasi").val();
        var KodePoliklinikBPJS = $("#poliklinik").val();
        var KodeDokterBPJS = $("#dokter").val();
        var SPRI_NoSPR2 = '';
        var SPRI_NoSPR2BPJS = '';
        var SPRI_NoSEP = $("#BPJS_NoSEP").val();
        var NamaPoliklinikBPJS = $('#poliklinik option:selected').text();
        var NamaDokterBPJS = $('#dokter option:selected').text();
        var SIMRS_JENIS_SEP = $("#SIMRS_JENIS_SEP").val();
        var SIMRS_Registrasi = $("#SIMRS_Registrasi").val();
        var jenisTrs = "Insert";
        let url = base_url + '/SIKBREC/public/aKontrolUlang/CreateKontrolUlang_2';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'JnsKontrol=' + JnsKontrol + '&nomor=' + nomor + '&TglRencanaKontrol=' + TglRencanaKontrol
                + '&KodePoliklinikBPJS=' + KodePoliklinikBPJS + '&KodeDokterBPJS=' + KodeDokterBPJS
                + '&SPRI_NoSPR2=' + SPRI_NoSPR2
                + '&jenisTrs=' + jenisTrs
                + '&TglRegIGD=' + TglRegIGD 
                + '&NamaPoliklinikBPJS=' + NamaPoliklinikBPJS 
                + '&NamaDokterBPJS=' + NamaDokterBPJS
                + '&SPRI_NoSPR2BPJS=' + SPRI_NoSPR2BPJS
                + '&SPRI_NoSEP=' + SPRI_NoSEP
                + '&SIMRS_JENIS_SEP=' + SIMRS_JENIS_SEP
                + '&SIMRS_Registrasi=' + SIMRS_Registrasi 
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
                //$("#cariDokterBPJS").select2();
                $(".preloader").fadeOut(); 
            })
    }
function closemodalSyarat(){
    $('#notif_Cetak_peringatan').modal('hide');
}
function checkTrue(){
     // Get the checkbox
     var checkBox = document.getElementById("checkboxSyarat");
    
     if (checkBox.checked == true){
         document.getElementById("btnCloseModalSyarat").disabled = false;
     } else {
        document.getElementById("btnCloseModalSyarat").disabled = true;
     }
}
    function toast(data, status) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr[status](data);
    }


    async function goCreateKontrolUlang_EMR() {
        try {
            const data = await CreateKontrolUlang_EMR();
            updateUIdataCreateKontrolUlang_EMR(data);
        } catch (err) {
            toast(err.message, "error")
        }
    }
    
    function updateUIdataCreateKontrolUlang_EMR(params) {
        let response = params;
        //console.log(response);
        $(".preloader").fadeOut();
        
        if(response.status == 'success'){
            toast(response.message, 'success')
            $("#ID_KontrolUlangEMR").val(response.ID_KontrolUlangEMR);
            var jenisRawat = document.getElementById("SIMRS_JENIS_SEP").value;
            if ($("#penjamin").val() == '313'){
                // disini cek dulu atau kasih pesan apa dia punya mobile jkn atau tidak.
                //-----SIGNUP
                swal({
                    title: "Konfirmasi Penggunaan Mobile JKN",
                    text: "Pastikan Pasien memiliki Handphone dan sudah Download Aplikasi Mobile JKN untuk Proses Ambil antrian / Booking dengan Aplikasi Mobile JKN secara Mandiri. Apakah Pasien sudah Download Aplikasi Mobile JKN dan Handphone support ?",
                    icon: "info",
                    buttons: ['Tidak, Sistem Akan Mendaftarkan Surat Kontrol BPJS dan Reservasi.', "Ya, Sudah Punya ( Bikin Rencana Kontrol saja, Reservasi Via Mobile JKN )"],
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                })
                    .then((willDelete) => {
                        if (willDelete) { 
                            console.log("YA")
                            if(jenisRawat == "Rawat Jalan"){
                                var akodepoliterpilihSimrs = document.getElementById("kodepoliterpilihSimrs").value;
                                var aBPJS_xKodePoliRujukan = document.getElementById("BPJS_xKodePoliRujukan").value;
                                if(akodepoliterpilihSimrs == aBPJS_xKodePoliRujukan){
                                    goCreateRencanaKontrol();
                                    console.log("ada jkn mobile, Poli sama")
                                }else{
                                    createReservasiWalkin();
                                    console.log("ada jkn mobile, Poli Beda")
                                }
                            }else{  // rawat inap
                                goCreateRencanaKontrol_nonMobileJkn();
                            } 
                        } else {
                            console.log("NO")
                            if(jenisRawat == "Rawat Jalan"){
                                var akodepoliterpilihSimrs = document.getElementById("kodepoliterpilihSimrs").value;
                                var aBPJS_xKodePoliRujukan = document.getElementById("BPJS_xKodePoliRujukan").value;
                                if(akodepoliterpilihSimrs == aBPJS_xKodePoliRujukan){
                                    goCreateRencanaKontrol_nonMobileJkn();
                                    console.log("tidak ada jkn mobile, Poli sama")
                                }else{
                                    createReservasiWalkin();
                                    console.log("tidak ada jkn mobile, Poli Beda")
                                }
                            }else{  // rawat inap
                                 goCreateRencanaKontrol_nonMobileJkn();
                            }  
                        }
                    });
                    //-#END SIGNUP 
                }else{
                createReservasiWalkin();
            }
        }else{
            toast('error','error')
        }
    
    }
    function CreateKontrolUlang_EMR() {
        var base_url = window.location.origin;
            var nomr = $('#Normpasien').val();
            var iduser = '';
            var idpoliklinik = $('#poliklinik').val();
            var namapoliklinik = $('#poliklinik option:selected').text();
            var tglreservasi = $('#tglreservasi').val();
            var Keterangan = $('#Keterangan').val();
            var iddokter = $('#dokter').val();
            var namadokter = $('#dokter option:selected').text();
            var jampraktek = $('#jampraktek').val();
            var SIMRS_Registrasi = $("#SIMRS_Registrasi").val();
        let url = base_url + '/SIKBREC/public/aKontrolUlang/CreateKontrolUlang_EMR';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: "nomr="+nomr+ 
                    "&iduser="+iduser+
                    "&idpoliklinik="+idpoliklinik+
                    "&namapoliklinik="+namapoliklinik+
                    "&tglreservasi="+tglreservasi+
                    "&Keterangan="+Keterangan+
                    "&iddokter="+iddokter+
                    "&namadokter="+namadokter+
                    "&jampraktek="+jampraktek+
                    "&SIMRS_Registrasi="+SIMRS_Registrasi
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
                $(".preloader").fadeOut();
    
            })
    }

    async function getDataPoliklinikSearch(){
        try{
            var xdi = document.getElementById("poliklinik").value;
            const dataGetNamaPoli = await getNamaPoliShow(xdi);
            updateUIgetNamaPoliShow(dataGetNamaPoli);
            console.log("show poli ", dataGetNamaPoli);
        } catch (err) {
            toast(err, "error")
        }
    }
    function updateUIgetNamaPoliShow(dataGetNamaPoli) {
        let responseApi = dataGetNamaPoli;
        $("#kodepoliterpilihSimrs").val(responseApi.data.codeBPJS);
        $("#namapoliterpilihSimrs").val(responseApi.data.NamaBPJS);
    } 
    function getNamaPoliShow(idPoliKlinik) {  
        var getidPoliKlinik = idPoliKlinik;
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/MasterDataUnit/getUnitId';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'id=' + getidPoliKlinik 
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
                $("#poliklinik").select2();
            })
    }



    async function ShowRencanaKontrol(){
        $('#myModalLihatRencanaKontrol').modal('show');
        
        try{
            var noRegistrasi = document.getElementById("SIMRS_Registrasi").value;
            // console.log(noRegistrasi);
            const dataGetRencanaKontrolJKN = await getRencanaKontrolJKN(noRegistrasi);
            console.log(dataGetRencanaKontrolJKN);
            updateUIgetRencanaKontrolJKN(dataGetRencanaKontrolJKN);
            // console.log("show poli ", dataGetNamaPoli);
        } catch (err) {
            toast(err, "error")
        }
    }
    function updateUIgetRencanaKontrolJKN(data) {
        let responseApi = data;

        $("#lihatid").val(responseApi.data.ID)
        idheader = responseApi.data.ID;
        // $("#").val(responseApi.data.NoRegistrasi)
        // $("#").val(responseApi.data.NoEpisode)
        $("#lihatNoMR").val(responseApi.data.NoMR)
        $("#lihatNama").val(responseApi.data.NamaPasien)
        // $("#").val(responseApi.data.NoSEP)
        $("#lihatTglSurat").val(responseApi.data.Tgl_SuratRujukan)
        $("#lihatDiagnosa").val(responseApi.data.Diagnosa)
        $("#lihatTerapi").val(responseApi.data.Terapi)
        $("#lihatAlasan_BelumDapat1").val(responseApi.data.is_belum_kembali)
        $("#lihatAlasan_TidakLanjut1").val(responseApi.data.Tindak_Lanjut)
        // $("#cekKonsulSelesai").val(responseApi.data.is_konsul_selesai)
        // responseApi.data.is_konsul_selesai = '1';
        if (responseApi.data.is_konsul_selesai == '1'){
            $("#cekKonsulSelesai").prop('checked',true);
            myFunctionKelasEksekutif();
        }
        $("#lihatTglTTD").val(responseApi.data.datecreate)

        var signature = responseApi.data.sign_dokter;
        // var signature2 = "https://hastaprakarsa.co.id/wp-content/uploads/2020/02/tanda-tangan-mujiono.png";
        // // console.log(signature);
        // console.log(signature2);
        document.getElementById('dokterSignature').src = signature ;
        // $("#").val(responseApi.data.sign_dokter)

        showTableLihatKontrolJKN(idheader)
    } 
    function getRencanaKontrolJKN(noRegistrasi) {
        // /aKontrolUlang/PrintRencanaKontrol/"
        var base_url = window.location.origin;
        let url = base_url + '/SIKBREC/public/aKontrolUlang/SuratKeteranganKontrolJKN';
        return fetch(url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'noRegistrasi=' + noRegistrasi 
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
                // $("#poliklinik").val();
                $("").val();
            })
    }

    // async function showTableLihatKontrolJKNx(idheader){
    // //    console.log(idheader);
    // //     return false;
    //     try{
    //         var idhdr = idheader;
    //         // console.log(noRegistrasi);
    //         const datagetTableLihatKontrolJKN = await getTableLihatKontrolJKN(idhdr);
    //         console.log(datagetTableLihatKontrolJKN);
    //         showdatagetTableLihatKontrolJKN(datagetTableLihatKontrolJKN);
    //         // console.log("show poli ", dataGetNamaPoli);
    //     } catch (err) {
    //         toast(err, "error")
    //     }
    // }
    // function getTableLihatKontrolJKN(idhdr) {
    //     // /aKontrolUlang/PrintRencanaKontrol/"
    //     var base_url = window.location.origin;
    //     let url = base_url + '/SIKBREC/public/aKontrolUlang/TableKeteranganKontrolJKN';
    //     return fetch(url, {
    //         method: 'POST',
    //         headers: {
    //             "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    //         },
    //         body: 'idhdr=' + idhdr 
    //     })
    //         .then(response => {
    //             if (!response.ok) {
    //                 throw new Error(response.statusText)
    //             }
    //             return response.json();
    //         })
    //         .then(response => {
    //             if (response.status === "error") {
    //                 throw new Error(response.message.errorInfo[2]);
    //                 // console.log("ok " + response.message.errorInfo[2])
    //             } else if (response.status === "warning") {
    //                 throw new Error(response.errorname);
    //                 // console.log("ok " + response.message.errorInfo[2])
    //             }
    //             return response
    //         })
    //         .finally(() => {
    //             // $("#poliklinik").val();
    //             $("").val();
    //         })
    // }

    function showTableLihatKontrolJKN(idheader) {
        const base_url = window.location.origin;
        var idheader = idheader;
        $(".preloader").fadeOut();
        $('#table-load-data-kontrol').dataTable({
            "bDestroy": true
        }).fnDestroy();
        $('#table-load-data-kontrol').DataTable({ 
        
        "ordering": true,
        "searching": false,
        "ajax": {
            "url": base_url + "/SIKBREC/public/aKontrolUlang/TableKeteranganKontrolJKN",
            "dataSrc": "",
            "deferRender": true,
            "type": "POST",
            data: function (d) {
                d.idheader = idheader;
                                // d.custom = $('#myInput').val();
            }
        },
        // console.log(row.ID);

        "columns": [
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.ID + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Tgl_Kontrol + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Poli + ' </font>  ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="1"> ' + row.Keterangan + ' </font>  ';
                    return html
                }
            },
            // { "data": "ID"},
            // // { "data": "ID_HDR" },
            // { "data": "Tgl_Kontrol" },
            // { "data": "Poli" },
            // { "data": "Keterangan" },
        ]
        
        });

        
    } 