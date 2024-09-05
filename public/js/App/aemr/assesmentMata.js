$(document).ready(function () {
    $(".preloader").fadeOut();
    asyncShowMain();
    // asyncShowSuratKeteranganSakit();
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
    $("#emr_namapasien").val(datapasien.data.PatientName);
    $("#emr_norm").val(datapasien.data.NoMR);
    $("#emr_tanggallahir").val(datapasien.data.Date_of_birth);

}

async function asyncShowSuratKeteranganSakit(){
    try{
        const datagetSuketByNoreg = await getSuketByNoreg();
        updateUIdatagetSuketByNoreg(datagetSuketByNoreg);
    } catch (err) {
        toast(err.message, "error")
    }
}

function getSuketByNoreg() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/aEMR/getSuratKeteranganSakit';
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
function updateUIdatagetSuketByNoreg(datagetSuketByNoreg) {
    let datasuket = datagetSuketByNoreg;
    $("#emer_tglistirahat").val(datasuket.data.Tanggal_Istirahat);
    $("#emr_diagnosa").val(datasuket.data.Diagnosa);
    $("#emr_kontrolulang").val(datasuket.data.Tanggal_Kontrol);
    $("#emr_tanggalsaatini").val(datasuket.data.Tanggal_Sekarang);
    $("#emr_dokter").val(datasuket.data.Dokter);
}

async function BtnSimpanData(){
    try{
        const dataSaveSuket = await SaveSuket();
        updateUIdataSaveSuket(dataSaveSuket);
    }catch{
        toast(err.message, "error")
    }
}
function SaveSuket() {
    var base_url = window.location.origin;
    var noreg_pasien = $("#emr_noreg").val();
    var mr_pasien = $("#emr_norm").val();
    var form_suket= $("#suratketerangansakit").serialize();
    let url = base_url + '/SIKBREC/public/aEMR/setSaveSuket';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body:   'noreg_pasien=' +  noreg_pasien +
                '&mr_pasien=' + mr_pasien +
                '&form_suket=' + form_suket 
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
function updateUIdataSaveSuket(dataSaveSuket) {
    let dataSuket = dataSaveSuket;
    if (dataSuket.status == "success") {
        swal("DATA SURAT KETERANGAN SAKIT",  "BERHASIL DISIMPAN", "success");
        asyncShowWakilPasien();
    }else{
        toast(response.message, "error")
    }
}

async function BtnPrintSuratKeteranganSakit1() {
    var base_url = window.location.origin;
    var jeniscetak = 'PrintSuratKeteranganSakit';
    var noreg = $("#emr_noreg").val();
    window.open(base_url + "/SIKBREC/public/aEMR/"+jeniscetak+"/"+noreg, "_blank",
            "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=800,height=800");
    // printrincian(base_urlx);
}

async function BtnPrintSuratKeteranganSakit() {
    var base_url = window.location.origin;
    var NoRegistrasi = $("#emr_noreg").val();
    window.open(base_url + "/SIKBREC/public/aEMR/PrintSuratKeteranganSakit/"+NoRegistrasi, "_blank",
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
