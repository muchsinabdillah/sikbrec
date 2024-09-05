$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    asyncShowResumeMedis();
});

async function asyncShowMain(){
    try{
        const datagetPasienByNoReg = await getPasienByNoReg();
        updateUIdatagetPasienByNoReg(datagetPasienByNoReg);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getPasienByNoReg() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/getDataPasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() 
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
function updateUIdatagetPasienByNoReg(datagetPasienByNoReg) {
    let datapasien = datagetPasienByNoReg;
    $("#emr_idvisit").val(datapasien.data.ID);
    $("#emr_namapasien").val(datapasien.data.PatientName);
    $("#emr_norm").val(datapasien.data.NoMR);
    $("#emr_tanggallahir").val(datapasien.data.Date_of_birth);
    $("#emr_nohp").val(datapasien.data.No_Phone);
    $("#emr_nik").val(datapasien.data.Nik);
    $("#emr_pekerjaan").val(datapasien.data.Pekerjaan);
    $("#emr_alamat").val(datapasien.data.Address);
    $("#emr_agama").val(datapasien.data.Religion);
    $("#emr_jeniskelamin").val(datapasien.data.Gander);
}

async function asyncShowResumeMedis(){
    try{
        const datagetResumeByNoreg = await getResumeByNoreg();
        updateUIdatagetResumeByNoreg(datagetResumeByNoreg);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getResumeByNoreg() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/getResumePasien';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'NoRegistrasi=' + $("#emr_noreg").val() 
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
function updateUIdatagetResumeByNoreg(datagetResumeByNoreg) {
    let dataresume = datagetResumeByNoreg;
    $("#emr_bedah").val(dataresume.data.Bedah);
    $("#emr_nonbedah").val(dataresume.data.Non_Bedah);
    $("#emr_nonbedahlainnya").val(dataresume.data.Non_Bedah_Lainnya);
    $("#emr_anamnesissingkat").val(dataresume.data.Anamnesis_Singkat);
    $("#emr_pemeriksaan").val(dataresume.data.Keadaan_Umum);
    $("#emr_tensi").val(dataresume.data.Tensi);
    $("#emr_suhu").val(dataresume.data.Suhu);
    $("#emr_nadi").val(dataresume.data.Nadi);
    $("#emr_nafas").val(dataresume.data.Nafas);
    $("#emr_bb").val(dataresume.data.BB);
    $("#emr_tb").val(dataresume.data.TB);
    $("#emr_laboratorium").val(dataresume.data.Laboratorium);
    $("#emr_radiologi").val(dataresume.data.Radiologi);
    $("#emr_pemeriksaanlainnya").val(dataresume.data.Pemeriksaan_Lainnya);
    $("#emr_tindakan").val(dataresume.data.Terapi);
    $("#emr_diagnosisakhir").val(dataresume.data.Diagnosis_Akhir);
    $("#emr_kategorikasus").val(dataresume.data.Kategori_Kasus);
    document.getElementById("emr_sembuh").checked = convertBitToBolean(dataresume.data.Sembuh);
    document.getElementById("emr_dipulangkan").checked = convertBitToBolean(dataresume.data.Dipulangkan);
    $("#emr_dipulangkanuntuk").val(dataresume.data.Alasan_Dipulangkan);
    $("#emr_dirurukke").val(dataresume.data.Dirujuk);
    $("#emr_atasdasar").val(dataresume.data.Atas_Dasar);
    $("#emr_alasandatang").val(dataresume.data.Alasan_Datang);
    
}


async function BtnSimpanData(){
    try{
        const dataSaveResume = await SaveResume();
        updateUIdataSaveResume(dataSaveResume);
    }catch{
        toast(err.message, "error")
    }
}
function SaveResume() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    var mr_pasien = $("#emr_norm").val();
    var form_resume= $("#resume_medis").serialize();
    var sembuh=convertBoleanToBit($("#emr_sembuh").is(":checked"));
    var pulang=convertBoleanToBit($("#emr_dipulangkan").is(":checked"));
    let url = base_url + '/SIKBREC/public/aEMR/setSaveResume';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'noreg_pasien=' +  noreg_pasien +
                '&mr_pasien=' + mr_pasien +

                '&sembuh=' + sembuh +
                '&pulang=' + pulang +
                '&form_resume=' + form_resume 
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
function updateUIdataSaveResume(dataSaveResume) {
    let dataResume = dataSaveResume;
    if (dataResume.status == "success") {
        swal("DATA RESUME",  "BERHASIL DISIMPAN", "success");
        asyncShowWakilPasien();
    }else{
        toast(response.message, "error")
    }
}


async function BtnPrintResumeMedis() {
    var base_url = window.location.origin;
    var NoRegistrasi = $("#emr_noreg").val();
    window.open(base_url + "/SIKBREC/public/aEMR/PrintResumeMedis/"+NoRegistrasi, "_blank",
    "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
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

function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
}

function convertBoleanToBit($data) {
    var convertboleanbit = $data ? 1 : 0;
    return convertboleanbit;
}

function convertBitToBolean($data) {
    // var convertbitbolean = $data ? true : false;
    // return convertbitbolean;
    var convertbitbolean = $data;
    if(convertbitbolean == "1"){
        convertbitbolean = true;
    }
    else{
        convertbitbolean = false;
    }
    return convertbitbolean;
}
