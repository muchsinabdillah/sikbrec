$(document).ready(function () {
    asyncShowMain();
    // format number to price
    //convertNumberToRp();
    // buton save ditekan
    const saveButton = document.querySelector('#btnreservasi');
    saveButton.addEventListener('click', async function () {
        try {
            const result = await saveTrs();
            if (result.status == "success") {
                toast(result.message, "success")
                setTimeout(function () { MyBack(); }, 1000);
            }
        } catch (err) {
            toast(err, "error")
        }
    })

    const saveButtonx = document.querySelector('#btnSave');
    saveButtonx.addEventListener('click', async function () {
        try {
            const result = await saveTarifAddLayanan();
            if (result.status == "success") {
                toast(result.message, "success")
                //setTimeout(function () { MyBack(); }, 1000);
                asyncShowMain();
            }

        } catch (err) {

            toast(err, "error")
        }
    })
    
});
async function asyncShowMain() {
    try {
        //await getHakAksesByForm(14);
        const datagetKodePDP = await getKodePDP(); 
        updateUIgetKodePDP(datagetKodePDP);
        const datagetKodeJasa = await getKodeJasa(); 
        updateUIgetKodeJasa(datagetKodeJasa);
        
        const datagetKodeTes = await getKodeTes(); 
        updateUIgetKodeTes(datagetKodeTes);


        const datagetDatabyID = await getDatabyID();
        updateUIdatagetDatabyID(datagetDatabyID);

        const datagetGrupPerawatan = await getGrupPerawatan(); 
        updateUIgetGrupPerawatan(datagetGrupPerawatan);
        getListDataOrderDetails();
        getListDataHistori();
    } catch (err) {
        toast(err, "error")
    }
}
function updateUIdatagetDatabyID(datagetDatabyID){
    let dataResponse = datagetDatabyID;

        $("#IdAuto").val(convertEntities(dataResponse.data.IDTes));
        $("#KodeTes").val(convertEntities(dataResponse.data.KodeTes));
        $("#KodeKelompok").val(convertEntities(dataResponse.data.KodeKelompok));
        $("#NamaTarif").val(convertEntities(dataResponse.data.NamaTes));
         $("#discontinue").val(convertEntities(dataResponse.data.Discontinue));
         $("#FlagPCR").val(convertEntities(dataResponse.data.pcr));
         $("#InLevel").val(convertEntities(dataResponse.data.InLevel));
         $("#IDGroup").val(convertEntities(dataResponse.data.IDGroup));
         
         $("#KodePDP").val(convertEntities(dataResponse.data.KD_PDP)).trigger('change');
         $("#KodeJasa").val(convertEntities(dataResponse.data.KD_JASA)).trigger('change');

         $("#KodeTes").select2();

        //  if ($("#IdAuto").val() != ''){
        //      $("#KodeTes").prop('disabled', 'disabled');
        //  }
         

}
function getDatabyID() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getTarifLabbyID/';
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

function saveTrs() {
    $(".preloader").fadeIn();
    $('#btnreservasi').html('Please Wait...');
    $('#btnreservasi').addClass('btn-danger');
    document.getElementById("btnreservasi").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/saveTrs_Lab/';
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

function getListDataOrderDetails() { 
    var base_url = window.location.origin;
    var IdAuto = $("#IdAuto").val();
    var kd_instalasi = $("#kd_instalasi").val();
    $('#datalayanan').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#datalayanan').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/MasterDataTarif/getListTarifRajal_Layanan", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.IdAuto = IdAuto
         d.kd_instalasi = kd_instalasi
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [
                            { "data": "id" },
                            { "data": "NamaUnit" },
                            {
                                "render": function (data, type, row) {
                                    var html = ""
                                    var html = '<button type="button" class="btn btn-danger btn-xs"  onclick="DeleteLayanan(' + row.id + ')" >Delete</button>'
                                    return html
                                },
                            },
                           ],
     });
} 

