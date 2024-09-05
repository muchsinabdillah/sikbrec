$(document).ready(function () {
    convertNumberToRp();
    asyncShowMain();
    // buton save ditekan
    const saveButton = document.querySelector('#btnSave');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveMasterDokter();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            } 
        } catch (err) { 
            toast(err, "error")
        }
    })
    $('#ClassID').on('select2:select', function (e) {
        var data = e.params.data; 
        $("#ClassName").val(data.text);
    });
});
async function saveMasterDokter() {
    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataRoom/addRoom';
    // data form
    var RoomName = document.getElementById("RoomName").value;
    var IdAuto = document.getElementById("IdAuto").value;
    var ClassID = document.getElementById("ClassID").value;
    var ClassName = document.getElementById("ClassName").value;
    var LantaiID = document.getElementById("LantaiID").value;
    var UnitID = document.getElementById("UnitID").value;
    var JumlahBed = price_to_number(document.getElementById("JumlahBed").value);
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&RoomName=" + RoomName + "&ClassID=" + ClassID
            + "&ClassID=" + ClassID + "&ClassName=" + ClassName
            + "&JumlahBed=" + JumlahBed 
            + "&LantaiID=" + LantaiID
            + "&UnitID=" + UnitID
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
            $('#btnSave').html('Submit');
            document.getElementById("btnSave").disabled = false;
        })

}
async function asyncShowMain() {
    try {
        await getHakAksesByForm(20);
        const datagetClass = await getClass();
        const datagetUnit = await getUnit();
        const datagetDataBedbyId = await getDataBedbyId(); 
        updateUIdatagetClass(datagetClass); 
        updateUIDataUnit(datagetUnit);
        updateUIdatagetDataBedbyId(datagetDataBedbyId); 
        $(".preloader").fadeOut();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDataBedbyId(datagetDataBedbyId) {
    let apiResponse = datagetDataBedbyId;
    $("#RoomName").val(convertEntities(apiResponse.data.ROOM));
    $("#ClassName").val(convertEntities(apiResponse.data.CLASS));
    $("#JumlahBed").val(convertEntities(apiResponse.data.BED));
    $("#ClassID").val(convertEntities(apiResponse.data.CLASS_ID)).trigger('change');
    $("#LantaiID").val(convertEntities(apiResponse.data.LANTAI)).trigger('change');
    $("#UnitID").val(convertEntities(apiResponse.data.UNIT)).trigger('change');
    console.log("BRIDGE_BPJS",apiResponse.data.BRIDGE_BPJS);
    if (apiResponse.data.BRIDGE_BPJS == "1"){
        document.getElementById("RoomName").readOnly = true;
        document.getElementById("ClassName").readOnly = true;
        document.getElementById("JumlahBed").readOnly = true;
        document.getElementById("ClassID").disabled = true;
    } else {  
        document.getElementById("RoomName").readOnly = false;
        document.getElementById("ClassName").readOnly = false;
        document.getElementById("JumlahBed").readOnly = false;
        document.getElementById("ClassID").disabled = false;
    }
}
function getDataBedbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataRoom/getRoomId/';
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
            $("#IncludeBOR").select2();
            $("#Discontinue").select2();
            $("#Publish").select2();
            $("#LantaiID").select2();
            $("#UnitID").select2();
        })
} 
function getUnit() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataUnit/GetLayananAll';
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
            $("#UnitID").select2();
        })
}

function updateUIDataUnit(data) {
    let responseApi = data;
    if (responseApi.data !== null && responseApi.data !== undefined) {
        console.log(responseApi.data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#UnitID").append(newRow);
        for (i = 0; i < responseApi.data.length; i++) {
            var newRow = '<option value="' + responseApi.data[i].ID + '">' + responseApi.data[i].NamaUnit + '</option';
            $("#UnitID").append(newRow);
        }
    }
}

function updateUIdatagetClass(datagetClass) {
    let data = datagetClass;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#ClassID").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].IDKelas + '">' + data.data[i].NamaKelas + '</option';
            $("#ClassID").append(newRow);
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
            $("#ClassID").select2();
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
    window.location = base_url + "/SIKBREC/public/MasterDataRoom";
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
    var JumlahBed = document.getElementById("JumlahBed");
    JumlahBed.addEventListener("keyup", function (e) {
        JumlahBed.value = formatRupiah(this.value);
    });

}