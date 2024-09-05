$(document).ready(function () {
    asyncShowMain();
    GetdataEdukasi();  
    $(".preloader").fadeOut(); 
       
    $(document).on('click', '#btnSave', function () {
        //checking before get data
        CheckVar();
        input();
        
    });
//     $(document).on('click', '#tandatangan', function (){
//         input();
// });
});
function CheckVar (){
    //if not in creteria return false
    if ($("#TinggalBersama").val() == ''){
        toast ('Tinggal Bersama Harap Diisi', "warning");
        return false;
    }
    if ($("#Bahasa").val() == ''){
        toast ('Bahasa Harap Diisi', "warning");
        return false;
    } 
    if ($("#Hambatan").val() == ''){
        toast ('Hambatan Harap Diisi', "warning");
        return false;
    }
    if ($("#KemampuanSolat").val() == ''){
        toast ('Kemampuan Solat Harap Diisi', "warning");
        return false;
    }if ($("#KemampuanMembacaAl_Quran").val() == ''){
        toast ('KemampuanMembacaAl_Quran Harap Diisi', "warning");
        return false;
    }
    if ($("#EdukasiDiberikanKepada").val() == ''){
        toast ('EdukasiDiberikanKepada Harap Diisi', "warning");
        return false;
    }
    if ($("#KemampuanBahasa").val() == ''){
        toast ('KemampuanBahasa Harap Diisi', "warning");
        return false;
    }
    if ($("#PerluPenerjemah").val() == ''){
        toast ('PerluPenerjemah Harap Diisi', "warning");
        return false;
    }
    if ($("#BacadanTulis").val() == ''){
        toast ('BacadanTulis Harap Diisi', "warning");
        return false;
    }
    if ($("#Kepercayaanlainya").val() == ''){
        toast ('Kepercayaanlainya Harap Diisi', "warning");
        return false;
    }
    if ($("#Kesediaan_Menerima_Edukasi").val() == ''){
        toast ('Kesediaan_Menerima_Edukasi Harap Diisi', "warning");
        return false;
    }
        if ($("#CaraEdukasi").val() == ''){
        toast ('CaraEdukasi Harap Diisi', "warning");
        return false;
    }
    if ($("#KebutuhanEdukasi").val() == ''){
        toast ('KebutuhanEdukasi Harap Diisi', "warning");
        return false;
    }
    if ($("#KebutuhanEdukasiIslami").val() == ''){
        toast ('KebutuhanEdukasiIslami Harap Diisi', "warning");
        return false;
    }
    //getInsert();
    goInsert();
}

async function goInsert() {
    try {
        const dataCreateData = await CreateData();
        updateUIdataCreateData(dataCreateData);
    } catch (err) {
        toast(err.message, "error")
    }
}
function updateUIdataCreateData(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
       
    }else{
        toast(response.message, "error")
    }  

}
function CreateData() {
    var str = $("#formdata").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/form/getInsert';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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

        })
}

async function asyncShowMain() {
    try {
        // await getHakAksesByForm(18);
        const datagetDataPasien = await getDataPasien();
        //console.log(datagetDataPasien)
        updateUIdataGetregistrasiRajalbyId(datagetDataPasien);
        // showdatatabel();
        
    } catch (err) {
        toast(err, "error")
    }
}

//
async function updateUIdataGetregistrasiRajalbyId(params) {
    let data = params;
    $("#NamaPasien").val(data.PatientName);
    $("#NoMR").val(data.NoMR);
    $("#NoEpisode").val(data.NoEpisode);
    
    $("#Tgl_Lahir").val(data.Date_of_birth);
    $("#PoliTujuan").val(data.LokasiPasien);
    $("#Tanggal").val(data.VisitDate);
    $("#NoRegistrasi").val(data.NoRegistrasi);
    $("#TinggalBersama").val(data.TinggalBersama);
    $("#Bahasa").val(data.Bahasa);
    $("#Hambatan").val(data.Hambatan);
    $("#KemampuanSolat").val(data.KemampuanSolat);
    $("#KemampuanMembacaAl_Quran").val(data.KemampuanMembacaAl_Quran);
    $("#EdukasiDiberikanKepada").val(data.EdukasiDiberikanKepada);
    $("#KemampuanBahasa").val(data.KemampuanBahasa);
    $("#PerluPenerjemah").val(data.PerluPenerjemah);
    $("#BacadanTulis").val(data.BacadanTulis);
    $("#Kepercayaanlainya").val(data.Kepercayaanlainya);
    $("#KesediaanMenerimaEdukasi").val(data.KesediaanMenerimaEdukasi);
    $("#CaraEdukasi").val(data.CaraEdukasi);
    $("#KebutuhanEdukasi").val(data.KebutuhanEdukasi);
    $("#KebutuhanEdukasiIslami").val(data.KebutuhanEdukasiIslami);

}
function getDataPasien() {
    var IdRegistrasi = document.getElementById("IdRegistrasi").value;
    // var iswalkin = $("#iswalkin").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aRegistrasiRajal/GetregistrasiRajalbyID';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IdRegistrasi=' + IdRegistrasi 
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
            $("#GruptarifKarcis").select2();
            $("#StatusKarcis").select2();
        })
}
//
async function GetdataEdukasi() {
    try {
        await getHakAksesByForm(18);
        const datagetDataPasienEdukasi = await getDataPasienEdukasi();
        //console.log(datagetDataPasien)
        updateUIdataGetDatadataEdukasi(datagetDataPasienEdukasi);
        // showdatatabel();
    } catch (err) {
        toast(err, "error")
    }
}

