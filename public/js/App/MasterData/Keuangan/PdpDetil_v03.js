$(document).ready(function () {
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await savePdpDetil();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
    asyncShowMain();
});
function savePdpDetil(){
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/PdpDetil/addPdpDetil';
    var form_data = $("#form_cuti").serialize();
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: form_data
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
            $('#btnreservasi').removeClass('btn-danger');
            $('#btnreservasi').html('Submit');
            document.getElementById("btnreservasi").disabled = false;
        })
}
async function asyncShowMain(){
    try {
        const dataGetRekeningPendapatan =  await getRekeningPendapatan();
        const datagetRekeningDiskon = await getRekeningDiskon();
        const datagetPdpAktif = await getPdpAktif();
        const dataDetilPdp =  await getDataDetilPdp();
        updateUIRekeningPendapatan(dataGetRekeningPendapatan);
        updateUIRekeningDiskon(datagetRekeningDiskon);
        updateUIPdpAktif(datagetPdpAktif);
        updateUIdataDetilPdp(dataDetilPdp);
        console.log(dataDetilPdp);
    }catch(err){

    }
}
function updateUIdataDetilPdp(dataDetilPdp) {
    let data = dataDetilPdp;
    $("#IdAuto").val(convertEntities(data.data.ID));
    $('#KodePdp').val(data.data.KD_PDP).trigger('change');
    $("#KodeTipePdp").val(convertEntities(data.data.KD_TIPE_PDP));
    $("#NilaiProsenPdp").val(convertEntities(data.data.NILAI_PROSEN));
    $("#NilaiFixPdp").val(convertEntities(data.data.NILAI_FIX));
    $('#KodeRekeningPendapatan').val(data.data.KD_POSTING).trigger('change');
    $('#KodeRekeningDiskon').val(data.data.KD_POSTING_DISC).trigger('change');
}
function getDataDetilPdp() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/PdpDetil/getPdpDetilId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + $("#IdAuto").val()
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
function updateUIPdpAktif(datagetPdpAktif) {
    let data = datagetPdpAktif;
    if (data !== null && data !== undefined) {
       console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodePdp").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].KD_PDP + '">' + data[i].NM_PDP + '</option';
            $("#KodePdp").append(newRow);
        }
    }
}
function getPdpAktif() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Pdp/getAllPdp';
    return fetch(url, {
        method: 'GET',
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
            $("#KodePdp").select2();
        })
}
function updateUIRekeningDiskon(datagetRekeningDiskon) {
    let data = datagetRekeningDiskon;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeRekeningDiskon").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].FS_KD_REKENING + '">' + data.data[i].FS_NM_REKENING + '</option';
            $("#KodeRekeningDiskon").append(newRow);
        }
    }
}
function getRekeningDiskon() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rekening/getRekeningAllAktif';
    return fetch(url, {
        method: 'GET',
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
            $("#KodeRekeningDiskon").select2();
        })
}
function updateUIRekeningPendapatan(dataGetRekeningPendapatan) {
    let data = dataGetRekeningPendapatan;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeRekeningPendapatan").append(newRow); 
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].FS_KD_REKENING + '">' + data.data[i].FS_NM_REKENING + '</option';
            $("#KodeRekeningPendapatan").append(newRow);
        }
    }
}
function getRekeningPendapatan(){
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/Rekening/getRekeningPendapatan';
    return fetch(url,{
        method: 'GET',
        headers:{
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
            $("#KodeRekeningPendapatan").select2();
        })
}
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/PdpDetil";
}

function convertEntities($data) {
    $xonvert = $('<textarea />').html($data).text();
    return $xonvert;
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