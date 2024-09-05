$(document).ready(function () {
    asyncShowMain();
    const saveButtonx = document.querySelector('#btnSave');
    saveButtonx.addEventListener('click', async function () {
        try {
            const result = await saveSupplier();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }

        } catch (err) {
            toast(err, "error")
        }
    })

});
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/MasterSupplier/list";
}
 function saveSupplier() {

    $(".preloader").fadeIn(); 
    var base_url = window.location.origin;

    // data form
    var IdAuto = document.getElementById("IdAuto").value;
    var Nama = document.getElementById("Nama").value;
    var NamaCPAwal = document.getElementById("NamaCPAwal").value;
    var NamaCPAkhir = document.getElementById("NamaCPAkhir").value;
    var Email = document.getElementById("Email").value;
    var IdPabrik = document.getElementById("IdPabrik").value;
    var TlpnKantor = document.getElementById("TlpnKantor").value;
    var NoHP = document.getElementById("NoHP").value;
    var FaxTlp = document.getElementById("FaxTlp").value;
    var Kota = document.getElementById("Kota").value;
    var Status = document.getElementById("Status").value;
    var Provinsi = document.getElementById("Provinsi").value;
    var Alamat = document.getElementById("Alamat").value;
    var KodePos = document.getElementById("KodePos").value;
    var LeadTime = document.getElementById("LeadTime").value;
    var JatuhTempo = document.getElementById("JatuhTempo").value;
    var NamaBank = document.getElementById("NamaBank").value;
    var NoRekening = document.getElementById("NoRekening").value;
    var url = '';
    if (IdAuto == "") {
        url = base_url + '/SIKBREC/public/MasterSupplier/addSupplier';

    } else {
        url = base_url + '/SIKBREC/public/MasterSupplier/editSupplier';
    }
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&Nama=" + Nama
            + "&NamaCPAwal=" + NamaCPAwal
            + "&NamaCPAkhir=" + NamaCPAkhir
            + "&Email=" + Email
            + "&IdPabrik=" + IdPabrik
            + "&TlpnKantor=" + TlpnKantor
            + "&NoHP=" + NoHP
            + "&FaxTlp=" + FaxTlp
            + "&Kota=" + Kota
            + "&Status=" + Status
            + "&Provinsi=" + Provinsi
            + "&Alamat=" + Alamat
            + "&KodePos=" + KodePos
            + "&NoRekening=" + NoRekening
            + "&LeadTime=" + LeadTime
            + "&NamaBank=" + NamaBank
            + "&JatuhTempo=" + JatuhTempo
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
async function asyncShowMain() {
    try {
        $("#Status").select2(); 
        const datagetPabrik = await getPabrik();
        updateUIdatagetPabrik(datagetPabrik); 
        var id = $("#IdAuto").val();
        if (id != "") {
            const dataGetSupplierbyId = await GetSupplierbyId();
            updateUIdataGetSupplierbyID(dataGetSupplierbyId);
        }


        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdataGetSupplierbyID(dataResponse) {
    $("#Nama").val(dataResponse.data[0].Company);
    $("#NamaCPAwal").val(dataResponse.data[0].FirstName);
    $("#NamaCPAkhir").val(dataResponse.data[0].LastName);
    $("#Email").val(dataResponse.data[0].Email); 
    $("#TlpnKantor").val(dataResponse.data[0].HomePhone);
    $("#NoHP").val(dataResponse.data[0].MobilePhone);
    $("#FaxTlp").val(dataResponse.data[0].FaxNumber);
    $("#Kota").val(dataResponse.data[0].City); 
    $('#Status').val(dataResponse.data[0].lock).trigger('change');
    $('#IdPabrik').val(dataResponse.data[0].IdPabrikan).trigger('change');
    $("#Provinsi").val(dataResponse.data[0].Province);
    $("#Alamat").val(dataResponse.data[0].Address);
    $("#KodePos").val(dataResponse.data[0].PostalCode); 
    $("#LeadTime").val(dataResponse.data[0].LeadTime_Days); 
    $("#JatuhTempo").val(dataResponse.data[0].LamaJatuhTempo_Days); 
    $("#NamaBank").val(dataResponse.data[0].NamaBank); 
    $("#NoRekening").val(dataResponse.data[0].NoRekening); 
}
function GetSupplierbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterSupplier/getSupplierbyId/';
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

function updateUIdatagetPabrik(params) {
    let responseApi = params;
    if (responseApi !== null && responseApi !== undefined) {
        console.log(responseApi);
        $("#IdPabrik").empty();
        var newRow = '<option value="">-- PILIH --</option';
        $("#IdPabrik").append(newRow);
        for (i = 0; i < responseApi.length; i++) {
            var newRow = '<option value="' + responseApi[i].ID + '">' + responseApi[i].Nama + '</option';
            $("#IdPabrik").append(newRow);
        }
    }
}
function getPabrik() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataPabrik/showPabrikAll';
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
            $("#IdPabrik").select2();
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