//
async function updateUIdataGetDatadataEdukasi(params) {
    let data = params;
    // $("#NamaPasien").val(data.PatientName);
    // $("#NoMR").val(data.NoMR);
    // $("#NoEpisode").val(data.NoEpisode);
    
    // $("#Tgl_Lahir").val(data.Date_of_birth);
    // $("#PoliTujuan").val(data.LokasiPasien);
    // $("#Tanggal").val(data.VisitDate);
    // $("#NoRegistrasi").val(data.NoRegistrasi);
    
    $("#TinggalBersama").val(data.TinggalBersama);
    $("#Bahasa").val(data.Bahasa);
    $("#Hambatan").val(data.Hambatan);
    $("#KemampuanSolat").val(data.KemampuanSolat);
    $("#KemampuanMembacaAl_Quran").val(data.KemampuanMembacaAl_Quran);
    $("#EdukasiDiberikanKepada").val(data.EdukasiDiberikanKepada);
    $("#KemampuanBahasa").val(data.KemampuanBahasa);
    $("#PerluPenerjemah").val(data.PerluPenerjemah);
    $("#BacadanTulis").val(data.BacadanTulis);
    $("#Kepercayaanlainya").val(data.Kepercayaanlainya);
    $("#KesediaanMenerimaEdukasi").val(data.KesediaanMenerimaEdukasi);
    $("#CaraEdukasi").val(data.CaraEdukasi);
    $("#KebutuhanEdukasi").val(data.KebutuhanEdukasi);
    $("#KebutuhanEdukasiIslami").val(data.KebutuhanEdukasiIslami);

}
function getDataPasienEdukasi() {
    var IdRegistrasi = document.getElementById("IdRegistrasi").value;
    // var iswalkin = $("#iswalkin").val();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/form/GetFormEdu';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IdRegistrasi=' + IdRegistrasi 
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
            $("#GruptarifKarcis").select2();
            $("#StatusKarcis").select2();
        })
}
function input (){
    //if not in creteria return false
    if ($("#TglJamEdukasi").val() == ''){
        toast ('Isi Tgl', "warning");
        return false;
    }
    if ($("#Materi_Edukasi_Berdasarkan_Kebutuhan").val() == ''){
        toast ('Isi Materi Edukasi', "warning");
        return false;
    } 
    if ($("#Kode_Leaflet").val() == ''){
        toast ('Isi Kode Leaflet', "warning");
        return false;
    }
    if ($("#Lama_Edukasi").val() == ''){
        toast ('Isi Lama Edukasi', "warning");
        return false;
    }if ($("#Hasil_Verifikasi").val() == ''){
        toast ('Isi Hasil Verifikasi', "warning");
        return false;
    }
     if ($("#Pemberi_Edukasi").val() == ''){
        toast ('Isi Pemberi Edukasi', "warning");
        return false;
    }
    if ($("#Pasien_keluarga_Hubungan").val() == ''){
        toast ('Isi Nama Pasien Atau Keluarga', "warning");
        return false;
    }
    if ($("#saksi_rumah_sakit").val() == ''){
        toast ('Isi TTD Pemberi Edukasi', "warning");
        return false;
    }
    if ($("#saksi_pasiens").val() == ''){
        toast ('Isi TTD ', "warning");
        return false;
    }
    goInput();
}

async function goInput() {
    try {
        const dataCreateData = await CreateDataPelaksanaE();
        updateUIdataCreateDataPelaksanaE(dataCreateData);
    } catch (err) {
        toast(err.message, "error")
    }
}

function updateUIdataCreateDataPelaksanaE(params) {
    let response = params;
    if (response.status == "success") {
        toast(response.message, "success")
    }else{
        toast(response.message, "error")
    }  
}

function CreateDataPelaksanaE() {
    var str = $("#formdata").serialize();
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/form/getpelaksanaan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: str
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

        })
}


// Primary function always
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

function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/aRegistrasiRajal/list";
}
//
// var form = document.getElementById('form1');
// var values = [];
// form.addEventListener('simpan', function(e) {
//     e.preventDefault();
//     var checkboxes = document.getElementsByname('KebutuhanEdukasiIslami');
//     for(var i=0 ; i < checkboxes.length; i++){
//         if(checkboxes[i].checked == true){
//             values.push(checkboxes[i].value);
//         }
//     }
//     alert('The vales(s):' + values.toString());
// });

// var expanded = [false, false, false];
// function showCheckboxes(i) {
//   checkboxes = checkboxes || document.getElementsByClassName("checkboxes");
//   if (!expanded[i]) {
//     checkboxes[i].style.display = "block";
//     expanded[i] = true;
//   } else {
//     checkboxes[i].style.display = "none";
//     expanded[i] = false;
//   }
// }   
//

// var expanded = false;
//     function showCheckboxes() {
//         var checkboxes = document.getElementById("checkboxes");
//         if (!expanded) {
//             checkboxes.style.display = "block";
//             expanded = true;
//         } else {
//             checkboxes.style.display = "none";
//             expanded = false;
//         }
//     }
