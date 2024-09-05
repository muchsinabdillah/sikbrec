$(document).ready(function () {   
    // $(".preloader").fadeOut(); 

    onLoadFunctionAll();
    // onLoadFunctionAlll();
    const saveButton = document.querySelector('#btnSave');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await Simpanx();
            if (result.status == "success") {
                toast(result.message, "success")
                // setTimeout(function () { MyBack(); }, 1000);
            }

        } catch (err) {

            toast(err, "error")
        }
    });

    $('#Medical_Provinsi').change(function () {
        //Some code
        $("#Medrec_kabupaten").empty();
        var newRow = '<option value="">-- Pilih Kabupaten --</option';
        $("#Medrec_kabupaten").append(newRow);
     $("#Medrec_kabupaten").select2();
 
        $("#Medrec_Kecamatan").empty();
        var newRow = '<option value="">-- Pilih Kecamatan --</option';
        $("#Medrec_Kecamatan").append(newRow);
    //  $("#Medrec_Kecamatan").select2();
  
        $("#Medrec_Kelurahan").empty();
        var newRow = '<option value="">-- Pilih Kelurahan --</option';
        $("#Medrec_Kelurahan").append(newRow);
        // $("#Medrec_Kelurahan").select2();
        var id = $("#id_Order").val();
        //console.log("datamr",Medrec_NoMR)
         if (id == ""){ 
            showGetKabupaten();
        }else{
            var xdi = document.getElementById("Medical_Provinsi").value;
            showGetKabupaten(xdi);
        }
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

async function onLoadFunctionAll(xTempMr) {
    try{
        $(".preloader").fadeIn();
        if (xTempMr != "") {

        const dataGetDataRumahSakit = await GetDataRumahSakit(xTempMr);
        updateUIdataGetDataRumahSakit(dataGetDataRumahSakit);
        // $(".preloader").fadeOut();
    }else{
        $("#Medrec_kabupaten").select2();
        $('#Medrec_Kecamatan').select2();
        $('#Medrec_Kelurahan').select2();
    }
        const datagetProvinsi =  await getProvinsi();
        updateUIgetProvinsi(datagetProvinsi);
    } catch (err) {
        toast(err, "error")
    }
}
// async function onLoadFunctionAlll() {
//     try{
//         const datagetProvinsi =  await getProvinsi();
//         updateUIgetProvinsi(datagetProvinsi);
//         $(".preloader").fadeOut();
//     } catch (err) {
//         toast(err, "error")
//     }
// }
function GetDataRumahSakit(xTempMr) {

    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/dataRumahSakit/GetDataRumahSakit';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "q=" + xTempMr +'&id=' + $("#id_Order").val()
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
async function updateUIdataGetDataRumahSakit(dataGetDataRumahSakit) {
    let dataResponse = dataGetDataRumahSakit;
    $("#Name").val(dataResponse.data.NamaRS);
    $("#Kode").val(dataResponse.data.KodeRS);
    $("#alamat").val(dataResponse.data.alamat);
    $("#RT").val(dataResponse.data.RT);
    $("#RW").val(dataResponse.data.RW);
    $("#kd_Provinsi").val(dataResponse.data.ProvinsiCode);
    $("#Medical_Provinsi").val(dataResponse.data.Medical_Provinsi).trigger('change');
    $('#Medrec_Kecamatan').val(dataResponse.data.Medrec_Kecamatan)//.trigger('change');
    $('#Medrec_kabupaten').val(dataResponse.data.Medrec_kabupaten)//.trigger('change');
    $('#Medrec_Kelurahan').val(dataResponse.data.Medrec_Kelurahan)//.trigger('change');
    console.log(dataResponse.data.Medical_Provinsi);

    $("#kd_Kota").val(dataResponse.data.KotaCode);
    // $("#Kota").val(dataResponse.data.KotaName);
    $("#kd_Kecamatan").val(dataResponse.data.KecamtanCode);
    // $("#Kecamatan").val(dataResponse.data.KecamatanName);
    $("#kd_Kelurahan").val(dataResponse.data.KelurahanCode);
    // $("#Kelurahan").val(dataResponse.data.KelurahanName);
    $("#Kd_Pos").val(dataResponse.data.Kd_Pos);
    $("#Longitude").val(dataResponse.data.Longitude);
    $("#Latitude").val(dataResponse.data.Latitude);
    // $('#Medical_Provinsi').val(dataResponse.ProvinsiName).trigger('change');

    await showGetKabupaten(dataResponse.data.Medical_Provinsi);
    await showGetKecamatan(dataResponse.data.Medrec_kabupaten);
    await showGetKelurahan(dataResponse.data.Medrec_Kecamatan);


    $("#Medrec_kabupaten").select2();
    $('#Medrec_Kecamatan').select2();
    $('#Medrec_Kelurahan').select2();
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
    let url = base_url + '/SIKBREC/public/dataRumahSakit/GetKabupaten';
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
    let url = base_url + '/SIKBREC/public/dataRumahSakit/GetKecamatan';
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
    let url = base_url + '/SIKBREC/public/dataRumahSakit/GetKodepos';
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
    let url = base_url + '/SIKBREC/public/dataRumahSakit/GetKelurahan';
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
function getProvinsi() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/dataRumahSakit/getProvinsi';
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
            var newRow = '<option value="' + responseApi.data[i].PovinsiID + '">' + responseApi.data[i].ProvinsiNama + '</option';
            $("#Medical_Provinsi").append(newRow);
            
        }
    }
}
async function Simpanx() {

    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/dataRumahSakit/updateDataRS';

    // data form
    var form_data = $("#form_dataRS").serialize();
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
            $('#btnSave').removeClass('btn-danger');
            // $('#btnSave').html('Submit');
            document.getElementById("btnSave").disabled = false;
        })

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