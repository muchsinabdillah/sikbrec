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
    
});
async function showdetilroom() {
    var IdAuto = document.getElementById("IdAuto").value;
    if (IdAuto ==""){
        const datagetDataRoombyId = await getDataRoombyId();
        console.log("datagetDataRoombyId", datagetDataRoombyId)
        updateUIdatagetDataRoombyId(datagetDataRoombyId);
    } 
}
function updateUIdatagetDataRoombyId(datagetDataBedbyId) {
    let apiResponse = datagetDataBedbyId;
    $("#RoomName").val(convertEntities(apiResponse.data.ROOM));  
    $("#ClassID").val(convertEntities(apiResponse.data.CLASS_ID)).trigger('change');
    $("#KodeBPJS").val(convertEntities(apiResponse.data.IDkelasBPJS)).trigger('change');
}
function getDataRoombyId() {
    var KodeLokasi = document.getElementById("KodeLokasi").value;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataRoom/getRoomId/';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + KodeLokasi
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
async function saveMasterDokter() {

    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBed/addBed';

    // data form
    var Tarif = price_to_number(document.getElementById("Tarif").value); 

    var IdAuto = document.getElementById("IdAuto").value;
    var KodeLokasi = document.getElementById("KodeLokasi").value;
    var ClassID = document.getElementById("ClassID").value; 
    var Ward = document.getElementById("Ward").value;
    var RoomName = document.getElementById("RoomName").value;
    var BedName = document.getElementById("BedName").value;
    var IncludeBOR = document.getElementById("IncludeBOR").value;
    var Discontinue = document.getElementById("Discontinue").value;
    var KodeBPJS = document.getElementById("KodeBPJS").value;
    var Publish = document.getElementById("Publish").value;
    var KodePDP = document.getElementById("KodePDP").value;
    var Keterangan = document.getElementById("Keterangan").value;
    var KodeBPJS = document.getElementById("KodeBPJS").value;

    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "IdAuto=" + IdAuto
            + "&Tarif=" + Tarif + "&KodeLokasi=" + KodeLokasi
            + "&ClassID=" + ClassID + "&Ward=" + Ward
            + "&RoomName=" + RoomName + "&BedName=" + BedName
            + "&IncludeBOR=" + IncludeBOR + "&Discontinue=" + Discontinue
            + "&KodeBPJS=" + KodeBPJS + "&Publish=" + Publish
            + "&KodePDP=" + KodePDP
            + "&Keterangan=" + Keterangan + "&KodeBPJS=" + KodeBPJS
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
        await getHakAksesByForm(21);
        const datagetClass = await getClass();
        const datagetRoom = await getRoom();
        const datagetJenisRawat = await getJenisRawat();
        const datagetKDPDP = await getKDPDP();
        const datagetDataBedbyId = await getDataBedbyId();
        console.log(datagetDataBedbyId);
        updateUIdatagetClass(datagetClass);
        updateUIdatagetRoom(datagetRoom);
        updateUIdatagetJenisRawat(datagetJenisRawat);
        updateUIdatagetKDPDP(datagetKDPDP);
        updateUIdatagetDataBedbyId(datagetDataBedbyId);
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetJenisRawat(datagetClass) {
    let data = datagetClass;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#Ward").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].JenisRuangRawat + '">' + data.data[i].JenisRuangRawat + '</option';
            $("#Ward").append(newRow);
        }
    }
}
function getJenisRawat() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBed/getJenisRawat';
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
            $("#Ward").select2();
        })
}
function updateUIdatagetRoom(datagetClass) {
    let data = datagetClass;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeLokasi").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ROOM_ID + '">' + data.data[i].ROOM + ' - ' + data.data[i].CLASS + '</option';
            $("#KodeLokasi").append(newRow);
        }
    }
}
function getRoom() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBed/getRoom';
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
            $("#KodeLokasi").select2();
        })
}
function updateUIdatagetDataBedbyId(datagetDataBedbyId) {
    let apiResponse = datagetDataBedbyId;
    $("#IdAuto").val(convertEntities(apiResponse.data.RoomID));
    $("#KodeLokasi").val(convertEntities(apiResponse.data.KodeLokasi));
    $("#Ward").val(convertEntities(apiResponse.data.Ward));
    $("#RoomName").val(convertEntities(apiResponse.data.Room));
    $("#BedName").val(convertEntities(apiResponse.data.Bad));
    $("#Tarif").val(convertEntities(price_to_number(apiResponse.data.TarifKamar)));
    $("#ClassID").val(convertEntities(apiResponse.data.KLSID));  
    $("#KodeBPJS").val(convertEntities(apiResponse.data.KdKlsBPJS));
    $("#Keterangan").val(convertEntities(apiResponse.data.Keterangan)); 
    $("#KodePDP").val(convertEntities(apiResponse.data.KD_PDP));
    $("#IncludeBOR").val(convertEntities(apiResponse.data.excludeBOR)).trigger('change');
    $("#Discontinue").val(convertEntities(apiResponse.data.Dsicontinue)).trigger('change');
    $("#Publish").val(convertEntities(apiResponse.data.Publish)).trigger('change');
    if (apiResponse.data.RoomID  != null ) {  
        document.getElementById("ClassID").disabled = true;
        //document.getElementById("KodeLokasi").disabled = true;
        document.getElementById("KodeBPJS").disabled = true;
    } else {
        document.getElementById("ClassID").disabled = false;
        //document.getElementById("KodeLokasi").disabled = false;
        document.getElementById("KodeBPJS").disabled = false;
    }
    $(".preloader").fadeOut();
}
function getDataBedbyId() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataBed/getBedId/';
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
        })
}
function updateUIdatagetKDPDP(datagetKDPDP) {
    let data = datagetKDPDP;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodePDP").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].KD_PDP + '">' + data.data[i].KD_PDP + ' - ' + data.data[i].NM_PDP + '</option';
            $("#KodePDP").append(newRow);
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
function getKDPDP() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/PdpDetil/getAllPdpDetilCombo';
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
            $("#KodePDP").select2();
        })
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
    window.location = base_url + "/SIKBREC/public/MasterDataBed";
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
    var Tarif = document.getElementById("Tarif");
    Tarif.addEventListener("keyup", function (e) {
        Tarif.value = formatRupiah(this.value);
    });
     
}