function getListDataHistori() { 
    var base_url = window.location.origin;
    var IdAuto = $("#IdAuto").val();
    var kd_instalasi = $("#kd_instalasi").val();
    $('#datahistori').dataTable({
        "bDestroy": true
    }).fnDestroy();
       $('#datahistori').DataTable({
         'ajax':
    {
        "url": base_url + "/SIKBREC/public/MasterDataTarif/getListTarifRajal_Histori", // URL file untuk proses select datanya
        "type": "POST",
        data: function (d) {
         d.IdAuto = IdAuto
         d.kd_instalasi = kd_instalasi
     },
         "dataSrc": "",
    "deferRender": true,
    }, 
    "columns": [

                            { "data": "ID_TR_TARIF" },
                            { "data": "tglentry" },
                            { "data": "tglberlaku" },
                            { "data": "tglexpired" },
                            { "data": "GROUP_TARIF" },
                            { "data": "NILAI" },
                            { "data": "KLSID" },
                            { "data": "GROUP_TARIF_2" },
                            { "data": "ID_TR_TARIF_PAKET" },
                           ],
     });
} 

function updateUIgetKodePDP(datagetKodePDP) {
    let data = datagetKodePDP;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodePDP").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].KD_PDP + '">' + data[i].NM_PDP + '</option';
            $("#KodePDP").append(newRow);
        }
    }
}
function getKodePDP() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getKodePDP';
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

function updateUIgetKodeJasa(datagetKodeJasa) {
    let data = datagetKodeJasa;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeJasa").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].KD_JASA + '">' + data[i].NM_JASA + '</option';
            $("#KodeJasa").append(newRow);
        }
    }
}
function getKodeJasa() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getKodeJasa';
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
            $("#KodeJasa").select2();
        })
}

function updateUIgetGrupPerawatan(datagetGrupPerawatan) {
    let data = datagetGrupPerawatan;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#GrupPerawatan").append(newRow);
        for (i = 0; i < data.data.length; i++) {
            var newRow = '<option value="' + data.data[i].ID + '">' + data.data[i].NamaUnit + '</option';
            $("#GrupPerawatan").append(newRow);
        }
    }
}
function getGrupPerawatan() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataDokter/getGrupPerawatan';
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
            $("#GrupPerawatan").select2();
        })
}

async function saveTarifAddLayanan() {

    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/addTarifLayanan';

    // data form
    //var form_data = $("#form_cuti").serialize();
    var id_tarif = $("#IdAuto").val();
    var id_layanan = $("#GrupPerawatan").val();
    var kd_instalasi = $("#kd_instalasi").val();
    //console.log('sss');return false;
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'IdAuto=' + id_tarif + '&GrupPerawatan=' + id_layanan + '&kd_instalasi=' + kd_instalasi
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

async function DeleteLayanan(idTarif_2){
    let DataId = idTarif_2;
    await GoDelete(DataId);
    await getListDataOrderDetails();
}

function GoDelete(DataId){
    $(".preloader").fadeIn();
    $('#btnSave').html('Please Wait...');
    $('#btnSave').addClass('btn-danger');
    document.getElementById("btnSave").disabled = true;
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/deleteTarifLayanan';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        }, 
        body: 'id=' + DataId
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
            toast('Item Berhasil Dihapus', "success")
        })
}

function updateUIgetKodeTes(param) {
    let data = param;
    if (data !== null && data !== undefined) {
        //console.log(data);
        var newRow = '<option value="">-- PILIH --</option';
        $("#KodeTes").append(newRow);
        for (i = 0; i < data.length; i++) {
            var newRow = '<option value="' + data[i].KodeTes + '">'+ data[i].KodeTes + ' - ' + data[i].NamaTes + '</option';
            $("#KodeTes").append(newRow);
        }
    }
}
function getKodeTes() {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getKodeTes';
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
            //$("#KodeTes").select2();
        })
}

async function getNamaTes(param) {
    try {
        const datagetKodeTesbyID = await getKodeTesbyID(param); 
        updateUIgetKodeTesbyID(datagetKodeTesbyID);
    } catch (err) {
        toast(err, "error")
    }
}

function updateUIgetKodeTesbyID(param) {
    let dataResponse = param;
    console.log(dataResponse);
            $("#KodeTes").val(convertEntities(dataResponse.data.KodeTes));
            $("#KodeKelompok").val(convertEntities(dataResponse.data.KodeKelompok));
            $("#NamaTarif").val(convertEntities(dataResponse.data.NamaTes));
}
function getKodeTesbyID(param) {
    var base_url = window.location.origin;
    let url = base_url + '/SIKBREC/public/MasterDataTarif/getKodeTesbyID';
    return fetch(url, {
        method: 'POST',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'id=' + param
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
    window.location = base_url + "/SIKBREC/public/MasterDataTarif/listlab";
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