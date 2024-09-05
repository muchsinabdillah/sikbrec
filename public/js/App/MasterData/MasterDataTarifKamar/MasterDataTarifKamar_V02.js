$(document).ready(function () { 
    asyncShowMain();
    // format number to price
    convertNumberToRp();
    // buton save ditekan
    const saveButton = document.querySelector('#btnSave');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveMasterTarifRoom();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })
});
async function saveMasterTarifRoom() {
    $(".preloader").fadeIn(); 
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/TarifKamar/addTarifRoom';
    // data form 
    var IdAuto = document.getElementById("IdAuto").value;
    var TRFKMR_ClassID = document.getElementById("TRFKMR_ClassID").value;
    var TRFKMR_GroupTarif = document.getElementById("TRFKMR_GroupTarif").value;
    var TRFKMR_Nilai = price_to_number(document.getElementById("TRFKMR_Nilai").value);
    var TRFKMR_TglBerlaku = document.getElementById("TRFKMR_TglBerlaku").value;
    var TRFKMR_TglExpired = document.getElementById("TRFKMR_TglExpired").value; 
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&TRFKMR_ClassID=" + TRFKMR_ClassID + "&TRFKMR_GroupTarif=" + TRFKMR_GroupTarif
            + "&TRFKMR_Nilai=" + TRFKMR_Nilai + "&TRFKMR_TglBerlaku=" + TRFKMR_TglBerlaku
            + "&TRFKMR_TglExpired=" + TRFKMR_TglExpired 
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
        await getHakAksesByForm(23);
        const datagetClass = await getClass(); 
        const datagetDatatarifBeddbyId = await getDataTarifBedbyId();
        updateUIdatagetClass(datagetClass); 
        updateUIdatagetDatatarifBedbyId(datagetDatatarifBeddbyId);
        console.log(datagetClass)
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDatatarifBedbyId(datagetDatatarifBeddbyId) {
    let apiResponse = datagetDatatarifBeddbyId;
    $("#TRFKMR_Nilai").val(convertEntities(number_to_price(apiResponse.data.TarifKamar)));
    $("#TRFKMR_TglBerlaku").val(convertEntities(apiResponse.data.Tanggal_Berlaku));
    $("#TRFKMR_TglExpired").val(convertEntities(apiResponse.data.Tanggal_Expired));
    $("#TRFKMR_GroupTarif").val(convertEntities(apiResponse.data.Group_Tarif)).trigger('change');
    $("#TRFKMR_ClassID").val(convertEntities(apiResponse.data.KLSID)).trigger('change');
    console.log("apiResponse.data.ID", apiResponse.data.ID )
    if (apiResponse.data.ID != null) {
        document.getElementById("TRFKMR_GroupTarif").disabled = true;
        document.getElementById("TRFKMR_ClassID").disabled = true;
        document.getElementById("TRFKMR_TglBerlaku").disabled = true;
    } else {
        document.getElementById("TRFKMR_GroupTarif").disabled = false;
        document.getElementById("TRFKMR_ClassID").disabled = false;
        document.getElementById("TRFKMR_TglBerlaku").disabled = false;
    }
}
function getDataTarifBedbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/TarifKamar/getTarifRoomId/';
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
             
        })
}
function updateUIdatagetClass(datagetClass) {
    let data = datagetClass;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#TRFKMR_ClassID").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].IDKelas + '">' + data.data[i].NamaKelas + '</option';
            $("#TRFKMR_ClassID").append(newRow);
        }
    }
}
function getClass() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBed/getClass';
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
            $("#TRFKMR_ClassID").select2();
            $("#TRFKMR_GroupTarif").select2();
        })
}

///harus ada
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
function MyBack() {
    const base_url = window.location.origin;
    window.location = base_url + "/SIKBREC/public/TarifKamar";
}
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : ",00";
}
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}
function convertNumberToRp() {
    var TRFKMR_Nilai = document.getElementById("TRFKMR_Nilai");
    TRFKMR_Nilai.addEventListener("keyup", function (e) {
        TRFKMR_Nilai.value = formatRupiah(this.value);
    });

} 